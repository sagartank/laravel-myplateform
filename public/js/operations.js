var device_type = detectDeviceType();
$(document).ready(function () {
    
    $('.mob_createbtn').hide(); // for mobile design
    initDaterangepickerSingle();

    $('#sort_type_operation_div').hide();
    var active_operation_nav_name_val = sessionStorage.getItem("active_operation_nav_name");
    var active_operation_tab_name_val = sessionStorage.getItem("active_operation_tab_name");

    if (active_operation_tab_name_val == null || active_operation_nav_name_val == null) {
        sessionStorage.setItem("active_operation_nav_name", 'operations-tab');
        sessionStorage.setItem("active_operation_tab_name", '#operations-tab-pane');

        let active_operation_nav_name_val = sessionStorage.getItem("active_operation_nav_name");
        let active_operation_tab_name_val = sessionStorage.getItem("active_operation_tab_name");

        $(`#${active_operation_nav_name_val}`).addClass('active');
        $(`${active_operation_tab_name_val}`).addClass('active show');
    }

    if (active_operation_tab_name_val == '#drafts-tab-pane') {
        $('#sort_type_operation_div').show();
    }

    $('.evt_operations_tab').click(function (e) {
        e.preventDefault();
        $('#sort_type_operation_div').hide();
        var operation_nav_name = $(this).attr('id');
        var operation_tab_name = $(this).attr('data-bs-target');
        console.log('operation_nav_name - id ', operation_nav_name);
        console.log('operation_tab_name - target ', operation_tab_name);
        sessionStorage.setItem("active_operation_nav_name", operation_nav_name);
        sessionStorage.setItem("active_operation_tab_name", operation_tab_name);
        if (operation_tab_name == '#drafts-tab-pane') {
            $('#sort_type_operation_div').show();
        }
    });

    $(`#${active_operation_nav_name_val}`).addClass('active');
    $(`${active_operation_tab_name_val}`).addClass('active show');

    $('#hide_show_amount').hide();
    $('#add_tags').select2({
        // tags: true,
        dropdownCssClass: 'increasezindex',
        placeholder: 'Search Tags',
        ajax: {
            dataType: 'json',
            type: 'post',
            delay: 500,
            url: url_load_operations_tags,
            data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
            },
            processResults: function (res) {
                console.log(' res.data', res.data);
                return {
                    data: res.data,
                    results: res.data,
                };
            },
            cache: true
        }
    });
    /*start load more operations data and advance filter*/
    loadMoreOperationsData(null, device_type);
    loadMoreOffersData();
    // loadMoreOfferContractData();

    $(document).on('click', '.evt_operations_details', function (e) {
        e.preventDefault();
        var details_link = $(this).attr('data-operations-details-link');
        window.location.href = details_link;
    });

    $(document).on('click', '.evt_paginate_operations .pagination a', function (e) {
        e.preventDefault();
        var page_no = $(this).attr('href').split('page=')[1];
        loadMoreOperationsData(page_no, device_type);
    });

    $(document).on('click', '.evt_got_to_page', debounce(function (e) {
        e.preventDefault();
        var self = $(this);
        var last_page_no = self.attr('data-last-page');
        var input_page_no = $('#page_no').val();

        if (parseInt(last_page_no) >= parseInt(input_page_no)) {
            loadMoreOperationsData($('#page_no').val(), device_type);
        } else {
            toastr.error(`Maximum page no ${last_page_no}`);
        }
    }, 200));

    $(document).on('click', '.evt_op_form_filter_apply', function (e) {
        e.preventDefault();
        let self = $(this);
        let device_type = $(this).attr('data-device-type');
        $('#filter_offer_status').val('');
        $('#op_list_side_bar_modal').removeClass('clicked');
        operation_filter_dashboard = true;
        loadMoreOperationsData(null, device_type);
    });

    $(document).on('click', '.evt_op_form_filter_reset', function (e) {
        e.preventDefault();
        let self = $(this);
        let device_type = $(this).attr('data-device-type');
        $('#op_list_side_bar_modal').removeClass('clicked');
        if (device_type == 'mob') {
            $('#op_form_filter_mob')[0].reset();
        } else {
            $('#op_form_filter_dst')[0].reset();
        }
        $('#filter_offer_status').val('');
        $('#operation_status').val('').trigger('change');
        initDaterangepickerSingle();
        operation_filter_dashboard = true;
        loadMoreOperationsData(null, device_type);
    });

    $(document).on('change', '#sort_type_operation', debounce(function (e) {
        e.preventDefault();
        let self = $(this);
        $('#filter_offer_status').val('');
        loadMoreOperationsData(null, device_type);
    }, 200));

    $(document).on('click', '.evt_delete_multiple_operation', function (e) {
        e.preventDefault();
        var self = $(this);
        var operation_ids = [];
        $(".operations_checkbox:checked").each(function () {
            operation_ids.push($(this).val());
        });

        if (operation_ids.length == 0) {
            toastr.error(operation_delete_at_list_one_en_msg);
            return false;
        }
        const res = confirm(ays_delete_en_msg);
        if (res && operation_ids.length != 0) {
            setLoadin();
            $.ajax({
                type: 'POST',
                url: self.attr('data-href'),
                dataType: 'json',
                data: {
                    'operation_ids': operation_ids,
                    'action': 'multiple'
                },
                cache: false,
                success: function (res) {
                    unsetLoadin();
                    if (res.status == true) {
                        $('#ajax_operations_list').empty();
                        loadMoreOperationsData(url_load_more_operations_data);
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

    $(document).on('click', '.evt_operation_status', function (e) {
        e.preventDefault();
        var self = $(this);
        operation_filter_dashboard = false;
        var status_name = self.attr('data-status-name');
        if (OFFER_FILTER_ARRAY.includes(status_name)) {
            $('#filter_offer_status').val(status_name);
            $('#operation_status').val('');
        } else {
            $('#operation_status').val(status_name);
            $('#filter_offer_status').val('');
        }
        loadMoreOperationsData(null, device_type);
    });

    $(document).on('click', '.evt_mi_operation_status', function (e) {
        e.preventDefault();
        var self = $(this);
        operation_filter_dashboard = false;
        var status_name = self.attr('data-status-name');

        if (status_name == OFFER_FILTER_SOLD) {
            window.location.href = url_deals;
        }

        if (OFFER_FILTER_ARRAY.includes(status_name)) {
            $('#filter_offer_status').val(status_name);
            $('#operation_status').val('');
        } else {
            $('#operation_status').val(status_name);
            $('#filter_offer_status').val('');
        }

        $('.evt_operations_tab').removeClass('active');
        $('#operations-tab-pane').removeClass('active show');
        $('#mi-operations-tab-pane').removeClass('active show');

        loadMoreOperationsData(null, device_type);

        $('#sort_type_operation_div').hide();
        var operation_nav_name = 'drafts-tab';
        var operation_tab_name = '#drafts-tab-pane';
        sessionStorage.setItem("active_operation_nav_name", operation_nav_name);
        sessionStorage.setItem("active_operation_tab_name", operation_tab_name);
        if (operation_tab_name == '#drafts-tab-pane') {
            $('#sort_type_operation_div').show();
        }
        $(`#${active_operation_nav_name_val}`).addClass('active');
        $(`${active_operation_tab_name_val}`).addClass('active show');
    });


    $(document).on('change', '#chk_all_explore', function (e) {
        e.preventDefault();
        var obj = $(this);
        $("body .operations_checkbox").prop('checked', $(this).prop("checked"));
    });

    $(document).on('click', '.evt_revert_multiple_operation', function (e) {
        e.preventDefault();
        var self = $(this);
        var operation_ids = [];
        $(".operations_checkbox:checked").each(function () {
            if ($(this).attr('data-operation-status') == OPERATIONS_STATUS_PENDING) {
                operation_ids.push($(this).val());
            }
        });

        if (operation_ids.length == 0) {
            toastr.error(`Please select at least one ${OPERATIONS_STATUS_PENDING} item`);
            return false;
        }
        const res = confirm('Are you sure, you want to this items?');
        if (res && operation_ids.length != 0) {
            setLoadin();
            $.ajax({
                type: 'POST',
                url: self.attr('data-href'),
                dataType: 'json',
                data: {
                    'operation_ids': operation_ids,
                    'operations_status': OPERATIONS_STATUS_DRAFT
                },
                cache: false,
                success: function (res) {
                    unsetLoadin();
                    if (res.status == true) {
                        $('#ajax_operations_list').empty();
                        loadMoreOperationsData(url_load_more_operations_data, device_type);
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
    /*end load more operations data and advance filter*/

    /*start offer list*/
    $(document).on('click', '.evt_paginate_offers .pagination a', function (e) {
        e.preventDefault();
        var page_no = $(this).attr('href').split('page=')[1];
        loadMoreOffersData(page_no);
    });

    $(document).on('click', '.evt_offers_got_to_page', function (e) {
        e.preventDefault();
        var self = $(this);
        var last_page_no = self.attr('data-last-page');
        var input_page_no = $('#offer_page_no').val();

        if (parseInt(last_page_no) >= parseInt(input_page_no)) {
            loadMoreOffersData($('#offer_page_no').val());
        } else {
            toastr.error(`Maximum page no ${last_page_no}`);
        }
    });

    $(document).on('click', '.evt_operation_by_offer', function (e) {
        e.preventDefault();
        var self = $(this);
        var operation_id = self.attr('data-operation-id');
        var offer_type = self.attr('data-offer-type');
        var offer_id = self.attr('data-offer-id');
        var offer_amount = self.attr('data-offer-amount');

        var issuer_name = self.attr('data-issuer-name');
        var operation_type_number = self.attr('data-operation-type-number');
        var operation_details_link = self.attr('data-operation-details-link');

        $('#add_select_operation_id').val(operation_id);

        $('#ajax_send_offer_group_page').hide();
        $('#hide_show_amount').hide();
        if (offer_type == 'Single') {
            $('#add_view_more_detail').attr('data-operations-details-link', operation_details_link);
            $('#add_view_type_and_operation').text(operation_type_number).append('<span>' +
                issuer_name + '</span>');
            $('#hide_show_group_offer_div').addClass('d-none');
            $('#add_offer_amount').text(offer_amount);
            $('#hide_show_amount').show();
        } else {
            $('#hide_show_group_offer_div').removeClass('d-none');
        }

        $('.evt_operation_by_offer').removeClass('active-selected-div');
        self.addClass('active-selected-div');

        if (operation_id != '') {
            setLoadin();
            $.ajax({
                type: 'POST',
                url: url_load_operations_by_offer,
                data: {
                    'sort_column': 'amount',
                    'sort_type': $('#high_to_low_amount').val(),
                    'operation_id': operation_id,
                    'offer_type': offer_type,
                    'offer_id': offer_id
                },
                dataType: 'json',
                cache: false,
                success: function (res) {
                    unsetLoadin();
                    if (res.status == true) {

                        $("body .init_nice_select").niceSelect();

                        $('#ajax_high_low_amount_list').empty();

                        $('#ajax_high_low_amount_list').html(res.data.dhtml);

                        if (res.data.show_high_low_avg) {
                        $('#add_high_value').text(document.getElementById('offer_high_value').value);
                            
                        $('#add_low_value').text(document.getElementById('offer_low_value').value);
                            
                        $('#add_avg_value').text(document.getElementById('offer_avg_value').value);
                        }

                        $('#hide_show_group_offer_div').empty();

                        $('#hide_show_group_offer_div').html(res.data.dhtml_group_offer);

                        initLineChart(res.data.line_labels, res.data.line_data);

                        $('#add_select_operation_id').val(operation_id);

                        $("body .init_nice_select").niceSelect();
                        $("body .init_nice_select_high_low").niceSelect();

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
            toastr.error(please_sel_ofr_en_msg);
        }
    });
    /*end offer list*/

    /*start high to low and counter offer*/
    $(document).on('click', '.evt_send_offer_single', function (e) {
        e.preventDefault();
        let self = $(this);
        let offer_id = self.attr('data-offer-id');
        let operation_id = self.attr('data-operation-id');
        let offer_type = self.attr('data-offer-type');
        setLoadin();
        $.ajax({
            type: 'POST',
            url: url_send_single_counter_offer,
            // url: "{{ route('operations.ajax-send-single-counter-page') }}",
            data: {
                'operation_id': operation_id,
                'offer_id': offer_id,
                'offer_type': offer_type ?? 'Single'
            },
            dataType: 'json',
            cache: false,
            success: function (res) {
                unsetLoadin();
                if (res.status == true) {
                    $("body .init_nice_select").niceSelect();

                    $('#ajax_send_offer_group_page').show();

                    $('#ajax_send_offer_group_page').empty();

                    $('#ajax_send_offer_group_page').html(res.data.dhtml);

                    $("body .init_nice_select").niceSelect();

                    // $("body .init_nice_select_high_low").niceSelect();

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

    $(document).on('change', '.evt_offer_high_to_low_amount', function (e) {
        e.preventDefault();
        if ($('#add_select_operation_id').val() != '') {
            operationsDataHighLowAmount();
        }
    });
    /*end high to low and counter offer*/

    /*start submit form counter offer*/
    $(document).on('submit', '#counter_offer_form', function (e) {
        e.preventDefault();
        let form = $(this);
        let form_valid = form.valid();
        let offer_id = $('#select_offer_id').val();
        let offer_amount = currency_inr($('#counter_offer_amount'));
        let old_offer_amount = currency_inr($('#offer_amount_hidden'));
        var reminder = '0';

        if (old_offer_amount == '') {
            return false;
        }

        if (form_valid && offer_id != '' && offer_id != '0' && offer_amount != '' && offer_amount !=
            '0') {
            var form_data = {
                'offer_id': offer_id,
                'counter_offer_hour_day': $('body #counter_offer_hour_day').val(),
                "counter_offer_payment_method": $('body #preferred_payment_method').val(),
                "counter_offer_amount": offer_amount,
                "counter_offer_time": $('body #counter_offer_time').val(),
                "reminder_on_expire": reminder
            }
            setLoadin();
            let actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form_data,
                dataType: 'json',
                beforeSend: function() {
                    $('.cmd-btn-offer-sbm-loader').html(btn_common_loader);
                    $('.cmd-btn-offer-sbm').hide();
                    $('.evt_hide_show_approved_reject_div').hide();
                },
                success: function (res) {
                    $('.cmd-btn-offer-sbm-loader').html(null);
                    $('.cmd-btn-offer-sbm').show();
                    $('.evt_hide_show_approved_reject_div').show();
                    $('body #counter_offer_form')[0].reset();
                    if (res.status == true) {
                        $('#select_offer_id').val('');
                        $('#counter_offer_payment_method').select2().trigger('change');
                        $('#hide_show_amount').hide();
                        $('#hide_show_group_offer_div').empty();
                        $('#ajax_send_offer_group_page').empty();
                        loadMoreOffersData();
                        $('#row_offer_remove_' + offer_id).remove();
                        toastr.success(res.message);
                    } else {
                        toastr.error(res.message);
                    }
                },
                error: function (xhr) {
                    $('.cmd-btn-op-sbm-loader').html(null);
                    $('.cmd-btn-offer-sbm').show();
                    $('.evt_hide_show_approved_reject_div').show();
                    ajaxErrorMsg(xhr);
                }
            });
        } else {
            if (offer_id == '') {
                toastr.error(please_sel_ofr_en_msg);
            }
        }
    });
    /*end submit form counter offer*/
});

/*end $document*/
function loadMoreOperationsData(page_no = null, device_type) {
    $('#ajax_operations_list').html(OperationsPage.list(20));
    var form_data = $('#op_form_filter_dst').serialize();
    if (device_type == 'mob') {
        form_data = $('#op_form_filter_mob').serialize();
    }

    $.ajax({
        type: 'POST',
        url: url_load_more_operations_data + '?page=' + page_no,
        data: form_data + '&sort_type=' + $('#sort_type_operation')
            .val() + '&offer_status=' + $('#filter_offer_status').val() + '&operation_filter_dashboard=' +
            operation_filter_dashboard,
        dataType: 'json',
        cache: false,
        success: function (res) {
            if (res.status == true) {
                $('#ajax_operations_list').html(res.data.dhtml);
                if (operation_filter_dashboard) {
                    $('#ajax_operation_dashboard_div').html(res.data.operations_dashboard);
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

function loadMoreOffersData(page_no = null) {
    setLoadin();
    $.ajax({
        type: 'POST',
        url: url_load_more_offers_data + '?page=' + page_no,
        data: {
            'sort_type' : $('#sort_type_operation_by_offer').val()
        },
        dataType: 'json',
        cache: false,
        success: function (res) {
            unsetLoadin();
            if (res.status == true) {
                $('#ajax_offers_list').html(res.data.dhtml);
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

function offerAcceptReject_contract(obj, offer_status) {
    var self = $(obj);
    var offer_id = self.attr('data-offer-id');
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
                        url: url_cofirm_offer,
                        // url: "{{ route('counter-offer.ajax-confirm-offer-pdf') }}",
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
                        url: url_offer_status,
                        // url: "{{ route('counter-offer.ajax-save-offer-status') }}",
                        data: form_data,
                        dataType: 'json',
                        success: function (res) {
                            unsetLoadin();
                            if (res.status == true) {
                                self.attr('data-offer-id', '');
                                $('#hide_show_amount').hide();
                                $('#ajax_send_offer_group_page').empty();
                                loadMoreOffersData();
                                Swal.fire(
                                    offer_status + '!',
                                    res.message,
                                    // 'Your record has been ' + action_name,
                                    'success'
                                )
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
            }
        });
    } else {
        toastr.error(please_sel_ofr_en_msg);
    }
}

function offerAcceptReject(obj, offer_status) {
    var self = $(obj);
    var offer_id = self.attr('data-offer-id');
    var form_data = {
        'offer_id': offer_id,
        'offer_status': offer_status,
    }
    if (offer_id != '' && offer_status != '') {
            var status_msg = "Are you sure, you want to " + offer_status + " this?";
            var offer_status_msg = "";
            if(offer_status == 'Approved') {
                offer_status_msg = approved_en_msg;
                status_msg = ays_approve_en_msg;
            } else if(offer_status == 'Rejected') {
                offer_status_msg = rejected_en_msg;
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
            cancelButtonText: cancle_en_msg,
            // confirmButtonText: 'Yes, ' + offer_status + ' it!'
        }).then((result) => {
            if (result.isConfirmed) {
                setLoadin();
                $.ajax({
                    type: "POST",
                    url: url_offer_status,
                    // url: "{{ route('counter-offer.ajax-save-offer-status') }}",
                    data: form_data,
                    dataType: 'json',
                    success: function (res) {
                        unsetLoadin();
                        if (res.status == true) {
                            self.attr('data-offer-id', '');
                            $('#hide_show_amount').hide();
                            $('#ajax_send_offer_group_page').empty();
                            $('#hide_show_group_offer_div').empty();
                            loadMoreOffersData();
                            Swal.fire(
                                offer_status_msg + '!',
                                res.message,
                                // 'Your record has been ' + action_name,
                                success_en_msg
                            )
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
    } else {
        toastr.error(please_sel_ofr_en_msg);
    }
}

function operationsDataHighLowAmount() {
    setLoadin();
    var operation_id = $('#add_select_operation_id').val();
    if (operation_id != '') {
        $.ajax({
            type: 'POST',
            url: url_operations_high_low_amount,
            // url: "{{ route('operations.ajax-operations-high-low-amount') }}",
            data: {
                'sort_column': 'amount',
                'sort_type': $('#high_to_low_amount').val(),
                'operation_id': operation_id,
                'offer_type': 'Single'
            },
            dataType: 'json',
            cache: false,
            success: function (res) {
                unsetLoadin();
                if (res.status == true) {
                    $('body #ajax_high_low_amount_list_sort_by').html(res.data.dhtml);
                    // $('#ajax_high_low_amount_list').html(res.data.dhtml);
                    $('#ajax_list_group_offer_by_operation').html(res.data.dhtml_group_offer);
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
        toastr.error(please_sel_ofr_en_msg);
    }
}

function initLineChart(labels_arr, data_arr) {
    const labels = labels_arr
    const data = {
        labels: labels,
        datasets: [{
            data: data_arr,
            fill: false,
            borderColor: '#13153B',
            // tension: 0.1
        }]
    };

    $('#div_line_chart').empty();

    var canvas = document.createElement("canvas");
    canvas.setAttribute("id", "line_chart_");

    $('#div_line_chart').html(canvas);

    new Chart(document.getElementById('line_chart_'), {
        type: 'line',
        data: data,
        options: {
            plugins: {
                legend: {
                    display: false
                },
            }
        }
    });
}

$(document).ready(function () {
    const data = {
        labels: pichart_labels,
        datasets: [{
            label: 'OPERATIONS',
            data: pichart_data,
            backgroundColor: [
                'rgb(13, 110, 253, 1.0)',
                'rgb(220,53,69,1.0)',
                'rgb(13, 110, 253, 0.8)',
                'rgb(220,53,69, 0.8)',
                'rgb(13, 110, 253, 0.6)',
                'rgb(220,53,69,0.6)',
                'rgb(13, 110, 253, 0.4)',
                'rgb(220,53,69, 0.4)',
            ],
            hoverOffset: 4
        }]
    };
    new Chart(document.getElementById('pie_chart_mi_operations_div'), {
        type: 'pie',
        data: data,
        options: {
            plugins: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        }
    });
});

// js for offer-contract-list
$(document).on('click', '.evt_paginate_offers_contract .pagination a', function (e) {
    e.preventDefault();
    var page_no = $(this).attr('href').split('page=')[1];
    loadMoreOfferContractData(page_no);
});

$(document).on('click', '.evt_offers_contract_got_to_page', function (e) {
    e.preventDefault();
    var self = $(this);
    var last_page_no = self.attr('data-last-page');
    var input_page_no = $('#offer_contract_page_no').val();

    if (parseInt(last_page_no) >= parseInt(input_page_no)) {
        loadMoreOfferContractData($('#offer_contract_page_no').val());
    } else {
        toastr.error(`Maximum page no ${last_page_no}`);
    }
});

function loadMoreOfferContractData(page_no = null) {
    setLoadin();
    $.ajax({
        type: 'POST',
        url: url_load_more_offer_contract_data + '?page=' + page_no,
        data: {},
        dataType: 'json',
        cache: false,
        success: function (res) {
            unsetLoadin();
            if (res.status == true) {
                $('#ajax_offer_contract_list').html(res.data.dhtml);
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
$(document).on('click', '#btn_bulk_upload_modal_modal_form', function (e) {
    e.preventDefault();
    if ($("#bulk_upload_modal_modal_form").valid()) {
        $(this).val('Uploading...');
        $(this).attr('disabled', 'disabled');
        $('#bulk_upload_modal_modal_form').submit();
    }
});

$(document).on('click', '.evt_group_offer_by_operation', function (e) {
    e.preventDefault();
    var offer_id = $(this).attr('data-offer-id');

    if (offer_id == '') {
        toastr.error(error_something_en_msg);
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
        beforeSend: function () {
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

/* Dropzone.options.bulkUploadModalForm = {
    paramName: "operation_xls",
    acceptedFiles: ".xlsx",
    binaryBody: false,
    maxFiles : 1,
    // addRemoveLinks: true,
    params: {
    },
    init: function () {
        this.on("success", function (file, res) {
            toastr.success('Bulk Upload file successfully');
            $('#bulkexampleModal').modal('hide');
        });
        this.on("error", function (file, errorMessage) {
            toastr.error(errorMessage);
            // $('#bulkexampleModal').modal('hide');
        });
        this.on('removedfile', function (file) {
            console.log('File removed:', file);
        });
    }
}; */

Dropzone.autoDiscover = false;
var dropzone = new Dropzone("#bulk_upload_modal_form", {
    paramName: "operation_xls",
    acceptedFiles: ".xlsx",
    binaryBody: false,
    maxFiles : 1,
});

dropzone.on("removedfile", function (file) {
    console.log('remove triggered');
});

dropzone.on("success", function (file, res) {
    toastr.success('Bulk Upload file successfully');
    $('#bulkexampleModal').modal('hide');
});
dropzone.on("error", function (file, errorMessage) {
    toastr.error(errorMessage);
    dropzone.removeAllFiles(true);
});

dropzone.on("addedfile", function (file) {
    console.log('addedfile triggered');
});

$(document).on('click', '#btn_bulk_modal_show', function () {
    $('#bulkexampleModal').modal('show');
});

$(document).on('change', '#sort_type_operation_by_offer', function () {
    loadMoreOffersData();
});

$(document).on('click', '.evt_cal_open', function (e) {
    e.preventDefault();
    $('input[name="duration_date_range"]').click();
});

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