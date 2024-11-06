<?php
namespace App\Imports;

use App\Models\Operation;
use App\Models\Document;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class OperationsImports implements ToCollection, WithHeadingRow
{

    public $validColumnName = [
        'operation_type',
        'is_government_contract',
        'responsibility',
        'preferred_payment_method',
        'contract_title',
        'description',
        'seller_id',
        'issuer_id',
        'preferred_currency',
        'amount',
        'amount_requested',
        'accept_below_requested',
        'check_number',
        'invoice_type',
        'issuer_company_type',
        'invoice_number',
        'tax_id',
        'timbrado',
        'authorized_personnel',
        'authorized_personnel_signature',
        'issuer_bank_id',
        'bcp',
        'inforconf',
        'infocheck',
        'criterium',
        'cheque_status',
        'cheque_type',
        'cheque_payee_type',
        'issuance_date',
        'expiration_date',
        'extra_expiration_days',
        'operations_status',
        'mipo_verified',
        'approved_at',
        'rejection_note',
        'auto_expire',
        'expired_at',
    ];
    private $documentsFileNameArr = [];
    private $spportAttachmentFileNameArr = [];
    public function collection(Collection $rows)
    {
        $imports_data = $rows->toArray();
        foreach ($imports_data as $row) 
        {
            try {
                $operation = new Operation();
                $operation->operation_type = $row['doc_type'] ?? null;
                $operation->responsibility = $row['responsibility'] ?? null;
                $operation->preferred_payment_method = $row['preferred_payment_method'] ?? null;
    
                if ($operation->operation_type == 'Cheque') {
                    $operation->check_number = $row['check_number'] ?? null ?? null;
                } elseif ($operation->operation_type == 'Invoice') {
                    $operation->invoice_type = $row['invoice_type'] ?? null;
                    $operation->invoice_number = $row['invoice_number'] ?? null;
                    $operation->issuer_company_type = $row['issuer_company_type'] ?? null;
                    $operation->tax_id = $row['tax_id'] ?? null;
                    $operation->timbrado = $row['timbrado'] ?? null;
                    $operation->authorized_personnel = $row['authorized_personnel'] ?? null;
                } elseif ($operation->operation_type == 'Contract') {
                    $operation->is_government_contract = $row['is_government_contract'] ?? null;
                    $operation->contract_title = $row['contract_title'] ?? null;
                    $operation->issuer_company_type = $row['issuer_company_type'] ?? null;
                } elseif ($operation->operation_type == 'Other') {
                    $operation->is_government_contract = $row['is_government_contract'] ?? null;
                    $operation->description = $row['description'] ?? null;
                    $operation->contract_title = $row['contract_title'] ?? null;
                    $operation->issuer_company_type = $row['issuer_company_type'] ?? null;
                }
    
                if($operation->operation_type != 'Cheque') {
                    $extra_expiration_days = $row['extra_expiration_days'] ?? null ?? '';
                    if(!empty($extra_expiration_days)) {
                        $operation->extra_expiration_days = $extra_expiration_days;
                    }
                } else {
                    $operation->extra_expiration_days = null;
                }
    
                $operation->seller_id = Auth()->user()->id;
    
                if ($row['issuer'] ?? null !== null && $row['issuer'] ?? null !== '') {
                    $issuer = Issuer::where('name', $row['issuer'] ?? null)->first();
                    if ($issuer === null) {
                        $issuer = Issuer::create(['name' => $row['issuer'] ?? null]);
                    }
                    $operation->issuer_id = $issuer->id;
                }
    
                $operation->preferred_currency = $row['preferred_currency'] ?? null;
                $operation->amount = $row['amount'] ?? null;
                $operation->amount_requested = $row['amount_requested'] ?? null;
                $operation->accept_below_requested = ($row['accept_below_requested'] ?? null == 'yes') ? 1 : 0;
                
                $operation->issuance_date = ($row['issuance_date']) ? Carbon::parse($row['issuance_date'])->format('Y-m-d') : null;
                $operation->expiration_date = ($row['expiration_date']) ? Carbon::parse($row['expiration_date'])->format('Y-m-d') : null;
                $operation->auto_expire = 0;
                $operation->expired_at = $operation->auto_expire ? $operation->expiration_date . ' 00:00:00' : null;
    
                $operation->operations_status = 'Draft';
                $operation->save();

                if($row['documents'] !=""){
                    $docArr = explode(',',$row['documents']);
                    $newDocArray = [];
                    foreach($docArr as $key=>$val){
                        //Store document in local storage from url
                        $newDocArray[$val] = $operation->id;
                        $extension = pathinfo($val, PATHINFO_EXTENSION);
                        if($extension && $extension !="svg"){
                            $fileName = basename($val);  
                            $name = str_replace(' ', '_', $fileName);
                            $path = 'operationdata/' . $operation->id . '/documents'.'/'.$fileName;
                            //$img = Image::make($val);
   
                            /* insert watermark at bottom-right corner with 10px offset */
                            //$img->insert(public_path('watermark.png'), 'bottom-right', 0, 0);

                            //$isUploads = Storage::put($path, file_get_contents($val));
                            //$isUploads = Storage::put($path, (string) $img->encode());
                            $isUploads = Storage::put($path, file_get_contents($val));

                            if($isUploads){
                                $mime = Storage::mimeType($path);
                                $lastModified = Storage::lastModified($path);
                                $size = Storage::size($path);

                                Document::create([
                                    'operation_id' => $operation->id,
                                    'name' => $name,
                                    'display_name' => $fileName,
                                    'size' => $size,
                                    'extension' => $extension,
                                    'last_modified' => $lastModified,
                                    'path' => $path,
                                    'uploaded_by' => Auth()->user()?->id,
                                ]);
                            }

                        }
                    }
                    $this->documentsFileNameArr = array_merge($this->documentsFileNameArr,$newDocArray);
                }
                if($row['supporting_attachments'] !=""){
                    $supportAttachmentArr = explode(',',$row['supporting_attachments']);
                    $newSupportAttachmentArray = [];
                    foreach($supportAttachmentArr as $key=>$val){
                        $newSupportAttachmentArray[$val] = $operation->id;
                        $extension = pathinfo($val, PATHINFO_EXTENSION);
                        if($extension && $extension !="svg"){
                            $fileName = basename($val);  
                            $name = str_replace(' ', '_', $fileName);
                            $path = 'operationdata/' . $operation->id . '/supportingattachments'.'/'.$fileName;
                            //$imgDoc = Image::make($val);
   
                            /* insert watermark at bottom-right corner with 10px offset */
                            //$imgDoc->insert(public_path('watermark.png'), 'bottom-right', 0, 0);
                            //$isUploads = Storage::put($path, (string) $imgDoc->encode());
                            $isUploads = Storage::put($path, file_get_contents($val));
                            if($isUploads){
                                $mime = Storage::mimeType($path);
                                $lastModified = Storage::lastModified($path);
                                $size = Storage::size($path);

                                Document::create([
                                    'operation_id' => $operation->id,
                                    'name' => $name,
                                    'display_name' => $fileName,
                                    'size' => $size,
                                    'extension' => $extension,
                                    'last_modified' => $lastModified,
                                    'path' => $path,
                                    'uploaded_by' => Auth()->user()?->id,
                                ]);
                            }

                        }
                    }
                    $this->spportAttachmentFileNameArr = array_merge($this->spportAttachmentFileNameArr,$newSupportAttachmentArray);
                }
            } catch (\Throwable $th) {
                // throw $th;
                report($th);
            }
        }
        
    }
    public function getDocumentAndAttechmentArray(): array
    {
        return ['documents' => $this->documentsFileNameArr, 'supporting_attachments'=> $this->spportAttachmentFileNameArr];
    }
}
?>