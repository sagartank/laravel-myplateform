$(document).ready(function () {

/*     var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd
    }
    if (mm < 10) {
        mm = '0' + mm
    }

    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById("is_cashed_date_").setAttribute("max", today);

    $("#is_cashed_date_").on("change", function () {
        this.setAttribute(
            "data-date",
            moment(this.value, "YYYY-MM-DD")
                .format(this.getAttribute("data-date-format"))
        )
    }).trigger("change") */

    $('.evt_cashed_date').daterangepicker({
        maxDate: moment().endOf('day'),
        autoUpdateInput: false,
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
});

$(document).on('change', '.evt_is_cashed_buyer', function (e) {
    e.preventDefault();
    var self = $(this);
    var group_offer_id = $(this).attr('data-group-offer-id');
    var offer_id = $(this).attr('data-offer-id');
    Swal.fire({
        title: ays_en_msg,
        text: ays_cashed_en_msg,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#13153B',
        confirmButtonText: yes_en_msg,
        cancelButtonText: cancle_en_msg
    }).then((result) => {
        if (result.isConfirmed) {
            var is_cashed = 'No';
            $('#is_cashed_offer_id_').val(offer_id);
            $('#is_cashed_group_offer_id_').val(group_offer_id);
            $('#is_cashed_type_').val('group_offer');
            $('#deal_cashed_multiple_modal').modal('show');
        } else {
            $('#is_cashed_offer_id_').val('');
            $('#is_cashed_group_offer_id_').val('');
            $('#is_cashed_type_').val('group_offer');
            self.prop('checked', false);
            $('#deal_cashed_multiple_modal').modal('hide');
        }
    });
});

$(document).on('click', '.deal_cashed_multiple_modal_close', function (e) {
    e.preventDefault();
    $('#is_cashed_offer_id_').val('');
    $('#is_cashed_group_offer_id_').val('');
    $('#is_cashed_type_').val('group_offer');
    $('#deal_cashed_multiple_modal').modal('hide');
});

$(document).on('click', '.evt_deals_feedback_modal_close', function(e) {
    e.preventDefault();
    $('#evt_deals_feedback_modal').modal('hide');
    $('body .evt_is_cashed_switch').prop('checked', false);
});

$(document).on('submit', '#deal_cashed_multiple_modal', function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: URL_IS_CASHED + '/' + OFFER_SLUG,
        data: $('#deal_cashed_multiple_form').serialize(),
        dataType: 'json',
        success: function (res) {
            unsetLoadin();
            if (res.status == true) {
                toastr.success(res.message);
                // location.reload();
                $('#is_cashed_offer_id').val('');
                $('#is_cashed_group_offer_id').val('');
                $('#is_cashed_type').val('group_offer');
                $('#deal_cashed_multiple_modal').modal('hide');
            } else {
                toastr.error(res.message);
            }
        },
        error: function (xhr) {
            $('#deal_cashed_multiple_modal').modal('hide');
            unsetLoadin();
            ajaxErrorMsg(xhr);
        }
    });
});

$(document).on('click', '.evt_is_cashed_dispute_buyer', function (e) {
    e.preventDefault();
    var group_offer_id = $(this).attr('data-group-offer-id');
    var offer_id = $(this).attr('data-offer-id');
    $('#is_dispute_offer_id_').val(offer_id);
    $('#is_dispute_group_offer_id_').val(group_offer_id);
    $('#is_dispute_type_').val('group_offer');
    $('#deal_dispute_multiple_modal').modal('show');
});

$(document).on('submit', '#deal_dispute_multiple_form', function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: URL_IS_DISPUTE + '/' + OFFER_SLUG,
        data: $('#deal_dispute_multiple_form').serialize(),
        dataType: 'json',
        success: function (res) {
            unsetLoadin();
            if (res.status == true) {
                toastr.success(res.message);
                location.reload();
                $('#is_dispute_offer_id_').val('');
                $('#is_dispute_group_offer_id_').val('');
                $('#is_dispute_type_').val('group_offer');
                $('#deal_dispute_multiple_modal').modal('hide');
            } else {
                toastr.error(res.message);
            }
        },
        error: function (xhr) {
            $('#deal_dispute_multiple_modal').modal('hide');
            unsetLoadin();
            ajaxErrorMsg(xhr);
        }
    });
});


$(document).on('change', '#evt_deals_chk_all_operation', function (e) {
    e.preventDefault();
    var checked = $(this).is(':checked');
    if (checked) {
        $('.evt_deals_chk_single_operation').prop('checked', true);
    } else {
        $('.evt_deals_chk_single_operation').prop('checked', false);
    }
});

$(document).on('click', '#evt_cash_review', function (e) {
    e.preventDefault();
    var deals_opeartion_ids = [];
    var total_operation = $('.evt_deals_chk_single_operation:checked').length;
    if (total_operation > 0) {
        $(".evt_deals_chk_single_operation").each(function () {
            if ($(this).is(':visible') && $(this).prop('checked')) {
                deals_opeartion_ids.push($(this).val());
            }
        });

        $.ajax({
            type: "POST",
            url: URL_MULTIPLE_FEEDBACK + '/' + OFFER_SLUG,
            data: { 'feedback_ids': deals_opeartion_ids.toString(), 'type' : "cash_feedback" },
            dataType: 'json',
            success: function (res) {
                unsetLoadin();
                if (res.status == true) {
                    $('#ajax_deals_feedback_modal').html(res.data.dhtml);
                    $('#evt_deals_feedback_modal').modal('show');
                    initRating();
                } else {
                    toastr.error(res.message);
                }
            },
            error: function (xhr) {
                unsetLoadin();
                ajaxErrorMsg(xhr);
            }
        });
    } else {
        toastr.error(please_sel_at_list_one_chkbox_cashed_en_msg);
    }
});

function initRating() {
    $('div.evt_feedback_rateit, span.rateit').rateit({
        resetable: false,
    });

    $('.evt_feedback_rateit').on('beforerated', function (e, value) {
        $(this).attr('data-rateit-value', value);
        var _index = $(this).attr('data-index');
        $(`#sell_feedback_rate_${_index}`).val(value);
    });

    $('div.evt_issuer_rateit, span.rateit').rateit({
        resetable: false,
    });

    $('.evt_issuer_rateit').on('beforerated', function (e, value) {
        $(this).attr('data-rateit-value', value);
        var _index = $(this).attr('data-index');
        $(`#pay_issuer_rate_${_index}`).val(value);
    });

    $('.evt_cashed_date').daterangepicker({
        maxDate: moment().endOf('day'),
        autoUpdateInput: false,
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

$(document).on('click', '.evt_next_btn', function (e) {
    e.preventDefault();
    var total_form = parseInt($(this).attr('data-total-form'));
    var form_name = $(this).attr('data-form-name');
    var next_id = parseInt($(this).attr('data-next-id'));
    var form_obj = $(form_name);
    $.ajax({
        type: "POST",
        url: form_obj.attr('action'),
        data: $(form_name).serialize(),
        dataType: 'json',
        success: function (res) {
            unsetLoadin();
            if (res.status == true) {
                toastr.success(res.message);

                if (total_form >= next_id) {
                    $('body .common_hide_show').hide();
                    $(`#hide_show_${next_id}`).show();
                } else {
                    $('#evt_deals_feedback_modal').modal('hide');
                    toastr.error(next_form_not_avail_en_msg);
                }

            } else {
                toastr.error(res.message);
            }
        },
        error: function (xhr) {
            unsetLoadin();
            ajaxErrorMsg(xhr);
        }
    });
});

$(document).on('click', '.evt_prev_btn', function (e) {
    e.preventDefault();

    var total_form = parseInt($(this).attr('data-total-form'));
    var form_name = $(this).attr('data-form-name');
    var next_id = parseInt($(this).attr('data-next-id'));
    var form_obj = $(form_name);
    
    if (total_form >= next_id) {
        $('body .common_hide_show').hide();
        $(`#hide_show_${next_id}`).show();
    } else {
        toastr.error(next_form_not_avail_en_msg);
    }

    /*  var prev_id = parseInt($(this).attr('data-prev-id'));
    if (prev_id > 0) {
        $('body .common_hide_show').hide();
        console.log('prev_id', prev_id);
        $(`#hide_show_${prev_id}`).show();
    } else {
        $('#evt_deals_feedback_modal').modal('hide');
        toastr.error('Prev form not available');
    } */
});

$(document).on('click', '.evt_is_cashed_feedback_buyer', function (e) {
    e.preventDefault();
    var group_offer_id = $(this).attr('data-group-offer-id');
    var offer_id = $(this).attr('data-offer-id');
    
    if (group_offer_id > 0) {
        $.ajax({
            type: "POST",
            url: URL_MULTIPLE_FEEDBACK + '/' + OFFER_SLUG,
            data: { 'feedback_ids': group_offer_id, 'type' : "feedback"},
            dataType: 'json',
            success: function (res) {
                unsetLoadin();
                if (res.status == true) {
                    $('#ajax_deals_feedback_modal').html(res.data.dhtml);
                    $('#evt_deals_feedback_modal').modal('show');
                    initRating();
                } else {
                    toastr.error(res.message);
                }
            },
            error: function (xhr) {
                unsetLoadin();
                ajaxErrorMsg(xhr);
            }
        });
    }
});

$(document).on('click', '.evt_frm_one_tras', function (e) {
    e.preventDefault();
    var obj = $(this);
    var form_name = $(this).attr('data-form-name');
    $(form_name).find('.evt_frm_one_tras').parents().removeClass('active');
    $('body .evt_frm_one_tras:visible').prop('checked', false);
    obj.parents().addClass('active');
    $(this).prop('checked', true);
    // sell_trans_doctype
});

$(document).on('click', '.evt_frm_one_doc:visible', function (e) {
    e.preventDefault();
    $('body .evt_frm_one_doc:visible').parents().removeClass('active');
    $('body .evt_frm_one_doc:visible').prop('checked', false);
    $(this).attr('checked', 'checked');
    $(this).parents().addClass('active');
});

$(document).on('click', '.evt_frm_one_pay:visible', function (e) {
    e.preventDefault();
    $('body .evt_frm_one_pay:visible').parents().removeClass('active');
    $('body .evt_frm_one_pay:visible').prop('checked', false);
    $(this).attr('checked', 'checked');
    $(this).parents().addClass('active');
});

$(document).on('click', '.evt_frm_one_cash:visible', function (e) {
    e.preventDefault();
    $('body .evt_frm_one_cash:visible').parents().removeClass('active');
    $('body .evt_frm_one_cash:visible').prop('checked', false);
    $(this).attr('checked', 'checked');
    $(this).parents().addClass('active');
});
