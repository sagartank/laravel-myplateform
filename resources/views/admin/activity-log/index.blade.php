<x-app-admin-layout>
    @section('pageTitle', 'Activity Logs List')
@section('custom_style')
<link href="{{ asset('plugins/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
<link href="{{ asset('plugins/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
@endsection

    <x-slot name="header">
        <x-header>
            {{ __('Activity Logs') }}
        </x-header>
    </x-slot>

    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="load-ajax"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="show-activity-log-modal-xl" tabindex="-1" role="dialog" aria-labelledby="show-activity-log-modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="show-activity-log-modal">Activity Log</h4>
                    <button type="button" class="close" data-dismiss="modal" data-coreui-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="activity-log-section">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal" data-coreui-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@section('custom_script')
<script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/responsive.bootstrap5.min.js') }}"></script>
<script>
    ajaxLoadRoute = "{{ route('admin.activity-logs.ajax-load-activity-log-data') }}";
    $(document).ready(function () {

        $('input[name="activity_log_range"]').daterangepicker({
            autoUpdateInput: false,
            timePicker: false,
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM-DD'
            }
        });

        $('input[name="activity_log_range"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });

        $('input[name="activity_log_range"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        initActivitylogData();

        $(document).on('submit', '#form-filter-activity-log', function (e) {
            e.preventDefault();
            initActivitylogData();
        });

        $(document).on('click', '#btn-filter-submit', function (e) {
            e.preventDefault();
            initActivitylogData();
        });

        $(document).on('click', '#btn-filter-reset', function (e) {
            $('#form-filter-activity-log').trigger('reset');
            //Remove value fromcase number textbox and hide div
            $("#case_number").val("");
            $("#case_number_value").val("");
            $('#caseNumberDiv').addClass('d-none');
            //End of above
            initActivitylogData();
        });

        $(document).on('click', '.page-link:not(.page-item.active .page-link)', function (e) {
            e.preventDefault();
            let rootPath = $(this).attr('href');
            initActivitylogData(rootPath);
        });

        $(document).on('click', '#activity-logs-table .sorting', function () {
            let obj = $(this);

            $('#activity-logs-table .sorting').each(function () {
                if ($(this).data('column-name') != obj.data('column-name')) {
                    $(this).removeClass('sorting_asc');
                    $(this).removeClass('sorting_desc');
                }
            });

            var sortColumn = obj.data('column-name');
            var sortType = 'both';

            if (obj.hasClass('sorting_asc')) {
                obj.removeClass('sorting_asc');
                obj.addClass('sorting_desc');
                sortType = 'desc';

            } else if (obj.hasClass('sorting_desc')) {
                obj.removeClass('sorting_desc');
                obj.addClass('sorting_asc');
                sortType = 'asc';

            } else {
                sortType = 'asc';
                obj.addClass('sorting_asc');
            }

            $("input[name='sort_column']").val(sortColumn);
            $("input[name='sort_type']").val(sortType);

            initActivitylogData();
        });

        $('#load-ajax').on('change', '#per-page', function () {
            initActivitylogData();
        });

        $(document).on('click', '.show-activity-log-btn', function (e) {
            e.preventDefault();
            let el = $(this);
            let id = el.data("activity-log-id");
            $('#show-activity-log-modal-xl').modal('hide');

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-Token': "{{ csrf_token() }}",
                },
                url: "{{ route('admin.activity-logs.ajax-show-activity-log') }}",
                data: 'id=' + id,
                success: function (res) {
                    if (res.success) {
                        console.log(res.message);
                        $('#activity-log-section').html(res.activityLogSection);
                        $('#show-activity-log-modal-xl').modal('show');
                        // $("td[class^='old-data-']").each(function () {
                        //     let key = ($(this).attr('class')).replace('old-data-', '');
                        //     highlight($('td.new-data-' + key), $(this));
                        // });
                    }
                    else {
                        swalAlert( 'Error','Error...',res.message);
                    }
                },
            });
        });
    });

    function initActivitylogData(rootPath) {
        $('.preloader').show();

        if (rootPath == undefined) {
            rootPath = ajaxLoadRoute;
        }
        var formData = $('#form-filter-activity-log').serialize();

        $.ajax({
            type: 'POST',
            data: formData,
            url: rootPath,
            success: function (response) {
                $('#load-ajax').html(response);
                $('#activity-logs-table').DataTable({
                    columnDefs: [
                        { orderable: false, targets: 'no-sort' },
                        // { width: '60%', targets: 0 }
                    ],
                    'searching': false,
                    'paging': false,
                    'ordering': false,
                    // 'pageLength': 20,
                    'resposive': true,
                    'info': false,
                });
                $('.preloader').hide();
            }
        });
    }

    function highlight(newElem, oldElem) {
        
    }
    /**
    *  Hide and Show CaseNumber textbox based on subject type seletion 
    *  show if subject type CaseModel else hide
    */
    $(document).on('change','#subject-type',function(e){
        $obj = $(this);
        $("#case_number").val("");
        $("#case_number_value").val("");
        $selectedSubjectVal = $obj.find(":selected").val().replace(/\\/g, '');
        if($selectedSubjectVal === "AppModelsCaseModel"){
            $('#caseNumberDiv').removeClass('d-none');   
        }else{
            $('#caseNumberDiv').addClass('d-none');
        }
    });
</script>
@endsection
</x-app-admin-layout>
