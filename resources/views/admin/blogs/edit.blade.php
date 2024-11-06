<x-app-admin-layout>
    @section('pageTitle', 'Marketing Blog Edit')
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
            {{ __('Edit Blog') }}
        </x-header>
    </x-slot>

    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                @foreach(config('constants.languages') as $shortCode => $language)
                                    @if($shortCode == 'es')
                                        <fieldset class="language-fieldset language-fieldset-{{ $shortCode }}">
                                            <legend>{{ $language }}</legend>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="title-{{ $shortCode }}">Title</label>
                                                        <input type="text" name="title[{{ $shortCode }}]" id="title-{{ $shortCode }}" class="form-control @error('title.' . $shortCode) is-invalid @enderror" placeholder="Blog Title" value="{{ old('title.' . $shortCode, $blog->getTranslation('title', $shortCode)) }}" required autofocus>
                                                        @error('title.' . $shortCode)
                                                        <x-error-alert :message="$message" />
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="excerpt-{{ $shortCode }}">Excerpt</label>
                                                        <textarea name="excerpt[{{ $shortCode }}]" id="excerpt-{{ $shortCode }}" class="form-control @error('excerpt.' . $shortCode) is-invalid @enderror" rows="2" placeholder="Excerpt" required>{{ old('excerpt.' . $shortCode, $blog->getTranslation('excerpt', $shortCode)) }}</textarea>
                                                        @error('excerpt.' . $shortCode)
                                                        <x-error-alert :message="$message" />
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="body-{{ $shortCode }}">Body</label>
                                                        <textarea name="body[{{ $shortCode }}]" id="body-{{ $shortCode }}" class="form-control @error('body.' . $shortCode) is-invalid @enderror" rows="6" placeholder="Body">{!! old('body.' . $shortCode, $blog->getTranslation('body', $shortCode)) !!}</textarea>
                                                        @error('body.' . $shortCode)
                                                        <x-error-alert :message="$message" />
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    @endif
                                @endforeach
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="news_link">{{ __('News Link')}}</label>
                                            <input type="text" name="news_link" id="news_link" class="form-control @error('news_link') is-invalid @enderror" placeholder="{{ __('News Link')}}" value="{{ old('news_link', $blog->news_link) }}">
                                            @error('news_link')
                                            <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <div style="height: 400px;">
                                                    <img src="{{ $blog->blog_image_url }}" alt="Thumbnail" id="thumbnail-preview" class="mx-auto img-thumbnail" style="max-width: 100%; max-height: 100%;">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="thumbnail">{{ __('Thumbnail') }}</label>
                                                <input type="file" name="thumbnail" id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" placeholder="Blog Thumbnail" accept="image/*">
                                                @error('thumbnail')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" id="is-active" type="checkbox" name="is_active" value="1" @if($blog->is_active) checked @endif>
                                                    <label class="form-check-label" for="is-active">{{ __('Is Active ?') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                @php
                                        $user_ids = [];
                                    if($blog->blog_users){
                                        $user_ids = $blog->blog_users->pluck('user_id')->toArray();
                                    }
                                @endphp
                                <fieldset>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="user_names">{{ __('Select Users') }}</label>
                                            <select class="form-control select2" multiple id="user_names" name="user_ids[]">
                                                <option value="">{{ __('Select User')}}</option>
                                                    @foreach ($users as $user)
                                                        <option @if(in_array($user->id, $user_ids)) selected @endif @endphp value="{{ $user->id }}">{{ $user->name }}</option>
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
    <script src="{{ asset('plugins/ckeditor5-build-classic/ckeditor.js') }}"></script>
    <script src="{{ asset('plugins/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
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
                            'undo', 'redo'
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
            output.attr('src', URL.createObjectURL(e.target.files[0]));
            output.onload = () => {
                URL.revokeObjectURL(output.src);
            };
        });
    });
    </script>
    @endsection
</x-app-admin-layout>
