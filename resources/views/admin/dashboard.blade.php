<x-app-admin-layout>
    @section('pageTitle', 'Dashboard')
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
                                <select class="selectbox" id="select_document_type" name="select_document_type"
                                    class="form-select form-select-sm">
                                    {{-- <option value="">select document </option> --}}
                                    @foreach ($type_of_documents as $val)
                                        <option value="{{ $val }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" id="select_currency_type" name="select_currency_type"/>
                            {{-- <div class="col-auto">
                              <select class="selectbox" id="select_currency_type" name="select_currency_type"
                                  class="form-select form-select-sm">
                                  @foreach ($currency_type as $val)
                                      <option value="{{ $val }}">{{ $val }}</option>
                                  @endforeach
                              </select>
                          </div --}}
                            <div class="col-auto">
                                <input type="text" name="duration_date_range" class="form-control" readonly id="duration_date_range" value="" />
                            </div>
                            <div class="col-auto">
                                <button type="button" id="cmd_search" class="btn btn-primary mb-3">{{ __('Search') }}</button>
                                <button type="button" id="btn-filter-export"  class="btn btn-info mb-3 text-white">{{ __('Export') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="ajax_dashboard_div"></div>

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

                $('input[name="duration_date_range"]').on('apply.daterangepicker', function(ev, picker) {
                    initDashboard();
                });
    
                $('#cmd_search').on('click', function (e) {
                    e.preventDefault();
                    var self = $(this);
                    initDashboard();
              });

                initDashboard();
            });

            function initDashboard() {
                var currency_type = $('#select_currency_type').val();
                var duration_date_range = $('#duration_date_range').val();
                var document_type = $('#select_document_type').val();

                var formData = {
                    'currency_type': currency_type,
                    'duration_date_range': duration_date_range,
                    'document_type': document_type,
                };

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.ajax-dashboard-admin') }}",
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    success: function(res) {
                        if (res.status == true) {
                            $('#ajax_dashboard_div').html(res.data.dhtml);
                            console.log(res.message);
                        } else {
                            console.log(res.message);
                        }
                    },
                    error: function(xhr) {
                        ajaxErrorMsg(xhr);
                    }
                });
            }

            $('#btn-filter-export').click(function(e){
                e.preventDefault();
                var currency_type = $('#select_currency_type').val();
                var duration_date_range = $('#duration_date_range').val();
                var document_type = $('#select_document_type').val();

                var formData = {
                    'currency_type': currency_type,
                    'duration_date_range': duration_date_range,
                    'document_type': document_type,
                };

                $.ajax({
                    type: 'POST',
                    data: formData,
                    url: "{{ route('admin.dashboard.export-daily-report') }}",
                    success: function (res) {
                        if(res.status  == true)
                        {
                            fileDownload(res.file_downalod, 'dashboard_');
                        } else {
                            toastr.error(res.message);
                        }
                    },
                    error: function (xhr) {
                        ajaxErrorMsg(xhr);
                    }
                });
            });
        </script>
    @endsection
</x-app-admin-layout>
