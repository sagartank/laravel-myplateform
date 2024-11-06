
var deals_filter_dashboard = true;
var device_type = detectDeviceType();

$(document).ready(function () {

    $(".js-example-basic-multiple").select2({
        tags: true,
        tokenSeparators: [',', ' ']
    });

    // $('input[name="duration_date_range"]').val('');

    dealsListSeller(null, device_type);
    dealsListBuyer(null, device_type);
    dealsPhoneNumber();

    $('.filter_selectprice input:checkbox').change(function () {
        if ($(this).is(":checked")) {
            $(this).parents('.filter_selectprice').addClass("active_payment");
        } else {
            $(this).parents('.filter_selectprice').removeClass("active_payment");
        }
    });

    $('.evt_get_seller').select2({
        dropdownCssClass: 'increasezindex',
        placeholder: sch_seller_en_msg,
        ajax: {
            dataType: 'json',
            type: 'post',
            delay: 500,
            url: ajax_url_get_seller,
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

    $('.evt_get_issuer').select2({
        dropdownCssClass: 'increasezindex',
        placeholder: sch_pay_issuer_en_msg,
        ajax: {
            dataType: 'json',
            type: 'post',
            delay: 500,
            url: ajax_url_get_buyer,
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

   /*  $(document).on('click', '.evt_deals_status', function (e) {
        e.preventDefault();
        var self = $(this);
        deals_filter_dashboard = false;
        var status_name = self.attr('data-status-name');
        if (status_name != '') {
            $('#deals_status').val(status_name);
        } else {
            $('#deals_status').val('');
        }
        var usert_type = $('.deals_tabs').find('li a.active').attr('data-active-name');
        if (usert_type == 'buyer') {
            dealsListBuyer();
        } else if (usert_type == 'seller') {
            dealsListSeller();
        } else {
            toastr.error(error_something_en_msg);
        }
    }); */

    $(document).on('click', '.evt_deal_form_filter_apply', function (event) {
        event.preventDefault();
        deals_filter_dashboard = true;
        var self = $(this);
        let device_type = $(this).attr('data-device-type');
        
       /*  $('#deals_status').val('');
        $('#deals_status').val('').trigger('change'); */
        
        $('#deal_list_side_bar_modal').removeClass('clicked');
        
        var usert_type = $('.deals_tabs').find('li a.active').attr('data-active-name');
        if (usert_type == 'buyer') {
            dealsListBuyer(null, device_type);
        } else if (usert_type == 'seller') {
            dealsListSeller(null, device_type);
        } else {
            toastr.error(error_something_en_msg);
        }
        // $('#advance_filter_modal').modal('hide');
    });

    $(document).on('click', '.evt_deal_form_filter_reset', function (event) {
        event.preventDefault();
        var self = $(this);
        deals_filter_dashboard = true;
        let device_type = $(this).attr('data-device-type');
        if(device_type == 'mob') {
            $('#deal_form_filter_mob')[0].reset();
        } else {
            $('#deal_form_filter_dst')[0].reset();
        }
        initDaterangepicker();
        $('#deal_list_side_bar_modal').removeClass('clicked');

        var usert_type = $('.deals_tabs').find('li a.active').attr('data-active-name');
        if (usert_type == 'buyer') {
            dealsListBuyer(null, device_type);
        } else if (usert_type == 'seller') {
            dealsListSeller(null, device_type);
        } else {
            toastr.error(error_something_en_msg);
        }
    });

    $(document).on('change', '#sort_type_operation', debounce(function (e) {
        e.preventDefault();
        var self = $(this);
        var usert_type = $('.deals_tabs').find('li a.active').attr('data-active-name');
        if (usert_type == 'buyer') {
            dealsListBuyer(null, device_type);
        } else if (usert_type == 'seller') {
            dealsListSeller(null, device_type);
        } else {
            toastr.error(error_something_en_msg);
        }
    }, 200));

    $(document).on('click', '.evt_btn_go_page_no', function (e) {
        e.preventDefault();
        var self = $(this);
        var usert_type = self.attr('data-active-name');
        var last_page_no = self.attr('data-last-page');
        if (usert_type == 'buyer') {
            var input_page_no = $('#got_to_page_buyer').val();
            if (parseInt(last_page_no) >= parseInt(input_page_no)) {
                dealsListBuyer(input_page_no, device_type);
            } else {
                toastr.error(`Maximum page no ${last_page_no}`);
            }
        } else if (usert_type == 'seller') {
            var input_page_no = $('#got_to_page_seller').val();
            if (parseInt(last_page_no) >= parseInt(input_page_no)) {
                dealsListSeller(input_page_no, device_type);
            } else {
                toastr.error(`Maximum page no ${last_page_no}`);
            }
        } else {
            toastr.error(error_something_en_msg);
        }
    });

    $(document).on('click', '.evt_refresh_icon', function (event) {
        event.preventDefault();

        var device_type = $(this).attr('data-device-type');
        var usert_type = $('.deals_tabs').find('li a.active').attr('data-active-name');
        initDaterangepicker();
        if (usert_type == 'buyer') {
            dealsListBuyer(null, device_type);
        } else if (usert_type == 'seller') {
            dealsListSeller(null, device_type);
        } else {
            toastr.error(error_something_en_msg);
        }
    });

    $(document).on('click', '.paginate_seller .pagination a', function (event) {
        event.preventDefault();
        var page_no = $(this).attr('href').split('page=')[1];
        dealsListSeller(page_no, device_type);
    });

    $(document).on('click', '.paginate_buyer .pagination a', function (event) {
        event.preventDefault();
        var page_no = $(this).attr('href').split('page=')[1];
        dealsListBuyer(page_no, device_type);
    });

    $(document).on('click', '.evt_deals_details', function (event) {
        event.preventDefault();
        var details_link = $(this).attr('data-deals-details-link');
        window.location.href = details_link;
    });

});

function dealsListSeller(page_no = null, device_type) {
    var usert_type = $('.deals_tabs').find('li a.active').attr('data-active-name');
    // setLoadin();
    var form_data = $('#deal_form_filter_dst').serialize();
    if(device_type == 'mob') {
        form_data = $('#deal_form_filter_mob').serialize();
    }
    $.ajax({
        type: "POST",
        url: ajax_deals_list_seller_url + '?page=' + page_no,
        data: form_data + '&sort_type=' + $('#sort_type_operation').val() + '&user_type=' + usert_type + '&deals_filter_dashboard=' + deals_filter_dashboard,
        dataType: 'json',
        beforeSend: function() {
            $('#ajax_deals_list_seller').html(DealPage.list(5, device_type));
        },
        success: function (res) {
            // unsetLoadin();
            if (res.status == true) {
                $('#ajax_deals_list_seller').html(res.data.dhtml);

                /* if (deals_filter_dashboard) {
                    $('#ajax_deals_seller_dashboard').html(res.data.deals_seller_dashboard);
                } */
                // toastr.success(res.message);
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

function dealsListBuyer(page_no = null, device_type) {
    var usert_type = $('.deals_tabs').find('li a.active').attr('data-active-name');
    // setLoadin();

    var form_data = $('#deal_form_filter_dst').serialize();
    if(device_type == 'mob') {
        form_data = $('#deal_form_filter_mob').serialize();
    }

    $.ajax({
        type: "POST",
        url: ajax_deals_list_buyer_url + '?page=' + page_no,
        data: form_data + '&sort_type=' + $('#sort_type_operation').val() + '&user_type=' + usert_type + '&deals_filter_dashboard=' + deals_filter_dashboard,
        dataType: 'json',
        beforeSend: function() {
            $('#ajax_deals_list_buyer').html(DealPage.list(5, device_type));
        },
        success: function (res) {
            // unsetLoadin();
            if (res.status == true) {
                $('#ajax_deals_list_buyer').html(res.data.dhtml);

                /* if (deals_filter_dashboard) {
                    $('#ajax_deals_buyer_dashboard').html(res.data.deals_buyer_dashboard);
                } */

                // toastr.success(res.message);
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

$(document).on('click', '.evt_change_status', function () {
    var self = $(this);
    var offer_id = self.attr('data-offer-id');
    var offer_status = self.attr('data-status');
    var form_data = {
        'offer_id': offer_id,
        'otp_resend': false,
        'offer_status': offer_status,
    }

    if (offer_id != '' && offer_status != '') {
        Swal.fire({
            title: ays_en_msg,
            text: "Are you sure, you want to " + offer_status + " this?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0D6EFD',
            cancelButtonColor: '#2E365A',
            confirmButtonText: 'Yes, ' + offer_status + ' it!'
        }).then((result) => {
            if (result.isConfirmed) {
                setLoadin();
                $.ajax({
                    type: "POST",
                    // url: "{{ route('counter-offer.ajax-confirm-offer-pdf') }}",
                    url: ajax_url_resend_otp_url,
                    data: form_data,
                    dataType: 'json',
                    success: function (res) {
                        unsetLoadin();
                        if (res.status == true) {

                            $('#ajax_confrim_offer_contract').html(res.data.dhtml);
                            var select_box = $('.evt_div_select_option_box');

                            $('#deals_contract_form')[0].reset();
                            $('#confrim_offer_contract_modal').modal('show');

                            var select_box_operation = "";
                            if (res.data.is_user_company == 1 && res.data.user_contract_sing.length > 0) {
                                $('#evt_div_select_box_deals_contract_name').show();
                                $('#evt_div_text_box_deals_contract_name').remove();

                                select_box_operation += `<option value="">Select Contract User</option>`;
                                res.data.user_contract_sing.forEach(user_name => {
                                    select_box_operation += `<option value="${user_name}">${user_name}</option>`;
                                });
                                select_box.html(select_box_operation);
                            } else {
                                $('#evt_div_text_box_deals_contract_name').show();
                                $('#evt_div_select_box_deals_contract_name').remove();
                            }

                            $('body #deal_otp').text(res.data.otp);
                            dealsPhoneNumber();
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
        toastr.error(please_sel_ofr_en_msg);
    }
});

function dealsPhoneNumber() {
    $("#deals_contract_phone").intlTelInput({
        initialCountry: "py",
        separateDialCode: true,
        utilsScript: "{{ asset('plugins/intl-tel-input-17.0.19/build/js/utils.js') }}",
        hiddenInput: "phone_number",
    });
}

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