@php
$current_date = date('Y-m-d 11:00:00');
$total_invested = 0;
/*section 1*/
$total_sold = $total_sold_paid = $total_pending_payment_receipt = 0;
$total_documents_sold = $total_op_sold_collected = $total_op_sold_pending_collection = 0;

$sold_data = $borrower_deals
    ->whereIn('offer_status', ['Approved','Completed'])
    ->where('is_disputed', 'No')
    ->pluck('operations')
    ->flatten();

$total_documents_sold = $sold_data->sum('amount');

$total_op_sold_collected = $borrower_deals->whereIn('offer_status', ['Approved','Completed'])->where('is_disputed', 'No')
    ->filter(function ($model_name) {
            return ($model_name->is_cashed_seller == 'Yes' || $model_name->is_qr_code_seller == 'Yes');
    })->sum('amount');

$total_op_sold_pending_collection = $borrower_deals->whereIn('offer_status', ['Approved','Completed'])->where('is_disputed', 'No')
    ->filter(function ($model_name) {
            return ($model_name->is_cashed_seller == 'No' && $model_name->is_qr_code_seller == 'No');
    })->sum('amount');

$total_expired_documents = 0;
$total_expired_documents = $borrower_deals->whereIn('offer_status', ['Pending'])->pluck('operations')->where('expiration_date', '<', $current_date)->flatten()->pluck('amount')->sum();

$total_open_disputes = 0;
$total_open_disputes = $borrower_deals->whereIn('offer_status', ['Approved'])->where('is_disputed', 'Yes')->pluck('amount')->sum();

$total_sold_paid = $borrower_deals
    ->whereIn('offer_status', ['Approved','Completed'])
    ->where('is_disputed', 'No')
    ->where('is_cashed_buyer', 'Yes')
    ->where('is_cashed_seller', 'Yes')
    ->pluck('amount')
    ->sum();

$total_pending_payment_receipt = $borrower_deals
    ->whereIn('offer_status', ['Approved'])
    ->where('is_disputed', 'No')
    ->where('is_cashed_buyer', 'No')
    ->where('is_cashed_seller', 'No')
    ->pluck('amount')
    ->sum();

    /*section 2*/
$total_documents_due = $total_uncashable = $total_disputes = 0;

$total_documents_due = $borrower_deals
    ->whereIn('offer_status', ['Approved'])
    ->where('is_cashed_buyer', 'No')
    ->where('deals_documents_count', '=', 0)
    ->pluck('operations')
    ->flatten()
    ->sum('amount');

$total_uncashable = $borrower_deals
        ->whereIn('offer_status', ['Approved', 'Completed'])
        ->where('is_cashed_buyer', 'No')
        ->where('deals_documents_count', '=', 0)
        ->sum('amount');

$total_disputes = $borrower_deals
    ->whereIn('offer_status', ['Approved','Completed'])
    ->where('is_disputed', 'Yes')
    ->pluck('amount')
    ->sum();

/*section 3 table  list*/
$total_sold_paid_amount = $total_pending_payment_receipt_amount = $total_documents_due_amount =  $total_uncashable_amount = $total_disputes_amount = 0;

/*
    sold_paid_data as Total Operations Sold Pending Collection
    pending_payment_receipt_data as Total Operations Sold Pending Collection
    documents_due_data as Documents Sold with Recurso Pending Collection
    uncashable_data as Documents Sold with Expired Appeal,
    disputes_data as total_open_disputes,
*/
$sold_paid_data = $borrower_deals->whereIn('offer_status', ['Approved','Completed'])->where('is_disputed', 'No')
->filter(function ($model_name) {
            return ($model_name->is_cashed_seller == 'Yes' || $model_name->is_qr_code_seller == 'Yes');
    })->all();

$pending_payment_receipt_data = $borrower_deals->whereIn('offer_status', ['Approved'])->where('is_disputed', 'No')
->filter(function ($model_name) {
            return ($model_name->is_cashed_seller == 'Yes' || $model_name->is_qr_code_seller == 'Yes');
    })->all();

$documents_due_data = $borrower_deals->whereIn('offer_status', ['Approved'])->where('is_qr_code_seller', 'No');

$uncashable_data = $borrower_deals->whereIn('offer_status', ['Pending'])->pluck('operations')->unique('operation_id')->where('expiration_date', '<', $current_date)->flatten();

$disputes_data = $borrower_deals->whereIn('offer_status', ['Approved'])->where('is_disputed', 'Yes')->pluck('operations')->flatten();

$total_pending_buyer_collection = $borrower_deals->whereIn('offer_status', ['Approved'])->sum('amount');
@endphp


<div class="icome-lista-rightbox">
    <div class="income_lista_row">
        <div class="income_lista_col">
            <div class="income_lista_box active-txt">
                <div class="income_price">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_documents_sold) }}</div>
                <h4>{!! __('Sold Documents') !!}</h4>
            </div>
        </div>
        <div class="income_lista_col">
            <div class="income_lista_box active-txt">
                <div class="income_price">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_op_sold_collected) }}</div>
                <h4>{!! __('Sold Documents Cashed') !!}</h4>
            </div>
        </div>
        <div class="income_lista_col">
            <div class="income_lista_box error-txt">
                <div class="income_price" style="color: var(--m-text-red-color);">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_documents_sold) }}</div>
                <h4>{!! __('Sold Documents Pending Cashing') !!}</h4>
            </div>
        </div>
        <div class="income_lista_col">
            <div class="income_lista_box waiting-txt">
                <div class="income_price" style="color: var(--m-text-yellow-color);">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_documents_sold) }}</div>
                <h4>{!! __('Sold w/Recurso Pend Buyers Cashing') !!}</h4>
            </div>
        </div>
        <div class="income_lista_col">
            <div class="income_lista_box error-txt">
                <div class="income_price" style="color: var(--m-text-red-color);">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_expired_documents) }}</div>
                <h4>{!! __('Due Documents') !!}</h4>
            </div>
        </div>
        <div class="income_lista_col">
            <div class="income_lista_box error-txt">
                <div class="income_price" style="color: var(--m-text-red-color);">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_open_disputes) }}</div>
                <h4>{!! __('Total Open Disputes') !!}</h4>
            </div>
        </div>
    </div>

    <div class="income_lista_bottom">
        <div class="income_lista_bottom_col">
            <div class="income_lista_chart_blk">
                <div class="income_lista_chart_img" style="margin: 24px 0 0 0;" id="treeMap_chart_data">
                    {{-- <img src="{{ asset('images/mipo/inother.png') }}" alt="no-image" style="width: 100%;"> --}}
                </div>
            </div>
        </div>
        <div class="income_lista_bottom_col">
            <div class="income_lista_bottom_blk active-txt">
                <div class="income_lista_title">
                    <h3 style="color: var(--m-text-black);">{!! __('Total Sold Documents Cashed') !!}</h3>
                </div>
                <div class="content_wrap">
                    <div class="income_lista_left">
                        @forelse ($sold_paid_data as $sold_paid)
                            @php
                                $total_sold_paid_amount += $sold_paid->amount;
                            @endphp
                            <div class="cheque_part_row">
                                <div class="cheque_part_left">
                                    <a href="#">
                                        <div class="cheque_left_top">
                                            <label for="cheque_check_1">{{ $sold_paid->operations->first()->operation_type_number }}
                                                - <span>{{ $sold_paid->operations->first()->seller->name }}</span></label>
                                        </div>
                                        <div class="cheque_compnyname">{{ $sold_paid->operations->first()->issuer->company_name }}</div>
                                    </a>
                                </div>
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $sold_paid->amount) }}
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
                                {{ __('Total') }}
                            </div>
                            <div class="total_count_income_total">
                                {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_sold_paid_amount) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="income_lista_bottom_blk error-txt">
                <div class="income_lista_title">
                    <h3 style="color: var(--m-text-black);">{!! __('Total Sold Documents Pending Cashing') !!}</h3>
                </div>
                <div class="content_wrap">
                    <div class="income_lista_left">
                        @forelse ($pending_payment_receipt_data as $pending_payment_receipt)
                            @php
                                $total_pending_payment_receipt_amount += ($pending_payment_receipt->amount);
                                // $total_pending_payment_receipt_amount += ($pending_payment_receipt->operations->first()->amount - $pending_payment_receipt->amount);
                            @endphp
                            <div class="cheque_part_row">
                                <div class="cheque_part_left">
                                    <a href="#">
                                        <div class="cheque_left_top">
                                            <label for="cheque_check_1">{{ $pending_payment_receipt->operations->first()->operation_type_number }}
                                                - <span>{{ $pending_payment_receipt->operations->first()->seller->name }}</span></label>
                                        </div>
                                        <div class="cheque_compnyname">{{ $pending_payment_receipt->operations->first()->issuer->company_name }}</div>
                                    </a>
                                </div>
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], ($pending_payment_receipt->operations->first()->amount - $pending_payment_receipt->amount)) }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="cheque_part_row">
                                <p>{!! __('No record found.') !!} </p>
                            </div>
                        @endforelse
                    </div> 
                    <div class="total_count_income_wrap">
                        <div class="total_count_income">
                            <div class="total_count_income_title inbl_text">
                                {{ __('Total') }}
                            </div>
                            <div class="total_count_income_total inblack_text">
                                {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_pending_payment_receipt_amount) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="income_lista_bottom_blk waiting-txt">
                <div class="income_lista_title">
                    <h3 style="color: var(--m-text-black);">{!! __('Total Sold Documents Pending Buyers Cashing') !!}</h3>
                </div>
                <div class="content_wrap">
                    <div class="income_lista_left">
                        @forelse ($documents_due_data as $documents_due)
                            @php
                                // $total_documents_due_amount += $documents_due->amount;
                                $total_documents_due_amount += $documents_due->operations->first()->amount;
                            @endphp
                            <div class="cheque_part_row">
                                <div class="cheque_part_left">
                                    <a href="#">
                                        <div class="cheque_left_top">
                                            <label for="cheque_check_1">{{ $documents_due->operations->first()->operation_type_number }}
                                                - <span>{{ $documents_due->operations->first()->seller->name }}</span></label>
                                        </div>
                                        <div class="cheque_compnyname">{{ $documents_due->operations->first()->issuer->company_name }}</div>
                                    </a>
                                </div>
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $documents_due->operations->first()->amount) }}
                                        {{-- {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $documents_due->amount) }} --}}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="cheque_part_row">
                                <p>{!! __('No record found.') !!} </p>
                            </div>
                        @endforelse
                    </div> 
                    <div class="total_count_income_wrap">
                        <div class="total_count_income">
                            <div class="total_count_income_title" style="color: var(--m-text-yellow-color);">
                                {{ __('Total') }}
                            </div>
                            <div class="total_count_income_total" style="color: var(--m-text-yellow-color);">
                                {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_documents_due_amount) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="income_lista_bottom_blk error-txt">
                <div class="income_lista_title">
                    <h3 style="color: var(--m-text-red-color);">{!! __('Total Documents Sold with Recurso Due') !!}</h3>
                </div>
                <div class="content_wrap">
                    <div class="income_lista_left">
                        @forelse ($uncashable_data as $uncashable)
                            @php
                                $total_uncashable_amount += $uncashable->amount;
                            @endphp
                            <div class="cheque_part_row">
                                <div class="cheque_part_left">
                                    <a href="#">
                                        <div class="cheque_left_top">
                                            <label for="cheque_check_1">{{ $uncashable->operation_type_number }}
                                                - <span>{{ $uncashable->seller->name }}</span></label>
                                        </div>
                                        <div class="cheque_compnyname">{{ $uncashable->issuer->company_name }}</div>
                                    </a>
                                </div>
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $uncashable->amount) }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="cheque_part_row">
                                <p>{!! __('No record found.') !!} </p>
                            </div>
                        @endforelse
                    </div> 
                    <div class="total_count_income_wrap">
                        <div class="total_count_income">
                            <div class="total_count_income_title" style="color: var(--m-text-red-color);">
                                {{ __('Total') }}
                            </div>
                            <div class="total_count_income_total" style="color: var(--m-text-red-color);">
                                {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_uncashable_amount) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="income_lista_bottom_blk error-txt">
                <div class="income_lista_title">
                    <h3 style="color: var(--m-text-red-color);">{!! __('Total Open Disputes') !!}</h3>
                </div>
                <div class="content_wrap">
                    <div class="income_lista_left">
                        @forelse ($disputes_data as $disputes)
                            @php
                                $total_disputes_amount += $disputes->amount;
                            @endphp
                            <div class="cheque_part_row">
                                <div class="cheque_part_left">
                                    <a href="#">
                                        <div class="cheque_left_top">
                                            <label for="cheque_check_1">{{ $disputes->operation_type_number }}
                                                - <span>{{ $disputes->seller->name }}</span></label>
                                        </div>
                                        <div class="cheque_compnyname">{{ $disputes->issuer->company_name }}</div>
                                    </a>
                                </div>
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $disputes->amount) }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="cheque_part_row">
                                <p>{!! __('No record found.') !!} </p>
                            </div>
                        @endforelse
                    </div> 
                    <div class="total_count_income_wrap">
                        <div class="total_count_income">
                            <div class="total_count_income_title" style="color: var(--m-text-red-color);">
                                {{ __('Total') }}
                            </div>
                            <div class="total_count_income_total" style="color: var(--m-text-red-color);">
                                {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_disputes_amount) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="income_lista_bottom_col">
            <input type="hidden" name="pie_chart_data" id="pie_chart_data"
                data-currency-name="{{ $req_param['currency_type'] }}"
                data-document_dues-amount="{{ $total_documents_due_amount }}"
                data-uncashable-amount="{{ $total_uncashable_amount }}"
                data-disputes-amount="{{ $total_disputes_amount }}" 
                data-cashed-amount="{{ $total_sold_paid_amount }}" />
            <div class="income_lista_chart_blk">
                <div class="income_lista_chart_img" id="div_pie_finalized_deals_borrower">
                    <img src="{{ asset('images/chart_incom_img_1.svg') }}" alt="no-image">
                </div>
                <div class="income_lista_chart_priceblk">
                    <div class="income_lista_chart_price">
                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_sold) }}
                    </div>
                    <div class="income_txt_totalinvest">{{ __('Total Sold') }}</div>
                </div>
            </div>
        </div> --}}
       {{-- <div class="income_lista_bottom_col">
            <div class="income_lista_chart_blk">
                <div class="income_lista_chart_img">
                    <img src="{{ asset('images/chart_incom_img_1.svg') }}" alt="no-image">
                </div>
                <div class="income_lista_chart_priceblk">
                    <div class="income_lista_chart_price">
                        389.000
                    </div>
                    <div class="income_txt_totalinvest">Total Invested</div>
                </div>
            </div>
        </div> --}}
    </div>
</div>
