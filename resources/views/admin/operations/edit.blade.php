<x-app-admin-layout>
    @section('pageTitle', 'Operation Edit')
@section('custom_style')
        <link href="{{ asset('plugins/fancybox/fancybox.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('plugins/dropzone/basic.min.css') }}">
@endsection

    <x-slot name="header">
        <x-header>
            {{ __('Edit Operation') }} {{ $edit->operation_type_number }}
            <x-slot name="right">
                <a href="{{ route('admin.operations.index') }}">
                    <button type="button" class="btn btn-sm btn-dark">{{ __('Back') }}</button>
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
                        <form action="{{ route('admin.operations.update', $edit) }}" id="operations" name="operations" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="doc-type-1">{{ __('Type of Document') }}</label>
                                                    @if(config('constants.TYPE_OF_DOCUMENT'))
                                                        @foreach (config('constants.TYPE_OF_DOCUMENT') as $key => $val)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input click-doc-type"  {{ ($edit->operation_type == $val)? "checked" : "" }} type="radio" name="doc_type" id="doc-type-{{$key}}" value="{{$val}}">
                                                            <label class="form-check-label" for="doc-type-{{$key}}">{{ __($key) }}</label>
                                                        </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
        
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="Cash">{{ __('Collection Preference') }}</label>
                                                    @if(config('constants.PREFERRED_MODE'))
                                                        @foreach (config('constants.PREFERRED_MODE') as $key => $val)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" {{ ($edit->preferred_payment_method == $val)? "checked" : "" }} name="preferred_payment_method" id="{{$val}}" value="{{$val}}">
                                                            <label class="form-check-label" for="{{$val}}">{{ __($key) }}</label>
                                                        </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
        
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="preferred_currency">{!! __('Dollars or Guarani') !!}</label>
                                                    @if(config('constants.CURRENCY_TYPE'))
                                                        @foreach (config('constants.CURRENCY_TYPE') as $key => $val)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" {{ ($edit->preferred_currency== $val)? "checked" : "" }} name="preferred_currency" id="{{$val}}" value="{{$val}}">
                                                            <label class="form-check-label" for="{{$val}}">{{($val)}}</label>
                                                        </div>
                                                        @endforeach 
                                                    @endif
                                                </div>
                                            </div>
        
                                            <div class="col-md-12 div-goverment-document">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="Yes">{{ __('Is It a Goverment Document ?') }}</label>
                                                    @if(config('constants.IS_GOVERMENT_DOCUMENT'))
                                                        @foreach (config('constants.IS_GOVERMENT_DOCUMENT') as $key => $val)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" {{ ($edit->is_government_contract== $val)? "checked" : "" }} name="is_government_contract" id="{{$val}}" value="{{$val}}">
                                                            <label class="form-check-label" for="{{$val}}">{{ __($val)}}</label>
                                                        </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="With">{!! __('With or Without Recurso') !!}</label>
                                                    @if(config('constants.RESPONSIBILITY'))
                                                        @foreach (config('constants.RESPONSIBILITY') as $key => $val)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" {{ ($edit->responsibility == $val)? "checked" : "" }} name="responsibility" id="{{$val}}" value="{{$val}}">
                                                            <label class="form-check-label" for="{{$val}}">{{ __($val) }}</label>
                                                        </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
        
                                            <div class="col-md-12 div-invoice">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="invoice_type">{{ __('Invoice Type') }}</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" {{ ($edit->invoice_type=="Product")? "checked" : "" }} name="invoice_type" id="product" value="Product">
                                                        <label class="form-check-label" for="product">{{ __('Product') }}</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" {{ ($edit->invoice_type=="Service")? "checked" : "" }} name="invoice_type" id="service" value="Service">
                                                        <label class="form-check-label" for="service">{{ __('Service') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @permission('operation-status-update')
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="operations_status">{{ __('Operation Status') }}</label>
                                            <select  required name="operations_status" id="operations_status" class="form-control">
                                                @if(config('constants.OPERATION_STATUS'))
                                                    @foreach (config('constants.OPERATION_STATUS') as $key => $status)
                                                        <option {{ ($edit->operations_status == $status) ? 'selected' : '' }} value="{{$status }}">{{ __($status) }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    @endpermission
                                    <div class="col-md-6 div-title">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="contract_title">{{ __('Title') }}</label>
                                            <input type="text" name="contract_title" id="contract_title" class="form-control @error('contract_title') is-invalid @enderror" placeholder="{{ __('Title') }}" value="{{ old('title', $edit->contract_title) }}"  >
                                            @error('contract_title')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 div-description">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="description">{{ __('Description') }}</label>
                                            <input type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="{{ __('Description') }}" value="{{ old('description', $edit->description ?? '') }}" >
                                            @error('description')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="seller_id">{{ __('Seller Name') }}</label>
                                            <input type="text" name="seller_id" id="seller_id" class="form-control @error('seller_id') is-invalid @enderror" placeholder="Seller Name" readonly disabled value="{{ old('seller_id', $edit->seller->name) }}">
                                            @error('seller_id')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="issuer_id">{{ __('Payer') }}</label>
                                            <select class="form-control" name="issuer_id" id="issuer_id" required>
                                                <option value="">{{ __('Select Payer')}}</option>
                                                @foreach($issuers as $issuer)
                                                    <option value="{{ $issuer->id }}" {{ ($edit->issuer_id == $issuer->id) ? 'selected' : ''}} >{{ $issuer->company_name .' '. $issuer->ruc_text_id }}</option>
                                                @endforeach    
                                            </select>
                                            @error('issuer_id')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                            <datalist id="issuers">
                                                @foreach($issuers as $issuer)
                                                    <option value="{{ $issuer->company_name }}">
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="form-label" for="amount">{!! __('Nominal Value Document') !!}</label>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" name="amount" id="amount" class="form-control  op_amount evt_validate_decimal @error('amount') is-invalid @enderror" placeholder="{{ __('Amount') }}" value="{{ old('amount', $edit->amount) }}"  >
                                                    @error('amount')
                                                        <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" name="amount_txt" readonly id="amount_txt" disabled class="form-control evt_validate_decimal @error('amount') is-invalid @enderror" placeholder="{{ __('Amount') }}" value="{{ old('amount', $edit->amount) }}"  >
                                                    @error('amount')
                                                        <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="form-label" for="amount_requested">{!! __('Minimum amount willing to sell check') !!}</label>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" name="amount_requested" id="amount_requested" class="form-control op_amount_req evt_validate_decimal @error('amount_requested') is-invalid @enderror" placeholder="Amount Requested" value="{{ old('amount_requested', $edit->amount_requested) }}" >
                                                    @error('amount_requested')
                                                        <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            <div class="form-group mb-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" {{ ($edit->accept_below_requested=="1")? "checked" : "" }} name="accept_below_requested" id="accept_below_requested" value="1">
                                                    <label class="form-check-label" for="accept_below_requested"> {!! __('Accept offers below my minimum amount') !!}</label>
                                                </div>
                                            </div>
                                            <label class="form-label" for="accept_below_requested"></label>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <input type="text" name="amount_requested_txt" readonly id="amount_requested_txt" disabled class="form-control evt_validate_decimal @error('amount_requested') is-invalid @enderror" placeholder="Amount Requested" value="{{ old('amount_requested', $edit->amount_requested) }}" >
                                                @error('amount_requested')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="issuance_date">{{ __('Date of issue') }}</label>
                                            <input type="date" name="issuance_date" id="issuance_date" class="form-control @error('issuance_date') is-invalid @enderror" placeholder="" value="{{ old('issuance_date', $edit->issuance_date) }}"  >
                                            @error('issuance_date')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    @php
                                        $expiration_date  = '';
                                        if($edit->expiration_date !='' && $edit->extra_expiration_days !='') {
                                            $expiration_date = \Carbon\Carbon::createFromFormat('Y-m-d', $edit->expiration_date)->subDays($edit->extra_expiration_days)->format('Y-m-d');
                                        } else if($edit->expiration_date!='') {
                                            $expiration_date = $edit->expiration_date;
                                        }
                                    @endphp
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="expiration_date">{{ __('Due date') }}</label>
                                            <input type="date" name="expiration_date" id="expiration_date" class="form-control @error('expiration_date') is-invalid @enderror" placeholder="" value="{{ old('expiration_date', $edit->expiration_date) }}" >
                                            @error('expiration_date')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3" id="evt_auto_expire">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" id="auto_expire" {{ ($edit->auto_expire=="1")? "checked" : "" }} type="checkbox" name="auto_expire" value="1">
                                                <label class="form-check-label" for="auto_expire">{{ __('Automatic expiration') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="expiration-add-day-row-box">
                                        <div class="form-group mb-3">
                                            <label class="form-check-label" for="extra_expiration_days">{{ __('Add Extra Days')}}</label>
                                            <input type="number" readonly value="{{ $edit->extra_expiration_days }}" class="form-control" id="extra_expiration_days" name="extra_expiration_days" list="suggestions_expiration_add_days">
                                            @if(config('constants.OPERATION_EXTRA_EXPIRE_DAYS'))
                                                @foreach (config('constants.OPERATION_EXTRA_EXPIRE_DAYS') as $key => $day)
                                                    <span role="button" title="{{ __('Add Extra Days')}}" class="badge badge-dark text-dark evt_click_extra_expiration_days">{{$day}}</span>
                                                @endforeach
                                            @endif
                                            @error('extra_expiration_days')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                   {{--  <div class="col-md-6 div-issuer-company-type">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="issuer_company_type">{{ __('Type of company') }}</label>
                                            <select class="form-select" name="issuer_company_type" id="issuer_company_type">
                                                <option value="">{{ __('Select Company') }}</option>
                                                @if($companies)
                                                    @foreach ($companies as $key => $val)
                                                    <option {{($edit->issuer_company_type == $val->name) ? 'selected' : ''}} value="{{ $val->name }}">{{ $val->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('issuer_company_type')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6 div-invoice">
                                        <div class="form-group mb-3 ">
                                            <label class="form-label" for="invoice_number">{{ __('Invoice Number') }}</label>
                                            <input type="text" name="invoice_number" id="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror" placeholder="Invoice No." value="{{ old('invoice_number', $edit->invoice_number) }}"  >
                                            @error('invoice_number')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    {{--  <div class="col-md-6 div-invoice">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="tax_id">{{ __('Tax ID') }}</label>
                                            <input type="text" name="tax_id" id="tax_id" class="form-control @error('tax_id') is-invalid @enderror" placeholder="Tax ID" value="{{ old('tax_id', $edit->tax_id) }}" >
                                            @error('tax_id')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6" id="timbrado-row-box">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="timbrado">{{ __('Timbrado') }}</label>
                                            <input type="text" name="timbrado" id="timbrado" class="form-control @error('timbrado') is-invalid @enderror" placeholder="Timbrado" value="{{ old('timbrado', $edit->timbrado) }}" >
                                            @error('timbrado')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="authorized_personnel">{{ __('Authorized Personnel') }}</label>
                                            <input type="text" name="authorized_personnel" id="authorized_personnel" class="form-control @error('authorized_personnel') is-invalid @enderror" placeholder="Authorized personnel" value="{{ old('authorized_personnel', $edit->authorized_personnel) }}" >
                                            @error('authorized_personnel')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div> --}}
                                    {{--  <div class="col-md-6 div-signature">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="authorized_personnel_signature">{{ __('Signature: Upload a Picture') }}</label>
                                            <input type="file" name="authorized_personnel_signature" id="authorized_personnel_signature" class="form-control @error('authorized_personnel_signature') is-invalid @enderror" placeholder="">
                                            @error('authorized_personnel_signature')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                            @if($edit->authorized_personnel_signature!='')
                                            <div class="col-sm-2">
                                                <img src="{{ $edit->authorized_personnel_signature ? route('secure-image', Crypt::encryptString($edit->authorized_personnel_signature)) : '#' }}" alt="ID Proof" class="img-fluid img-thumbnail rounded mt-2" id="id-proof" data-fancybox>
                                            </div>
                                                @endif
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6" id="paying-bank-row-box">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="issuer_bank">{{ __('Paying Bank') }}</label>
                                            {{-- <input type="text" name="issuer_bank" id="issuer_bank" class="form-control @error('issuer_bank') is-invalid @enderror" placeholder="Paying Bank" value="{{ old('issuer_bank', $edit->issuer_bank?->name) }}" list="issuer-banks"> --}}
                                            <select class="form-control" name="issuer_bank" id="issuer-bank" >
                                                <option value="">{{ __('Select Issure Bank')}}</option>
                                                @foreach($issuerBanks as $issuerBank)
                                                    <option value="{{ $issuerBank->id }}" {{ ($edit->issuer_bank_id == $issuerBank->id) ? 'selected' : ''}} >{{ $issuerBank->name }}</option>
                                                @endforeach    
                                            </select>
                                            @error('issuer_bank')
                                            <x-error-alert :message="$message" />
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 div-check-number">
                                            <label class="form-label" for="cheque_number">{{ __('Cheque Number') }}</label>
                                            <input type="text" name="cheque_number" id="cheque_number" class="form-control @error('cheque_number') is-invalid @enderror" placeholder="Cheque Number" value="{{ old('cheque_number', $edit->check_number) }}" >
                                            @error('cheque_number')
                                                <x-error-alert :message="$message" />
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row" id="contract-number-row-box">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="contract_number">{!! __('Contract number') !!}</label>
                                                <input type="text" name="contract_number" id="contract_number" class="form-control @error('contract_number') is-invalid @enderror"  value="{{ old('contract_number', $edit->contract_number) }}" >
                                                @error('stamp_expircontract_numberation')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="stamp-expiration-row-box">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="stamp_expiration">{{ __('Stamp Expiration') }}</label>
                                                <input type="date" name="stamp_expiration" id="stamp_expiration" class="form-control @error('stamp_expiration') is-invalid @enderror"  value="{{ old('stamp_expiration', $edit->stamp_expiration) }}" >
                                                @error('stamp_expiration')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="legal_direction">{{ __('Legal direction') }}</label>
                                                <input type="text" name="legal_direction" id="legal_direction" class="form-control @error('legal_direction') is-invalid @enderror"  value="{{ old('legal_direction', $edit->legal_direction) }}" >
                                                @error('legal_direction')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="legal_telephone">{{ __('Legal Telephone') }}</label>
                                                <input type="number" name="legal_telephone" id="legal_telephone" class="form-control @error('legal_telephone') is-invalid @enderror"  value="{{ old('legal_telephone', $edit->legal_telephone) }}" >
                                                @error('legal_telephone')
                                                    <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <fieldset>
                                        <hr>
                                        <legend>{{ __('Mipo') }}</legend>
                                        <div class="row">
                                            <div class="col-md-4 mt-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="mipo_verified_y">{{ __('Mipo+ Verified') }}</label>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" {{ ($edit->mipo_verified== 'Yes')? "checked" : "" }} name="mipo_verified" id="mipo_verified_y" value="Yes">
                                                            <label class="form-check-label" for="mipo_verified_y">{{ __('Yes') }}</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" {{ ($edit->mipo_verified == 'No')? "checked" : "" }} name="mipo_verified" id="mipo_verified_n" value="No">
                                                            <label class="form-check-label" for="mipo_verified_n">{{ __('No') }}</label>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="mipo_comment">{{ __('Mipo Comment') }}</label>
                                                    <textarea class="form-control" id="mipo_comment" name="mipo_comment"> {{ $edit->mipo_comment }}</textarea>
                                                    @error('mipo_comment')
                                                        <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset id="evt_type_of_cheque">
                                        <hr>
                                        <legend>{{ __('Types of Cheque') }}</legend>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="cheque_type">{{ __('Cheque type') }}</label>
                                                    <select name="cheque_type" id="cheque_type" class="form-control">
                                                        <option value="">{{ __('No Visible') }}</option>
                                                        @if(config('constants.CHEQUE_TYPE'))
                                                            @foreach (config('constants.CHEQUE_TYPE') as $key => $val)
                                                                <option {{ ($edit->cheque_type== $val)? "selected" : "" }} value="{{$val}}">{{ __($val) }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="cheque_status">{{ __('Cheque Status') }}</label>
                                                    <select name="cheque_status" id="cheque_status" class="form-control">
                                                        <option value="">{{ __('No Visible') }}</option>
                                                        @if(config('constants.CHEQUE_STATUS'))
                                                            @foreach (config('constants.CHEQUE_STATUS') as $key => $val)
                                                                <option {{ ($edit->cheque_status== $val)? "selected" : "" }} value="{{$val}}">{{ __($val) }}</option>
                                                            @endforeach
                                                        @endif>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="cheque_payee_type">{{ __('Cheque Payee Type') }}</label>
                                                    <select name="cheque_payee_type" id="cheque_payee_type" class="form-control">
                                                        <option value="">{{ __('No Visible') }}</option>
                                                        @if(config('constants.CHEQUE_PAYEE_TYPE'))
                                                            @foreach (config('constants.CHEQUE_PAYEE_TYPE') as $key => $val)
                                                                <option {{ ($edit->cheque_payee_type== $val)? "selected" : "" }} value="{{$val}}">{{ __($val) }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <hr>
                                        <legend>{{ __('Types of Process') }}</legend>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="bcp">{{ __('BCP') }} {{ __('Status') }}</label>
                                                    <select name="bcp" id="bcp" class="form-control">
                                                        <option value="0">{{ __('N/A') }}</option>
                                                        <option {{ ($edit->bcp=="1")? "selected" : "" }} value="1">{{ __('Yes') }}</option>
                                                        <option {{ ($edit->bcp=="2")? "selected" : "" }} value="2">{{ __('No') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="inforconf">{{ __('Inforconf') }} {{ __('Status') }}</label>
                                                    <select name="inforconf" id="inforconf" class="form-control">
                                                        <option value="0">{{ __('N/A') }}</option>
                                                        <option {{ ($edit->inforconf=="1")? "selected" : "" }} value="1">{{ __('Yes') }}</option>
                                                        <option {{ ($edit->inforconf=="2")? "selected" : "" }}  value="2">{{ __('No') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="infocheck">{{ __('Infocheck') }} {{ __('Status') }}</label>
                                                    <select name="infocheck" id="infocheck" class="form-control">
                                                        <option value="0">{{ __('N/A') }}</option>
                                                        <option {{ ($edit->infocheck=="1")? "selected" : "" }} value="1">{{ __('Yes') }}</option>
                                                        <option {{ ($edit->infocheck=="2")? "selected" : "" }} value="2">{{ __('No') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="criterium">{{ __('Criterium') }} {{ __('Status') }}</label>
                                                    <select name="criterium" id="criterium" class="form-control">
                                                        <option value="0">{{ __('N/A') }}</option>
                                                        <option {{ ($edit->criterium=="1")? "selected" : "" }} value="1">{{ __('Yes') }}</option>
                                                        <option {{ ($edit->criterium=="2")? "selected" : "" }} value="2">{{ __('No') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <input type="file" name="bcp_file" id="bcp_file" title="{{ __('upload pdf file')}}" class="form-control @error('bcp_file') is-invalid @enderror">
                                                </div>
                                                @if(isset($edit->operations_process_status_file) && !empty($edit->operations_process_status_file->bcp_file))
                                                <div class="form-check form-check-inline div-remove-image">
                                                    <a href="{{route('secure-pdf', Crypt::encryptString($edit->operations_process_status_file->bcp_file))}}" target="_blank">
                                                        <img width="100" src="{{ asset('images/mipo/pdf.png') }}" alt="document" class="img-fluid img-thumbnail rounded mt-2">
                                                    </a>
                                                    <img role="button" class="center-block d-block mx-auto delete-image pt-2" data-href="{{route('admin.operations.ajax-delete-process-status-file', [$edit->operations_process_status_file->id, 'bcp'])}}" title="Delete" src="{{ asset('/images/delete-icon.svg') }}"/>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <input type="file" name="inforconf_file" id="inforconf_file" title="{{ __('upload pdf file')}}" class="form-control @error('inforconf_file') is-invalid @enderror">
                                                </div>
                                                @if(isset($edit->operations_process_status_file) && !empty($edit->operations_process_status_file->inforconf_file))
                                                <div class="form-check form-check-inline div-remove-image">
                                                    <a href="{{route('secure-pdf', Crypt::encryptString($edit->operations_process_status_file->inforconf_file))}}" target="_blank">
                                                        <img width="100" src="{{ asset('images/mipo/pdf.png') }}" alt="document" class="img-fluid img-thumbnail rounded mt-2">
                                                    </a>
                                                    <img role="button" class="center-block d-block mx-auto delete-image pt-2" data-href="{{route('admin.operations.ajax-delete-process-status-file', [$edit->operations_process_status_file->id, 'inforconf'])}}" title="Delete" src="{{ asset('/images/delete-icon.svg') }}"/>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <input type="file" name="infocheck_file" id="infocheck_file" title="{{ __('upload pdf file')}}" class="form-control @error('infocheck_file') is-invalid @enderror">
                                                </div>
                                                @if(isset($edit->operations_process_status_file) && !empty($edit->operations_process_status_file->infocheck_file))
                                                <div class="form-check form-check-inline div-remove-image">
                                                    <a href="{{route('secure-pdf', Crypt::encryptString($edit->operations_process_status_file->infocheck_file))}}" target="_blank">
                                                        <img width="100" src="{{ asset('images/mipo/pdf.png') }}" alt="document" class="img-fluid img-thumbnail rounded mt-2">
                                                    </a>
                                                    <img role="button" class="center-block d-block mx-auto delete-image pt-2" data-href="{{route('admin.operations.ajax-delete-process-status-file', [$edit->operations_process_status_file->id, 'infocheck'])}}" title="Delete" src="{{ asset('/images/delete-icon.svg') }}"/>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-3">
                                                    <input type="file" name="criterium_file" id="criterium_file" title="{{ __('upload pdf file')}}" class="form-control @error('criterium_file') is-invalid @enderror">
                                                </div>
                                                @if(isset($edit->operations_process_status_file) && !empty($edit->operations_process_status_file->criterium_file))
                                                <div class="form-check form-check-inline div-remove-image">
                                                    <a href="{{route('secure-pdf', Crypt::encryptString($edit->operations_process_status_file->criterium_file))}}" target="_blank">
                                                        <img width="100" src="{{ asset('images/mipo/pdf.png') }}" alt="document" class="img-fluid img-thumbnail rounded mt-2">
                                                    </a>
                                                    <img role="button" class="center-block d-block mx-auto delete-image pt-2" data-href="{{route('admin.operations.ajax-delete-process-status-file', [$edit->operations_process_status_file->id, 'criterium'])}}" title="Delete" src="{{ asset('/images/delete-icon.svg') }}"/>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <hr>
                                        <legend>{{ __('Documents / Attachments') }}</legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="upload_picture">{{ __('Upload Documents') }}</label>
                                                    <input type="file" name="upload_picture[]" id="upload_picture" multiple class="form-control @error('upload_picture') is-invalid @enderror" placeholder="">
                                                    @error('upload_picture')
                                                        <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="supporting_attachments">{{ __('Supporting Attachments') }}</label>
                                                    <input type="file" name="supporting_attachment[]" id="supporting_attachments" multiple class="form-control @error('supporting_attachments') is-invalid @enderror" placeholder="">
                                                    @error('supporting_attachments')
                                                        <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    @if(isset($edit->documents) && $edit->documents->count() > 0)
                                                        @foreach ($edit->documents as $val)
                                                            @if($val->path!='')
                                                                @php
                                                                    $file_ext = strtolower(pathinfo($val->path, PATHINFO_EXTENSION));
                                                                @endphp
                                                                @if($file_ext == 'pdf' && $val->path!='')
                                                                    <div class="form-check form-check-inline div-remove-image">
                                                                        <a href="{{ $val->path ? route('secure-pdf', Crypt::encryptString($val->path)) : '#' }}" target="_blank">
                                                                            <img width="100" src="{{ asset('images/mipo/pdf.png') }}" alt="document" class="img-fluid img-thumbnail rounded mt-2">
                                                                        </a>
                                                                        <img role="button" class="center-block d-block mx-auto delete-image pt-2" data-href="{{route('admin.operations.ajax-delete-document', $val->slug)}}" title="Delete" src="{{ asset('/images/delete-icon.svg') }}"/>
                                                                    </div>
                                                                @else
                                                                    <div class="form-check form-check-inline div-remove-image">
                                                                        <img width="100" src="{{ $val->path ? route('secure-image', Crypt::encryptString($val->path)) : '#' }}" alt="document" class="img-fluid img-thumbnail rounded mt-2" id="document" data-fancybox>
                                                                        <img role="button" class="center-block d-block mx-auto delete-image pt-2" data-href="{{route('admin.operations.ajax-delete-document', $val->slug)}}" title="Delete" src="{{ asset('/images/delete-icon.svg') }}"/>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    @if(isset($edit->supportingAttachments) && $edit->supportingAttachments->count() > 0)
                                                        @foreach ($edit->supportingAttachments as $val)
                                                            @if($val->path!='')
                                                                @php
                                                                    $file_ext = strtolower(pathinfo($val->path, PATHINFO_EXTENSION));
                                                                @endphp
                                                                @if($file_ext == 'pdf' && $val->path!='')
                                                                    <div class="form-check form-check-inline div-remove-image">
                                                                        <a href="{{ $val->path ? route('secure-pdf', Crypt::encryptString($val->path)) : '#' }}" target="_blank">
                                                                            <img width="100" src="{{ asset('images/mipo/pdf.png') }}" alt="document" class="img-fluid img-thumbnail rounded mt-2">
                                                                        </a>
                                                                        <img role="button" class="center-block d-block mx-auto delete-image pt-2" data-href="{{route('admin.operations.ajax-delete-attachments', $val->slug)}}" title="Delete" src="{{ asset('/images/delete-icon.svg') }}"/>
                                                                    </div>
                                                                @else
                                                                    <div class="form-check form-check-inline div-remove-image">
                                                                        <img width="100" src="{{ $val->path ? route('secure-image', Crypt::encryptString($val->path)) : '#' }}" alt="supportingAttachment" class="img-fluid img-thumbnail rounded mt-2" id="supportingAttachment" data-fancybox>
                                                                        <img  role="button" class="center-block d-block mx-auto delete-image pt-2" data-href="{{route('admin.operations.ajax-delete-attachments', $val->slug)}}" title="Delete" src="{{ asset('/images/delete-icon.svg') }}"/>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <hr>
                                        <legend>{{ __('Commercial References (Optional)') }}</legend>
                                        <div class="col-md-12">
                                            <div class="repeater" id="reference-repeater">
                                                <div data-repeater-list="references">
                                                    @if(isset($edit->references) && $edit->references->count() > 0)
                                                        @foreach($edit->references as $val)
                                                            <div data-repeater-item>
                                                                <div class="row align-items-center mb-4" >
                                                                    <input type="hidden" name="id" value="{{ $val->id }}">
                                                                    <div class="col-md-1">
                                                                        <img data-repeater-delete title="Delete" src="{{ asset('/images/delete-icon.svg') }}" alt="delete" role="button">
                                                                    </div>
                                                                    <div class="col-md">
                                                                        <input type="text" value="{{$val->name}}" name="name" class="form-control" placeholder="{{ __('Commercial Name') }}">
                                                                    </div>
                                                                    <div class="col-md">
                                                                        <input type="text" value="{{$val->company_name}}" name="company_name" class="form-control" placeholder="{{ __('Company Name') }}">
                                                                    </div>
                                                                    <div class="col-md">
                                                                        <input type="text" value="{{$val->phone_number}}" name="phone_number" class="form-control" placeholder="{{ __('Phone Number') }}">
                                                                    </div>
                                                                    <div class="col-md">
                                                                        <input type="email" value="{{$val->email}}" name="email" class="form-control" placeholder="{{ __('Email Address') }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        @else
                                                        <div data-repeater-item>
                                                            <div class="row align-items-center mb-4" >
                                                                <input type="hidden" name="id" value="">
                                                                <div class="col-md-1">
                                                                    <img data-repeater-delete title="Delete" src="{{ asset('/images/delete-icon.svg') }}" alt="mipio" role="button">
                                                                </div>
                                                                <div class="col-md">
                                                                    <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}">
                                                                </div>
                                                                <div class="col-md">
                                                                    <input type="text" name="company_name" class="form-control" placeholder="{{ __('Company Name') }}">
                                                                </div>
                                                                <div class="col-md">
                                                                    <input type="text" name="phone_number" class="form-control" placeholder="{{ __('Phone Number') }}">
                                                                </div>
                                                                <div class="col-md">
                                                                    <input type="email" name="email" class="form-control" placeholder="{{ __('Email Address') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <img data-repeater-create src="{{ asset('/images/plus-gray.svg') }}" title="{{ __('Add') }}" role="button">
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="rejection_note_hide_show">
                                        <hr>
                                        <legend>{{ __('Rejection Note') }}</legend>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <textarea name="rejection_note" class="form-control" id="rejection_note">{{ $edit->rejection_note }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <hr>
                                        <legend>{{ __('Admin Staff Attachments File') }}</legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    {{-- <label class="form-label" for="admin_staff_attachments_files">{{ __('Files') }}</label> --}}
                                                    <input type="file" name="admin_staff_attachments_files[]" id="admin_staff_attachments_files" multiple class="form-control @error('admin_staff_attachments_files') is-invalid @enderror">
                                                    @error('admin_staff_attachments_files')
                                                        <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    @if(isset($edit->operations_admin_staff_file) && $edit->operations_admin_staff_file->count() > 0)
                                                        @foreach ($edit->operations_admin_staff_file as $val)
                                                            @if($val->path!='')
                                                                @php
                                                                    $file_ext = strtolower(pathinfo($val->path, PATHINFO_EXTENSION));
                                                                @endphp
                                                                @if($file_ext == 'pdf' && $val->path!='')
                                                                    <div class="form-check form-check-inline div-remove-image">
                                                                        <a href="{{ $val->path ? route('secure-pdf', Crypt::encryptString($val->path)) : '#' }}" target="_blank">
                                                                            <img width="100" src="{{ asset('images/mipo/pdf.png') }}" alt="document" class="img-fluid img-thumbnail rounded mt-2">
                                                                        </a>
                                                                        <img role="button" class="center-block d-block mx-auto delete-image pt-2" data-href="{{route('admin.operations.ajax-delete-admin-staff-attachments-file', $val->id)}}" title="Delete" src="{{ asset('/images/delete-icon.svg') }}"/>
                                                                    </div>
                                                                @else
                                                                    <div class="form-check form-check-inline div-remove-image">
                                                                        <img width="100" src="{{ $val->path ? route('secure-image', Crypt::encryptString($val->path)) : '#' }}" alt="document" class="img-fluid img-thumbnail rounded mt-2" id="document" data-fancybox>
                                                                        <img role="button" class="center-block d-block mx-auto delete-image pt-2" data-href="{{route('admin.operations.ajax-delete-admin-staff-attachments-file', $val->id)}}" title="Delete" src="{{ asset('/images/delete-icon.svg') }}"/>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row py-2">
                                    <div class="col-md-12">
                                        <x-submit-button class="mr-4">
                                            {{ __('Update') }}
                                        </x-submit-button>
                                        <a href="{{ route('admin.operations.index') }}">
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
    <script src="{{ asset('plugins/jquery-repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('plugins/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('plugins/fancybox/fancybox.umd.js') }}"></script>
    <script src="{{ asset('plugins/jsvalidation/jsvalidation.min.js') }}"></script>
    <script src="{{ asset('js/jquery.formatCurrency-1.4.0.js') }}"></script>
    <script src="{{ asset('js/jquery.formatCurrency.all.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\OperationEditRequest') !!}
    <script>Dropzone.autoDiscover = false;</script>
    <script>
        $(document).ready(function ($) {
            applyDocTypeChange($('input[name="doc_type"]:checked').val());
            $('.rejection_note_hide_show').hide();
            $('#operations_status').change(function(){
                $('.rejection_note_hide_show').hide();
                var get_val = $(this).val();
                if(get_val == 'Rejected'){
                    $('.rejection_note_hide_show').show();
                }
            }).trigger('change');

            $('.click-doc-type').click(function(e){
                let obj = $(this);
                applyDocTypeChange(obj.val());
            });

            $(document).on('click', '.evt_click_extra_expiration_days', function (e) {
                e.preventDefault();
                if($(this).text()!='') {
                    $('#extra_expiration_days').val($(this).text());
                }
            });
            
            $('.delete-image').click(function(e){
                Swal.fire({
                title: ays_en_msg,
                text: ays_delete_en_msg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#13153B',
                confirmButtonText: yes_delete_en_msg,
                cancelButtonText: cancel_en_msg,
                }).then((result) => {
                    if (result.isConfirmed) {
                        const self = $(this);
                        const url_link = self.attr('data-href');
                        $.ajax({
                            type: 'GET',
                            url: url_link,
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
                                toastr.error(error_something_en_msg);
                                console.log(data);
                            }
                        });
                    }
                });
            });
            
            $('#reference-repeater').repeater({
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    if(confirm(repeater_delete_en_msg)) {
                        $(this).slideUp(deleteElement);
                    }
                },
                isFirstItemUndeletable: false,
            });
            changeCurrency();
        });

        function applyDocTypeChange(val)
        {
            let paying_bank = $('#paying-bank-row-box');
            let stamp_expiration = $('#stamp-expiration-row-box');
            let contract_number = $('#contract-number-row-box');
            let timbrado = $('#timbrado-row-box');

            if(val == 'Contract')
            {
                $('.div-title').show();
                $('.div-title-extra').show();
                $('.div-goverment-document').show();
                $('.div-issuer-company-type').show();
                $('.div-invoice').hide();
                $('.div-description').hide();
                $('.div-signature').show();
                $('.div-check-number').hide();
                $('#expiration-add-day-row-box').show();
                $('#evt_auto_expire').show();
                $('#evt_type_of_cheque').hide();
                timbrado.show();
                paying_bank.hide();
                stamp_expiration.show();
                contract_number.show();
            } else if(val == 'Other') {
                $('.div-description').show();
                $('.div-title').show();
                $('.div-goverment-document').show();
                $('.div-issuer-company-type').show();
                $('.div-title-extra').hide();
                $('.div-invoice').hide();
                $('.div-signature').show();
                $('.div-check-number').hide();
                $('#expiration-add-day-row-box').show();
                $('#evt_auto_expire').show();
                $('#evt_type_of_cheque').hide();
                paying_bank.hide();
                stamp_expiration.hide();
                contract_number.hide();
                timbrado.hide();
            } else if(val == 'Cheque') {
                $('.div-check-number').show();
                $('.div-description').hide();
                $('.div-signature').hide();
                $('.div-title').hide();
                $('.div-title-extra').hide();
                $('.div-goverment-document').hide();
                $('.div-invoice').hide();
                $('.div-issuer-company-type').hide();
                $('#expiration-add-day-row-box').hide();
                $('#evt_auto_expire').hide();
                $('#evt_type_of_cheque').show();
                paying_bank.show();
                stamp_expiration.hide();
                contract_number.hide();
                timbrado.hide();
            } else if(val == 'Invoice') {
                $('.div-invoice').show();
                $('.div-issuer-company-type').show();
                $('.div-signature').show();
                $('.div-check-number').hide();
                $('.div-description').hide();
                $('.div-title-extra').hide();
                $('.div-title').hide();
                $('.div-goverment-document').hide();
                $('#expiration-add-day-row-box').show();
                $('#evt_auto_expire').show();
                $('#evt_type_of_cheque').hide();
                paying_bank.hide();
                stamp_expiration.show();
                contract_number.hide();
                timbrado.show();
            } else {
                $('.div-issuer-company-type').hide();
                $('.div-check-number').hide();
                $('.div-description').hide();
                $('.div-title').hide();
                $('.div-title-extra').hide();
                $('.div-invoice').hide();
                $('.div-goverment-document').hide();
                $('.div-signature').hide();
                $('#expiration-add-day-row-box').hide();
                $('#evt_auto_expire').hide();
                $('#evt_type_of_cheque').hide();
                paying_bank.hide();
                stamp_expiration.hide();
                contract_number.hide();
                timbrado.hide();
            }
        }
    </script>
@endsection
</x-app-admin-layout>
