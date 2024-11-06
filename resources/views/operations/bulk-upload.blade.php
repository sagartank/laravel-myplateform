<x-app-layout>
@section('custom_style')
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/basic.min.css') }}">
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">--}}
    <link href="{{ asset('plugins/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet">
    <style>
        
    </style>
@endsection

    <div class="operation_wrap">
        <div class="container">
            <div class="page_heading">
                <div class="title">
                    <h3>{{ __('Bulk Upload Operation') }}</h3>
                </div>
            </div>
            
            <form id="dropzone-form-bulk" action="{{ route('operations.bulk-upload') }}" method="POST" enctype="multipart/form-data">
                @csrf  
                <div class="container">
                    <div class="row">
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Uplaod oprations xls file</label>
                                <input type="file" name="operation_xls" id="operation_xls" class="form-control">
                            </div>
                            <div class="mb-3">
                                <input class="primary-btn" type="submit" id="operationBulkUpload" value="{{ __('Submit') }}">
                            </div>
                            <!-- <div id="dropzoneXls" class="dropzone"></div> -->
                        </div>
                        <!-- <div class="col-9">
                            <h6>{{ __('Upload a Documents') }}</h6>
                            <div id="scan-file-dropzone" class="dropzone"></div>
                        </div> -->
                    </div>
                </div>
            </form>
        </div>
    </div>

@section('custom_script')
    <script src="{{ asset('plugins/jquery-repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('plugins/dropzone/dropzone.min.js') }}"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script> -->
    {{-- <script src="{{ asset('plugins/bootstrap-tags/bootstrap-tags-input.min.js') }}"></script> --}}
    <script src="{{ asset('plugins/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>//Dropzone.autoDiscover = false;</script>
    <script>
        Dropzone.autoDiscover = false;   
        scanFileDropzone = new Dropzone("#scan-file-dropzone", {
        // Dropzone.options.formCreateCase = {
            url: "{{ route('operations.bulk-upload') }}",
            paramName: 'operation_documents',
            autoProcessQueue: false,
            uploadMultiple: true,
            // addRemoveLinks: true,
            parallelUploads: 100,
            maxFiles: 100,
            maxFilesize: 2048,
            //previewsContainer: ".scan-files-previews-wrapper",
            //previewTemplate: document.getElementById('scan-file-preview').innerHTML,
            // accept: function(file, done) {
            // },

            init: function () {
                scanFileDropzone = this;
                $("#dropzone-form").submit(function (e) {
                    e.preventDefault();
                    $('#dropzone-form :input').removeClass('is-invalid');
                    $('#dropzone-form .error-text').remove();
                    
                    e.stopPropagation();
                    if (scanFileDropzone.getQueuedFiles().length > 0) {
                        scanFileDropzone.processQueue();
                    }
                });
                this.on("sendingmultiple", function(data, xhr, formData) {
                    let form = $("#dropzone-form").serializeArray();
                    var operation_xls = $("#operation_xls").prop("files")[0];
                    //var data = new FormData(); // Creating object of FormData class
                    //formData.append("form", form);
                    formData.append("operation_xls", operation_xls);
                    $.each(form, function(i, field) {
                        formData.append(field.name, field.value);
                    });
                });
                this.on("addedfile", function (file) {
                    
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
                    
                });
                this.on("successmultiple", function (files, res) {
                    if (res.success) {
                        location.href = res.redirectTo;
                    }
                    else {
                        alert('Error ' + res.status + ':' + res.message);    
                    }
                });
                this.on("errormultiple", function (files, res, xhr) {
                    if (xhr.status === 422) {
                        $.each(res.errors, function (key, value) {
                            let target = $('#dropzone-form [name="' + dotToArray(key) + '"]');
                            target.addClass('is-invalid');
                            let errorAlert = '<span class="invalid-feedback error-text" role="alert"><strong>' + value + '</strong></span>';
                            target.parent().append(errorAlert);
                        });
                    }
                    alert('Error ' + res.code + ':' + res.message);
                });
            },
        // };
        });
    </script>
@endsection
</x-app-layout>
