<x-app-admin-layout>
    @section('pageTitle', 'Marketing Blog Add')
    @section('custom_style')
    <link href="{{ asset('plugins/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet">
    <style>
        .ck-editor__editable_inline {
            min-height: 350px;
        }
    </style>
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Create Blog') }}
        </x-header>
    </x-slot>

    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf

                                @foreach(config('constants.languages') as $shortCode => $language)
                                    @if($shortCode == 'es')
                                    <fieldset class="language-fieldset language-fieldset-{{ $shortCode }}">
                                        <legend>{{ $language }}</legend>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="title-{{ $shortCode }}">Title</label>
                                                    <input type="text" name="title[{{ $shortCode }}]" id="title-{{ $shortCode }}" class="form-control @error('title.' . $shortCode) is-invalid @enderror" placeholder="Blog Title" value="{{ old('title.' . $shortCode) }}" required autofocus>
                                                    @error('title.' . $shortCode)
                                                    <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="excerpt-{{ $shortCode }}">Excerpt</label>
                                                    <textarea name="excerpt[{{ $shortCode }}]" id="excerpt-{{ $shortCode }}" class="form-control @error('excerpt.' . $shortCode) is-invalid @enderror" rows="2" placeholder="Excerpt" required>{{ old('excerpt.' . $shortCode) }}</textarea>
                                                    @error('excerpt.' . $shortCode)
                                                    <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="body-{{ $shortCode }}">Body</label>
                                                    <textarea name="body[{{ $shortCode }}]" id="body-{{ $shortCode }}" class="form-control @error('body.' . $shortCode) is-invalid @enderror" rows="6" placeholder="Body">{!! old('body.' . $shortCode) !!}</textarea>
                                                    @error('body.' . $shortCode)
                                                    <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    @endif
                                    <hr>
                                @endforeach
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="news_link">{{ __('News Link')}}</label>
                                            <input type="text" name="news_link" id="news_link" class="form-control @error('news_link') is-invalid @enderror" placeholder="{{ __('News Link')}}" value="{{ old('news_link') }}">
                                            @error('news_link')
                                            <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-12">      
                                            <div class="form-group mb-3" style="display: none;" id="thumbnail-preview-block">
                                                <div style="height: 400px;">
                                                    <img src="" alt="Thumbnail" id="thumbnail-preview" class="mx-auto img-thumbnail" style="max-width: 100%; max-height: 100%;">
                                                </div>
                                            </div>                                      
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="thumbnail">{{ __('Thumbnail') }}</label>
                                                <input type="file" name="thumbnail" id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" placeholder="Blog Thumbnail" required accept="image/*">
                                                @error('thumbnail')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="user_names">{{ __('Select Users') }}</label>
                                            <select class="form-control select2" multiple id="user_names" name="user_ids[]">
                                                <option value="">{{ __('Select User')}}</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                            </fieldset>
                            </div>
                            <div class="card-footer">
                                <div class="row py-2">
                                    <div class="col-md-12">
                                        <x-submit-button class="mr-4">
                                            {{ __('Submit') }}
                                        </x-submit-button>
                                        <a href="{{ route('admin.blogs.index') }}">
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
    <script src="{{ asset('plugins/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/ckeditor5-build-classic/ckeditor.js') }}"></script>
    <script>

    $(document).ready(function () {
        $(".select2").select2({
            placeholder: "Select"
        });
    });

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

        $("input[name='thumbnail']").change(function(e) {
            let output = $('#thumbnail-preview');
            let outputBlock = $('#thumbnail-preview-block');
            output.attr('src', URL.createObjectURL(e.target.files[0]));
            outputBlock.slideDown();
            output.onload = () => {
                URL.revokeObjectURL(output.src);
            };
        });
    });
    </script>
    @endsection
</x-app-admin-layout>