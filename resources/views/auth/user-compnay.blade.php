<x-guest-layout>
    @section('pageTitle', 'User Company Registration') 
    @section('custom_style')
        <link href="{{ asset('plugins/intl-tel-input-17.0.19/build/css/intlTelInput.min.css') }}" rel="stylesheet" />
        <style>
            .pac-container{
                z-index:9999;
            }
            #map {
                height: 100%;
                width: 100%;
                margin: 0px;
                padding: 0px
            }
            </style>
    @endsection

        <div class="user-verification-page user-verification-page-v2">
            <div class="page-logo">
                <a href="/"><img src="{{ asset('images/logo.svg') }}" alt="mipo" /></a>
            </div>

            <div class="user-block-main">
                <div class="user-block-inners">
                    <div class="user-block-left_form">
                        <div class="user-title">
                            <h5>{{ __('Business Registration Form') }}</h5>
                        </div>
                        @include('components.message')
                        <div class="user-form-block">
                            <form action="{{route('user.store-company-account')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-row">
                                            <label class="form-label" for="first_name">{{ __('Company Name') }}:*</label>
                                            <input class="form-control" type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" autofocus required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-row">
                                            <label class="form-label" for="last_name">{{ __('Commercial Business Name') }}:</label>
                                            <input class="form-control" type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" autofocus required>
                                            @error('last_name')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-row">
                                            <label class="form-label" for="birth_date">{{ __('Date of Constitution') }}</label>
                                            <input class="form-control" type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
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
                                            <select class="form-select @error('city_id') is-invalid @enderror selectbox" id="city_id" name="city_id" required>
                                                <option value="">{{ __('Select a city') }}</option>
                                                @foreach($cities as $city)
                                                <option value="{{ $city->id }}" {{ (139 == $city->id) ? "selected" : ''}} >{{ $city->name }}</option>
                                                    {{-- <option value="{{ $city->id }}"  {{ (old('city_id') == $city->id) ? "selected" : ''}}>{{ $city->name }}</option> --}}
                                                @endforeach
                                            </select>
                                            @error('city')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-row">
                                            <label class="form-label" for="ruc_tax_id">{{ __('RUC') }}*</label>
                                            <input class="form-control" name="ruc_tax_id" id="ruc_tax_id" type="text" value="{{ old('ruc_tax_id') }}" required>
                                            @error('ruc_tax_id')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-row">
                                            <label class="form-label" for="ruc_code">{{ __('D.V.') }}</label>
                                            <input class="form-control" type="text" name="ruc_code" id="ruc_code" value="{{ old('ruc_code') }}">
                                            @error('gender')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-row">
                                            <label class="form-label" for="cmp_logo">{{ __('Company Logo') }}*</label>
                                            <span class="input-browse"><span>{{ __('Upload File') }}</span><input class="form-control @error('profile_image') is-invalid @enderror com_logo"  type="file" id="cmp_logo" name="profile_image" required accept="image/*"></span>
                                            @error('profile_image')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-row">
                                            <label class="form-label" for="email">{{ __('Email') }}*</label>
                                            <input class="form-control" type="text"  name="email" id="email" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-row">
                                            <label class="form-label" for="mobile_code">{{ __('Phone Number') }}*</label>
                                            <input id="mobile_code" class="form-control @error('phone_code') is-invalid @enderror" type="text" name="phone_code" value="{{ old('phone_code') }}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-row">
                                            <label class="form-label" for="password">{{ __('Password') }}*</label>
                                            <input class="form-control" type="password" name="password" id="password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-row">
                                            <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}*</label>
                                            <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-row">
                                            <div class="address_box_label">
                                                <label class="form-label" for="address">{{ __('Legal Address') }}*</label>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalmap">{{ __('Add Location on Maps') }}</a>
                                            </div>
                                            <textarea class="form-control @error('address') is-invalid @enderror" id="search_input" name="address" required placeholder="Type address...">{{ old('address') }}</textarea>
                                            <input type="hidden" name="latitude" id="loc_lat" />
                                            <input type="hidden" name="longitude" id="loc_long" />
                                            <input type="hidden" name="address_google_map" id="address_google_map" />
                                            @error('address')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-row">
                                            <label class="form-label" for="attach_company_documents">{{ __('Attach Business Documents') }}*</label>
                                            <span class="input-browse">{{ __('Upload File') }}<input class="form-control @error('attach_company_documents') is-invalid @enderror com_logo" type="file" id="attach_company_documents" name="attach_company_documents[]" multiple required accept="image/*" multiple></span>
                                            @error('attach_company_documents')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input_row_content">
                                            <h5>{{ __('Please Attach') }}:</h5>
                                            <ul>
                                                <li>{!! __('Business Constitution') !!}</li>
                                                <li>{!! __('Last Assembly') !!}</li>
                                                <li>{!! __('TAX ID') !!}</li>
                                                <li>{!! __('Last 3 Tax Reports') !!}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-row">
                                            <div class="conform_box">
                                                <input type="checkbox" name="agree" id="conformation_form" required>
                                                {{-- <label for="conformation_form_">
                                                    <a href="{{ route('privacy-policy') }}">{{ __('When checking, you agree to our Terms and Conditions and our Privacy Policies') }}</a>
                                                </label> --}}
                                                <span class="in_check text-14-medium"> {!! __('When checking, you agree to our') !!}
                                                    <a href="{{ route('privacy-policy') }}" class="text-14-medium">{!! __('Terms and Conditions') !!}</a> {!! __('and our') !!}
                                                    <a href="{{ route('privacy-policy') }}" class="text-14-medium">{!! __('Privacy Policies.') !!}</a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="btnbox_sec">
                                            <div class="section">
                                                <input class="btn-primary" type="submit" value="{{ __('Continue') }}">
                                                <i><img src="{{asset('images/mipo/user-verifyleft.svg')}}" alt="mipo"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="user-block-right-box">
                        <div class="user-block-right-inner">
                            <div class="user_block_right_top">
                                <h3>{{ __('Download our App') }}</h3>
                                <p>{{ __('Desktop and Mobile Available') }}</p>
                                <div class="icon_apps">
                                    <ul>
                                        <li><a href="javascript:;"><img src="{{ asset('images/marketing/Microsoft.svg') }}" alt="microsoft"></a></li>
                                        <li><a href="javascript:;"><img src="{{ asset('images/marketing/Apple.svg') }}" alt="apple"></a></li>
                                        <li><a href="javascript:;"><img src="{{ asset('images/marketing/chrome.svg') }}" alt="chrome"></a></li>
                                        <li><a href="javascript:;"><img src="{{ asset('images/marketing/android.svg') }}" alt="android"></a></li>
                                        <li><a href="javascript:;"><img src="{{ asset('images/marketing/firefox.svg') }}" alt="firefox"></a></li>
                                        <li><a href="javascript:;"><img src="{{ asset('images/marketing/safari.svg') }}" alt="safari"></a></li>
                                    </ul>
                                </div>
                                <div class="webapp_btn">
                                    <a href="javascript:;" id="company_triger">
                                        <img src="{{asset('images/webapp-icon.png')}}" alt="mipo">
                                    </a>
                                </div>
                            </div>
                            <div class="mipo_viewer_bottom">
                                <img src="{{asset('images/mipo-viwer.png')}}" alt="mipo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="map_popup_section">
            <div class="modal fade map_modal" id="modalmap" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form id="gmModalForm">
                                <div class="modal_form_row">
                                    <div class="modal_form_col">
                                        <div class="input-row">
                                            <input id="address-modal-input" name="address_address" class="form-control" style="z-index:9999;"/>
                                         {{--    <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
                                            <input type="hidden" name="address_longitude" id="address-longitude" value="0" /> --}}
                                        </div>
                                    </div>
                                    <div class="modal_form_col">
                                        <div class="map_block_modal">
                                            <div id="address-map-container" style="width:100%;height:400px; ">
                                                <div id="map" style="height:100%;z-index:9995;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal_form_col modal_form_submit">
                                        <input type="button" id="mapModelBtn" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @section('custom_script')
    <script src="{{ asset('plugins/intl-tel-input-17.0.19/build/js/intlTelInput-jquery.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=geometry,places&key={{ env('GOOGLE_MAP_KEY') }}"></script>
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
        date.setFullYear(date.getFullYear());
        document.getElementById("birth_date").max = date.toISOString().split("T")[0];
    </script>
     <script>
        // var searchInput = 'search_input';
        var searchInput = 'address-modal-input';
        function initForm() {
            $('form#gmModalForm').on('keyup keypress', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });
            var autocomplete;
            autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
                types: ['geocode'],
            });
            
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var near_place = autocomplete.getPlace();
                document.getElementById('loc_lat').value = near_place.geometry.location.lat();
                document.getElementById('loc_long').value = near_place.geometry.location.lng();

                var addressSearchVal = document.getElementById('address-modal-input').value;
                document.getElementById('address_google_map').value = addressSearchVal;
            });
        }
        
        google.maps.event.addDomListener(window, 'load', initForm);
        // navigator.geolocation.getCurrentPosition(
        //     function (position) {
        //         console.log(position.coords.latitude);
        //         defaultLatLong = {
        //             lat: position.coords.latitude,
        //             lng: position.coords.longitude
        //         };
        //     },
        //     function errorCallback(error) {
        //         console.log(error)
        //     }
        // );
        defaultLatLong = {
            lat: -25.2968298,
            lng: -57.680491
        };

        var map = new google.maps.Map(document.getElementById('map'), {
            center: defaultLatLong,
            zoom: 13,
            mapTypeId: 'roadmap'
        });

        var input = document.getElementById('address-modal-input');

        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo('bounds', map);
        //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        var marker = new google.maps.Marker({
            map: map,
            position: defaultLatLong,
            draggable: true,
            clickable: true
        });

        google.maps.event.addListener(marker, 'dragend', function(marker) {
            var latLng = marker.latLng;
            currentLatitude = latLng.lat();
            currentLongitude = latLng.lng();
            var latlng = {
                lat: currentLatitude,
                lng: currentLongitude
            };
            console.log('marker', marker);
            var addressSearchVal = document.getElementById('address-modal-input').value;
                document.getElementById('address_google_map').value = addressSearchVal;
                document.getElementById('loc_lat').value = currentLatitude;
                document.getElementById('loc_long').value = currentLongitude;

            var geocoder = new google.maps.Geocoder;
            geocoder.geocode({
                'location': latlng
            }, function(results, status) {
                if (status === 'OK') {
                if (results[0]) {
                    input.value = results[0].formatted_address;
                } else {
                    window.alert('No results found');
                }
                } else {
                window.alert('Geocoder failed due to: ' + status);
                }
            });
            });

            autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
            }

            marker.setPosition(place.geometry.location);

            currentLatitude = place.geometry.location.lat();
            currentLongitude = place.geometry.location.lng();
        
            document.getElementById('loc_lat').value = currentLatitude;
            document.getElementById('loc_long').value = currentLongitude;
            document.getElementById('address_google_map').value = document.getElementById('address-modal-input').value;

        });
        $(document).on('click','#mapModelBtn',function(){
            document.getElementById('address_google_map').value = document.getElementById('address-modal-input').value;
            $('#modalmap').modal('hide');
        });
    </script>
    @endsection
</x-guest-layout>