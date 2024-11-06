<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Issuer;
use App\Models\City;
use App\Models\User;
use App\Models\Operation;
use App\Models\IssuersattachImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PayerissuerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:payer_issuer_master|add-payer-issuer|edit-payer-issuer|delete-payer-issuer', ['only' => ['index','show']]);
        $this->middleware('permission:add-payer-issuer', ['only' => ['create','store']]);
        $this->middleware('permission:edit-payer-issuer', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-payer-issuer', ['only' => ['destroy']]);
    }
    public function index()
    {
        $issuer = Issuer::orderBy('id', 'desc')->withTrashed()->get();
        $users = User::orderBy('id', 'desc')->whereNotNull('is_registered')->get();
        $marital_status = config('constants.MARITAL_STATUS');
        return view('admin.payer-issuer.index', ['issuer' => $issuer,'users'=>$users]);
    }

    public function create()
    {
        $cities = City::getAllCities();
        $marital_status = config('constants.MARITAL_STATUS');
        return view('admin.payer-issuer.create', ['cities' => $cities, 'marital_status' => $marital_status]);
    }

    public function store(Request $request)
    {
        $request->validate([
          /*   'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'], */
            'commercial_name' => ['required', 'string', 'max:255'],
            'city_name' => ['required'],
            // 'company_name' => ['required', 'string', 'max:255', 'unique:issuers,company_name'],
            'ruc_text_id' => ['required', 'string', 'max:255', 'unique:issuers,ruc_text_id'],
            'registry_in_mipo' => ['required', 'in:Yes,No'],
            'verified_address' => ['required', 'in:Yes,No'],
            'registered_at' => ['nullable', 'before:today'],
            'issuers_image' => ['nullable', 'file', 'mimetypes:image/*'],
            'issuers_attach_images.*' => ['nullable', 'file', 'mimetypes:image/*'],
        ],
        ['ruc_text_id.unique' => __('The RUC has already been taken.')]);
    
        $payer_issuer = new Issuer;
        $payer_issuer->first_name = $request->first_name;
        $payer_issuer->last_name = $request->last_name;
        $payer_issuer->company_name = $request->company_name;
        $payer_issuer->marital_status = $request->marital_status;
        $payer_issuer->registry_in_mipo = $request->registry_in_mipo;
        $payer_issuer->tradename = $request->tradename ?? null;
        $payer_issuer->ruc_text_id = $request->ruc_text_id;
        $payer_issuer->ruc_code_optional = $request->ruc_code_optional;
        $payer_issuer->address = $request->address;
        $payer_issuer->verified_address = $request->verified_address;
        $payer_issuer->heading = $request->heading;
        $payer_issuer->basic_info = $request->basic_info;
        $payer_issuer->additional_info = $request->additional_info;
        $payer_issuer->country_id = null;
        // $payer_issuer->gender = $request->gender;
        // $payer_issuer->country_id = $request->country_id;
        $payer_issuer->city_id = $request->city_name;
        $payer_issuer->registered_at = $request->registered_at;
        $payer_issuer->bcp = $request->input('bcp');
        $payer_issuer->inforconf = $request->input('inforconf');
        $payer_issuer->infocheck = $request->input('infocheck');
        $payer_issuer->criterium = $request->input('criterium');
        $payer_issuer->commercial_name = $request->input('commercial_name');
        $payer_issuer->save();

        if ($request->hasFile('issuers_image')) {
            $issuers_image = $request->file('issuers_image');
            $name = str_replace(' ', '_', $issuers_image->getClientOriginalName());
            $size = round($issuers_image->getSize() / 1024, 2); //  in KB
            $extension = $issuers_image->extension();
            $last_modified = $issuers_image->getMTime();
            if ($extension == 'heif') {
                $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                $path = 'issuers_image/' . $payer_issuer->id.'/'.$fileName;

                $getImageBlob = app('common')->heicToBlob($issuers_image->getPathName());
                Storage::put($path, $getImageBlob);
            }else{                       
                $file_name = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                $path = $issuers_image->storeAs('issuers_image/' . $payer_issuer->id, $file_name);
            }
            
            $payer_issuer->issuers_image = $path;
            $payer_issuer->save();
        }

        if ($request->hasFile('issuers_attach_images')) {
            $i = 0;
            foreach ($request->file('issuers_attach_images') as $issuers_attach_image) {
                $name = str_replace(' ', '_', $issuers_attach_image->getClientOriginalName());
                $size = round($issuers_attach_image->getSize() / 1024, 2); //  in KB
                $extension = $issuers_attach_image->extension();
                $lastModified = $issuers_attach_image->getMTime();
                if ($extension == 'heif') {
                    $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                    $path = 'issuers_image/' . $payer_issuer->id . '/attach_image/'.$fileName;
    
                    $getImageBlob = app('common')->heicToBlob($issuers_attach_image->getPathName());
                    Storage::put($path, $getImageBlob);
                }else{                       
                    $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                    $path = $issuers_attach_image->storeAs('issuers_image/' . $payer_issuer->id . '/attach_image', $fileName);
                }
               

                IssuersattachImage::create([
                    'issuers_id' => $payer_issuer->id,
                    'name' => $name,
                    'size' => $size,
                    'extension' => $extension,
                    'last_modified' => $lastModified,
                    'path' => $path,
                ]);
                $i++;
            }
        }

        return redirect()->route('admin.payer-issuer.index')->with('success', __('Company added successfully'));
    }

    public function show(Company $company)
    {
        //
    }

    public function edit(Issuer $payer_issuer)
    {   
        $cities = City::getAllCities();
        $marital_status = config('constants.MARITAL_STATUS');
        return view('admin.payer-issuer.edit', ['edit' => $payer_issuer->load('issuers_attach_images:id,issuers_id,slug,extension,path,name'), 'cities' => $cities, 'marital_status' => $marital_status]);
    }

    public function update(Request $request, Issuer $payer_issuer)
    {
        $request->validate([
           /*  'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'], */
            'commercial_name' => ['required', 'string', 'max:255'],
            'city_name' => ['required'],
            // 'company_name' => ['required', 'string', 'max:255', 'unique:issuers,company_name,'.$payer_issuer->id],
            'ruc_text_id' => ['required', 'string', 'max:255', 'unique:issuers,ruc_text_id,'.$payer_issuer->id],
            'registry_in_mipo' => ['required', 'in:Yes,No'],
            'verified_address' => ['required', 'in:Yes,No'],
            'registered_at' => ['nullable', 'before:today'],
            'issuers_image' => ['nullable', 'file', 'mimetypes:image/*'],
            'issuers_attach_images.*' => ['nullable', 'file', 'mimetypes:image/*'],
        ],
        ['ruc_text_id.unique' => __('The RUC has already been taken.')]);

        if ($request->hasFile('issuers_image')) {
            $issuers_image = $request->file('issuers_image');
            $name = str_replace(' ', '_', $issuers_image->getClientOriginalName());
            $size = round($issuers_image->getSize() / 1024, 2); //  in KB
            $extension = $issuers_image->extension();
            $last_modified = $issuers_image->getMTime();
            if ($extension == 'heif') {
                $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                $path = 'issuers_image/' . $payer_issuer->id.'/'.$fileName;

                $getImageBlob = app('common')->heicToBlob($issuers_image->getPathName());
                Storage::put($path, $getImageBlob);
            }else{                       
                $file_name = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                $path = $issuers_image->storeAs('issuers_image/' . $payer_issuer->id, $file_name);
            }
            
            if(!empty($payer_issuer->issuers_image)) {
                \Storage::delete($payer_issuer->issuers_image);
            }
            $payer_issuer->issuers_image = $path;
        }

        $payer_issuer->first_name = $request->first_name;
        $payer_issuer->last_name = $request->last_name;
        $payer_issuer->company_name = $request->company_name;
        $payer_issuer->marital_status = $request->marital_status;
        $payer_issuer->registry_in_mipo = $request->registry_in_mipo;
        $payer_issuer->tradename = $request->tradename ?? null;
        $payer_issuer->ruc_text_id = $request->ruc_text_id;
        $payer_issuer->ruc_code_optional = $request->ruc_code_optional;
        $payer_issuer->address = $request->address;
        $payer_issuer->verified_address = $request->verified_address;
        $payer_issuer->heading = $request->heading;
        $payer_issuer->basic_info = $request->basic_info;
        $payer_issuer->additional_info = $request->additional_info;
        $payer_issuer->country_id = null;
        // $payer_issuer->gender = $request->gender;
        // $payer_issuer->country_id = $request->country_id;
        $payer_issuer->city_id = $request->city_name;
        $payer_issuer->registered_at = $request->registered_at;
        $payer_issuer->bcp = $request->input('bcp');
        $payer_issuer->inforconf = $request->input('inforconf');
        $payer_issuer->infocheck = $request->input('infocheck');
        $payer_issuer->criterium = $request->input('criterium');
        $payer_issuer->commercial_name = $request->input('commercial_name');
        $payer_issuer->save();
        
        if ($request->hasFile('issuers_attach_images')) {
            $i = 0;
            foreach ($request->file('issuers_attach_images') as $issuers_attach_image) {
                $name = str_replace(' ', '_', $issuers_attach_image->getClientOriginalName());
                $size = round($issuers_attach_image->getSize() / 1024, 2); //  in KB
                $extension = $issuers_attach_image->extension();
                $lastModified = $issuers_attach_image->getMTime();
                if ($extension == 'heif') {
                    $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                    $path = 'issuers_image/' . $payer_issuer->id . '/attach-image/'.$fileName;

                    $getImageBlob = app('common')->heicToBlob($disputes_file->getPathName());
                    Storage::put($path, $getImageBlob);
                }else{                       
                    $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                    $path = $issuers_attach_image->storeAs('issuers_image/' . $payer_issuer->id . '/attach-image', $fileName);
                }
                

                IssuersattachImage::create([
                    'issuers_id' => $payer_issuer->id,
                    'name' => $name,
                    'size' => $size,
                    'extension' => $extension,
                    'last_modified' => $lastModified,
                    'path' => $path,
                ]);
                $i++;
            }
        }

        return redirect()->route('admin.payer-issuer.index')->with('success', __('Compnay updated successfully'));
    }

    public function destroy(Request $request, $slug)
    {
        if($request->ajax())
        {
            $type = null;
            $issuer = Issuer::withTrashed()->where('slug', $slug)->first();
            if($issuer)
            {
                $is_extis = Operation::withTrashed()->where('issuer_id', $issuer->id)->count();
                $is_user = User::where('issuer_id', $issuer->id)->withTrashed()->count();
                
                if($is_extis > 0 || $is_user > 0) {
                    $response = [
                        'status' => false,
                        'message' => __('Can not delete user Associated data exists, please delete them first'),
                        'data' => []
                    ];

                    return response()->json($response);
                }

                if(is_null($issuer->deleted_at) && empty($issuer->deleted_at)){
                    $type = 'restore';
                    $message = 'Deleted successfully';
                    $issuer->deleted_at = Carbon::now();
                } else{
                    $type = 'delete';
                    $message = "Restore successfully";
                    $issuer->deleted_at = null;
                }
                $issuer->save();
                $response = [
                    'status' => true,
                    'message' => __($message),
                    'data' => ['type' => __($type)]
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => __('Something went wrong please try again!'),
                    'data' => ['type' => __($type)]
                ];
            }  
            return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }

    public function forceDelete(Request $request, $slug)
    {
        if($request->ajax())
        {
            \DB::beginTransaction();
            try {
                $issuer = Issuer::withTrashed()->where('slug', $slug)->first();
                if($issuer)
                {
                    $issuer_id = $issuer->id;

                    $is_operation = Operation::where('issuer_id', $issuer_id)->withTrashed()->count();
                    $is_user = User::where('issuer_id', $issuer_id)->withTrashed()->count();

                    if($is_operation > 0 || $is_user > 0) {
                        $response = [
                            'status' => false,
                            'message' => __('Can not delete user Associated data exists, please delete them first'),
                            'data' => ''
                        ];

                        return response()->json($response);
                    }

                    app('fileupload')->fileDeleteFromFolder($issuer->issuers_image);

                    $is_results = IssuersattachImage::where('issuers_id', $issuer->id)->get();
                    if ($is_results && $is_results->count() > 0) {
                        foreach ($is_results as $key => $val) {
                           
                            app('fileupload')->fileDeleteFromFolder($val->path);
                            $is_result->forceDelete();
                        }
                    }

                    $issuer->forceDelete();
                   \DB::commit();
                    $response = [
                        'status' => true,
                        'message' => __('Deleted successfully'),
                        'data' => ''
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => __('Issuer no found'),
                        'data' => ''
                    ];
                }
            } catch (\Throwable $th) {
                \DB::rollBack();
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() . ' Line No  :' . $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }

    public function ajaxDeleteIssuerAttachImage(Request $request, $slug)
    {
        if ($request->ajax()) {
            try {
                $is_result = IssuersattachImage::where('slug', $slug)->first();
                if ($is_result) {
                    $imagePath = storage_path('app/' . $is_result->path);
                    if (file_exists($imagePath)) {
                        Storage::delete($is_result->path);
                    }
                    $is_result->forceDelete();
                    $response = [
                        'status' => true,
                        'message' => __('File deleted successfully'),
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
}
