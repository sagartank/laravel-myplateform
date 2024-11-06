$(function ($) {
    var bank_div = $('#bank_details_div');
    var ewallet_div = $('#ewallet_div');
    var bank_ewallet_div = $('#bank_ewallet_div');
    $('.evt_payment_options').change(function (e) {
        e.preventDefault();
        ewallet_div.hide();
        bank_div.hide();
        bank_ewallet_div.hide();
        var payment_val = $(this).val();
        if (payment_val != '') {
            if (payment_val == 'Bank') {
                bank_div.show();
                bank_ewallet_div.show();
                $('#identification_label_txt').text(doc_number_en_msg);
            } else if (payment_val == 'eWallet') {
                $('#identification_label_txt').text('ID Number');
                ewallet_div.show();
                bank_ewallet_div.show();
            }
        }
    });
    let date = new Date();
    date.setFullYear(date.getFullYear());
    document.getElementById("birth_date").max = date.toISOString().split("T")[0];
    loadMoreUserData();
    loadMoreFavoriteUserData();
    loadMoreBankUserData();
    loadMoreRoleData();

    $(".input-group.password .pass_txt_1").on("click", function () {
        let input = $('#oldpassword');
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
    $(".input-group.password .pass_txt_2").on("click", function () {
        let input = $('#newpassword');
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
    
    $(".input-group.password .pass_txt_3").on("click", function () {
        let input = $('#confirmpassword');
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    $('.evt_file_upload').on('change', function (e) {
        e.preventDefault();
        let form = $('#userProfileForm');
        let form_valid = form.valid();
        if (form_valid) {
            setLoadin();
            let actionUrl = form.attr('action');
            let formData = new FormData($('#userProfileForm')[0]);
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: formData,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                success: function (res) {
                    unsetLoadin();
                    $("input[type='file']").val('');
                    if (res.status == true) {
                        toastr.success(res.message);
                        $('#profile_image_url').attr('src', res.data[0]
                            .profile_image_url);
                        $('#user-login-profile').attr('src', res.data[0]
                            .profile_image_url);
                    } else {
                        toastr.error(res.message);
                    }
                },
                error: function (xhr) {
                    $("input[type='file']").val('');
                    unsetLoadin();
                    ajaxErrorMsg(xhr);
                }
            });
        } else {
            $("input[type='file']").val('');
            toastr.error('something went wrong please try again!');
        }
    });
    /* end user profile personal details */
    $("#personalDetailsForm").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let form_valid = form.valid();
        if (form_valid) {
            setLoadin();
            let formData = new FormData($('#personalDetailsForm')[0]);
            let actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: formData,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    // $('.savebtn').html(btn_common_loader);
                },
                success: function (res) {
                    $("input[type='password']").val('');
                    $("#user_profile_attache").val('');
                    unsetLoadin();
                    if (res.status == true) {
                        toastr.success(res.message);
                        $('#user-login-name').text((res.data[0].first_name + ' ' + res
                            .data[0].last_name));
                    } else {
                        toastr.error(res.message);
                    }
                },
                error: function (xhr) {
                    $("#user_profile_attache").val('');
                    unsetLoadin();
                    ajaxErrorMsg(xhr);
                }
            });
        }
    });
    /* end user profile personal details */
    /* start user profile Invite friends */
    $("#inviteForm").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let form_valid = form.valid();
        let ref_code = $('#txt_referral_code').attr('data-ref-code');
        if (form_valid && ref_code != '') {
            setLoadin();
            let formData = new FormData($('#inviteForm')[0]);
            // formData.append('referral_code', ref_code);
            formData.append('email', $("#email_invite").val());
            let actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: formData,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                success: function (res) {
                    $("#email_invite").val('');
                    unsetLoadin();
                    if (res.status == true) {
                        toastr.success(res.message);
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
    /* end user profile Invite friends */
    /* start user profile setting */
    $('.evt-user-profile-setting-form').change(function (e) {
        e.preventDefault();
        let self = $(this);
        let type = self.attr('data-type');
        var formData = {}
        var user_login_id = $('#web_user_login_slug').val();
        if (type == 'preferred_dashboard') {
            formData = {
                'type': type,
                'preferred_dashboard': self.val()
            };
        } else if (type == 'preferred_currency') {
            formData = {
                'type': type,
                'preferred_currency': self.val()
            };
        } else if (type == 'preferred_contact_method') {
            formData = {
                'type': type,
                'preferred_contact_method': self.val()
            };
        } else if (type == 'language') {
            formData = {
                'type': type,
                'language': self.attr('data-select-language')
            };
        }
        formData.user_login_id = user_login_id;
        if (formData != null && user_login_id != '') {
            setLoadin();
            $.ajax({
                type: "POST",
                url: url_user_profile_setting,
                // url: "{{ route('profile.ajax-user-profile-setting') }}" ,
                data: (formData),
                dataType: 'json',
                success: function (res) {
                    unsetLoadin();
                    if (res.status == true) {
                        toastr.success(res.message);
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
    /* end user profile setting */
    $('#addsubUserForm').submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let form_valid = form.valid();
        if (form_valid) {
            setLoadin();
            let formData = new FormData($('#addsubUserForm')[0]);
            let actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: formData,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                success: function (res) {
                    unsetLoadin();
                    if (res.status == true) {
                        toastr.success(res.message);
                        $('#add_new_user').modal('hide');
                        $('#addsubUserForm')[0].reset();
                        loadMoreUserData();
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
    $('#addUserBankForm').submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let form_valid = form.valid();
        if (form_valid) {
            setLoadin();
            let formData = new FormData($('#addUserBankForm')[0]);
            let actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: formData,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                success: function (res) {
                    unsetLoadin();
                    if (res.status == true) {
                        toastr.success(res.message);
                        $('#add_new_bank_modal').modal('hide');
                        $('#addUserBankForm')[0].reset();
                        loadMoreBankUserData();
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
    $('.evt_close_modal').click(function (e) {
        e.preventDefault();
        var self = $(this);
        var modal_name = self.attr('data-modal-name');
        var form_name = self.attr('data-form-name');
        $(modal_name).modal('hide');
        $(form_name)[0].reset();
    });
    $('.evt_open_otp_verify_address_verify_modal').click(function (e) {
        e.preventDefault();
        var self = $(this);
        $('#otp_verify_address_verify_modal').modal('show');
    });
    $("#otp_verify_address_form").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let form_valid = form.valid();
        if (form_valid) {
            setLoadin();
            let formData = new FormData($('#otp_verify_address_form')[0]);
            let actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: formData,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    // $('.savebtn').html(btn_common_loader);
                },
                success: function (res) {
                    unsetLoadin();
                    $(form)[0].reset();
                    if (res.status == true) {
                        $('.evt_open_otp_verify_address_verify_modal').unbind('click');
                        $('#otp_verify_anchor_tag').removeClass('evt_open_otp_verify_address_verify_modal');
                        /*    $('#otp_verify_anchor_tag').text('Verified');
                        $('#link_addree_class').removeClass('text-bg-primary');
                        $('#link_addree_class').addClass('text-bg-success'); */
                        $('#otp_verify_address_verify_modal').modal('hide');
                        toastr.success(res.message);
                        location.reload();
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
});
$(document).on('click', '.evt_paginate_user .pagination a', function (e) {
    e.preventDefault();
    var page_no = $(this).attr('href').split('page=')[1];
    loadMoreUserData(page_no);
});
$(document).on('click', '.evt_got_to_page', debounce(function (e) {
    e.preventDefault();
    var self = $(this);
    var last_page_no = self.attr('data-last-page');
    var input_page_no = $('#page_no').val();
    if (parseInt(last_page_no) >= parseInt(input_page_no)) {
        loadMoreUserData($('#page_no').val());
    } else {
        toastr.error(`Maximum page no ${last_page_no}`);
    }
}, 200));
$(document).on('click', '.evt_user_modal_open', function (e) {
    e.preventDefault();
    var self = $(this);
    const form_obj = $('#addsubUserForm');
    var modal_name = self.attr('data-modal-name');
    var form_name = self.attr('data-form-name');
    var user_data = self.attr('data-user-object');
    var action_name = self.attr('data-action');
    form_obj.find('#action').val(action_name);
    form_obj.find('#user_id').val('');
    form_obj.find('[type=submit]').text(action_name);

    if(action_name == 'Add') {
        $('#addsubUserForm').trigger('reset');
    }
    if (user_data && user_data != '') {
        user_data = JSON.parse(user_data);
        form_obj.find('#user_id').val(user_data.id);
        form_obj.find('#first_name').val(user_data.first_name);
        form_obj.find('#last_name').val(user_data.last_name);
        form_obj.find('#email').val(user_data.email);
        form_obj.find('#phone_number').val(user_data.phone_number);
        /* if(user_data.roles){
            form_obj.find('#role_id').val(user_data.roles[0].id);
        } */
    }
    $(modal_name).modal('show');
});
$(document).on('click', '.evt_role_modal_open', function (e) {
    setLoadin();
    e.preventDefault();
    var self = $(this);
    $.ajax({
        type: 'GET',
        url: $(this).attr('data-modal-url'),
        success: function (res) {
            console.log(res);
            unsetLoadin();
            if (res.status == true) {
                $('#role_modal_dailog').html(res.view);
                $('#role_modal').modal('show');
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
function loadMoreUserData(page_no = null) {
    setLoadin();
    $.ajax({
        type: 'POST',
        url: url_load_more_user_data + '?page=' + page_no,
        data: {},
        dataType: 'json',
        cache: false,
        success: function (res) {
            unsetLoadin();
            if (res.status == true) {
                $('#ajax_enterprise_by_user_list').html(res.data.dhtml);
                if(res.data.total == 0) {
                    $('#evt_no_sub_user').show();
                } else {
                    $('#evt_no_sub_user').hide();
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
}
// js favorites
$(document).on('click', '.evt_paginate_user_favorites .pagination a', function (e) {
    e.preventDefault();
    var page_no = $(this).attr('href').split('page=')[1];
    loadMoreFavoriteUserData(page_no);
});
$(document).on('click', '.evt_got_to_page_favorites', debounce(function (e) {
    e.preventDefault();
    var self = $(this);
    var last_page_no = self.attr('data-last-page');
    var loadMoreFavoriteUserData = $('#page_no_favorites').val();
    if (parseInt(last_page_no) >= parseInt(input_page_no)) {
        loadMoreFavoriteUserData($('#page_no_favorites').val());
    } else {
        toastr.error(`Maximum page no ${last_page_no}`);
    }
}, 200));
$(document).on('click', '.evt_favorite_delete', function (e) {
    e.preventDefault();
    var favorite_id = $(this).attr('data-favorite-id');
    Swal.fire({
        title: ays_en_msg,
        text: ays_delete_en_msg,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0D6EFD',
        cancelButtonColor: '#2E365A',
        confirmButtonText: yes_delete_en_msg
    }).then((result) => {
        if (result.isConfirmed) {
            setLoadin();
            $.ajax({
                type: "POST",
                url: url_favorite_profile_delete,
                // url: "{{ route('profile.ajax-favorite-prfile-delete') }}",
                data: {
                    'favorite_id': favorite_id
                },
                dataType: 'json',
                success: function (res) {
                    unsetLoadin();
                    if (res.status == true) {
                        toastr.success(res.message);
                        loadMoreFavoriteUserData();
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
});
function loadMoreFavoriteUserData(page_no = null) {
    setLoadin();
    $.ajax({
        type: 'POST',
        url: url_load_more_favorite_user_data + '?page=' + page_no,
        data: {},
        dataType: 'json',
        cache: false,
        success: function (res) {
            unsetLoadin();
            if (res.status == true) {
                $('#ajax_favorites_by_user_list').html(res.data.dhtml);
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
$(document).on('click', '.evt_bank_modal_open', function (e) {
    e.preventDefault();
    var self = $(this);
    const form_obj = $('#addUserBankForm');
    var modal_name = self.attr('data-modal-name');
    var form_name = self.attr('data-form-name');
    var bank_data = self.attr('data-bank-object');
    var action_name = self.attr('data-action');
    form_obj.find('#action').val(action_name);
    form_obj.find('#user_id').val('');
    form_obj.find('#bank_id').val('');
    form_obj.find('[type=submit]').text(action_name);
    if (bank_data && bank_data != '') {
        bank_data = JSON.parse(bank_data);
        $("input[name=preferred_payment_method][value='" + bank_data.payment_options + "']").prop("checked", true);
        form_obj.find('#bank_id').val(bank_data.id);
        form_obj.find('#user_id').val(bank_data.user_id);
        // form_obj.find('#bank_name').val(bank_data.bank_id);
        if (bank_data.bank_id) {
            $('#bank_name option[value=' + bank_data.bank_id + ']').attr('selected', 'selected');
        }
        form_obj.find('#account_name').val(bank_data.account_name);
        form_obj.find('#account_number').val(bank_data.account_number);
        form_obj.find('#phone_company').val(bank_data.phone_company);
        form_obj.find('#phone_number').val(bank_data.phone_number);
        form_obj.find('#identification_id').val(bank_data.identification_id);
        form_obj.find('#payment_note').val(bank_data.payment_note);
        var bank_div = $('#bank_details_div');
        var ewallet_div = $('#ewallet_div');
        var bank_ewallet_div = $('#bank_ewallet_div');
        ewallet_div.hide();
        bank_div.hide();
        bank_ewallet_div.hide();
        var payment_val = bank_data.payment_options;
        if (payment_val != '') {
            if (payment_val == 'Bank') {
                bank_div.show();
                bank_ewallet_div.show();
            } else if (payment_val == 'eWallet') {
                ewallet_div.show();
                bank_ewallet_div.show();
            }
        }
    }
    $(modal_name).modal('show');
});

function loadMoreBankUserData(page_no = null) {
    setLoadin();
    $.ajax({
        type: 'POST',
        url: url_load_more_bank_user_data + '?page=' + page_no,
        data: {},
        dataType: 'json',
        cache: false,
        success: function (res) {
            unsetLoadin();
            if (res.status == true) {
                $('#ajax_bank_details_list').html(res.data.dhtml);
                if(res.data.total == 0) {
                    $('#evt_payment_not').show();
                } else {
                    $('#evt_payment_not').hide();
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
}
//Load Role list
function loadMoreRoleData(page_no = null) {
    setLoadin();
    $.ajax({
        type: 'POST',
        url: url_load_more_role_data + '?page=' + page_no,
        data: {},
        dataType: 'json',
        cache: false,
        success: function (res) {
            unsetLoadin();
            if (res.status == true) {
                $('#ajax_role_list').html(res.data.dhtml);
            } else {
                toastr.error(res.message);
            }
            $('#role_modal').modal('hide');
        },
        error: function (xhr) {
            unsetLoadin();
            ajaxErrorMsg(xhr);
        }
    });
}

$(document).on('click', '.referral_code_copy', function (e) {
    e.preventDefault();
    try {
        var temp = document.createElement("input");
        temp.setAttribute("value", document.getElementById('txt_referral_code').innerHTML);
        document.body.appendChild(temp);
        temp.select();
        document.execCommand("copy");
        document.body.removeChild(temp);
        toastr.success('copy success');
    } catch (error) {
        ajaxErrorMsg(error);
    }
});

// otp-verify
$(document).ready(function () {
    const els = (sel, par) => (par || document).querySelectorAll(sel);

    els(".pin").forEach((elGroup) => {

        const elsInputOuter = [...elGroup.children];
        const elsInput = elsInputOuter.map((el) => el.firstChild);
        const len = elsInput.length;

        const handlePaste = (ev) => {
            const clip = ev.clipboardData.getData('text');          // Get clipboard data
            const pin = clip.replace(/\s/g, "");                    // Sanitize string
            const ch = [...pin];                                    // Create array of chars
            elsInput.forEach((el, i) => el.value = ch[i]??"");      // Populate inputs
            elsInput[pin.length - 1]??elsInput[len - 1].focus();    // Focus input
        };

        const handleInput = (ev) => {
            const elInp = ev.currentTarget;
            const i = elsInput.indexOf(elInp);
            if (elInp.value && (i+1) % len) elsInput[i + 1].focus();  // focus next
        };

        const handleKeyDn = (ev) => {
            const elInp = ev.currentTarget
            const i = elsInput.indexOf(elInp);
            if (!elInp.value && ev.key === "Backspace" && i) elsInput[i - 1].focus(); // Focus previous
        };

        // Add the same events to every input in group:
        elsInput.forEach(elInp => {
            elInp.addEventListener("paste", handlePaste);   // Handle pasting
            elInp.addEventListener("input", handleInput);   // Handle typing
            elInp.addEventListener("keydown", handleKeyDn); // Handle deleting
        });
    });
});

$(document).on('click', '.evt_account_status_modal_close', function (e) {
    e.preventDefault();
    $('#evt_account_status_modal').modal('hide');
});

$(document).ready(function () {
    // previous pass
    $("#oldpassicon").click(function (e) {
        e.preventDefault();
        var self = $(this);
        var oldpassword = $('#oldpassword');
        self.parent().toggleClass("show");
        if(self.parent().hasClass('show')){
            oldpassword.attr("type", "text");
        } else {
            oldpassword.attr("type", "password");
        }
    });
    //new
    $("#newpassicon").click(function (e) {
        e.preventDefault();
        var self = $(this);
        var newpassword = $('#newpassword');
        self.parent().toggleClass("show");
        if(self.parent().hasClass('show')){
            newpassword.attr("type", "text");
        } else {
            newpassword.attr("type", "password");
        }
    });
    //confirm
    $("#confirmpass").click(function (e) {
        e.preventDefault();
        var self = $(this);
        var confirmpassword = $('#confirmpassword');
        self.parent().toggleClass("show");
        if(self.parent().hasClass('show')){
            confirmpassword.attr("type", "text");
        } else {
            confirmpassword.attr("type", "password");
        }
    });
});