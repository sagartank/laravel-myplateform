var device_type = detectDeviceType();
$(document).ready(function () {
    initDaterangepickerSingle();
    $.each(['#search_seller_dst', '#search_seller_mob'], function(_ind, _val) {
        $(_val).select2({
            dropdownCssClass: 'increasezindex',
            placeholder: sch_seller_en_msg,
            ajax: {
                dataType: 'json',
                type: 'post',
                delay: 500,
                url: ajax_url_get_user,
                data: function (params) {
                    var query = {
                        search: params.term,
                    }
                    return query;
                },
                processResults: function (res) {
                    return {
                        data: res.data,
                        results: res.data,
                    };
                },
                cache: true
            }
        });
    });

    $.each(['#search_payer_mob', '#search_payer_dst'], function(_ind, _val) {
        console.log('select2_val', _val);
        $(_val).select2({
            dropdownCssClass: 'increasezindex',
            placeholder: sch_pay_issuer_en_msg,
            ajax: {
                dataType: 'json',
                type: 'post',
                delay: 500,
                url: ajax_url_get_compnay,
                data: function (params) {
                    var query = {
                        search: params.term,
                    }
                    return query;
                },
                processResults: function (res) {
                    return {
                        data: res.data,
                        results: res.data,
                    };
                },
                cache: true
            }
        });
    });

    $.each(['#search_bank_dst', '#search_bank_mob'], function(_ind, _val) {
        // console.log("Index: " + _ind + ", Value: " + _val);
        $(_val).select2({
            dropdownCssClass: 'increasezindex',
            placeholder: sch_bank_en_msg,
            ajax: {
                dataType: 'json',
                type: 'post',
                delay: 500,
                url: ajax_url_get_bank,
                data: function (params) {
                    var query = {
                        search: params.term,
                    }
                    return query;
                },
                processResults: function (res) {
                    return {
                        data: res.data,
                        results: res.data,
                    };
                },
                cache: true
            }
        });
    });

    if (sessionStorage.getItem("session_filter_type_doc") != null && sessionStorage.getItem("session_filter_type_doc") != 'undefined') {
        var session_filter_type_doc = sessionStorage.getItem("session_filter_type_doc");
        $('.filter-document-type').parents().removeClass('active');
        var chk_radio_obj = $("input:radio[value='" + session_filter_type_doc + "']");
        $(chk_radio_obj).prop('checked', true);
        $(chk_radio_obj).parents().addClass('active');
        loadMoreExploreOperationsData(null, device_type);
    } else {
        loadMoreExploreOperationsData(null, device_type);
    }
});

$(document).on('click', '.show_more_btn a', function (e) {
    $(this).parents('.top_part_cheque').find('.dropdown_wrap').slideToggle(500);
    $(this).parents('.top_part_cheque').find('.dropdown_wrap').toggleClass('open_dropdown_wrap');
    $(this).parent().toggleClass('active');
    if ($(this).parents('.top_part_cheque').find('.dropdown_wrap').hasClass("open_dropdown_wrap")) {
        $(this).find('span').text(show_less_en_msg);
    } else {
        $(this).find('span').text(show_more_en_msg);
    }
    e.stopPropagation();
});

$(document).on('click', '.evt_paginate_operations .pagination a', function (e) {
    e.preventDefault();
    var page_no = $(this).attr('href').split('page=')[1];
    loadMoreExploreOperationsData(page_no, device_type);
});

$(document).on('click', '.evt_got_to_page', function (e) {
    e.preventDefault();
    var self = $(this);
    var last_page_no = self.attr('data-last-page');
    var input_page_no = $('#page_no').val();

    if (parseInt(last_page_no) >= parseInt(input_page_no)) {
        loadMoreExploreOperationsData($('#page_no').val(), device_type);
    } else {
        toastr.error(`Maximum page no ${last_page_no}`);
    }
});

$(document).on('click', '.evt_refresh_icon', function (e) {
    e.preventDefault();
    let self = $(this);
    let device_type = $(this).attr('data-device-type');
    if(device_type == 'mob') {
        $('#eop_form_filter_mob')[0].reset();
    } else {
        $('#eop_form_filter_dst')[0].reset();
    }
    initDaterangepickerSingle();
    $('#eop_explore_side_bar_modal').removeClass('clicked');
    loadMoreExploreOperationsData(null, device_type);
});

$(document).on('click', '.evt_eop_form_filter_apply', function (e) {
    e.preventDefault();
    let self = $(this);
    $('#advance_filter_modal').modal('hide');
    $('#ajax_explore_operations_list').empty();

    $('#eop_explore_side_bar_modal').removeClass('clicked');
    
    let device_type = $(this).attr('data-device-type');
    loadMoreExploreOperationsData(null, device_type);
});

$(document).on('click', '.evt_eop_form_filter_reset', function (e) {
    e.preventDefault();
    let self = $(this);
    let device_type = $(this).attr('data-device-type');
    if(device_type == 'mob') {
        $('#eop_form_filter_mob')[0].reset();
    } else {
        $('#eop_form_filter_dst')[0].reset();
    }
    $('#eop_explore_side_bar_modal').removeClass('clicked');
    initDaterangepickerSingle();
    // $('#ajax_explore_operations_list').empty();
    loadMoreExploreOperationsData(null, device_type);
});

$(document).on('change', '#sort_type_explore_operation', debounce(function (e) {
    e.preventDefault();
    let self = $(this);
    $('#ajax_operations_list').empty();
    $('#ajax_explore_operations_list').empty();
    loadMoreExploreOperationsData(url_load_more_explore_operations_data, device_type);
}, 200));

$(document).on('change', '.filter-document-type', function (e) {
    e.preventDefault();
    $('.filter-document-type').parents().removeClass('active');
    $(this).prop('checked', true);
    $(this).parents().addClass('active');

    var filer_type_doc = $("input:radio[name='doc_type']:checked").val();
    sessionStorage.setItem("session_filter_type_doc", filer_type_doc);
    loadMoreExploreOperationsData(page_no = null, device_type);
});

function loadMoreExploreOperationsData(page_no = null, device_type) {
    $('.btn_group_offer').prop('disabled', true);
    $('#chk_all_explore').prop('checked', false);
    $('#chk_all_explore').prop('disabled', true);
    
    $('.explore_operation_ids').prop('checked', false);

    var form_data = $('#eop_form_filter_dst').serialize();
    $('#ajax_explore_operations_list').html(ExploreOperationsPage.list(10));
    if(device_type == 'mob') {
        form_data = $('#eop_form_filter_mob').serialize();
        $('#ajax_explore_operations_list_mobile').html(ExploreOperationsPage.list_mobile(10));
    }
    console.log('device_type', device_type);
    $.ajax({
        type: 'POST',
        url: url_load_more_explore_operations_data + '?page=' + page_no,
        data: form_data + '&sort_column=' + $('#sort_type_explore_operation').val() + '&filer_type_doc=' + $("input:radio[name='doc_type']:checked").val(),
        dataType: 'json',
        cache: false,
        success: function (res) {
            if (res.status == true) {
                $('#ajax_explore_operations_list').html(res.data.dhtml);
                $('#ajax_explore_operations_list_mobile').html(res.data.dhtml_mobile);
                $('#chk_all_explore').prop('disabled', false);
                initFunction();
            } else {
                toastr.error(res.message);
            }
            initToolTip();
        },
        error: function (xhr) {
            ajaxErrorMsg(xhr);
        }
    });
}

function initFunction() {
    $('.document_slider').owlCarousel({
        loop: false,
        margin: 8,
        dots: false,
        navText: [
            '<svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.5 11L1.5 6L6.5 1" stroke="#ADADAD" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            '<svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 1L6.5 6L1.5 11" stroke="#ADADAD" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>'
        ],
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1400: {
                items: 3
            }
        }
    });

    $('.filter_selectprice input:checkbox').change(function () {
        if ($(this).is(":checked")) {
            $(this).parents('.filter_selectprice').addClass("active_payment");
        } else {
            $(this).parents('.filter_selectprice').removeClass("active_payment");
        }
    });

    // psidebar dropdown open close
    jQuery(".filter_modal_cattitle a").on("click", function (e) {
        e.preventDefault();
        jQuery(this).parent().parent().find(".expbudget")
            .slideToggle();
        jQuery(this).parent().toggleClass("active");
    });

    jQuery(".filter_modal_cattitle a").on("click", function (e) {
        e.preventDefault();
        jQuery(this).parent().toggleClass("active");
    });

    // psidebar dropdown open close
    jQuery(".evt_showmore a").on("click", function (e) {
        e.preventDefault();
        var obj = $(this);
        var _index = obj.attr('data-index');
        jQuery(this).parent().parent().find(".openmore_data").slideToggle();
        jQuery(this).parent().toggleClass("active");

        if ($(`#showmore_wrap_${_index}`).hasClass('active')) {
            $(`#txt_show_more_${_index}`).text(show_less_en_msg);
        } else {
            $(`#txt_show_more_${_index}`).text(show_more_en_msg);
        }
    });

    //explorer operation ee more attach doc slider
    $('.attach_sldr').owlCarousel({
        items: 3,
        loop: false,
        margin: 10,
        nav: true,
        dots: false,
        smartSpeed: 500,
        navText: [
            '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.5 13L5.5 8L10.5 3" stroke="#939393" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 3L10.5 8L5.5 13" stroke="#939393" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>'
        ],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    })
}

/* mobile js */
$(document).on('click', '.evt_doc_type_mobile', function (e) {
    e.preventDefault();
    var doc_val = $(this).attr('data-doc-val');
    $('input:radio[value="'+doc_val+'"]').prop('checked', true);
    sessionStorage.setItem("session_filter_type_doc", doc_val);
    loadMoreExploreOperationsData(page_no = null, 'mob');
});

$(document).on('change', '.evt_sort_type_mobile', function (e) {
    e.preventDefault();
    var sort_type_val = $(this).val();
    $('#sort_type_explore_operation').val(sort_type_val);

    $('.mobile_operation_tab').removeClass('clicked');
    $('body').removeClass('exptab_filter');

    loadMoreExploreOperationsData(page_no = null, 'mob');
});

function detectDeviceType() {
    // Get the screen width using jQuery
    var screenWidth = $(window).width();

    // Define breakpoints for mobile and tablet
    var mobileBreakpoint = 768; // Example breakpoint for mobile (adjust as needed)
    var tabletBreakpoint = 991; // Example breakpoint for tablet (adjust as needed)

    // Determine the device type based on screen width
    if (screenWidth < mobileBreakpoint) {
        return "mob";
    } else if (screenWidth < tabletBreakpoint) {
        return "mob";
    } else {
        return "dst";
    }
}

function initDaterangepickerSingle() {
    $('input[name="duration_date_range"]').daterangepicker({
        // autoUpdateInput: false,
        showButtonPanel: false,
        singleDatePicker: true,
        showDropdowns: false,
        minYear: 1901,
        // autoApply: true,
        locale: {
            format: 'DD/MM/YYYY'
        },
        maxYear: parseInt(moment().format('YYYY'), 10)
    }, function (start, end, label) {
        /*  var years = moment().diff(start, 'years');
        alert("You are " + years + " years old!"); */
    }).on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });
}