$(document).on('blur', '.single_offer_amount, .seller_group_offer_amount, .seller_group_retention, .single_retention, .seller_group_offer_mipo_amount, .seller_group_offer_mipo_retention, .explore_offer_input, .counter_offer_amount', function () {
    var el = $(this);
    var currency_type = $(this).attr('data-currency-type');
    if (currency_type == USD) {
        $(this).formatCurrency({
            symbol: '',
            positiveFormat: '%s %n',
            negativeFormat: '(%s %n)',
            decimalSymbol: '.',
            digitGroupSymbol: ',',
            groupDigits: true
        });
    } else {
        $(this).formatCurrency({
            symbol: '',
            positiveFormat: '%s %n',
            negativeFormat: '(%s %n)',
            decimalSymbol: ',',
            digitGroupSymbol: '.',
            groupDigits: true,
            roundToDecimalPlace: -1,
        });
    }

    changeCurrency();
});

$(document).on('change', '#group_offer_change_currency', function (e) {
    e.preventDefault();
    changeCurrency();
});

changeCurrency = () => {
    const currency_class_arr = ['seller_group_offer_amount', 'seller_group_retention', 'seller_group_offer_mipo_amount', 'seller_group_offer_mipo_retention'];
    $.each(currency_class_arr, function (index, txt_cls) {
        $(`.${txt_cls}:visible`).each(function () {
            var currency_type = $(this).attr('data-currency-type');
            if (currency_type == USD) {
                $(this).formatCurrency({
                    symbol: '',
                    positiveFormat: '%s %n',
                    negativeFormat: '(%s %n)',
                    decimalSymbol: '.',
                    digitGroupSymbol: ',',
                    groupDigits: true
                });
            } else {
                $(this).formatCurrency({
                    symbol: '',
                    positiveFormat: '%s %n',
                    negativeFormat: '(%s %n)',
                    decimalSymbol: ',',
                    digitGroupSymbol: '.',
                    groupDigits: true,
                    roundToDecimalPlace: -1,
                });
            }
        });
    });
}

$(document).on('change', "input[name='preferred_currency']", function () {
    $('.op_amount, .op_amount_req').val('');
});

$(document).on('blur', '.op_amount, .op_amount_req', function () {
    var el = $(this);
    var currency_type = $("input[name='preferred_currency']:checked").val();
    if (currency_type == USD) {
        $(this).formatCurrency({
            symbol: '',
            positiveFormat: '%s %n',
            negativeFormat: '(%s %n)',
            decimalSymbol: '.',
            digitGroupSymbol: ',',
            groupDigits: true
        });
    } else {
        $(this).formatCurrency({
            symbol: '',
            positiveFormat: '%s %n',
            negativeFormat: '(%s %n)',
            decimalSymbol: ',',
            digitGroupSymbol: '.',
            groupDigits: true,
            roundToDecimalPlace: -1,
        });
    }
}).trigger('blur');

function currency_type_amount_sum(obj, currency_type, amount) {
    if (obj == null) {
        if (amount != '') {
            return parseInt(amount);
        } else {
            return '';
        }
    } else {
        if (currency_type == USD) {
            return parseInt(amount.replace(/[^0-9\.]/g, ""));
        } else {
       /*      var remove_coma = amount.replace(",00", "");
            var remove_dot = remove_coma.replace(".", ""); */
            var remove_coma = amount.replace(/[.,]/g, "");
            return parseInt(remove_coma);
        }
    }
}

function currency_inr(obj) {
    var currency_type = $(obj).attr('data-currency-type');
    var amount = $(obj).val() ? $(obj).val() : '';
    if (amount != '') {
        if (currency_type == USD && amount != '') {
            return parseInt(amount.replace(/[^0-9\.]/g, ""));
        } else {
            if (amount != '') {
            /*     var remove_coma = amount.replace(",00", "");
                var remove_dot = remove_coma.replace(".", ""); */
                var remove_coma = amount.replace(/[.,]/g, "");
                return parseInt(remove_coma);
            }
        }
    } else {
        return '';
    }
}

function currency_inr_operation(currency_type, amount) {
    var amount = amount ? amount : '';
    if (amount != '') {
        if (currency_type == USD && amount != '') {
            return parseInt(amount.replace(/[^0-9\.]/g, ""));
        } else {
            if (amount != '') {
              /*   var remove_coma = amount.replace(",00", "");
                var remove_dot = remove_coma.replace(".", ""); */
                var remove_coma = amount.replace(/[.,]/g, "");
                return parseInt(remove_coma);
            }
        }
    } else {
        return '';
    }
}