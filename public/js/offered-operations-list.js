
$(document).ready(function () {
    $(".js-example-basic-multiple").select2({
        tags: true,
        tokenSeparators: [',', ' ']
    });

    $('#next_page_url').hide();
    loadMoreOfferedOperationsData();

    $(document).on('change', '#sort_type_offered_operation', debounce(function (e) {
        e.preventDefault();
        var self = $(this);
        var total_offered_operations = $('.total_offered_operations').length;
        if (total_offered_operations != 0) {
            $('#ajax_offered_operations_list').empty();
            loadMoreOfferedOperationsData();
        }
    }, 200));

    $(document).on('click', '.evt_paginate_operations .pagination a', function (e) {
        e.preventDefault();
        var page_no = $(this).attr('href').split('page=')[1];
        loadMoreOfferedOperationsData(page_no);
    });

    $(document).on('click', '.evt_got_to_page', function (e) {
        e.preventDefault();
        var self = $(this);
        var last_page_no = self.attr('data-last-page');
        var input_page_no = $('#page_no').val();

        if (parseInt(last_page_no) >= parseInt(input_page_no)) {
            loadMoreOfferedOperationsData($('#page_no').val());
        } else {
            toastr.error(`Maximum page no ${last_page_no}`);
        }
    });


    $(document).on('click', '.update_offered_operations', function () {
        var self = $(this);
        var form_valid = true;

        var offer_id = self.attr('data-offer-id');
        var offer_dealmode = $('#offer_dealmode_' + offer_id);
        var offer_till = $('#offer_till_' + offer_id);
        var offer_amount = $('#offer_amount_' + offer_id);
        var offer_day_hour = $('#offer_day_hour_' + offer_id);
        var offer_retention = $('#offer_retention_' + offer_id);
        var operation_amount = $('#operation_amount_' + offer_id);
        var amount_requested = $('#amount_requested_' + offer_id);
        var offer_mipo_plus = $('#offer_mipo_' + offer_id).is(":checked");
        var accept_below_requested = $('#accept_below_requested_' + offer_id).val();

        var offer_amount_val = currency_inr(offer_amount);
        var offer_retention_val = currency_inr(offer_retention);

        var form_data = {
            'offer_id': offer_id,
            'offer_status': 'Pending',
            'offer_send': 'Buyer',
            'deal_mode': offer_dealmode.val(),
            'offer_till': offer_day_hour.val(),
            'offer_amount': offer_amount_val,
            'offer_day_hour': offer_till.val(),
            'retention': offer_retention_val,
            'is_mipo_plus': offer_mipo_plus
        }

        if (offer_retention_val != '') {
            if (parseInt(offer_retention_val) > parseInt(operation_amount.val())) {
                offer_retention.addClass('offer_error');
                toastr.error('retention amount must be less than seller operation amount.');
                form_valid = false;
            }

            if (parseInt(offer_amount_val) < parseInt(offer_retention_val)) {
                offer_retention.addClass('offer_error');
                toastr.error('retention amount must be less than offer amount.');
                form_valid = false;
            }
        }

        if (accept_below_requested == '1') {
            if (parseInt(offer_amount_val) > parseInt(operation_amount.val())) {
                offer_amount.addClass('offer_error');
                toastr.error('offer amount must be less than operation amount.');
                form_valid = false;
            }

            if (parseInt(amount_requested.val()) > parseInt(offer_amount_val)) {
                offer_amount.addClass('offer_error');
                toastr.error('offer amount must be amount requested.');
                form_valid = false;
            }
        }

        if (parseInt(offer_amount_val) > parseInt(operation_amount.val())) {
            offer_amount.addClass('offer_error');
            toastr.error('offer amount must be less than operation amount.');
            form_valid = false;
        }

        if (offer_id != '' && offer_amount_val != '' && form_valid == true) {
            setLoadin();
            $('#update_offer_popup').modal('hide');
            $.ajax({
                type: "POST",
                url: url_offered_operations_update,
                data: form_data,
                dataType: 'json',
                success: function (res) {
                    unsetLoadin();
                    if (res.status == true) {
                        $('#ajax_offered_operations_list').empty();
                        toastr.success(res.message);
                        loadMoreOfferedOperationsData(url_load_more_offered_operations_data);
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
            toastr.error('Please enter the valid value');
        }
    });

    $(document).on('click', '.evt_change_status_contract', function () {
        var self = $(this);
        var offer_id = self.attr('data-offer-id');
        var offer_status = self.attr('data-status');
        var form_data = {
            'offer_id': offer_id,
            'offer_status': offer_status,
        }

        if (offer_id != '' && offer_status != '') {
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure, you want to " + offer_status + " this?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0D6EFD',
                cancelButtonColor: '#2E365A',
                confirmButtonText: 'Yes, ' + offer_status + ' it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (offer_status == 'Approved') {
                        $.ajax({
                            type: "POST",
                            url: url_offered_approved_update_status,
                            data: form_data,
                            dataType: 'json',
                            success: function (res) {
                                unsetLoadin();
                                if (res.status == true) {
                                    $('#ajax_confrim_offer_contract').html(res.data.dhtml);
                                    $('#deals_contract_form')[0].reset();
                                    $('#confrim_offer_contract_modal').modal('show');
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
                        $.ajax({
                            type: "POST",
                            url: url_offered_counter_update_status,
                            data: form_data,
                            dataType: 'json',
                            success: function (res) {
                                unsetLoadin();
                                if (res.status == true) {
                                    toastr.success(res.message);
                                    loadMoreOfferedOperationsData();
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
                }
            })
        } else {
            toastr.error('Please select offer.');
        }
    });

    $(document).on('click', '.evt_change_status', function () {
        var self = $(this);
        var offer_id = self.attr('data-offer-id');
        var offer_status = self.attr('data-status');
        var form_data = {
            'offer_id': offer_id,
            'offer_status': offer_status,
        }

        if (offer_id != '' && offer_status != '') {
            var status_msg = "Are you sure, you want to " + offer_status + " this?";
            if(offer_status == 'Approved') {
                status_msg = ays_approve_en_msg;
            } else if(offer_status == 'Revert' || offer_status == 'Rejected') {
                status_msg = ays_revert_en_msg;
            }
            Swal.fire({
                title: ays_en_msg,
                text: status_msg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0D6EFD',
                cancelButtonColor: '#2E365A',
                confirmButtonText: yes_en_msg,
                cancelButtonText: cancle_en_msg
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: url_offered_counter_update_status,
                        data: form_data,
                        dataType: 'json',
                        success: function (res) {
                            unsetLoadin();
                            if (res.status == true) {
                                toastr.success(res.message);
                                loadMoreOfferedOperationsData();
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
            })
        } else {
            toastr.error('Please select offer.');
        }
    });
});

$(document).on('click', '.evt_ex_operations_details', function (e) {
    e.preventDefault();
    var details_link = $(this).attr('data-operations-details-link');
    window.location.href = details_link;
});

function loadMoreOfferedOperationsData(page_no = null) {
    $.ajax({
        type: 'POST',
        url: url_load_more_offered_operations_data + '?page=' + page_no,
        data: 'sort_type=' + $('#sort_type_offered_operation').val(),
        dataType: 'json',
        cache: false,
        beforeSend: function() {
            // setLoadin();
            $('#ajax_offered_operations_list').html(offeredOperationsPage.list());
        },
        success: function (res) {
            // unsetLoadin();
            if (res.status == true) {
                $('#ajax_offered_operations_list').html(res.data.dhtml);
                // initFunction();
            } else {
                toastr.error(res.message);
            }
        },
        error: function (xhr) {
            // unsetLoadin();
            ajaxErrorMsg(xhr);
        }
    });
}

function initFunction() {
    $('.document_slider').owlCarousel({
        loop: true,
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

    $(".show_more_btn a").on('click', function (e) {
        $(this).parents('.top_part_cheque').find('.dropdown_wrap').slideToggle(500);
        $(this).parents('.top_part_cheque').find('.dropdown_wrap').toggleClass('open_dropdown_wrap');
        $(this).parent().toggleClass('active');
        if ($(this).parents('.top_part_cheque').find('.dropdown_wrap').hasClass("open_dropdown_wrap")) {
            $(this).find('span').text("Show less");
        } else {
            $(this).find('span').text("Show more");
        }
        e.stopPropagation();
    });

    $('.filter_selectprice input:checkbox').change(function () {
        if ($(this).is(":checked")) {
            $(this).parents('.filter_selectprice').addClass("active_payment");
        } else {
            $(this).parents('.filter_selectprice').removeClass("active_payment");
        }
    });
}

$(document).on('click', '.evt_offered_list', function (e) {
    e.preventDefault();
    var offer_id = $(this).attr('data-offer-id');
    var currency_name = $(this).attr('data-currency-name');

    if (offer_id == '') {
        toastr.error('something went wrong please try again!');
        return false;
    }
    // setLoadin();
    $.ajax({
        type: 'POST',
        url: url_offered_operations_history,
        data: {
            'offer_id': offer_id,
            'currency_name': currency_name,
        },
        dataType: 'json',
        cache: false,
        success: function (res) {
            // unsetLoadin();
            if (res.status == true) {
                $('#ajax_offered_history_list').html(res.data.dhtml);
                $('#offered_history_modal').modal('show');
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

$(document).on('click', '.evt_update_offer_popup', function (e) {
    e.preventDefault();
    var offer_id = $(this).attr('data-offer-id');

    if (offer_id == '') {
        toastr.error('something went wrong please try again!');
        return false;
    }
    
    $.ajax({
        type: 'POST',
        url: url_offered_by_id,
        data: {
            'offer_id': offer_id,
            'action': 'update',
        },
        dataType: 'json',
        cache: false,
        success: function (res) {
            if (res.status == true) {
                $('#ajax_update_offer_view').html(res.data.dhtml);
                $('#update_offer_popup').modal('show');
                $('.init-nice-select').niceSelect();
            } else {
                toastr.error(res.message);
            }
        },
        error: function (xhr) {
            ajaxErrorMsg(xhr);
        }
    });
});

$(document).on('click', '.evt_group_offer_by_operation', function (e) {
    e.preventDefault();
    var offer_id = $(this).attr('data-offer-id');

    if (offer_id == '') {
        toastr.error('something went wrong please try again!');
        return false;
    }
    $.ajax({
        type: 'POST',
        url: url_offered_by_id,
        data: {
            'offer_id': offer_id,
            'action': 'list',
        },
        dataType: 'json',
        cache: false,
        beforeSend: function() {
            $('#group_offer_operation_popup').modal('show');
            $('#ajax_group_offer_operation_view').html(offeredOperationsPage.modalOfferGroupByOpearionList());
        },
        success: function (res) {
            unsetLoadin();
            if (res.status == true) {
                $('#ajax_group_offer_operation_view').html(res.data.dhtml);
            } else {
                toastr.error(res.message);
                $('#group_offer_operation_popup').modal('hide');
            }
        },
        error: function (xhr) {
            ajaxErrorMsg(xhr);
            $('#group_offer_operation_popup').modal('hide');
        }
    });
});

/* calculation */
$(document).on('change', '.evt_change', function(e) {
    e.preventDefault();
    var self = $(this);
    const operation_id = self.attr('data-operation-id');
    const seller_id = self.attr('data-seller-id');
    calculationCurrentOperation(seller_id, operation_id);
});

$(document).on('change', '.evt_is_mipo_plus', function (e) {
    e.preventDefault();
    var self = $(this);
    var checked = $(this).is(':checked');
    var seller_id = $(this).attr('data-seller-id');
    var operation_id = $(this).attr('data-operation-id');

    calculationCurrentOperation(seller_id, operation_id);
});

function calculationCurrentOperation(seller_id, operation_id) {
    var current_operation_obj = $(`body #single_operation_info_${operation_id}`);
    var seller_name = current_operation_obj.attr('data-seller-name');
    var issuer_name = current_operation_obj.attr('data-issuer-name');
    var operation_type = current_operation_obj.attr('data-operation-type');
    var operation_number = current_operation_obj.attr('data-operation-number');
    var currency_type = preferred_currency;
    var preferred_currency = current_operation_obj.attr('data-currency-type');
    var offer_id = current_operation_obj.attr('data-offer-id');
    var MIPO_COMMISSION = current_operation_obj.attr('data-investor-commission');
    var MIPO_ADD_COMMISSION = current_operation_obj.attr('data-mipo-commission');

    console.log('MIPO_COMMISSION', MIPO_COMMISSION);
    console.log('MIPO_ADD_COMMISSION', MIPO_ADD_COMMISSION);

    var real_time_offer_amount = retention_amount = offer_time = null;

    operation_amount = parseFloat($('body #offer_retention_' + offer_id).attr("data-operation-amount")).toFixed(2);
        
    retention_amount = currency_inr($(`body #offer_retention_${offer_id}`));

    real_time_offer_amount = currency_inr($(`body #offer_amount_${offer_id}`));

    var is_mipo_checked = $(`body #offer_mipo_${offer_id}`).is(":checked");

    var new_operation_amount = new_retention_amount = new_real_time_offer_amount = 0;
    if (preferred_currency == USD) {
        new_operation_amount = $.number(operation_amount, 2, ',', '.');
        new_retention_amount = $.number(retention_amount, 2, ',', '.');
        new_real_time_offer_amount = $.number(real_time_offer_amount, 2, ',', '.');
    } else if (preferred_currency == PYGH) {
        new_operation_amount = $.number(operation_amount, 0, ',', '.');
        new_retention_amount = $.number(retention_amount, 0, ',', '.');
        new_real_time_offer_amount = $.number(real_time_offer_amount, 0, ',', '.');
    }

    $('body #current_operation_amount').text(new_operation_amount);

    $('body #current_rentention_amount').text(new_retention_amount);

    $('body #current_real_time_offer').text(new_real_time_offer_amount);

    var current_operation_retention_amount = (operation_amount - retention_amount);

    var new_current_operation_amount = 0;
    if (preferred_currency == USD) {
        new_operation_amount = $.number(current_operation_retention_amount, 2, ',', '.');
    } else if (preferred_currency == PYGH) {
        new_operation_amount = $.number(current_operation_retention_amount, 0, ',', '.');
    }

    $(`body #current_operation_rentention_amount`).text(new_current_operation_amount);

    var current_overall_profit = (current_operation_retention_amount - real_time_offer_amount);

    var current_mipo_commission = ((current_overall_profit * MIPO_COMMISSION) / 100);

    console.log('current_mipo_commission', current_mipo_commission);

    var new_current_mipo_commission = 0;
    if (preferred_currency == USD) {
        new_current_mipo_commission = $.number(parseFloat(current_mipo_commission).toFixed(2), 2, ',', '.');
    } else if (preferred_currency == PYGH) {
        new_current_mipo_commission = $.number(parseFloat(current_mipo_commission).toFixed(2), 0, ',', '.');
    }

    $('body #current_mipo_commission').text(new_current_mipo_commission);

    var current_add_mipo_commission = null;
    if (is_mipo_checked) {
        current_add_mipo_commission = ((real_time_offer_amount * MIPO_ADD_COMMISSION) / 100);
    }

    var new_current_add_mipo_commission = 0;
    if (preferred_currency == USD) {
        new_current_add_mipo_commission = $.number(current_add_mipo_commission, 2, ',', '.');
    } else if (preferred_currency == PYGH) {
        new_current_add_mipo_commission = $.number(current_add_mipo_commission, 0, ',', '.');
    }

    $('body #current_add_mipo_commission').text(new_current_add_mipo_commission);

    var current_net_profit = (current_overall_profit - current_mipo_commission - current_add_mipo_commission);

    var new_current_net_profit = 0;
    if (preferred_currency == USD) {
        new_current_net_profit = $.number(Math.round(parseFloat(current_net_profit).toFixed(2)), 2, ',', '.');
    } else if (preferred_currency == PYGH) {
        new_current_net_profit = $.number(Math.round(parseFloat(current_net_profit).toFixed(2)), 0, ',', '.');
    }

    console.log('new_current_net_profit', new_current_net_profit);
    $('body #current_net_profit').text(new_current_net_profit);
}

function getStrignToNumber(str_val) {
    return (str_val != '') ? parseInt(str_val) : '';
}


$('input[type=radio][name=sort_type_offered_operation]').change(function() {
    var self = $(this);
    var total_offered_operations = $('.total_offered_operations').length;
    if (total_offered_operations != 0) {
        $('#ajax_offered_operations_list').empty();
        $('#sort_type_offered_operation').val(self.val());
        // $('.mobile_sortby').hide();
        loadMoreOfferedOperationsData();
    }
});