<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Issuer;
use App\Models\Operation;
use App\Models\SupportingAttachment;
use App\Models\Document;
use App\Models\CommercialReference;
use App\Models\Company;
use App\Http\Requests\OperationEditRequest;
use App\Exports\OperationExport;
use App\Models\OperationProgressStatusFile;
use App\Models\IssuerBank;
use App\Models\OperationsLogs;
use App\Models\OperationsAdminStaffFile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OperationDocumentApproved as NotificationsOperationDocumentApproved;
use App\Notifications\OperationDocumentRejected as NotificationsOperationDocumentRejected;
use Illuminate\Support\Facades\Crypt;
use App\Imports\OperationsImports;
use Maatwebsite\Excel\Facades\Excel;
use Image;
use Illuminate\Support\Facades\Mail;
use App\Mail\SellerDocumentUploadApproved;
use App\Mail\SellerDocumentUploadRejected;
use Barryvdh\DomPDF\Facade\Pdf;

class OperationController extends Controller
{
    public $toggle_column_names = ['seller_name' => 'Seller Name', 'ruc_id' => 'RUC ID',  'opt_number' => "Operation Number", 'payers_name' => "Payers Name"];
    function __construct()
    {
        $this->middleware('permission:operation_master|export-operation|edit-operation|delete-operation', ['only' => ['index','show']]);
        $this->middleware('permission:export-operation', ['only' => ['fileExport']]);
        $this->middleware('permission:edit-operation', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-operation', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['operations_column_names'] = $this->toggle_column_names;
        return view('admin.operations.index', $data);
    }

    /**
     * Load operations data table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function ajaxLoadOperationsData(Request $request)
    {
        $this->validate($request, [
            'search' => ['nullable', 'string'],
            'role_id' => ['nullable', 'numeric'],
            'is_active' => ['nullable', 'string'],
        ]);

        $re_param = $request->all();
        $perPage = $request->input('per_page') ?? config('constants.PER_PAGE_ADMIN');
        $sortType = $request->input('sort_type') ?? 'DESC';
        $sortColumn = $request->input('sort_column',) ?? 'id';
        $column_names = $request->input('column_names') ?? [];
        $data = app('operation')->getAll($re_param);

        return view('admin.operations.ajax.operations-data-table', ['data' => $data, 'sortType' => $sortType, 'sortColumn' => $sortColumn, 'perPage' => $perPage, 'column_names' => $column_names]);
    }

    public function show(Operation $operation)
    {
        $operation_details = app('operation')->getOperationById($operation->id);
    
        return view('admin.operations.details', [
            'operation' => $operation_details,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Operation $operation)
    {
        $companies = Company::getActiveCompany();

        $operation = $operation->load('operations_process_status_file', 'documents', 'supportingAttachments', 'references');
    
        return view('admin.operations.edit', [
            'edit' => $operation,
            'companies' => $companies,
            'issuers' => Issuer::select('id','company_name', 'ruc_text_id')->get(),
            'issuerBanks' => IssuerBank::getIssuerBank(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    public function update(OperationEditRequest $request, Operation $operation)
    {
        if($request->has('accept_below_requested') && $request->get('accept_below_requested') == '1') {
            $this->validate($request, [
                'amount' => 'required|numeric',
                'accept_below_requested' => 'sometimes|in:1',
                'amount_requested' => 'required_if:accept_below_requested,1|numeric|lt:amount|min:0',
            ]);
        } else {
            $this->validate($request, [
                'amount' => 'required|numeric',
                'amount_requested' => 'nullable|numeric|lt:amount|min:0',
            ]);
        }
        DB::beginTransaction();
        try {
            
            $notifications_operation = config('constants.NOTIFICATIONS_TYPES.OPERATIONS');

            $doc_type  = $request->input('doc_type');
            $operations_status = $request->input('operations_status');
            $operation->operation_type = $doc_type;
            $operation->operations_status = $operations_status;
            $operation->responsibility = $request->input('responsibility');
            $operation->preferred_payment_method = $request->input('preferred_payment_method');

            $operation->approved_at = null;
            if($operations_status == 'Approved')
            {
                $operation->approved_at = Carbon::now();

                try {
                    if($notifications_operation['Approved'])
                    {   
                        $seller_obj = app('common')->getUserEmail($operation->seller_id);

                        $operation_detail_link = route('operations.details', [$operation->slug]);
                        $operation_number = $operation->operation_number;
                        Mail::to($seller_obj->email)->send(new SellerDocumentUploadApproved($seller_obj->name, $operation_detail_link, $operation_number));
                        // Notification::send($operation->seller, new NotificationsOperationDocumentApproved($operation));
                    }
                } catch (\Throwable $th) {
                    return redirect()->route('admin.operations.index')->with('error', $th);
                }
            }

            $operation->rejection_note = null;
            if($operations_status == 'Rejected')
            {
                $operation->rejection_note =  $request->input('rejection_note', null);

                try {
                    if($notifications_operation['Rejected'])
                    {
                        $seller_obj = app('common')->getUserEmail($operation->seller_id);
                        $operation_detail_link = route('operations.details', [$operation->slug]);
                        $operation_number = $operation->operation_number;
                        Mail::to($seller_obj->email)->send(new SellerDocumentUploadRejected($seller_obj->name, $operation_detail_link, $operation_number));
                        // Notification::send($operation->seller, new NotificationsOperationDocumentRejected($operation));
                    }
                } catch (\Throwable $th) {
                    return redirect()->route('admin.operations.index')->with('error', $th);
                }
            }

            if ($doc_type == 'Cheque') {
                $operation->check_number = $request->input('cheque_number');
                $operation->contract_title =  null;
                $operation->description = null;
            } else if ($doc_type == 'Invoice') {
                $operation->invoice_type = $request->input('invoice_type');
                $operation->invoice_number = $request->input('invoice_number');
                //$operation->issuer_company_type = $request->input('issuer_company_type');
                $operation->tax_id = $request->input('tax_id');
                $operation->timbrado = $request->input('timbrado');
                $operation->authorized_personnel = $request->input('authorized_personnel');
                $operation->contract_title =  null;
                $operation->description = null;
                $operation->stamp_expiration = $request->has('stamp_expiration') ? $request->input('stamp_expiration') : null;
            } else if ($doc_type == 'Contract') {
                $operation->is_government_contract = $request->input('is_government_contract');
                $operation->contract_title = $request->input('contract_title');
                //$operation->issuer_company_type = $request->input('issuer_company_type');
                $operation->timbrado = $request->input('timbrado');
                $operation->contract_number = $request->input('contract_number');
                $operation->stamp_expiration = $request->has('stamp_expiration') ? $request->input('stamp_expiration') : null;
            } else if ($doc_type == 'Other') {
                $operation->is_government_contract = $request->input('is_government_contract');
                $operation->description = $request->input('description');
                $operation->contract_title = $request->input('contract_title');
                //$operation->issuer_company_type = $request->input('issuer_company_type');
            }

            if($operation->operation_type != 'Cheque') {
                $extra_expiration_days = $request->input('extra_expiration_days', '');
                if(!empty($extra_expiration_days) && $extra_expiration_days > 0) {
                    $operation->extra_expiration_days = $extra_expiration_days;
                    $operation->expiration_date_document = Carbon::parse($request->input('expiration_date'))->addDays($extra_expiration_days)->format('Y-m-d');
                } else {
                    $operation->expiration_date_document = Carbon::parse($request->input('expiration_date'))->format('Y-m-d');
                }
                $operation->auto_expire = $request->has('auto_expire') ? 1 : 0;
            } else {
                $operation->expiration_date_document = Carbon::parse($request->input('expiration_date'))->format('Y-m-d');
                $operation->extra_expiration_days = null;
                $operation->auto_expire = 0;
            }
            // $operation->seller_id = Auth()->user()->id;
        
            if ($request->input('issuer_id') !== null && $request->input('issuer_id') !== '') {
                /*$issuer = Issuer::where('name', $request->input('issuer_id'))->first();
                if (is_null($issuer)) {
                    $issuer = Issuer::create(['company_name' => $request->input('issuer_id')]);
                }
                $operation->issuer_id = $issuer->id; */

                $operation->issuer_id = $request->input('issuer_id');
            }

            $operation->amount = $request->input('amount');
            $operation->amount_requested = $request->input('amount_requested');
            $operation->accept_below_requested = $request->has('accept_below_requested') ? 1 : 0;
            $operation->legal_direction = $request->legal_direction;
            $operation->legal_telephone = $request->legal_telephone;
            // $operation->issuer_bank = $request->input('issuer_bank');

            if ($request->input('issuer_bank') !== null && $request->input('issuer_bank') !== '') {
                /*  $issuerBank = IssuerBank::where('name', $request->input('issuer_bank'))->first();
                if (is_null($issuerBank)) {
                    $issuerBank = IssuerBank::create(['name' => $request->input('issuer')]);
                } */
                // $operation->issuer_bank_id = $issuerBank->id;
                $operation->issuer_bank_id = $request->input('issuer_bank');
            }

            $operation->issuance_date = Carbon::parse($request->input('issuance_date'))->format('Y-m-d');
            $operation->expiration_date = Carbon::parse($request->input('expiration_date'))->format('Y-m-d');
            
            $operation->bcp = $request->input('bcp');
            $operation->inforconf = $request->input('inforconf');
            $operation->infocheck = $request->input('infocheck');
            $operation->criterium = $request->input('criterium');
            $operation->mipo_verified = $request->input('mipo_verified', 'No');
            $operation->mipo_comment = $request->input('mipo_comment');
            $operation->preferred_currency = $request->input('preferred_currency');
            $operation->cheque_status = $request->input('cheque_status');
            $operation->cheque_type = $request->input('cheque_type');
            $operation->cheque_payee_type = $request->input('cheque_payee_type');
            $operation->save();

            // $update = User::where('id',  $operation->seller_id)->first();
            // $update->account_type = $request->input('seller_type');
            // $update->save();

            if ($request->hasFile('authorized_personnel_signature') && $doc_type != 'Cheque') {
                Storage::delete($operation->authorized_personnel_signature);
                $extension = request()->file('authorized_personnel_signature')->extension();
                if ($extension == 'heif') {
                    $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                    $path = 'operationdata/' . $operation->id . '/authorizedpersonnelsignature/'.$fileName;

                    $getImageBlob = app('common')->heicToBlob(request()->file('authorized_personnel_signature')->getPathName());
                    Storage::put($path, $getImageBlob);
                    $operation->authorized_personnel_signature = $path;
                }else{                       
                    $operation->authorized_personnel_signature = request()->file('authorized_personnel_signature')->store('operationdata/' . $operation->id . '/authorizedpersonnelsignature');
                }
            }
            $operation->save();

            if ($request->hasFile('upload_picture')) {
                foreach ($request->file('upload_picture') as $documentFile) {
                    $name = str_replace(' ', '_', $documentFile->getClientOriginalName());
                    $size = round($documentFile->getSize() / 1024, 2); //  in KB
                    $extension = $documentFile->extension();
                    $lastModified = $documentFile->getMTime();
                    if ($extension == 'heif') {
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                        $path = 'operationdata/' . $operation->id . '/documents/'.$fileName;

                        $getImageBlob = app('common')->heicToBlob($documentFile->getPathName());
                        Storage::put($path, $getImageBlob);
                    }else{                       
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                        $path = $documentFile->storeAs('operationdata/' . $operation->id . '/documents', $fileName);
                    }
                    

                    Document::create([
                        'operation_id' => $operation->id,
                        'name' => $name,
                        'display_name' => 'Document',
                        'size' => $size,
                        'extension' => $extension,
                        'last_modified' => $lastModified,
                        'path' => $path,
                        'uploaded_by' => Auth()->user()?->id,
                    ]);
                }
            }

            if ($request->hasFile('supporting_attachment')) {
                foreach ($request->file('supporting_attachment') as $supportingAttachmentFile) {
                    $name = str_replace(' ', '_', $supportingAttachmentFile->getClientOriginalName());
                    $size = round($supportingAttachmentFile->getSize() / 1024, 2); //  in KB
                    $extension = $supportingAttachmentFile->extension();
                    $lastModified = $supportingAttachmentFile->getMTime();
                    if ($extension == 'heif') {
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                        $path = 'operationdata/' . $operation->id . '/supportingattachments/'.$fileName;

                        $getImageBlob = app('common')->heicToBlob($supportingAttachmentFile->getPathName());
                        Storage::put($path, $getImageBlob);
                    }else{                       
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                        $path = $supportingAttachmentFile->storeAs('operationdata/' . $operation->id . '/supportingattachments', $fileName);
                    }                    

                    SupportingAttachment::create([
                        'operation_id' => $operation->id,
                        'name' => $name,
                        'display_name' => 'SupportingAttachment',
                        'size' => $size,
                        'extension' => $extension,
                        'last_modified' => $lastModified,
                        'path' => $path,
                        'uploaded_by' => Auth()->user()?->id,
                    ]);
                }
            }

            if ($request->has('references')) {
                $referenceIds = array_filter(array_column($request->input('references'), 'id'));

                if (!empty($referenceIds)) {
                    CommercialReference::where('operation_id', $operation->id)->whereNotIn('id', $referenceIds)->delete();
                }

                foreach ($request->input('references') as $reference)
                {
                    if($reference['name']!='')
                    {
                        CommercialReference::updateOrCreate(
                            ['id' => $reference['id'] ?? null],
                            [
                                'name' => $reference['name'] ?? '',
                                'company_name' => $reference['company_name'] ?? '',
                                'email' => $reference['email'] ?? '',
                                'phone_number' => $reference['phone_number'] ?? '',
                                'operation_id' => $operation->id,
                                ]
                            );
                    }
                }
            } else {
                CommercialReference::where('operation_id', $operation->id)->delete();
            }
            
            $operations_process_status_file_path = "/process-status-file-pdf";

            $operations_process_status_file = OperationProgressStatusFile::where('operation_id', $operation->id)->first();
            if(is_null($operations_process_status_file)) {
                $operations_process_status_file = new OperationProgressStatusFile;
            }

            if ($request->hasFile('bcp_file')) {
                app('common')->fileDeleteFromFolder($operations_process_status_file->bcp_file);
                $extension = $request->file('bcp_file')->extension();
                if ($extension == 'heif') {
                    $name = str_replace(' ', '_', $request->file('bcp_file')->getClientOriginalName());
                    $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                    $path = 'operationdata/' . $operation->id .$operations_process_status_file_path.'/'.$fileName;
                    $getImageBlob = app('common')->heicToBlob($request->file('bcp_file')->getPathName());
                    Storage::put($path, $getImageBlob);
                    $operations_process_status_file->bcp_file = $path;
                }else{                       
                    $operations_process_status_file->bcp_file = $request->file('bcp_file')->store('operationdata/' . $operation->id .$operations_process_status_file_path);
                }  
            }
            if ($request->hasFile('inforconf_file')) {
                app('common')->fileDeleteFromFolder($operations_process_status_file->inforconf_file);
                $extension = $request->file('inforconf_file')->extension();
                if ($extension == 'heif') {
                    $name = str_replace(' ', '_', $request->file('inforconf_file')->getClientOriginalName());
                    $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                    $path = 'operationdata/' . $operation->id .$operations_process_status_file_path.'/'.$fileName;
                    $getImageBlob = app('common')->heicToBlob($request->file('inforconf_file')->getPathName());
                    Storage::put($path, $getImageBlob);
                    $operations_process_status_file->inforconf_file = $path;
                }else{                       
                    $operations_process_status_file->inforconf_file = $request->file('inforconf_file')->store('operationdata/' . $operation->id .$operations_process_status_file_path);
                }  
            }
            if ($request->hasFile('infocheck_file')) {
                app('common')->fileDeleteFromFolder($operations_process_status_file->infocheck_file);
                $extension = $request->file('infocheck_file')->extension();
                if ($extension == 'heif') {
                    $name = str_replace(' ', '_', $request->file('infocheck_file')->getClientOriginalName());
                    $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                    $path = 'operationdata/' . $operation->id .$operations_process_status_file_path.'/'.$fileName;
                    $getImageBlob = app('common')->heicToBlob($request->file('infocheck_file')->getPathName());
                    Storage::put($path, $getImageBlob);
                    $operations_process_status_file->infocheck_file = $path;
                }else{                       
                    $operations_process_status_file->infocheck_file = $request->file('infocheck_file')->store('operationdata/' . $operation->id .$operations_process_status_file_path);
                }
            }
            if ($request->hasFile('criterium_file')) {
                app('common')->fileDeleteFromFolder($operations_process_status_file->criterium_file);
                $extension = $request->file('criterium_file')->extension();
                if ($extension == 'heif') {
                    $name = str_replace(' ', '_', $request->file('criterium_file')->getClientOriginalName());
                    $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                    $path = 'operationdata/' . $operation->id .$operations_process_status_file_path.'/'.$fileName;
                    $getImageBlob = app('common')->heicToBlob($request->file('criterium_file')->getPathName());
                    Storage::put($path, $getImageBlob);
                    $operations_process_status_file->criterium_file = $path;
                }else{                       
                    $operations_process_status_file->criterium_file = $request->file('criterium_file')->store('operationdata/' . $operation->id .$operations_process_status_file_path);
                }
            }
            $operations_process_status_file->operation_id = $operation->id;
            $operations_process_status_file->save();

            if ($request->hasFile('admin_staff_attachments_files')) {
                foreach ($request->file('admin_staff_attachments_files') as $file) {
                    $name = str_replace(' ', '_', $file->getClientOriginalName());
                    $size = round($file->getSize() / 1024, 2); //  in KB
                    $extension = $file->extension();
                    $lastModified = $file->getMTime();
                    if ($extension == 'heif') {
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                        $path = 'operationdata/' . $operation->id . '/admin-staff-files/'.$fileName;

                        $getImageBlob = app('common')->heicToBlob($file->getPathName());
                        Storage::put($path, $getImageBlob);
                    }else{                       
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                        $path = $file->storeAs('operationdata/' . $operation->id . '/admin-staff-files', $fileName);
                    }
                    

                    OperationsAdminStaffFile::create([
                        'operation_id' => $operation->id,
                        'name' => $name,
                        'size' => $size,
                        'extension' => $extension,
                        'last_modified' => $lastModified,
                        'path' => $path,
                        'uploaded_by' => Auth()->user()?->id,
                    ]);
                }
            }
            DB::commit();

            //Add watermark to operations images
            if(file_exists(public_path('watermark.png')) && $operation->operations_status == 'Approved')
            {
                $operationsDocuments = $operation->documents;
                $operationsSupportingAttachments = $operation->supportingAttachments;

                if($operationsDocuments->count() > 0) {
                    foreach($operationsDocuments as $doc) 
                    {
                        if($doc->extension !='pdf') {
                            $img = Image::make(Storage::get($doc->path));
                            $imgFile = Image::make(public_path('watermark.png'));
                            $imgFile->text($operation->operation_number, 35, 20, function($font) { 
                                $font->file('fonts/GeneralSans-Regular.ttf'); 
                                $font->size(14);  
                                $font->valign('center');
                                $font->align('center');
                                $font->color('#ffffff');
                            });
                            
                            $img->insert($imgFile, 'bottom-right', 15, 15);
                            Storage::put($doc->path, $img->stream());
                        }
                    }
                }
                
                if($operationsSupportingAttachments->count() > 0) {
                    foreach($operationsSupportingAttachments as $attachment) {
                        if($attachment->extension !='pdf') {
                            $img = Image::make(Storage::get($attachment->path));
                            $imgFile = Image::make(public_path('watermark.png'));
                            $imgFile->text($operation->operation_number, 35, 20, function($font) {
                                $font->file('fonts/GeneralSans-Regular.ttf'); 
                                $font->size(14);  
                                $font->valign('center');
                                $font->align('center');
                                $font->color('#ffffff');
                            });
                            $img->insert($imgFile, 'bottom-right', 15, 15);
                            //$img->insert(public_path('watermark.png'), 'bottom-right', 0, 0);
                            Storage::put($attachment->path, $img->stream());
                        }
                    }
                }
            }

            $msg = "Operation updated successfully";
            if($operation->operations_status == 'Pending') {
                $msg = "Pending operation successfully";
            } else if($operation->operations_status == 'Rejected') {
                $msg = "Operation reverted from verification";
            }
            
            return redirect()->route('admin.operations.index')->with('success', __($msg));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.operations.index')->with('error', $th);
        }
    }

    public function destroy(Request $request, $slug)
    {
        if ($request->ajax()) {
            $result = app('operation')->delete($slug);
            if ($result) {
                $response = [
                    'status' => true,
                    'message' => __('Operation deleted successfully'),
                    'data' => ''
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => __('Associate module can not delete'),
                    'data' => ''
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }
    
    public function ajaxDeleteDocument(Request $request, $slug)
    {
        if ($request->ajax()) {
            try {
                    $result = app('operation')->deleteDocuments($slug);
                    if($result)
                    {
                        $response = [
                            'status' => true,
                            'message' => __('Image deleted successfully'),
                        ];
                    }
                } catch (\Throwable $th) {
                    $response = [
                        'status' => false,
                        'message' => $th->getMessage(),
                    ];
                }
                return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }

    public function ajaxDeleteAttachments(Request $request, $slug)
    {
        if ($request->ajax()) {
            try {
                    $result = app('operation')->deleteAttachments($slug);
                    if($result){
                        $response = [
                            'status' => true,
                            'message' => __('Image deleted successfully'),
                        ];
                    } 
                } catch (\Throwable $th) {
                    $response = [
                        'status' => false,
                        'message' => $th->getMessage(),
                    ];
                }
                return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }

    public function fileExport(Request $request)
    {
        if ($request->ajax()) 
        {
            try {
               /*  $path = 'export/export_operation_'.time().'.xlsx';

                    $param = $request->only('search', 'operation_type', 'operations_status', 'action');
                    
                    $result = (new OperationExport($param))->store($path);
                */

                $fileName = 'operation_list_'.time().'.pdf';

                $param = $request->only('search', 'operation_type', 'operations_status', 'action');
                
                $data = app('operation')->getAll($param, false);

                $pdf = Pdf::loadView('admin.exports.pdf.operation-list-pdf', ['data' => $data]);

                $filePath = "/admin/pdf/";

                $fileFullPath = storage_path('app'.$filePath.$fileName);
                
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];

                $content = $pdf->download()->getOriginalContent();

                $is_storage = Storage::put($filePath.$fileName, $content);
             
                $file_downalod = route('secure-pdf', Crypt::encryptString($filePath.$fileName));

                if($is_storage && $file_downalod)
                {
                    $response = [
                        'status' => true,
                        'message' => '',
                        'file_downalod' =>  $file_downalod,
                    ];
                }
            } catch (\Throwable $th) {
                $response = [
                    'status' => false,
                    'message' => $th->getMessage(),
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }

    public function fileImport(Request $request) 
    {
        try {
            Excel::import(new OperationsImports, $request->file('file_import')->store('import-operation'));
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function ajaxDeleteAll(Request $request) {
        $this->validate($request, [
            'ids' => ['required'],
        ]);
        try {
            $ids = $request->get('ids');
            if(is_array($ids)) {
                $results = Operation::with('documents:id,slug', 'supportingAttachments:id,slug')->whereIn('id', $ids)->where('operations_status', '!=', 'Approved')->select('id')->get();
                if($results && $results->count() > 0) {
                    foreach ($results as $key => $result) {
                        if($result->documents->count() > 0) {
                            foreach ($result->documents as $key => $document) {
                                app('operation')->deleteDocuments($document->slug);
                            }
                        }
                        if($result->supportingAttachments->count() > 0) {
                            foreach ($result->supportingAttachments as $key => $supportingAttachment) {
                                app('operation')->deleteAttachments($supportingAttachment->slug);
                            }
                        }
                        $result->offers()->delete();
                        $result->delete();
                    }
                    $response = [
                        'status' => true,
                        'message' => __('Deleted successfully'),
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => __('No deleted'),
                    ];
                }
            }
        } catch (\Throwable $th) {
            $response = [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
        return response()->json($response);
    }

    public function ajaxDeleteProcessStatusFile(Request $request, $id, $clm_name)
    {
        if ($request->ajax() && $id!='' && $clm_name!='') {
            try {+
                    $result = app('operation')->deleteProcessStatusFile($id, $clm_name);
                    if($result)
                    {
                        $response = [
                            'status' => true,
                            'message' => __('Image deleted successfully'),
                        ];
                    }
                } catch (\Throwable $th) {
                    $response = [
                        'status' => false,
                        'message' => $th->getMessage(),
                    ];
                }
                return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }

    public function ajaxDeleteAdminStaffAttachmentsFile(Request $request, $id)
    {
        if ($request->ajax()) {
            try {
                    $result = app('operation')->deleteAdminStaffAttachmentsFile($id);
                    if($result){
                        $response = [
                            'status' => true,
                            'message' => __('Image deleted successfully'),
                        ];
                    } 
                } catch (\Throwable $th) {
                    $response = [
                        'status' => false,
                        'message' => $th->getMessage(),
                    ];
                }
                return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }

    public function exportOperationDetail(Request $request, $slug)
    {
            set_time_limit(300); 

            // Record the start time
            $startTime = microtime(true);

            $currency_symblos = config('constants.CURRENCY_SYMBOLS');
    
            $result = app('operation')->getOperationById($operation_id = null, $slug);

            if($result)
            {
                $data['operation'] = $result;
                
                $data['currency_symblos'] = $currency_symblos;
                $data['imageUrl'] = asset('images/mipo/pdf/singlestr48.png');
        
                $fileName = $result->operation_number.".pdf";

                $pdf = Pdf::loadView('admin.operations.pdf.operation-detail', $data);
                
                $endTime = microtime(true);

                // Calculate the load time
                $loadTime = $endTime - $startTime;
        
                // Log or display the load time
                \Log::info("PDF Load Time: {$loadTime} seconds");

                // return $pdf->stream();
                return $pdf->download($fileName);
                
            } else {
                return redirect()->route('admin.operations.index')->with('error', __('Something went wrong please try again!'));
            }
    }
}
