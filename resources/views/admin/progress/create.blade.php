<x-app-admin-layout>
    @section('pageTitle', 'Progress Add')
@section('custom_style')
@endsection

    <x-slot name="header">
        <x-header>
            {{ __('Create Progress') }}
            <x-slot name="right">
                <a href="{{ route('admin.progress.index') }}">
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
                        <form action="{{ route('admin.progress.store') }}" method="POST">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group mb-4">
                                            <label class="form-label" for="title">{{ __('Select Step Type')}}</label>
                                            <select name="step_type" id="step_type" class="form-control @error('step_type') is-invalid @enderror" >
                                                <option value="Buyer">{{ __('Buyer')}}</option>
                                                <option value="Seller">{{ __('Seller')}}</option>
                                            </select>
                                            @error('step_type')
                                            <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="title_en">Title (EN)</label>
                                            <input type="text" name="title_en" id="title_en" class="form-control @error('title') is-invalid @enderror"  placeholder="Title (EN)" value="{{ old('title') }}" required autofocus>
                                            @error('title_en')
                                            <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="title_es">Title (ES)</label>
                                            <input type="text" name="title_es" id="title_es" class="form-control @error('title') is-invalid @enderror"  placeholder="Title (ES)" value="{{ old('title') }}" required autofocus>
                                            @error('title_es')
                                            <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="description">{{ __('Description')}}</label>
                                            <textarea type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Description">{{ old('description') }}</textarea>
                                            @error('description')
                                            <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="file_upload_y">{{ __('Is File Upload') }}</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="file_upload" id="file_upload_y" value="Yes">
                                                <label class="form-check-label" for="file_upload_y">{{ __('Yes')}}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="file_upload" id="file_upload_n" value="No" checked>
                                                <label class="form-check-label" for="file_upload_n">{{ __('No') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="cashed_y">{{ __('Cashed') }}</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="cashed" id="cashed_y" value="Yes">
                                                <label class="form-check-label" for="cashed_y">{{ __('Yes') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="cashed" id="cashed_n" value="No" checked>
                                                <label class="form-check-label" for="cashed_n">{{ __('No') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="qr_code_y">{{ __('QrCode') }}</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="qr_code" id="qr_code_y" value="Yes">
                                                <label class="form-check-label" for="qr_code_y">{{ __('Yes') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="qr_code" id="qr_code_n" value="No" checked>
                                                <label class="form-check-label" for="qr_code_n">{{ __('No') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="rate_y">{{ __('Rate') }}</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="rate" id="rate_y" value="Yes">
                                                <label class="form-check-label" for="rate_y">{{ __('Yes') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="rate" id="rate_n" value="No" checked>
                                                <label class="form-check-label" for="rate_n">{{ __('No') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mt-4" >
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="payment_y">{{ __('Payment') }}</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="payment" id="payment_y" value="Yes">
                                                    <label class="form-check-label" for="payment_y">{{ __('Yes') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="payment" id="payment_n" value="No" checked>
                                                    <label class="form-check-label" for="payment_n">{{ __('No') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="order_position">{{ __('Order Position') }}</label>
                                                <input type="number" name="order_position" id="order_position" class="form-control @error('order_position') is-invalid @enderror" placeholder="Number" value="{{ old('order_position') }}" autofocus>
                                                @error('order_position')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3 mt-2">
                                            <label class="form-label" for="mcpn">{{ __('Mipo Commission Payment') }}</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="mipo_commission_payment" id="mcpn" value="No">
                                                <label class="form-check-label" for="mcpn">{{ __('No') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="mipo_commission_payment" id="mcpy" value="Yes" >
                                                <label class="form-check-label" for="mcpy">{{ __('Yes') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3 mt-2">
                                            <label class="form-label" for="mts">{{ __('Manual Trigger') }}</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="manual_trigger" id="mts" value="Self">
                                                <label class="form-check-label" for="mts">{{ __('Self') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="manual_trigger" id="mtu" value="User" >
                                                <label class="form-check-label" for="mtu">{{ __('User') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="manual_trigger" id="mta" value="Admin" >
                                                <label class="form-check-label" for="mta">{{ __('Admin') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="manual_trigger" id="mtn" value="None" checked>
                                                <label class="form-check-label" for="mtn">{{ __('None') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3 mt-2">
                                                <label class="form-label" for="is_active_y">{{ __('Is Active?') }}</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="is_active" id="is_active_y" value="Yes" checked>
                                                    <label class="form-check-label" for="is_active_y">{{ __('Yes') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="is_active" id="is_active_n" value="No">
                                                    <label class="form-check-label" for="is_active_n">{{ __('No') }}</label>
                                                </div>
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
                                        <a href="{{ route('admin.progress.index') }}">
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
