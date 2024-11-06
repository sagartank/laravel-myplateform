@if($offers && $offers->count() > 0)
@foreach ($offers->groupBy('buyer_id') as $key => $offers_vals)
<div class="form_offered_oprt_grp">
    <div class="form_offered_oprt_grp_part heilight">
        <span class="name_chaque_form_offered">{{ __('GROUP OFFER') }} {{ $offers_vals->first()->operation_number}} - {{ $offers_vals->first()->buyer_name }}</span>
        <span class="hour_form_offered">{{ __('Mixed') }}</span>
    </div>
    @foreach ($offers_vals as $key => $offer)
    <div class="form_offered_oprt_grp_part">
        <span class="name_chaque_form_offered">{{$offer->operation_type}} - {{$offer->operation_number}}</span>
        <span class="hour_form_offered">{{ __($offer->preferred_payment_method) }}</span>
        <span class="brand_form_offered">{{$offer->issuer_company_type}}</span>
        <span class="price_form_offered">{{ app('common')->currencyBySymbol($offer->preferred_currency) }}{{$offer->operations_amount}}</span>
        <span class="hour_form_offered">Expire in {{$offer->offer_expire_days}} {{ __('days') }}</span>
    </div>
@endforeach
</div>
@endforeach
@endif