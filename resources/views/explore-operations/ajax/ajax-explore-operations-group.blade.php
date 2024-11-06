<div class="tab-pane fade" id="amedlr" role="tabpanel" aria-labelledby="amedlr-tab">
    <div class="tabDetail_wrap">
        <div class="index_oprow">
            <div class="opration text-14-medium">{!! __('Operation') !!}</div>
            <div class="opration_col text-14-medium">
                <ul>
                    <li>{!! __('Retention') !!}</li>
                    <li>{!! __('Payment Method') !!}</li>
                    <li>{!! __('Validity of Offer') !!}</li>
                    <li>{!! __('Offer') !!}</li>
                </ul>
            </div>
        </div>
        <div class="billbox">
            @foreach ($operations->where('preferred_currency', 'USD')->groupBy('seller_id') as $seller => $seller_groups)
                @php
                    $total_operation_amount = $total_miop_operation_amount = 0;
                    $seller_group_first  = $seller_groups->first();
                @endphp
                <div class="table_content evt_div_group_by_seller row_seller_name_remove_{{$seller_group_first->seller_id}}" data-currency-type="USD" data-mipo-verified="{{$seller_group_first->mipo_verified}}" id="row_seller_name_remove_{{$seller_group_first->seller_id}}" data-operation-id="{{$seller_group_first->id}}" data-seller-name="{{$seller_group_first->seller->name}}" data-seller-id="{{$seller_group_first->seller_id}}">
                    <div class="infobox">
                        <div class="namebox">
                            <h3 class="text-16-semibold">{{ app('common')->lockOperationDetail($seller_group_first, []) }}</h3>
                            {{-- <img src="{{ asset('images/mipo/singlestr.png') }}" alt="no-image">
                            <span>{!! __('4.5/5 (50)') !!}</span> --}}
                        </div>
                    </div>
                </div>
                @foreach ($seller_groups->groupBy('mipo_verified') as $mipo => $mipo_groups)
                    @foreach ($mipo_groups as $mipo_index => $mipo)
                        @if ($mipo->mipo_verified == 'Yes')
                            @php
                                $total_miop_operation_amount += $mipo->amount;
                            @endphp
                            <x-single-mipo-offer-button :operation="$mipo" currency="USD"></x-single-mipo-offer-button>
                            @if ($loop->last)
                            <x-group-mipo-offer-button :operation="$mipo" :total_miop_operation_amount="$total_miop_operation_amount" currency="USD"></x-group-mipo-offer-button>
                            @endif
                        @elseif($mipo->mipo_verified == 'No')
                            @php
                                $total_operation_amount += $mipo->amount;
                            @endphp
                            <x-single-offer-button :operation="$mipo" currency="USD"></x-single-offer-button>
                            @if ($loop->last)
                                <x-group-offer-button :operation="$mipo" :total_operation_amount="$total_operation_amount" currency="USD"> </x-group-offer-button>
                            @endif
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        </div>
    </div>
</div>

<div class="tab-pane fade show active" id="gugs" role="tabpanel" aria-labelledby="gugs-tab">
    <div class="tabDetail_wrap">
        <div class="index_oprow">
            <div class="opration text-14-medium">{!! __('Operation') !!}</div>
            <div class="opration_col text-14-medium">
                <ul>
                    <li>{!! __('Retention') !!}</li>
                    <li>{!! __('Payment Method') !!}</li>
                    <li>{!! __('Validity of Offer') !!}</li>
                    <li>{!! __('Offer') !!}</li>
                </ul>
            </div>
        </div>

        <div class="billbox">
            @foreach ($operations->where('preferred_currency', 'Gs.')->groupBy('seller_id') as $seller => $seller_groups)
                @php
                    $total_operation_amount = $total_miop_operation_amount = 0;
                    $seller_group_first  = $seller_groups->first();
                @endphp
                <div class="table_content evt_div_group_by_seller row_seller_name_remove_{{$seller_group_first->seller_id}}" data-currency-type="Gs." data-mipo-verified="{{$seller_group_first->mipo_verified}}" id="row_seller_name_remove_{{$seller_group_first->seller_id}}" data-operation-id="{{$seller_group_first->id}}" data-seller-name="{{$seller_group_first->seller->name}}" data-seller-id="{{$seller_group_first->seller_id}}">
                    <div class="infobox">
                        <div class="namebox">
                            <h3 class="text-16-semibold">{{ app('common')->lockOperationDetail($seller_group_first, []) }}</h3>
                            {{-- <img src="{{ asset('images/mipo/singlestr.png') }}" alt="no-image">
                            <span>{!! __('4.5/5') !!}</span> --}}
                        </div>
                    </div>
                </div>
                @foreach ($seller_groups->groupBy('mipo_verified') as $mipo => $mipo_groups)
                    @foreach ($mipo_groups as $mipo_index => $mipo)
                        @if ($mipo->mipo_verified == 'Yes')
                            @php
                                $total_miop_operation_amount += $mipo->amount;
                            @endphp
                            <x-single-mipo-offer-button :operation="$mipo" currency="Gs."></x-single-mipo-offer-button>
                            @if ($loop->last)
                            <x-group-mipo-offer-button :operation="$mipo" :total_miop_operation_amount="$total_miop_operation_amount" currency="Gs."></x-group-mipo-offer-button>
                            @endif
                        @elseif($mipo->mipo_verified == 'No')
                            @php
                                $total_operation_amount += $mipo->amount;
                            @endphp
                            <x-single-offer-button :operation="$mipo" currency="Gs."></x-single-offer-button>
                            @if ($loop->last)
                                <x-group-offer-button :operation="$mipo" :total_operation_amount="$total_operation_amount" currency="Gs."> </x-group-offer-button>
                            @endif
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="mdl_close text-18-medium" data-bs-dismiss="modal">{!! __('Close') !!}</button>
    <button type="button" onclick="placeOffer(this)" class="btn btn-primary bigofr">{!! __('OFFER') !!}</button>
</div>

{{-- summary:st --}}
<div class="grp_oprt_summary">
    <div class="grp_oprt_summary_row">
        <div class="grp_oprt_summary_col">
            <div class="grp_oprt_summary_box">
                <div class="grp_oprt_summary_title text-20-medium">{!! __('Individual Operation Summary') !!}</div>
                <div class="grp_oprt_summary_block">
                    <div class="name_grp_oprt text-16-medium" id="add_seller_name">{!! __('Arya Kagathara') !!}</div>
                    <div class="grp_oprt_summary_dtlblk text-14-medium">
                        <div class="grp_oprt_summary_heading cqno inline_row">
                            <span id="add_chk_number">-</span>&nbsp;
                            <span id="payment_opt">-</span>&nbsp
                            <span id="add_company_name">-</span>
                        </div>
                        <div class="grp_oprt_summary_dtl inline_row"><span id="current_operation_amount">0</span><span class="add_currency_js">{{ app('common')->currencyBySymbol($currency_name) }}</span></div>
                    </div>

                    <div class="grp_oprt_summary_dtlblk text-14-medium">
                        <div class="grp_oprt_summary_heading"><span>{!! __('Retention') !!}</span></div>
                        <div class="grp_oprt_summary_dtl inline_row"><span id="current_rentention_amount">0</span><span class="add_currency_js">{{ app('common')->currencyBySymbol($currency_name) }}</span></div>
                    </div>
                    <div class="grp_oprt_summary_dtlblk text-14-medium">
                        <div class="grp_oprt_summary_heading"><span>{!! __('Real Time Offer') !!}</span></div>
                        <div class="grp_oprt_summary_dtl inline_row"><span id="current_real_time_offer">0</span><span class="add_currency_js">{{ app('common')->currencyBySymbol($currency_name) }}</span></div>
                    </div>
                    <div class="grp_oprt_summary_dtlblk text-14-medium">
                        <div class="grp_oprt_summary_heading"><span>{{ __('Mipo Commission ('.$investor_commission.'%)') }}</div>
                        <div class="grp_oprt_summary_dtl inline_row"><span id="current_mipo_commission">0</span><span class="add_currency_js">{{ app('common')->currencyBySymbol($currency_name) }}</span></div>
                    </div>
                    <div class="grp_oprt_summary_dtlblk text-14-medium">
                        <div class="grp_oprt_summary_heading"><span>{{ __('Guaranteed Payment MIPO+ ('.$mipo_commission.'%)') }}</span></div>
                        <div class="grp_oprt_summary_dtl inline_row"><span id="current_add_mipo_commission">0</span><span class="add_currency_js">{{ app('common')->currencyBySymbol($currency_name) }}</span></div>
                    </div>
                    <div class="grp_oprt_summary_dtlblk sum_ftr text-16-medium">
                        <div class="grp_oprt_summary_heading"><span>{!! __('Net Profit') !!}</span></div>
                        <div class="grp_oprt_summary_dtl inline_row"><span id="current_net_profit">0</span><span class="add_currency_js">{{ app('common')->currencyBySymbol($currency_name) }}</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grp_oprt_summary_col">
            <div class="grp_oprt_summary_box">
                <div class="grp_oprt_summary_title text-20-medium">{!! __('Overall Operation Summary') !!}</div>
                <div class="grp_oprt_summary_block">
                    <div class="name_grp_oprt text-16-medium ">{!! __('Offer Totals') !!}</div>
                    <div class="grp_oprt_summary_dtlblk text-14-medium">
                        <div class="grp_oprt_summary_heading cqno"><span>{!! __('Group Offer - OP001') !!}</span></div>
                        <div class="grp_oprt_summary_dtl inline_row"><span id="overall_operation_total">0 </span><span class="add_currency_js">{{ app('common')->currencyBySymbol($currency_name) }}</span></div>
                    </div>

                    <div class="grp_oprt_summary_dtlblk text-14-medium">
                        <div class="grp_oprt_summary_heading"><span>{!! __('Retention') !!}</span></div>
                        <div class="grp_oprt_summary_dtl inline_row"><span id="overall_retention_total">0 </span><span class="add_currency_js">{{ app('common')->currencyBySymbol($currency_name) }}</span></div>
                    </div>
                    <div class="grp_oprt_summary_dtlblk text-14-medium">
                        <div class="grp_oprt_summary_heading"><span>{!! __('Real Time Offer') !!}</span></div>
                        <div class="grp_oprt_summary_dtl inline_row"><span id="overall_real_time_total">0 </span><span class="add_currency_js">{{ app('common')->currencyBySymbol($currency_name) }}</span></div>
                    </div>
                    <div class="grp_oprt_summary_dtlblk text-14-medium">
                        <div class="grp_oprt_summary_heading"><span>{{ __('Mipo Commission ('.$investor_commission.'%)') }}</span></div>
                        <div class="grp_oprt_summary_dtl inline_row"><span id="overall_mipo_commission">0 </span><span class="add_currency_js">{{ app('common')->currencyBySymbol($currency_name) }}</span></div>
                    </div>
                    <div class="grp_oprt_summary_dtlblk text-14-medium">
                        <div class="grp_oprt_summary_heading"><span>  {{ __('Guaranteed Payment MIPO+ ('.$mipo_commission.'%)') }}</span></div>
                        <div class="grp_oprt_summary_dtl inline_row"><span id="overall_add_mipo_commission">0 </span><span class="add_currency_js">{{ app('common')->currencyBySymbol($currency_name) }}</span></div>
                    </div>
                    <div class="grp_oprt_summary_dtlblk sum_ftr text-16-medium">
                        <div class="grp_oprt_summary_heading"><span>{!! __('Beneficio neto') !!}</span></div>
                        <div class="grp_oprt_summary_dtl inline_row"><span id="overall_net_profit">0 </span><span class="add_currency_js">{{ app('common')->currencyBySymbol($currency_name) }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- summary:nd --}}
