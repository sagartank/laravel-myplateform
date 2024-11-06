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
            <div class="title_bar">
                <div class="title_bar_left">
                    <h3>Progress Deals</h3>
                    <div class="sub_head">Investors</div>
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

            <div id="ajax_progress_deals_investor_div"></div>

        </div>
    </div>

    </div> {{-- close dashboard_main --}}

    @include('dashboard.common.advance-filter-modal')

    @section('custom_script')
        <script src="{{ asset('plugins/chart/chart.min.js') }}"></script>
        <script src="{{ asset('plugins/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
        <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
        <script>
            $(document).ready(function() {
                $(".js-example-basic-multiple").select2({
                    tags: true,
                    tokenSeparators: [',', ' ']
                });
                initProgressDealsInvestorDashboard();
            });

            $('input[name="duration_date_range"]').on('apply.daterangepicker', function(ev, picker) {
                initProgressDealsInvestorDashboard();
            });

            $(document).on('click', '#btn_advance_filter_modal_form', function(e) {
                e.preventDefault();
                let self = $(this);
                $('#advance_filter_modal').modal('hide');
                initProgressDealsInvestorDashboard();
            });

            $(document).on('click', '#btn_reset_advance_filter_modal', function(e) {
                e.preventDefault();
                let self = $(this);
                $('#advance_filter_modal').modal('hide');
                $('#advance_filter_modal_form')[0].reset();
                initProgressDealsInvestorDashboard();
            });

            function initProgressDealsInvestorDashboard() {
                setLoadin();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('dashboard.investor.ajax-progress-deals') }}",
                    data: $('#advance_filter_modal_form').serialize(),
                    dataType: 'json',
                    success: function(res) {
                        if (res.status == true) {
                            $('#ajax_progress_deals_investor_div').html(res.data.dhtml);
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
        </script>
    @endsection
</x-app-layout>
