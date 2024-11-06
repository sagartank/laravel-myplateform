
$(document).ready(function () {
    $('.evt_suggest_modal_open').click(function (e) {
        e.preventDefault();
        $(`#suggest_more_info_modal`).modal('show');
    });

    $('.evt_claim_profile_modal_open').click(function (e) {
        e.preventDefault();
        $(`#claim_this_profile_modal`).modal('show');
    });

    $('.close_modal').click(function (e) {
        e.preventDefault();
        const form_name = $(this).attr('data-form-name');
        const modal_name = $(this).attr('data-modal-name');

        $(`${modal_name}`).modal('hide');
        $(`${form_name}`)[0].reset();
        $(`${form_name}`).find('.error').removeClass('error');
    });

    $("#form_suggest_more_info").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let form_valid = form.valid();
        if (form_valid) {
            setLoadin();
            let formData = new FormData($('#form_suggest_more_info')[0]);
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
                        $(`#suggest_more_info_modal`).modal('hide');
                        $('#form_suggest_more_info')[0].reset();
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

    $("#form_claim_profile").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let form_valid = form.valid();
        if (form_valid) {
            setLoadin();
            let formData = new FormData($('#form_claim_profile')[0]);
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
                        $(`#claim_this_profile_modal`).modal('hide');
                        $('#form_claim_profile')[0].reset();
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
})