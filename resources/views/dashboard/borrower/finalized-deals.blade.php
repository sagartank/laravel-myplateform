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
                'h3' => 'Sold Documents',
                'title' => 'Seller',
                'pdf' => 'download_pdf',
                'excel' => 'download_excel',
            ])

            <div id="ajax_finalize_deals_div" class="invbor"></div>

        </div>
    </div>

    </div> {{-- close dashboard_main --}}

    @include('dashboard.common.advance-filter-modal')

    @section('custom_script')
        <script src="{{ asset('plugins/chart/chart.min.js') }}"></script>
        <script src="{{ asset('plugins/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-treemap"></script>
        <script>
            const ajax_url_get_seller = "{{ route('profile.ajax-search-seller') }}";
            const ajax_url_get_buyer = "{{ route('profile.ajax-search-buyer') }}";
            var action_name = "search";

            $(document).ready(function() {
                $(".js-example-basic-multiple").select2({
                    tags: true,
                    tokenSeparators: [',', ' ']
                });
                
                initFinalizeDealsDashboard();

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
                initFinalizeDealsDashboard();
            });

            $(document).on('click', '#btn_reset_advance_filter_modal', function(e) {
                e.preventDefault();
                let self = $(this);
                $('#advance_filter_modal').modal('hide');
                $('#advance_filter_modal_form')[0].reset();
                initFinalizeDealsDashboard();
            });

            $(document).on('click', '#download_pdf, .evt_download_pdf_mob', function(e) {
                e.preventDefault();
                let self = $(this);
                // var link = document.createElement('a');
                action_name = "pdf";
                initFinalizeDealsDashboard();
            });

            $(document).on('click', '#download_excel', function(e) {
                e.preventDefault();
                let self = $(this);
                action_name = "excel";
                initFinalizeDealsDashboard();
            });

            function initFinalizeDealsDashboard() {
                setLoadin();
                var pie_chart_image = '';
                const route_url = "{{ route('dashboard.borrower.ajax-finalized-deals') }}";
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
                  /*   pie_chart_image = document.getElementById('pie_finalized_deals_borrower').toDataURL();
                    form_data.push({
                        name: "pie_chart_image",
                        value: pie_chart_image
                    }); */

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
                                $('#ajax_finalize_deals_div').html(res.data.dhtml);
                                // initPieChart();
                                toastr.success(res.message);
                                initTreemapschart(res.data.treemap_data);
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

            /* function initPieChart() {

                const pie_data_obj = $('body #pie_chart_data');
                const pichart_data_obj = {
                    labels: ['Total Document Dues', 'Total Uncashable', 'Total Disputes', 'Total Cashed'],
                    datasets: [{
                        // label: 'Risk Managment',
                        data: [
                            pie_data_obj.attr('data-document_dues-amount'),
                            pie_data_obj.attr('data-uncashable-amount'),
                            pie_data_obj.attr('data-disputes-amount'),
                            pie_data_obj.attr('data-cashed-amount'),
                        ],
                        backgroundColor: [
                            '#DC3545',
                            '#FFC107',
                            '#0D6EFD',
                            '#3D8BFD',
                        ],
                        hoverOffset: 4
                    }]
                };

                $('body #div_pie_finalized_deals_borrower').empty();

                var canvas = document.createElement("canvas");
                canvas.setAttribute("id", "pie_finalized_deals_borrower");

                $('body #div_pie_finalized_deals_borrower').html(canvas);

                new Chart(document.getElementById('pie_finalized_deals_borrower'), {
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
            } */

            function initTreemapschart(treemapsData)
            {
                const DATA = treemapsData;
                    
                    $('body #treeMap_chart_data').empty();

                    var canvas = document.createElement("canvas");
                    canvas.setAttribute("id", "treemap_finalized_deals_borrower");

                    $('body #treeMap_chart_data').html(canvas);

                    new Chart(document.getElementById('treemap_finalized_deals_borrower'), {
                        type: 'treemap',
                        data: {
                            datasets: [
                            {
                                label: 'Fruits',
                                tree: DATA,
                                key: 'value',
                                borderWidth: 0,
                                borderRadius: 6,
                                spacing: 1,
                                backgroundColor(ctx) {
                                if (ctx.type !== 'data') {
                                    return 'transparent';
                                }
                                return ctx.raw._data.color;
                                },
                                labels: {
                                align: 'left',
                                display: true,
                                formatter(ctx) {
                                    if (ctx.type !== 'data') {
                                    return;
                                    }
                                   
                                    return [ctx.raw._data.what, 'operation amount is ' + ctx.raw.v];
                                },
                                color: ['white', 'whiteSmoke'],
                                font: [{size: 20, weight: 'bold'}, {size: 12}],
                                position: 'top'
                                }
                            }
                            ],
                        },
                        options: {
                            events: [],
                            plugins: {
                            title: {
                                display: true,
                                text: 'Operations'
                            },
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            }
                            }
                        }
                    });
            }
        </script>
    @endsection
</x-app-layout>
