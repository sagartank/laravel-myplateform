$(document).ready(function () {
    $(document).on('submit', '#form-filter-user', function (e) {
        e.preventDefault();
        initDataTable();
    });

    $(document).on('click', '#btn-filter-submit', function (e) {
        e.preventDefault();
        initDataTable();
    });

    $(document).on('click', '#btn-filter-reset', function (e) {
        $('#form-filter-user').trigger('reset');
        initDataTable();
    });

    $(document).on('click', '.page-link:not(.page-item.active .page-link)', function (e) {
        e.preventDefault();
        let rootPath = $(this).attr('href');
        initDataTable(rootPath);
    });

    $(document).on('click', '#data-table-list .sorting', function () {
        let obj = $(this);

        $('#data-table-list .sorting').each(function () {
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

        initDataTable();
    });

    $('#load-ajax').on('change', '#per-page', function () {
        initDataTable();
    });
});

function initDataTable(rootPath) {
    $('body .evt_btn_delete_all').prop('disabled', true);
    if (rootPath == undefined) {
        rootPath = ajaxDataTableUrl;
    }
    var formData = $('#form-filter-user').serialize();
    $.ajax({
        type: 'POST',
        data: formData,
        url: rootPath,
        success: function (response) {
            $('#load-ajax').html(response);
            $('#data-table-list').DataTable({
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
        },
        error: function (xhr) {
            ajaxErrorMsg(xhr);
        }
    });
}