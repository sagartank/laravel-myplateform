<x-app-admin-layout>
    @section('pageTitle', 'Issuer Bank Edit')
    @section('custom_style')
    @endsection
        <x-slot name="header">
            <x-header>
                {{ __('Edit') }} {{ __('Issuer Bank') }}
                <x-slot name="right">
                    <a href="{{ route('admin.issuer-bank.index') }}">
                        <button type="button" class="btn btn-sm btn-dark">{{ __('Back')}}</button>
                    </a>
                </x-slot>
            </x-header>
        </x-slot>
        <div class="py-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <form action="{{ route('admin.issuer-bank.update', $edit) }}" method="POST">
                                <div class="card-body">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="name">{{ __('Name') }}</label>
                                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"  placeholder="Name" value="{{ old('name', $edit->name) }}" required autofocus>
                                                @error('name')
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
                                                {{ __('Update') }}
                                            </x-submit-button>
                                            <a href="{{ route('admin.issuer-bank.index') }}">
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
    @endsection
    </x-app-admin-layout>
    