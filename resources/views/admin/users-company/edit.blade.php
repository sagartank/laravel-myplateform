<x-app-admin-layout>
    @section('custom_style')
        <link href="{{ asset('plugins/fancybox/fancybox.css') }}" rel="stylesheet">
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Edit User') }}
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
                                                <label class="form-label" for="first-name">{{ ($user->is_user_company == '1') ? __('Company Name') : __('First Name') }}</label>
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
                                                <label class="form-label" for="last-name">{{ ($user->is_user_company == '1') ? __('Commercial Name') : __('Last Name') }}</label>
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
                                                <label class="form-label" for="birth-date">{{ __('Date of Birth') }}</label>
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
                                                <label class="form-label" for="password">Password</label>
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
                                                <label class="form-label" for="gender">{{ __('Gender') }}</label>
                                                <select name="gender" id="gender" class="form-control"
                                                    value="{{ old('gender', $user->gender) }}">
                                                    <option value="">{{ __('Select a gender') }}</option>
                                                    <option value="Male"
                                                        @if ($user->gender === 'Male') selected @endif>{{ __('Male')}}</option>
                                                    <option value="Female"
                                                        @if ($user->gender === 'Female') selected @endif>{{ __('Female')}}
                                                    </option>
                                                    <option value="Other"
                                                        @if ($user->gender === 'Other') selected @endif>{{ __('Other') }}</option>
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
                                    {{--                                    <hr> --}}
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
                                            <div class="col-md-6 mt-4">
                                                <div class="row mb-3">
                                                    <label for="first-name" class="col-sm-4 col-form-label">{{ ($user->is_user_company == '1') ?  __('Company Name') : __('First Name' ) }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="first-name"
                                                            name="first_name"
                                                            value="{{ old('first_name', $user->first_name) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-4">
                                                <div class="row mb-3">
                                                    <label for="last-name" class="col-sm-4 col-form-label">{{ ($user->is_user_company == '1') ?  __('Commercial Name') : __('Last Name' ) }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="last-name"
                                                            name="last_name"
                                                            value="{{ old('last_name', $user->last_name) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="birth-date" class="col-sm-4 col-form-label">{{ __('Date of Birth') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control" id="birth-date"
                                                            name="birth_date"
                                                            value="{{ old('birth_date', $user->birth_date) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="gender"
                                                        class="col-sm-4 col-form-label">{{ __('Gender') }}</label>
                                                    <div class="col-sm-8">
                                                            <select name="gender" id="gender" class="form-control"
                                                            value="{{ old('gender', $user->gender) }}">
                                                            <option value="">{{ __('Select a gender') }}</option>
                                                            <option value="Male"
                                                                @if ($user->gender === 'Male') selected @endif>{{ __('Male')}}</option>
                                                            <option value="Female"
                                                                @if ($user->gender === 'Female') selected @endif>{{ __('Female')}}
                                                            </option>
                                                            <option value="Other"
                                                                @if ($user->gender === 'Other') selected @endif>{{ __('Other') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
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
                                                                <option {{ ($city->name == $user->city) ? 'selected' : ''}} value="{{ $city->name }}">{{ $city->name }}</option>
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
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="ruc-tax-id" class="col-sm-4 col-form-label">{{ __('RUC') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="ruc-tax-id"
                                                            name="ruc_tax_id"
                                                            value="{{ old('ruc_tax_id', $user->ruc_tax_id) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="occupation"
                                                        class="col-sm-4 col-form-label">{{ __('Occupation')}}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="occupation"
                                                            name="occupation"
                                                            value="{{ old('occupation', $user->occupation) }}">
                                                    </div>
                                                </div>
                                            </div>
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
                                                    <div class="col-md-12">
                                                        <div class="row mb-3">
                                                            <label for="bio"
                                                                class="col-sm-2 col-form-label">{{ __('Address') }}</label>
                                                            <div class="col-sm-10">
                                                                <textarea rows="2" class="form-control" id="address" name="address">{{ old('address', $user->address) }}</textarea>
                                                            </div>
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
                                                                    <input type="text" class="form-control"
                                                                        id="preferred-currency"
                                                                        name="preferred_currency"
                                                                        value="{{ old('preferred_currency', $user->preferred_currency) }}">
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
                                                                        @if (config('constants.PREFERRED_DASHBOARD'))
                                                                            @foreach (config('constants.PREFERRED_DASHBOARD') as $val)
                                                                                <option
                                                                                    {{ $user->preferred_dashboard === $val ? 'selected' : '' }}
                                                                                    value="{{ $val }}">
                                                                                    {{ $val }}</option>
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
                                                                    <input type="text" class="form-control"
                                                                        id="preferred-language"
                                                                        name="preferred_language"
                                                                        value="{{ old('preferred_language', $user->preferred_language) }}">
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
                                                                        {{ $issuer->name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    @if($user->is_user_company == '1')
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
                                            <div class="col-sm-4 col-sm-offset-4">
                                                <textarea id="points_title" name="points_title" class="form-control" placeholder="{{ __('Mi point title')}}"></textarea>
                                            </div>
                                        </div>

                                        @if($user->mi_coins_poinst->count())
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th><strong>{{ __('Point') }}</strong></th>
                                                            <th><strong>{{ __('Title') }}</strong></th>
                                                            <th><strong>{{ __('Date & Time') }}</strong></th>
                                                            <th><strong>{{ __('Created by') }}</strong></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($user->mi_coins_poinst as $point_val)
                                                            <tr>
                                                                <td>{{ $point_val->points }}</td>
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
                                            <a href="{{ route('admin.users.index') }}">
                                                <button type="button"
                                                    class="btn waves-effect waves-light btn-outline-dark rounded-md">{{ __('Back to User List') }}</button>
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

    @section('custom_script')
    <script src="{{ asset('plugins/jquery-repeater/jquery.repeater.min.js') }}"></script>
    <script>
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
    @endsection
</x-app-admin-layout>
