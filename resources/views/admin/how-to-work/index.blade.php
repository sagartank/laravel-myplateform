<x-app-admin-layout>
    @section('pageTitle', 'Marketing How To Work Edit')
    @section('custom_style')
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Edit How To Work') }}
        </x-header>
    </x-slot>

    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.how-to-work.update', $howToWork) }}" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                @foreach(config('constants.languages') as $shortCode => $language)
                                    <fieldset class="language-fieldset language-fieldset-{{ $shortCode }}">
                                        <legend>{{ $language }}</legend>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="heading-text-b-{{ $shortCode }}">{{ __('Heading Text Buyer') }}</label>
                                                    <input type="text" name="heading_text_buyer[{{ $shortCode }}]" id="heading-text-b-{{ $shortCode }}" class="form-control @error('heading_text_buyer.' . $shortCode) is-invalid @enderror" placeholder="Heading Text" value="{{ old('heading_text_buyer.' . $shortCode, $howToWork->getTranslation('heading_text_buyer', $shortCode)) }}" required autofocus>
                                                    @error('heading_text_buyer.' . $shortCode)
                                                    <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="sub-heading-text-b-{{ $shortCode }}">{{ __('Sub Heading Text Buyer') }}</label>
                                                    <textarea name="sub_heading_text_buyer[{{ $shortCode }}]" id="sub-heading-text-b-{{ $shortCode }}" class="form-control @error('sub_heading_text_buyer.' . $shortCode) is-invalid @enderror" rows="2" placeholder="Sub Heading Text" required>{{ old('sub_heading_text_buyer.' . $shortCode, $howToWork->getTranslation('sub_heading_text_buyer', $shortCode)) }}</textarea>
                                                    @error('sub_heading_text_buyer.' . $shortCode)
                                                    <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="button-text-b-{{ $shortCode }}">{{ __('Button Text Buyer') }}</label>
                                                    <input type="text" name="button_text_buyer[{{ $shortCode }}]" id="button-text-b-{{ $shortCode }}" class="form-control @error('button_text_buyer.' . $shortCode) is-invalid @enderror" placeholder="Heading Text" value="{{ old('button_text_buyer.' . $shortCode, $howToWork->getTranslation('button_text_buyer', $shortCode)) }}" required autofocus>
                                                    @error('button_text_buyer.' . $shortCode)
                                                    <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="heading-text-{{ $shortCode }}">{{ __('Heading Text Seller') }}</label>
                                                    <input type="text" name="heading_text_seller[{{ $shortCode }}]" id="heading-text-{{ $shortCode }}" class="form-control @error('heading_text_seller.' . $shortCode) is-invalid @enderror" placeholder="Heading Text" value="{{ old('heading_text_seller.' . $shortCode, $howToWork->getTranslation('heading_text_seller', $shortCode)) }}" required autofocus>
                                                    @error('heading_text_seller.' . $shortCode)
                                                    <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="sub-heading-text-{{ $shortCode }}">{{ __('Sub Heading Text Seller') }}</label>
                                                    <textarea name="sub_heading_text_seller[{{ $shortCode }}]" id="sub-heading-text-{{ $shortCode }}" class="form-control @error('sub_heading_text_seller.' . $shortCode) is-invalid @enderror" rows="2" placeholder="Sub Heading Text" required>{{ old('sub_heading_text_seller.' . $shortCode, $howToWork->getTranslation('sub_heading_text_seller', $shortCode)) }}</textarea>
                                                    @error('sub_heading_text_seller.' . $shortCode)
                                                    <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="button-text-{{ $shortCode }}">{{ __('Button Text Seller') }}</label>
                                                    <input type="text" name="button_text_seller[{{ $shortCode }}]" id="button-text-{{ $shortCode }}" class="form-control @error('button_text_seller.' . $shortCode) is-invalid @enderror" placeholder="Heading Text" value="{{ old('button_text_seller.' . $shortCode, $howToWork->getTranslation('button_text_seller', $shortCode)) }}" required autofocus>
                                                    @error('button_text_seller.' . $shortCode)
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
                                            <div class="form-group mb-3"  id="seller-image-preview-block">
                                                <div style="height: 200px;">
                                                    <img src="{{ $howToWork->seller_image_url }}" alt="Image" id="seller-image-preview" class="mx-auto img-thumbnail" style="max-width: 100%; max-height: 100%;">
                                                </div>
                                            </div>                                      
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="svg-image">{{ __('Seller Image') }}</label>
                                                <input type="file" name="seller_image" id="seller-image" class="form-control @error('seller_image') is-invalid @enderror"  accept="image/*">
                                                @error('seller_image')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="seller-link">{{ __('Seller Link') }}</label>
                                                <input type="text" name="seller_link" id="seller-link"  value="{{ $howToWork->seller_link }}" class="form-control @error('seller_link') is-invalid @enderror">
                                                @error('seller_link')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">      
                                            <div class="form-group mb-3"  id="buyer-image-preview-block">
                                                <div style="height: 200px;">
                                                    <img src="{{ $howToWork->buyer_image_url }}" alt="Image" id="buyer-image-preview" class="mx-auto img-thumbnail" style="max-width: 100%; max-height: 100%;">
                                                </div>
                                            </div>                                      
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="buyer-image">{{ __('Buyer Image') }}</label>
                                                <input type="file"  name="buyer_image" id="buyer-image" class="form-control @error('buyer_image') is-invalid @enderror"  accept="image/*">
                                                @error('buyer_image')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label" for="buyer-link">{{ __('Buyer Link') }}</label>
                                                <input type="text" name="buyer_link" id="buyer-link" value="{{ $howToWork->buyer_link }}" class="form-control @error('buyer_link') is-invalid @enderror">
                                                @error('buyer_link')
                                                <x-error-alert :message="$message" />
                                                @enderror
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
            $("input[name='seller_image']").change(function(e) {
                let output = $('#seller-image-preview');
                let outputBlock = $('#seller-image-preview-block');
                output.attr('src', URL.createObjectURL(e.target.files[0]));
                outputBlock.slideDown();
                output.onload = () => {
                    URL.revokeObjectURL(output.src);
                };
            });

            $("input[name='buyer_image']").change(function(e) {
                let output = $('#buyer-image-preview');
                let outputBlock = $('#buyer-image-preview-block');
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
