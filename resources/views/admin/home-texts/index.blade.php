<x-app-admin-layout>
    @section('pageTitle', 'Marketing Home Texts Edit')
    @section('custom_style')
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Edit Home Texts') }}
        </x-header>
    </x-slot>

    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.home-texts.update', $homeText) }}" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                @foreach(config('constants.languages') as $shortCode => $language)
                                    <fieldset class="language-fieldset language-fieldset-{{ $shortCode }}">
                                        <legend>{{ $language }}</legend>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="heading-text-{{ $shortCode }}">Heading Text</label>
                                                    <input type="text" name="heading_text[{{ $shortCode }}]" id="heading-text-{{ $shortCode }}" class="form-control @error('heading_text.' . $shortCode) is-invalid @enderror" placeholder="Heading Text" value="{{ old('heading_text.' . $shortCode, $homeText->getTranslation('heading_text', $shortCode)) }}" required autofocus>
                                                    @error('heading_text.' . $shortCode)
                                                    <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="sub-heading-text-{{ $shortCode }}">Sub Heading Text</label>
                                                    <textarea name="sub_heading_text[{{ $shortCode }}]" id="sub-heading-text-{{ $shortCode }}" class="form-control @error('sub_heading_text.' . $shortCode) is-invalid @enderror" rows="2" placeholder="Sub Heading Text" required>{{ old('sub_heading_text.' . $shortCode, $homeText->getTranslation('sub_heading_text', $shortCode)) }}</textarea>
                                                    @error('sub_heading_text.' . $shortCode)
                                                    <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="footer-text-{{ $shortCode }}">Footer Text</label>
                                                    <textarea name="footer_text[{{ $shortCode }}]" id="footer-text-{{ $shortCode }}" class="form-control @error('footer_text.' . $shortCode) is-invalid @enderror" rows="2" placeholder="Footer Text" required>{{ old('footer_text.' . $shortCode, $homeText->getTranslation('footer_text', $shortCode)) }}</textarea>
                                                    @error('footer_text.' . $shortCode)
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
                                            <div class="form-group mb-3">
                                                <label for="contact-email">Contact Email</label>
                                                <input type="email" name="contact_email" id="contact-email" class="form-control @error('contact_email') is-invalid @enderror" placeholder="Contact Email" value="{{ old('contact_email', $homeText->contact_email) }}" required>
                                                @error('contact_email')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="contact-phone">Contact Phone</label>
                                                <input type="text" name="contact_phone" id="contact-phone" class="form-control @error('contact_phone') is-invalid @enderror" placeholder="Contact Phone" value="{{ old('contact_phone', $homeText->contact_phone) }}" required>
                                                @error('contact_phone')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="address-line-1">Address Line 1</label>
                                                <input type="text" name="address_line_1" id="address-line-1" class="form-control @error('address_line_1') is-invalid @enderror" placeholder="Address Line 1" value="{{ old('address_line_1', $homeText->address_line_1) }}" required>
                                                @error('address_line_1')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="address-line-2">Address Line 2</label>
                                                <input type="text" name="address_line_2" id="address-line-2" class="form-control @error('address_line_2') is-invalid @enderror" placeholder="Address Line 2" value="{{ old('address_line_2', $homeText->address_line_2) }}" required>
                                                @error('address_line_2')
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
    @endsection
</x-app-admin-layout>
