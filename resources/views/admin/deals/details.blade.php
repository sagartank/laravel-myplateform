<x-app-admin-layout>
    @section('pageTitle', 'Deal Details')
    @section('custom_style')
        <link href="{{ asset('css/dealflow-admin.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/carousel/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/fancybox/fancybox.css') }}" rel="stylesheet">
    @endsection
    <x-slot name="header">
        <x-header>
            {{ __('Deals Details') }}
            <x-slot name="right">
                <a href="{{ route('admin.deals.index') }}">
                    <button type="button" class="btn btn-sm btn-dark">{{ __('Back') }}</button>
                </a>
            </x-slot>
        </x-header>
    </x-slot>
    @include('components.message')
    @php
    /*   $is_disputed_val = $offer->is_disputed;
        $is_rated_val = $offer->is_rated_buyer;
        $is_cashed_val = $offer->is_cashed_buyer;
        $is_offer_status = $offer->offer_status;
        $step_btn = true;
        if ($is_disputed_val == 'Yes' || $is_offer_status == 'Completed') {
            $step_btn = false;
        } */
    @endphp

    @php
    $offer_id_val = $offer->id;
    $offer_slug_val = $offer->slug;
    $is_disputed_val = $offer->is_disputed;
    $is_rated_val = $offer->is_rated_buyer;
    $is_cashed_val = $offer->is_cashed_buyer;
    $is_offer_status = $offer->offer_status;
    $step_btn = true;
    if ($is_disputed_val == 'Yes') {
        $step_btn = false;
    }
    @endphp

    <div class="py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            </div> --}}
                        <div class="card-body">
                            <div class="row">
                                @if ($is_disputed_val == 'Yes')
                                    <div class="alert alert-danger" role="alert">
                                        <strong> {{ __('Error Deals Dispute ') . ' ' . $offer->updated_at }} </strong>
                                        <button type="button" class="btn btn-primary btn-sm" data-coreui-toggle="modal" data-coreui-target="#dispute_resolve_modal">{{ __('Resolve') }} </button>
                                        {{-- <p class="mt-2"> {{ $offer->disputes_note }} </p> --}}
                                    </div>
                                    <div class="modal fade" id="dispute_resolve_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Dispute Resolve Form')}}</h5>
                                                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form name="dispute_resolve_form" id="dispute_resolve_form" method="post" action="{{ route('admin.deals.dispute-resolve') }}">
                                                        @csrf
                                                        <input type="hidden" name="offer_id" value="{{ $offer->slug }}"/>
                                                        <input type="hidden" name="disputed_id" value="{{ $details->deals_disputes->first()?->id }}"/>
                                                        <div class="mb-3">
                                                            <label for="resolved_note" class="col-form-label">{{ __('Resolved Note') }}</label>
                                                            <textarea class="form-control" id="resolved_note" name="resolved_note"></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">{{ __('Save')}}</button>
                                                            <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <fieldset>
                                    <legend>{{ __('Change Seller Offer Status') }}</legend>
                                    <div class="btn-group btn-group-lg total_seller_step w-100">
                                        <div class="progress_steps">
                                            <ul>
                                                @forelse ($seller_steps as $key => $seller)
                                                    @php
                                                        $progress_key = app('common')->removeSpecialChars($seller->title_en);
                                                        $index = ' STEP ' . ($key + 1);
                                                    @endphp
                                                    @if (in_array($seller->title_en, $offers_logs->pluck('title')->toArray()))
                                                        <li class="filled {{ $progress_key }} seller_toggel_{{ $seller->id }}"
                                                            id="seller_step_name_{{ $key + 1 }}"
                                                            data-step-name="{{ $seller->title_en }}"
                                                            data-step-id="{{ $seller->id }}"
                                                            data-step-link-ids="{{ ($seller->manual_trigger == 'Admin') ? ($seller->step_links) : '' }}"
                                                            data-coreui-toggle="tooltip" data-coreui-placement="top"
                                                            title="{{ $seller->title_en }}">
                                                            <button type="button">
                                                                <span class="step_dot"></span>
                                                                @if ($langs == 'es')
                                                                    <p>{{ $seller_steps_es[$seller->title_en] }}</p>
                                                                @else
                                                                    <p>{{ $seller->title_en }}</p>
                                                                @endif
                                                            </button>
                                                        </li>
                                                    @else
                                                        <li class="{{ $progress_key }} seller_toggel_{{ $seller->id }}"
                                                            id="seller_step_name_{{ $key + 1 }}"
                                                            data-step-name="{{ $seller->title_en }}"
                                                            data-step-id="{{ $seller->id }}"
                                                            data-step-link-ids="{{ ($seller->manual_trigger == 'Admin') ? ($seller->step_links) : '' }}"
                                                            data-coreui-toggle="tooltip" data-coreui-placement="top"
                                                            title="{{ $seller->title_en }}">
                                                            <button type="button"><span class="step_dot"></span>
                                                                @if ($langs == 'es')
                                                                    <p>{{ $seller_steps_es[$seller->title_en] }}</p>
                                                                @else
                                                                    <p>{{ $seller->title_en }}</p>
                                                                @endif
                                                            </button>
                                                        </li>
                                                    @endif
                                                @empty
                                                    <p>{{ __('No Record') }}</p>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>

                                    @if ($step_btn == true)
                                        @permission('back-forward-seller-deal')
                                            <div class="mt-2">
                                                <nav aria-label="Page navigation example pt-4">
                                                    <ul class="pagination justify-content-center">
                                                        <li class="page-item">
                                                            <a class="page-link evt_btn_back_forward_seller"
                                                                data-offer-id="{{ $details->id }}"
                                                                data-operation-id="{{ $details->operations->first()->pivot->operation_id }}"
                                                                data-action-name="back"
                                                                href="javascript:;">{{ __('Back') }}</a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link evt_btn_back_forward_seller"
                                                                data-offer-id="{{ $details->id }}"
                                                                data-operation-id="{{ $details->operations->first()->pivot->operation_id }}"
                                                                data-action-name="forward"
                                                                href="javascript:;">{{ __('Forward') }}</a>
                                                        </li>
                                                    </ul>
                                                </nav>
                                            </div>
                                        @endpermission
                                    @endif
                                    <hr>
                                </fieldset>

                                <fieldset>
                                    <legend>{{ __('Change Buyer Offer Status') }}</legend>
                                    {{--    <div class="btn-group btn-group-lg total_buyer_step">
                                        @forelse ($buyer_steps as $key => $buyer)
                                            @php
                                                $progress_key = app('common')->removeSpecialChars($buyer->title_en);
                                                $index = ' STEP ' . ($key + 1);
                                            @endphp
                                            @if (in_array($buyer->title_en, $offers_logs->pluck('title')->toArray()))
                                                &nbsp; <button type="button" id="buyer_step_name_{{ $key + 1 }}"
                                                    class="btn btn-primary rounded-pill {{ $progress_key }}"
                                                    data-progress-key="{{ $progress_key }}"
                                                    data-step-name="{{ $buyer->title_en }}"
                                                    data-coreui-toggle="tooltip" data-coreui-placement="top"
                                                    title="{{ $buyer->title_en }}">
                                                    {{ $index }} </button>&nbsp;
                                            @else
                                                &nbsp;<button type="button" id="buyer_step_name_{{ $key + 1 }}"
                                                    class="btn btn-secondary rounded-pill {{ $progress_key }}"
                                                    data-progress-key="{{ $progress_key }}"
                                                    data-step-name="{{ $buyer->title_en }}"
                                                    data-coreui-toggle="tooltip" data-coreui-placement="top"
                                                    title="{{ $buyer->title_en }}">{{ $index }} </button>&nbsp;
                                            @endif
                                        @empty
                                            <p>No Record</p>
                                        @endforelse
                                    </div> --}}

                                    <div class="btn-group btn-group-lg total_buyer_step w-100">
                                        <div class="progress_steps">
                                            <ul>
                                                @forelse ($buyer_steps as $key => $buyer)
                                                    @php
                                                        $progress_key = app('common')->removeSpecialChars($buyer->title_en);
                                                        $index = ' STEP ' . ($key + 1);
                                                    @endphp
                                                    @if (in_array($buyer->title_en, $offers_logs->pluck('title')->toArray()))
                                                        <li class="filled {{ $progress_key }} buyer_toggel_{{ $buyer->id }}"
                                                            id="buyer_step_name_{{ $key + 1 }}"
                                                            data-step-name="{{ $buyer->title_en }}"
                                                            data-step-id="{{ $buyer->id }}"
                                                            data-step-link-ids="{{ ($buyer->manual_trigger == 'Admin') ? ($buyer->step_links) : '' }}"
                                                            data-coreui-toggle="tooltip" data-coreui-placement="top"
                                                            title="{{ $buyer->title_en }}">
                                                            <button type="button">
                                                                <span class="step_dot"></span>
                                                                @if ($langs == 'es')
                                                                    <p>{{ $buyer_steps_es[$buyer->title_en] }}</p>
                                                                @else
                                                                    <p>{{ $buyer->title_en }}</p>
                                                                @endif
                                                            </button>
                                                        </li>
                                                    @else
                                                        <li class="{{ $progress_key }} buyer_toggel_{{ $buyer->id }}"
                                                            id="buyer_step_name_{{ $key + 1 }}"
                                                            data-step-name="{{ $buyer->title_en }}"
                                                            data-step-id="{{ $buyer->id }}"
                                                            data-step-link-ids="{{ ($buyer->manual_trigger == 'Admin') ? ($buyer->step_links) : '' }}"
                                                            data-coreui-toggle="tooltip" data-coreui-placement="top"
                                                            title="{{ $buyer->title_en }}">
                                                            <button type="button"><span class="step_dot"></span>
                                                                @if ($langs == 'es')
                                                                    <p>{{ $buyer_steps_es[$buyer->title_en] }}</p>
                                                                @else
                                                                    <p>{{ $buyer->title_en }}</p>
                                                                @endif
                                                            </button>
                                                        </li>
                                                    @endif
                                                @empty
                                                    <p>{{ __('No Record') }}</p>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                    @if ($step_btn == true)
                                        @permission('back-forward-buyer-deal')
                                            <div class="mt-2">
                                                <nav aria-label="Page navigation example pt-4">
                                                    <ul class="pagination justify-content-center">
                                                        <li class="page-item">
                                                            <a class="page-link evt_btn_back_forward_buyer"
                                                                data-offer-id="{{ $details->id }}"
                                                                data-operation-id="{{ $details->operations->first()->pivot->operation_id }}"
                                                                data-action-name="back"
                                                                href="javascript:;">{{ __('Back') }}</a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link evt_btn_back_forward_buyer"
                                                                data-offer-id="{{ $details->id }}"
                                                                data-operation-id="{{ $details->operations->first()->pivot->operation_id }}"
                                                                data-action-name="forward"
                                                                href="javascript:;">{{ __('Forward') }} </a>
                                                        </li>
                                                    </ul>
                                                </nav>
                                            </div>
                                        @endpermission
                                    @endif
                                    <hr>
                                </fieldset>
                                <fieldset>
                                    <legend>{{ __('Change Deals Status') }}</legend>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input evt_offer_status" type="checkbox"  {{ ($details->is_mipo_commission_payment == 'Yes') ? 'checked' : '' }} role="switch" id="is_mipo_commission_payment">
                                                <label class="form-check-label" for="is_mipo_commission_payment">{{ __('Is Mipo Commission Payment')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input evt_offer_status" type="checkbox" {{ ($details->is_qr_code_seller == 'Yes') ? 'checked' : '' }} role="switch" id="is_qr_code_seller">
                                                <label class="form-check-label" for="is_qr_code_seller">{{ __('Is QrCode Seller')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input evt_offer_status" type="checkbox" {{ ($details->is_cashed_seller == 'Yes') ? 'checked' : '' }} role="switch" id="is_cashed_seller">
                                                <label class="form-check-label" for="is_cashed_seller">{{ __('Is Cashed Seller')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input evt_offer_status" type="checkbox" {{ ($details->is_cashed_buyer == 'Yes') ? 'checked' : '' }} role="switch" id="is_cashed_buyer">
                                                <label class="form-check-label" for="is_cashed_buyer">{{ __('Is Cashed Buyer')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                @php
                                    $currency_symbol = app('common')->currencyBySymbol($details->operations->first()->preferred_currency);
                                    $operation_amount = app('common')->currencyNumberFormat($details->operations->first()->preferred_currency, $details->operations->first()->amount);
                                    $amount_requested = app('common')->currencyNumberFormat($details->operations->first()->preferred_currency, $details->operations->first()->amount_requested);
                                    $offer_amount = app('common')->currencyNumberFormat($details->operations->first()->preferred_currency, $details->amount);
                                    $retention_amount = app('common')->currencyNumberFormat($details->operations->first()->preferred_currency, $details->retention);
                                    $net_profit = app('common')->currencyNumberFormat($details->operations->first()->preferred_currency, $details->net_profit);
                                @endphp
                                <fieldset>
                                    <hr>
                                    <legend>{{ __('Offer Details') }} id {{ $details->id}}</legend>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <table>
                                                <tr>
                                                    <th>{{ __('Buyer Name') }} : </th>
                                                    <td>{{ $details->buyer->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Seller Name') }} : </th>
                                                    <td>{{ $details->operations->first()->seller->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Type') }} : </th>
                                                    <td>{{ $details->offer_type }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Preferred Payment') }} : </th>
                                                    <td>{{ $details->preferred_payment_method }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Status') }} : </th>
                                                    <td>{{ $details->offer_status }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Expires') }} : </th>
                                                    <td>{{ $details->expires_at }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Mipo Plus') }}: </th>
                                                    <td>
                                                        <span class="text-white badge text-bg-{{ ($details->is_mipo_plus == 'Yes') ? 'success' : 'danger' }}">
                                                            {{ $details->is_mipo_plus }}
                                                        </span>
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <table>
                                                <tr>
                                                    <th>{{ __('Amount') }} : </th>
                                                    <td>{{ $currency_symbol . '' . $offer_amount }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Retention') }} : </th>
                                                    <td>{{ $currency_symbol . '' . $retention_amount }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Mipo Commission') }} : </th>
                                                    <td>{{ $details->mipo_commission }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Mipo Plus Commission') }} : </th>
                                                    <td>{{ $details->mipo_plus_commission }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Net Profit') }} : </th>
                                                    <td>{{ $currency_symbol . '' . $net_profit }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <table>
                                                <tr>
                                                    <th>{{ __('Is Dispute') }} </th>
                                                    <td>
                                                        <span class="text-white badge text-bg-{{ ($details->is_disputed == 'Yes') ? 'success' : 'danger' }}">
                                                        {{ $details->is_disputed }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                {{--
                                                <tr>
                                                    <th>{{ __('Dispute Note') }} </th>
                                                    <td>{{ $details->disputes_note }}</td>
                                                </tr> --}}
                                                <tr>
                                                    <th>{{ __('Is Mipo Commission Payment') }} </th>
                                                    <td>
                                                        <span class="text-white badge text-bg-{{ ($details->is_mipo_commission_payment == 'Yes') ? 'success' : 'danger' }}">
                                                        {{ $details->is_mipo_commission_payment }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Is QrCode Buyer') }} </th>
                                                    <td>
                                                        <span class="text-white badge text-bg-{{ ($details->is_qr_code_buyer == 'Yes') ? 'success' : 'danger' }}">
                                                            {{ $details->is_qr_code_buyer }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Is QrCode Seller') }} </th>
                                                    <td>
                                                        <span class="text-white badge text-bg-{{ ($details->is_qr_code_seller == 'Yes') ? 'success' : 'danger' }}">
                                                            {{ $details->is_qr_code_seller }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Is Cashed Buyer') }} </th>
                                                    <td>
                                                        <span class="text-white badge text-bg-{{ ($details->is_cashed_buyer == 'Yes') ? 'success' : 'danger' }}">
                                                            {{ $details->is_cashed_buyer }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @if($details->is_cashed_buyer == 'Yes')
                                                    <tr>
                                                        <th>{{ __('Is Cashed Buyer Date') }} </th>
                                                        <td>
                                                            <span class="text-white badge text-bg-dark">
                                                                {{ $details->cashed_date_buyer }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <th>{{ __('Is Cashed Seller') }} </th>
                                                    <td>
                                                        <span class="text-white badge text-bg-{{ ($details->is_cashed_seller == 'Yes') ? 'success' : 'danger' }}">
                                                            {{ $details->is_cashed_seller }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @if($details->is_cashed_seller == 'Yes')
                                                    <tr>
                                                        <th>{{ __('Is Cashed Seller Date') }} </th>
                                                        <td>
                                                            <span class="text-white badge text-bg-dark">
                                                                {{ $details->cashed_date_seller }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <th>{{ __('Is Rated Buyer') }}</th>
                                                    <td>
                                                        <span class="text-white badge text-bg-{{ ($details->is_rated_buyer == 'Yes') ? 'success' : 'danger' }}">
                                                            {{ $details->is_rated_buyer }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Is Rated Seller') }}</th>
                                                    <td>
                                                        <span class="text-white badge text-bg-{{ ($details->is_rated_seller == 'Yes') ? 'success' : 'danger' }}">
                                                            {{ $details->is_rated_seller }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>{{ __('Is Seller Contract Sign') }}</th>
                                                    <td>
                                                        <span class="text-white badge text-bg-{{ ($details->is_seller_deals_contract == 'Yes') ? 'success' : 'danger' }}">
                                                            {{ $details->is_seller_deals_contract }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>{{ __('Is Buyer Contract Sign') }}</th>
                                                    <td>
                                                        <span class="text-white badge text-bg-{{ ($details->is_buyer_deals_contract == 'Yes') ? 'success' : 'danger' }}">
                                                            {{ $details->is_buyer_deals_contract }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                
                                            </table>
                                        </div>
                                    </div>
                                    <fieldset>
                                        <hr>
                                        <legend>{{ __('Deals  Documents') }}</legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4> {{ __('Seller') }}</h4>
                                                <div class="row mt-2">
                                                    @forelse($details->deals_documents->where('uploaded_by_name', 'Seller') as $key => $deals_document_val )
                                                    <div class="col-md-2">
                                                        @if ($deals_document_val->extension != 'pdf')
                                                            <img src="{{ $deals_document_val->deals_path_url }}" data-fancybox width="100" title="deals  documents" alt="deals  documents">
                                                        @else
                                                        <a href="{{ $deals_document_val->path ? route('secure-pdf', Crypt::encryptString($deals_document_val->path)) : '#' }}" target="_blank">
                                                            <img width="100" src="{{ asset('images/mipo/pdf.png') }}" title="deals  documents" alt="deals  documents">
                                                        </a>
                                                        @endif  
                                                    </div>
                                                    @empty
                                                        <p>{{ __('No Record') }}</p>
                                                    @endforelse
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h4> {{ __('Buyer') }}</h4>
                                                <div class="row mt-2">
                                                    @forelse($details->deals_documents->where('uploaded_by_name', 'Buyer')  as $key => $deals_document_val )
                                                    <div class="col-md-2">
                                                        @if ($deals_document_val->extension != 'pdf')
                                                            <img src="{{ $deals_document_val->deals_path_url }}" data-fancybox width="100" title="deals  documents" alt="deals  documents">
                                                        @else
                                                        <a href="{{ $deals_document_val->path ? route('secure-pdf', Crypt::encryptString($deals_document_val->path)) : '#' }}" target="_blank">
                                                            <img width="100" src="{{ asset('images/mipo/pdf.png') }}" title="deals  documents" alt="deals  documents">
                                                        </a>
                                                        @endif  
                                                    </div>
                                                    @empty
                                                        <p>{{ __('No Record') }}</p>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </fieldset>

                                    <fieldset>
                                        <hr>
                                        <legend>{{ __('Deals contract') }}</legend>
                                        <div class="row">
                                            @if($details->deals_contract)
                                                @if( $details->deals_contract->deals_contract_file!='')
                                                    <div class="col-md-2">
                                                        <a href="{{ $details->deals_contract->deals_contract_file_pdf_url }}" download role="button">
                                                            <img width="100" src="{{ asset('images/mipo/pdf.png') }}" title="{{ __('Deals Contract Pdf')}}" alt="{{ __('Deals Contract Pdf')}}" >
                                                        </a>
                                                    </div>
                                                @endif
                                            @else
                                                <p>{{ __('No Record') }}</p>
                                            @endif
                                    </fieldset>
                                    <fieldset>
                                        <hr>
                                        <legend>{{ __('Deals Disputes') }}</legend>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Note')}}</th>
                                                    <th>{{ __('File')}}</th>
                                                    <th>{{ __('Date & Time')}}</th>
                                                    <th>{{ __('Dispted by')}}</th>
                                                    <th>{{ __('Resolved by')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($details->deals_disputes as $key => $deals_dispute_val)
                                                <tr>
                                                    <td>{{ $deals_dispute_val->disputes_note  }}</td>
                                                    <td> 
                                                        @if($deals_dispute_val->dispute_file_url && $deals_dispute_val->file_path != '')
                                                            @php
                                                                $file_ext = strtolower(pathinfo($deals_dispute_val->file_path, PATHINFO_EXTENSION));
                                                            @endphp
                                                            @if ($file_ext != 'pdf')
                                                                <img src="{{ $deals_dispute_val->dispute_file_url }}" data-fancybox width="100" title="dispute-file" alt="dispute-file">
                                                            @else
                                                            <a href="{{ $deals_dispute_val->file_path ? route('secure-pdf', Crypt::encryptString($deals_dispute_val->file_path)) : '#' }}" target="_blank">
                                                                <img width="100" src="{{ asset('images/mipo/pdf.png') }}" title="dispute-file" alt="dispute-file">
                                                            </a>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>{{ $deals_dispute_val->created_at }}</td>
                                                    <td>{{ $deals_dispute_val->disputed_user?->name ?? '-' }}</td>
                                                    <td>{{ $deals_dispute_val->resolved_user?->name ?? '-'}}</td>
                                                </tr>
                                            @empty
                                            </tr>
                                                <td colspan="5">
                                                    <p>{{ __('No Record') }}</p>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    </fieldset>
                                </fieldset>
                                <fieldset>
                                    <hr>
                                    <legend>{{ __('Operation Details') }}</legend>
                                    @php
                                        $operations = $details->operations->first();
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-4">
                                            <table>
                                                <tr>
                                                    <th>{{ __('Seller Name') }} : </th>
                                                    <td>{{ $operations->seller->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Operation Number') }} : </th>
                                                    <td>{{ $operations->operation_number }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Operation Type') }} : </th>
                                                    <td>{{ $operations->operation_type }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Preferred Payment') }} : </th>
                                                    <td>{{ $operations->preferred_payment_method }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Preferred Currency ') }}: </th>
                                                    <td>{{ $operations->preferred_currency }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Expiration Date') }} : </th>
                                                    <td>{{ $operations->expiration_date }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <table>
                                                <tr>
                                                    <th>{{ __('Amount') }} : </th>
                                                    <td>{{ $currency_symbol . '' . $operation_amount }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Amount Requested') }} : </th>
                                                    <td>{{ $currency_symbol . '' .$amount_requested }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <hr>
                                    <legend>{{ __('Operation Documents') }}</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table">
                                                @if ($documents)
                                                    <tr>
                                                        @foreach ($documents as $document)
                                                            @if ($document->document_url != '')
                                                                @if ($document->extension != 'pdf')
                                                                    <img src="{{ $document->document_url }}" data-fancybox width="100" title="documents" alt="deals  documents">
                                                                @else
                                                                <a href="{{ $document->path ? route('secure-pdf', Crypt::encryptString($document->path)) : '#' }}" target="_blank">
                                                                    <img width="100" src="{{ asset('images/mipo/pdf.png') }}" title="documents" alt="deals  documents">
                                                                </a>
                                                                @endif  
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table">
                                                @if ($supporting_attachments)
                                                    <tr>
                                                        @foreach ($supporting_attachments as $supporting_attachment)
                                                        @if ($supporting_attachment->attachment_url != '')
                                                            @if ($supporting_attachment->extension != 'pdf')
                                                                <img src="{{ $supporting_attachment->attachment_url }}" data-fancybox width="100" title="documents" alt="deals  documents">
                                                            @else
                                                            <a href="{{ $supporting_attachment->path ? route('secure-pdf', Crypt::encryptString($supporting_attachment->path)) : '#' }}" target="_blank">
                                                                <img width="100" src="{{ asset('images/mipo/pdf.png') }}" title="documents" alt="deals  documents">
                                                            </a>
                                                            @endif  
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <hr>
                                    <legend>{{ __('Assignment Certificate') }}</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table>
                                                <tr>
                                                    <th>{{ __('Payer Name') }} : </th>
                                                    <td>{{ $operations->issuer?->company_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Buyer Name') }} : </th>
                                                    <td>{{ $details->buyer->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Seller Name') }} : </th>
                                                    <td>{{ $operations->seller->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Created At') }} : </th>
                                                    <td>{{ $details->created_at }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Expired At') }} : </th>
                                                    <td>{{ $details->expires_at }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Amount') }} : </th>
                                                    <td>{{ $currency_symbol . '' . $offer_amount }}</td>
                                                </tr>
                                            </table>
                                            <form name="deals_seog" id="deals_seog" action="{{ route('admin.deals.create-seog', $offer->slug)}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <table>
                                                    <tr>
                                                        <th>{{ __('SEOG') }} : </th>
                                                        <td><input type="text" name="seog_name" id="seog_name" class="form-control" required></td>
                                                    </tr>
                                                    <tr style="margin-top: 10px">
                                                        <th>{{ __('SEOG File Upload') }} : </th>
                                                        <td><input type="file" name="seog_file" id="seog_file" class="form-control" required></td>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <td>
                                                            <button type="submit" class="btn btn-primary">{{ __('File Upload') }}</button>
                                                            @if($details->deals_seog && !empty($details->deals_seog->deals_seog_path_url))
                                                            <a href="{{ route('admin.deals.download-seog', $offer->slug)}}" class="btn btn-success text-white"  role="button">
                                                                {{ __('Generate Pdf') }}
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            @if($details->deals_seog && !empty($details->deals_seog->deals_seog_path_url))
                                            <table>
                                                <tr>
                                                    <th>{{ __('File Download') }} : </th>
                                                    <td>
                                                        <a href="{{ $details->deals_seog->deals_seog_path_url }}" download role="button">
                                                            <img width="100" src="{{ asset('images/mipo/pdf.png') }}" title="{{ __('Deals SEOG Pdf')}}" alt="{{ __('Deals SEOG Pdf')}}" >
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>

                                
                                <fieldset>
                                    <hr>
                                    <legend>{{ __('Admin Note') }}</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form name="deals_note" id="deals_note" action="{{ route('admin.deals.private-note-crud')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="deals_private_note_action" value="add"/>
                                                <input type="hidden" name="deals_id" value="{{ $offer->id }}"/>
                                                <input type="hidden" name="deals_private_note_id" value=""/>
                                                <div class="mb-3">
                                                    <textarea name="deals_private_note" id="deals_private_note" class="form-control" required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">{{ __('Add Note') }}</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('Note')}}</th>
                                                        <th>{{ __('Created At')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        @forelse ($deals_private_notes as $deals_private_note)
                                                        <tr>
                                                            <td>{{ $deals_private_note->note  }}</td>
                                                            <td>{{ $deals_private_note->created_at  }}</td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="2" style="text-align: center">{{ __('No Record')}}</td>
                                                        </tr>
                                                        @endforelse
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <hr>
                                    <legend>{{ __('Admin File Upload') }}</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form name="deals_seog" id="deals_seog" action="{{ route('admin.deals.create-seog', $offer->slug)}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <table>
                                                    <tr>
                                                        <td><input type="hidden" name="seog_name" id="seog_name" class="form-control" value="admin"></td>
                                                        <td><input type="hidden" name="doc_type" id="doc_type" class="form-control" value="admin"></td>
                                                    </tr>
                                                    <tr style="margin-top: 10px">
                                                        <th>{{ __('Admin File Upload') }} : </th>
                                                        <td><input type="file" name="seog_file" id="seog_file" class="form-control" required></td>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <td>
                                                            <button type="submit" class="btn btn-primary">{{ __('File Upload') }}</button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                @forelse ($details->deals_admin_file as $admin_file)
                                                <div class="col-md-2">
                                                    <a href="{{ $admin_file->deals_seog_path_url }}" download role="button">
                                                        <img width="100" src="{{ asset('images/mipo/pdf.png') }}" title="{{ __('admin file')}}" alt="{{ __('admin file')}}" >
                                                    </a>
                                                </div>
                                                @empty
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('custom_script')
    <script src="{{ asset('plugins/carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('plugins/fancybox/fancybox.umd.js') }}"></script>
        <script>
            const offer_id_val = "{{ $offer_id_val }}";
            const offer_slug_val = "{{ $offer_slug_val }}";
            
            $(document).ready(function() {
                $('.evt_btn_back_forward_seller').click(function(e) {
                    e.preventDefault();
                    var self = $(this);

                    var active = $('.total_seller_step').find('.filled').length;
                    console.log('active length ', active);

                    var in_active = (active + 1);

                    var operation_id = self.attr('data-operation-id');
                    var offer_id = self.attr('data-offer-id');

                    var action_name = self.attr('data-action-name');
                    var step_name = '';

                    if (action_name == 'back') {
                        step_name = $('#seller_step_name_' + active).attr('data-step-name');
                        var step_id = $('#seller_step_name_' + active).attr('data-step-id');
                        var step_links_ids = $('#seller_step_name_' + active).attr('data-step-link-ids');
                    } else if (action_name == 'forward') {
                        step_name = $('#seller_step_name_' + in_active).attr('data-step-name');
                        var step_id = $('#seller_step_name_' + in_active).attr('data-step-id');
                        var step_links_ids = $('#seller_step_name_' + in_active).attr('data-step-link-ids');
                    }

                    var form_data = {
                        'action_name': action_name,
                        'offer_id': offer_id,
                        'operation_id': operation_id,
                        'step_type': 'Seller',
                        'step_name': step_name,
                        'step_id': step_id,
                        'step_links_ids': step_links_ids,
                    };

                    console.info('form_data', form_data);
                    $.ajax({
                        type: 'POST',
                        data: form_data,
                        url: "{{ route('admin.deals.ajax-deals-change-status') }}",
                        success: function(res) {
                            if (res.status == true) {
                                if (res.data.step == 'back') {
                                    $('.' + res.data.prev_title).removeClass('filled');
                                    $('.' + res.data.prev_title).addClass('');

                                    if(res.data.next_back_buyer_ids) {
                                        res.data.next_back_buyer_ids.forEach(ele => {
                                            $('body .buyer_toggel_' + ele).removeClass('filled');
                                            $('.' + res.data.prev_title).addClass('');
                                        });
                                    }

                                    if(res.data.next_back_seller_ids) {
                                        res.data.next_back_seller_ids.forEach(ele => {
                                            $('body .seller_toggel_' + ele).removeClass('filled');
                                            $('.' + res.data.prev_title).addClass('');
                                        });
                                    }

                                } else if (res.data.step == 'forward') {
                                    $('.' + res.data.next_title).removeClass('');
                                    $('.' + res.data.next_title).addClass('filled');

                                    if(res.data.next_back_buyer_ids) {
                                        res.data.next_back_buyer_ids.forEach(ele => {
                                            $('body .buyer_toggel_' + ele).addClass('filled');
                                        });
                                    }

                                    if(res.data.next_back_seller_ids) {
                                        res.data.next_back_seller_ids.forEach(ele => {
                                            $('body .seller_toggel_' + ele).addClass('filled');
                                        });
                                    }
                                }
                            } else if (res.status == false) {
                                toastr.error(res.message);
                            } else {
                                toastr.error(res.message);
                            }
                        },
                        error: function(xhr) {
                            ajaxErrorMsg(xhr);
                        }
                    });
                });

                $('.evt_btn_back_forward_buyer').click(function(e) {
                    e.preventDefault();
                    var self = $(this);
                    var active = $('.total_buyer_step').find('.filled').length;

                    var in_active = (active + 1);

                    var operation_id = self.attr('data-operation-id');
                    var offer_id = self.attr('data-offer-id');

                    var action_name = self.attr('data-action-name');
                    var step_name = '';

                    if (action_name == 'back') {
                        step_name = $('#buyer_step_name_' + active).attr('data-step-name');
                        var step_id = $('#buyer_step_name_' + active).attr('data-step-id');
                        var step_links_ids = $('#buyer_step_name_' + active).attr('data-step-link-ids');
                    } else if (action_name == 'forward') {
                        step_name = $('#buyer_step_name_' + in_active).attr('data-step-name');
                        var step_id = $('#buyer_step_name_' + in_active).attr('data-step-id');
                        var step_links_ids = $('#buyer_step_name_' + in_active).attr('data-step-link-ids');
                    }

                    var form_data = {
                        'action_name': action_name,
                        'offer_id': offer_id,
                        'operation_id': operation_id,
                        'step_type': 'Buyer',
                        'step_name': step_name,
                        'step_id': step_id,
                        'step_links_ids': step_links_ids,
                    };
                    console.info('form_data', form_data);
                    $.ajax({
                        type: 'POST',
                        data: form_data,
                        url: "{{ route('admin.deals.ajax-deals-change-status') }}",
                        success: function(res) {
                            if (res.status == true) {
                                if (res.data.step == 'back') {
                                    $('.' + res.data.prev_title).removeClass('filled');
                                    $('.' + res.data.prev_title).addClass('');

                                    if(res.data.next_back_seller_ids) {
                                        res.data.next_back_seller_ids.forEach(ele => {
                                            $('body .seller_toggel_' + ele).removeClass('filled');
                                            $('.' + res.data.prev_title).addClass('');
                                        });
                                    }

                                    if(res.data.next_back_buyer_ids) {
                                        res.data.next_back_buyer_ids.forEach(ele => {
                                            $('body .buyer_toggel_' + ele).removeClass('filled');
                                            $('.' + res.data.prev_title).addClass('');
                                        });
                                    }

                                } else if (res.data.step == 'forward') {
                                    $('.' + res.data.next_title).removeClass('');
                                    $('.' + res.data.next_title).addClass('filled');

                                    if(res.data.next_back_seller_ids) {
                                        res.data.next_back_seller_ids.forEach(ele => {
                                            $('body .seller_toggel_' + ele).addClass('filled');
                                        });
                                    }

                                    if(res.data.next_back_buyer_ids) {
                                        res.data.next_back_buyer_ids.forEach(ele => {
                                            $('body .buyer_toggel_' + ele).addClass('filled');
                                        });
                                    }
                                }
                            } else if (res.status == false) {
                                toastr.error(res.message);
                            } else {
                                toastr.error(res.message);
                            }
                        },
                        error: function(xhr) {
                            ajaxErrorMsg(xhr);
                        }
                    });
                });
            });
            $(document).on('change', '.evt_offer_status', function(e){
                e.preventDefault();
                var column_name = $(this).attr('id');

                var form_data = {
                        'column_name': column_name,
                        'offer_id': offer_id_val,
                    };
                
                    $.ajax({
                        type: 'POST',
                        data: form_data,
                        url: "{{ route('admin.deals.ajax-deals-flow-change-status') }}",
                        success: function(res) {
                            if (res.status == true) {
                                toastr.success(res.message);
                            } else {
                                toastr.error(res.message);
                            }
                        },
                        error: function(xhr) {
                            ajaxErrorMsg(xhr);
                        }
                    });
            });
        </script>
    @endsection
</x-app-admin-layout>
