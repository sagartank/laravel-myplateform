<x-app-admin-layout>
    @section('pageTitle', 'Marketing FAQ Types Edit')
    @section('custom_style')
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Edit FAQ Type') }}
        </x-header>
    </x-slot>

    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.faq-types.update', $faqType) }}" method="POST">
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                @foreach(config('constants.languages') as $shortCode => $language)
                                    <fieldset class="language-fieldset language-fieldset-{{ $shortCode }}">
                                        <legend>{{ $language }}</legend>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="name-{{ $shortCode }}">Name</label>
                                                    <input type="text" name="name[{{ $shortCode }}]" id="name-{{ $shortCode }}" class="form-control @error('name.' . $shortCode) is-invalid @enderror" placeholder="Name" value="{{ old('name.' . $shortCode, $faqType->getTranslation('name', $shortCode)) }}" required autofocus>
                                                    @error('name.' . $shortCode)
                                                    <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <hr>
                                @endforeach

                                <fieldset>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" id="is-active" type="checkbox" name="is_active" value="1" @if($faqType->is_active) checked @endif>
                                                    <label class="form-check-label" for="is-active">Is Active ?</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
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
