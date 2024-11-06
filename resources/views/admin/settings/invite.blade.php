<x-app-admin-layout>
    @section('pageTitle', 'Invite User')
    @section('custom_style')
        <style>
            .ck-editor__editable_inline {
                min-height: 350px;
            }
        </style>
        <link href="{{ asset('plugins/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet">
    @endsection
    <x-slot name="header">
        <x-header>
            {{ __('Invite User') }}
            <x-slot name="right">

            </x-slot>
        </x-header>
    </x-slot>
    @include('components.message')
    <div class="py-2">
        <div class="container-fluid">
            @permission('setting-language')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <form action="{{ route('admin.settings.send-invite') }}" method="POST">
                                <div class="card-body">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="step_links">{{ __('Add Email To') }}</label>
                                                <select class="form-control select2" multiple id="email_tos"
                                                    name="email_tos[]">
                                                </select>
                                                @error('email_tos')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <label class="form-label" for="body-description-en">{{ __('Email Template') }}</label>
                                            <textarea name="email_template" id="body-description-en"
                                                class="form-control @error('email_template') is-invalid @enderror" rows="6" placeholder="Body">{!! old('email_template') !!}</textarea>
                                            @error('email_template')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row py-2">
                                        <div class="col-md-12">
                                            <x-submit-button class="mr-4">
                                                {{ __('Send') }}
                                            </x-submit-button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endpermission
        </div>
    </div>
    @section('custom_script')
        <script src="{{ asset('plugins/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('plugins/ckeditor5-build-classic/ckeditor.js') }}"></script>
        <script>
            $(function() {
                $("#email_tos").select2({
                    tags: true,
                    tokenSeparators: [',', ' ']
                });
                $("textarea[id^='body-']").each(function() {
                    let el = $(this).attr('id');
                    let key = ($(this).attr('id')).replace('body-', '');
                    window['contentEditor' + key] = ClassicEditor
                        .create(document.querySelector('#' + el), {
                            toolbar: {
                                items: [
                                    'heading', '|',
                                    'fontfamily', 'fontsize', '|',
                                    'alignment', '|',
                                    'fontColor', 'fontBackgroundColor', '|',
                                    'bold', 'italic', 'strikethrough', 'underline', 'subscript',
                                    'superscript', '|',
                                    'link', '|',
                                    'outdent', 'indent', '|',
                                    'bulletedList', 'numberedList', /*'todoList',*/ '|',
                                    'code', 'codeBlock', '|',
                                    'insertTable', '|',
                                    'blockQuote', '|',
                                    'undo', 'redo',
                                    // '|', 'uploadImage'
                                ],
                                shouldNotGroupWhenFull: true,
                            },
                        })
                        .catch(error => {
                            console.error(error);
                        });
                });
            });
        </script>
    @endsection
</x-app-admin-layout>
