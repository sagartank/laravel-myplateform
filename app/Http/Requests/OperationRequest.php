<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class OperationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // dd($this->all());
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $paymentMethods = (config('constants.PREFERRED_MODE'));
        $currencyTypes = (config('constants.CURRENCY_TYPE'));

        return [
            'doc_type' => ['nullable', 'string', 'max:255'],
            'is_government_contract' => ['nullable', Rule::in(['Yes', 'No'])],
            'responsibility' => ['nullable', Rule::in(['With', 'Without'])],
            'preferred_payment_method' => ['nullable', Rule::in($paymentMethods)],
            'contract_title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'issuer' => ['nullable', 'string'],
            'preferred_currency' => ['required', Rule::in($currencyTypes)],
            'amount' => ['nullable', 'numeric', 'min:0'],
            // 'amount_requested' => ['nullable', 'numeric', 'min:0', 'lt:amount'],
            'accept_below_requested' => ['sometimes', Rule::in('1')],
            'amount_requested' => 'required_if:accept_below_requested,1|numeric|lt:amount|min:0',
            'invoice_type' => ['nullable', Rule::in(['Service', 'Product'])],
            'issuance_date' => ['nullable', 'date'],
            'expiration_date' => ['nullable', 'after:issuance_date'],
            'auto_expire' => ['sometimes', Rule::in('on')],
            'check_number' => ['nullable', 'string', 'max:255'],
            'issuer_company_type' => ['nullable', 'string', 'max:255'],
            'invoice_number' => ['nullable', 'string', 'max:255'],
            'tax_id' => ['nullable', 'string', 'max:255'],
            'timbrado' => ['nullable', 'string', 'max:255'],
            'authorized_personnel' => ['nullable', 'string', 'max:255'],
            'authorized_personnel_signature' => ['sometimes', 'file', 'image'],
            'issuer_bank' => ['nullable', 'string', 'max:255'],
            'references' => ['sometimes', 'array'],
            'references.*.name' => ['nullable', 'string', 'max:255'],
            'references.*.phone_number' => ['nullable', 'string', 'max:255', 'regex:/^([0-9\ \-\+\(\)]*)$/'],
            'references.*.email' => ['nullable', 'string', 'max:255', 'email'],
            'tnc' => ['sometimes', Rule::in('on')],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['required', 'string', 'max:255'],
            'documents' => ['sometimes', 'nullable', 'array'],
            'documents.*' => ['sometimes', 'nullable', 'file', 'mimetypes:image/*,application/pdf'],
            'document_names' => ['sometimes', 'nullable', 'array'],
            'document_names.*' => ['sometimes', 'nullable', 'string', 'max:255'],
            'supporting_attachments' => ['sometimes', 'nullable', 'array'],
            'supporting_attachments.*' => ['sometimes', 'nullable', 'file', 'mimetypes:image/*,application/pdf'],
            'supporting_attachment_names' => ['sometimes', 'nullable', 'array'],
            'supporting_attachment_names.*' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }

    public function attributes()
    {
        return [
            'seller_id' => 'seller',
            'references' => 'reference',
            'references.*.name' => 'reference name',
            'references.*.phone_number' => 'reference phone number',
            'references.*.email' => 'reference email',
            'documents.*' => 'document',
            'document_names.*' => 'document name',
            'supporting_attachments.*' => 'supporting attachment',
            'supporting_attachments.*' => 'supporting attachment name',
        ];
    }
}
