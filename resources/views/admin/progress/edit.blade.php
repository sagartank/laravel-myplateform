<x-app-admin-layout>
    @section('pageTitle', 'Progress Edit')
    @section('custom_style')
    <link href="{{ asset('plugins/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet">
    @endsection
        <x-slot name="header">
            <x-header>
                {{ __('Edit Progress') }}
                <x-slot name="right">
                    <a href="{{ route('admin.progress.index') }}">
                        <button type="button" class="btn btn-sm btn-dark">{{ __('Back' )}}</button>
                    </a>
                </x-slot>
            </x-header>
        </x-slot>
    
        <div class="py-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <form action="{{ route('admin.progress.update', $edit) }}" method="POST">
                                <div class="card-body">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="title">{{ __('Select Step Type') }}</label>
                                                <select name="step_type" id="step_type" class="form-control @error('title') is-invalid @enderror" >
                                                    <option {{ ($edit->step_type == 'Buyer') ?  'selected' : ' '}} value ="Buyer">{{ __('Buyer') }}</option>
                                                    <option {{ ($edit->step_type == 'Seller') ?  'selected' : ' '}} value="Seller">{{ __('Seller') }}</option>
                                                </select>
                                                @error('step_type')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="title_en">Title (EN)</label>
                                                <input type="text" name="title_en" id="title_en" class="form-control @error('title_en') is-invalid @enderror" placeholder="Title (EN)" value="{{ old('title_en', $edit->title_en) }}" required autofocus>
                                                @error('title_en')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="title_es">Title (ES)</label>
                                                <input type="text" name="title_es" id="title_es" class="form-control @error('title_es') is-invalid @enderror" placeholder="Title (ES)" value="{{ old('title_es', $edit->title_es) }}" required autofocus>
                                                @error('title_es')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="description">{{ __('Description') }}</label>
                                                <textarea type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Description">{{ old('description', $edit->description) }}</textarea>
                                                @error('description')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="file_upload_y">{{ __('Is File Upload') }}</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" {{ ($edit->file_upload == 'Yes') ? 'checked' :''}} name="file_upload" id="file_upload_y" value="Yes">
                                                    <label class="form-check-label" for="file_upload_y">{{ __('Yes') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" {{ ($edit->file_upload == 'No') ? 'checked' :''}} name="file_upload" id="file_upload_n" value="No">
                                                    <label class="form-check-label" for="file_upload_n">{{ __('No') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="cashed_y">{{ __('Cashed') }}</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" {{ ($edit->cashed == 'Yes') ? 'checked' :''}} name="cashed" id="cashed_y" value="Yes">
                                                    <label class="form-check-label" for="cashed_y">{{ __('Yes') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" {{ ($edit->cashed == 'No') ? 'checked' :''}} name="cashed" id="cashed_n" value="No">
                                                    <label class="form-check-label" for="cashed_n">{{ __('No') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="qr_code_y">{{ __('QrCode') }}</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" {{ ($edit->qr_code == 'Yes') ? 'checked' :''}} name="qr_code" id="qr_code_y" value="Yes">
                                                    <label class="form-check-label" for="qr_code_y">{{ __('Yes') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" {{ ($edit->qr_code == 'No') ? 'checked' : ''}} name="qr_code" id="qr_code_n" value="No">
                                                    <label class="form-check-label" for="qr_code_n">{{ __('No') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="rate_y">{{ __('Rate') }}</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" {{ ($edit->rate == 'Yes') ? 'checked' :''}} name="rate" id="rate_y" value="Yes">
                                                    <label class="form-check-label" for="rate_y">{{ __('Yes') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" {{ ($edit->rate == 'No') ? 'checked' :''}}  name="rate" id="rate_n" value="No">
                                                    <label class="form-check-label" for="rate_n">{{ __('No') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group mb-3" title="{{ __('Buyer To Seller') }}">
                                                    <label class="form-label" for="payment_y">{{ __('Payment') }}</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input"  {{ ($edit->payment == 'Yes') ? 'checked' :''}} type="radio" name="payment" id="payment_y" value="Yes">
                                                        <label class="form-check-label" for="payment_y">{{ __('Yes') }}</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input"  {{ ($edit->payment == 'No') ? 'checked' :''}} type="radio" name="payment" id="payment_n" value="No">
                                                        <label class="form-check-label" for="payment_n">{{ __('No') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group mb-3 mt-2" title="{{ __('Buyer') }}">
                                                    <label class="form-label" for="mcpy">{{ __('Mipo Commission Payment') }}</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" {{ ($edit->mipo_commission_payment == 'Yes') ? 'checked' :''}} name="mipo_commission_payment" id="mcpy" value="Yes" >
                                                        <label class="form-check-label" for="mcpy">{{ __('Yes') }}</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" {{ ($edit->mipo_commission_payment == 'No') ? 'checked' :''}} name="mipo_commission_payment" id="mcpn" value="No">
                                                        <label class="form-check-label" for="mcpn">{{ __('No') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="order_position">{{ __('Order Position') }}</label>
                                                    <input type="number" name="order_position" id="order_position" class="form-control @error('order_position') is-invalid @enderror" placeholder="Number" value="{{ old('order_position', $edit->order_position) }}" autofocus>
                                                    @error('order_position')
                                                        <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3 mt-2">
                                                    <label class="form-label" for="mts">{{ __('Manual Trigger') }}</label>
                                                {{--  <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" {{ ($edit->manual_trigger == 'Self') ? 'checked' :''}} name="manual_trigger" id="mts" value="Self">
                                                        <label class="form-check-label" for="mts">{{ __('Self') }}</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" {{ ($edit->manual_trigger == 'User') ? 'checked' :''}} name="manual_trigger" id="mtu" value="User" >
                                                        <label class="form-check-label" for="mtu">{{ __('User') }}</label>
                                                    </div> --}}
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" {{ ($edit->manual_trigger == 'Admin') ? 'checked' :''}} name="manual_trigger" id="mta" value="Admin" >
                                                        <label class="form-check-label" for="mta">{{ __('Admin') }}</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" {{ ($edit->manual_trigger == 'None') ? 'checked' :''}} name="manual_trigger" id="mtn" value="None" >
                                                        <label class="form-check-label" for="mtn">{{ __('None') }}</label>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="step_links">{{ __('Step Link') }}</label>
                                                    <select class="form-control select2" multiple id="step_links" name="step_links[]">
                                                        <option value="">{{ __('Select Title')}}</option>
                                                    
                                                        @foreach ($progress_steps as $step)
                                                            @php
                                                                $selected = "";
                                                                if( $edit->step_links && in_array($step->id, json_decode($edit->step_links))) {
                                                                    $selected = "selected";
                                                                }
                                                            @endphp
                                                            <option value="{{$step->id}}" {{$selected}} >{{ $step->title_en }}</option>
                                                        @endforeach
                                                        {{--  @if($edit->step_type == 'Seller')
                                                            @if($progress_steps->where('step_type', 'Buyer')->count())
                                                                @foreach ($progress_steps->where('step_type', 'Buyer') as $buyer_step)
                                                                        @php
                                                                            $selected = "";
                                                                            if( $edit->step_links && in_array($buyer_step->id, json_decode($edit->step_links))) {
                                                                                $selected = "selected";
                                                                            }
                                                                        @endphp
                                                                    <option value="{{$buyer_step->id}}" {{$selected}} >{{ $buyer_step->title_en }}</option>
                                                                @endforeach
                                                            @elseif($edit->step_type == 'Buyer')
                                                                @if($progress_steps->where('step_type', 'Seller')->count())
                                                                    @foreach ($progress_steps->where('step_type', 'Seller') as $seller_step)
                                                                        <option value="{{$seller_step->id}}">{{ $seller_step->title_en }}</option>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        @endif
                                                        @if($edit->step_type == 'Buyer')
                                                        @if($progress_steps->where('step_type', 'Seller')->count())
                                                            @foreach ($progress_steps->where('step_type', 'Seller') as $seller_step)
                                                                    @php
                                                                        $selected = "";
                                                                        if( $edit->step_links && in_array($seller_step->id, json_decode($edit->step_links))) {
                                                                            $selected = "selected";
                                                                        }
                                                                    @endphp
                                                                <option value="{{$seller_step->id}}" {{$selected}} >{{ $seller_step->title_en }}</option>
                                                            @endforeach
                                                        @elseif($edit->step_type == 'Buyer')
                                                            @if($progress_steps->where('step_type', 'Seller')->count())
                                                                @foreach ($progress_steps->where('step_type', 'Seller') as $buyer_step)
                                                                    <option value="{{$buyer_step->id}}">{{ $seller_step->title_en }}</option>
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    @endif --}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group mb-3 mt-2">
                                                <label class="form-label" for="is_active_y">{{ __('Is Active?') }}</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"  {{ ($edit->is_active == 'Yes') ? 'checked' :''}} name="is_active" id="is_active_y" value="Yes">
                                                    <label class="form-check-label" for="is_active_y">{{ __('Yes') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" {{ ($edit->is_active == 'No') ? 'checked' :''}} name="is_active" id="is_active_n" value="No" >
                                                    <label class="form-check-label" for="is_active_n">{{ __('No') }}</label>
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
    <script src="{{ asset('plugins/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
    <script>
    $(document).ready(function () {
        $(".select2").select2({
            placeholder: "Select"
        });
    });
    </script>
    @endsection
    </x-app-admin-layout>
    