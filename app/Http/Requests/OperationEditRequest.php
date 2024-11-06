<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class OperationEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $preferred_payment_method = (config('constants.PREFERRED_MODE'));
        $currencyTypes = (config('constants.CURRENCY_TYPE'));
        return [
            // 'seller_type' => ['required'],
            'issuer_id' => ['required'],
            'operations_status' => ['required'],
            'preferred_currency' => ['required'],
            'cheque_payee_type' => ['nullable'],
            'cheque_status' => ['nullable'],
            'cheque_type' => ['nullable'],
            'amount' => ['nullable', 'numeric'],
            'accept_below_requested' => ['sometimes', Rule::in('1')],
            // 'amount_requested' => 'required_if:accept_below_requested,1|numeric|lt:amount|min:0',
            'responsibility' => ['nullable', Rule::in(['With', 'Without'])],
            'preferred_payment_method' => ['nullable', Rule::in($preferred_payment_method)],
            'preferred_currency' => ['required', Rule::in($currencyTypes)],
            'contract_title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'authorized_personnel_signature' => 'nullable|mimes:png,jpg,jpeg,heif',
            'upload_picture' => ['sometimes', 'nullable', 'array'],
            'upload_picture.*' => ['sometimes', 'nullable', 'file', 'mimes:png,jpg,jpeg,pdf,heif'],
            // 'upload_picture.*' => ['sometimes', 'nullable', 'file', 'image'],
            'supporting_attachment' => ['sometimes', 'nullable', 'array'],
            // 'supporting_attachment.*' => ['sometimes', 'nullable', 'file', 'image'],
            'supporting_attachment.*' => ['sometimes', 'nullable', 'file', 'mimes:png,jpg,jpeg,pdf,heif'],
            'references' => ['sometimes', 'array'],
            'references.*.name' => ['nullable', 'string', 'max:50'],
            'references.*.phone_number' => ['nullable', 'string', 'max:50', 'regex:/^([0-9\ \-\+\(\)]*)$/'],
            'references.*.email' => ['nullable', 'string', 'max:50', 'email'],
            'bcp_file' => ['nullable'],
            'inforconf_file' => ['nullable','file','mimes:pdf'],
            'infocheck_file' => ['nullable','file','mimes:pdf'],
            'criterium_file' => ['nullable','file','mimes:pdf'],
            'admin_staff_attachments_files' => ['sometimes', 'nullable', 'array'],
            'admin_staff_attachments_files.*' => ['sometimes', 'nullable', 'file', 'mimes:png,jpg,jpeg,pdf,heif'],
        ];
        
    }

    public function attributes()
    {
        return [
            'preferred_currency' => 'currency',
            'seller_id' => 'seller',
            'upload_picture' => 'document',
            'upload_picture.*' => 'document',
            'supporting_attachment.*' => 'supporting attachment',
            'supporting_attachment.*' => 'supporting attachment name',
            'references' => 'reference',
            'references.*.name' => 'reference name',
            'references.*.phone_number' => 'reference phone number',
            'references.*.email' => 'reference email',
            'admin_staff_attachments_files' => 'admin staff attachments files',
            'admin_staff_attachments_files.*' => 'admin staff attachments files',
            "issuer_id" => "Payer"
        ];
    }
}
