<x-app-layout>
    @section('pageTitle', 'Dashboard')
    @section('custom_style')
        <link href="{{ asset('plugins/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet">
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="income_deshbord_main">
        <div class="container">
            <div class="title_bar">
                <div class="title_bar_left">
                    <h3>Progress Deals</h3>
                    <div class="sub_head">Borrower</div>
                </div>
                <div class="title_right_bar">
                    <div class="advance_filter_btn">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#advance_filter_modal">Advance
                            Filters</a>
                    </div>
                    <div class="export_blk">
                        <span>Export to:</span>
                        <a href="#">Excel</a>
                        <a href="#">PDF</a>
                    </div>
                </div>
            </div>
            <div class="income_lista_row">
                <div class="income_lista_col">
                    <div class="income_lista_box active-txt">
                        <h4>Total Sold</h4>
                        <div class="income_price">USD 212.000</div>
                    </div>
                </div>
                <div class="income_lista_col">
                    <div class="income_lista_box active-txt">
                        <h4>Total Sold (Paid)</h4>
                        <div class="income_price">USD 180.000</div>
                    </div>
                </div>
                <div class="income_lista_col">
                    <div class="income_lista_box error-txt">
                        <h4>Total Pending Payment Receipt</h4>
                        <div class="income_price">USD 20.000</div>
                    </div>
                </div>
                <div class="income_lista_col">
                    <div class="income_lista_box waiting-txt">
                        <h4>Total Documents Due</h4>
                        <div class="income_price">USD 16.000</div>
                    </div>
                </div>
                <div class="income_lista_col">
                    <div class="income_lista_box error-txt">
                        <h4>Total Uncashable</h4>
                        <div class="income_price">USD 8.000</div>
                    </div>
                </div>
                <div class="income_lista_col">
                    <div class="income_lista_box error-txt">
                        <h4>Total Disputes</h4>
                        <div class="income_price">USD 1.000</div>
                    </div>
                </div>
            </div>
            <div class="income_lista_bottom">
                <div class="income_lista_bottom_col">
                    <div class="income_lista_bottom_blk active-txt">
                        <div class="income_lista_title">
                            <h3>Total Sold (Paid)</h3>
                        </div>
                        <div class="income_lista_left">
                            <div class="cheque_part_row">
                                <div class="cheque_part_left">
                                    <div class="cheque_left_top">
                                        <label for="cheque_check_1">CHEQUE - OP123 - <span>Arya Kagathara</span></label>
                                    </div>
                                    <div class="cheque_compnyname">Goldman Sach</div>
                                </div>
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        50.000 USD
                                    </div>
                                </div>
                            </div>
                            <div class="cheque_part_row">
                                <div class="cheque_part_left">
                                    <div class="cheque_left_top">
                                        <label for="cheque_check_1">CHEQUE - OP123 - <span>Arya Kagathara</span></label>
                                    </div>
                                    <div class="cheque_compnyname">Goldman Sach</div>
                                </div>
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        20.000 USD
                                    </div>

                                </div>
                            </div>
                            <div class="cheque_part_row">
                                <div class="cheque_part_left">
                                    <div class="cheque_left_top">
                                        <label for="cheque_check_1">CHEQUE - OP123 - <span>Arya Kagathara</span></label>
                                    </div>
                                    <div class="cheque_compnyname">Goldman Sach</div>
                                </div>
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        50.000 USD
                                    </div>

                                </div>
                            </div>
                            <div class="cheque_part_row">
                                <div class="cheque_part_left">
                                    <div class="cheque_left_top">
                                        <label for="cheque_check_1">CHEQUE - OP123 - <span>Arya Kagathara</span></label>
                                    </div>
                                    <div class="cheque_compnyname">Goldman Sach</div>
                                </div>
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        60.000 USD
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="total_count_income_wrap">
                            <div class="total_count_income">
                                <div class="total_count_income_title">
                                    Total
                                </div>
                                <div class="total_count_income_total">
                                    180.000 USD
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="income_lista_bottom_blk error-txt">
                        <div class="income_lista_title">
                            <h3>Total Pending Payment Receipt</h3>
                        </div>
                        <div class="income_lista_left">
                            <div class="cheque_part_row">
                                <div class="cheque_part_left">
                                    <div class="cheque_left_top">
                                        <label for="cheque_check_1">CHEQUE - OP123 - <span>Arya Kagathara</span></label>
                                    </div>
                                    <div class="cheque_compnyname">Goldman Sach</div>
                                </div>
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        20.000 USD
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="total_count_income_wrap">
                            <div class="total_count_income">
                                <div class="total_count_income_title">
                                    Total
                                </div>
                                <div class="total_count_income_total">
                                    20.000 USD
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="income_lista_bottom_blk waiting-txt">
                        <div class="income_lista_title">
                            <h3>Total Due</h3>
                        </div>
                        <div class="income_lista_left">
                            <div class="cheque_part_row">
                                <div class="cheque_part_left">
                                    <div class="cheque_left_top">
                                        <label for="cheque_check_1">CHEQUE - OP123 - <span>Arya Kagathara</span></label>
                                    </div>
                                    <div class="cheque_compnyname">Goldman Sach</div>
                                </div>
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        16.000 USD
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="total_count_income_wrap">
                            <div class="total_count_income">
                                <div class="total_count_income_title">
                                    Total
                                </div>
                                <div class="total_count_income_total">
                                    16.000 USD
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="income_lista_bottom_blk error-txt">
                        <div class="income_lista_title">
                            <h3>Total Disputes</h3>
                        </div>
                        <div class="income_lista_left">
                            <div class="cheque_part_row">
                                <div class="cheque_part_left">
                                    <div class="cheque_left_top">
                                        <label for="cheque_check_1">CHEQUE - OP123 - <span>Arya
                                                Kagathara</span></label>
                                    </div>
                                    <div class="cheque_compnyname">Goldman Sach</div>
                                </div>
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        1.000 USD
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="total_count_income_wrap">
                            <div class="total_count_income">
                                <div class="total_count_income_title">
                                    Total
                                </div>
                                <div class="total_count_income_total">
                                    1.000 USD
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="income_lista_bottom_blk error-txt">
                        <div class="income_lista_title">
                            <h3>Total Uncashable</h3>
                        </div>
                        <div class="income_lista_left">
                            <div class="cheque_part_row">
                                <div class="cheque_part_left">
                                    <div class="cheque_left_top">
                                        <label for="cheque_check_1">CHEQUE - OP123 - <span>Arya
                                                Kagathara</span></label>
                                    </div>
                                    <div class="cheque_compnyname">Goldman Sach</div>
                                </div>
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        8.000 USD
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="total_count_income_wrap">
                            <div class="total_count_income">
                                <div class="total_count_income_title">
                                    Total
                                </div>
                                <div class="total_count_income_total">
                                    8.000 USD
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="income_lista_bottom_col">
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
                </div>
            </div>
        </div>
    </div>

    </div> {{-- close dashboard_main --}}

    @include('dashboard.common.advance-filter-modal')
</x-app-layout>

@section('custom_script')
    <script src="{{ asset('plugins/chart/chart.min.js') }}"></script>
    <script src="{{ asset('plugins/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery(".js-example-basic-multiple").select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });
        });
    </script>