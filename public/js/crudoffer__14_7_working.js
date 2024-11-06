var modal_offer_seller_arr = [];
var explore_operation_ids = new Array();
var preferred_currency = USD;
$(document).ready(function () {

    $('#chk_all_explore').click(function () {
        var checked = $(this).is(':checked');
        if (checked) {
            $('.explore_operation_ids').prop('checked', true);
        } else {
            $('.btn_group_offer').text('Offer');
            $('.btn_group_offer').prop('disabled', false);
            $('.explore_operation_ids').prop('checked', false);
        }

        $('.btn_group_offer').prop('disabled', true);
        var total_offers = $(".explore_operation_ids:checked").length;

        if (total_offers > 0) {
            $('.btn_group_offer').text('Offer');
            $('.btn_group_offer').prop('disabled', false);
        }

        if (total_offers > 1) {
            $('.btn_group_offer').text('Group Offer');
        }
    });

    // JS FOR EXPLORE PAGE OFFER BUTTON CLICK
    $('.btn_group_offer').click(function (e) {
        e.preventDefault();
        explore_operation_ids = [];
        var explore_operation_currenc_usd = new Array();
        var explore_operation_currenc_pygh = new Array();

        $(".explore_operation_ids").each(function () {
            if ($(this).is(':visible') && $(this).prop('checked')) {

                if ($(this).attr('data-currency-type') == USD) {
                    $('.add_currency_js').text(USD_SIGN);
                    explore_operation_currenc_usd.push($(this).attr('data-currency-type'));
                }

                if ($(this).attr('data-currency-type') == PYGH) {
                    $('.add_currency_js').text(PYGH_SIGN);
                    explore_operation_currenc_pygh.push($(this).attr('data-currency-type'));
                }

                explore_operation_ids.push($(this).val());
            }
        });
        if (explore_operation_currenc_usd.length == 0 && explore_operation_currenc_pygh.length == 0) {
            $('#group_modal').modal('hide');
            toastr.error('Please select explore operations');
        } else {
            var preferred_currency = USD;
            if (explore_operation_currenc_usd.length == 0) {
                preferred_currency = PYGH;
            }
            checkGroupList(url_get_explore_operations_group, explore_operation_ids, preferred_currency);
        }
    });
});

// JS FOR EXPLORE PAGE LIST CHECKBOX 
$(document).on('change', '.explore_operation_ids', function (e) {
    e.preventDefault();

    $('.btn_group_offer').prop('disabled', true);
    var total_offers = $(".explore_operation_ids:checked").length;

    if (total_offers > 0) {
        $('.btn_group_offer').text('Offer');
        $('.btn_group_offer').prop('disabled', false);
    }

    if (total_offers > 1) {
        $('.btn_group_offer').text('Group Offer');
    }
});

// JS FOR MODEL OPEN  CHANGE CURRENCY 
$(document).on('change', '#group_offer_change_currency', function (e) {
    e.preventDefault();
    preferred_currency = USD;
    $('.add_currency_js').text(USD_SIGN);
    if ($(this).is(':checked') == true) {
        $('.add_currency_js').text(PYGH_SIGN);
        preferred_currency = PYGH;
        $('#pyg_tab').css('display', 'block');
        $('#usd_tab').css('display', 'none');
    } else {
        $('#pyg_tab').css('display', 'none');
        $('#usd_tab').css('display', 'block');
    }
    calculationAllOperation();
});

// JS FOR EXPLORE PAGE MODEL OPEN LIST
function checkGroupList(ajax_url, explore_operation_ids, preferred_currency) {
    if (explore_operation_ids.length != 0) {
        modal_offer_seller_arr = [];
        setLoadin();
        $.ajax({
            type: 'POST',
            url: ajax_url,
            data: { 'operations_ids': explore_operation_ids, 'preferred_currency': preferred_currency },
            dataType: 'json',
            cache: false,
            success: function (res) {
                explore_operation_ids = [];
                unsetLoadin();
                if (res.status == true) {
                    $('#group_modal').modal('show');
                    $('#ajax_group_explore_operation').html(res.data.dhtml);

                    // modal_page_data
                    $('.evt_div_group_by_seller').each(function (index) {
                        var self = $(this);
                        var seller_id = self.attr('data-seller-id');
                        var seller_name = self.attr('data-seller-name');
                        var operaion_ids = [];
                        var operaion_mipo_ids = [];

                        $(`.group_operation_ids_${seller_id}`).each(function (index_operation_id) {
                            operaion_ids.push($(this).attr('data-operation-id'));
                        });

                        $(`.group_mipo_operation_ids_${seller_id}`).each(function (index_operation_mipo_id) {
                            operaion_mipo_ids.push($(this).attr('data-operation-id'));
                        });

                        var modal_offer_seller = {
                            'seller_id': seller_id,
                            'seller_name': seller_name,
                            'seller_operation_details': {
                                'total_both_operation': (document.getElementsByClassName(`remove_mipo_group_by_seller_${seller_id}`).length + document.getElementsByClassName(`remove_operation_group_by_seller_${seller_id}`).length),
                                'total_operation_mipo': document.getElementsByClassName(`remove_mipo_group_by_seller_${seller_id}`).length,
                                'total_operation': document.getElementsByClassName(`remove_operation_group_by_seller_${seller_id}`).length,
                                'total_operation_ids': operaion_ids,
                                'total_operation_mipo_ids': operaion_mipo_ids,
                                'total_seller_by_offer_ids': operaion_mipo_ids.concat(operaion_ids)
                            }
                        };
                        modal_offer_seller_arr.push(modal_offer_seller);
                    });

                    if (preferred_currency == USD) {
                        $('body #group_offer_change_currency').prop('checked', false).trigger('change');
                    }

                    if (preferred_currency == PYGH) {
                        $('body #group_offer_change_currency').prop('checked', true).trigger('change');
                    }

                    $(".selectbox").niceSelect();
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
        $('#group_modal').modal('hide');
        toastr.error('Please select explore operations');
    }
}

$(document).on('keyup', '.evt_input', function (e) {
    e.preventDefault();
    var self = $(this);
    singelOperationValidation(self);
});

$(document).on('focus', '.evt_input', function (e) {
    e.preventDefault();
    var self = $(this);
    singelOperationValidation(self);
});

$(document).on('change', '.evt_change', function (e) {
    e.preventDefault();
    var self = $(this);
    singelOperationValidation(self);
});

$(document).on('click', '.evt_click_single_mipo', function (e) {
    var self = $(this);
    singelOperationValidation(self);
    overallOperationSummary();
});

function singelOperationValidation(obj) {
    var self = $(obj);
    self.removeClass('offer_error');
    var valid_form = true;
    var offer_amount = retention_amount = offer_time = 0;
    var currency_type = self.attr('data-currency-type');
    const seller_id = self.attr('data-seller-id');
    const operation_id = self.attr('data-operation-id');
    const input_name = self.attr('data-name');
    const operation_obj = $('#single_operation_info_' + operation_id);
    const current_operation_amount = parseInt(operation_obj.attr('data-operation-amount'));
    const document_amount = parseInt(operation_obj.attr('data-amount-requested'));
    const accept_below_document_amount_requested = parseInt(operation_obj.attr('data-accept-below-requested'));

    var obj_retention_amount = $('#retention_' + operation_id);
    var obj_offer_amount = $('#offer_amount_' + operation_id);
    var obj_offer_time = $('#offer_time' + operation_id);

    obj_retention_amount.removeClass('offer_error');
    obj_offer_amount.removeClass('offer_error');
    obj_offer_time.removeClass('offer_error');

    offer_amount = currency_type_amount_sum(null, currency_type, $('#offer_amount_' + operation_id).val());
    console.log('offer_amountoffer_amount', offer_amount);
    retention_amount = currency_type_amount_sum(null, currency_type, $('#retention_' + operation_id).val());
    offer_time = getStrignToNumber($('#offer_time_' + operation_id).val());

    if ((offer_amount > current_operation_amount) || (offer_amount.length == 0 || offer_amount == '')) {
        obj_offer_amount.addClass('offer_error');
        valid_form = false;
    }

    if (accept_below_document_amount_requested == 1) {
        if (offer_amount > document_amount || offer_amount < document_amount) {
            valid_form = true;
        }
    } else {
        if (document_amount > offer_amount) {
            valid_form = false;
        }
    }

    if (current_operation_amount < offer_amount) {
        valid_form = false;
    }

    if (retention_amount != '') {
        if (retention_amount > offer_amount) {
            obj_retention_amount.addClass('offer_error');
            valid_form = false;
        }

        if (retention_amount > current_operation_amount) {
            obj_retention_amount.addClass('offer_error');
            valid_form = false;
        }
    }

    if (offer_time.length > MAX_HOUR_DAY_LENGTH) {
        obj_offer_time.addClass('offer_error');
        toastr.error(`Maximum character length ${MAX_HOUR_DAY_LENGTH} .`);
        valid_form = false;
    }

    var deal_mode = $('#deal_mode_' + operation_id).val();
    $('#payment_opt').text(deal_mode);

    if (valid_form) {
        $('#btn_sent_offer_' + operation_id).prop('disabled', false);
    } else {
        $('#btn_sent_offer_' + operation_id).prop('disabled', true);
    }

    calculationCurrentOperation(seller_id, operation_id);

    return valid_form;
}

$(document).on('keyup', '.evt_input_group', function (e) {
    e.preventDefault();
    var self = $(this);
    groupOperationValidation(self);
});

$(document).on('change', '.evt_change_group', function (e) {
    e.preventDefault();
    var self = $(this);
    groupOperationValidation(self);
});

function groupOperationValidation(obj) {
    var self = $(obj);
    self.removeClass('offer_error');

    var valid_form = true;
    var offer_amount = retention_amount = offer_time = 0;

    const seller_id = self.attr('data-seller-id');
    const operation_id = self.attr('data-operation-id');
    const input_name = self.attr('data-name');
    const preferred_currency = self.attr('data-currency-type');
    const operation_obj = $(`.group_operation_info_${seller_id}[data-currency-type='${preferred_currency}']`);
    const current_operation_total_amount = parseInt(operation_obj.attr('data-operation-total-amount'));

    var obj_retention_amount = $(`.grp_ret_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
    var obj_offer_amount = $(`.grp_offer_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
    var obj_offer_time = $(`.grp_time_till_${seller_id}[data-currency-type='${preferred_currency}']:visible`);

    obj_retention_amount.removeClass('offer_error');
    obj_offer_amount.removeClass('offer_error');
    obj_offer_time.removeClass('offer_error');

    retention_amount = currency_type_amount_sum(null, preferred_currency, $(`.grp_ret_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`).val());
    offer_amount = currency_type_amount_sum(null, preferred_currency, $(`.grp_offer_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`).val());
    offer_time = getStrignToNumber($(`.grp_time_till_${seller_id}[data-currency-type='${preferred_currency}']:visible`).val());

    if (offer_amount == 0 || offer_amount == '') {
        obj_retention_amount.addClass('offer_error');
        // toastr.error('offer amount require.');
        valid_form = false;
    }

    if (retention_amount > current_operation_total_amount) {
        obj_retention_amount.addClass('offer_error');
        // toastr.error('retention must be less than operation amount.');
        valid_form = false;
    }

    if (retention_amount > offer_amount) {
        obj_retention_amount.addClass('offer_error');
        // toastr.error('retention must be less than offer amount.');
        valid_form = false;
    }

    if ((offer_amount > current_operation_total_amount) || (offer_amount.length == 0 || offer_amount == '')) {
        obj_offer_amount.addClass('offer_error');
        // toastr.error('offer amount must be less than operation amount.');
        valid_form = false;
    }

    // if (input_name == 'offer_time') {
    if (offer_time.length > MAX_HOUR_DAY_LENGTH) {
        obj_offer_time.addClass('offer_error');
        toastr.error(`maximum character length ${MAX_HOUR_DAY_LENGTH} .`);
        valid_form = false;
    }
    // }

    // if (input_name == 'payment_method') {
    var deal_mode = $(`.grp_payment_${seller_id}[data-currency-type='${preferred_currency}']`).val();
    $('#payment_opt:visible').text(deal_mode);
    // }

    if (valid_form) {
        $(`.grp_offer_btn_${seller_id}[data-currency-type='${preferred_currency}']`).prop('disabled', false);
    } else {
        $(`.grp_offer_btn_${seller_id}[data-currency-type='${preferred_currency}']`).prop('disabled', true);
    }
    overallOperationSummary();

    return valid_form;
}

$(document).on('change', '.evt_seller_group_mipo_checkbox', function (e) {
    var self = $(this);
    var checked = $(this).is(':checked');
    var seller_id = $(this).attr('data-seller-id');
    var operaion_id = $(this).attr('data-operation-id');

    groupMipoOperationValidation(self);
    // Select all
    if (checked) {
        $('.single_mipo_verified_' + seller_id).each(function () {
            $(this).prop("checked", true);
        });

    } else {
        // Deselect All
        $('.single_mipo_verified_' + seller_id).each(function () {
            $(this).prop("checked", false);
        });
    }
    overallOperationSummary();
});

$(document).on('keyup', '.evt_input_group_mipo', function (e) {
    e.preventDefault();
    var self = $(this);
    groupMipoOperationValidation(self);
});

$(document).on('change', '.evt_change_group_mipo', function (e) {
    e.preventDefault();
    var self = $(this);
    groupMipoOperationValidation(self);
});

function groupMipoOperationValidation(obj) {
    var self = $(obj);
    self.removeClass('offer_error');

    var valid_form = true;
    var offer_amount = retention_amount = offer_time = 0;

    const seller_id = self.attr('data-seller-id');
    const operation_id = self.attr('data-operation-id');
    const input_name = self.attr('data-name');
    const preferred_currency = self.attr('data-currency-type');

    const operation_obj = $(`.group_operation_info_${seller_id}[data-currency-type='${preferred_currency}']`);
    const current_operation_total_amount = parseInt(operation_obj.attr('data-operation-total-amount'));

    var obj_retention_amount = $(`.grp_mipo_ret_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
    var obj_offer_amount = $(`.grp_mipo_offer_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
    var obj_offer_time = $(`.grp_mipo_time_till_${seller_id}[data-currency-type='${preferred_currency}']:visible`);

    obj_retention_amount.removeClass('offer_error');
    obj_offer_amount.removeClass('offer_error');
    obj_offer_time.removeClass('offer_error');

    retention_amount = currency_type_amount_sum(null, preferred_currency, $(`.grp_mipo_ret_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`).val());
    offer_amount = currency_type_amount_sum(null, preferred_currency, $(`.grp_mipo_offer_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`).val());
    offer_time = getStrignToNumber($(`.grp_mipo_time_till_${seller_id}[data-currency-type='${preferred_currency}']:visible`).val());

    if (offer_amount == 0 || offer_amount == '') {
        obj_retention_amount.addClass('offer_error');
        valid_form = false;
    }
    if (retention_amount > current_operation_total_amount) {
        obj_retention_amount.addClass('offer_error');
        valid_form = false;
    }
    if (retention_amount > offer_amount) {
        obj_retention_amount.addClass('offer_error');
        valid_form = false;
    }
    if ((offer_amount > current_operation_total_amount) || (offer_amount.length == 0 || offer_amount == '')) {
        obj_offer_amount.addClass('offer_error');
        valid_form = false;
    }

    if (offer_time.length > MAX_HOUR_DAY_LENGTH) {
        obj_offer_time.addClass('offer_error');
        toastr.error(`maximum character length ${MAX_HOUR_DAY_LENGTH} .`);
        valid_form = false;
    }

    var deal_mode = $(`.grp_mipo_payment_${seller_id}[data-currency-type='${preferred_currency}']:visible`).val();
    $('#payment_opt:visible').text(deal_mode);

    if (valid_form) {
        $(`.grp_mipo_offer_btn_${seller_id}[data-currency-type='${preferred_currency}']:visible`).prop('disabled', false);
    } else {
        $(`.grp_mipo_offer_btn_${seller_id}[data-currency-type='${preferred_currency}']:visible`).prop('disabled', true);
    }
    overallOperationSummary();

    return valid_form;
}

$(document).on('click', '.evt_submit_sent_offer', function (e) {
    var self = $(this);
    const seller_id = self.attr('data-seller-id');
    const operation_id = self.attr('data-operation-id');
    const preferred_currency = self.attr('data-currency-type');
    singelOperationValidation(self);
    sentOffer(self, operation_id, seller_id, preferred_currency);
});

function sentOffer(btn_obj, operation_id, seller_id, preferred_currency) {
    var self = $(btn_obj);
    var seller_id = seller_id;
    var operation_amount = self.attr('data-operation-amount');
    var offer_name = self.attr('data-offer-type');
    var retention = $('#retention_' + operation_id);
    var deal_mode = $('#deal_mode_' + operation_id);
    var offer_till = $('#offer_time_' + operation_id);
    var offer_amount = $('#offer_amount_' + operation_id);
    var offer_day_hour = $('#offer_day_hour_' + operation_id);
    var is_mipo_plus = $('#mipo_verified_' + operation_id).is(":checked");
    var total_offer_seller = $(".total_seller_group_" + seller_id).length;
    
    var form_data = {
        'offer_type': SINGLE,
        'operation_id': operation_id,
        'seller_id': seller_id,
        'operation_amount': operation_amount,
        "retention": currency_inr(retention),
        "deal_mode": deal_mode.val(),
        "offer_till": offer_till.val(),
        "offer_amount":  currency_inr(offer_amount),
        'offer_day_hour': offer_day_hour.val(),
        'is_mipo_plus': is_mipo_plus
    }

    setLoadin();
    $.ajax({
        type: 'POST',
        url: url_save_group_offer,
        data: form_data,
        dataType: 'json',
        cache: false,
        success: function (res) {
            unsetLoadin();
            if (res.status == true) {
                toastr.success(res.message);

                $(`body #row_offer_remove_${operation_id}:visible`).remove();

                var total_single_operation = $(`.remove_operation_group_by_seller_${seller_id}[data-currency-type='${preferred_currency}']:visible`).length;
                if (total_single_operation == 0) {
                    $(`.remove_seller_group_${seller_id}[data-currency-type='${preferred_currency}']:visible`).remove();
                }

                var total_single_mipo_operation = $(`.remove_mipo_group_by_seller_${seller_id}[data-currency-type='${preferred_currency}']:visible`).length;
                if (total_single_mipo_operation == 0) {
                    $(`.remove_seller_group_mipo_${seller_id}[data-currency-type='${preferred_currency}']:visible`).remove();
                }

                if ((total_single_mipo_operation + total_single_operation) == 0) {
                    $(`.row_seller_name_remove_${seller_id}[data-currency-type='${preferred_currency}']`).remove();
                }

                var total_seller_by_currency = $(`.evt_div_group_by_seller[data-currency-type='${preferred_currency}`).length;
                if (total_seller_by_currency == 0 && preferred_currency == USD) {
                    $('body #group_offer_change_currency').prop('checked', true).trigger('change');
                }

                if (total_seller_by_currency == 0 && preferred_currency == PYGH) {
                    $('body #group_offer_change_currency').prop('checked', false).trigger('change');
                }

                if ($(`body .evt_div_group_by_seller:visible`).length == 0) {
                    $('#group_modal').modal('hide');
                }

                explore_operation_ids = explore_operation_ids.filter(e => e !== operation_id);

                const auto_first_offer_obj = $('.single_offer_amount:visible');
                const operation_id_new = auto_first_offer_obj.attr('data-operation-id');
                const seller_id_new = auto_first_offer_obj.attr('data-seller-id');

                calculationCurrentOperation(seller_id_new, operation_id_new);

                calculationAllOperation();
                // removeOffer(self, false);
                loadMoreExploreOperationsData();
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

$(document).on('click', '.evt_submit_sent_group_offer:visible', function (e) {
    var self = $(this);
    const seller_id = self.attr('data-seller-id');
    const operation_id = self.attr('data-operation-id');
    const btn_name = self.attr('data-btn-name');
    const preferred_currency = self.attr('data-currency-type');

    if (btn_name == 'btn_group_mipo') {
        groupMipoOperationValidation(self);
        sentGropuOffer(self, operation_id, seller_id, btn_name, preferred_currency);
    } else if (btn_name == 'btn_group') {
        groupOperationValidation(self);
        sentGropuOffer(self, operation_id, seller_id, btn_name, preferred_currency);
    } else {
        singelOperationValidation(self);
        sentGropuOffer(self, operation_id, seller_id, btn_name, preferred_currency);
    }
});

function placeOffer(obj) {
    var self = $(obj);
    $('.evt_submit_sent_group_offer:visible').each(function (index, val) {
        var self = $(this);
        const seller_id = self.attr('data-seller-id');
        const operation_id = self.attr('data-operation-id');
        const btn_name = self.attr('data-btn-name');
        const preferred_currency = self.attr('data-currency-type');
        var is_group_offer_mipo_checkbox = $(`#is_group_offer_mipo_checkbox_${seller_id}:visible`).is(':checked');
        var is_group_offer_checkbox = $(`#is_group_offer_checkbox_${seller_id}:visible`).is(':checked');
        if (btn_name == 'btn_group_mipo' && is_group_offer_mipo_checkbox == true) {
            var res = true;
            var offer_amount = $(`#seller_group_offer_mipo_amount_${seller_id}`).val();
            if (res && is_group_offer_mipo_checkbox == true) {
                if (offer_amount != '') {
                    sentGropuOffer(self, operation_id, seller_id, btn_name, preferred_currency);
                } else {
                    toastr.error('offer amount require.');
                }
            }
        } else if (btn_name == 'btn_group' && is_group_offer_checkbox == true) {
            var res = true;
            var offer_amount = $(`#seller_group_offer_amount_${seller_id}`).val();
            if (res && is_group_offer_checkbox == true) {
                if (offer_amount != '') {
                    sentGropuOffer(self, operation_id, seller_id, btn_name, preferred_currency);
                } else {
                    toastr.error('offer amount require.');
                }
            }
        }
    });

    $('.evt_submit_sent_offer:visible').each(function (index, val) {
        var self = $(this);
        const seller_id = self.attr('data-seller-id');
        const operation_id = self.attr('data-operation-id');
        const preferred_currency = self.attr('data-currency-type');
        var offer_amount = $(`#offer_amount_${operation_id}:visible`).val();
        if (offer_amount != '' && offer_amount > 0) {
            sentOffer(self, operation_id, seller_id, preferred_currency);
        } else {
            if (index == 0) {
                toastr.error('offer amount require.');
            }
        }
    });
}

function sentGropuOffer(self, operation_id, seller_id, btn_name = '', preferred_currency) {
    var form_valid = true;
    var offer_type = GROUP;
    var total_offer_seller = 0;
    var operation_forms = [];
    var is_group = true;

    var is_group_offer_mipo_checkbox = $(`.grp_offer_mipo_chk_${seller_id}[data-currency-type='${preferred_currency}']:visible`).is(':checked');

    var is_group_offer_checkbox = $(`.is_group_offer_checkbox_${seller_id}[data-currency-type='${preferred_currency}']:visible`).is(':checked');

    if (is_group_offer_mipo_checkbox == false && btn_name == 'btn_group_mipo') {
        toastr.error('Please checked group mipo checkbox');
        is_group = false;
        return false;
    } else if (is_group_offer_checkbox == false && btn_name == 'btn_group') {
        toastr.error('Please checked group checkbox');
        is_group = false;
        return false;
    }

    if (btn_name == 'btn_group_mipo') {
        total_offer_seller = $(`.total_seller_mipo_group_${seller_id}[data-currency-type='${preferred_currency}']:visible`).length;
    } else if (btn_name == 'btn_group') {
        total_offer_seller = $(`.total_seller_group_${seller_id}[data-currency-type='${preferred_currency}']:visible`).length;
    }

    if (total_offer_seller == 1 || total_offer_seller == 0) {
        var operation_ids = $(`.group_operation_ids_${seller_id}[data-currency-type='${preferred_currency}']`).val();
        offer_type = SINGLE;
        is_group = false;
    }

    if (offer_type == GROUP && btn_name == 'btn_group_mipo') {
        var operation_ids = [];
        $(`.group_mipo_operation_ids_${seller_id}[data-currency-type='${preferred_currency}']`).attr('data-currency-type', preferred_currency).each(function () {
            var operaion_id = $(this).val();
            if (operaion_id != '') {
                form_data = {
                    'operaion_id': operaion_id,
                    'seller_id': seller_id,
                    'operaion_amount': $(`#single_operation_info_${operaion_id}`).attr('data-operation-amount'),
                    'operaion_retention': currency_inr($(`#retention_${operaion_id}:visible`)),
                    'operaion_dealmode': $(`#deal_mode_${operaion_id}:visible`).val(),
                    'operaion_day_hour': $(`#offer_day_hour_${operaion_id}:visible`).val(),
                    'operaion_till': $(`#offer_time_${operaion_id}:visible`).val(),
                    'operaion_offer_amount': currency_inr($(`#offer_amount_${operaion_id}:visible`)),
                    'operaion_mipo_plus': $(`#mipo_verified_${operaion_id}:visible`).is(':checked') ? 'Yes' : 'No'
                }
                operation_ids.push(operaion_id);
                operation_forms.push(form_data);
            }
        });

    } else if (offer_type == GROUP && btn_name == 'btn_group') {
        var operation_ids = [];
        $(`.group_operation_ids_${seller_id}[data-currency-type='${preferred_currency}']`).each(function () {
            var operaion_id = $(this).val();
            if (operaion_id != '') {
                form_data = {
                    'operaion_id': operaion_id,
                    'seller_id': seller_id,
                    'operaion_amount': $(`#single_operation_info_${operaion_id}`).attr('data-operation-amount'),
                    'operaion_retention': currency_inr($(`#retention_${operaion_id}:visible`)),
                    'operaion_dealmode': $(`#deal_mode_${operaion_id}:visible`).val(),
                    'operaion_day_hour': $(`#offer_day_hour_${operaion_id}:visible`).val(),
                    'operaion_till': $(`#offer_time_${operaion_id}:visible`).val(),
                    'operaion_offer_amount': currency_inr($(`#offer_amount_${operaion_id}:visible`)),
                    'operaion_mipo_plus': 'No'
                }
                operation_ids.push(operaion_id);
                operation_forms.push(form_data);
            }
        });
    }

    if (btn_name == 'btn_group') {
        var retention = $(`.grp_ret_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
        var deal_mode = $(`#seller_group_payment_method_${seller_id}`);
        var offer_till = $(`.grp_time_till_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
        var offer_day_hour = $(`#seller_group_offer_hour_day_${seller_id}`);
        var offer_amount = $(`.grp_offer_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
        var is_mipo_plus = false;
        var total_operation_amount = $(`.grp_offer_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`).attr('data-operation-total-amount');

    } else if (btn_name == 'btn_group_mipo') {
        var retention = $(`.grp_mipo_ret_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
        var deal_mode = $(`#seller_group_offer_mipo_payment_method_${seller_id}`);
        var offer_till = $(`.grp_mipo_time_till_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
        var offer_day_hour = $(`#seller_group_offer_mipo_hour_day_${seller_id}`);
        var offer_amount = $(`.grp_mipo_offer_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
        var is_mipo_plus = $(`.grp_mipo_chk_${seller_id}[data-currency-type='${preferred_currency}']:visible`).is(":checked");
        var total_operation_amount = $(`.grp_mipo_offer_amount_${seller_id}[data-currency-type='${preferred_currency}']`).attr('data-operation-total-amount');
    }

    var form_data = {
        'operation_id': operation_ids,
        'operation_form': operation_forms,
        'operation_amount': total_operation_amount,
        'seller_id': seller_id,
        'offer_type': offer_type,
        "retention": currency_inr(retention),
        "deal_mode": deal_mode.val(),
        "offer_till": offer_till.val(),
        "offer_amount": currency_inr(offer_amount),
        'offer_day_hour': offer_day_hour.val(),
        'is_mipo_plus': is_mipo_plus,
        'is_group': is_group
    };

    if (form_valid && offer_type != '') {
        setLoadin();
        $.ajax({
            type: 'POST',
            url: url_save_group_offer,
            data: form_data,
            dataType: 'json',
            cache: false,
            success: function (res) {
                unsetLoadin();
                if (res.status == true) {
                    toastr.success(res.message);
                    if (btn_name == 'btn_place') {
                        $('#group_modal').modal('hide');
                    } else if (btn_name == 'btn_group') {
                        $(`.remove_operation_group_by_seller_${seller_id}[data-currency-type='${preferred_currency}']:visible`).remove();
                        $(`#remove_seller_group_${seller_id}[data-currency-type='${preferred_currency}']:visible`).remove();
                    } else if (btn_name == 'btn_group_mipo') {
                        $(`.remove_mipo_group_by_seller_${seller_id}[data-currency-type='${preferred_currency}']:visible`).remove();
                        $(`#remove_seller_group_mipo_${seller_id}[data-currency-type='${preferred_currency}']:visible`).remove();
                    }

                    var total_seller_operation = $(`#remove_seller_group_${seller_id}[data-currency-type='${preferred_currency}']:visible`).length;
                    var total_seller_mipo_operation = $(`#remove_seller_group_mipo_${seller_id}[data-currency-type='${preferred_currency}']:visible`).length;
                    var total_seller_operations = (total_seller_operation + total_seller_mipo_operation);

                    if (total_seller_operations == 0) {
                        $(`#row_seller_name_remove_${seller_id}[data-currency-type='${preferred_currency}']`).remove();
                    }

                    explore_operation_ids = explore_operation_ids.filter(function (obj) { return operation_ids.indexOf(obj) == -1; });

                    var total_seller_by_currency = $(`.evt_div_group_by_seller[data-currency-type='${preferred_currency}`).length;

                    if (total_seller_by_currency == 0 && preferred_currency == USD) {
                        $('body #group_offer_change_currency').prop('checked', true).trigger('change');
                    }

                    if (total_seller_by_currency == 0 && preferred_currency == PYGH) {
                        $('body #group_offer_change_currency').prop('checked', false).trigger('change');
                    }

                    if ($(`body .evt_div_group_by_seller:visible`).length == 0) {
                        $('#group_modal').modal('hide');
                    }

                    const auto_first_offer_obj = $('.single_offer_amount:visible');
                    const operation_id_new = auto_first_offer_obj.attr('data-operation-id');
                    const seller_id_new = auto_first_offer_obj.attr('data-seller-id');

                    calculationCurrentOperation(seller_id_new, operation_id_new);

                    calculationAllOperation();

                    overallOperationSummary();

                    loadMoreExploreOperationsData();
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

//JS FOR REMOVE SINGL OFFER
$(document).on('click', '.evt_remove_offer:visible', function (e) {
    e.preventDefault();
    var self = $(this);
    removeOffer(self, true);
});

$(document).on('change', '.evt_group_offer_checkbox:visible', function (e) {
    e.preventDefault();
    var self = $(this);
    var seller_id = self.attr('data-seller-id');
    var offer_type = self.attr('data-offer-type');
    var preferred_currency = self.attr('data-currency-type');

    var group_offer_retention = $(`.grp_ret_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
    var group_offer_time = $(`.grp_time_till_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
    var group_offer_amount = $(`.grp_offer_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
    var seller_group_payment = $(`.grp_payment_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
    var seller_group_offer_hour_day = $(`.grp_day_hour_${seller_id}[data-currency-type='${preferred_currency}']:visible`);

    var group_offer_retention_mipo = $(`.grp_mipo_ret_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
    var group_offer_time_mipo = $(`.grp_mipo_time_till_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
    var group_offer_amount_mipo = $(`.grp_mipo_offer_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
    var group_offer_payment_mipo = $(`.grp_mipo_payment_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
    var group_offer_day_hour_mipo = $(`.grp_mipo_day_hour_${seller_id}[data-currency-type='${preferred_currency}']:visible`);

    var retention = $(`.retention_${seller_id}:visible`);
    var offer_time = $(`.offer_time_${seller_id}:visible`);
    var offer_amount = $(`.offer_amount_${seller_id}:visible`);
    var sent_offer = $(`.sent_offer_${seller_id}:visible`);
    var deal_mode_offer = $(`.deal_mode_offer_${seller_id}:visible`);
    var day_hour_offer = $(`.day_hour_offer_${seller_id}:visible`);

    var retention_mipo = $(`.retention_mipo_${seller_id}:visible`);
    var offer_time_mipo = $(`.offer_time_mipo_${seller_id}:visible`);
    var offer_amount_mipo = $(`.offer_amount_mipo_${seller_id}:visible`);
    var sent_offer_mipo = $(`.sent_offer_mipo_${seller_id}:visible`);
    var deal_mode_offer_mipo = $(`.deal_mode_offer_mipo_${seller_id}:visible`);
    var day_hour_offer_mipo = $(`.day_hour_offer_mipo_${seller_id}:visible`);

    var grp_mipo_offer_btn = $(`.grp_mipo_offer_btn_${seller_id}[data-currency-type='${preferred_currency}']`);
    var grp_btn_offer = $(`.grp_offer_btn_${seller_id}[data-currency-type='${preferred_currency}']`);

    if ($(this).prop('checked')) {
        if (offer_type == OFFER_TYPE_MIPO) {
            group_offer_retention_mipo.prop('disabled', false).removeClass('cursor_not_allowed');
            group_offer_time_mipo.prop('disabled', false).removeClass('cursor_not_allowed');
            group_offer_amount_mipo.prop('disabled', false).removeClass('cursor_not_allowed');
            group_offer_payment_mipo.prop('disabled', false).removeClass('cursor_not_allowed');
            group_offer_day_hour_mipo.prop('disabled', false).removeClass('cursor_not_allowed');
            grp_mipo_offer_btn.prop('disabled', false).removeClass('cursor_not_allowed');

            retention_mipo.prop('disabled', true).addClass('cursor_not_allowed');
            offer_time_mipo.prop('disabled', true).addClass('cursor_not_allowed');
            offer_amount_mipo.prop('disabled', true).addClass('cursor_not_allowed');
            deal_mode_offer_mipo.prop('disabled', true).addClass('cursor_not_allowed');
            day_hour_offer_mipo.prop('disabled', true).addClass('cursor_not_allowed');
            sent_offer_mipo.prop('disabled', true).addClass('cursor_not_allowed');
            $(`.offer_amount_mipo_${seller_id}`).removeClass('offer_error');

        } else if (offer_type == OFFER_TYPE_OPERATION) {
            $(`.offer_amount_${seller_id}`).removeClass('offer_error');
            group_offer_retention.prop('disabled', false).removeClass('cursor_not_allowed');
            group_offer_time.prop('disabled', false).removeClass('cursor_not_allowed');
            group_offer_amount.prop('disabled', false).removeClass('cursor_not_allowed');
            seller_group_payment.prop('disabled', false).removeClass('cursor_not_allowed');
            seller_group_offer_hour_day.prop('disabled', false).removeClass('cursor_not_allowed');
            grp_btn_offer.prop('disabled', false).removeClass('cursor_not_allowed');

            retention.prop('disabled', true).addClass('cursor_not_allowed');
            offer_time.prop('disabled', true).addClass('cursor_not_allowed');
            offer_amount.prop('disabled', true).addClass('cursor_not_allowed');
            deal_mode_offer.prop('disabled', true).addClass('cursor_not_allowed');
            day_hour_offer.prop('disabled', true).addClass('cursor_not_allowed');
            sent_offer.prop('disabled', true).addClass('cursor_not_allowed');
        }
    } else {
        if (offer_type == OFFER_TYPE_MIPO) {
            $(`.grp_mipo_offer_amount_${seller_id}`).removeClass('offer_error');
            $(`.grp_mipo_ret_amount_${seller_id}`).removeClass('offer_error');
            group_offer_retention_mipo.prop('disabled', true).addClass('cursor_not_allowed');
            group_offer_time_mipo.prop('disabled', true).addClass('cursor_not_allowed');
            group_offer_amount_mipo.prop('disabled', true).addClass('cursor_not_allowed');
            group_offer_payment_mipo.prop('disabled', true).addClass('cursor_not_allowed');
            group_offer_day_hour_mipo.prop('disabled', true).addClass('cursor_not_allowed');
            grp_mipo_offer_btn.prop('disabled', true).addClass('cursor_not_allowed');

            retention_mipo.prop('disabled', false).removeClass('cursor_not_allowed');
            offer_time_mipo.prop('disabled', false).removeClass('cursor_not_allowed');
            offer_amount_mipo.prop('disabled', false).removeClass('cursor_not_allowed');
            deal_mode_offer_mipo.prop('disabled', false).removeClass('cursor_not_allowed');
            day_hour_offer_mipo.prop('disabled', false).removeClass('cursor_not_allowed');
            sent_offer_mipo.prop('disabled', false).removeClass('cursor_not_allowed');

        } else if (offer_type == OFFER_TYPE_OPERATION) {
            $(`.grp_offer_amount_${seller_id}`).removeClass('offer_error');
            $(`.grp_ret_amount_${seller_id}`).removeClass('offer_error');
            group_offer_retention.prop('disabled', true).addClass('cursor_not_allowed');
            group_offer_time.prop('disabled', true).addClass('cursor_not_allowed');
            group_offer_amount.prop('disabled', true).addClass('cursor_not_allowed');
            seller_group_payment.prop('disabled', true).addClass('cursor_not_allowed');
            seller_group_offer_hour_day.prop('disabled', true).addClass('cursor_not_allowed');
            grp_btn_offer.prop('disabled', true).addClass('cursor_not_allowed');

            retention.prop('disabled', false).removeClass('cursor_not_allowed');
            offer_time.prop('disabled', false).removeClass('cursor_not_allowed');
            offer_amount.prop('disabled', false).removeClass('cursor_not_allowed');
            deal_mode_offer.prop('disabled', false).removeClass('cursor_not_allowed');
            day_hour_offer.prop('disabled', false).removeClass('cursor_not_allowed');
            sent_offer.prop('disabled', false).removeClass('cursor_not_allowed');
        }
    }
    overallOperationSummary();
});

function removeOffer(obj, is_confirm = false) {
    var self = $(obj);
    var operation_id = self.attr('data-operation-id');
    var seller_id = self.attr('data-seller-id');
    var current_operation_amount = parseInt($(`#offer_amount_${operation_id}`).attr('data-operation-amount'));
    var offer_type = self.attr('data-offer-type');
    var preferred_currency = self.attr('data-currency-type');
    if (is_confirm == true) {
        const res = confirm('Are you sure, you want to permanent delete this?');
        if (res) {
            $(`body #row_offer_remove_${operation_id}:visible`).remove();

            var total_single_operation = $(`.remove_operation_group_by_seller_${seller_id}[data-currency-type='${preferred_currency}']:visible`).length;
            if (total_single_operation == 0) {
                $(`.remove_seller_group_${seller_id}[data-currency-type='${preferred_currency}']:visible`).remove();
            }

            var total_single_mipo_operation = $(`.remove_mipo_group_by_seller_${seller_id}[data-currency-type='${preferred_currency}']:visible`).length;
            if (total_single_mipo_operation == 0) {
                $(`.remove_seller_group_mipo_${seller_id}[data-currency-type='${preferred_currency}']:visible`).remove();
            }

            if ((total_single_mipo_operation + total_single_operation) == 0) {
                $(`.row_seller_name_remove_${seller_id}[data-currency-type='${preferred_currency}']`).remove();
            }

            var total_seller_by_currency = $(`.evt_div_group_by_seller[data-currency-type='${preferred_currency}`).length;
            if (total_seller_by_currency == 0 && preferred_currency == USD) {
                $('body #group_offer_change_currency').prop('checked', true).trigger('change');
            }

            if (total_seller_by_currency == 0 && preferred_currency == PYGH) {
                $('body #group_offer_change_currency').prop('checked', false).trigger('change');
            }

            if ($(`body .evt_div_group_by_seller:visible`).length == 0) {
                $('#group_modal').modal('hide');
            }

            var first_seller_obj = $(`.evt_remove_offer[data-currency-type='${preferred_currency}']:visible`).first();

            var currency_sing = PYGH_SIGN;
            if (preferred_currency == USD) {
                currency_sing = USD_SIGN;
            }

            if (offer_type == 'mipo') {
                var mipo_obj = $(`#seller_group_offer_mipo_amount_${seller_id}`);
                var exist_mipo_group_amount = parseInt(mipo_obj.attr('data-operation-total-amount'));
                var new_mipo_group_amount = (exist_mipo_group_amount - current_operation_amount);
                mipo_obj.attr('data-operation-total-amount', parseInt(new_mipo_group_amount));
                $(`#seller_group_offer_mipo_amount_txt_${seller_id}`).text(currency_sing + '' + currency_format(new_mipo_group_amount, preferred_currency));
            } else {
                var ope_obj = $(`#seller_group_offer_amount_${seller_id}`);
                var exsit_op_group_amount = parseInt(ope_obj.attr('data-operation-total-amount'))
                var new_op_group_amount = (exsit_op_group_amount - current_operation_amount);
                ope_obj.attr('data-operation-total-amount', parseInt(new_op_group_amount));
                $(`#seller_group_offer_amount_txt_${seller_id}`).text(currency_sing + '' + currency_format(new_op_group_amount, preferred_currency));
            }

            calculationCurrentOperation(first_seller_obj.attr('data-seller-id'), first_seller_obj.attr('data-operation-id'));
            $(`.single_retention[data-currency-type='${preferred_currency}']:visible`).first().focus();

            overallOperationSummary();
        }
    }
}

//  calculation all here
function calculationCurrentOperation(seller_id, operation_id) {
    var current_operation_obj = $(`#single_operation_info_${operation_id}`);
    var seller_name = current_operation_obj.attr('data-seller-name');
    var issuer_name = current_operation_obj.attr('data-issuer-name');
    var operation_type = current_operation_obj.attr('data-operation-type');
    var operation_number = current_operation_obj.attr('data-operation-number');
    var preferred_currency = current_operation_obj.attr('data-currency-type');

    $('#add_chk_number:visible').text(`${operation_type}  ${operation_number}`);
    $('#payment_opt:visible').text($(`#group_offer_dealmode_${operation_id}:visible`).val());

    $('#add_seller_name:visible').text(seller_name);
    $('#add_company_name:visible').text(' ' + issuer_name);

    var real_time_offer_amount = retention_amount = offer_time = null;
    operation_amount = parseFloat(current_operation_obj.attr('data-operation-amount')).toFixed(2);
    retention_amount = getStrignToNumber($(`#retention_${operation_id}:visible`).val());

    real_time_offer_amount = getStrignToNumber($(`#offer_amount_${operation_id}:visible`).val());

    var is_mipo_checked = $(`#mipo_verified_${operation_id}:visible`).is(":checked");

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

    $('#current_operation_amount:visible').text(new_operation_amount);

    $('#current_rentention_amount:visible').text(new_retention_amount);

    $('#current_real_time_offer:visible').text(new_real_time_offer_amount);

    var current_operation_retention_amount = (operation_amount - retention_amount);

    // var new_current_operation_amount = 0;
    if (preferred_currency == USD) {
        new_operation_amount = $.number(current_operation_retention_amount, 2, ',', '.');
    } else if (preferred_currency == PYGH) {
        new_operation_amount = $.number(current_operation_retention_amount, 0, ',', '.');
    }

    $(`#current_operation_rentention_amount:visible`).text(new_operation_amount);

    var current_overall_profit = (current_operation_retention_amount - real_time_offer_amount);

    var current_mipo_commission = ((current_overall_profit * MIPO_COMMISSION) / 100);

    var new_current_mipo_commission = 0;
    if (preferred_currency == USD) {
        new_current_mipo_commission = $.number(parseFloat(current_mipo_commission).toFixed(2), 2, ',', '.');
    } else if (preferred_currency == PYGH) {
        new_current_mipo_commission = $.number(parseFloat(current_mipo_commission).toFixed(2), 0, ',', '.');
    }

    $('#current_mipo_commission:visible').text(new_current_mipo_commission);

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

    $('#current_add_mipo_commission:visible').text(new_current_add_mipo_commission);

    var current_net_profit = (current_overall_profit - current_mipo_commission - current_add_mipo_commission);

    var new_current_net_profit = 0;
    if (preferred_currency == USD) {
        new_current_net_profit = $.number(Math.round(parseFloat(current_net_profit).toFixed(2)), 2, ',', '.');
    } else if (preferred_currency == PYGH) {
        new_current_net_profit = $.number(Math.round(parseFloat(current_net_profit).toFixed(2)), 0, ',', '.');
    }

    $('#current_net_profit:visible').text(new_current_net_profit);

    calculationAllOperation();

    $('body #calculation_div_row').show();
}

function calculationAllOperation() {
    $('.evt_div_group_by_seller:visible').each(function (index) {
        var self = $(this);
        var seller_id = self.attr('data-seller-id');

        // calculation mipo
        var mipo_retention_total = mipo_time_total = mipo_offer_amount_total = null;

        $(`.retention_mipo_${seller_id}:visible`).each(function () {
            var self = $(this);
            var currency_val = $(this).val();
            var currency_type = $(this).attr('data-currency-type');
            if (self.val() != '') {
                mipo_retention_total += currency_type_amount_sum(self, currency_type, currency_val);
            }
        });

        $(`#seller_group_offer_mipo_retention_${seller_id}:visible`).val(mipo_retention_total);

        $(`.offer_time_mipo_${seller_id}:visible`).each(function () {
            var self = $(this);
            if (self.val() != '') {
                mipo_time_total += parseInt(self.val());
            }
        });
        $(`#seller_group_offer_mipo_time_${seller_id}:visible`).val(mipo_time_total);

        $(`.offer_amount_mipo_${seller_id}:visible`).each(function () {
            var self = $(this);
            var currency_val = $(this).val();
            var currency_type = $(this).attr('data-currency-type');
            if (self.val() != '') {
                mipo_offer_amount_total += currency_type_amount_sum(self, currency_type, currency_val);
            }
        });
        $(`.grp_mipo_offer_amount_${seller_id}:visible`).val(mipo_offer_amount_total);

        // calculation operation
        var operation_retention_total = operation_time_total = operation_amount_total = null;

        $(`.retention_${seller_id}:visible`).each(function () {
            var self = $(this);
            var currency_val = $(this).val();
            var currency_type = $(this).attr('data-currency-type');
            if (self.val() != '') {
                operation_retention_total += currency_type_amount_sum(self, currency_type, currency_val);
            }
        });
        $(`#seller_group_offer_retention_${seller_id}:visible`).val(operation_retention_total);

        $(`.offer_time_${seller_id}:visible`).each(function () {
            var self = $(this);
            if (self.val() != '') {
                operation_time_total += parseInt(self.val());
            }
        });
        $(`#seller_group_offer_time_${seller_id}:visible`).val(operation_time_total);

        $(`.offer_amount_${seller_id}:visible`).each(function () {
            var self = $(this);
            var currency_val = $(this).val();
            var currency_type = $(this).attr('data-currency-type');
            if (self.val() != '') {
                operation_amount_total += currency_type_amount_sum(self, currency_type, currency_val);
            }
        });
        
        $(`.grp_offer_amount_${seller_id}:visible`).val(operation_amount_total);

    });
    overallOperationSummary();
}

function overallOperationSummary() {
    var operation_cal_arr = [];
    var mipo_plus_cal_arr = [];
    var mipo_plus_cal_obj = {};
    var operation_cal_obj = {};

    $('.evt_group_offer_checkbox:visible').each(function (index) {
        var self = $(this);
        var seller_id = self.attr('data-seller-id');
        var offer_type = self.attr('data-offer-type');
        var preferred_currency = self.attr('data-currency-type');

        var group_offer_retention_mipo = currency_type_amount_sum(null, preferred_currency, $(`.grp_mipo_ret_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`).val());
        var group_offer_amount_mipo_obj = $(`.grp_mipo_offer_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
        
        var group_offer_mipo_real_time_amount =  currency_type_amount_sum(null, preferred_currency, group_offer_amount_mipo_obj.val());

        var group_operation_mipo_amount = getStrignToNumber(group_offer_amount_mipo_obj.attr('data-operation-total-amount'));

        var group_offer_retention = currency_type_amount_sum(null, preferred_currency, $(`.grp_ret_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`).val());
        var group_offer_amount_obj = $(`.grp_offer_amount_${seller_id}[data-currency-type='${preferred_currency}']:visible`);
        
        var group_offer_real_time_amount =  currency_type_amount_sum(null, preferred_currency, group_offer_amount_obj.val());

        var group_operation_amount = getStrignToNumber(group_offer_amount_obj.attr('data-operation-total-amount'));

        var current_operation_amount = current_overall_profit = current_mipo_commission = current_add_mipo_commission = current_net_profit = 0;
        var total_operation_amount = total_retention_amount = mipo_real_time_offer_amount = 0;
        var mipo_verify = 'No';

        if ($(this).is(':visible') && $(this).prop('checked') == true) {
            if (offer_type == OFFER_TYPE_MIPO) {
                total_operation_amount = group_operation_mipo_amount;

                total_retention_amount = group_offer_retention_mipo;

                mipo_real_time_offer_amount = group_offer_mipo_real_time_amount;

                current_operation_amount = (group_operation_mipo_amount - group_offer_retention_mipo);

                current_overall_profit = (current_operation_amount - group_offer_mipo_real_time_amount);

                current_mipo_commission = ((current_overall_profit * MIPO_COMMISSION) / 100);

                var is_mipo_plus_obj = $(`.grp_mipo_chk_${seller_id}[data-currency-type='${preferred_currency}']:visible`);

                if (is_mipo_plus_obj.is(':visible') && is_mipo_plus_obj.is(':checked') == true) {
                    mipo_verify = 'Yes';
                    current_add_mipo_commission = ((group_offer_mipo_real_time_amount * MIPO_ADD_COMMISSION) / 100);
                }

                current_net_profit = (current_overall_profit - current_mipo_commission - current_add_mipo_commission);

                mipo_plus_cal_obj = {
                    'mipo_verify': mipo_verify,
                    'seller_id': seller_id,
                    'commission_amount': current_mipo_commission,
                    'mipo_plus_commission_amount': current_add_mipo_commission,
                    'real_time_offer_amount': mipo_real_time_offer_amount,
                    'operation_amount': total_operation_amount,
                    'retention_amount': total_retention_amount,
                    'operation_retention_amount': current_operation_amount,
                    'net_profit_amount': current_net_profit,
                };
                mipo_plus_cal_arr.push(mipo_plus_cal_obj);
            } else if (offer_type == OFFER_TYPE_OPERATION) {
                total_operation_amount = group_operation_amount;

                total_retention_amount = group_offer_retention;

                mipo_real_time_offer_amount = group_offer_real_time_amount;

                current_operation_amount = (group_operation_amount - group_offer_retention);

                current_overall_profit = (current_operation_amount - group_offer_real_time_amount);

                current_mipo_commission = ((current_overall_profit * MIPO_COMMISSION) / 100);

                current_net_profit = (current_overall_profit - current_mipo_commission - current_add_mipo_commission);

                mipo_plus_cal_obj = {
                    'mipo_verify': mipo_verify,
                    'seller_id': seller_id,
                    'commission_amount': current_mipo_commission,
                    'mipo_plus_commission_amount': current_add_mipo_commission,
                    'real_time_offer_amount': mipo_real_time_offer_amount,
                    'operation_amount': total_operation_amount,
                    'retention_amount': total_retention_amount,
                    'operation_retention_amount': current_operation_amount,
                    'net_profit_amount': current_net_profit,
                };
                mipo_plus_cal_arr.push(mipo_plus_cal_obj);
            }
        }
    });

    /* All Single Offer Calculation */
    var preferred_currency = USD;
    $('.single_offer_amount:visible').each(function () {
        var self = $(this);
        var seller_id = self.attr('data-seller-id');
        var operaion_id = self.attr('data-operation-id');
        var offer_type = self.attr('data-offer-type');
        preferred_currency = self.attr('data-currency-type');
    
        if ($(this).val() != '') {

            var is_group_offer_checkbox = $(`#is_group_offer_checkbox_${seller_id}[data-currency-type='${preferred_currency}']:visible`).is(':checked');
            var is_group_offer_mipo_checkbox = $(`#is_group_offer_mipo_checkbox_${seller_id}[data-currency-type='${preferred_currency}']:visible`).is(':checked');

            var single_offer_retention_mipo = currency_type_amount_sum(null, preferred_currency, $(`#retention_${operaion_id}[data-currency-type='${preferred_currency}']:visible`).val());
            var single_offer_amount_mipo_obj = $(`#offer_amount_${operaion_id}:visible`);
            var single_offer_mipo_real_time_amount = currency_type_amount_sum(null, preferred_currency, single_offer_amount_mipo_obj.val());
            var single_operation_mipo_amount = getStrignToNumber(single_offer_amount_mipo_obj.attr('data-operation-amount'));

            var single_offer_retention = currency_type_amount_sum(null, preferred_currency, $(`#retention_${operaion_id}[data-currency-type='${preferred_currency}']:visible`).val());
            var single_offer_amount_obj = $(`#offer_amount_${operaion_id}[data-currency-type='${preferred_currency}']:visible`);
            var single_offer_real_time_amount = currency_type_amount_sum(null, preferred_currency, single_offer_amount_obj.val());
            var single_operation_amount = getStrignToNumber(single_offer_amount_obj.attr('data-operation-amount'));

            var current_operation_amount = current_overall_profit = current_mipo_commission = current_add_mipo_commission = current_net_profit = 0;
            var total_operation_amount = total_retention_amount = mipo_real_time_offer_amount = 0;
            var mipo_verify = 'No';

            if (offer_type == OFFER_TYPE_MIPO && is_group_offer_mipo_checkbox == false) {
                total_operation_amount = single_operation_mipo_amount;

                total_retention_amount = single_offer_retention_mipo;

                mipo_real_time_offer_amount = single_offer_mipo_real_time_amount;

                current_operation_amount = (single_operation_mipo_amount - single_offer_retention_mipo);

                current_overall_profit = (current_operation_amount - single_offer_mipo_real_time_amount);

                current_mipo_commission = ((current_overall_profit * MIPO_COMMISSION) / 100);

                var is_mipo_plus_obj = $(`#mipo_verified_${operaion_id}:visible`);

                if (is_mipo_plus_obj.is(':visible') && is_mipo_plus_obj.prop('checked')) {
                    mipo_verify = 'Yes';
                    current_add_mipo_commission = ((single_offer_mipo_real_time_amount * MIPO_ADD_COMMISSION) / 100);
                }

                current_net_profit = (current_overall_profit - current_mipo_commission - current_add_mipo_commission);

                operation_cal_obj = {
                    'mipo_verify': mipo_verify,
                    'seller_id': seller_id,
                    'commission_amount': current_mipo_commission,
                    'mipo_plus_commission_amount': current_add_mipo_commission,
                    'real_time_offer_amount': mipo_real_time_offer_amount,
                    'operation_amount': total_operation_amount,
                    'retention_amount': total_retention_amount,
                    'operation_retention_amount': current_operation_amount,
                    'net_profit_amount': current_net_profit,
                };
                operation_cal_arr.push(operation_cal_obj);

            } else if (offer_type == OFFER_TYPE_OPERATION && is_group_offer_checkbox == false) {
                total_operation_amount = single_operation_amount;

                total_retention_amount = single_offer_retention;

                mipo_real_time_offer_amount = single_offer_real_time_amount;

                current_operation_amount = (single_operation_amount - single_offer_retention);

                current_overall_profit = (current_operation_amount - single_offer_real_time_amount);

                current_mipo_commission = ((current_overall_profit * MIPO_COMMISSION) / 100);

                current_net_profit = (current_overall_profit - current_mipo_commission - current_add_mipo_commission);

                operation_cal_obj = {
                    'mipo_verify': mipo_verify,
                    'seller_id': seller_id,
                    'commission_amount': current_mipo_commission,
                    'mipo_plus_commission_amount': current_add_mipo_commission,
                    'real_time_offer_amount': mipo_real_time_offer_amount,
                    'operation_amount': total_operation_amount,
                    'retention_amount': total_retention_amount,
                    'operation_retention_amount': current_operation_amount,
                    'net_profit_amount': current_net_profit,
                };
                operation_cal_arr.push(operation_cal_obj);
            }
        }
    });
    var main_object = mipo_plus_cal_arr.concat(operation_cal_arr);

    var overall_operation_total = overall_retention_total = overall_operation_rentention_total = overall_real_time_offer_total =
        overall_net_profit_total = overall_commission_total = overall_mipo_commission_total = 0;
    $(main_object).each(function (index, seller_obj) {

        if (seller_obj.operation_amount != '') {
            overall_operation_total += parseInt(seller_obj.operation_amount);
        }

        if (seller_obj.retention_amount != '') {
            overall_retention_total += parseInt(seller_obj.retention_amount);
        }

        if (seller_obj.operation_retention_amount != '') {
            overall_operation_rentention_total += parseInt(seller_obj.operation_retention_amount);
        }

        if (seller_obj.real_time_offer_amount != '') {
            overall_real_time_offer_total += parseInt(seller_obj.real_time_offer_amount);
        }

        if (seller_obj.net_profit_amount != '') {
            overall_net_profit_total += Math.round(parseFloat(seller_obj.net_profit_amount));
        }

        if (seller_obj.commission_amount != '') {
            overall_commission_total += parseInt(seller_obj.commission_amount);
        }

        if (seller_obj.mipo_plus_commission_amount != '') {
            overall_mipo_commission_total += parseInt(seller_obj.mipo_plus_commission_amount);
        }

    });

    var new_amount_overall_operation_total = new_amount_overall_retention_total = new_amount_overall_operation_rentention_total = 0;
    var new_amount_overall_real_time_offer_total = new_amount_overall_commission_total = new_amount_overall_mipo_commission_total = new_amount_overall_net_profit_total = 0;

    if (preferred_currency == USD) {
        new_amount_overall_operation_total = $.number(overall_operation_total, 2, ',', '.');
        new_amount_overall_retention_total = $.number(overall_retention_total, 2, ',', '.');
        new_amount_overall_operation_rentention_total = $.number(overall_operation_rentention_total, 2, ',', '.');
        new_amount_overall_real_time_offer_total = $.number(overall_real_time_offer_total, 2, ',', '.');
        new_amount_overall_commission_total = $.number(overall_commission_total, 2, ',', '.');
        new_amount_overall_mipo_commission_total = $.number(overall_mipo_commission_total, 2, ',', '.');
        new_amount_overall_net_profit_total = $.number(overall_net_profit_total, 2, ',', '.');
    } else if (preferred_currency == PYGH) {
        new_amount_overall_operation_total = $.number(overall_operation_total, 0, ',', '.');
        new_amount_overall_retention_total = $.number(overall_retention_total, 0, ',', '.');
        new_amount_overall_operation_rentention_total = $.number(overall_operation_rentention_total, 0, ',', '.');
        new_amount_overall_real_time_offer_total = $.number(overall_real_time_offer_total, 0, ',', '.');
        new_amount_overall_commission_total = $.number(overall_commission_total, 0, ',', '.');
        new_amount_overall_mipo_commission_total = $.number(overall_mipo_commission_total, 0, ',', '.');
        new_amount_overall_net_profit_total = $.number(overall_net_profit_total, 0, ',', '.');
        new_amount_overall_net_profit_total = $.number(overall_net_profit_total, 0, ',', '.');
    }

    $('#overall_operation_total:visible').text(new_amount_overall_operation_total);
    $('#overall_retention_total:visible').text(new_amount_overall_retention_total);
    $('#overall_operation_rentention_total:visible').text(new_amount_overall_operation_rentention_total);
    $('#overall_real_time_total:visible').text(new_amount_overall_real_time_offer_total);
    $('#overall_mipo_commission:visible').text(new_amount_overall_commission_total);
    $('#overall_add_mipo_commission:visible').text(new_amount_overall_mipo_commission_total);
    $('#overall_net_profit:visible').text(new_amount_overall_net_profit_total);
}

function getStrignToNumber(str_val) {
    return (str_val != '') ? parseInt(str_val) : '';
}

function currency_format(amount, currency_type) {
    if (amount != '') {
        if (currency_type == USD) {
            return $.number(Math.round(parseFloat(amount).toFixed(2)), 2, ',', '.');
        } else {
            return $.number(Math.round(parseFloat(amount).toFixed(2)), 0, ',', '.');
        }
    }
}