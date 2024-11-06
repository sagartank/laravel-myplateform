<x-app-admin-layout>
@section('custom_style')
<link href="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
<link href="{{ asset('plugins/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('plugins/select2-bootstrap4-theme-master/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
@endsection

    <x-slot name="header">
        <x-header>
            {{ __('Create User') }}
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

            {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="first-name">{{ __('First Name') }}</label>
                                                <input type="text" name="first_name" id="first-name" class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name" value="{{ old('first_name') }}" required autofocus>
                                                @error('first_name')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="last-name">{{ __('Last Name') }}</label>
                                                <input type="text" name="last_name" id="last-name" class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name" value="{{ old('last_name') }}" required>
                                                @error('last_name')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="email">{{ __('Email Address') }}</label>
                                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" value="{{ old('email') }}" required autocomplete="username">
                                                @error('email')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="phone-number">{{ __('Mobile Number') }}</label>
                                                <input type="text" name="phone_number" id="phone-number" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Mobile Number" value="{{ old('phone_number') }}" required>
                                                @error('phone_number')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="birth-date">{{ __('Date of Birth')}}</label>
                                                <input type="date" name="birth_date" id="birth-date" class="form-control @error('birth_date') is-invalid @enderror" placeholder="Date of Birth" value="{{ old('birth_date') }}">
                                                @error('birth_date')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="password">{{ __('Password') }}</label>
                                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="new-password">
                                                @error('password')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="password-confirm">{{ __('Confirm Password') }}</label>
                                                <input type="password" id="password-confirm" name="password_confirmation" class="form-control" placeholder="Re-enter your password" required autocomplete="new-password">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <x-select-role />
                                            {{-- <div class="form-group mb-3">
                                                <label class=form-label" for="role-id">{{ __('Role') }}</label>
                                                <select name="role_id" id="role-id" class="form-control select2 @error('role_id') is-invalid @enderror" required>
                                                    @foreach($roles as $roleId => $roleName)
                                                        <option value="{{ $roleId }}" {{ (old('role_id') == $roleId) ? 'selected="selected"' : '' }}>{{ $roleName }}</option>
                                                    @endforeach
                                                </select>
                                                @error('role_id')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div> --}}
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="gender">{{ __('Gender') }}</label>
                                                <select name="gender" id="gender" class="form-control">
                                                    <option value="">{{ __('Select a gender')   }}</option>
                                                    <option value="Male" @if(old('gender') == 'Male') selected @endif>{{ __('Male')}}</option>
                                                    <option value="Female" @if(old('gender') == 'Female') selected @endif>{{ __('Female') }}</option>
                                                    <option value="Other" @if(old('gender') == 'Other') selected @endif>{{ __('Other') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="profile-image">{{ __('Profile Image') }}</label>
                                                <input type="file" accept="image/*" name="profile_image" id="profile-image" class="form-control @error('profile_image') is-invalid @enderror">
                                                @error('profile_image')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="card-footer">
                                <div class="row py-2">
                                    <div class="col-md-12">
                                        <x-submit-button class="mr-4">
                                            {{ __('Submit') }}
                                        </x-submit-button>
                                        <a href="{{ route('admin.users.index') }}">
                                            <button type="button" class="btn waves-effect waves-light btn-outline-dark rounded-md">{{ __('Cancel') }}</button>
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
    $(document).ready(function () {

    });
</script>
@endsection
</x-app-admin-layout>
