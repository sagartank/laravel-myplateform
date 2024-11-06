<x-guest-layout>
    @section('custom_style')
    @endsection

        <div class="user-verification-page">
            <div class="page-logo">
                <a href="/"><img src="{{ asset('images/logo.svg') }}" alt="" /></a>
            </div>

            <div class="user-block-main">
                <div class="user-title">
                    <h5>{{ __('Fill your details') }}</h5>
                </div>
                @include('components.message')
                <div class="user-form-block">
                    <form action="{{ route('details.user') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                         <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_if_company" value="1" id="is_if_company">
                                    <label class="form-check-label" for="is_if_company">
                                        {{ __('is if company ?')}}
                                    </label>
                                    </div>
                            </div>
                         </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-row">
                                    <label class="form-label label_user" for="first_name">{{ __('What’s your firstname?') }}</label>
                                    <label class="form-label label_comp" for="first_name">{{ __('Company Name') }}</label>
                                    <input class="form-control @error('first_name') is-invalid @enderror" type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" autofocus required>
                                    @error('first_name')
                                        <x-error-alert :message="$message" />
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-row">
                                    <label class="form-label label_user" for="last_name">{{ __('What’s your lastname?') }}</label>
                                    <label class="form-label label_comp" for="last_name">{{ __('Last Name') }}</label>
                                    <input class="form-control @error('last_name') is-invalid @enderror" type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                    @error('last_name')
                                        <x-error-alert :message="$message" />
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-row">
                                    <label class="form-label label_user" for="birth_date">{{ __('What’s your date of birth?') }}</label>
                                    <label class="form-label label_comp" for="birth_date">{{ __('Birthdate') }}</label>
                                    <input class="form-control @error('birth_date') is-invalid @enderror" type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                                    @error('birth_date')
                                        <x-error-alert :message="$message" />
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-row">
                                    <label class="form-label label_user" for="gender">{{ __('What’s your gender') }}</label>
                                    <label class="form-label label_comp" for="gender">{{ __('Gender') }}</label>
                                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                        <option selected>{{ __('Select a gender') }}</option>
                                        <option value="Male" @if(old('gender') == 'Male') selected @endif>{{ __('Male') }}</option>
                                        <option value="Female" @if(old('gender') == 'Female') selected @endif>{{ __('Female') }}</option>
                                        <option value="Other" @if(old('gender') == 'Other') selected @endif>{{ __('Other') }}</option>
                                    </select>
                                    @error('gender')
                                        <x-error-alert :message="$message" />
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-row">
                                    <label class="form-label label_user" for="country_id">{{ __('What’s your country?') }}</label>
                                    <label class="form-label label_comp" for="country_id">{{ __('Resident  country') }}</label>
                                    <select class="form-select @error('country_id') is-invalid @enderror" id="country_id" name="country_id" required>
                                        <option selected disabled hidden>{{ __('Select a country') }}</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" @if(old('country', 167) == $country->id) selected @endif>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <x-error-alert :message="$message" />
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-row">
                                    <label class="form-label label_user" for="city">{{ __('Please enter your city name') }}</label>
                                    <label class="form-label label_comp" for="city">{{ __('City') }}</label>
                                    <input class="form-control @error('city') is-invalid @enderror" type="text" name="city" value="{{ old('city') }}" required>
                                    @error('city')
                                        <x-error-alert :message="$message" />
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-row">
                                    <label class="form-label" for="address">{{ __('Please enter your full address') }}</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" required>{{ old('address') }}</textarea>
                                    @error('address')
                                        <x-error-alert :message="$message" />
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-row">
                                    <label class="form-label label_user" for="state">{{ __('What’s your state?') }}</label>
                                    <label class="form-label label_comp" for="state">{{ __('State') }}</label>
                                    <input class="form-control @error('state') is-invalid @enderror" type="text" id="state" name="state" placeholder="" value="{{ old('state') }}" required>
                                    @error('state')
                                    <x-error-alert :message="$message" />
                                    @enderror
                                </div>
                            </div>                            
                            <div class="col-md-6">
                                <div class="input-row hide_show_postal_code">
                                    <label class="form-label" for="postal_code">{{ __('Postal Code') }}</label>
                                    <input class="form-control @error('postal_code') is-invalid @enderror" type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required>
                                    @error('postal_code')
                                        <x-error-alert :message="$message" />
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-row">
                                    <label class="form-label label_user" for="profile_image">{{ __('Upload a Profile Picture') }}</label>
                                    <label class="form-label label_comp" for="profile_image">{{ __('Company Logo') }}</label>
                                    <input class="form-control @error('profile_image') is-invalid @enderror" type="file" id="profile_image" name="profile_image" required accept="image/*">
                                    @error('profile_image')
                                        <x-error-alert :message="$message" />
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-row">
                                    <label class="form-label" for="ruc_tax_id">{{ __('RUC / TAX ID') }}</label>
                                    <input class="form-control @error('ruc_tax_id') is-invalid @enderror" type="text" id="ruc_tax_id" name="ruc_tax_id" value="{{ old('ruc_tax_id') }}" required>
                                    @error('ruc_tax_id')
                                        <x-error-alert :message="$message" />
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="btnbox">
                                    <input class="btn btn-secondary" type="submit" value="{{ __('Submit') }}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @section('custom_script')
    <script>
        let date = new Date();
        date.setFullYear(date.getFullYear()-18);
        document.getElementById("birth_date").max = date.toISOString().split("T")[0];

        $(document).ready(function(){
            $('.label_comp').hide();
            $('#is_if_company').click(function() {
                if($(this).is(":checked")){
                    $('.hide_show_postal_code').hide();
                    $('.label_user').hide();
                    $('.label_comp').show();
                    $('#postal_code').prop('required', false);
                } else {
                    $('.hide_show_postal_code').show();
                    $('#postal_code').prop('required', true);
                    $('.label_comp').hide();
                    $('.label_user').show();

                }
            });
        });
    </script>
    @endsection
</x-guest-layout>
