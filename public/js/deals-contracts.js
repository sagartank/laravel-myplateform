
// $(document).on('change', '#deals_contract_verify', function (e) {
$("#deals_contract_form").submit(function (e) {
    e.preventDefault();
    setTimeout(() => {
       /*  var input = $('input[name="phone_number"]');
            input.intlTelInput();

            input.on("countrychange", function() {
            input.val('');
        });
 */
        dealsPhoneNumber();
        var self = $(this);
        var deals_phone_number = $('input[name="phone_number"]').val();
        var chk_box_verify = $('#deals_contract_verify');
        var form_deals = $('#deals_contract_form');
        var action_url = form_deals.attr('action');
        var form_valid = form_deals.valid();
        var deals_contract_id = $('#deals_contract_id').val();
        var deals_id = $('#deals_id').val();
        var formData = new FormData($('#deals_contract_form')[0]);
        formData.append('deals_contract_id', deals_contract_id);
        formData.append('deals_id', deals_id);
        formData.append('deals_contract_status', 'Approved');
        formData.append('otp_resend', false);
        formData.append('deals_phone_number', deals_phone_number);

        if (chk_box_verify.is(':checked') && form_valid && deals_contract_id != '' && action_url != '' && deals_id != '') {
            Swal.fire({
                title: ays_en_msg,
                text: ays_sing_en_msg,
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
                        url: action_url,
                        data: formData,
                        dataType: 'json',
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function (res) {
                            chk_box_verify.prop('checked', false);
                            unsetLoadin();
                            if (res.status == true) {
                                $('#confrim_offer_contract_modal').modal('hide');
                                if ($.isFunction(window.loadMoreOffersData)) {
                                    $('#hide_show_amount').hide();
                                    $('#deals_contract_form')[0].reset();
                                    $('#ajax_send_offer_group_page').empty();
                                }

                                if ($.isFunction(window.dealsListSeller)) {
                                    dealsListSeller();
                                }

                                if ($.isFunction(window.dealsListBuyer)) {
                                    dealsListBuyer();
                                }

                                $('.evt_btn_sign_contract').remove();
                                $('#btn_sign_contract').remove();

                                toastr.success(res.message);
                                window.location.reload();
                            } else if (res.status == false) {
                                chk_box_verify.prop('checked', false);
                                toastr.error(res.message);
                                $('#deals_contract_form')[0].reset();
                            } else {
                                chk_box_verify.prop('checked', false);
                                toastr.error(res.message);
                            }
                        },
                        error: function (xhr) {
                            chk_box_verify.prop('checked', false);
                            unsetLoadin();
                            ajaxErrorMsg(xhr);
                        }
                    });
                } else {
                    chk_box_verify.prop('checked', false);
                }
            });
        } else {
            chk_box_verify.prop('checked', false);
            toastr.error(valid_form_en_msg);
        }
    }, 1000);
});

$(document).on('keyup', 'input[name="deals_contract_name"]', function (e) {
    var input_name = $(this).val();
    $('.add_sing_name_contract_pdf').text(input_name);
});


$(document).on('change', 'select[name="deals_contract_name"]', function (e) {
    var input_name = $(this).val();
    $('.add_sing_name_contract_pdf').text(input_name);
});

/* $(document).on('keyup', '#deals_contract_phone', function (e) {
    dealsPhoneNumber();
    console.log($(this).val());
}); */


$("#deals_contract_file").change(function (e) {
    var file_extensions_valid = ['png', 'jpg', 'jpeg', 'JPG', 'PNG', 'JPEG'];
    var img_show_div = document.getElementById('add_signature_contract_pdf');
    fileList = [];
    var totalfiles = document.getElementById('deals_contract_file').files.length;
    for (var index = 0; index < totalfiles; index++) {
        var file_name = e.target.files[index].name;
        var file_extensions = file_name.split('.').pop();
        if (file_extensions_valid.includes(file_extensions)) {
            fileList.push(URL.createObjectURL(e.target.files[index]));
        } else {
            alert('Please upload valid file. jpeg / jpg / png.');
            $("#deals_contract_file").val('').trigger('change');
        }
    }
    $('#add_signature_contract_pdf').empty();
    fileList.forEach(img_src_val => {
        var img_ele = document.createElement('img');
        img_ele.src = img_src_val;
        img_ele.width = '100';
        img_show_div.appendChild(img_ele);
    });
});

$(document).on('click', '#deals_contract_otp_resend', function (e) {
    e.preventDefault();
    var self = $(this);
    var offer_id = $('#deals_id').val();
    var formData = {
        'offer_id': offer_id,
        'otp_resend': true,
        'offer_status': 'Approved',
    }
    if (offer_id != '') {
        setLoadin();
        self.hide();
        $('#deals_contract_otp').val('');
        $('#deals_contract_verify').prop('checked', false);
        $.ajax({
            type: "POST",
            url: ajax_url_resend_otp_url,
            data: formData,
            dataType: 'json',
            cache: false,
            success: function (res) {
                unsetLoadin();
                $('#deals_contract_verify').prop('checked', false);
                if (res.status == true) {
                    $('#deal_otp').text(res.otp);
                    toastr.success(res.message)
                } else {
                    toastr.error(res.message);
                }
                setTimeout(() => {
                    self.show();
                }, 8000);
            },
            error: function (xhr) {
                setTimeout(() => {
                    self.show();
                }, 8000);
                $('#deals_contract_form')[0].reset();
                $('#deals_contract_verify').prop('checked', false);
                unsetLoadin();
                ajaxErrorMsg(xhr);
            }
        });
    }
});

function dealsPhoneNumber() {
    $("body #deals_contract_phone").intlTelInput({
        initialCountry: "py",
        separateDialCode: true,
        utilsScript: "{{ asset('plugins/intl-tel-input-17.0.19/build/js/utils.js') }}",
        hiddenInput: "phone_number",
    });
}

function dealContractVerifyOtp(obj, ajax_url, form_id) {
    $.ajax({
        type: "POST",
        url: ajax_url,
        data: $('body #deal_contract_verify_otp_form_'+form_id).serialize(),
        dataType: 'json',
        beforeSend: function() {
            $(obj).text(verify_en_msg +'...');
            $('body #deal_contract_verify_otp_resend_btn_'+form_id).hide();
        },
        success: function (res) {
            unsetLoadin();
            $(obj).text(verify_en_msg);
            if (res.status == true) {
                $(obj).attr('disabled', 'disabled');
                $(obj).text('Verified');
                $(obj).css('background-color', '#198754');
                $('body #deal_contract_verify_otp_resend_btn_'+form_id).hide();
                $('body #deal_otp_'+form_id).val(otp_verified_en_msg);
                $('body #deal_otp_'+form_id).attr('disabled', 'disabled');

                $('body #deal_name_'+form_id).attr('disabled', 'disabled');
                toastr.success(res.message);
            } else {
                $('body #deal_contract_verify_otp_resend_btn_'+form_id).show();
                toastr.error(res.message);
            }
        },
        error: function (xhr) {
            $(obj).text('Verify');
            $('body #deal_contract_verify_otp_resend_btn_'+form_id).show();
            unsetLoadin();
            ajaxErrorMsg(xhr);
        }
    });
}

function dealContractResendOtp(obj, ajax_url, form_id) {
    $.ajax({
        type: "POST",
        url: ajax_url,
        data: $('body #deal_contract_verify_otp_form_'+form_id).serialize(),
        dataType: 'json',
        beforeSend: function() {
            $(obj).hide();
        },
        success: function (res) {
            unsetLoadin();
            $(obj).show();
            if (res.status == true) {
                toastr.success(res.message);
            } else {
                toastr.error(res.message);
            }
        },
        error: function (xhr) {
            $(obj).show();
            unsetLoadin();
            ajaxErrorMsg(xhr);
        }
    });
}