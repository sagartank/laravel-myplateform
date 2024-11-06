<x-app-admin-layout>
    @section('pageTitle', 'Page Add')
@section('custom_style')
<style>
    .ck-editor__editable_inline {
        min-height: 350px;
    }
</style>
@endsection

    <x-slot name="header">
        <x-header>
            {{ __('Page') }}
            <x-slot name="right">
                <a href="{{ route('admin.pages.index') }}">
                    <button type="button" class="btn btn-sm btn-dark">{{ __('Back')}}</button>
                </a>
            </x-slot>
        </x-header>
    </x-slot>

    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.pages.store') }}" method="POST">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="name">{{ __('Name') }}</label>
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"  placeholder="Name" value="{{ old('name') }}" required autofocus>
                                            @error('name')
                                            <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="body-description">{{ __('Description') }}</label>
                                        <textarea name="description" id="body-description" class="form-control @error('description') is-invalid @enderror" rows="6" placeholder="Body">{!! old('description') !!}</textarea>
                                        @error('description')
                                        <x-error-alert :message="$message" />
                                        @enderror
                                    </div>
                            </div>
                            </div>
                            <div class="card-footer">
                                <div class="row py-2">
                                    <div class="col-md-12">
                                        <x-submit-button class="mr-4">
                                            {{ __('Submit') }}
                                        </x-submit-button>
                                        <a href="{{ route('admin.pages.index') }}">
                                            <button type="button" class="btn waves-effect waves-light btn-outline-dark rounded-md">{{ __('Cancel') }}</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('custom_script')
    <script src="{{ asset('plugins/ckeditor5-build-classic/ckeditor.js') }}"></script>
    <script>
    $(function() {
        $("textarea[id^='body-']").each(function () {
            let el = $(this).attr('id');
            let key = ($(this).attr('id')).replace('body-', '');
            window['contentEditor'+key] = ClassicEditor
                .create(document.querySelector('#' + el), {
                    toolbar: {
                        items: [
                            'heading', '|',
                            'fontfamily', 'fontsize', '|',
                            'alignment', '|',
                            'fontColor', 'fontBackgroundColor', '|',
                            'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
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
