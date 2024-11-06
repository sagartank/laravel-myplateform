<x-app-admin-layout>
    @section('pageTitle', 'Marketing Home Slides Edit')
    @section('custom_style')
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Edit Home Slide') }}
        </x-header>
    </x-slot>

    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.home-slides.update', $homeSlide) }}" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                @foreach(config('constants.languages') as $shortCode => $language)
                                    <fieldset class="language-fieldset language-fieldset-{{ $shortCode }}">
                                        <legend>{{ $language }}</legend>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="title-{{ $shortCode }}">Title</label>
                                                    <input type="text" name="title[{{ $shortCode }}]" id="title-{{ $shortCode }}" class="form-control @error('title.' . $shortCode) is-invalid @enderror" placeholder="Title" value="{{ old('title.' . $shortCode, $homeSlide->getTranslation('title', $shortCode)) }}" required autofocus>
                                                    @error('title.' . $shortCode)
                                                    <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="text-{{ $shortCode }}">Text</label>
                                                    <textarea name="text[{{ $shortCode }}]" id="text-{{ $shortCode }}" class="form-control @error('text.' . $shortCode) is-invalid @enderror" rows="2" placeholder="Text" required>{{ old('text.' . $shortCode, $homeSlide->getTranslation('text', $shortCode)) }}</textarea>
                                                    @error('text.' . $shortCode)
                                                    <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <hr>
                                @endforeach
                                  
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-12">      
                                            <div class="form-group mb-3" id="svg-image-preview-block">
                                                <div style="height: 200px;">
                                                    <img src="{{ $homeSlide->gif_image_url }}" alt="Image" id="svg-image-preview" class="mx-auto img-thumbnail" style="max-width: 100%; max-height: 100%;">
                                                </div>
                                            </div>                                      
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="svg-image">SVG Image</label>
                                                <input type="file" name="svg_image" id="svg-image" class="form-control @error('svg_image') is-invalid @enderror" accept="image/*">
                                                @error('svg_image')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" id="is-active" type="checkbox" name="is_active" value="1" @if($homeSlide->is_active) checked @endif>
                                                    <label class="form-check-label" for="is-active">Is Active ?</label>
                                                </div>
                                            </div>
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
                                        <a href="{{ route('admin.home-slides.index') }}">
                                            <button type="button" class="btn waves-effect waves-light btn-outline-dark rounded-md">Cancel</button>
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
    <script>
        $(document).ready(function() {
            $("input[name='svg_image']").change(function(e) {
                let output = $('#svg-image-preview');
                output.attr('src', URL.createObjectURL(e.target.files[0]));
                output.onload = () => {
                    URL.revokeObjectURL(output.src);
                };
            });
        });
    </script>
    @endsection
</x-app-admin-layout>
