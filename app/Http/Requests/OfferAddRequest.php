<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class OfferAddRequest extends FormRequest
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
        $deal_mode = implode(',', config('constants.PREFERRED_MODE'));
        $offer_type = Request::get('offer_type');
        if($offer_type === 'Group') {
            return [
                'offer_type' => 'required|in:Group,Single',
                'offer_day_hour' => 'required|in:day,hour',
                'operation_id' => 'required',
                'deal_mode' => 'required|in:'.$deal_mode,
                'operation_amount' => 'required',
                'retention' => 'nullable|lt:operation_amount|lt:offer_amount',
                'offer_amount' => 'required|lt:operation_amount',
                'is_group' => 'required:|in:true'
                // 'operation_form.*.operaion_retention' => 'nullable|lt:operation_form.*.operaion_amount|lt:operation_form.*.operaion_offer_amount',
                // 'operation_form.*.operaion_offer_amount' => 'nullable|lt:operation_form.*.operaion_amount',
            ];
        } else {
            return [
                'offer_type' => 'required|in:Group,Single',
                'offer_day_hour' => 'required|in:day,hour',
                'operation_id' => 'required',
                'deal_mode' => 'required|in:'.$deal_mode,
                'operation_amount' => 'required',
                'retention' => 'nullable|lt:operation_amount|lt:offer_amount',
                'offer_amount' => 'required|lt:operation_amount',
            ];
        }
    }

    public function messages()
    {
        return [
            // 'operation_form.*.operaion_retention.lt' => 'Offer Amount is required',
            // 'operation_form.*.operaion_offer_amount.lt' => 'Offer Amount is required',
        ];
    }

    public function attributes()
    {
        return [
         /*    'offer_type' => 'Offer Type',
            'offer_day_hour' => 'Select Hour / Day',
            'deal_mode' => 'Select DEAL MODE',
            'operation_amount' => 'Operation Amount',
            'retention' => 'Retention',
            'offer_amount' => 'Offer Amount', */
            'operation_form.*' => 'operación',
            'operation_form.*.operaion_retention' => 'retención',
            'operation_form.*.operaion_offer_amount' => 'monto de ofertar',
        ];
    }
}
