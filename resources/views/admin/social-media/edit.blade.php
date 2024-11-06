<x-app-admin-layout>
    @section('pageTitle', 'Marketing Social Media Edit')
    @section('custom_style')
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Add Social Media') }}
        </x-header>
    </x-slot>

    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.social-media.update', $socialMedia->slug) }}" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="name">{{ __('Name') }}</label>
                                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name', $socialMedia->name) }}" required autofocus>
                                                @error('name')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="name">{{ __('Link') }}</label>
                                                <input type="text" name="link" id="link" class="form-control @error('link') is-invalid @enderror" placeholder="Link" value="{{ old('name', $socialMedia->link) }}"  required autofocus>
                                                @error('link')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                       {{--  <div class="col-md-12">      
                                            <div class="form-group mb-3" id="icon-image-preview-block">
                                                <div style="height: 50px;">
                                                    <img src="{{ asset('storage/'. $socialMedia->icon_image) }}" alt="Image" id="icon-image-preview" class="mx-auto img-thumbnail" style="max-width: 100%; max-height: 100%;">
                                                </div>
                                            </div>                                      
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="icon-image">Image</label>
                                                <input type="file" name="icon_image" id="icon-image" class="form-control @error('icon_image') is-invalid @enderror"  accept="image/*">
                                                @error('icon_image')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" id="is-active" type="checkbox" name="is_active" value="1" @if($socialMedia->is_active) checked @endif>
                                                    <label class="form-check-label" for="is-active">{{ __('Is Active ?') }}</label>
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
                                        <a href="{{ route('admin.social-media.index') }}">
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
            $("input[name='icon_image']").change(function(e) {
                let output = $('#icon-image-preview');
                output.attr('src', URL.createObjectURL(e.target.files[0]));
                output.onload = () => {
                    URL.revokeObjectURL(output.src);
                };
            });
        });
    </script>
    @endsection
</x-app-admin-layout>
