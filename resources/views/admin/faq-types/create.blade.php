<x-app-admin-layout>
    @section('pageTitle', 'Marketing FAQ Types Add')
    @section('custom_style')
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Create FAQ Type') }}
        </x-header>
    </x-slot>

    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.faq-types.store') }}" method="POST">
                            <div class="card-body">
                                @csrf

                                @foreach(config('constants.languages') as $shortCode => $language)
                                    <fieldset class="language-fieldset language-fieldset-{{ $shortCode }}">
                                        <legend>{{ $language }}</legend>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="name-{{ $shortCode }}">Name</label>
                                                    <input type="text" name="name[{{ $shortCode }}]" id="name-{{ $shortCode }}" class="form-control @error('name.' . $shortCode) is-invalid @enderror" placeholder="Name" value="{{ old('name.' . $shortCode) }}" required autofocus>
                                                    @error('name.' . $shortCode)
                                                    <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <hr>
                                @endforeach
                            </div>
                            <div class="card-footer">
                                <div class="row py-2">
                                    <div class="col-md-12">
                                        <x-submit-button class="mr-4">
                                            {{ __('Submit') }}
                                        </x-submit-button>
                                        <a href="{{ route('admin.faq-types.index') }}">
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
