<div class="mobile_offeredbox total_offered_operations" data-screen="mobile">
    <div class="offered_op_wrap">
        <div class="offered_box">
            <div class="leftpart">
                <div class="check_cash"><a href="{{ route('explore-operations.details', $offer->operations->first()->slug) }}" class="text-14-medium">{{ $offer->operations->first()->operation_type_number }}</a>
                    <span class="text-14-medium">{{ __($offer->operations->first()->preferred_payment_method)}}</span>
                </div>
                <div class="name_star"><a href="javascript:;" class="text-14-medium">{{ app('common')->lockOperationDetail($offer->operations->first(), []) }}</a>
                    <div class="starimg"><img src="{{ asset('images/mipo/singlestr.png') }}" alt="no-image"></div><span
                        class="text-14-medium">
                        {{ floor($offer->operations->first()->seller?->ratings_avg_rating_number)}}{!! __('/5 ('. $offer->operations->first()->seller?->ratings_count .')') !!}
                    </span>
                </div>
                <a href="{{ route('profile.public-payer-profile', $offer->operations()->first()->issuer?->slug) }}" class="company text-14-medium">{{ $offer->operations()->first()->issuer->company_name ?? '-' }}</a>
                {{-- <div class="viewAll_op">
                    <a href="javascript:;" class="viewalltag">
                        <span class="text-12-medium">{{ __('View Operations') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16"
                            fill="none">
                            <g clip-path="url(#clip0_3317_3420)">
                                <path d="M7.41406 10.3346L10.0807 7.66797" stroke="#0D6EFD" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M7.41406 5L10.0807 7.66667" stroke="#0D6EFD" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_3317_3420">
                                    <rect width="16" height="16" fill="white" transform="translate(0.414062)">
                                    </rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </a>
                </div> --}}
                {{-- mobile view operation:st --}}
                <div class="mobile_view_op_tab">
                    <div class="view_op_innerbox">
                        <div class="titlebox">
                            <a href="javascript:;"><i><img src="{{ asset('images/mipo/mobilelightleftarrow.svg') }}"
                                        alt="no-image"></i></a>
                            <h2 class="text-20-semibold">{{ __('Offer') }}</h2>
                        </div>
                        <div class="op_repeatbox">
                            <div class="view_opbox">
                                <div class="lftpart">
                                    <div class="name_star"><a href="{{ route('profile.public-seller', $offer->operations->first()->seller->slug) }}" class="text-14-medium">{{ app('common')->lockOperationDetail($offer->operations->first(), []) }}</a>
                                        <div class="starimg"><img src="{{ asset('images/mipo/singlestr.png') }}"
                                                alt="no-image"></div><span class="text-14-medium">
                                                    {{ floor($offer->operations->first()->seller?->ratings_avg_rating_number)}}{!! __('/5 ('. $offer->operations->first()->seller?->ratings_count .')') !!}
                                                </span>
                                    </div>
                                    <div class="check_cash"><a href="{{ route('explore-operations.details', $offer->operations->first()->slug) }}" class="text-14-medium">{{ $offer->operations->first()->operation_type_number }}</a><span class="text-14-medium">{{ $offer->operations->first()->preferred_payment_method }}</span>
                                    </div>
                                    <a href="{{ route('profile.public-payer-profile', $offer->operations()->first()->issuer?->slug) }}" class="company text-14-medium">{{ $offer->operations()->first()->issuer->company_name ?? '-' }}</a>
                                </div>
                                <div class="rghtpart">
                                    <div class="with_resource">
                                        <ul>
                                            <li class="text-14-medium">
                                                <i><svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect y="0.5" width="20" height="20"
                                                            rx="10" fill="#FAFAFA"></rect>
                                                        <path id="hw6"
                                                            d="M12.0406 5.47443C12.1939 4.84186 13.0936 4.84186 13.2469 5.47443C13.3277 5.80774 13.6634 6.0126 13.9967 5.93182C14.059 5.91674 14.1189 5.89192 14.1739 5.85835C14.7296 5.51968 15.366 6.15566 15.0274 6.71183C14.8488 7.00476 14.9417 7.38674 15.2346 7.56532C15.2891 7.5984 15.3485 7.62322 15.4108 7.6383C16.0434 7.79158 16.0434 8.69129 15.4108 8.84457C15.0775 8.92534 14.8726 9.26109 14.9534 9.59441C14.9685 9.65669 14.9933 9.71654 15.0269 9.77153C15.3655 10.3272 14.7296 10.9637 14.1734 10.625C13.8805 10.4464 13.4985 10.5394 13.3199 10.8323C13.2868 10.8868 13.262 10.9462 13.2469 11.0084C13.0936 11.641 12.1939 11.641 12.0406 11.0084C11.9599 10.6751 11.6241 10.4703 11.2908 10.551C11.2285 10.5661 11.1687 10.5909 11.1137 10.6245C10.558 10.9632 9.92154 10.3272 10.2602 9.77104C10.4388 9.47811 10.3458 9.09614 10.0529 8.91756C9.99842 8.88447 9.93906 8.85965 9.87677 8.84457C9.2442 8.69129 9.2442 7.79158 9.87677 7.6383C10.2101 7.55753 10.4149 7.22178 10.3342 6.88847C10.3191 6.82618 10.2943 6.76633 10.2607 6.71135C9.92202 6.15566 10.558 5.51919 11.1142 5.85786C11.4743 6.07683 11.9409 5.88317 12.0406 5.47443Z"
                                                            stroke="#939393" stroke-width="0.8" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                        <path id="hw5"
                                                            d="M11.5635 8.24064C11.5635 8.83733 12.0473 9.32111 12.644 9.32111C13.2407 9.32111 13.7244 8.83733 13.7244 8.24064C13.7244 7.64394 13.2407 7.16016 12.644 7.16016C12.0473 7.16016 11.5635 7.64394 11.5635 8.24064Z"
                                                            stroke="#939393" stroke-width="0.8" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                        <path id="hw4" d="M11.0337 14.0861L13.3836 13.8262"
                                                            stroke="#939393" stroke-width="0.8" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                        <path id="hw3" d="M11.0337 14.0861L13.3836 13.8262"
                                                            stroke="#939393" stroke-width="0.8" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                        <path id="hw2"
                                                            d="M6.19581 14.5664L7.16316 16.0804C7.28129 16.2654 7.22714 16.5109 7.04237 16.6291L6.55976 16.9373C6.37473 17.0554 6.12918 17.0013 6.01105 16.8165L4.06254 13.7674C3.94441 13.5824 3.99857 13.3368 4.18333 13.2187L4.66594 12.9102C4.85097 12.7921 5.09652 12.8462 5.21466 13.031L5.65878 13.726"
                                                            stroke="#939393" stroke-width="0.8"
                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path id="hw1"
                                                            d="M7.07859 15.9466L7.56067 15.4785C7.71915 15.3248 7.94692 15.2662 8.15982 15.324L9.90976 15.8008C10.103 15.8669 10.3077 15.8858 10.5086 15.856L13.9268 15.349C14.1397 15.3174 14.3419 15.2319 14.5164 15.1003L16.8134 13.3631C16.9955 13.1764 17.0175 12.8754 16.8644 12.6601C16.6969 12.4247 16.3807 12.3747 16.1572 12.5489L14.6634 13.422C14.27 13.6519 13.8338 13.7894 13.3847 13.8255L13.3897 13.4982C13.3348 13.1058 13.0327 12.8024 12.6581 12.7637L10.939 12.633C10.5418 12.5919 10.3385 12.4616 9.98515 12.2648C9.64031 12.0729 9.00506 11.8494 8.66261 11.7634C8.06134 11.6123 7.42396 11.7249 6.89728 12.0519L5.24609 13.078"
                                                            stroke="#939393" stroke-width="0.8"
                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </i>
                                                {!! app('common')->responsibility($offer->operations()->first()->responsibility) !!}
                                            </li>
                                            <li class="text-14-medium">
                                                @if($offer->operations->first()->preferred_currency == 'USD')
                                                <i>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <rect width="20" height="20" rx="10" fill="#FAFAFA"/>
                                                        <path d="M10.1375 4V16.55M7 13.6028L7.91929 14.292C9.14396 15.2113 11.13 15.2113 12.3557 14.292C13.5814 13.3728 13.5814 11.8835 12.3557 10.9642C11.7439 10.504 10.9407 10.275 10.1375 10.275C9.37927 10.275 8.62104 10.0449 8.0427 9.5858C6.886 8.66651 6.886 7.17724 8.0427 6.25795C9.19939 5.33867 11.0756 5.33867 12.2323 6.25795L12.6663 6.60308" stroke="#939393" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </i>
                                            @else
                                                <i>
                                                    <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect y="0.5" width="20" height="20" rx="10" fill="#FAFAFA"/>
                                                    <path d="M14.125 6.87625C13.2324 6.06941 12.0717 5.62341 10.8685 5.625C9.5767 5.62673 8.33839 6.1411 7.42556 7.05515C6.51272 7.96921 6 9.2082 6 10.5C6 13.1926 8.17912 15.375 10.8685 15.375C12.069 15.3759 13.2271 14.9312 14.1185 14.127C14.7133 13.5908 14.983 12.3818 14.931 10.5L12.4937 10.5" stroke="#939393" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M10.8687 17V4" stroke="#939393" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </i>
                                            @endif
                                            {{ app('common')->currencyNumberFormat($offer->operations()->first()->preferred_currency, $offer->operations()->first()->amount) }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="iconrow">
                                        <ul>
                                            @if (!is_null($offer->operations()->first()->cheque_status) && $offer->operations()->first()->cheque_status != '')
                                            <li><i><img src="{{ app('common')->operationChequeStatus( $offer->operations()->first()->cheque_status) }}" title="{{  $offer->operations()->first()->cheque_status }}" alt="{{ $offer->operations()->first()->cheque_status }}"></i></li>
                                            @endif
                                            
                                            @if (!is_null($offer->operations()->first()->cheque_type) && $offer->operations()->first()->cheque_type != '')
                                            <li><i><img src="{{ app('common')->operationChequeType($offer->operations()->first()->cheque_type) }}" title="{{ $offer->operations()->first()->cheque_type }}" alt="{{ $offer->operations()->first()->cheque_type }}"></i></li>
                                            @endif
                
                                            @if (!is_null($offer->operations()->first()->cheque_payee_type) && $offer->operations()->first()->cheque_payee_type != '')
                                            <li><i><img src="{{ app('common')->operationChequePayeeType($offer->operations()->first()->cheque_payee_type) }}" title="{{ $offer->operations()->first()->cheque_payee_type }}" alt="{{ $offer->operations()->first()->cheque_payee_type }}"></i></li>
                                            @endif
                
                                            @if (!is_null($offer->operations()->first()->seller) && $offer->operations()->first()->seller?->account_type != '')
                                            <li><i><img src="{{ app('common')->userAccountType($offer->operations()->first()->seller?->account_type) }}" title="{{ $offer->operations()->first()->seller?->account_type }}"  alt="{{ $offer->operations()->first()->seller?->account_type }}"></i></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tag_location">
                                <div class="lftpart">
                                    <ul>
                                        @if ($offer->operations()->first()->bcp != '0' && !is_null($offer->operations()->first()->bcp))
                                        <li>
                                            <div class="pcap {{ ($offer->operations()->first()->bcp == '2') ? 'redwarning' : '' }}">
                                                @if($offer->operations()->first()->bcp == '2')
                                                <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                                @else
                                                <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                                @endif
                                                <span class="text-12-medium">{!! __('BCP') !!}</span>
                                            </div>
                                        </li>
                                        @endif
    
                                        @if ($offer->operations()->first()->inforconf != '0' && !is_null($offer->operations()->first()->inforconf))
                                        <li>
                                            <div class="pcap {{ ($offer->operations()->first()->inforconf == '2') ? 'redwarning' : '' }}">
                                                @if($offer->operations()->first()->inforconf == '2')
                                                <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                                @else
                                                <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                                @endif
                                                <span class="text-12-medium">{!! __('Infocheck') !!}</span>
                                            </div>
                                        </li>
                                        @endif
    
                                        @if ($offer->operations()->first()->infocheck != '0' && !is_null($offer->operations()->first()->infocheck))
                                        <li>
                                            <div class="pcap {{ ($offer->operations()->first()->infocheck == '2') ? 'redwarning' : '' }}">
                                                @if($offer->operations()->first()->infocheck == '2')
                                                <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                                @else
                                                <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                                @endif
                                                <span class="text-12-medium">{!! __('Infocheck') !!}</span>
                                            </div>
                                        </li>
                                        @endif
    
                                        @if ($offer->operations()->first()->criterium != '0' && !is_null($offer->operations()->first()->criterium))
                                        <li>
                                            <div class="pcap {{ ($offer->operations()->first()->criterium == '2') ? 'redwarning' : '' }}">
                                                @if($offer->operations()->first()->criterium == '2')
                                                <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                                @else
                                                <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                                @endif
                                                <span class="text-12-medium">{!! __('Criterium') !!}</span>
                                            </div>
                                        </li>
                                        @endif
                                    </ul>
                                </div>

                                <div class="rightpart">
                                    <div class="userLocation">
                                        @if ($offer->is_mipo_plus == 'Yes')
                                            <div class="mipoplus"><i><img  src="{{ asset('images/mipo/ofrmipoplus.svg') }}"  alt="no-image"></i></div>
                                        @endif
                                        <ul>
                                            <li><i><img src="{{ asset('images/mipo/sml_security_secure.svg') }}"
                                                        alt="no-image"></i></li>
                                            <li><i><img src="{{ asset('images/mipo/smlGold.svg') }}"
                                                        alt="no-image"></i></li>
                                        </ul>
                                        <p class="text-14-medium">{!! __($offer->operations()->first()->seller->city?->name ?? 'Unknown City') !!}</p>
                                    </div>
                                    <div class="expireDay text-12-medium">{{ $offer->operations()->first()->expire_at }}</div>
                                    <div class="showmore">
                                        <a href="javascript:;"><span class="show-More text-14-medium">{{ __('Show More') }}</span>
                                            <i><img src="{{ asset('images/mipo/show_morerght.svg') }}"
                                                    alt="no-image"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                {{-- mobile view operation:nd --}}
                <div class="whattakes">
                    <ul>
                        @if ($offer->operations()->first()->bcp != '0' && !is_null($offer->operations()->first()->bcp))
                        <li>
                            <div class="pcap {{ ($offer->operations()->first()->bcp == '2') ? 'redwarning' : '' }}">
                                @if($offer->operations()->first()->bcp == '2')
                                <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                @else
                                <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                @endif
                                <span class="text-12-medium">{!! __('BCP') !!}</span>
                            </div>
                        </li>
                        @endif

                        @if ($offer->operations()->first()->inforconf != '0' && !is_null($offer->operations()->first()->inforconf))
                        <li>
                            <div class="pcap {{ ($offer->operations()->first()->inforconf == '2') ? 'redwarning' : '' }}">
                                @if($offer->operations()->first()->inforconf == '2')
                                <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                @else
                                <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                @endif
                                <span class="text-12-medium">{!! __('Infocheck') !!}</span>
                            </div>
                        </li>
                        @endif

                        @if ($offer->operations()->first()->infocheck != '0' && !is_null($offer->operations()->first()->infocheck))
                        <li>
                            <div class="pcap {{ ($offer->operations()->first()->infocheck == '2') ? 'redwarning' : '' }}">
                                @if($offer->operations()->first()->infocheck == '2')
                                <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                @else
                                <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                @endif
                                <span class="text-12-medium">{!! __('Infocheck') !!}</span>
                            </div>
                        </li>
                        @endif

                        @if ($offer->operations()->first()->criterium != '0' && !is_null($offer->operations()->first()->criterium))
                        <li>
                            <div class="pcap {{ ($offer->operations()->first()->criterium == '2') ? 'redwarning' : '' }}">
                                @if($offer->operations()->first()->criterium == '2')
                                <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                @else
                                <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                @endif
                                <span class="text-12-medium">{!! __('Criterium') !!}</span>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="rightpart">
                <div class="with_resource">
                    <ul>
                        <li class="text-14-medium">
                            <i><svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect y="0.5" width="20" height="20" rx="10"
                                        fill="#FAFAFA"></rect>
                                    <path id="hw6"
                                        d="M12.0406 5.47443C12.1939 4.84186 13.0936 4.84186 13.2469 5.47443C13.3277 5.80774 13.6634 6.0126 13.9967 5.93182C14.059 5.91674 14.1189 5.89192 14.1739 5.85835C14.7296 5.51968 15.366 6.15566 15.0274 6.71183C14.8488 7.00476 14.9417 7.38674 15.2346 7.56532C15.2891 7.5984 15.3485 7.62322 15.4108 7.6383C16.0434 7.79158 16.0434 8.69129 15.4108 8.84457C15.0775 8.92534 14.8726 9.26109 14.9534 9.59441C14.9685 9.65669 14.9933 9.71654 15.0269 9.77153C15.3655 10.3272 14.7296 10.9637 14.1734 10.625C13.8805 10.4464 13.4985 10.5394 13.3199 10.8323C13.2868 10.8868 13.262 10.9462 13.2469 11.0084C13.0936 11.641 12.1939 11.641 12.0406 11.0084C11.9599 10.6751 11.6241 10.4703 11.2908 10.551C11.2285 10.5661 11.1687 10.5909 11.1137 10.6245C10.558 10.9632 9.92154 10.3272 10.2602 9.77104C10.4388 9.47811 10.3458 9.09614 10.0529 8.91756C9.99842 8.88447 9.93906 8.85965 9.87677 8.84457C9.2442 8.69129 9.2442 7.79158 9.87677 7.6383C10.2101 7.55753 10.4149 7.22178 10.3342 6.88847C10.3191 6.82618 10.2943 6.76633 10.2607 6.71135C9.92202 6.15566 10.558 5.51919 11.1142 5.85786C11.4743 6.07683 11.9409 5.88317 12.0406 5.47443Z"
                                        stroke="#939393" stroke-width="0.8" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path id="hw5"
                                        d="M11.5635 8.24064C11.5635 8.83733 12.0473 9.32111 12.644 9.32111C13.2407 9.32111 13.7244 8.83733 13.7244 8.24064C13.7244 7.64394 13.2407 7.16016 12.644 7.16016C12.0473 7.16016 11.5635 7.64394 11.5635 8.24064Z"
                                        stroke="#939393" stroke-width="0.8" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path id="hw4" d="M11.0337 14.0861L13.3836 13.8262" stroke="#939393"
                                        stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path id="hw3" d="M11.0337 14.0861L13.3836 13.8262" stroke="#939393"
                                        stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path id="hw2"
                                        d="M6.19581 14.5664L7.16316 16.0804C7.28129 16.2654 7.22714 16.5109 7.04237 16.6291L6.55976 16.9373C6.37473 17.0554 6.12918 17.0013 6.01105 16.8165L4.06254 13.7674C3.94441 13.5824 3.99857 13.3368 4.18333 13.2187L4.66594 12.9102C4.85097 12.7921 5.09652 12.8462 5.21466 13.031L5.65878 13.726"
                                        stroke="#939393" stroke-width="0.8" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path id="hw1"
                                        d="M7.07859 15.9466L7.56067 15.4785C7.71915 15.3248 7.94692 15.2662 8.15982 15.324L9.90976 15.8008C10.103 15.8669 10.3077 15.8858 10.5086 15.856L13.9268 15.349C14.1397 15.3174 14.3419 15.2319 14.5164 15.1003L16.8134 13.3631C16.9955 13.1764 17.0175 12.8754 16.8644 12.6601C16.6969 12.4247 16.3807 12.3747 16.1572 12.5489L14.6634 13.422C14.27 13.6519 13.8338 13.7894 13.3847 13.8255L13.3897 13.4982C13.3348 13.1058 13.0327 12.8024 12.6581 12.7637L10.939 12.633C10.5418 12.5919 10.3385 12.4616 9.98515 12.2648C9.64031 12.0729 9.00506 11.8494 8.66261 11.7634C8.06134 11.6123 7.42396 11.7249 6.89728 12.0519L5.24609 13.078"
                                        stroke="#939393" stroke-width="0.8" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                            </i>
                            {!! app('common')->responsibility($offer->operations()->first()->responsibility) !!}
                        </li>
                        <li class="text-14-medium">
                            @if($offer->operations->first()->preferred_currency == 'USD')
                            <i>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <rect width="20" height="20" rx="10" fill="#FAFAFA"/>
                                    <path d="M10.1375 4V16.55M7 13.6028L7.91929 14.292C9.14396 15.2113 11.13 15.2113 12.3557 14.292C13.5814 13.3728 13.5814 11.8835 12.3557 10.9642C11.7439 10.504 10.9407 10.275 10.1375 10.275C9.37927 10.275 8.62104 10.0449 8.0427 9.5858C6.886 8.66651 6.886 7.17724 8.0427 6.25795C9.19939 5.33867 11.0756 5.33867 12.2323 6.25795L12.6663 6.60308" stroke="#939393" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </i>
                        @else
                            <i>
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect y="0.5" width="20" height="20" rx="10" fill="#FAFAFA"/>
                                <path d="M14.125 6.87625C13.2324 6.06941 12.0717 5.62341 10.8685 5.625C9.5767 5.62673 8.33839 6.1411 7.42556 7.05515C6.51272 7.96921 6 9.2082 6 10.5C6 13.1926 8.17912 15.375 10.8685 15.375C12.069 15.3759 13.2271 14.9312 14.1185 14.127C14.7133 13.5908 14.983 12.3818 14.931 10.5L12.4937 10.5" stroke="#939393" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M10.8687 17V4" stroke="#939393" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </i>
                        @endif
                        {{ app('common')->currencyNumberFormat($offer->operations()->first()->preferred_currency, $offer->operations()->first()->amount) }}
                        </li>
                    </ul>
                </div>
                <div class="iconrow">
                    <ul>
                        @if (!is_null($offer->operations()->first()->cheque_status) && $offer->operations()->first()->cheque_status != '')
                        <li><i><img src="{{ app('common')->operationChequeStatus( $offer->operations()->first()->cheque_status) }}" title="{{  $offer->operations()->first()->cheque_status }}" alt="{{ $offer->operations()->first()->cheque_status }}"></i></li>
                        @endif
                        
                        @if (!is_null($offer->operations()->first()->cheque_type) && $offer->operations()->first()->cheque_type != '')
                        <li><i><img src="{{ app('common')->operationChequeType($offer->operations()->first()->cheque_type) }}" title="{{ $offer->operations()->first()->cheque_type }}" alt="{{ $offer->operations()->first()->cheque_type }}"></i></li>
                        @endif

                        @if (!is_null($offer->operations()->first()->cheque_payee_type) && $offer->operations()->first()->cheque_payee_type != '')
                        <li><i><img src="{{ app('common')->operationChequePayeeType($offer->operations()->first()->cheque_payee_type) }}" title="{{ $offer->operations()->first()->cheque_payee_type }}" alt="{{ $offer->operations()->first()->cheque_payee_type }}"></i></li>
                        @endif

                        @if (!is_null($offer->operations()->first()->seller) && $offer->operations()->first()->seller?->account_type != '')
                        <li><i><img src="{{ app('common')->userAccountType($offer->operations()->first()->seller?->account_type) }}" title="{{ $offer->operations()->first()->seller?->account_type }}"  alt="{{ $offer->operations()->first()->seller?->account_type }}"></i></li>
                        @endif
                    </ul>
                </div>
                <div class="userLocation">
                    @if ($offer->is_mipo_plus == 'Yes')
                        <div class="mipoplus"><img src="{{ asset('images/mipo/ofrmipoplus.svg') }}" alt="no-image"></div>
                    @endif
                    <ul>
                        <li><i><img src="{{ asset('images/mipo/sml_security_secure.svg') }}" alt="no-image"></i></li>
                        <li><i><img src="{{ asset('images/mipo/smlGold.svg') }}" alt="no-image"></i></li>
                    </ul>
                    <p class="text-14-medium">{!! __($offer->operations()->first()->seller->city?->name ?? 'Unknown City') !!}</p>
                </div>
                <div class="expireDay text-12-medium">
                    {{ app('common')->diffForHumans($offer->operations()->first()->expiration_date) }}
                    {{-- {!! __('Expires in') !!} {{ $offer->operations()->first()->expire_days }} {{  ($offer->operations()->first()->expire_days > 1)? __('days') :  __('day') }} --}}
                    {{-- {{ __('Expires in') }} {{ $offer->operations()->first()->expire_at }} --}}
                </div>

                <div class="down_share">
                    <ul>
                        <li><a href="javascript:;" class="evt_download_pdf_btn"
                            data-href="{{ route('export.explore-operation-detail', $offer->operations()->first()->slug) }}"
                            data-file-name="{{ $offer->operations()->first()->operation_number }}"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ __('Export') }}"
                            >
                            <svg width="21" height="20" viewBox="0 0 21 20"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.0922852" width="20" height="20" rx="10"
                                        fill="#FAFAFA"></rect>
                                    <path
                                        d="M5.09229 12.5V13.75C5.09229 14.0815 5.22398 14.3995 5.4584 14.6339C5.69282 14.8683 6.01076 15 6.34229 15H13.8423C14.1738 15 14.4917 14.8683 14.7262 14.6339C14.9606 14.3995 15.0923 14.0815 15.0923 13.75V12.5M12.5923 10L10.0923 12.5M10.0923 12.5L7.59229 10M10.0923 12.5V5"
                                        stroke="#939393" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                </svg>
                            </a>
                        </li>
                        <li><a href="javascript:;" class="evt_share_btn"
                            data-share-val="{{ route('explore-operations.details', $offer->operations()->first()->slug) }}"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ __('Share') }}"
                            ><svg width="21" height="20" viewBox="0 0 21 20"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.0922852" width="20" height="20" rx="10"
                                        fill="#FAFAFA"></rect>
                                    <path
                                        d="M7.62941 9.42852C7.50501 9.20467 7.30978 9.02846 7.0744 8.92756C6.83901 8.82666 6.57678 8.80678 6.32887 8.87104C6.08096 8.9353 5.8614 9.08007 5.70467 9.28261C5.54793 9.48515 5.46289 9.734 5.46289 9.99011C5.46289 10.2462 5.54793 10.4951 5.70467 10.6976C5.8614 10.9001 6.08096 11.0449 6.32887 11.1092C6.57678 11.1734 6.83901 11.1535 7.0744 11.0526C7.30978 10.9517 7.50501 10.7755 7.62941 10.5517M7.62941 9.42852C7.7219 9.59499 7.77482 9.78613 7.77482 9.99011C7.77482 10.1941 7.7219 10.3857 7.62941 10.5517M7.62941 9.42852L12.5444 6.6982M7.62941 10.5517L12.5444 13.282M12.5444 13.282C12.4707 13.4148 12.4238 13.5607 12.4064 13.7116C12.3891 13.8625 12.4017 14.0153 12.4434 14.1613C12.4851 14.3073 12.5552 14.4437 12.6496 14.5626C12.744 14.6816 12.861 14.7807 12.9937 14.8545C13.1265 14.9282 13.2725 14.9751 13.4233 14.9924C13.5742 15.0098 13.727 14.9972 13.873 14.9555C14.019 14.9138 14.1554 14.8437 14.2743 14.7493C14.3933 14.6548 14.4925 14.5379 14.5662 14.4052C14.7151 14.1371 14.7515 13.8208 14.6672 13.5259C14.5829 13.231 14.385 12.9816 14.1169 12.8327C13.8488 12.6838 13.5325 12.6474 13.2376 12.7317C12.9427 12.8159 12.6933 13.0139 12.5444 13.282V13.282ZM12.5444 6.6982C12.6165 6.83392 12.7149 6.9539 12.8338 7.05115C12.9528 7.14839 13.09 7.22094 13.2373 7.26455C13.3847 7.30816 13.5392 7.32196 13.692 7.30515C13.8447 7.28833 13.9925 7.24124 14.1269 7.16661C14.2612 7.09199 14.3793 6.99134 14.4743 6.87054C14.5692 6.74974 14.6392 6.61122 14.68 6.46308C14.7208 6.31494 14.7316 6.16015 14.7119 6.00776C14.6922 5.85537 14.6423 5.70844 14.5652 5.57555C14.4131 5.31369 14.1644 5.12194 13.8725 5.04152C13.5805 4.9611 13.2687 4.99843 13.004 5.14548C12.7393 5.29254 12.5429 5.53758 12.4569 5.82793C12.371 6.11828 12.4024 6.43076 12.5444 6.6982V6.6982Z"
                                        stroke="#939393" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>

                @if( $offer->offer_status == 'Rejected')
                <div class="offerd-status-box">
                    <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                    <span class="text-12-medium redwarning"> {!! __('Seller’s Offer has been Rejected') !!}</span>
                </div>
                @endif

                <div class="reject_acceptbox">
                    @if ($offer->offer_status == 'Counter')
                        <a href="javascript:;" class="text-12-medium redbtn evt_change_status" data-offer-id="{{ $offer->id }}" data-status="Rejected">{!! __('Reject') !!}</a>
                        <a href="javascript:;" class="text-12-medium greenbtn evt_change_status" data-offer-id="{{ $offer->id }}" data-status="Approved">{!! __('Accept') !!}</a>
                    @endif
                </div>
            </div>
        </div>
        <a href="{{ route('explore-operations.details', $offer->operations->first()->slug) }}" class="full_link"></a>
    </div>
    <div class="longtagbox">
        <div class="tagbox">
            @if ($offer->offer_status == 'Counter')
            <div class="tag redtxtbg">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                    fill="none">
                    <g clip-path="url(#clip0_1994_64966)">
                        <path d="M9.33325 2.33594H11.6666V4.66927" stroke="#707070" stroke-width="1.16667"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M8.75 5.2526L11.6667 2.33594" stroke="#707070" stroke-width="1.16667"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M2.33325 11.6667L5.24992 8.75" stroke="#707070" stroke-width="1.16667"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M9.33325 11.6693H11.6666V9.33594" stroke="#707070" stroke-width="1.16667"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M2.33325 2.33594L11.6666 11.6693" stroke="#707070" stroke-width="1.16667"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                    <defs>
                        <clipPath id="clip0_1994_64966">
                            <rect width="14" height="14" fill="white"></rect>
                        </clipPath>
                    </defs>
                </svg>
                <span class="text-12-medium">
                    {{ __('Counter Offer') }} : {{ __($offer->preferred_payment_method) }} - {{ __('Expires in') }} {{ $offer->offer_expire_hour }} {!! __('hours') !!} -
                    {{-- {!! __('Counter Offer:  Cash - Expires in').'&nbsp;'. $offer->offer_expire_hour !!} {!! __('hours') !!} - --}}
                    {{ $currency_symblos[$offer->operations()->first()->preferred_currency] }} {{ app('common')->currencyNumberFormat($offer->operations()->first()->preferred_currency, $amount) }}
                </span>
            </div>
            @endif
        </div>

        <div class="tagbox">
            <div class="tag">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                    fill="none">
                    <g clip-path="url(#clip0_1994_64975)">
                        <path
                            d="M1.75 7C1.75 7.68944 1.8858 8.37213 2.14963 9.00909C2.41347 9.64605 2.80018 10.2248 3.28769 10.7123C3.7752 11.1998 4.35395 11.5865 4.99091 11.8504C5.62787 12.1142 6.31056 12.25 7 12.25C7.68944 12.25 8.37213 12.1142 9.00909 11.8504C9.64605 11.5865 10.2248 11.1998 10.7123 10.7123C11.1998 10.2248 11.5865 9.64605 11.8504 9.00909C12.1142 8.37213 12.25 7.68944 12.25 7C12.25 6.31056 12.1142 5.62787 11.8504 4.99091C11.5865 4.35395 11.1998 3.7752 10.7123 3.28769C10.2248 2.80018 9.64605 2.41347 9.00909 2.14963C8.37213 1.8858 7.68944 1.75 7 1.75C6.31056 1.75 5.62787 1.8858 4.99091 2.14963C4.35395 2.41347 3.7752 2.80018 3.28769 3.28769C2.80018 3.7752 2.41347 4.35395 2.14963 4.99091C1.8858 5.62787 1.75 6.31056 1.75 7Z"
                            stroke="#707070" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                        <path d="M7 7H9.04167" stroke="#707070" stroke-width="1.16667" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M7 4.08594V7.0026" stroke="#707070" stroke-width="1.16667" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                    <defs>
                        <clipPath id="clip0_1994_64975">
                            <rect width="14" height="14" fill="white"></rect>
                        </clipPath>
                    </defs>
                </svg>
                <span class="text-12-medium">
                    {{-- {!! __('Previous Offer: Cash - Expires in').'&nbsp;'. $offer->offer_expire_hour !!} {!! __('hours') !!} - --}}
                    {{ __('Previous Offer') }} : {{ __($offer->preferred_payment_method) }} - {{ __('Expires in') }} {{ $offer->offer_expire_hour }} {!! __('hours') !!} -
                    {{ $currency_symblos[$offer->operations()->first()->preferred_currency] }} {{ app('common')->currencyNumberFormat($offer->operations()->first()->preferred_currency, $offer->amount) }}
                </span>
            </div>
        </div>
    </div>
    @if ($high_offer_result)
    <div class="best_blueofr">
        <div class="bestOfr">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14"
                fill="none">
                <g clip-path="url(#clip0_1994_64900)">
                    <path
                        d="M5.34008 7.00056H3.24825C3.13289 7.00054 3.02014 6.96631 2.92423 6.90221C2.82832 6.83811 2.75358 6.74702 2.70944 6.64044C2.6653 6.53387 2.65374 6.4166 2.67624 6.30346C2.69874 6.19032 2.75428 6.08639 2.83583 6.00481L6.67766 2.16298C6.78706 2.05362 6.9354 1.99219 7.09008 1.99219C7.24476 1.99219 7.39311 2.05362 7.5025 2.16298L11.3443 6.00481C11.4259 6.08639 11.4814 6.19032 11.5039 6.30346C11.5264 6.4166 11.5149 6.53387 11.4707 6.64044C11.4266 6.74702 11.3518 6.83811 11.2559 6.90221C11.16 6.96631 11.0473 7.00054 10.9319 7.00056H8.84008V8.75056H5.34008V7.00056Z"
                        stroke="#0D6EFD" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                    <path d="M5.34009 12.25H8.84009" stroke="#0D6EFD" stroke-width="1.16667" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                    <path d="M5.34009 10.5H8.84009" stroke="#0D6EFD" stroke-width="1.16667" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                </g>
                <defs>
                    <clipPath id="clip0_1994_64900">
                        <rect width="14" height="14" fill="white" transform="translate(0.0900879)"></rect>
                    </clipPath>
                </defs>
            </svg>
            
            <span class="text-12-medium">
                {!! __('Best Offer') !!} :
                {{ $currency_symblos[$offer->operations()->first()->preferred_currency] }}{{ app('common')->currencyNumberFormat($offer->operations()->first()->preferred_currency, $high_offer_result->amount ?? '') }}
            </span>
        </div>
    </div>
    @endif

    <div class="bottom_link">
        <a href="javascript:;" class="gery text-14-medium evt_offered_list" data-offer-id="{{$offer->id}}" data-currency-name="{{ $offer->operations()->first()->preferred_currency }}">{!! __('View History') !!}</a>
    
        @if ($offer->offer_status == 'Pending' || $offer->offer_status == 'Rejected')
            <a href="javascript:;" class="red text-14-medium evt_change_status" data-offer-id="{{ $offer->id }}" data-status="Revert">{!! __('Revert Back') !!}</a>
        @endif

        @if ($offer->offer_status == 'Pending' || $offer->offer_status == 'Rejected' || $offer->offer_status == 'Counter')
            <a href="javascript:;" class="blue text-14-medium evt_update_offer_popup" data-offer-id="{{ $offer->id }}">{!! __('Update Offer') !!}</a>
        @endif
    </div>
</div>
