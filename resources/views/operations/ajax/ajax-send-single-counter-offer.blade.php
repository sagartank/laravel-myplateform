@if(isset($offers) && !is_null($offers))
<div class="my_thirdopera">
    <div class="heading">
        <a href="javascript:;"><img src="{{ asset('images/mipo/dashboardsubpageleft.svg')}}" alt="no-image"></a>
        <h3 class="text-20-semibold">{!! __('My Operations') !!}</h3>
    </div>
    <div href="javascript:;" class="opera_oction">
        <div class="opera_leftpart">
            <div class="oction_head">
                <h6 class="text-14-medium">
                    {{ app('common')->lockOfferDetail($offers, ['buyer_name']) }}
                </h6>
            </div>
            <p class="text-14-medium">
                {{ app('common')->diffForHumans($offers->expires_at) }}
                {{-- {{ __(' Expire in')}} {{$offers->offer_expire_hour}} {{ __('hour')}} --}}
            </p>
        </div>
        <div class="opera_rightpart">
            <h6 class="text-14-medium">
                {{ app('common')->currencyBySymbol($offers->operations->first()->preferred_currency).''.app('common')->currencyNumberFormat($offers->operations->first()->preferred_currency, $offers->amount)}}
            </h6>
            <p class="text-14-medium">
                {{ __($offers->preferred_payment_method) }}
            </p>
            <div class="btnbox evt_hide_show_approved_reject_div">
                <a href="javascript:;" onclick="offerAcceptReject(this, 'Rejected')" data-offer-id="{{ $offers->id }}" class="rejectbtn text-14-medium add_offer_id">{!! __('Reject') !!}</a>
                <a href="javascript:;" onclick="offerAcceptReject(this, 'Approved')" data-offer-id="{{ $offers->id }}" class="approvebtn text-14-medium add_offer_id">{!! __('Approve') !!}</a>
            </div>
        </div>
    </div>

    <form action="{{route('counter-offer.ajax-save-counter-offer')}}" novalidate="novalidate" method="post" name="counter_offer_form" id="counter_offer_form">
        <input type="hidden" name="offer_id" id="select_offer_id" value="{{ $offers->id }}">
        <input type="hidden" name="offer_amount_hidden" id="offer_amount_hidden" value="{{ $offers->amount }}">
        <div class="counteroffer">
            <div class="counter-header">
                <h5 class="count-title text-16-medium">{!! __('Counteroffer') !!}</h5>
            </div>
            <div class="count-body">
                <div class="offerbox">
                {{--     <div class="offer_field">
                        <div class="title text-14-medium">{!! __('Retención') !!}</div>
                        <div class="inputfield">
                            <div class="ofr">
                                <input type="text" placeholder="{!! __('Retención') !!}">
                                <div class="gs"><img src="{{ asset('images/mipo/offdollartab.svg') }}" alt="no-image">
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="offer_field">
                        <div class="title text-14-medium">{!! __('Payment Method') !!}</div>
                        <div class="select">
                            <select name="counter_offer_payment_method" data-msg-required="{{ __('The payment method is required.') }}" required id="preferred_payment_method" class="form-select selectbox text-12-semibold init_nice_select">
                                @if(config('constants.PREFERRED_MODE'))
                                    @foreach (config('constants.PREFERRED_MODE') as $key => $val)
                                        <option value="{{$val}}"> {{ __($key) }} </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="offer_field">
                        <div class="title text-14-medium">{!! __('Offer Duration') !!}</div>
                        <div class="inputfield">
                            <div class="multifield">
                                <div class="ofrtime text-12-semibold">
                                    <input type="number" name="counter_offer_time" required id="counter_offer_time" minlength="1" maxlength="2" data-msg-required="The field is required." value="{{ config('constants.DEFAULT_OFFER_TIME')}}" placeholder="hour / days">
                                </div>
                                <div class="timeoption">
                                    <div class="select-dd">
                                        <select name="counter_offer_hour_day" id="counter_offer_hour_day" required data-msg-required="{{ __('The hour / day is required.') }}" class="form-select selectbox text-12-semibold init_nice_select">
                                            <option value="hour">{{ __('Hour') }}</option>
                                            <option value="day">{{ __('Days') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="offer_field">
                        <div class="title text-14-medium">{!! __('Offer Amount') !!}</div>
                        <div class="inputfield">
                            <div class="ofr">
                                <input type="text" name="counter_offer_amount" required id="counter_offer_amount" minlength="1" data-msg-required="{{ __('The amount is required.') }}" value="" data-currency-type="{{ ($offers->operations->first()?->preferred_currency) }}" placeholder="Amount" class="counter_offer_amount">
                                @if($offers->operations->first()->preferred_currency == 'USD')
                                    <div class="gs"><img src="{{ asset('images/mipo/offdollartab.svg') }}" alt="no-image"></div>
                                @else
                                    <div class="gs"><img src="{{ asset('images/mipo/guarani14.svg') }}" alt="no-image"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ftrbtm">
                <div class="count-footer">
                    <button type="button" class="text-14-medium view" data-bs-toggle="modal" data-bs-target="#offer_history_modal">{!! __('View Offer History') !!}<i><img src="{{ asset('images/mipo/arrowrightblue.svg') }}" alt="no-image"></i></button>
                    <input type="submit" id="btn_counter_offer" value="{!! __('Update Offer') !!}" class="updtofr text-14-medium cmd-btn-offer-sbm">
                    <div class="cmd-btn-offer-sbm-loader"></div>
                </div>
            </div>
        </div>
    </form>

    {{-- <div class="previously">
        <div class="imgbox">
            {!! __('Previously: Expires in') !!}
            {{$offers->offer_expire_hour}} {{ __('hour')}} -   {{ app('common')->currencyBySymbol($offers->operations->first()->preferred_currency).''.app('common')->currencyNumberFormat($offers->operations->first()->preferred_currency, $offers->amount)}}
            <i><img src="{{ asset('images/mipo/offtime.svg') }}" alt="no-image"></i>
        </div>
    </div> --}}
</div>

<div class="view-his-popup">
    <div class="modal fade" id="offer_history_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-20-medium">{!! __('Offer History') !!}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table>
                        <thead>
                            <tr class="forbg">
                                <th class="text-14-medium">{!! __('Offered By') !!}</th>
                                <th class="text-14-medium">{!! __('Offer Amount') !!}</th>
                                <th class="text-14-medium">{!! __('Retention') !!}</th>
                                <th class="text-14-medium">{!! __('Payment Method') !!}</th>
                                <th class="text-14-medium">{!! __('MIPO+') !!}</th>
                                <th class="text-14-medium">{!! __('Date and Time of Offer') !!}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($offers_histories->count() > 0)
                            @foreach ($offers_histories as $key => $offers_history)
                            <tr>
                                <td class="text-12-medium">
                                    @if($offers_history->created_by == Auth()->user()?->id)
                                    {{ __('You')}}
                                    {{-- <br> --}}
                                    @else
                                    {{ app('common')->lockOfferBy($offers_history->offer_by->name, ['offer_by']) }}
                                    {{-- <br> --}}
                                    @endif
                                    {{-- <span>{{ $offers_history->offer_status == 'Counter' ? 'Counter' : 'Pending' }}</span> --}}
                                </td>
                                <td class="text-12-medium">
                                    {{ app('common')->currencyBySymbol($offers->operations->first()->preferred_currency)}} {{ app('common')->currencyNumberFormat($offers->operations->first()->preferred_currency, $offers_history->amount) }}
                                </td>
                                <td class="text-12-medium">
                                    {{ app('common')->currencyBySymbol($offers->operations->first()->preferred_currency)}} {{ app('common')->currencyNumberFormat($offers->operations->first()->preferred_currency, $offers_history->retention) }} </td>
                                </td>
                                <td class="text-12-medium highlight">{{ __($offers_history->preferred_payment_method) }}</td>
                                <td class="text-12-medium">{{ __($offers_history->is_mipo_plus) }}</td>
                                <td class="text-12-medium">
                                    {{ $offers_history->offer_create_date_iso }}
                                {{--  <br>
                                    <span> {{ __('Expire in ')}} {{ $offers_history->offer_expire }} --}}
                                    {{-- </span> --}}
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="movi_popup_history">
        <div class="movi_header">
            <a href="javascript:;"><img src="{{ asset('images/mipo/dashboardsubpageleft.svg') }}" alt="no-image"></a>
            <h5 class="text-20-semibold">{!! __('Offer History') !!}</h5>
        </div>
        @if($offers_histories->count() > 0)
            @foreach ($offers_histories as $key => $offers_history)
                <div class="open_mobile_content">
                    <div class="mobile_lr">
                        <p class="text-16-medium">{!! __('Offered By') !!}</p>
                        <h6 class="text-16-medium">
                            @if($offers_history->created_by == Auth()->user()?->id)
                            {{ __('You')}}
                            {{-- <br> --}}
                            @else
                            {{ app('common')->lockOfferBy($offers_history->offer_by->name, ['offer_by']) }}
                            {{-- <br> --}}
                            @endif
                            {{-- <span>{{ $offers_history->offer_status == 'Counter' ? 'Counter' : 'Pending' }}</span> --}}
                        </h6>
                    </div>
                    <div class="mobile_lr">
                        <p class="text-16-medium">{!! __('Offer Amount') !!}</p>
                        <h6 class="text-16-medium">
                            {{ app('common')->currencyBySymbol($offers->operations->first()->preferred_currency)}} {{ app('common')->currencyNumberFormat($offers->operations->first()->preferred_currency, $offers_history->amount) }}
                        </h6>
                    </div>
                    <div class="mobile_lr">
                        <p class="text-16-medium">{!! __('Retention') !!}</p>
                        <h6 class="text-16-medium">
                            {{ app('common')->currencyBySymbol($offers->operations->first()->preferred_currency)}} {{ app('common')->currencyNumberFormat($offers->operations->first()->preferred_currency, $offers_history->retention) }} 
                        </h6>
                    </div>
                    <div class="mobile_lr">
                        <p class="text-16-medium">{!! __('Payment Method') !!}</p>
                        <h6 class="text-16-medium">
                            {{ __($offers_history->preferred_payment_method) }}
                        </h6>
                    </div>
                    <div class="mobile_lr">
                        <p class="text-16-medium">{!! __('MIPO+') !!}</p>
                        <h6 class="text-16-medium">
                            {{ __($offers_history->is_mipo_plus) }}
                        </h6>
                    </div>
                    <div class="mobile_lr">
                        <p class="text-16-medium">{!! __('Date and Time of Offer') !!}</p>
                        <h6 class="text-16-medium">
                            {{ $offers_history->offer_create_date_iso }}
                        </h6>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endif
