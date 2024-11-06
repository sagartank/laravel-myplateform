let governmentContract = $('#government-contract-row-box');
let contractTitle = $('#contract-title-row-box');
let description = $('#description-row-box');
let checkNumber = $('#check-number-row-box');
let invoiceType = $('#invoice-type-row-box');
let invoiceNumber = $('#invoice-number-row-box');
let issuerCompanyType = $('#issuer-company-type-row-box');
let taxId = $('#tax-id-row-box');
let timbrado = $('#timbrado-row-box');
let authorizedPersonnel = $('#authorized-personnel-row-box');
// let authorizedPersonnelSignature = $('#authorized-personnel-signature-row-box');
let tagsInput = $('input[name="tags"]');
let expiration_add_days = $('#expiration-add-day-row-box');
let operation_type = "{{$operation->operation_type}}";
let auto_expire = $('#evt_auto_expire');
let paying_bank = $('#paying-bank-row-box');
let stamp_expiration = $('#stamp-expiration-row-box');
let contract_number = $('#contract-number-row-box');

$(document).ready(function () {
    applyDocTypeChange(operation_type);
    // pageLoadTags($('input[name="doc_type"]').val());

    $referenceRepeater = $('#reference-repeater').repeater({
        initEmpty: "{{ $operation->references->isEmpty() }}",
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            if(confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement);
            }
        },
        isFirstItemUndeletable: false,
    });

    
$('#evt_show_modal_payer').click(function (e) { 
    e.preventDefault();
    $('#form_add_payer_issuer')[0].reset();
    $('#modal_payer_issuer').modal('show');
});

$('#form_add_payer_issuer').submit(function (e) { 
    e.preventDefault();
    $('#cmd_btn_add_payer').val('Please Wait...');
    $("#cmd_btn_add_payer").attr("disabled", true);
    $.ajax({
        type: 'POST',
        url: "{{ route('operations.ajax-add-payer-issuer') }}",
        dataType: 'json',
        data: $('#form_add_payer_issuer').serialize(),
        success: function (res) {
            $('#cmd_btn_add_payer').val('Submit');
            $("#cmd_btn_add_payer").attr("disabled", false);
            if (res.status == true) {
                    toastr.success(res.message);
                    $('#form_add_payer_issuer')[0].reset();
                    $('#modal_payer_issuer').modal('hide');
            } else {
                toastr.error(res.message);
            }
        },
        error: function (xhr) {
            $('#cmd_btn_add_payer').val('Submit');
            $("#cmd_btn_add_payer").attr("disabled", false);
            unsetLoadin();
            ajaxErrorMsg(xhr);
        }
    });
});

$("#issuer").select2({
    ajax: {
        url: "{{ route('operations.ajax-payer-issuer-list') }}",
        dataType: 'json',
        delay: 500,
        data: function (params) {
            return {
                query: params.term, // search term
                page: params.page
            };
        },
        processResults: function (data, params) {
            return {
                    results: data.results
                };
        },
        cache: true
    }
});

    $("#operation-tags").select2({
        tags: true,
        tokenSeparators: [',', ';'],
        ajax: {
            url: "{{ route('operations.ajax-get-tags-list') }}",
            dataType: 'json',
            delay: 500,
            data: function (params) {
                return {
                    query: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results,
                    pagination: {
                        more: (params.page * data.tags.per_page) < data.tags.total
                    }
                };
            },
            cache: true
        },
        templateResult: function (res) {
            if (res.loading) {
                return null;
            }
            return res.text;
        },
        templateSelection: function (res) {
            return res.text;
        },
    });
    
    $(document).on('click', '.evt_click_extra_expiration_days', function (e) {
        e.preventDefault();
        if($(this).text()!='') {
            $('#extra_expiration_days').val($(this).text());
        }
    });

    $(document).on('change', '.document-type', function (e) {
        e.preventDefault();
        let el = $(this);
        applyDocTypeChange(el.val());
        // tagsInput.tagsinput('add', {'key' : el.prop('name'), 'value' : el.val()});            
    });

    // $(document).on('change', '.is-government-contract', function (e) {
    //     e.preventDefault();
    //     let el = $(this);
    //     if (el.val() == 'Yes') {
    //         tagsInput.tagsinput('add', {'key' : el.prop('name'), 'value' : 'Government'});
    //     }
    //     else {
    //         tagsInput.tagsinput('remove', {'key' : el.prop('name'), 'value' : 'Government'});
    //     }            
    // });

    // $(document).on('change', '.preferred-payment-method', function (e) {
    //     e.preventDefault();
    //     let el = $(this);
    //     tagsInput.tagsinput('add', {'key' : el.prop('name'), 'value' : el.val()});            
    // });

    // $(document).on('change', '.invoice-type', function (e) {
    //     e.preventDefault();
    //     let el = $(this);
    //     tagsInput.tagsinput('add', {'key' : el.prop('name'), 'value' : el.val()});            
    // });

    $(document).on('change', '#issuer', debounce(function (e) {
        e.preventDefault();
        let el = $(this);
        // tagsInput.tagsinput('add', {'key' : el.prop('name'), 'value' : el.val()});      
        submitOperationForm($('#form-update-operation'), (res) => {toastr.success(res.message);});      
    }, 500));

    $(document).on('change', '#amount', debounce(function (e) {
        e.preventDefault();
        submitOperationForm($('#form-update-operation'), (res) => {toastr.success(res.message);});
    }, 500));

    // $(document).on('change', '#issuer-company-type', function (e) {
    //     e.preventDefault();
    //     let el = $(this);
    //     tagsInput.tagsinput('add', {'key' : el.prop('name'), 'value' : el.val()});            
    // });

    // $(document).on('change', '#issuer-bank', debounce(function (e) {
    //     e.preventDefault();
    //     let el = $(this);
    //     tagsInput.tagsinput('add', {'key' : el.prop('name'), 'value' : el.val()});            
    // }, 500));

    // $("input[name='authorized_personnel_signature']").change(function(e) {
    //     let output = $('#authorized-personnel-signature-preview');
    //     output.attr('src', URL.createObjectURL(e.target.files[0]));
    //     output.show();
    //     output.onload = () => {
    //         URL.revokeObjectURL(output.src);
    //     };
    //     $('#authorized-personnel-signature-preview-box').show();
    // });

    // $(document).on('click', '#delete-authorized-personnel-signature', function (e) {
    //     e.preventDefault();
    //     $("input[name='authorized_personnel_signature']").val('');
    //     $.ajax({
    //         type: 'POST',
    //         dataType: 'JSON',
    //         headers: {
    //             'X-CSRF-Token': "{{ csrf_token() }}",
    //         },
    //         url: "{{ route('operations.ajax-delete-authorized-personnel-signature') }}",
    //         data: 'slug=' + $(this).data("operation-slug"),
    //         success: function (res) {
    //             if (res.success) {
    //                 console.log(res.message);
    //             }
    //             else {
    //                 alert('Error '+ res.status + ': ' + res.message);
    //             }
    //         },
    //     });
    //     $('#authorized-personnel-signature-preview-box').hide();
    // });

    $(document).on('submit', '#form-update-operation', function (e) {
        e.preventDefault();
        e.stopPropagation();

        submitOperationForm($(this), (res) => {
            // toastr.success(res.message);
            let timerInterval;
            Swal.fire({
                title: res.message,
                html: 'You will be redirected to details page.',
                timer: 4000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();                            
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
                }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    window.location.href = res.detailsLink;
                }
            });
        });
    });
});

// tagsInput.tagsinput({
//     itemValue: 'key',
//     itemText: 'value',
//     onTagExists: function(item, $tag) {
//         $tag.hide();
//         tagsInput.tagsinput('remove', item);
//         tagsInput.tagsinput('add', item);
//         $tag.fadeIn();
//     }
// });

function submitOperationForm (el, callback = () => {}) {
    $('#form-update-operation :input').removeClass('is-invalid');
    $('#form-update-operation .invalid-feedback').remove();
    setLoadin();

    var currency_type = $("input[name='preferred_currency']:checked").val();
    var amount_ = currency_inr_operation(currency_type, $('#amount').val());
    var amount_requested_ = currency_inr_operation(currency_type, $('#amount_requested').val());
    
    let data = new FormData(el[0]);
    data.append('amount', amount_);
    data.append('amount_requested', amount_requested_);

    // const tags = tagsInput.tagsinput('items').map(({ value }) => value);
    // tags.forEach((tag, i) => {
    //     data.append('operation_tags[' + i + ']', tag);
    // });

    documentDropzone.files.forEach((file, i) => {
        data.append('documents[' + i + ']', file);
        displayName = file.previewElement.querySelector("input[name='document_name']");
        data.append('document_names[' + i + ']', $(displayName).val());
    });

    supportingAttachmentDropzone.files.forEach((file, i) => {
        data.append('supporting_attachments[' + i + ']', file);
        displayName = file.previewElement.querySelector("input[name='supporting_attachment_name']");
        data.append('supporting_attachment_names[' + i + ']', $(displayName).val());
    });
    // console.log(data);

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        headers: {
            'X-CSRF-Token': "{{ csrf_token() }}",
        },
        url: "{{ route('operations.update', $operation) }}",
        data: data,
        cache: false,
        processData: false,
        contentType: false,
        success: function (res) {
            if (res.success) {
                console.log(res.message);
                // location.href = res.redirectTo;
                documentDropzone.removeAllFiles(true);
                $('.documents-previews-wrapper').empty();
                (res.documents).forEach(document => {
                    documentFile = { name: document.name, size: document.size * 1024 };
                    documentDropzone.displayExistingFile(documentFile, document.extension == 'pdf' ? "{{ asset('images/mipo/pdf.png') }}" : document.document_url, function () {
                        displayName = documentFile.previewElement.querySelector("input[name='document_name']");
                        $(displayName).val(document.display_name);
                        $(displayName).data("document-slug", document.slug);
                        $(displayName).on('change', function (e) {
                            e.preventDefault();
                            debounce(updateDocumentDisplayName($(this)), 900);
                        });
                        deleteDocumentBtn = $(documentFile.previewElement).find('.dz-remove');                                    
                        deleteDocumentBtn.addClass('delete-document-btn');
                        deleteDocumentBtn.data("document-slug", document.slug);                                    
                        $(deleteDocumentBtn).on('click', function (e) {
                            e.preventDefault();
                            if(confirm("Are you sure you want to delete this file?")) {
                                deleteDocument($(this), () => $(this).parents('.dz-image-preview').remove());
                            }
                        });
                    }, null, false);
                });

                supportingAttachmentDropzone.removeAllFiles(true);
                $('.supporting-attachments-previews-wrapper').empty();
                (res.supportingAttachments).forEach(supportingAttachment => {
                    supportingAttachmentFile = { name: supportingAttachment.name, size: supportingAttachment.size * 1024 };
                    supportingAttachmentDropzone.displayExistingFile(supportingAttachmentFile, supportingAttachment.extension == 'pdf' ? "{{ asset('images/mipo/pdf.png') }}" : supportingAttachment.attachment_url, function () {
                        displayName = supportingAttachmentFile.previewElement.querySelector("input[name='supporting_attachment_name']");
                        $(displayName).val(supportingAttachment.display_name);
                        $(displayName).data("supporting-attachment-slug", supportingAttachment.slug);
                        $(displayName).on('change', function (e) {
                            e.preventDefault();
                            debounce(updateSupportingAttachmentDisplayName($(this)), 900);
                        });
                        deleteSupportingAttachementBtn = $(supportingAttachmentFile.previewElement).find('.dz-remove');                                    
                        deleteSupportingAttachementBtn.addClass('delete-supporting-attachment-btn');
                        deleteSupportingAttachementBtn.data("supporting-attachment-slug", supportingAttachment.slug);                                    
                        $(deleteSupportingAttachementBtn).on('click', function (e) {
                            e.preventDefault();
                            if(confirm("Are you sure you want to delete this file?")) {
                                deleteSupportingAttachment($(this), () => $(this).parents('.dz-image-preview').remove());
                            }
                        });
                    }, null, false);
                });

                $('.references-repeater').empty();
                $referenceRepeater.setList(res.commercialReferences);

                callback(res);
            }
            else {
                alert('Error '+ res.status + ': ' + res.message);
            }
            unsetLoadin();
        },
        statusCode: {
            422: function (res) {
                $.each(res.responseJSON.errors, function (key, value) {
                    let target = $('#form-update-operation [name="' + dotToArray(key) + '"]');
                    target.addClass('is-invalid');
                    let errorAlert = '<span class="invalid-feedback" role="alert">' + value + '</span>';
                    target.parent().append(errorAlert);
                });
                unsetLoadin();
            }
        },
    });
}

function pageLoadTags (value) {
    // tagsInput.tagsinput('add', {'key' : $('.document-type').prop('name'), 'value' : $('.document-type').val()});
    if (value == 'Contract' || value == 'Other') {
        if ($('.is-government-contract').val() == 'Yes') {
            // tagsInput.tagsinput('add', {'key' : $('.is-government-contract').prop('name'), 'value' : 'Government'});
        }
    }   
    if ($('.preferred-payment-method').val()) {    
        // tagsInput.tagsinput('add', {'key' : $('.preferred-payment-method').prop('name'), 'value' : $('.preferred-payment-method').val()});
    }
    if (value == 'Invoice') {
        if ($('.invoice-type').val()) {
            // tagsInput.tagsinput('add', {'key' : $('.invoice-type').prop('name'), 'value' : $('.invoice-type').val()});
        }
    }                
    if ($('#issuer').val()) {
        // tagsInput.tagsinput('add', {'key' : $('#issuer').prop('name'), 'value' : $('#issuer').val()});
    }
    if (value == 'Invoice' || value == 'Contract' || value == 'Other') {
        if ($('#issuer-company-type').val()) {
            // tagsInput.tagsinput('add', {'key' : $('#issuer-company-type').prop('name'), 'value' : $('#issuer-company-type').val()});
        }
    }
    if ($('#issuer-bank').val()) {
        // tagsInput.tagsinput('add', {'key' : $('#issuer-bank').prop('name'), 'value' : $('#issuer-bank').val()});
    }
}

function applyDocTypeChange(value) {
    if (value == 'Cheque') {
        governmentContract.hide();
        auto_expire.hide();
        // tagsInput.tagsinput('remove', governmentContract.find('input').prop('name'));
        contractTitle.hide();
        description.hide();
        checkNumber.show();
        invoiceType.hide();
        // tagsInput.tagsinput('remove', invoiceType.find('input').prop('name'));
        invoiceNumber.hide();
        issuerCompanyType.hide();
        // tagsInput.tagsinput('remove', issuerCompanyType.find('input').prop('name'));
        taxId.hide();
        timbrado.hide();
        authorizedPersonnel.hide();
        expiration_add_days.hide();
        paying_bank.show();
        stamp_expiration.hide();
        contract_number.hide();
        // authorizedPersonnelSignature.hide();
    }
    else if (value == 'Invoice') {
        governmentContract.hide();
        auto_expire.show();
        // tagsInput.tagsinput('remove', governmentContract.find('input').prop('name'));
        contractTitle.hide();
        description.hide();
        checkNumber.hide();
        invoiceType.show();
        if(invoiceType.find('input:checked').length){
            // tagsInput.tagsinput('add', {'key' : invoiceType.find('input').prop('name'), 'value' : invoiceType.find('input:checked').val()});
        }
        invoiceNumber.show();
        issuerCompanyType.show();
        if(issuerCompanyType.find('select').val()){
            // tagsInput.tagsinput('add', {'key' : issuerCompanyType.find('select').prop('name'), 'value' : issuerCompanyType.find('select').val()});
        }
        taxId.show();
        authorizedPersonnel.show();
        expiration_add_days.show();
        paying_bank.hide();
        timbrado.show();
        stamp_expiration.show();
        contract_number.hide();
        // authorizedPersonnelSignature.show();
    }
    else if (value == 'Contract') {
        auto_expire.show();
        governmentContract.show();
        if(governmentContract.find('input:checked').val() == 'Yes'){
            // tagsInput.tagsinput('add', {'key' : governmentContract.find('input').prop('name'), 'value' : 'Government'});
        }
        contractTitle.show();
        description.hide();
        checkNumber.hide();
        invoiceType.hide();
        // tagsInput.tagsinput('remove', invoiceType.find('input').prop('name'));
        invoiceNumber.hide();
        issuerCompanyType.show();
        if(issuerCompanyType.find('select').val()){
            // tagsInput.tagsinput('add', {'key' : issuerCompanyType.find('select').prop('name'), 'value' : issuerCompanyType.find('select').val()});
        }
        taxId.hide();
        timbrado.hide();
        authorizedPersonnel.hide();
        expiration_add_days.show();
        paying_bank.hide();
        stamp_expiration.show();
        contract_number.show();
        // authorizedPersonnelSignature.show();
    }
    else if (value == 'Other') {
        auto_expire.show();
        governmentContract.show();
        if(governmentContract.find('input:checked').val() == 'Yes'){
            // tagsInput.tagsinput('add', {'key' : governmentContract.find('input').prop('name'), 'value' : 'Government'});
        }
        contractTitle.show();
        description.show();
        checkNumber.hide();
        invoiceType.hide();
        // tagsInput.tagsinput('remove', invoiceType.find('input').prop('name'));
        invoiceNumber.hide();
        issuerCompanyType.show();
        if(issuerCompanyType.find('select').val()){
            // tagsInput.tagsinput('add', {'key' : issuerCompanyType.find('select').prop('name'), 'value' : issuerCompanyType.find('select').val()});
        }
        taxId.hide();
        timbrado.hide();
        authorizedPersonnel.hide();
        expiration_add_days.show();
        paying_bank.hide();
        stamp_expiration.hide();
        contract_number.hide();
        // authorizedPersonnelSignature.show();
    }
}

function updateDocumentDisplayName (el) {
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        headers: {
            'X-CSRF-Token': "{{ csrf_token() }}",
        },
        url: "{{ route('operations.ajax-update-document-display-name') }}",
        data: 'slug=' + el.data("document-slug") + '&display_name=' + el.val(),                    
        success: function (res) {
            if (res.success) {
                console.log(res.message);                        
            }
            else {
                alert('Error '+ res.status + ': ' + res.message);
            }
        },
    });
}

function updateSupportingAttachmentDisplayName (el) {
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        headers: {
            'X-CSRF-Token': "{{ csrf_token() }}",
        },
        url: "{{ route('operations.ajax-update-supporting-attachment-display-name') }}",
        data: 'slug=' + el.data("supporting-attachment-slug") + '&display_name=' + el.val(),                    
        success: function (res) {
            if (res.success) {
                console.log(res.message);                        
            }
            else {
                alert('Error '+ res.status + ': ' + res.message);
            }
        },
    });
}

function deleteDocument (el, callback) {
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        headers: {
            'X-CSRF-Token': "{{ csrf_token() }}",
        },
        url: "{{ route('operations.ajax-delete-document-file') }}",
        data: 'slug=' + el.data("document-slug"),                    
        success: function (res) {
            if (res.success) {
                console.log(res.message);
                callback();
            }
            else {
                alert('Error '+ res.status + ': ' + res.message);
            }
        },
    });
}

function deleteSupportingAttachment (el, callback) {
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        headers: {
            'X-CSRF-Token': "{{ csrf_token() }}",
        },
        url: "{{ route('operations.ajax-delete-supporting-attachment-file') }}",
        data: 'slug=' + el.data("supporting-attachment-slug"),                    
        success: function (res) {
            if (res.success) {
                console.log(res.message);
                callback();
            }
            else {
                alert('Error '+ res.status + ': ' + res.message);
            }
        },
    });
}

documentDropzone = new Dropzone("#document-dropzone", {
    // Dropzone.options.formCreateCase = {
    url: "{{ route('operations.update', $operation) }}",
    paramName: 'documents',
    autoProcessQueue: false,
    uploadMultiple: true,
    // addRemoveLinks: true,
    parallelUploads: 100,
    maxFiles: 100,

    previewsContainer: ".documents-previews-wrapper",
    previewTemplate: document.getElementById('document-preview').innerHTML,
    thumbnailWidth: null,
    thumbnailHeight: null,

    capture: 'camera',
    acceptedFiles: 'image/*,application/pdf',
    // accept: function(file, done) {
    // },

    // params: function (files, xhr) {
    //     return {
    //         filename: '',
    //     }
    // },
    // dictCancelUploadConfirmation: true,
    // dictRemoveFileConfirmation: "Are you sure you want to delete this file?",

    init: function () {
        documentDropzone = this;
        
        let crossOrigin = null; // Added to the `img` tag for crossOrigin handling
        let resizeThumbnail = false; // Tells Dropzone whether it should resize the image first
        <?php
            if($operation->documents->isNotEmpty()) {
                foreach($operation->documents as $document) {
                    ?>
                    var mockFile = { name: "{{ $document->name }}", size: "{{ $document->size * 1024 }}" };                            
                    documentDropzone.displayExistingFile(mockFile, "{{ $document->extension == 'pdf' ? asset('images/mipo/pdf.png') : route('secure-image', Crypt::encryptString($document->path)) }}", function () {
                        displayName = mockFile.previewElement.querySelector("input[name='document_name'");
                        $(displayName).val("{{ $document->display_name }}");
                        $(displayName).data("document-slug", "{{ $document->slug }}");
                        $(displayName).on('change', function (e) {
                            e.preventDefault();
                            debounce(updateDocumentDisplayName($(this)), 900);
                        });
                        deleteDocumentBtn = $(mockFile.previewElement).find('.dz-remove');                                    
                        deleteDocumentBtn.addClass('delete-document-btn');
                        deleteDocumentBtn.data("document-slug", "{{ $document->slug }}");                                    
                        $(deleteDocumentBtn).on('click', function (e) {
                            e.preventDefault();
                            if(confirm("Are you sure you want to delete this file?")) {
                                deleteDocument($(this), () => $(this).parents('.dz-image-preview').remove());
                            }
                        });
                    }, crossOrigin, resizeThumbnail);
                    <?php
                }
            }
        ?>

        this.on("sendingmultiple", function(data, xhr, formData) {

            // displayName = file.previewElement.querySelector("input[name='document_name'");
            // formData.append("documents[display_name]", $(displayName).val());

            // $("#form-update-operation").trigger('submit');

            // let x = $("#form-update-operation").serializeArray();
            // $.each(x, function(i, field) {
            //     formData.append(field.name, field.value);
            // });
        });
        this.on("addedfile", function (file) {
            removeBtn = file.previewElement.querySelector('.dz-remove');
            removeBtn.addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();
                documentDropzone.removeFile(file);
            });
        });
        this.on("addedfiles", function() {
            submitOperationForm($('#form-update-operation'), (res) => {toastr.success(res.message);});
        });
        this.on("success", function (file, res) {
            if (file.previewElement) {
                return file.previewElement.classList.add("dz-success");
            }
            console.log(res.message);
        });
        this.on("queuecomplete", function (file) {

        });
        this.on("error", function (file, res) {
            if(res.message !== undefined && res.message !== null)
                $(file.previewElement).find('.dz-error-message').text(res.message);
            // if(res.errors !== undefined)
            //     $(file.previewElement).find('.dz-error-message').text(res.errors.file);
        });
        this.on("uploadprogress", function (file, progress, bytesSent) {
            // if (file.previewElement) {
            //     for (let node of file.previewElement.querySelectorAll("[data-dz-uploadprogress]")) {
            //         node.style.width = progress + "%";
            //         node.querySelector(".progress-text").textContent = Math.round(progress) + "%";
            //     }
            // }
        });
        this.on("successmultiple", function (files, res) {
            console.log(res.message);
            // location.href = res.redirectTo;
        });
        this.on("errormultiple", function (files, res, xhr) {
            if (xhr.status === 422) {
                $.each(res.errors, function (key, value) {
                    let target = $('#form-update-operation [name="' + dotToArray(key) + '"]');
                    target.addClass('is-invalid');
                    let errorAlert = '<span class="invalid-feedback" role="alert">' + value + '</span>';
                    target.parent().append(errorAlert);
                });
            }
            alert('Error '+ res.code + ':'+ res.message);
        });
    },
    // };
});

supportingAttachmentDropzone = new Dropzone("#supporting-attachment-dropzone", {
    // Dropzone.options.formCreateCase = {
    url: "{{ route('operations.update', $operation) }}",
    paramName: 'supporting_attachments',
    autoProcessQueue: false,
    uploadMultiple: true,
    // addRemoveLinks: true,
    parallelUploads: 100,
    maxFiles: 100,

    previewsContainer: ".supporting-attachments-previews-wrapper",
    previewTemplate: document.getElementById('supporting-attachment-preview').innerHTML,
    thumbnailWidth: null,
    thumbnailHeight: null,

    capture: 'camera',
    acceptedFiles: 'image/*,application/pdf',
    // accept: function(file, done) {
    // },
    // dictCancelUploadConfirmation: true,
    // dictRemoveFileConfirmation: "Are you sure you want to delete this file?",

    init: function () {
        supportingAttachmentDropzone = this;

        let crossOrigin = null; // Added to the `img` tag for crossOrigin handling
        let resizeThumbnail = false; // Tells Dropzone whether it should resize the image first
        <?php
            if($operation->supportingAttachments->isNotEmpty()) {
                foreach($operation->supportingAttachments as $supportingAttachment) {
                    ?>
                    var mockFile = { name: "{{ $supportingAttachment->name }}", size: "{{ $supportingAttachment->size * 1024 }}" };                            
                    supportingAttachmentDropzone.displayExistingFile(mockFile, "{{ $supportingAttachment->extension == 'pdf' ? asset('images/mipo/pdf.png') : route('secure-image', Crypt::encryptString($supportingAttachment->path)) }}", function () {
                        displayName = mockFile.previewElement.querySelector("input[name='supporting_attachment_name'");
                        $(displayName).val("{{ $supportingAttachment->display_name }}");
                        $(displayName).data("supporting-attachment-slug", "{{ $supportingAttachment->slug }}");
                        $(displayName).on('change', function (e) {
                            e.preventDefault();
                            debounce(updateSupportingAttachmentDisplayName($(this)), 900);
                        });
                        deleteSupportingAttachmentBtn = $(mockFile.previewElement).find('.dz-remove');
                        deleteSupportingAttachmentBtn.addClass('delete-supporting-attachment-btn');
                        deleteSupportingAttachmentBtn.data("supporting-attachment-slug", "{{ $supportingAttachment->slug }}");
                        $(deleteSupportingAttachmentBtn).on('click', function (e) {
                            e.preventDefault();
                            if(confirm("Are you sure you want to delete this file?")) {
                                deleteSupportingAttachment($(this), () => $(this).parents('.dz-image-preview').remove());
                            }
                        });
                    }, crossOrigin, resizeThumbnail);
                    <?php
                }
            }
        ?>
        
        this.on("sendingmultiple", function(data, xhr, formData) {
            
        });
        this.on("addedfile", function (file) {
            removeBtn = file.previewElement.querySelector('.dz-remove');
            removeBtn.addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();
                supportingAttachmentDropzone.removeFile(file);
            });
        });
        this.on("addedfiles", function() {
            submitOperationForm($('#form-update-operation'), (res) => {toastr.success(res.message);});
        });
        this.on("success", function (file, res) {
            if (file.previewElement) {
                return file.previewElement.classList.add("dz-success");
            }
            console.log(res.message);
        });
        this.on("queuecomplete", function (file) {

        });
        this.on("error", function (file, res) {
            if(res.message !== undefined && res.message !== null)
                $(file.previewElement).find('.dz-error-message').text(res.message);
            // if(res.errors !== undefined)
            //     $(file.previewElement).find('.dz-error-message').text(res.errors.file);
        });
        this.on("uploadprogress", function (file, progress, bytesSent) {
            // if (file.previewElement) {
            //     for (let node of file.previewElement.querySelectorAll("[data-dz-uploadprogress]")) {
            //         node.style.width = progress + "%";
            //         node.querySelector(".progress-text").textContent = Math.round(progress) + "%";
            //     }
            // }
        });
        this.on("successmultiple", function (files, res) {
            console.log(res.message);
            location.href = res.redirectTo;
        });
        this.on("errormultiple", function (files, res, xhr) {
            if (xhr.status === 422) {
                $.each(res.errors, function (key, value) {
                    let target = $('#form-update-operation [name="' + dotToArray(key) + '"]');
                    target.addClass('is-invalid');
                    let errorAlert = '<span class="invalid-feedback" role="alert">' + value + '</span>';
                    target.parent().append(errorAlert);
                });
            }
            alert('Error '+ res.code + ':'+ res.message);
        });
    },
    // };
});
