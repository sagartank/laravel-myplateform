<x-guest-layout>
    @section('custom_style')
    <style>
    .pac-container{
        z-index:9999;
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
                            <h5>{{ __('Fill your details') }}</h5>
                        </div>
                        @include('components.message')
                        <div class="user-form-block">
                            <form action="{{ route('details.user') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-row">
                                            <label class="form-label" for="first_name">{{ __('First Name') }}*</label>
                                            <input class="form-control @error('first_name') is-invalid @enderror" type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" autofocus required>
                                            @error('first_name')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-row">
                                            <label class="form-label" for="first_name">{{ __('Last Name') }}*</label>
                                            <input class="form-control @error('last_name') is-invalid @enderror" type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" autofocus required>
                                            @error('last_name')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-row">
                                            <label class="form-label" for="birth_date">{{ __('Birthdate') }}</label>
                                            <input class="form-control @error('birth_date') is-invalid @enderror" type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                                            @error('birth_date')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-row">
                                            <label class="form-label" for="marital_status">{{ __('Marital status') }}</label>
                                            <select class="form-select @error('marital_status') is-invalid @enderror" id="marital_status" name="marital_status">
                                                <option selected>{{ __('Select a marital status') }}</option>
                                                @foreach (config('constants.MARITAL_STATUS') as $marital_status_val)
                                                <option  value="{{ $marital_status_val }}"> {{ $marital_status_val }}</option>
                                                @endforeach
                                            </select>
                                            @error('gender')
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
                                    <div class="col-md-4">
                                        <div class="input-row">
                                            <label class="form-label" for="gender">{{ __('RUC*') }}</label>
                                            <input class="form-control" type="text" name="ruc_tax_id" id="ruc_tax_id" required>
                                            @error('gender')
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
                                    <div class="col-md-12">
                                        <div class="input-row">
                                            <div class="address_box_label">
                                                <label class="form-label" for="address">{{ __('Please enter your full address') }}</label>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalmap">Agregar Ubicacion en Mape</a>
                                            </div>
                                            <textarea class="form-control @error('address') is-invalid @enderror" id="search_input" name="address" required placeholder="Type address...">{{ old('address') }}</textarea>
                                            <input type="hidden" name="latitude" id="loc_lat" />
                                            <input type="hidden" name="longitude" id="loc_long" />
                                            @error('address')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-row">
                                            <label class="form-label" for="profile_image">{{ __('Upload a Profile Picture') }}</label>
                                            <input class="form-control @error('profile_image') is-invalid @enderror" type="file" id="profile_image" name="profile_image" required accept="image/*">
                                            @error('profile_image')
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
                    <div class="user-block-right-box">
                        <div class="user-block-right-inner">
                            <div class="user_block_right_top">
                                <h3>Descarga nuestra aplicación</h3>
                                <p>Desktop & Mobile Available</p>
                                <div class="icon_apps">
                                    <img src="{{asset('images/social-icon-user.png')}}" alt="mipo">
                                </div>
                                <div class="webapp_btn">
                                    <a href="#">
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
        <div class="modal fade map_modal" id="modalmap" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <a href="javascript:void(0)" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <div class="modal_form_row">
                                {{-- <div class="modal_form_col modal_form_col_half">
                                    <div class="input-row">
                                        <input type="text" name="" id="" class="form-control" placeholder="Name">
                                    </div>
                                </div>
                                <div class="modal_form_col modal_form_col_half">
                                    <div class="input-row">
                                        <input type="text" name="" id="" class="form-control" placeholder="Email">
                                    </div>
                                </div> --}}
                                <div class="modal_form_col">
                                    <div class="input-row">
                                        <input type="text" id="address-modal-input" name="address_address" class="form-control map-modal-input" style="z-index:9999;">
                                        <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
                                        <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
                                    </div>
                                </div>
                                <div class="modal_form_col">
                                    <div class="map_block_modal">
                                        <div id="address-map-container" style="width:100%;height:400px; ">
                                            <div class="container" id="map-canvas" style="height:100%;z-index:9995;"></div>
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
    @section('custom_script')
    <script>
        let date = new Date();
        date.setFullYear(date.getFullYear()-18);
        document.getElementById("birth_date").max = date.toISOString().split("T")[0];
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key={{ env('GOOGLE_MAP_KEY') }}"></script>
    <script>
        var searchInput = 'search_input';
        function initForm() {
            var autocomplete;
            autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
                types: ['geocode'],
            });
            
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var near_place = autocomplete.getPlace();
                document.getElementById('loc_lat').value = near_place.geometry.location.lat();
                document.getElementById('loc_long').value = near_place.geometry.location.lng();
            });
        }
        function init() {
            var map = new google.maps.Map(document.getElementById('map-canvas'), {
                center: {
                    lat: 12.9715987,
                    lng: 77.59456269999998
                },
                zoom: 12
            });
            var searchBox = new google.maps.places.SearchBox(document.getElementById('address-modal-input'));
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(document.getElementById('address-modal-input'));
            google.maps.event.addListener(searchBox, 'places_changed', function() {                
                searchBox.set('map', null);
                var places = searchBox.getPlaces();
                var bounds = new google.maps.LatLngBounds();
                var i, place;
                for (i = 0; place = places[i]; i++) {
                    (function(place) {
                        var marker = new google.maps.Marker({
                            position: place.geometry.location
                        });
                        marker.bindTo('map', searchBox, 'map');
                        google.maps.event.addListener(marker, 'map_changed', function() {
                            if (!this.getMap()) {
                                this.unbindAll();
                            }
                        });
                        //Set lat & long
                        document.getElementById('address-latitude').value = place.geometry.location.lat();
                        document.getElementById('address-longitude').value = place.geometry.location.lng();                    
                        bounds.extend(place.geometry.location);
                    }(place));
                }
                map.fitBounds(bounds);
                searchBox.set('map', map);
                map.setZoom(Math.min(map.getZoom(),12));
            });
        }
        google.maps.event.addDomListener(window, 'load', init);
        google.maps.event.addDomListener(window, 'load', initForm);
    </script>
    @endsection
</x-guest-layout>