@php
$user_type = 'buyer';
$user_type_th = 'SELLER';
if ($req_param['preferred_dashboard'] == 'Borrower') {
    $user_type = 'seller';
    $user_type_th = 'BUYER';
}
@endphp
<table class="table">
    <thead>
        <tr>
            <th>{{ __('OPERATION') }}</th>
            <th>{{ __($user_type_th) }} </th>
            <th>{{ __('EXPIRATION') }}</th>
            <th>{{ __('STATUS') }} </th>
        </tr>
    </thead>

    <tbody>
      
        @if ($update_deals && $update_deals->count() > 0)
            @foreach ($update_deals as $update_deal)
                <tr class="evt_deals_details"  data-deals-details-link="{{ route('deals.details', [$update_deal->slug, $user_type]) }}"
                    role="button" title="Click More Details">
                    <td>
                        <div class="opr_wrap">
                            @if ($update_deal->offer_type == 'Single')
                                @if ($update_deal->operations->first()->operation_type == 'Cheque')
                                    <i class="icon"><img src="{{ asset('images/sign-icon.svg') }}" alt="no-image"></i>
                                @elseif($update_deal->operations->first()->operation_type == 'Contract')
                                    <i class="icon"><img src="{{ asset('images/contract-icon.svg') }}"
                                            alt="no-image"></i>
                                @elseif($update_deal->operations->first()->operation_type == 'Invoice')
                                    <i class="icon"><img src="{{ asset('images/invoice-icon.svg') }}"
                                            alt="no-image"></i>
                                @else
                                    <i class="icon"><img src="{{ asset('images/bond-icon.svg') }}" alt="no-image"></i>
                                @endif
                            @elseif($update_deal->offer_type == 'Group')
                                <i class="icon"><img src="{{ asset('images/bond-icon.svg') }}" lt="no-image"></i>
                            @endif
                            <div class="text">
                                @if ($update_deal->offer_type == 'Single')
                                    <span>
                                        {{ $update_deal->operations->first()->operation_type_number }}
                                    </span>
                                @endif

                                @if ($update_deal->offer_type == 'Group')
                                    <span>{{ __('Group Offer') }}</span>
                                @endif
                                <p>
                                    {{ app('common')->currencyBySymbol($req_param['currency_type']) }}{{ app('common')->currencyNumberFormat($req_param['currency_type'], $update_deal->operations->first()->amount) }}
                                </p>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="name_box">
                            <span class="image">
                                <img width="50" src="{{ $update_deal->buyer->profile_image_url }}" alt="no-image">
                            </span>
                            <strong>{{ $update_deal->buyer->name }}</strong>
                            <span class="dot" style="background-color: var(--m-background-blue);"></span>
                        </div>
                    </td>

                    <td>
                        <div class="date_box" title="{{$update_deal->offer_status}}">
                            <p>{{ $update_deal->offer_expire_date_iso }}</p>
                            {{-- @if ($update_deal->is_disputed == 'No' && $update_deal->offer_status == 'Completed')
                                <i class="icon"><img src="{{ asset('images/stack-icon.svg') }}" alt="no-image"></i>
                            @elseif ($update_deal->is_disputed == 'No')
                                <i class="icon"><img src="{{ asset('images/bag-icon.svg') }}" alt="no-image"></i>
                            @elseif($update_deal->is_disputed == 'Yes')
                                <i class="icon"><img src="{{ asset('images/disable-icon.svg') }}" alt="no-image"></i>
                            @endif --}}
                        </div>
                    </td>

                    <td>
                        <div class="status-box">
                            <p>{{$update_deal->offer_status}}</p>
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4">
                    <p class="text-center font-weight-bold text-danger mt-3">
                        {!! __('No Record Found.') !!}
                    </p>
                </td>
            </tr>
        @endif
    </tbody>
</table>

<div class="mobile_deals_table">
    <div class="deal_headbody">
        <h5 class="text-14-medium">{!! __('CHEQUE - OP25') !!}</h5>
        <div class="deal_mobile_content">
            <div class="delr_mobile_wrap">
                <p class="text-16-medium">{!! __('OPERATION') !!}</p>
                <h6 class="text-16-medium">{!! __('0') !!}</h6>
            </div>
            <div class="delr_mobile_wrap">
                <p class="text-16-medium">{!! __('SELLER') !!}</p>
                <h6 class="text-16-medium">{!! __('Martin Jeferson') !!}</h6>
            </div>
            <div class="delr_mobile_wrap">
                <p class="text-16-medium">{!! __('EXPIRATION') !!}</p>
                <h6 class="text-16-medium">{!! __('00 June 0000') !!}</h6>
            </div>
            <div class="delr_mobile_wrap">
                <p class="text-16-medium">{!! __('STATUS') !!}</p>
                <h6 class="text-16-medium">{!! __('Pending Signature') !!}</h6>
            </div>
        </div>
    </div>
    <div class="deal_headbody">
        <h5 class="text-14-medium">{!! __('CHEQUE - OP25') !!}</h5>
        <div class="deal_mobile_content">
            <div class="delr_mobile_wrap">
                <p class="text-16-medium">{!! __('OPERATION') !!}</p>
                <h6 class="text-16-medium">{!! __('0') !!}</h6>
            </div>
            <div class="delr_mobile_wrap">
                <p class="text-16-medium">{!! __('SELLER') !!}</p>
                <h6 class="text-16-medium">{!! __('Martin Jeferson') !!}</h6>
            </div>
            <div class="delr_mobile_wrap">
                <p class="text-16-medium">{!! __('EXPIRATION') !!}</p>
                <h6 class="text-16-medium">{!! __('00 June 0000') !!}</h6>
            </div>
            <div class="delr_mobile_wrap">
                <p class="text-16-medium">{!! __('STATUS') !!}</p>
                <h6 class="text-16-medium">{!! __('Pending Signature') !!}</h6>
            </div>
        </div>
    </div>
</div>