@if($result->operations->count() > 0)
    @foreach ($result->operations as $operation)
    <div class="operatorbox_outer">
        <div class="grp-ofr-operation_box">
            <div class="leftpart">
                <div class="opecheck_all_wrp">
                    <a href="{{ route('profile.public-seller', $operation->seller?->slug ?? 'javascript:;') }}" class="name text-16-medium">{!! app('common')->lockOperationDetail($operation, []) !!}</a>
                    <div class="imgbox">
                        @permission('explore-operations-stars')
                        <i><img src="{{ asset('images/mipo/singlestr.png') }}" alt="no-image" /></i>
                        <span class="text-16-medium">{{ round($operation->seller?->ratings_avg_rating_number, 2) }}{!! __('/5 (50)') !!}</span>
                        @endpermission
                    </div>
                </div>
                <div class="company">
                    <a href="{{ route('explore-operations.details', $operation->slug) }}" class="text-14-medium invoice">{!! __($operation->operation_type_number) !!}</a>
                    <span>{!! __($operation->preferred_payment_method) !!}</span>
                    <a href="{{ route('profile.public-payer-profile', $operation->issuer?->slug) }}" class="text-14-medium">{{ $operation->issuer?->company_name }}</a>
                </div>

                <div class="resource_wrap">
                    <ul class="first">
                        <li class="ficon text-14-medium">
                            <i><svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect y="0.5" width="20" height="20" rx="10" fill="#FAFAFA" />
                                    <path id="hw6"
                                        d="M12.0406 5.47443C12.1939 4.84186 13.0936 4.84186 13.2469 5.47443C13.3277 5.80774 13.6634 6.0126 13.9967 5.93182C14.059 5.91674 14.1189 5.89192 14.1739 5.85835C14.7296 5.51968 15.366 6.15566 15.0274 6.71183C14.8488 7.00476 14.9417 7.38674 15.2346 7.56532C15.2891 7.5984 15.3485 7.62322 15.4108 7.6383C16.0434 7.79158 16.0434 8.69129 15.4108 8.84457C15.0775 8.92534 14.8726 9.26109 14.9534 9.59441C14.9685 9.65669 14.9933 9.71654 15.0269 9.77153C15.3655 10.3272 14.7296 10.9637 14.1734 10.625C13.8805 10.4464 13.4985 10.5394 13.3199 10.8323C13.2868 10.8868 13.262 10.9462 13.2469 11.0084C13.0936 11.641 12.1939 11.641 12.0406 11.0084C11.9599 10.6751 11.6241 10.4703 11.2908 10.551C11.2285 10.5661 11.1687 10.5909 11.1137 10.6245C10.558 10.9632 9.92154 10.3272 10.2602 9.77104C10.4388 9.47811 10.3458 9.09614 10.0529 8.91756C9.99842 8.88447 9.93906 8.85965 9.87677 8.84457C9.2442 8.69129 9.2442 7.79158 9.87677 7.6383C10.2101 7.55753 10.4149 7.22178 10.3342 6.88847C10.3191 6.82618 10.2943 6.76633 10.2607 6.71135C9.92202 6.15566 10.558 5.51919 11.1142 5.85786C11.4743 6.07683 11.9409 5.88317 12.0406 5.47443Z"
                                        stroke="#939393" stroke-width="0.8" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path id="hw5"
                                        d="M11.5635 8.24064C11.5635 8.83733 12.0473 9.32111 12.644 9.32111C13.2407 9.32111 13.7244 8.83733 13.7244 8.24064C13.7244 7.64394 13.2407 7.16016 12.644 7.16016C12.0473 7.16016 11.5635 7.64394 11.5635 8.24064Z"
                                        stroke="#939393" stroke-width="0.8" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path id="hw4" d="M11.0337 14.0861L13.3836 13.8262" stroke="#939393"
                                        stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round" />
                                    <path id="hw3" d="M11.0337 14.0861L13.3836 13.8262" stroke="#939393"
                                        stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round" />
                                    <path id="hw2"
                                        d="M6.19581 14.5664L7.16316 16.0804C7.28129 16.2654 7.22714 16.5109 7.04237 16.6291L6.55976 16.9373C6.37473 17.0554 6.12918 17.0013 6.01105 16.8165L4.06254 13.7674C3.94441 13.5824 3.99857 13.3368 4.18333 13.2187L4.66594 12.9102C4.85097 12.7921 5.09652 12.8462 5.21466 13.031L5.65878 13.726"
                                        stroke="#939393" stroke-width="0.8" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path id="hw1"
                                        d="M7.07859 15.9466L7.56067 15.4785C7.71915 15.3248 7.94692 15.2662 8.15982 15.324L9.90976 15.8008C10.103 15.8669 10.3077 15.8858 10.5086 15.856L13.9268 15.349C14.1397 15.3174 14.3419 15.2319 14.5164 15.1003L16.8134 13.3631C16.9955 13.1764 17.0175 12.8754 16.8644 12.6601C16.6969 12.4247 16.3807 12.3747 16.1572 12.5489L14.6634 13.422C14.27 13.6519 13.8338 13.7894 13.3847 13.8255L13.3897 13.4982C13.3348 13.1058 13.0327 12.8024 12.6581 12.7637L10.939 12.633C10.5418 12.5919 10.3385 12.4616 9.98515 12.2648C9.64031 12.0729 9.00506 11.8494 8.66261 11.7634C8.06134 11.6123 7.42396 11.7249 6.89728 12.0519L5.24609 13.078"
                                        stroke="#939393" stroke-width="0.8" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg> </i>{!! __($operation->responsibility) !!} {!! __('Recurso') !!}
                        </li>
                        <li class="sicon text-14-medium">
                            @if($operation->preferred_currency == 'USD')
                                <i>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 16 16" fill="none">
                                        <rect width="20" height="20" rx="10" fill="#FAFAFA"/>
                                        <path d="M8 4V12M6 10.1213L6.586 10.5607C7.36667 11.1467 8.63267 11.1467 9.414 10.5607C10.1953 9.97467 10.1953 9.02533 9.414 8.43933C9.024 8.146 8.512 8 8 8C7.51667 8 7.03333 7.85333 6.66467 7.56067C5.92733 6.97467 5.92733 6.02533 6.66467 5.43933C7.402 4.85333 8.598 4.85333 9.33533 5.43933L9.612 5.65933" stroke="#939393" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </i>
                            @else
                                <i><svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect y="0.5" width="20" height="20" rx="10" fill="#FAFAFA" />
                                    <path
                                        d="M14.125 6.87625C13.2324 6.06941 12.0717 5.62341 10.8685 5.625C9.5767 5.62673 8.33839 6.1411 7.42556 7.05515C6.51272 7.96921 6 9.2082 6 10.5C6 13.1926 8.17912 15.375 10.8685 15.375C12.069 15.3759 13.2271 14.9312 14.1185 14.127C14.7133 13.5908 14.983 12.3818 14.931 10.5L12.4937 10.5"
                                        stroke="#939393" stroke-width="1.3" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M10.8687 17V4" stroke="#939393" stroke-width="1.3" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg></i>
                            @endif
                            {{ app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount) }}
                        </li>
                    </ul>
                </div>

                <div class="whattakes">
                    <ul>
                        @if ($operation->bcp != '0' && !is_null($operation->bcp))
                            @permission('explore-operations-bcp')
                            <li>
                                <div class="pcap {{ ($operation->bcp == '2') ? 'redwarning' : '' }}">
                                    @if(($operation->bcp == '2'))
                                    <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                    @else
                                    <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                    @endif
                                    <span class="text-12-medium">{!! __('BCP') !!}</span>
                                </div>
                            </li>
                            @endpermission
                        @endif
                        @if ($operation->inforconf != '0' && !is_null($operation->inforconf))
                            @permission('explore-operations-inforconf')
                            <li>
                                <div class="pcap {{ ($operation->inforconf == '2') ? 'redwarning' : '' }}">
                                    @if(($operation->inforconf == '2'))
                                    <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                    @else
                                    <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                    @endif
                                    <span class="text-12-medium">{!! __('Inforconf') !!}</span>
                                </div>
                            </li>
                            @endpermission
                        @endif
                        @if ($operation->infocheck != '0' && !is_null($operation->infocheck))
                            @permission('explore-operations-infocheck')
                            <li>
                                <div class="pcap {{ ($operation->infocheck == '2') ? 'redwarning' : '' }}">
                                    @if(($operation->infocheck == '2'))
                                    <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                    @else
                                    <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                    @endif
                                    <span class="text-12-medium">{!! __('Infocheck') !!}</span>
                                </div>
                            </li>
                            @endpermission
                        @endif
                        @if ($operation->criterium != '0' && !is_null($operation->criterium))
                            @permission('explore-operations-criterium')
                            <li>
                                <div class="pcap {{ ($operation->criterium == '2') ? 'redwarning' : '' }}">
                                    @if(($operation->criterium == '2'))
                                    <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                    @else
                                    <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                    @endif
                                    <span class="text-12-medium">{!! __('Criterium') !!}</span>
                                </div>
                            </li>
                            @endpermission
                        @endif
                    </ul>
                </div>
            </div>
            <div class="rightpart">
                <div class="userLocation">
                    <p class="text-16-medium">{{ $operation->seller->city?->name ?? 'Unknown City' }}</p>
                </div>
                <div class="expireDay text-14-medium">
                    {!! __('Expires in') !!} {{  $operation->expire_at }}
                </div>
                <div class="iconsrow">
                    <ul class="first">
                        @if (!is_null($operation->cheque_status) && $operation->cheque_status != '')
                        <li><i><img src="{{ app('common')->operationChequeStatus($operation->cheque_status) }}" title="{{ $operation->cheque_status }}" alt="{{ $operation->cheque_status }}"></i></li>
                        @endif
                        
                        @if (!is_null($operation->cheque_type) && $operation->cheque_type != '')
                        <li><i><img src="{{ app('common')->operationChequeType($operation->cheque_type) }}" title="{{ $operation->cheque_type }}" alt="{{ $operation->cheque_type }}"></i></li>
                        @endif

                        @if (!is_null($operation->cheque_payee_type) && $operation->cheque_payee_type != '')
                        <li><i><img src="{{ app('common')->operationChequePayeeType($operation->cheque_payee_type) }}" title="{{ $operation->cheque_payee_type }}" alt="{{ $operation->cheque_payee_type }}"></i></li>
                        @endif

                        @if (!is_null($operation->seller) && $operation->seller?->account_type != '')
                        <li><i><img src="{{ app('common')->userAccountType($operation->seller?->account_type) }}" title="{{ $operation->seller?->account_type }}"  alt="{{ $operation->seller?->account_type }}"></i></li>
                        @endif
                    </ul>
                    <ul class="second">
                        @if ($operation->seller->address_verify == 'Yes')
                            <li><i><img src="{{ $operation->seller->address_verify_img }}" title="{{ __('Address verified')}}" alt="{{ __('Address verified')}}"></i></li>
                        @endif
                        <li><i><img src="{{ app('common')->userLevelImage($operation->seller->user_level) }}" title="user level" alt="user level"></i></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="showmore_wrap">
            <div class="showmore">
                <a href="{{ route('explore-operations.details', $operation->slug) }}"><span class="show-More text-12-medium">{!! __('Show More') !!}</span>
                    <i><img src="{{ asset('images/mipo/show_morerght.svg') }}" alt="no-image" /></i></a>
            </div>
        </div>
        <a href="{{ route('explore-operations.details', $operation->slug) }}" class="full_link"></a>
    </div>
    @endforeach
@endif
