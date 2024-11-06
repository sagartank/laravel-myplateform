<x-app-admin-layout>
    @section('custom_style')
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Edit Permission') }}
            <x-slot name="right"></x-slot>
        </x-header>
    </x-slot>

    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="name">Name</label>
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Permission Name" value="{{ old('name', $permission->display_name) }}" required autofocus>
                                            @error('name')
                                            <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="description">Description</label>
                                            <textarea type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Define Permission">{{ old('description', $permission->description) }}</textarea>
                                            @error('description')
                                            <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" id="is-admin" type="checkbox" name="is_admin" value="1" @if($permission->is_admin) checked @endif>
                                                <label class="form-check-label" for="is-admin">Is For Admin Users ?</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" id="is-active" type="checkbox" name="is_active" value="1" @if($permission->is_active) checked @endif>
                                                <label class="form-check-label" for="is-active">Is Active ?</label>
                                            </div>
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
                                        <a href="{{ route('admin.permissions.index') }}">
                                            <button type="button" class="btn waves-effect waves-light btn-outline-dark rounded-md">Cancel</button>
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
