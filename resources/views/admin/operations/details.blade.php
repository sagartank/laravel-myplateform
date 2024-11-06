<x-app-admin-layout>
    @section('pageTitle', 'Operation Details')
    @section('custom_style')
        <link href="{{ asset('plugins/fancybox/fancybox.css') }}" rel="stylesheet">
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Details Operation') }}
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
                        <div class="card-body">
                            <fieldset>
                                <legend>{{ __('Details Operation') }}</legend>
                                <table class="table table-hover">
                                    <tr>
                                        <th>{{ __('Operation Number') }}</th>
                                        <td>{{ $operation->operation_number  }}</td>
                                        <th>{{ __('Document Type') }}</th>
                                        <td>{{ $operation->operation_type }}</td>
                                        <th>{{ __('Government Contract') }}</th>
                                        <td>{{ $operation->is_government_contract }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Issuance Date') }}</th>
                                        <td>{{ $operation->issuance_date }}</td>
                                        <th>{{ __('Expiration Date') }}</th>
                                        <td>{{ $operation->expiration_date }}</td>
                                        <th>{{ __('Extra Expiration Days') }}</th>
                                        <td>({{ $operation->extra_expiration_days }} {{ __('days')}} ) 
                                            {{ $operation->expiration_date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Operations Status') }}</th>
                                        <td>{{ $operation->operations_status }}</td>
                                        <th>{{ __('Mipo Verified') }}</th>
                                        <td>{{ $operation->mipo_verified }}</td>
                                        <th>{{ __('Mipo Comment') }}</th>
                                        <td>{{ $operation->mipo_comment }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Approved Date') }}</th>
                                        <td>{{ $operation->approved_at }}</td>
                                        <th>{{ __('Auto Expire') }}</th>
                                        <td>{{ ($operation->auto_expire == '1') ? 'Yes' : 'No' }}</td>
                                        @if($operation->auto_expire == '1')
                                            <th>{{ __('Expired Date') }}</th>
                                            <td>{{ ($operation->auto_expire == '1') ? $operation->expired_at : '-'  }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th>{{ __('Responsibility') }}</th>
                                        <td>{{ $operation->responsibility }}</td>
                                        <th>{{ __('Contract Title') }}</th>
                                        <td>{{ $operation->contract_title }}</td>
                                        <th>{{ __('Description') }}</th>
                                        <td>{{ $operation->description }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Preferred Payment Method') }}</th>
                                        <td>{{ $operation->preferred_payment_method  }}</td>
                                        <th>{{ __('Seller Name') }}</th>
                                        <td>{{ $operation->seller?->name }}</td>
                                        <th>{{ __('Issuer Name') }}</th>
                                        <td>{{ $operation->issuer?->company_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Currency') }}</th>
                                        <td>{{ $operation->preferred_currency  }}</td>
                                        <th>{{ __('Amount') }}</th>
                                        <td>
                                            {{ app('common')->currencyBySymbol($operation->preferred_currency).''.app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount) }}
                                            {{-- {{ $operation->amount }} --}}
                                        </td>
                                        <th>{{ __('Amount Requested') }}</th>
                                        <td>
                                            {{ app('common')->currencyBySymbol($operation->preferred_currency).''.app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount_requested) }}
                                            {{-- {{ $operation->amount_requested }} --}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Accept Below Requested') }}</th>
                                        <td>{{ $operation->accept_below_requested  }}</td>
                                        <th>{{ __('Check Number') }}</th>
                                        <td>{{ $operation->check_number }}</td>
                                        <th>{{ __('Invoice Type') }}</th>
                                        <td>{{ $operation->invoice_type }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Issuer Company') }}</th>
                                        <td>{{ $operation->issuer_company_type  }}</td>
                                        <th>{{ __('Invoice Number') }}</th>
                                        <td>{{ $operation->invoice_number }}</td>
                                        <th>{{ __('Tax Id') }}</th>
                                        <td>{{ $operation->tax_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Timbrado') }}</th>
                                        <td>{{ $operation->timbrado  }}</td>
                                        <th>{{ __('Issuer Bank Name') }}</th>
                                        <td>{{ $operation->issuer_bank?->name  }}</td>
                                        <th></th>
                                        <td></td>
                                        {{-- <th>{{ __('Authorized Personnel') }}</th>
                                        <td>{{ $operation->authorized_personnel }}</td>
                                        <th>{{ __('Authorized Personnel Signature') }}</th>
                                        <td>{{ $operation->authorized_personnel_signature }}</td> --}}
                                    </tr>
                                    <tr>
                                        <th>{{ __('BCP') }}</th>
                                        <td>{{ ($operation->bcp == '1') ? 'Yes' : 'No' }}</td>
                                        <th>{{ __('Inforconf') }}</th>
                                        <td>{{ ($operation->inforconf == '1') ? 'Yes' : 'No' }}</td>
                                        <th>{{ __('Infocheck') }}</th>
                                        <td>{{ ($operation->infocheck == '1') ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Cheque Status') }}</th>
                                        <td>{{ $operation->cheque_status }}</td>
                                        <th>{{ __('Cheque Payess Type') }}</th>
                                        <td>{{ $operation->cheque_payee_type }}</td>
                                        <th>{{ __('Cheque Type') }}</th>
                                        <td>{{ $operation->cheque_type }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Contract number') }}</th>
                                        <td>{{ $operation->contract_number }}</td>
                                        <th>{{ __('Legal direction') }}</th>
                                        <td>{{ $operation->legal_direction }}</td>
                                        <th>{{ __('Legal Telephone') }}</th>
                                        <td>{{ $operation->legal_telephone }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Stamp Expiration') }}</th>
                                        <td>{{ $operation->stamp_expiration }}</td>
                                    </tr>
                                </table>
                            </fieldset>
                            <fieldset>
                                <legend>{{ __('Documents') }}</legend>
                                <table class="table table-hover">
                                    @if ($operation->documents && $operation->documents->count() > 0)
                                        <tr>
                                        @foreach ($operation->documents as $document)
                                            @if ($document->document_url != '')
                                                @php
                                                    $file_ext = strtolower(pathinfo($document->path, PATHINFO_EXTENSION));
                                                @endphp
                                                @if ($file_ext != 'pdf')
                                                    <td><img  width="100" src="{{ $document->document_url }}" alt="document-image" data-fancybox></td>
                                                @else
                                                <td><a href="{{ $document->path ? route('secure-pdf', Crypt::encryptString($document->path)) : '#' }}" target="_blank">
                                                    <img width="100" src="{{ asset('images/mipo/pdf.png') }}" title="documents" alt="deals  documents">
                                                </a>
                                                </td>
                                                @endif
                                            @endif
                                        @endforeach
                                        </tr>
                                    @endif
                                </table>
                            </fieldset>
                            <fieldset>
                                <legend>{{ __('Supporting Attachments') }}</legend>
                                <table class="table table-hover">
                                    @if ($operation->supportingAttachments && $operation->supportingAttachments->count() > 0)
                                    <tr>
                                    @foreach ($operation->supportingAttachments as $attachments)
                                        @if ($attachments->attachment_url != '')
                                            @php
                                                $file_ext = strtolower(pathinfo($attachments->path, PATHINFO_EXTENSION));
                                            @endphp
                                            @if ($file_ext != 'pdf')
                                                <td><img width="100" src="{{ $attachments->attachment_url }}" alt="document-image" data-fancybox></td>
                                            @else
                                            <td> <a href="{{ $supporting_attachment->path ? route('secure-pdf', Crypt::encryptString($supporting_attachment->path)) : '#' }}" target="_blank">
                                                    <img width="100" src="{{ asset('images/mipo/pdf.png') }}" title="documents" alt="deals  documents">
                                                </a>
                                            </td>
                                            @endif
                                            @endif
                                        @endforeach
                                        </tr>
                                    @endif
                                </table>
                            </fieldset>
                            <fieldset>
                                <legend>{{ __('References') }}</legend>
                                <table class="table table-hover">
                                    @if ($operation->references && $operation->references->count() > 0)
                                            <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Company Nname') }}</th>
                                            <th>{{ __('Email') }}</th>
                                            <th>{{ __('Phone Number') }}</th>
                                            </tr>
                                        @foreach ($operation->references as $reference)
                                        <tr>
                                            <td>{{ $reference->name }}</td>
                                            <td>{{ $reference->company_name }}</td>
                                            <td>{{ $reference->email }}</td>
                                            <td>{{ $reference->phone_number }}</td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </fieldset>
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
