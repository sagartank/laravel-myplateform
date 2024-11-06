<x-app-admin-layout>
    @section('custom_style')
        <link href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
        <style>
            div.icon>img {
                max-width: 100%;
                max-height: 100%;
                width: 100%;
                height: auto;
            }
        </style>
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Dashboard') }}
            <x-slot name="right">
            </x-slot>
        </x-header>
    </x-slot>

    <div class="container-lg">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="row">
                            <div class="col-auto">
                                <select class="selectbox" id="select_currency_type" class="form-select form-select-sm">
                                    @foreach ($currency_type as $val)
                                        <option value="{{ $val }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <input type="text" name="duration_date_range" class="form-control" readonly
                                    id="duration_date_range" value="" />
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-3">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @permission('users')
            <fieldset>
                <legend>{{ __('Users') }}</legend>
                <div class="row">
                    <div class="col-sm-6 col-md-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/users-group.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">{{ $total_user->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Total User') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-sm-6 col-md-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/user.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>

                                <div class="fs-4 fw-semibold">{{ $today_register_user }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Registere') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-sm-6 col-md-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/user-question.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">{{ $total_user->where('is_active', '!=', '1')->count() }}
                                </div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Pending User') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/user-check.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">{{ $total_user->where('is_active', '1')->count() }}</div>
                                <small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Active User') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </fieldset>
        @endpermission
        @permission('operations')
            <fieldset>
                <legend>{{ __('Operations') }}</legend>
                <div class="row">
                    <div class="row">
                        <div class="col-sm-6 col-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-medium-emphasis-inverse text-end mb-4">
                                        <div class="icon icon-xxl">
                                            <img src="{{ asset('images/mipo/file-upload.svg') }}"
                                                alt="{{ __('mipo') }}">
                                        </div>
                                    </div>
                                    <div class="fs-4 fw-semibold">{{ $today_documents_uploaded }}</div><small
                                        class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Documents uploaded') }}</small>
                                    <div class="progress progress-white progress-thin mt-3">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-medium-emphasis-inverse text-end mb-4">
                                        <div class="icon icon-xxl">
                                            <img src="{{ asset('images/mipo/file-upload.svg') }}"
                                                alt="{{ __('mipo') }}">
                                        </div>
                                    </div>
                                    <div class="fs-4 fw-semibold">{{ $today_documents_uploaded }}</div><small
                                        class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Documents Sold') }}</small>
                                    <div class="progress progress-white progress-thin mt-3">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-medium-emphasis-inverse text-end mb-4">
                                        <div class="icon icon-xxl">
                                            <img src="{{ asset('images/mipo/file-upload.svg') }}"
                                                alt="{{ __('mipo') }}">
                                        </div>
                                    </div>
                                    <div class="fs-4 fw-semibold">{{ $today_documents_uploaded }}</div><small
                                        class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Documents pending verification') }}</small>
                                    <div class="progress progress-white progress-thin mt-3">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-medium-emphasis-inverse text-end mb-4">
                                        <div class="icon icon-xxl">
                                            <img src="{{ asset('images/mipo/file-alert.svg') }}"
                                                alt="{{ __('mipo') }}">
                                        </div>
                                    </div>
                                    <div class="fs-4 fw-semibold">{{ $today_documents_uploaded }}</div><small
                                        class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Documents Sold By Type') }}</small>
                                    <div class="progress progress-white progress-thin mt-3">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-medium-emphasis-inverse text-end mb-4">
                                        <div class="icon icon-xxl">
                                            <img src="{{ asset('images/mipo/file-alert.svg') }}"
                                                alt="{{ __('mipo') }}">
                                        </div>
                                    </div>
                                    <div class="fs-4 fw-semibold">{{ $total_operation->count() }}</div><small
                                        class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Operations Requiring Admin Assistance') }}</small>
                                    <div class="progress progress-white progress-thin mt-3">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        @endpermission
        @permission('offers')
            <fieldset>
                <legend>{{ __('Offers') }}</legend>
                <div class="row">
                    <div class="col-sm-6 col-md-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">{{ $total_offer->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Total Offer') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-sm-6 col-md-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    {{ $total_offer->where('offer_status', 'Pending')->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Pending Offer') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-sm-6 col-md-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    {{ $total_offer->where('offer_status', 'Counter')->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Counter Offer') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    {{ $total_offer->where('offer_status', 'Rejected')->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Rejected Offer') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    {{ $total_offer->where('offer_status', 'Approved')->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Approved Offer') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    {{ $total_offer->where('offer_status', 'Completed')->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Completed Offer') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        @endpermission
        @permission('deals')
            <fieldset>
                <legend>{{ __('Deals') }}</legend>
                <div class="row">
                    <div class="col-sm-6 col-md-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    {{ $total_offer->where('offer_status', 'Approved')->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Total Deals') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">{{ $total_offer->where('is_disputed', 'Yes')->count() }}
                                </div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Disputed Deals') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    {{ $total_offer->where('offer_status', 'Completed')->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Completed Deals') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        @endpermission
    </div>

    @section('custom_script')
        <script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
        <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('input[name="duration_date_range"]').daterangepicker({
                    opens: 'left',
                    locale: {
                        format: 'DD/MM/YYYY'
                    },
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                        .format('YYYY-MM-DD'));
                });

                function initDashboard() {
                    // setLoadin(); 
                    var currency_type = $('#select_currency_type').val();
                    var duration_date_range = $('#duration_date_range').val();
                    var select_preferred = $('#select_preferred_dashboard').val();

                    var formData = {
                        'currency_type': currency_type,
                        'duration_date_range': duration_date_range,
                        'preferred_dashboard': select_preferred,
                        'sort_type_deals': sort_type_deals,
                    };

                    $.ajax({
                        type: "POST",
                        url: url_ajax_dashboard_type,
                        data: formData,
                        dataType: 'json',
                        cache: false,
                        success: function(res) {
                            if (res.status == true) {
                                var res_data = res.data[0];

                                $('#ajax_first_div').html(res_data.first_section);

                                $('#ajax_latest_update_in_deals_table_div').html(res_data.second_section);

                                $('#ajax_last_section_div').html(res_data.last_section);

                                initPieChart(res_data.pichart);
                                // initBarChart(res_data);
                                // toastr.success(res.message);
                                console.log(res.message);
                            } else {
                                toastr.error(res.message);
                            }
                            // unsetLoadin();
                        },
                        error: function(xhr) {
                            // unsetLoadin();
                            ajaxErrorMsg(xhr);
                        }
                    });
                }
            });
        </script>
    @endsection
</x-app-admin-layout>
