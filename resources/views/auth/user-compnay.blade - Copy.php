<x-guest-layout>
    @section('custom_style')
        <link href="{{ asset('plugins/intl-tel-input-17.0.19/build/css/intlTelInput.min.css') }}" rel="stylesheet" />
    @endsection

        <div class="user-verification-page user-verification-page-v2">
            <div class="page-logo">
                <a href="/"><img src="{{ asset('images/logo.svg') }}" alt="" /></a>
            </div>

            <div class="user-block-main">
                <div class="user-block-inners">
                    <div class="user-block-left_form">
                        <div class="user-title">
                            <h5>{{ __('Fill your details') }}</h5>
                        </div>
                        @include('components.message')
                        <div class="user-form-block">
                            <form action="{{route('user.store-company-account')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-row">
                                            <label class="form-label" for="first_name">Nombre de laq Empresa*</label>
                                            <input class="form-control" type="text" id="first_name" name="first_name" value="" autofocus required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-row">
                                            <label class="form-label" for="last_name">Nombre Comercial</label>
                                            <input class="form-control" type="text" id="last_name" name="last_name" value="" autofocus required>
                                            @error('last_name')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-row">
                                            <label class="form-label" for="birth_date">Fecha de nacimiento</label>
                                            <input class="form-control " type="date" id="birth_date" name="birth_date" value="" required>
                                            @error('birth_date')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="input-row">
                                            <label class="form-label" for="gender">{{ __('Género') }}</label>
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
                                    </div> --}}
                                    <div class="col-md-6">
                                        <div class="input-row">
                                            <label class="form-label label_user" for="city_id">{{ __('City') }}</label>
                                            <select class="form-select @error('city_id') is-invalid @enderror" id="city_id" name="city_id" required>
                                                <option selected disabled hidden>{{ __('Select a city') }}</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('city')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-row">
                                            <label class="form-label" for="ruc_tax_id">{{ __('RUC*') }}</label>
                                            <input class="form-control" name="ruc_tax_id" id="ruc_tax_id" type="text" required>
                                            @error('ruc_tax_id')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-row">
                                            <label class="form-label" for="ruc_code">{{ __('RUC Code') }}</label>
                                            <input class="form-control" type="text" name="ruc_code" id="ruc_code">
                                            @error('gender')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-row">
                                            <label class="form-label" for="cmp_logo">{{ __('Logo de la Empresa') }}</label>
                                            <input class="form-control @error('profile_image') is-invalid @enderror" type="file" id="cmp_logo" name="profile_image" required accept="image/*">
                                            @error('profile_image')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-row">
                                            <label class="form-label" for="email">{{ __('Correo electrónico*') }}</label>
                                            <input class="form-control" type="text"  name="email" id="email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-row">
                                            <label class="form-label" for="mobile_code">{{ __('Numero de telefono*') }}</label>
                                            <input id="mobile_code" class="form-control @error('phone_code') is-invalid @enderror" type="text" name="phone_code" value="{{ old('phone_code') }}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-row">
                                            <label class="form-label" for="password">{{ __('Contrasena*') }}</label>
                                            <input class="form-control" type="password" name="password" id="password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-row">
                                            <label class="form-label" for="password_confirmation">{{ __('Confirmar contrasena*') }}</label>
                                            <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-row">
                                            <div class="address_box_label">
                                                <label class="form-label" for="address">{{ __('Dirección Legal*') }}</label>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalmap">Agregar Ubicacion en Mape</a>
                                            </div>
                                            <textarea class="form-control @error('address')  @enderror" id="search_input" name="address" required>{{ old('address') }}</textarea>
                                            <input type="hidden" name="latitude" id="loc_lat" />
                                            <input type="hidden" name="longitude" id="loc_long" />
                                            @error('address')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-row">
                                            <label class="form-label" for="attach_company_documents">{{ __('Upload a Profile Picture') }}</label>
                                            <input class="form-control @error('attach_company_documents') is-invalid @enderror" type="file" id="attach_company_documents" name="attach_company_documents" required accept="image/*" multiple>
                                            @error('attach_company_documents')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input_row_content">
                                            <h5>Requlsitos:</h5>
                                            <ul>
                                                <li>Constitucion de Compania</li>
                                                <li>Ultima Asambiea</li>
                                                <li>Cedula Tributaria</li>
                                                <li>Ultimas 3 presentaciones de IVA</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-row">
                                            <div class="conform_box">
                                                <input type="checkbox" name="agree" id="conformation_form">
                                                <label for="conformation_form">Al continuar, aceptas nuestros acuerdos del usuario y Poltica de Privacidad</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="btnbox">
                                            <input class="btn btn-primary" type="submit" value="{{ __('Continue') }}">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="user-block-right-box">
                        <div class="user-block-right-inner">
                            <div class="user_block_right_top">
                                <h3>Descarga nuestra aplicación</h3>
                                <p>Desktop & Mobile Available</p>
                                <div class="icon_apps">
                                    <img src="{{asset('images/social-icon-user.png')}}" alt="">
                                </div>
                                <div class="webapp_btn">
                                    <a href="#">
                                        <img src="{{asset('images/webapp-icon.png')}}" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="mipo_viewer_bottom">
                                <img src="{{asset('images/mipo-viwer.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @section('custom_script')
    <script src="{{ asset('plugins/intl-tel-input-17.0.19/build/js/intlTelInput-jquery.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyAqiWrN_T9aTFEXd2j9kIVWLP47_FHOHgw"></script>
    <script>
        $(document).ready(function () {
            $("#mobile_code").intlTelInput({
                // initialCountry: "auto",
                // geoIpLookup: function(success, failure) {
                //     $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                //         var countryCode = (resp && resp.country) ? resp.country : "us";
                //         success(countryCode);
                //     });
                // },
                initialCountry: "py",
                separateDialCode: true,
                utilsScript: "{{ asset('plugins/intl-tel-input-17.0.19/build/js/utils.js') }}",
                hiddenInput: "phone_number",
            });
        });
        let date = new Date();
        date.setFullYear(date.getFullYear()-18);
        document.getElementById("birth_date").max = date.toISOString().split("T")[0];

        var searchInput = 'search_input';
        $(document).ready(function () {
            var autocomplete;
            autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
                types: ['geocode'],
            });
            
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var near_place = autocomplete.getPlace();
                document.getElementById('loc_lat').value = near_place.geometry.location.lat();
                document.getElementById('loc_long').value = near_place.geometry.location.lng();
                
                document.getElementById('latitude_view').innerHTML = near_place.geometry.location.lat();
                document.getElementById('longitude_view').innerHTML = near_place.geometry.location.lng();
            });
        });
    </script>
    @endsection
</x-guest-layout>

<div class="modal fade map_modal" id="modalmap" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <a href="javascript:void(0)" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="modal_form_row">
                        <div class="modal_form_col">
                            <div class="input-row">
                                <textarea name="" id="" placeholder="Address" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal_form_col">
                            <div class="map_block_modal">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d518.7819137225766!2d70.75287369779679!3d22.270827834576252!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3959cbc12fbcd859%3A0x4eed385ff432a220!2sThe%20Hideout%20Snooker%20Mania!5e1!3m2!1sen!2sin!4v1683719478794!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                        <div class="modal_form_col modal_form_submit">
                            <input type="submit" value="Submit" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

