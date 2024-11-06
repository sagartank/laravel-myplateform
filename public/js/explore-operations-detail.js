var retention_amount = 0;

function sentOffer(obj, id, screen_name = 'dst') {
    var has_id = `${id}${screen_name}`;
    
    if (operation_type != 'Cheque') {
        retention_amount = ($('#offer_retention_' + has_id).val()) ? currency_inr($('#offer_retention_' + has_id)) : 0;
    }

    var self = $(obj);
    var seller_id = self.attr('data-seller-id');
    var deal_mode = $('#payment_method_' + has_id);
    var offer_till = $('#sel_day_hour_' + has_id);
    var offer_amount = $('#offer_amount_' + has_id);
    var offer_day_hour = $('#day_hour_no_' + has_id);
    var retention = $('#offer_retention_' + has_id);
    var is_mipo_plus = $('#is_mipo_cbox_' + has_id).is(":checked");
    var operation_amount = $('#offer_retention_' + has_id).attr("data-operation-amount");

    var offer_amount_val = currency_inr(offer_amount);

    if(deal_action  == 'add') {
        var ajax_url_send_offer = url_save_group_offer;
        var form_data = {
            'offer_type': SINGLE,
            'offer_send': 'Buyer',
            'operation_id': id,
            'seller_id': seller_id,
            'operation_amount': operation_amount,
            "retention": retention_amount,
            "deal_mode": deal_mode.val(),
            "offer_till": offer_day_hour.val(),
            "offer_amount": offer_amount_val,
            'offer_day_hour': offer_till.val(),
            'is_mipo_plus': is_mipo_plus
        }
    }

    if(deal_action  == 'update' && parseInt(offer_id) > 0 ) {
        var ajax_url_send_offer = url_offered_operations_update;
        var form_data = {
            'offer_id': offer_id,
            'offer_status': 'Pending',
            'offer_send': 'Buyer',
            'deal_mode': deal_mode.val(),
            'offer_till': offer_day_hour.val(),
            'offer_amount': offer_amount_val,
            'offer_day_hour': offer_till.val(),
            'retention': retention_amount,
            'is_mipo_plus': is_mipo_plus
        }
    }
    console.log('form_data', form_data);
    offer_amount.removeClass('offer_error');
    if (offer_amount_val == '') {
        toastr.error('Please enter offer amount.');
        offer_amount.addClass('offer_error');
        return false;
    }

    if (offer_amount_val == 0 || offer_amount_val == '') {
        retention.addClass('offer_error');
        return false;
    }

    if (accept_below_document_amount_requested != 1 || accept_below_document_amount_requested == '') {
        if (parseInt(offer_amount_val) < parseInt(document_amount)) {
            offer_amount.addClass('offer_error');
            toastr.error(`Amount Request for document ${document_amount}`);
            return false;
        }
    }

    if (parseInt(offer_amount_val) >= parseInt(current_operation_amount)) {
        offer_amount.addClass('offer_error');
        toastr.error(`Offer amount for operation amount ${current_operation_amount}`);
        return false;
    }
        
    if (operation_type != 'Cheque' && retention_amount != 0) {
        if (retention_amount > offer_amount_val) {
            retention.addClass('offer_error');
            return false;
        }

        if (retention_amount > current_operation_amount) {
            retention.addClass('offer_error');
            return false;
        }
    }

    if (offer_till.length > MAX_HOUR_DAY_LENGTH) {
        offer_till.addClass('offer_error');
        toastr.error(`Maximum character length ${MAX_HOUR_DAY_LENGTH} .`);
        return false;;
    }
    
    setLoadin();
    $.ajax({
        type: 'POST',
        url: ajax_url_send_offer,
        data: form_data,
        dataType: 'json',
        cache: false,
        beforeSend: function() {
            $(self).text(loadin_en_msg);
        },
        success: function (res) {
            unsetLoadin();
            if (res.status == true) {
                $(self).text(offer_en_msg);
                // $('.offer_hide_show').remove();
                toastr.success(res.message);
                // window.location.href = REDIRECT_EXPLORE_OPERATIONS;
            } else {
                toastr.error(res.message);
            }
            window.location.reload();
        },
        error: function (xhr) {
            unsetLoadin();
            ajaxErrorMsg(xhr);
            window.location.reload();
        }
    });
}

function offerSummary(obj) {
    var self = $(obj);
    $('#add_offer_amount').text(self.val());
    const operation_id = self.attr('data-operation-id');
    const seller_id = self.attr('data-seller-id');
    const screen_name = self.attr('data-screen-name');
    const has_id = `${operation_id}${screen_name}`;
    calculationCurrentOperation(seller_id, operation_id, has_id);
}

$(document).on('focus', '.evt_input', function (e) {
    e.preventDefault();
    var self = $(this);
    const operation_id = self.attr('data-operation-id');
    const seller_id = self.attr('data-seller-id');
    const screen_name = self.attr('data-screen-name');
    const has_id = `${operation_id}${screen_name}`;
    calculationCurrentOperation(seller_id, operation_id, has_id);
});

$(document).on('change', '.evt_change', function (e) {
    e.preventDefault();
    var self = $(this);
    const operation_id = self.attr('data-operation-id');
    const seller_id = self.attr('data-seller-id');
    const screen_name = self.attr('data-screen-name');
    const has_id = `${operation_id}${screen_name}`;
    calculationCurrentOperation(seller_id, operation_id, has_id);
});

$(document).on('change', '.evt_is_mipo_plus', function (e) {
    e.preventDefault();
    var self = $(this);
    var checked = $(this).is(':checked');
    var seller_id = $(this).attr('data-seller-id');
    var operation_id = $(this).attr('data-operation-id');
    const screen_name = self.attr('data-screen-name');
    const has_id = `${operation_id}${screen_name}`;
    calculationCurrentOperation(seller_id, operation_id, has_id);
});


function calculationCurrentOperation(seller_id, operation_id, has_id) {
    var current_operation_obj = $(`#single_operation_info_${operation_id}`);
    var seller_name = current_operation_obj.attr('data-seller-name');
    var issuer_name = current_operation_obj.attr('data-issuer-name');
    var operation_type = current_operation_obj.attr('data-operation-type');
    var operation_number = current_operation_obj.attr('data-operation-number');
    var preferred_currency = current_operation_obj.attr('data-currency-type');

    $('#add_chk_number:visible').text(`${operation_type}  ${operation_number}`);
    $('#payment_opt:visible').text($(`#payment_method_${has_id}`).val());
    if (seller_name) {
        $('#add_seller_name:visible').text(`${seller_name.charAt(0)}***`);
    }

    var real_time_offer_amount = retention_amount = offer_time = 0;

    operation_amount = $('#offer_retention_' + has_id).attr("data-operation-amount");

    retention_amount = currency_inr($(`#offer_retention_${has_id}:visible`));
    real_time_offer_amount = currency_inr($(`#offer_amount_${has_id}:visible`));

    var is_mipo_checked = $(`#is_mipo_cbox_${has_id}:visible`).is(":checked");

    if($(`#offer_amount_${has_id}:visible`).val().length > 0)
    {
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

        var new_current_operation_amount = 0;
        if (preferred_currency == USD) {
            new_operation_amount = $.number(current_operation_retention_amount, 2, ',', '.');
        } else if (preferred_currency == PYGH) {
            new_operation_amount = $.number(current_operation_retention_amount, 0, ',', '.');
        }

        $(`#current_operation_rentention_amount:visible`).text(new_current_operation_amount);

        var current_overall_profit = (current_operation_retention_amount - real_time_offer_amount);

        var current_mipo_commission = ((current_overall_profit * MIPO_COMMISSION) / 100);

        var new_current_mipo_commission = 0;
        if (preferred_currency == USD) {
            new_current_mipo_commission = $.number(parseFloat(current_mipo_commission).toFixed(2), 2, ',', '.');
        } else if (preferred_currency == PYGH) {
            new_current_mipo_commission = $.number(parseFloat(current_mipo_commission).toFixed(2), 0, ',', '.');
        }

        $('#current_mipo_commission:visible').text(new_current_mipo_commission);

        var current_add_mipo_commission = 0;
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
    } else {
        $('#current_operation_amount:visible').text(0);
        $('#current_rentention_amount:visible').text(0);
        $('#current_real_time_offer:visible').text(0);
        $(`#current_operation_rentention_amount:visible`).text(0);
        $('#current_mipo_commission:visible').text(0);
        $('#current_add_mipo_commission:visible').text(0);
        $('#current_net_profit:visible').text(0);
    }   
}

function getStrignToNumber(str_val) {
    return (str_val != '') ? parseInt(str_val) : '';
}

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
                        } else {
                            toastr.error(res.message);
                        }
                        window.location.reload();
                    },
                    error: function (xhr) {
                        unsetLoadin();
                        ajaxErrorMsg(xhr);
                        window.location.reload();
                    }
                });
            }
        })
    } else {
        toastr.error('Please select offer.');
    }
});