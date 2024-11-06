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
                'h3' => 'Guaranteed Repurchase (MIPO+)',
                'title' => 'Buyer',
                'pdf' => 'download_pdf',
                'excel' => 'download_excel',
            ])
            <div id="ajax_risk_management_div" class="invrisk"></div>
        </div>
    </div>
    </div> {{-- close dashboard_main --}}

    @include('dashboard.common.advance-filter-modal')

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
                
                initRiskManagementDashboard();

                $('input[name="duration_date_range"]').on('apply.daterangepicker', function(ev, picker) {
                    action_name = "search";
                    initRiskManagementDashboard();
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
                $('#advance_filter_modal').modal('hide');
                action_name = "search";
                initRiskManagementDashboard();
            });

            $(document).on('click', '#btn_reset_advance_filter_modal', function(e) {
                e.preventDefault();
                let self = $(this);
                $('#advance_filter_modal').modal('hide');
                $('#advance_filter_modal_form')[0].reset();
                action_name = "search";
                initRiskManagementDashboard();
            });


            $(document).on('click', '#download_pdf, .evt_download_pdf_mob', function(e) {
                e.preventDefault();
                let self = $(this);
                // var link = document.createElement('a');
                action_name = "pdf";
                initRiskManagementDashboard();
            });

            $(document).on('click', '#download_excel', function(e) {
                e.preventDefault();
                let self = $(this);
                action_name = "excel";
                initRiskManagementDashboard();
            });


            function initRiskManagementDashboard() {

                var pie_chart_image = '';
                const route_url = "{{ route('dashboard.investor.ajax-risk-managment') }}";
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
                    pie_chart_image = document.getElementById('pie_risk_managment_investor').toDataURL();
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
                                $('#ajax_risk_management_div').html(res.data.dhtml);
                                toastr.success(res.message);
                                initPieChart();
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
                    labels: [dashboard_risk__mipo_chart_en_msg, dashboard_risk_in_chart_en_msg],
                    datasets: [{
                        // label: 'Risk Managment',
                        data: [pie_data_obj.attr('data-mipo-amount'), pie_data_obj.attr('data-self-risk-amount')],
                        backgroundColor: [
                            'rgb(26, 135, 84)',
                            'rgb(61, 138, 252)',
                        ],
                        hoverOffset: 4
                    }]
                };

                $('body #div_pie_risk_managment_investor').empty();

                var canvas = document.createElement("canvas");
                canvas.setAttribute("id", "pie_risk_managment_investor");

                $('body #div_pie_risk_managment_investor').html(canvas);

                new Chart(document.getElementById('pie_risk_managment_investor'), {
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

            $(document).on('click', '.evt_deals_details', function(event) {
                event.preventDefault();
                var details_link = $(this).attr('data-deals-details-link');
                window.location.href = details_link;
            });

            $(document).on('click', '.evt_operations_details', function(event) {
                event.preventDefault();
                var details_link = $(this).attr('data-operations-details-link');
                window.location.href = details_link;
            });
        </script>
    @endsection
</x-app-layout>
