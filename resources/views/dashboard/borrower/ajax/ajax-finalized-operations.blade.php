@php
    /* finalized operations */
    $total_finalized_doc_sold = $total_finalized_doc_sold_amount = 0;
    
    $finalized_doc_sold_data = $borrower_deals
        ->whereIn('offer_status', ['Approved','Completed'])
        ->where('is_disputed', 'No')
        ->pluck('operations')
        ->flatten();
    
    $total_finalized_doc_sold = $finalized_doc_sold_data->pluck('amount')->sum();
    
    $total_finalized_doc_accepted  = $total_finalized_doc_accepted_amount = 0;

    $total_finalized_doc_accepted = $borrower_deals
        ->whereIn('offer_status', ['Approved','Completed'])
        ->where('is_disputed', 'No')
        ->pluck('amount')
        ->sum();

    $finalized_doc_accepted_data = $borrower_deals
        ->whereIn('offer_status', ['Approved','Completed'])
        ->where('is_disputed', 'No');
       /*  ->pluck('operations')
        ->flatten(); */
    

$total_finalized_doc_sold_discount = $total_finalized_doc_sold_discount_pr = 0;

$total_finalized_doc_sold_discount = ($total_finalized_doc_sold - $total_finalized_doc_accepted); 

if($total_finalized_doc_sold_discount > 0 ) {
    $total_finalized_doc_sold_discount_pr = (($total_finalized_doc_sold_discount * 100) / $total_finalized_doc_sold ) ;
}
@endphp

<div class="icome-ajax-rightbox">
    <div class="income_lista_row">
        <div class="income_lista_col">
            <div class="income_lista_box">
                <div class="income_price">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_finalized_doc_sold) }}</div>
                <h4>{{ __('Total Documents Sold')}}</h4>
            </div>
        </div>
        <div class="income_lista_col">
            <div class="income_lista_box">
                <div class="income_price">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_finalized_doc_accepted) }}</div>
                <h4>{{ __('Total Offers Accepted') }}</h4>
            </div>
        </div>
        <div class="income_lista_col">
            <div class="income_lista_box error-txt">
                <div class="income_price" style="color: var(--m-text-red-color);">{{ round($total_finalized_doc_sold_discount_pr, 2) }}%</div>
                <h4>{{ __('Average Discount') }}</h4>
            </div>
        </div>
    </div>
    <div class="income_lista_bottom">
        <div class="income_lista_bottom_col">
            <div class="income_lista_bottom_blk active-txt">
                <div class="income_lista_title">
                    <h3>{{ __('Total Documents Sold') }}</h3>
                </div>
                <div class="content_wrap">
                    <div class="income_lista_left">
                        @forelse ($finalized_doc_sold_data as $finalized_doc_sold)
                            @php
                                $total_finalized_doc_sold_amount += $finalized_doc_sold->amount;
                            @endphp
                            <div class="cheque_part_row">
                                <div class="cheque_part_left">
                                    <div class="cheque_left_top evt_operations_details" data-operations-details-link="{{ route('operations.details', $finalized_doc_sold->slug) }}" role="button" title="Click More Details">
                                        <div class="cheque_left_top">
                                            <label for="cheque_check_1">{{ $finalized_doc_sold->operation_type_number }} - <span>{{ $finalized_doc_sold->seller->name }}</span></label>
                                        </div>
                                    </div>
                                    <div class="cheque_compnyname">{{ $finalized_doc_sold->issuer->company_name }}</div>
                                </div>
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $finalized_doc_sold->amount) }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="cheque_part_row">
                                <p>{{ __('No record found.') }} </p>
                            </div>
                        @endforelse
                    </div> 
                    <div class="total_count_income_wrap">
                        <div class="total_count_income">
                            <div class="total_count_income_title" style="color: var(--m-green-text);">
                                {{ __('Total')}}
                            </div>
                            <div class="total_count_income_total" style="color: var(--m-green-text);">
                                {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_finalized_doc_sold_amount) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="income_lista_bottom_blk">
                <div class="income_lista_title">
                    <h3>{!! __('Total Accepted Offers') !!}</h3>
                </div>
                <div class="content_wrap">
                    <div class="income_lista_left">
                        @forelse ($finalized_doc_accepted_data as $finalized_doc_accepted)
                            @php
                                $total_finalized_doc_accepted_amount += $finalized_doc_accepted->amount;
                            @endphp
                            <div class="cheque_part_row">
                                <div class="cheque_part_left">
                                    <div class="cheque_left_top evt_operations_details" data-operations-details-link="{{ route('operations.details', $finalized_doc_accepted->slug) }}" role="button" title="Click More Details">
                                        <label for="cheque_check_1">{{ $finalized_doc_accepted->operations->first()->operation_type_number }} - <span>{{ $finalized_doc_accepted->operations->first()->seller->name }}</span></label>
                                    </div>
                                    <div class="cheque_compnyname">{{ $finalized_doc_accepted->operations->first()->issuer->company_name }}</div>
                                </div>
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $finalized_doc_accepted->amount) }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="cheque_part_row">
                                <p>{{ __('No record found.') }} </p>
                            </div>
                        @endforelse
                    </div> 
                    <div class="total_count_income_wrap">
                        <div class="total_count_income">
                            <div class="total_count_income_title">
                                {{ __('Total')}}
                            </div>
                            <div class="total_count_income_total">
                                {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_finalized_doc_accepted_amount) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="income_grand_total income_lista_bottom_blk error-txt">
                <div class="income_lista_title">
                    <h3 style="color: var(--m-text-red-color);">{!! __('Discount Given Over Sold Operations') !!}</h3>
                </div>
                <div class="content_wrap">
                    <div class="total_count_income_wrap">
                        <div class="total_count_income totblack">
                            <div class="total_count_income_total text-rd">
                                {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], ($total_finalized_doc_sold_discount)) }}
                                {{-- {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], ($total_finalized_doc_sold - $total_finalized_doc_accepted)) }} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="income_lista_bottom_col scale_gr">
            <input type="hidden" name="line_chart_data" id="line_chart_data" data-line-chart-offer="{{ json_encode($line_chart_offers_data) }}" data-line-chart-operation="{{ json_encode($line_chart_operation_data) }}" data-line-chart-lable="{{json_encode($line_chart_lable) }}" />
            <div class="income_lista_chart_blk">
                <div class="income_lista_chart_img"  id="div_line_chart_finalized_operations_borrower">
                    <img src="{{ asset('images/risk-management-borrower-image.svg') }}" alt="">
                </div>
                <div class="income_lista_chart_table">
                    <table>
                        <tr>
                            <th><img src="{{ asset('images/mipo/pluse-mipo.svg') }}" alt=""></th>
                            <th>{{ __('Nominal value') }}</th>
                            <th>{{ __('Sale Value') }}</th>
                        </tr>
                        @forelse($dashboard_line_chart_table as $dashboard_line_chart_table_val)
                        <tr>
                            <th>{{ $dashboard_line_chart_table_val->operations->first()->operation_number }}</th>
                            <td>{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $dashboard_line_chart_table_val->operations->first()->amount) }}</td>
                            <td>{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $dashboard_line_chart_table_val->amount) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3"></td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>