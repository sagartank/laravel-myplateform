<x-app-layout>
    @section('pageTitle', 'Dashboard')
    @section('custom_style')
        <link href="{{ asset('plugins/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet">
        <style>
            .select2-dropdown.increasezindex {
                z-index: 99999;
            }

            .active-selected-div {
                background-color: #F5F7F9;
            }
        </style>
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="income_deshbord_main">
        <div class="container">
         
                @include('dashboard.common.dashboar-filter-pdf', [
                    'h3' => 'Total Investments',
                    'title' => 'Buyer',
                    'pdf' => 'download_pdf',
                    'excel' => 'download_excel',
                ])
                <div id="ajax_incomes_profit_loss_div" class="invbor">
                    
                </div>
            </div>
        </div>
    </div>

    </div> {{-- close dashboard_main --}}

    @include('dashboard.common.advance-filter-modal')

    {{-- 
    <div class="modal fade advance_filter_modal" id="advance_filter_modal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form name="advance_filter_modal_form" id="advance_filter_modal_form" method="post">
                        <div class="filter_modal_wrap">
                            <div class="filter_modal_top">
                                <div class="filter_modal_toprow">
                                    <div class="filter_modal_topcol">
                                        <div class="filter_modal_cattitle">{{ __('CATEGORY') }}</div>
                                        <div class="filter_catlist">
                                            @if (config('constants.TYPE_OF_DOCUMENT'))
                                                @foreach (config('constants.TYPE_OF_DOCUMENT') as $key => $val)
                                                    <div class="filter_checkbox_wrap">
                                                        <input type="checkbox" name="operation_type[]"
                                                            value="{{ $val }}"
                                                            id="catagory_contracts_{{ $key }}">
                                                        <label
                                                            for="catagory_contracts_{{ $key }}">{{ $val }}</label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="filter_modal_topcol">
                                        <div class="filter_modal_cattitle">{{ __('OPERATION CURRENCY') }}</div>
                                        <div class="filter_catlist">
                                            @if (config('constants.CURRENCY_TYPE'))
                                                @foreach (config('constants.CURRENCY_TYPE') as $key => $val)
                                                    <div class="filter_checkbox_wrap">
                                                        <input type="radio"
                                                            {{ $currency_type == $val ? 'checked' : '' }}
                                                            name="currency_type" value="{{ $val }}"
                                                            id="opert_curr_usd_{{ $key }}">
                                                        <label
                                                            for="opert_curr_usd_{{ $key }}">{{ $val }}</label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="filter_modal_topcol filter_modal_topcol_duration">
                                        <div class="filter_modal_cattitle">DURATION</div>
                                        <input type="text" name="duration_date_range" class="form-control"
                                            id="duration_date_range" value="{{ $date_range }}" />
                                    </div>
                                    <div class="filter_modal_topcol filter_modal_topcol_operation_range">
                                        <div class="filter_modal_cattitle">OPERATION RANGE</div>
                                        <div class="filter_modal_selectprice">
                                            <div class="filter_selectprice active_payment">
                                                <div class="selectprice_duration_row">
                                                    <div class="selectprice_duration_col modal_form_wrp">
                                                        <label for="min">Min</label>
                                                        <input type="number" name="min" id="min"
                                                            value="6000">
                                                    </div>
                                                    <div class="selectprice_duration_col modal_form_wrp">
                                                        <label for="">Max</label>
                                                        <input type="number" name="max" id="max"
                                                            value="10000">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter_modal_morerow">
                                    <div class="filter_modal_morecol">
                                        <div class="filter_modal_cattitle">
                                            PAYER
                                        </div>
                                        <div class="filter_modal_select modal_form_wrp">
                                            <!-- <label for="">Add Tags</label> -->
                                            <select name="statesstates" class="js-example-basic-multiple"
                                                name="states[]" multiple="multiple">
                                                <option selected="selected" value="JP Morgan">JP Morgan</option>
                                                <option selected="selected" value="Cocacola">Cocacola</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="filter_modal_morecol">
                                        <div class="filter_modal_cattitle">
                                            SELLER
                                        </div>
                                        <div class="filter_modal_select modal_form_wrp">
                                            <!-- <label for="">Add Tags</label> -->
                                            <select name="states" class="js-example-basic-multiple" name="states[]"
                                                multiple="multiple">
                                                <option selected="selected" value="JP Morgan">JP Morgan</option>
                                                <option selected="selected" value="Cocacola">Cocacola</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="filter_modal_bottom">
                                <div class="filter_modal_bottom_left">
                                    <input type="submit" value="Apply Filter" id="btn_advance_filter_modal_form"
                                        class="btn btn-primary">
                                    <input type="reset" value="Reset" id="btn_reset_advance_filter_modal"
                                        class="simpalbtn resetbtn">
                                </div>
                                <div class="filter_modal_bottom_right">
                                    <button type="button" class="simpalbtn" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    @section('custom_script')
        <script src="{{ asset('plugins/chart/chart.min.js') }}"></script>
        <script src="{{ asset('plugins/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
        <script>
            const ajax_url_get_seller = "{{ route('profile.ajax-search-seller') }}";
            const ajax_url_get_buyer = "{{ route('profile.ajax-search-buyer') }}";
            var action_name = "search";
            $(document).ready(function() {
                $(".js-example-basic-multiple").select2({
                    tags: true,
                    tokenSeparators: [',', ' ']
                });

                initIncomesProfitLossDashboard();

                $('input[name="duration_date_range"]').on('apply.daterangepicker', function(ev, picker) {
                    initIncomesProfitLossDashboard();
                });

                $('.evt_get_seller').select2({
                    dropdownCssClass: 'increasezindex',
                    placeholder: sch_seller_en_msg,
                    ajax: {
                        dataType: 'json',
                        type: 'post',
                        delay: 500,
                        url: ajax_url_get_seller,
                        data: function(params) {
                            var query = {
                                search: params.term,
                            }
                            return query;
                        },
                        processResults: function(res) {
                            return {
                                data: res.data,
                                results: res.data,
                            };
                        },
                        cache: true
                    }
                });

                $('.evt_get_issuer').select2({
                    dropdownCssClass: 'increasezindex',
                    placeholder: sch_pay_issuer_en_msg,
                    ajax: {
                        dataType: 'json',
                        type: 'post',
                        delay: 500,
                        url: ajax_url_get_buyer,
                        data: function(params) {
                            var query = {
                                search: params.term,
                            }
                            return query;
                        },
                        processResults: function(res) {
                            return {
                                data: res.data,
                                results: res.data,
                            };
                        },
                        cache: true
                    }
                });
            });

            $(document).on('click', '#btn_advance_filter_modal_form', function(e) {
                e.preventDefault();
                let self = $(this);
                action_name = "search";
                $('#advance_filter_modal').modal('hide');
                initIncomesProfitLossDashboard();
            });

            $(document).on('click', '#btn_reset_advance_filter_modal', function(e) {
                e.preventDefault();
                let self = $(this);
                action_name = "search";
                $('#advance_filter_modal').modal('hide');
                $('#advance_filter_modal_form')[0].reset();
                initIncomesProfitLossDashboard();
            });

            $(document).on('click', '#download_pdf, .evt_download_pdf_mob', function(e) {
                e.preventDefault();
                let self = $(this);
                // var link = document.createElement('a');
                action_name = "pdf";
                initIncomesProfitLossDashboard();
            });

            $(document).on('click', '#download_excel', function(e) {
                e.preventDefault();
                let self = $(this);
                action_name = "excel";
                initIncomesProfitLossDashboard();
            });

            function initIncomesProfitLossDashboard() {
                var pie_chart_image = '';
                const route_url = "{{ route('dashboard.investor.ajax-incomes-profit-loss') }}";
                var form_data = $('#advance_filter_modal_form').serializeArray();

                form_data.push({
                    name: "pie_chart_image",
                    value: ""
                });

                form_data.push({
                    name: "action",
                    value: action_name
                });

                if (action_name == 'pdf') {
                    pie_chart_image = document.getElementById('pie_incomes_investor').toDataURL();
                    form_data.push({
                        name: "pie_chart_image",
                        value: pie_chart_image
                    });

                    ajax_pdf(route_url, 'POST', form_data, randomString());
                } else {
                    setLoadin();
                    $.ajax({
                        type: 'POST',
                        url: route_url,
                        data: form_data,
                        dataType: 'json',
                        success: function(res) {
                            if (res.status == true) {
                                $('#ajax_incomes_profit_loss_div').html(res.data.dhtml);
                                initPieChart();

                                toastr.success(res.message);
                            } else {
                                toastr.error(res.message);
                            }
                            unsetLoadin();
                        },
                        error: function(xhr) {
                            unsetLoadin();
                            ajaxErrorMsg(xhr);
                        }
                    });
                }
            }

            function initPieChart() {

                const pie_data_obj = $('body #pie_chart_data');

                const pichart_data_obj = {
                    labels: ['Total Disputas', 'Total Documentos a Cobrar', 'Total Documentos Cobrados'],
                    datasets: [{
                        // label: 'Incomes',
                        data: [pie_data_obj.attr('data-uncashable-amount'), pie_data_obj.attr('data-due-amount'),
                            pie_data_obj.attr('data-cashed-amount')
                        ],
                        backgroundColor: [
                            'rgb(219, 54, 70)',
                            'rgb(255, 193, 8)',
                            'rgb(53, 150, 105)'
                        ],
                        hoverOffset: 4
                    }]
                };

                $('body #div_pie_incomes_investor').empty();

                var canvas = document.createElement("canvas");
                canvas.setAttribute("id", "pie_incomes_investor");

                $('body #div_pie_incomes_investor').html(canvas);

                new Chart(document.getElementById('pie_incomes_investor'), {
                    type: 'pie',
                    data: pichart_data_obj,
                    options: {
                        plugins: {
                            responsive: true,
                            legend: {
                                position: 'bottom',
                            },
                        }
                    }
                });
            }
        </script>
    @endsection
</x-app-layout>
