$(document).ready(function () {
    $(document).on('submit', '#form-filter-users', function (e) {
        e.preventDefault();
        initUserDataTable();
    });

    $(document).on('click', '.evt_btn_search', function (e) {
        e.preventDefault();
        initUserDataTable();
    });

    $(document).on('click', '.evt_btn_reset', function (e) {
        $('#form-filter-users').trigger('reset');
        initUserDataTable();
    });

    $(document).on('click', '.page-link:not(.page-item.active .page-link)', function (e) {
        e.preventDefault();
        let rootPath = $(this).attr('href');
        initUserDataTable(rootPath);
    });

    $(document).on('click', '.evt_user_data_table_list .sorting', function () {
        let obj = $(this);

        $('.evt_user_data_table_list .sorting').each(function () {
            if ($(this).data('column-name') !== obj.data('column-name')) {
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

        initUserDataTable();
    });

    $('#load-user-ajax').on('change', '#per-page', function () {
        initUserDataTable();
    });
});

function initUserDataTable(rootPath) {
    if (rootPath == undefined) {
        rootPath = ajaxUserDataTableUrl;
    }
    var formData = $('#form-filter-users').serialize();
    $.ajax({
        type: 'POST',
        data: formData,
        url: rootPath,
        success: function (response) {
            $('#load-user-ajax').html(response);
            $('.evt_user_data_table_list').DataTable({
                columnDefs: [
                    { orderable: false, targets: 'no-sort' },
                ],
                'searching': false,
                'paging': false,
                'ordering': false,
                // 'pageLength': 20,
                'resposive': true,
                'info': false,
            });
        }
    });
}