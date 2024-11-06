<x-app-admin-layout>
    @section('pageTitle', 'User Details')
    @section('custom_style')
        <link href="{{ asset('plugins/fancybox/fancybox.css') }}" rel="stylesheet">
        <style>
            .pac-container {
                z-index:9999;
            }
            #map {
                height: 100%;
                width: 100%;
                margin: 0px;
                padding: 0px
            }
        </style>
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Details User') }}
            <x-slot name="right">
                <a href="{{ route('admin.users.index') }}">
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

                        <div class="card-body">
                        
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-coreui-toggle="pill"
                                        data-coreui-target="#pills-user" type="button" role="tab"
                                        aria-controls="pills-user" aria-selected="true">{{ __('User') }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-coreui-toggle="pill"
                                        data-coreui-target="#pills-operations" type="button" role="tab"
                                        aria-controls="pills-operations" aria-selected="false">{{ __('Operations') }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-coreui-toggle="pill"
                                        data-coreui-target="#pills-deals" type="button" role="tab"
                                        aria-controls="pills-deals" aria-selected="false">{{ __('Deals') }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-coreui-toggle="pill"
                                        data-coreui-target="#pills-mi-coins" type="button" role="tab"
                                        aria-controls="pills-mi-coins" aria-selected="false">{{ __('Mi Coins') }}</button>
                                </li>
                                @if($user->companies->count() == 0)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-coreui-toggle="pill"
                                        data-coreui-target="#pills-add-company" type="button" role="tab"
                                        aria-controls="pills-add-company" aria-selected="false">{{ __('Add Company') }}</button>
                                </li>
                                @endif
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link evt_download_pdf_btn"
                                    data-href="{{ route('admin.users.ajax-kyc-address', [$user->slug, 'user-account-activity']) }}"
                                    data-file-name="{{ $user->slug.time() }}"
                                    data-user-id="{{$user->id}}"
                                    type="button" role="tab"
                                    >{{ __('Export') }}</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-user" role="tabpanel"
                                    aria-labelledby="pills-user-tab" tabindex="0">
                                    <fieldset>
                                        <legend>{{ __('User Details') }}</legend>
                                        <table class="table table-hover">
                                            <tr>
                                                <th>{{ __('User Profile') }}</th>
                                                <td>
                                                    <img role="button" width="100" title="{{ __('User Profile') }}"
                                                        src="{{ $user->profile_image ? route('secure-image', Crypt::encryptString($user->profile_image)) : asset('images/profile-stock.png') }}" data-fancybox>
                                                </td>
                                                <th>{{ __('IPV Image') }}</th>
                                                <td>
                                                    <img role="button" width="100" src="{{ $user->ipv_image ? route('secure-image', Crypt::encryptString($user->ipv_image)) : '#' }}" alt="IPV Image" data-fancybox>
                                                </td>
                                                <th>{{ __('Id Proof') }}</th>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row mb-3">
                                                                @if ($id_proofes)
                                                                    @foreach ($id_proofes as $id_proofe)
                                                                        <div class="col-sm-2 mb-2" role="button"
                                                                            title="{{ __('Id Proof') }}">
                                                                            <img role="button" width="100" src="{{ $id_proofe->id_proof_image_url }}" alt="ID Proof" data-fancybox>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>{{ _($user->is_user_company == '1') ? __('Company Name') : __('First Name') }} </th>
                                                <td>{{ $user->first_name }}</td>
                                                <th>{{ __('Last Name') }}</th>
                                                <td>{{ $user->last_name }}</td>
                                                <th>{{ __('Email Address') }}</th>
                                                <td>{{ $user->email }}</td>
                                                <th>{{ __('Is User Company')}}</th>
                                                <td>{{ _($user->is_user_company == '1') ? __('Yes') : __('No') }}</td>
                                                <th></th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Mobile Number') }}</th>
                                                <td>{{ $user->phone_number }}</td>
                                                <th>{{ ($user->is_user_company == '1') ?  __('Established') : __('Date of Birth')  }}</th>
                                                <td>{{ $user->birth_date }}</td>
                                                <th>{{ __('Marital Status')}}</th>
                                                <td>{{ __($user->marital_status) }}</td>
                                                <th></th>
                                                <td></td>
                                                <th></th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Address') }}</th>
                                                <td>{{ $user->address }}</td>
                                                <th>{{ __('Postal Code') }}</th>
                                                <td>{{ $user->postal_code }}</td>
                                                <th>{{ __('City') }}</th>
                                                <td>{{ $user->city?->name}}</td>
                                                {{-- <th>State</th>
                                                <td>{{ $user->state }}</td>
                                                <th>Country</th>
                                                <td>{{ $user->country?->name }}</td> --}}
                                            </tr>
                                            <tr>
                                                <th>{{ __('Occupation') }}</th>
                                                <td>{{ $user->occupation }}</td>
                                                <th>{{ __('Bio') }}</th>
                                                <td>{{ $user->bio }}</td>
                                                <th></th>
                                                <td></td>
                                                <th></th>
                                                <td></td>
                                                <th></th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Ref By') }} </th>
                                                <td>{{ $user->ref_by?->name}}</td>
                                                <th></th>
                                                <td></td>
                                                <th></th>
                                                <td></td>
                                                <th></th>
                                                <td></td>
                                                <th></th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Is Active') }}? </th>
                                                <td>{{ $user->is_active == '1' ? __('Yes') : __('No') }}</td>
                                                <th>{{ __('Is Registered') }}? </th>
                                                <td>{{ $user->is_registered == '1' ?  __('Yes') :  __('No') }}</td>
                                                <th>{{ __('Register At') }}</th>
                                                <td>{{ $user->registered_at }}</td>
                                                <th></th>
                                                <td></td>
                                                <th></th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Last login Ip') }}</th>
                                                <td>{{ $user->last_login_ip }}</td>
                                                <th>{{ __('Last login At') }}</th>
                                                <td>{{ $user->last_login_at }}</td>
                                                <th></th>
                                                <td></td>
                                                <th></th>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                    <fieldset>
                                        <legend>{{ __('Bank Details') }}</legend>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Payment options') }}</th>
                                                    <th>{{ __('Bank Name') }}</th>
                                                    <th>{{ __('Account Name') }}</th>
                                                    <th>{{ __('Account Number') }}</th>
                                                    <th>{{ __('Phone Number Company') }}</th>
                                                    <th>{{ __('Phone Number') }}</th>
                                                    <th>{{ __('identification Id') }}</th>
                                                    <th>{{ __('Note') }}</th>
                                                    <th>{{ __('Active') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($bank_details)
                                                    <tr>
                                                        <td>{{ __($bank_details->payment_options) }}</td>
                                                        <td>{{ $bank_details->issuer_bank?->name }}</td>
                                                        <td>{{ $bank_details->account_name }}</td>
                                                        <td>{{ $bank_details->account_number }}</td>
                                                        <td>{{ $bank_details->phone_company }}</td>
                                                        <td>{{ $bank_details->phone_number }}</td>
                                                        <td>{{ $bank_details->identification_id }}</td>
                                                        <td>{{ $bank_details->payment_note }}</td>
                                                        <td>{{ __($bank_details->is_active) }}</td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="9" align="center">{{ __('No record found') }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </fieldset>
                                    @if($user->is_user_company == '1')
                                        <fieldset>
                                            <legend>{{ __('User Companies Details')}}</legend>
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
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('Name')}}</th>
                                                        <th>{{ __('Email')}}</th>
                                                        <th>{{ __('Phone number')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($user_companies)
                                                        @foreach ($user_companies as $user_comp)
                                                        <tr>
                                                            <td>{{ $user_comp->name }}</td>
                                                            <td>{{ $user_comp->email }}</td>
                                                            <td>{{ $user_comp->phone }}</td>
                                                        </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="3" align="center">{{ __('No record found') }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </fieldset>
                                    @endif
                                    <fieldset>
                                        <legend>{{ __('User Alert Notifications Details') }}</legend>
                                        <table class="table table-bordered table-hover dt-responsive nowrap">
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
                                                    <tr>
                                                        <td colspan="3" align="center">{{ __('No record found') }}
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </div>
                                <div class="tab-pane fade" id="pills-operations" role="tabpanel"
                                    aria-labelledby="pills-operations-tab" tabindex="0">
                                    <fieldset>
                                        <legend>{{ __('Operations Details') }}</legend>
                                        <table class="table table-bordered table-hover dt-responsive nowrap">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Seller Name') }}</th>
                                                    <th>{{ __('Operation Number') }}</th>
                                                    <th>{{ __('Operation Type') }}</th>
                                                    <th>{{ __('Amount') }}</th>
                                                    <th>{{ __('Currency') }}</th>
                                                    <th>{{ __('Mipo Verified') }}</th>
                                                    <th>{{ __('Status') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($operations->isNotEmpty())
                                                    @foreach ($operations as $val)
                                                        <tr id="row-{{ $val->slug }}">
                                                            <td>{{ $val->seller?->name }}</td>
                                                            <td>{{ $val->operation_number }}</td>
                                                            <td>{{ __($val->operation_type) }}</td>
                                                            <td>{{ app('common')->currencyBySymbol($val->preferred_currency) . '' . app('common')->currencyNumberFormat($val->preferred_currency, $val->amount) }}
                                                            </td>
                                                            <td>{{ $val->preferred_currency }}</td>
                                                            <td>
                                                                <span
                                                                    class="text-white badge text-bg-{{ $val->mipo_verified == 'Yes' ? 'success' : 'danger' }}">{{ __($val->mipo_verified) }}</span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="text-white badge text-bg-{{ app('common')->operationStatusBgcolor($val->operations_status) }}">{{ __($val->operations_status) }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </div>
                                <div class="tab-pane fade" id="pills-deals" role="tabpanel"
                                    aria-labelledby="pills-deals-tab" tabindex="0">
                                    <fieldset>
                                        <legend>{{ __('Deals Details') }}</legend>
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Operation Number') }}</th>
                                                    <th>{{ __('Seller Name') }}</th>
                                                    <th>{{ __('Operation Amount') }}</th>
                                                    <th>{{ __('Buyer Name') }}</th>
                                                    <th>{{ __('Deal Amount') }}</th>
                                                    <th>{{ __('Offer Type') }}</th>
                                                    <th>{{ __('Deal Status') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($deals->isNotEmpty())
                                                    @foreach ($deals as $val)
                                                        @php
                                                            $currency_symbol = app('common')->currencyBySymbol($val->operations?->first()->preferred_currency);
                                                            $operation_amount = app('common')->currencyNumberFormat($val->operations?->first()->preferred_currency, $val->operations?->first()->amount);
                                                            $offer_amount = app('common')->currencyNumberFormat($val->operations?->first()->preferred_currency, $val->amount);
                                                        @endphp
                                                        <tr id="row-{{ $val->slug }}">
                                                            <td>{{ $val->operations?->first()->operation_number ?? '' }}
                                                            </td>
                                                            <td>{{ $val->operations?->first()->seller?->name ?? '' }}
                                                            </td>
                                                            <td>{{ $currency_symbol . '' . $operation_amount }}</td>
                                                            <td>{{ $val->buyer?->name }}</td>
                                                            <td>{{ $currency_symbol . '' . $offer_amount }}</td>
                                                            <td>{{ $val->offer_type }}</td>
                                                            <td>
                                                                @if ($val->offer_status == 'Approved')
                                                                    <span
                                                                        class="text-white badge text-bg-success">{{ __($val->offer_status) }}</span>
                                                                @elseif($val->offer_status == 'Rejected')
                                                                    <span
                                                                        class="text-white badge text-bg-danger">{{ __($val->offer_status) }}</span>
                                                                @elseif($val->offer_status == 'Pending')
                                                                    <span
                                                                        class="text-white badge text-bg-warning">{{ __($val->offer_status) }}</span>
                                                                @elseif($val->offer_status == 'Counter' || $val->offer_status == 'Completed')
                                                                    <span
                                                                        class="text-white badge text-bg-info">{{ __($val->offer_status) }}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="7" align="center">{{ __('No record found') }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </div>
                                <div class="tab-pane fade" id="pills-mi-coins" role="tabpanel" aria-labelledby="pills-mi-coins-tab" tabindex="0">
                                    <fieldset>
                                        <legend>{{ __('Mi Coins')}} </legend>
                                        @if($user->mi_coins_poinst->count())
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th><strong>{{ __('Point') }}</strong></th>
                                                            <th><strong>{{ __('Credit') }}</strong></th>
                                                            <th><strong>{{ __('Withdraw') }}</strong></th>
                                                            <th><strong>{{ __('Title') }}</strong></th>
                                                            <th><strong>{{ __('Date & Time') }}</strong></th>
                                                            <th><strong>{{ __('Created by') }}</strong></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($user->mi_coins_poinst as $point_val)
                                                            <tr>
                                                                <td>{{ $point_val->points }}</td>
                                                                <td>{{ $point_val->credit }}</td>
                                                                <td>{{ $point_val->withdraw }}</td>
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
                                        @endif
                                    </fieldset>
                                </div>
                                @if($user->companies->count() == 0)
                                <div class="tab-pane fade" id="pills-add-company" role="tabpanel" aria-labelledby="pills-mi-coins-tab" tabindex="0">
                                    <fieldset>
                                        <legend>{{ __('Add Company')}} </legend>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <form action="{{ route('admin.users.create-company-account', $user->slug) }}" method="POST" enctype="multipart/form-data">
                                                        <div class="card-body">
                                                            @csrf
                                                            <div class="row">
                                                                {{--     <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label" for="first-name">{{ __('First Name') }}</label>
                                                                            <input type="text" name="first_name" id="first-name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required autofocus>
                                                                            @error('first_name')
                                                                                <x-error-alert :message="$message" />
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label" for="last-name">{{ __('Last Name') }}</label>
                                                                            <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror"  value="{{ old('last_name') }}" required>
                                                                            @error('last_name')
                                                                                <x-error-alert :message="$message" />
                                                                            @enderror
                                                                        </div>
                                                                    </div> --}}
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label" for="company_name">{{ __('Company Name') }}</label>
                                                                            <input type="text" name="company_name" id="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" required autofocus>
                                                                            @error('company_name')
                                                                                <x-error-alert :message="$message" />
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label" for="commercial_name">{{ __('commercial Name') }}</label>
                                                                            <input type="text" name="commercial_name" id="commercial_name" class="form-control @error('commercial_name') is-invalid @enderror" value="{{ old('commercial_name') }}" required>
                                                                            @error('commercial_name')
                                                                                <x-error-alert :message="$message" />
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label" for="email">{{ __('Email Address') }}</label>
                                                                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="username">
                                                                            @error('email')
                                                                                <x-error-alert :message="$message" />
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label" for="phone-number">{{ __('Mobile Number') }}</label>
                                                                            <input type="text" name="phone_number" id="phone-number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}" required>
                                                                            @error('phone_number')
                                                                                <x-error-alert :message="$message" />
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label" for="ruc_tax_id">{{ __('RUC') }}</label>
                                                                            <input type="text" name="ruc_tax_id" id="ruc_tax_id" class="form-control @error('ruc_tax_id') is-invalid @enderror" value="{{ old('ruc_tax_id') }}" required autocomplete="username">
                                                                            @error('ruc_tax_id')
                                                                                <x-error-alert :message="$message" />
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label" for="ruc_code">{{ __('RUC Code') }}</label>
                                                                            <input type="text" name="ruc_code" id="ruc_code" class="form-control @error('ruc_code') is-invalid @enderror"value="{{ old('ruc_code') }}" required>
                                                                            @error('ruc_code')
                                                                                <x-error-alert :message="$message" />
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label" for="address">{{ __('Address')}}</label>
                                                                            <textarea name="address" class="form-control" id="search_input" cols="30" rows="2">{{ old('address') }}</textarea>
                                                                            @error('address')
                                                                                <x-error-alert :message="$message" />
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group mb-3">
                                                                            <a href="javascript::" data-coreui-toggle="modal" data-coreui-target="#modalmap">Agregar Ubicacion en Mape</a>
                                                                            <input type="hidden" name="latitude" id="loc_lat" />
                                                                            <input type="hidden" name="longitude" id="loc_long" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <label for="city" class="form-label">{{ __('City') }}</label>
                                                                                <select class="form-select @error('city') is-invalid @enderror" id="city" name="city" required>
                                                                                    <option selected disabled hidden>{{ __('Select a City') }}</option>
                                                                                    @foreach($cities as $city)
                                                                                        <option value="{{ $city->id }}" {{ (old('city') == $city->id) ? "selected" : ''}} >{{ $city->name }}</option>
                                                                                    @endforeach
                                                                                </select>
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
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label" for="registered_at">{{ __('Registered')}}</label>
                                                                            <input type="date" name="registered_at" id="registered_at" class="form-control @error('registered_at') is-invalid @enderror" value="{{ old('registered_at') }}">
                                                                            @error('registered_at')
                                                                                <x-error-alert :message="$message" />
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label" for="profile-image">{{ __('Company logo') }}</label>
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
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <!-- Modal -->
 <div class="modal fade map_modal" id="modalmap" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <a href="javascript:void(0)" class="btn-close"  data-coreui-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <form id="gmModalForm">
                    <div class="modal_form_row">
                        <div class="modal_form_col">
                            <div class="input-row">
                                <input id="address-modal-input" name="address_address" class="form-control" style="z-index:9999;"/>
                                <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
                                <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
                            </div>
                        </div>
                        <div class="modal_form_col mt-4">
                            <div class="map_block_modal">
                                <div id="address-map-container" style="width:100%;height:400px; ">
                                    <div id="map" style="height:100%;z-index:9995;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal_form_col modal_form_submit mt-4">
                            <input type="button" id="mapModelBtn" value="Submit" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    @section('custom_script')
        <script src="{{ asset('plugins/fancybox/fancybox.umd.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?libraries=geometry,places&key={{ env('GOOGLE_MAP_KEY') }}"></script>
        <script>
            var searchInput = 'search_input';
            function initForm() {
                $('form#gmModalForm').on('keyup keypress', function(e) {
                    var keyCode = e.keyCode || e.which;
                    if (keyCode === 13) {
                        e.preventDefault();
                        return false;
                    }
                });
                var autocomplete;
                autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
                    types: ['geocode'],
                });
                
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var near_place = autocomplete.getPlace();
                    document.getElementById('loc_lat').value = near_place.geometry.location.lat();
                    document.getElementById('loc_long').value = near_place.geometry.location.lng();
                });
            }
            
            google.maps.event.addDomListener(window, 'load', initForm);
            defaultLatLong = {
                lat: -25.2968298,
                lng: -57.680491
            };
        
            var map = new google.maps.Map(document.getElementById('map'), {
                center: defaultLatLong,
                zoom: 13,
                mapTypeId: 'roadmap'
            });
        
            var input = document.getElementById('address-modal-input');
        
            var autocomplete = new google.maps.places.Autocomplete(input);
        
            autocomplete.bindTo('bounds', map);
            //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        
            var marker = new google.maps.Marker({
                map: map,
                position: defaultLatLong,
                draggable: true,
                clickable: true
            });
        
            google.maps.event.addListener(marker, 'dragend', function(marker) {
                var latLng = marker.latLng;
                currentLatitude = latLng.lat();
                currentLongitude = latLng.lng();
                var latlng = {
                    lat: currentLatitude,
                    lng: currentLongitude
                };
                var geocoder = new google.maps.Geocoder;
                geocoder.geocode({
                    'location': latlng
                }, function(results, status) {
                    if (status === 'OK') {
                    if (results[0]) {
                        input.value = results[0].formatted_address;
                    } else {
                        window.alert('No results found');
                    }
                    } else {
                    window.alert('Geocoder failed due to: ' + status);
                    }
                });
                });
        
                autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                }
        
                marker.setPosition(place.geometry.location);
        
                currentLatitude = place.geometry.location.lat();
                currentLongitude = place.geometry.location.lng();
                console.log(currentLatitude,currentLongitude);
                document.getElementById('address-latitude').value = currentLatitude;
                document.getElementById('address-longitude').value = currentLongitude;
        
            });
            $(document).on('click','#mapModelBtn',function(){
                document.getElementById('loc_lat').value = document.getElementById('address-latitude').value;
                document.getElementById('loc_long').value = document.getElementById('address-longitude').value;
                document.getElementById('search_input').value = document.getElementById('address-modal-input').value;
                $('#modalmap').modal('hide');
            });
        </script>
    @endsection
</x-app-admin-layout>
