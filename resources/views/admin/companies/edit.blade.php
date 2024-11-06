<x-app-admin-layout>
    @section('pageTitle', 'Company Type Edit')
    @section('custom_style')
    @endsection
        <x-slot name="header">
            <x-header>
                {{ __('Edit Company') }}
                <x-slot name="right">
                    <a href="{{ route('admin.companies.index') }}">
                        <button type="button" class="btn btn-sm btn-dark">{{ __('Back') }}</button>
                    </a>
                </x-slot>
            </x-header>
        </x-slot>
        <div class="py-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                           
                            <form action="{{ route('admin.companies.update', $edit) }}" method="POST">
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <input type="checkbox" {{ ($edit->is_active && $edit->is_active == '1') ? 'checked' : '' }} name="is_active" id="is_active" class="form-check-input @error('is_active') is-invalid @enderror" value="1">
                                                <label class="form-label" for="is_active">{{ __('Is Active?') }}</label>
                                                @error('is_active')
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
                                            <a href="{{ route('admin.companies.index') }}">
                                                <button type="button" class="btn waves-effect waves-light btn-outline-dark rounded-md">{{ __('Cancel')  }}</button>
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
    