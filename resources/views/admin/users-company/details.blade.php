<x-app-admin-layout>
    @section('custom_style')
        <link href="{{ asset('plugins/fancybox/fancybox.css') }}" rel="stylesheet">
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
                                        aria-controls="pills-user" aria-selected="true">User</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-coreui-toggle="pill"
                                        data-coreui-target="#pills-operations" type="button" role="tab"
                                        aria-controls="pills-operations" aria-selected="false">Operations</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-coreui-toggle="pill"
                                        data-coreui-target="#pills-deals" type="button" role="tab"
                                        aria-controls="pills-deals" aria-selected="false">Deals</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-coreui-toggle="pill"
                                        data-coreui-target="#pills-mi-coins" type="button" role="tab"
                                        aria-controls="pills-mi-coins" aria-selected="false">Mi Coins</button>
                                </li>

                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-user" role="tabpanel"
                                    aria-labelledby="pills-user-tab" tabindex="0">
                                    <fieldset>
                                        <legend>User Details</legend>
                                        <table class="table table-hover">
                                            <tr>
                                                <th>User Profile</th>
                                                <td>
                                                    <img role="button" width="100" title="{{ __('User Profile') }}"
                                                        src="{{ $user->profile_image ? route('secure-image', Crypt::encryptString($user->profile_image)) : asset('images/profile-stock.png') }}" data-fancybox>
                                                </td>
                                                <th>IPV Image</th>
                                                <td>
                                                    <img role="button" width="100" src="{{ $user->ipv_image ? route('secure-image', Crypt::encryptString($user->ipv_image)) : '#' }}" alt="IPV Image" data-fancybox>
                                                </td>
                                                <th>Id Proof</th>
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
                                                <th>{{ ($user->is_user_company == '1') ? 'Company Name' : 'First Name' }} </th>
                                                <td>{{ $user->first_name }}</td>
                                                <th>Last Name</th>
                                                <td>{{ $user->last_name }}</td>
                                                <th>Email Address</th>
                                                <td>{{ $user->email }}</td>
                                                <th>{{ __('Is User Company')}}</th>
                                                <td>{{ ($user->is_user_company == '1') ? 'Yes' : 'No' }}</td>
                                                <th></th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>Mobile Number</th>
                                                <td>{{ $user->phone_number }}</td>
                                                <th>Date of Birth</th>
                                                <td>{{ $user->birth_date }}</td>
                                                <th>Gender</th>
                                                <td>{{ $user->gender }}</td>
                                                <th></th>
                                                <td></td>
                                                <th></th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>{{ $user->address }}</td>
                                                <th>Postal Code</th>
                                                <td>{{ $user->postal_code }}</td>
                                                <th>City</th>
                                                <td>{{ $user->city }}</td>
                                                {{-- <th>State</th>
                                                <td>{{ $user->state }}</td>
                                                <th>Country</th>
                                                <td>{{ $user->country?->name }}</td> --}}
                                            </tr>
                                            <tr>
                                                <th>Occupation</th>
                                                <td>{{ $user->occupation }}</td>
                                                <th>Bio</th>
                                                <td>{{ $user->bio }}</td>
                                                <th></th>
                                                <td></td>
                                                <th></th>
                                                <td></td>
                                                <th></th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>Ref By </th>
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
                                                <th>Is Active ? </th>
                                                <td>{{ $user->is_active == '1' ? 'Yes' : 'No' }}</td>
                                                <th>Is Registered ? </th>
                                                <td>{{ $user->is_registered == '1' ? 'Yes' : 'No' }}</td>
                                                <th>Register At</th>
                                                <td>{{ $user->registered_at }}</td>
                                                <th></th>
                                                <td></td>
                                                <th></th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>Last login Ip </th>
                                                <td>{{ $user->last_login_ip }}</td>
                                                <th>Last login At  </th>
                                                <td>{{ $user->last_login_at }}</td>
                                                <th></th>
                                                <td></td>
                                                <th></th>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                    <fieldset>
                                        <legend>Bank Details</legend>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Payment options</th>
                                                    <th>Bank Name</th>
                                                    <th>Account Name</th>
                                                    <th>Account Number</th>
                                                    <th>Phone Number Company</th>
                                                    <th>Phone Number</th>
                                                    <th>identification Id</th>
                                                    <th>Note</th>
                                                    <th>Active</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($bank_details)
                                                    <tr>
                                                        <td>{{ $bank_details->payment_options }}</td>
                                                        <td>{{ $bank_details->issuer_bank?->name }}</td>
                                                        <td>{{ $bank_details->account_name }}</td>
                                                        <td>{{ $bank_details->account_number }}</td>
                                                        <td>{{ $bank_details->phone_company }}</td>
                                                        <td>{{ $bank_details->phone_number }}</td>
                                                        <td>{{ $bank_details->identification_id }}</td>
                                                        <td>{{ $bank_details->payment_note }}</td>
                                                        <td>{{ $bank_details->is_active }}</td>
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
                                        <legend>User Alert Notifications Details</legend>
                                        <table class="table table-bordered table-hover dt-responsive nowrap">
                                            <thead>
                                                <tr>
                                                    <th><strong>Status</strong></th>
                                                    <th><strong>Title</strong></th>
                                                    <th><strong>Date & Time</strong></th>
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
                                        <legend>Operations Details</legend>
                                        <table class="table table-bordered table-hover dt-responsive nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Seller Name</th>
                                                    <th>Operation Number</th>
                                                    <th>Operation Type</th>
                                                    <th>Amount</th>
                                                    <th>Currency</th>
                                                    <th>Mipo Verified</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($operations->isNotEmpty())
                                                    @foreach ($operations as $val)
                                                        <tr id="row-{{ $val->slug }}">
                                                            <td>{{ $val->seller->name }}</td>
                                                            <td>{{ $val->operation_number }}</td>
                                                            <td>{{ $val->operation_type }}</td>
                                                            <td>{{ app('common')->currencyBySymbol($val->preferred_currency) . '' . app('common')->currencyNumberFormat($val->preferred_currency, $val->amount) }}
                                                            </td>
                                                            <td>{{ $val->preferred_currency }}</td>
                                                            <td>
                                                                <span
                                                                    class="text-white badge text-bg-{{ $val->mipo_verified == 'Yes' ? 'success' : 'danger' }}">{{ $val->mipo_verified }}</span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="text-white badge text-bg-{{ app('common')->operationStatusBgcolor($val->operations_status) }}">{{ $val->operations_status }}</span>
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
                                        <legend>Deals Details</legend>
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Operation Number</th>
                                                    <th>Seller Name</th>
                                                    <th>Operation Amount</th>
                                                    <th>Buyer Name</th>
                                                    <th>Deal Amount</th>
                                                    <th>Offer Type</th>
                                                    <th>Deal Status</th>
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
                                                                        class="text-white badge text-bg-success">{{ $val->offer_status }}</span>
                                                                @elseif($val->offer_status == 'Rejected')
                                                                    <span
                                                                        class="text-white badge text-bg-danger">{{ $val->offer_status }}</span>
                                                                @elseif($val->offer_status == 'Pending')
                                                                    <span
                                                                        class="text-white badge text-bg-warning">{{ $val->offer_status }}</span>
                                                                @elseif($val->offer_status == 'Counter' || $val->offer_status == 'Completed')
                                                                    <span
                                                                        class="text-white badge text-bg-info">{{ $val->offer_status }}</span>
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
                                                            <th><strong>{{ __('Title') }}</strong></th>
                                                            <th><strong>{{ __('Date & Time') }}</strong></th>
                                                            <th><strong>{{ __('Created by') }}</strong></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($user->mi_coins_poinst as $point_val)
                                                            <tr>
                                                                <td>{{ $point_val->points }}</td>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('custom_script')
        <script src="{{ asset('plugins/fancybox/fancybox.umd.js') }}"></script>
    @endsection
</x-app-admin-layout>
