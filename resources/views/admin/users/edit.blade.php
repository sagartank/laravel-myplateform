<x-app-admin-layout>
    @section('pageTitle', 'User Edit')
    @section('custom_style')
    <link href="{{ asset('plugins/fancybox/fancybox.css') }}" rel="stylesheet">
    <style>
        .pac-container {
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

    <x-slot name="header">
        <x-header>
            {{ ($user->is_user_company == '1') ?  __('Edit Company') : __('Edit User' )  }}
            <x-slot name="right">
                <a href="{{ route('admin.users.index') }}">
                    <button type="button" class="btn btn-sm btn-dark">{{__('Back')}}</button>
                </a>
            </x-slot>
        </x-header>
    </x-slot>
    @include('components.message')
    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.users.update', $user) }}" method="POST"
                            enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                @method('PUT')

                                @if ($user->is_admin)
                                    <div class="text-center">
                                        <div class="user-avatar">
                                            <img src="{{ $user->profile_image ? route('secure-image', Crypt::encryptString($user->profile_image)) : asset('images/profile-stock.png') }}"
                                                class="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="first-name">{{  __('First Name') }}</label>
                                                <input type="text" name="first_name" id="first-name"
                                                    class="form-control @error('first_name') is-invalid @enderror"
                                                    placeholder=""
                                                    value="{{ old('first_name', $user->first_name) }}" required
                                                    autofocus>
                                                @error('first_name')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="last-name">{{  __('Last Name') }}</label>
                                                <input type="text" name="last_name" id="last-name"
                                                    class="form-control @error('last_name') is-invalid @enderror"
                                                    placeholder=""
                                                    value="{{ old('last_name', $user->last_name) }}" required>
                                                @error('last_name')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="email">{{ __('Email Address')}}</label>
                                                <input type="email" name="email" id="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    placeholder="{{ __('Email Address')}}" value="{{ old('email', $user->email) }}"
                                                    required autocomplete="username">
                                                @error('email')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="phone-number">{{ __('Mobile Number') }}</label>
                                                <input type="text" name="phone_number" id="phone-number"
                                                    class="form-control @error('phone_number') is-invalid @enderror"
                                                    placeholder="{{ __('Mobile Number') }}"
                                                    value="{{ old('phone_number', $user->phone_number) }}" required>
                                                @error('phone_number')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="birth-date">{{ ($user->is_user_company == '1') ?  __('Established') : __('Date of Birth' )  }}</label>
                                                <input type="date" name="birth_date" id="birth-date"
                                                    class="form-control @error('birth_date') is-invalid @enderror"
                                                    placeholder="{{ __('Date of Birth') }}"
                                                    value="{{ old('birth_date', $user->birth_date) }}">
                                                @error('birth_date')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="password">{{ __('Password') }}</label>
                                                <input type="password" name="password" id="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Password" autocomplete="new-password">
                                                @error('password')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label"
                                                    for="password-confirm">{{ __('Confirm Password') }}</label>
                                                <input type="password" id="password-confirm"
                                                    name="password_confirmation" class="form-control"
                                                    placeholder="Re-enter your password" autocomplete="new-password">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <x-select-role :user="$user" />
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="gender">{{ __('Marital status') }}</label>
                                                {{-- <select name="gender" id="gender" class="form-control"
                                                    value="{{ old('gender', $user->gender) }}">
                                                    <option value="">{{ __('Select a gender') }}</option>
                                                    <option value="Male"
                                                        @if ($user->gender === 'Male') selected @endif>{{ __('Male')}}</option>
                                                    <option value="Female"
                                                        @if ($user->gender === 'Female') selected @endif>{{ __('Female')}}
                                                    </option>
                                                    <option value="Other"
                                                        @if ($user->gender === 'Other') selected @endif>{{ __('Other') }}</option>
                                                </select> --}}

                                                <select class="form-control @error('marital_status') is-invalid @enderror" id="marital_status" name="marital_status">
                                                    @foreach (config('constants.MARITAL_STATUS') as $marital_status_val)
                                                    <option  {{ ($user->marital_status == $marital_status_val) ? 'selected' : ''}} value="{{ $marital_status_val }}"> {{ __($marital_status_val) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="profile-image">{{ __('Profile Image') }}</label>
                                                <input type="file" accept="image/*" name="profile_image"
                                                    id="profile-image"
                                                    class="form-control @error('profile_image') is-invalid @enderror">
                                                @error('profile_image')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" id="is-active" type="checkbox"
                                                        name="is_active" value="1"
                                                        @if ($user->is_active) checked @endif>
                                                    <label class="form-check-label" for="is-active">{{ __('Is Active?')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (!$user->is_admin)
                                    @permission('edit-user-authentication-fields')
                                    <fieldset>
                                        <legend>{{ __('Authentication') }}</legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="email" class="col-sm-4 col-form-label">{{ __('Email Address')}}</label>
                                                    <div class="col-sm-8">
                                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="phone-number" class="col-sm-4 col-form-label">{{ __('Phone Number') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="phone-number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="otp" class="col-sm-4 col-form-label">{{ __('OTP') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="otp"
                                                            name="otp" value="@if($user->is_otp_verified) Verified @else {{ old('otp', $user->otp) }} @endif">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="ipv-code" class="col-sm-4 col-form-label">{!! __('IPV Code')!!}</label>
                                                    <div class="col-sm-8">
                                                        @if ($user->is_registered == '0' || empty($user->is_registered))
                                                        <input type="text" class="form-control" id="ipv-code" name="ipv_code" value="{{ old('ipv_code', $user->ipv_code) }}">
                                                        @endif
                                                        @if ($user->is_registered == '1')
                                                            <span class="badge bg-success"> {{ $user->ipv_code }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="id-proof" class="col-sm-4 col-form-label">{{ __('ID Proof') }}</label>
                                                    <div class="col-sm-6">
                                                        @if ($user->is_registered == '0' || empty($user->is_registered))
                                                        <input type="file" class="form-control" multiple name="id_proof_doc[]">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="ipv-image" class="col-sm-4 col-form-label">{{ __('IPV Image')}}</label>
                                                    <div class="col-sm-6">
                                                        @if ($user->is_registered == '0'  || empty($user->is_registered))
                                                            <input type="file" class="form-control" name="ipv_image">
                                                        @endif
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <img src="{{ $user->ipv_image ? route('secure-image', Crypt::encryptString($user->ipv_image)) : '#' }}"
                                                            alt="IPV Image" class="img-fluid img-thumbnail rounded"
                                                            id="ipv-image" data-fancybox>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    @if($id_proofes)
                                                        @foreach ($id_proofes as $id_proofe)
                                                        <div class="col-sm-2 mb-2" role="button" title="{{ __('Id Proof')}}">
                                                            <img src="{{ $id_proofe->id_proof_image_url }}"   alt="ID Proof" class="img-fluid img-thumbnail rounded" id="id-proof" data-fancybox>
                                                        </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6"></div>
                                        </div>
                                        <div class="row" data-registered="{{$user->is_registered}}">
                                            @permission('user-accept-reject')
                                            <div class="col-md-6">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input evt_active_inactive" data-id="{{$user->id}}" @if ($user->is_active == '1') checked @endif type="checkbox" name="is_active" role="switch" id="active_inactive">
                                                    <label class="form-check-label" for="active_inactive">{{ __('Is Active?')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" id="approve-user-btn" data-show-id="#reject-user-btn" data-user-id="{{ $user->slug }}" class="btn btn-success mr-3 text-white"  @if ($user->is_registered == '1') style="display: none;" @endif>{{ __('Approve User Register')}}</button>
                                                <button type="button" id="reject-user-btn" data-show-id="#approve-user-btn" data-user-id="{{ $user->slug }}" class="btn btn-danger text-white" @if ($user->is_registered == '0') style="display: none;" @endif>{{ __('Reject User Register') }}</button>
                                            </div>
                                            @endpermission
                                            {{-- <div class="col-md-6 ">
                                                <div class="form-group mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" id="is-active"
                                                            type="checkbox" name="is_active" value="1"
                                                            @if ($user->is_active) checked @endif>
                                                        <label class="form-check-label" for="is-active">Is Login
                                                            ?</label>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </fieldset>
                                    @endpermission
                                    <hr>
                                    <fieldset>
                                        <legend>{{ __('Profile') }}</legend>
                                        <div class="row">
                                            <div class="text-center">
                                                <div class="user-avatar">
                                                    <img src="{{ $user->profile_image ? route('secure-image', Crypt::encryptString($user->profile_image)) : asset('images/profile-stock.png') }}"
                                                        class="">
                                                </div>
                                            </div>
                                            @if($user->is_user_company != '1')
                                            <div class="col-md-6 mt-4">
                                                <div class="row mb-3">
                                                    <label for="first-name" class="col-sm-4 col-form-label">{{  __('First Name' ) }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="first-name"
                                                            name="first_name"
                                                            value="{{ old('first_name', $user->first_name) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-4">
                                                <div class="row mb-3">
                                                    <label for="last-name" class="col-sm-4 col-form-label">{{   __('Last Name' ) }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="last-name"
                                                            name="last_name"
                                                            value="{{ old('last_name', $user->last_name) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @if($user->is_user_company == '1')
                                            <div class="col-md-6 mt-4">
                                                <div class="row mb-3">
                                                    <label for="last-name" class="col-sm-4 col-form-label">{{   __('Company Name') }}</label>
                                                    <div class="col-sm-8">
                                                        <input required type="text" class="form-control" id="company_name"
                                                            name="company_name"
                                                            value="{{ old('company_name', $user->issuer?->company_name) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-4">
                                                <div class="row mb-3">
                                                    <label for="last-name" class="col-sm-4 col-form-label">{{   __('Commercial Name') }}</label>
                                                    <div class="col-sm-8">
                                                        <input required type="text" class="form-control" id="commercial_name"
                                                            name="commercial_name"
                                                            value="{{ old('commercial_name', $user->issuer?->commercial_name) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="birth-date" class="col-sm-4 col-form-label">{{ ($user->is_user_company == '1') ?  __('Established') : __('Date of Birth') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control" id="birth-date"
                                                            name="birth_date"
                                                            value="{{ old('birth_date', $user->birth_date) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                @if($user->is_user_company != '1')
                                                <div class="row mb-3">
                                                    <label for="gender"
                                                        class="col-sm-4 col-form-label">{{ __('Marital Status') }}</label>
                                                    <div class="col-sm-8">
                                                            <select class="form-control @error('marital_status') is-invalid @enderror" id="marital_status" name="marital_status">
                                                                @foreach (config('constants.MARITAL_STATUS') as $marital_status_val)
                                                                <option  {{ ($user->marital_status == $marital_status_val) ? 'selected' : ''}} value="{{ $marital_status_val }}"> {{ __($marital_status_val) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </select>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="gender" class="col-sm-4 col-form-label">
                                                        {{ ($user->is_user_company == '1') ? 'Company Logo' : 'Profile Picture' }}
                                                        </label>
                                                    <div class="col-sm-8">
                                                        <input type="file" class="form-control" id="profile_image"
                                                            name="profile_image">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="city" class="col-sm-4 col-form-label">{{ __('City') }}</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-select @error('city') is-invalid @enderror" id="city" name="city" required>
                                                            <option selected disabled hidden>{{ __('Select a City') }}</option>
                                                            @foreach($cities as $city)
                                                                <option {{ ($city->id == $user->city_id) ? 'selected' : ''}} value="{{ $city->id }}">{{ $city->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="postal-code" class="col-sm-4 col-form-label">{{ __('Postal
                                                        Code') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="postal-code"
                                                            name="postal_code"
                                                            value="{{ old('postal_code', $user->postal_code) }}">
                                                    </div>
                                                </div>
                                            </div> --}}
                                            {{-- <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="state"
                                                        class="col-sm-4 col-form-label">State</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="state"
                                                            name="state" value="{{ old('state', $user->state) }}">
                                                    </div>
                                                </div>
                                            </div> --}}
                                        {{--     <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="country" class="col-sm-4 col-form-label">Country</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-select @error('country_id') is-invalid @enderror" id="country" name="country" required>
                                                            <option selected disabled hidden>{{ __('Select a country') }}</option>
                                                            @foreach($countries as $country)
                                                                <option {{ ($country->id == $user->country_id) ? 'selected' : ''}} value="{{ $country->id }}">{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> --}}
                                           {{--  <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="ruc-tax-id" class="col-sm-4 col-form-label">{{ __('RUC') }}</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control disabled" id="ruc-tax-id"
                                                            name="ruc_tax_id"
                                                            value="{{ old('ruc_tax_id', $user->issuer?->ruc_text_id) }}" disabled>
                                                    </div>
                                                    <div class="col-sm-2">
                                                            <input type="text" class="form-control disabled" id="ruc_code"
                                                            name="ruc_code" placeholder="{{ __('Code')}}"
                                                            value="{{ old('ruc_code', $user->issuer?->ruc_code_optional) }}" disabled>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            {{-- <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="occupation"
                                                        class="col-sm-4 col-form-label">{{ __('Occupation')}}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="occupation"
                                                            name="occupation"
                                                            value="{{ old('occupation', $user->occupation) }}">
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <div class="col-md-12">
                                                <div class="row mb-3">
                                                    <label for="bio" class="col-sm-2 col-form-label">{{ __('Bio') }}</label>
                                                    <div class="col-sm-10">
                                                        <textarea rows="2" class="form-control" id="bio" name="bio">{{ old('bio', $user->bio) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <fieldset>
                                            <hr>
                                            <fieldset>
                                                <legend>{{ __('Address') }}</legend>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="row mb-3">
                                                            <label for="bio"
                                                                class="col-sm-2 col-form-label">{{ __('Address') }}</label>
                                                            <div class="col-sm-10">
                                                                <textarea rows="2" class="form-control" id="search_input" name="address">{{ old('address', $user->address) }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="row mb-3">
                                                            <label for="bio"
                                                                class="col-sm-2 col-form-label">{{ __('Address Map') }}</label>
                                                            <div class="col-sm-10">
                                                                <textarea rows="2" class="form-control" id="address_google_map" readonly name="address_google_map">{{ old('address', $user->address_google_map) }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="address_box_label">
                                                            <a href="javascript::" data-coreui-toggle="modal" data-coreui-target="#modalmap">Agregar Ubicacion en Mape</a>
                                                            <input type="hidden" name="latitude" id="loc_lat" />
                                                            <input type="hidden" name="longitude" id="loc_long" />
                                                        </div>
                                                    </div>
                                                    @if ($user->address_verify == 'No')
                                                        <div class="col-md-6">
                                                            <div class="row mb-3">
                                                                <label for="address_verify_otp"
                                                                    class="col-sm-4 col-form-label">{{ __('OTP')}} {!! ($user->address_verify_otp!='') ? ' : <strong>'. $user->address_verify_otp .'</strong>': '' !!}
                                                                </label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control"
                                                                        id="address_verify_otp"
                                                                        name="address_verify_otp" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @elseif($user->address_verify == 'Yes')
                                                        <div class="col-md-6">
                                                            <div class="row mb-3">
                                                                <label for="address_verify_otp"
                                                                    class="col-sm-4 col-form-label">
                                                                    <span
                                                                        class="badge rounded-pill bg-info text-dark">{{ __('OTP Verified') }}</span>
                                                                </label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" disabled
                                                                        class="form-control" id="address_verify_otp"
                                                                        readonly name="address_verify_otp"
                                                                        value="{{ $user->address_verify_otp }}" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-md-6">
                                                        <div class="row mb-3">
                                                            <label for="address_authorise_name"
                                                                class="col-sm-4 col-form-label">{{ __('Authorise Name') }}</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                    id="address_authorise_name"
                                                                    name="address_authorise_name"
                                                                    {{ ($user->address_verify == 'Yes') ? 'readonly disabled' : '' }}
                                                                    value="{{ old('address_authorise_name', $user->address_authorise_name) }}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--   @if ($user->address_verify == 'No' && empty($user->address_verify_otp))
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" id="send_address"
                                                                        type="checkbox" name="send_address"
                                                                        value="1">
                                                                    <label class="form-check-label"
                                                                        for="send_address">{{ __('Send Address?') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif --}}
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <hr>
                                                <fieldset>
                                                    <legend>{{ __('Preferred Account') }}</legend>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row mb-3">
                                                                <label for="account_type"
                                                                    class="col-sm-4 col-form-label">{{ __('Account Type') }}</label>
                                                                <div class="col-sm-8">
                                                                    <select name="account_type" id="account_type"
                                                                        class="form-control">
                                                                        @if (config('constants.ACCOUNT_TYPE'))
                                                                            @foreach (config('constants.ACCOUNT_TYPE') as $val)
                                                                                <option
                                                                                    {{ $user->account_type === $val ? 'selected' : '' }}
                                                                                    value="{{ $val }}">
                                                                                    {{ $val }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if ($user->account_type === 'Enterprise')
                                                            <div class="col-md-6">
                                                                <div class="row mb-3">
                                                                    <label for="ent-business-type"
                                                                        class="col-sm-4 col-form-label">{{ __('Business Type') }}</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control"
                                                                            id="ent-business-type"
                                                                            name="ent_business_type"
                                                                            value="{{ old('ent_business_type', $user->ent_business_type) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row mb-3">
                                                                    <label for="ent-no-of-users"
                                                                        class="col-sm-4 col-form-label">{{ __('Number of Users') }}</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control"
                                                                            id="ent-no-of-users"
                                                                            name="ent_no_of_users"
                                                                            value="{{ old('ent_no_of_users', $user->ent_no_of_users) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row mb-3">
                                                                    <label for="ent-no-of-deals-per-day"
                                                                        class="col-sm-4 col-form-label">{{ __('Number of Deals Per Day') }}</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control"
                                                                            id="ent-no-of-deals-per-day"
                                                                            name="ent_no_of_deals_per_day"
                                                                            value="{{ old('ent_no_of_deals_per_day', $user->ent_no_of_deals_per_day) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="col-md-6">
                                                            <div class="row mb-3">
                                                                <label for="preferred-currency"
                                                                    class="col-sm-4 col-form-label">{{ __('Preferred Currency') }}</label>
                                                                <div class="col-sm-8">
                                                                    <select name="preferred_currency" id="preferred_currency" class="form-control">
                                                                        @if (config('constants.CURRENCY_SYMBOLS'))
                                                                            @foreach (config('constants.CURRENCY_SYMBOLS') as $key => $val)
                                                                                <option {{ $user->preferred_currency === $key ? 'selected' : '' }} value="{{ $key }}">  {{ $key }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row mb-3">
                                                                <label for="preferred-dashboard"
                                                                    class="col-sm-4 col-form-label">{{ __('Preferred Dashboard') }}</label>
                                                                <div class="col-sm-8">
                                                                    <select name="preferred_dashboard"
                                                                        id="preferred_dashboard" class="form-control">
                                                                        @if (config('constants.PREFERRED_DASHBOARD_Arr'))
                                                                            @foreach (config('constants.PREFERRED_DASHBOARD_Arr') as $key =>  $val)
                                                                                <option {{ $user->preferred_dashboard === $key ? 'selected' : '' }}  value="{{ $key }}">  {{ __($val) }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row mb-3">
                                                                <label for="preferred-language"
                                                                    class="col-sm-4 col-form-label">{{ __('Preferred Language') }}</label>
                                                                <div class="col-sm-8">
                                                                    <select name="preferred_language" id="preferred_language" class="form-control">
                                                                        @if (config('constants.languages'))
                                                                            @foreach (config('constants.languages') as $key => $val)
                                                                                <option {{ $user->preferred_language === $key ? 'selected' : '' }}  value="{{ $key }}">  {{ $val }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row mb-3">
                                                                <label for="preferred-contact-method"
                                                                    class="col-sm-4 col-form-label">{{ __('Preferred Contact Method') }}</label>
                                                                <div class="col-sm-8">
                                                                    <select name="preferred_contact_method"
                                                                        id="preferred_contact_method"
                                                                        class="form-control">
                                                                        @if (config('constants.PREFERRED_CONTACT_METHOD'))
                                                                            @foreach (config('constants.PREFERRED_CONTACT_METHOD') as $val)
                                                                                <option
                                                                                    {{ $user->preferred_contact_method === $val ? 'selected' : '' }}
                                                                                    value="{{ $val }}">
                                                                                    {{ $val }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" id="as-borrower"
                                                                        type="checkbox" name="as_borrower"
                                                                        value="1"
                                                                        @if ($user->as_borrower) checked @endif
                                                                        disabled>
                                                                    <label class="form-check-label"
                                                                        for="as-borrower">{{ __('As Borrower') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" id="as-investor"
                                                                        type="checkbox" name="as_investor"
                                                                        value="1"
                                                                        @if ($user->as_investor) checked @endif
                                                                        disabled>
                                                                    <label class="form-check-label"
                                                                        for="as-investor">{{ __('As Investor') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                @endif
                                @if (!$user->is_admin)
                                    @php
                                        $bank_ewallet = $bank = $eWallet = 'none';
                                        if (isset($bank_details)) {
                                            if ($bank_details?->payment_options == 'Bank') {
                                                $bank = '';
                                                $bank_ewallet = '';
                                            } elseif ($bank_details?->payment_options == 'eWallet') {
                                                $eWallet = '';
                                                $bank_ewallet = '';
                                            }
                                        }
                                    @endphp
                                {{--  <hr>
                                    <fieldset>
                                        <legend>{{ __('Bank Details') }}</legend>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"
                                                        for="doc-type-1">{{ __('Payment Options') }}</label>
                                                    @if ($payment_options)
                                                        @foreach ($payment_options as $payment_option_label => $payment_option_val)
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input evt_payment_options"
                                                                    {{ $bank_details?->payment_options == $payment_option_val ? 'checked' : '' }}
                                                                    type="radio" name="payment_options"
                                                                    id="payment_options-{{ $payment_option_label }}"
                                                                    value="{{ $payment_option_val }}">
                                                                <label class="form-check-label"
                                                                    for="payment_options-{{ $payment_option_label }}">{{ $payment_option_label }}</label>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="row bank_details_div" style="display: {{ $bank }}">
                                                <div class="col-md-4">
                                                    <div class="row mb-3">
                                                        <label for="bank_name"
                                                            class="col-sm-4 col-form-label">{{ __('Bank Name') }}</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="bank_name"
                                                                name="bank_name"
                                                                value="{{ old('bank_name', $bank_details?->bank_name) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row mb-3">
                                                        <label for="account_name"
                                                            class="col-sm-4 col-form-label">{{ __('Account Name') }}</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                id="account_name" name="account_name"
                                                                value="{{ old('account_name', $bank_details?->account_name) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row mb-3">
                                                        <label for="account_number"
                                                            class="col-sm-4 col-form-label">{{ __('Account Number') }}</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                id="account_number" name="account_number"
                                                                value="{{ old('account_number', $bank_details?->account_number) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row ewallet_div" style="display: {{ $eWallet }}">
                                                <div class="col-md-4">
                                                    <div class="row mb-3">
                                                        <label for="phone_company"
                                                            class="col-sm-4 col-form-label">{{ __('Phone Company') }}</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                id="phone_company" name="phone_company"
                                                                value="{{ old('phone_company', $bank_details?->phone_company) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row mb-3">
                                                        <label for="bank_phone_number"
                                                            class="col-sm-4 col-form-label">{{ __('Phone Number') }}</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                id="bank_phone_number" name="bank_phone_number"
                                                                value="{{ old('bank_phone_number', $bank_details?->phone_number) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row bank_ewallet_div" style="display: {{ $bank_ewallet }}">
                                                <div class="col-md-4">
                                                    <div class="row mb-3">
                                                        <label for="identification_id"
                                                            class="col-sm-4 col-form-label">{{ __('Identification Id') }}</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                id="identification_id" name="identification_id"
                                                                value="{{ old('identification_id', $bank_details?->identification_id) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="payment_note"
                                                            class="col-sm-4 col-form-label">{{ __('Payment Note') }}</label>
                                                        <div class="col-sm-8">
                                                            <textarea rows="2" class="form-control" id="payment_note" name="payment_note">{{ $bank_details?->payment_note }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="bank_is_active"
                                                                type="checkbox" name="bank_is_active" value="Yes"
                                                                @if ($bank_details?->is_active) checked @endif>
                                                            <label class="form-check-label"
                                                                for="bank_is_active">{{ __('Is Active ?') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset> --}}
                                    <hr>
                                    <fieldset>
                                        <legend>{{ __('User issuers Attach') }}</legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="issuer_id"
                                                        class="col-sm-4 col-form-label">{{ __('Issuers') }}</label>
                                                    <div class="col-sm-8">
                                                        <select name="issuer_id" id="issuer_id" class="form-control">
                                                            @if ($issuers)
                                                                <option value="">{{ __('Select Issuers') }}
                                                                </option>
                                                                @foreach ($issuers as $key => $issuer)
                                                                    <option
                                                                        {{ $user->issuer_id == $issuer->id ? 'selected' : '' }}
                                                                        value="{{ $issuer->id }}">
                                                                        {{ $issuer->company_name .' RUC ('. $issuer->ruc_code .')' }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    @if($user->is_user_company == '11')
                                    <hr>
                                    <fieldset>
                                        <legend>{{ __('User Company') }}</legend>
                                        <div class="row">
                                            <div class="col-md-4 label_comp">
                                                <div class="input-row">
                                                    <label class="form-label label_comp" for="attach_company_documents">{{ __('Attach Company Documents') }}</label>
                                                    <input class="form-control @error('attach_company_documents') is-invalid @enderror" type="file" title="{{ __('Attach Company Documents') }}" id="attach_company_documents" name="attach_company_documents">
                                                    @error('attach_company_documents')
                                                        <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4 label_comp">
                                                <div class="input-row">
                                                    @if(!empty($user->attach_company_documents)) 
                                                        @php
                                                            $file_ext = strtolower(pathinfo($user->attach_company_documents, PATHINFO_EXTENSION));
                                                        @endphp
                                                        @if ($file_ext == 'pdf' && $user->attach_company_documents != '')
                                                            <div class="mt-2">
                                                                <a href="{{ $user->attach_company_documents ? route('secure-pdf', Crypt::encryptString($user->attach_company_documents)) : '#' }}" target="_blank">
                                                                    <img width="100" src="{{ asset('images/mipo/pdf.png') }}"  title="company documents" alt="company documents">
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div class="doc_img mt-2"><img src="{{ $user->attach_company_documents }}" alt="company documents" data-fancybox></div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="repeater label_comp" id="user-company-repeater">
                                                    <div data-repeater-list="user_companies" class="references-repeater">
                                                        @forelse($user_companies as $user_comp)
                                                        <div class="row mt-2" data-repeater-item>
                                                            <input type="hidden" name="user_comp_id" value="{{ $user_comp->id }}">
                                                            <div class="col-md-4">
                                                                <div class="input-row">
                                                                    <input class="form-control" type="text" id="name" name="name" value="{{ $user_comp->name }}" placeholder="Name" required>
                                                                    @error('name')
                                                                    <x-error-alert :message="$message" />
                                                                    @enderror
                                                                </div>
                                                            </div>  
                                                            <div class="col-md-4">
                                                                <div class="input-row">
                                                                    <input class="form-control" type="text" id="phone" name="phone" value="{{ $user_comp->phone }}" placeholder="phone">
                                                                    @error('phone')
                                                                    <x-error-alert :message="$message" />
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="input-row">
                                                                    <input class="form-control" type="text" id="email" name="email" value="{{ $user_comp->email }}" placeholder="email">
                                                                    @error('email')
                                                                    <x-error-alert :message="$message" />
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="input-row mt-2">
                                                                    <img data-repeater-delete src="{{ asset('/images/delete-icon.svg') }}" width="20" height="20" alt="mipo" role="button">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @empty
                                                        <div class="row mt-2" data-repeater-item>
                                                            <div class="col-md-4">
                                                                <div class="input-row">
                                                                    <input class="form-control" type="text" id="name" name="name" placeholder="{{ __('Name')}}" required>
                                                                    @error('name')
                                                                    <x-error-alert :message="$message" />
                                                                    @enderror
                                                                </div>
                                                            </div>  
                                                            <div class="col-md-4">
                                                                <div class="input-row">
                                                                    <input class="form-control" type="text" id="phone" name="phone" placeholder="{{ __('Phone') }}">
                                                                    @error('phone')
                                                                    <x-error-alert :message="$message" />
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="input-row">
                                                                    <input class="form-control" type="text" id="email" name="email" placeholder="{{ __('Email') }}">
                                                                    @error('email')
                                                                    <x-error-alert :message="$message" />
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="input-row mt-2">
                                                                    <img data-repeater-delete src="{{ asset('/images/delete-icon.svg') }}" width="20" height="20" alt="mipo" role="button">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforelse
                                                        
                                                    </div>
                                                    <img data-repeater-create src="{{ asset('/images/plus-gray.svg') }}" alt="mipo" role="button" class="mt-2">
                                                </div>
                                        </div>
                                    </fieldset>
                                    @endif
                                    <hr>
                                    <fieldset>
                                        <legend>{{ __('User Alert Notify') }}</legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="user_alert_type"
                                                        class="col-sm-4 col-form-label">{{ __('User Alert') }}</label>
                                                    <div class="col-sm-8">
                                                        <select name="user_alert_type" id="user_alert_type"
                                                            class="form-control">
                                                            @if (config('constants.USER_ALERT'))
                                                                <option value="">{{ __('Select User Alert') }}
                                                                </option>
                                                                @foreach (config('constants.USER_ALERT') as $user_alert_val => $user_alert_text)
                                                                    <option  value="{{ $user_alert_val }}"> {{ $user_alert_text }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="user_alert_msg"
                                                        class="col-sm-4 col-form-label">{{ __('User Alert Message') }}</label>
                                                    <div class="col-sm-8">
                                                        <textarea class="form-control" name="user_alert_msg" id="user_alert_msg"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($user_alert_notify->count())
                                            <div class="col-md-12">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th><strong>{{ __('Status') }}</strong></th>
                                                            <th><strong>{{ __('Title') }}</strong></th>
                                                            <th><strong>{{ __('Date & Time') }}</strong></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($user_alert_notify as $user_alert_notify_val)
                                                            <tr>
                                                                <td>{{ config('constants.USER_ALERT')[$user_alert_notify_val->alert_id] }}
                                                                </td>
                                                                <td>{{ $user_alert_notify_val->title }}</td>
                                                                <td>{{ $user_alert_notify_val->created_at }}</td>
                                                            </tr>
                                                        @empty
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                            @endif
                                        </div>
                                    </fieldset>
                                    <hr>
                                    <fieldset>
                                        <legend>{{ __('Mi Coins') }}</legend>
                                        <div class="row">
                                            <div class="col-sm-4 col-sm-offset-4">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="btn btn-dark btn-sm" id="minus-btn"><i class="icon cil-minus"></i></span>
                                                    </div>
                                                    <input type="number" id="qty_input" name="mi_points" class="form-control form-control-sm" value="" min="1">
                                                    <div class="input-group-prepend">
                                                        <span class="btn btn-dark btn-sm" id="plus-btn"><i class="icon cil-plus"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-sm-offset-4">
                                                <select name="mi_points_status" id="mi_points_status" class="form-control">
                                                    <option value="credit">{{ __('Credit')}}</option>
                                                    <option value="withdraw">{{ __('Withdraw')}}</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6 col-sm-offset-4">
                                                <textarea id="points_title" name="mi_points_title" class="form-control" placeholder="{{ __('Mi point title')}}"></textarea>
                                            </div>
                                        </div>

                                        @if($user->mi_coins_poinst->count())
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th><strong>{{ __('Point') }}</strong></th>
                                                            <th><strong>{{ __('Credit') }}</strong></th>
                                                            <th><strong>{{ __('Withdraw') }}</strong></th>
                                                            <th><strong>{{ __('Title') }}</strong></th>
                                                            <th><strong>{{ __('Date & Time') }}</strong></th>
                                                            <th><strong>{{ __('Created by') }}</strong></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($user->mi_coins_poinst as $point_val)
                                                            <tr>
                                                                <td>{{ $point_val->points }}</td>
                                                                <td>{{ $point_val->credit }}</td>
                                                                <td>{{ $point_val->withdraw }}</td>
                                                                <td>{{ $point_val->title }}</td>
                                                                <td>{{ $point_val->created_at }}</td>
                                                                <td>{{ $point_val->created_by_user->name }}</td>
                                                            </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="3">
                                                                <p class="text-center font-weight-bold text-danger mt-3">
                                                                    {{ __(' No Record Found.')}}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </fieldset>
                                    @endif
                                @endif
                                <hr>
                                <fieldset>
                                    <legend>{{ __('Relevant Attachments') }}</legend>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="file"  name="user_profile_attache" title="{{ __('Relevant Attachments') }}" id="user_profile_attache" class="form-control">
                                        </div>
                                        <div class="col-md-8"></div>
                                    </div>
                                    <div class="row mt-4">
                                        @if($user->user_profile_attache)
                                            @foreach ($user->user_profile_attache as $user_profile_atta)
                                            @php
                                                $file_ext = strtolower(pathinfo($user_profile_atta->path, PATHINFO_EXTENSION));
                                            @endphp
                                            @if($file_ext == 'pdf' && $user_profile_atta->path!='')
                                            <div class="col-md-1 mb-2 div-remove-image" role="button">
                                                <a href="{{ $user_profile_atta->path ? route('secure-pdf', Crypt::encryptString($user_profile_atta->path)) : '#' }}" target="_blank">
                                                    <img width="100" src="{{ asset('images/mipo/pdf.png') }}" alt="document" class="img-fluid img-thumbnail rounded mt-2">
                                                </a>
                                                <img role="button" class="center-block d-block mx-auto delete-image pt-2" data-table="profile_attaches" data-href="{{ route('admin.users.ajax-delete-image-document', ['id' => $user_profile_atta->id])}}" title="Delete" src="{{ asset('/images/delete-icon.svg') }}"/>
                                            </div>
                                            @else
                                            <div class="col-md-1 mb-2 div-remove-image" role="button">
                                                <img src="{{ $user_profile_atta->user_attach_image_url }}" width="150" class="img-fluid img-thumbnail rounded" alt="document" data-fancybox>
                                                <img role="button" class="center-block d-block mx-auto delete-image pt-2" data-table="profile_attaches" data-href="{{ route('admin.users.ajax-delete-image-document', ['id' => $user_profile_atta->id])}}" title="Delete" src="{{ asset('/images/delete-icon.svg') }}"/>
                                            </div>
                                            @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </fieldset>
                            </div>
                            <div class="card-footer">
                                <div class="row py-2">
                                    <div class="col-md-12">
                                        @if ($user->is_admin)
                                            <x-submit-button class="mr-4">
                                                {{ __('Submit') }}
                                            </x-submit-button>
                                            <a href="{{ route('admin.users.index') }}">
                                                <button type="button"
                                                    class="btn waves-effect waves-light btn-outline-dark rounded-md">{{ __('Cancel') }}</button>
                                            </a>
                                        @else
                                            <x-submit-button class="mr-4">
                                                {{ __('Submit') }}
                                            </x-submit-button>
                                            <a href="{{ ($user->is_user_company == '1') ? route('admin.users.company') : route('admin.users.index')  }}">
                                                <button type="button"
                                                    class="btn waves-effect waves-light btn-outline-dark rounded-md">
                                                    {{ ($user->is_user_company == '1') ?  __('Back to Company List') : __('Back to User List')  }}
                                                </button>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
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
                <a href="javascript:void(0)" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <form id="gmModalForm">
                    <div class="modal_form_row">
                        <div class="modal_form_col">
                            <div class="input-row">
                                <input id="address-modal-input" name="address_address" class="form-control" style="z-index:9999;"/>
                              {{--   <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
                                <input type="hidden" name="address_longitude" id="address-longitude" value="0" /> --}}
                            </div>
                        </div>
                        <div class="modal_form_col mt-4">
                            <div class="map_block_modal">
                                <div id="address-map-container" style="width:100%;height:400px; ">
                                    <div id="map" style="height:100%;z-index:9995;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal_form_col modal_form_submit mt-4">
                            <input type="button" id="mapModelBtn" value="Submit" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    @section('custom_script')
    <script src="{{ asset('plugins/jquery-repeater/jquery.repeater.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=geometry,places&key={{ env('GOOGLE_MAP_KEY') }}"></script>
    <script>
        const lat_user = "{{ $user->latitude }}";
        const lng_user = "{{ $user->longitude }}";
        const active_inactive_url = "{{ route('admin.users.ajax-active-inactive-user') }}";
    </script>
        <script src="{{ asset('plugins/fancybox/fancybox.umd.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#qty_input').prop('readonly', false);

                $company_repeater = $('#user-company-repeater').repeater({
                    show: function () {
                        $(this).slideDown();
                    },
                    hide: function (deleteElement) {
                        if(confirm('Are you sure you want to delete this element?')) {
                            $(this).slideUp(deleteElement);
                        }
                    },
                    isFirstItemUndeletable: false,
                });

                $('#plus-btn').click(function() {
                    var point_number = ($('#qty_input').val() ? $('#qty_input').val()  : 0);
                        $('#qty_input').val(parseInt(point_number) + 1 );
                    });
                    
                    $('#minus-btn').click(function() {
                        $('#qty_input').val(parseInt($('#qty_input').val()) - 1 );
                        if ($('#qty_input').val() == 0) {
                            $('#qty_input').val(1);
                        }
                });

                $(document).on('click', '#approve-user-btn', function(e) {
                    e.preventDefault();
                    let el = $(this);
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-Token': "{{ csrf_token() }}",
                        },
                        url: "{{ route('admin.users.ajax-approve-user') }}",
                        data: 'user_id=' + el.data('user-id'),
                        success: function(res) {
                            if (res.status == true) {
                                el.hide();
                                var _id_show = el.attr('data-show-id');
                                $(_id_show).show();
                                toastr.success(res.message);
                            } else {
                                alert('Error ' + res.status + ': ' + res.message);
                            }
                        },
                        error: function (xhr) {
                            unsetLoadin();
                            ajaxErrorMsg(xhr);
                        }
                    });
                });

                $(document).on('click', '#reject-user-btn', function(e) {
                    e.preventDefault();
                    let el = $(this);
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-Token': "{{ csrf_token() }}",
                        },
                        url: "{{ route('admin.users.ajax-reject-user') }}",
                        data: 'user_id=' + el.data('user-id'),
                        success: function(res) {
                            if (res.status == true) {
                                el.hide();
                                var _id_show = el.attr('data-show-id');
                                $(_id_show).show();
                                toastr.success(res.message);
                               /*  $('#approve-user-btn').show();
                                el.attr('id', 'approve-user-btn');
                                el.text('Approve User');
                                el.removeClass('btn-danger');
                                el.addClass('btn-success'); */
                            } else {
                                alert('Error ' + res.status + ': ' + res.message);
                            }
                        },
                        error: function (xhr) {
                            unsetLoadin();
                            ajaxErrorMsg(xhr);
                        }
                    });
                });

                var bank_div = $('.bank_details_div');
                var ewallet_div = $('.ewallet_div');
                var bank_ewallet_div = $('.bank_ewallet_div');
                $('.evt_payment_options').change(function(e) {
                    e.preventDefault();
                    ewallet_div.hide();
                    bank_div.hide();
                    bank_ewallet_div.hide();
                    var payment_val = $(this).val();
                    if (payment_val != '') {
                        if (payment_val == 'Bank') {
                            bank_div.show();
                            bank_ewallet_div.show();
                        } else if (payment_val == 'eWallet') {
                            ewallet_div.show();
                            bank_ewallet_div.show();
                        }
                    }
                });
            });

            $(document).on('change', '.evt_active_inactive', function (e) {
                e.preventDefault();
                let el = $(this);
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    url: active_inactive_url,
                    data: 'id=' + el.attr('data-id'),
                    success: function (res) {
                        if (res.status == true) {
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                        }
                    },
                    error: function (xhr) {
                        unsetLoadin();
                        ajaxErrorMsg(xhr);
                    }
                });
            });
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
    if(lat_user!='' && lng_user!='') {
        defaultLatLong = {
            lat: lat_user ? parseInt(lat_user) : -25.2968298 ,
            lng: lng_user ? parseInt(lng_user) : -57.680491
        };
    } else {
        defaultLatLong = {
            lat: -25.2968298,
            lng: -57.680491
        };
    }
    
    console.log(defaultLatLong);
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
        console.log(currentLatitude,currentLongitude);

        // document.getElementById('address-latitude').value = currentLatitude;
        // document.getElementById('address-longitude').value = currentLongitude;

        document.getElementById('loc_lat').value = currentLatitude;
        document.getElementById('loc_long').value = currentLongitude;
        document.getElementById('address_google_map').value = document.getElementById('address-modal-input').value;

    });
    $(document).on('click','#mapModelBtn',function(){
     /*    document.getElementById('loc_lat').value = document.getElementById('address-latitude').value;
        document.getElementById('loc_long').value = document.getElementById('address-longitude').value;
        document.getElementById('search_input').value = document.getElementById('address-modal-input').value; */

        document.getElementById('address_google_map').value = document.getElementById('address-modal-input').value;
        $('#modalmap').modal('hide');
    });

    $(document).ready(function ($) {
    $('.delete-image').click(function(e){
        Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure, you want to delete this?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#13153B',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const self = $(this);
                const url_link = self.attr('data-href');
                $.ajax({
                    type: 'POST',
                    url: url_link,
                    data : {
                        'table_name' : self.attr('data-table')
                    },
                    dataType: 'json',
                    success: function (res) {
                        if(res.status == true){
                            toastr.success(res.message);
                            self.parent('.div-remove-image').remove();
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        }
                    },
                    error: function (data) {
                        toastr.error('something went wrong please try again!');
                        console.log(data);
                    }
                });
            }
        });
            });
    });
</script>
    @endsection
</x-app-admin-layout>
