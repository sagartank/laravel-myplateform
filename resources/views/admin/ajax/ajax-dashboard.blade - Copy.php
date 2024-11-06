        @permission('users')
            <fieldset>
                <legend>{{ __('Users') }}</legend>
                <div class="row">
                    {{-- <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/users-group.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">{{ $total_user->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Total User') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- /.col-->
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/user.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>

                                <div class="fs-4 fw-semibold">{{ $today_register_user }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Registere') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/user-question.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">{{ $total_user->where('is_active', '!=', '1')->count() }}
                                </div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Pending User') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/user-check.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">{{ $total_user->where('is_active', '1')->count() }}</div>
                                <small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Active User') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </fieldset>
        @endpermission
        @permission('operations')
            <fieldset>
                <legend>{{ __('Operations') }}</legend>
                <div class="row">
                    <div class="row">
                    {{--    <div class="col-md-3" title="Total Operations Requiring Admin Assistance">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-medium-emphasis-inverse text-end mb-4">
                                        <div class="icon icon-xxl">
                                            <img src="{{ asset('images/mipo/file-alert.svg') }}"
                                                alt="{{ __('mipo') }}">
                                        </div>
                                    </div>
                                    <div class="fs-4 fw-semibold">{{ $total_operation }}</div><small
                                        class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Total Operations') }}</small>
                                    <div class="progress progress-white progress-thin mt-3">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-medium-emphasis-inverse text-end mb-4">
                                        <div class="icon icon-xxl">
                                            <img src="{{ asset('images/mipo/file-upload.svg') }}"
                                                alt="{{ __('mipo') }}">
                                        </div>
                                    </div>
                                    <div class="fs-4 fw-semibold">{{ $today_documents_uploaded }}</div><small
                                        class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Documents uploaded') }}</small>
                                    <div class="progress progress-white progress-thin mt-3">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-medium-emphasis-inverse text-end mb-4">
                                        <div class="icon icon-xxl">
                                            <img src="{{ asset('images/mipo/file-upload.svg') }}"
                                                alt="{{ __('mipo') }}">
                                        </div>
                                    </div>
                                    <div class="fs-4 fw-semibold">
                                        {{ __('val.')}} {{ app('common')->currencyBySymbol($currency_type).' '.app('common')->currencyNumberFormat($currency_type,  $documents_sold->total_documents_sold_amount) }}
                                    </div>
                                    <div class="fs-4 fw-semibold">
                                        <span>{{ __('qty.')}} {{ $documents_sold->total_documents_sold }}</span>
                                    </div>
                                    <small
                                        class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Documents Sold') }}</small>
                                    <div class="progress progress-white progress-thin mt-3">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-medium-emphasis-inverse text-end mb-4">
                                        <div class="icon icon-xxl">
                                            <img src="{{ asset('images/mipo/file-upload.svg') }}"
                                                alt="{{ __('mipo') }}">
                                        </div>
                                    </div>
                                    <div class="fs-4 fw-semibold">{{ $documents_pending }}</div><small
                                        class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Documents pending verification') }}</small>
                                    <div class="progress progress-white progress-thin mt-3">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-medium-emphasis-inverse text-end mb-4">
                                        <div class="icon icon-xxl">
                                            <img src="{{ asset('images/mipo/file-alert.svg') }}"
                                                alt="{{ __('mipo') }}">
                                        </div>
                                    </div>
                                    <div class="fs-4 fw-semibold">
                                        {{ __('val.')}} {{ app('common')->currencyBySymbol($currency_type).' '.app('common')->currencyNumberFormat($currency_type,  $documents_sold_type->total_documents_sold_amount) }}
                                    </div>
                                    <div class="fs-4 fw-semibold">
                                        <span>{{ __('qty.')}} {{ $documents_sold_type->total_documents_sold }}</span>
                                    </div>
                                    <small class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Documents Sold By Type') }}</small>
                                        
                                    <div class="progress progress-white progress-thin mt-3">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        @endpermission
        @permission('offers')
            <fieldset>
                <legend>{{ __('Offers') }}</legend>
                {{-- <div class="row mt-3">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    {{ $total_offer->where('offer_status', 'Pending')->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Total commissions pending') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    {{ $total_offer->where('offer_status', 'Pending')->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Total commissions cashed') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    {{ $total_offer->where('offer_status', 'Pending')->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Total documents sold due') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="row mt-3">
                   {{--  <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">{{ $total_offer->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Total Offer') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- /.col-->
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    {{ $total_offer->where('offer_status', 'Pending')->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Pending Offer') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    {{ $total_offer->where('offer_status', 'Counter')->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Counter Offer') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    {{ $total_offer->where('offer_status', 'Rejected')->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Rejected Offer') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    {{ $total_offer->where('offer_status', 'Approved')->where('is_disputed', 'No')->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Approved Offer') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    {{ $total_offer->where('offer_status', 'Completed')->where('is_disputed', 'No')->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Completed Offer') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        @endpermission
        @permission('deals')
            <fieldset>
                <legend>{{ __('Deals') }}</legend>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">{{ $total_offer->where('is_disputed', 'Yes')->count() }}
                                </div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Disputed Deals') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    {{ $deals_doc_expired_pending_cash }} </div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Documents expired pending cashing') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    21 </div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Pending operations to be reviewed by buyers') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold">
                                    {{ $total_offer->where('offer_status', 'Completed')->count() }}</div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Completed Deals') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold" data-info="op-doc-value-and-offer_status-approve-completed-and-dispute-no">
                                    {{ app('common')->currencyBySymbol($currency_type).' '.app('common')->currencyNumberFormat($currency_type,  $avg_documents_values_by_type->avg_documents_values) }}
                                </div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Avg. document values by type') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold" data-info="">
                                    {{ app('common')->currencyBySymbol($currency_type).' '.app('common')->currencyNumberFormat($currency_type,  0) }}
                                </div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Avg. discount rate') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold" data-info="">
                                    {{ app('common')->currencyBySymbol($currency_type).' '.app('common')->currencyNumberFormat($currency_type,  $avg_deals_commission_mipo) }}
                                </div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Avg. commission mipo') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-medium-emphasis-inverse text-end mb-4">
                                    <div class="icon icon-xxl">
                                        <img src="{{ asset('images/mipo/basket.svg') }}" alt="{{ __('mipo') }}">
                                    </div>
                                </div>
                                <div class="fs-4 fw-semibold" data-info="">
                                    {{ app('common')->currencyBySymbol($currency_type).' '.app('common')->currencyNumberFormat($currency_type,  $avg_deals_retention) }}
                                </div><small
                                    class="text-medium-emphasis text-uppercase fw-semibold">{{ __('Avg. retentions') }}</small>
                                <div class="progress progress-white progress-thin mt-3">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        @endpermission
