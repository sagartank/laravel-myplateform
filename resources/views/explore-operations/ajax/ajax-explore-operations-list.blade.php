@if (isset($operations) && $operations->count() > 0)
<div class="operation_Wrap">
    @foreach ($operations as $key => $operation)
        <div class="operatorbox_outer">
            <div class="operation_box">
                <div class="leftpart">

                    <div class="top_part_cheque_select">
                        @if ($operation->offers->count() == 0)
                            <input type="checkbox" name="explore_operation_ids" class="explore_operation_ids form-check-input" id="cheque_check_{{ $operation->id }}" data-currency-type="{{ $operation->preferred_currency }}" value="{{ $operation->id }}">
                        @endif
                    </div>

                    <div class="opecheck_all_wrp">

                        <a href="{{ route('explore-operations.details', $operation->slug) }}" class="codeid">
                            {{ ($operation->operation_type == 'Cheque') ? __('Check') : __($operation->operation_type) }} {!! __($operation->operation_number) !!}
                        </a>

                        <span class="cash">{!! __($operation->preferred_payment_method) !!}</span>

                        @if(isset($operation->seller) && !empty($operation->seller->slug))  
                            <a href="{{ route('profile.public-seller', $operation->seller?->slug ?? 'unknow') }}" class="name">{!! app('common')->lockOperationDetail($operation, ['seller_name']) !!}</a>
                        @endif
                    
                        <div class="imgbox">
                            @permission('explore-operations-stars')
                            <i><img src="{{ asset('images/mipo/singlestr.png') }}" alt="no-image"></i>
                                <span>{{ floor($operation->seller?->ratings_avg_rating_number) }}{!! __('/5 ('. $operation->seller?->ratings_count .')') !!}</span>
                                {{-- <span>{{ round($operation->seller?->ratings_avg_rating_number, 2) }}{!! __('/5 (50)') !!}</span> --}}
                            @endpermission
                        </div>

                        @if ($operation->offers->count() > 0)
                            <div class="tag">{!! __('Offered') !!}</div>
                        @endif

                    </div>
                    <div class="company">
                        <a href="{{ route('profile.public-payer-profile', $operation->issuer?->slug ?? 'javascript:;') }}" class="com_tour">{{ $operation->issuer?->company_name  ?? ''}}</a>
                    </div>

                    <div class="resource_wrap">
                        <ul class="first">
                            <li class="ficon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{!! app('common')->responsibility($operation->responsibility) !!}"><i><svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect y="0.5" width="20" height="20" rx="10" fill="#FAFAFA"/>
                                <path id="hw6" d="M12.0406 5.47443C12.1939 4.84186 13.0936 4.84186 13.2469 5.47443C13.3277 5.80774 13.6634 6.0126 13.9967 5.93182C14.059 5.91674 14.1189 5.89192 14.1739 5.85835C14.7296 5.51968 15.366 6.15566 15.0274 6.71183C14.8488 7.00476 14.9417 7.38674 15.2346 7.56532C15.2891 7.5984 15.3485 7.62322 15.4108 7.6383C16.0434 7.79158 16.0434 8.69129 15.4108 8.84457C15.0775 8.92534 14.8726 9.26109 14.9534 9.59441C14.9685 9.65669 14.9933 9.71654 15.0269 9.77153C15.3655 10.3272 14.7296 10.9637 14.1734 10.625C13.8805 10.4464 13.4985 10.5394 13.3199 10.8323C13.2868 10.8868 13.262 10.9462 13.2469 11.0084C13.0936 11.641 12.1939 11.641 12.0406 11.0084C11.9599 10.6751 11.6241 10.4703 11.2908 10.551C11.2285 10.5661 11.1687 10.5909 11.1137 10.6245C10.558 10.9632 9.92154 10.3272 10.2602 9.77104C10.4388 9.47811 10.3458 9.09614 10.0529 8.91756C9.99842 8.88447 9.93906 8.85965 9.87677 8.84457C9.2442 8.69129 9.2442 7.79158 9.87677 7.6383C10.2101 7.55753 10.4149 7.22178 10.3342 6.88847C10.3191 6.82618 10.2943 6.76633 10.2607 6.71135C9.92202 6.15566 10.558 5.51919 11.1142 5.85786C11.4743 6.07683 11.9409 5.88317 12.0406 5.47443Z" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <path id="hw5" d="M11.5635 8.24064C11.5635 8.83733 12.0473 9.32111 12.644 9.32111C13.2407 9.32111 13.7244 8.83733 13.7244 8.24064C13.7244 7.64394 13.2407 7.16016 12.644 7.16016C12.0473 7.16016 11.5635 7.64394 11.5635 8.24064Z" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <path id="hw4" d="M11.0337 14.0861L13.3836 13.8262" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <path id="hw3" d="M11.0337 14.0861L13.3836 13.8262" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <path id="hw2" d="M6.19581 14.5664L7.16316 16.0804C7.28129 16.2654 7.22714 16.5109 7.04237 16.6291L6.55976 16.9373C6.37473 17.0554 6.12918 17.0013 6.01105 16.8165L4.06254 13.7674C3.94441 13.5824 3.99857 13.3368 4.18333 13.2187L4.66594 12.9102C4.85097 12.7921 5.09652 12.8462 5.21466 13.031L5.65878 13.726" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <path id="hw1" d="M7.07859 15.9466L7.56067 15.4785C7.71915 15.3248 7.94692 15.2662 8.15982 15.324L9.90976 15.8008C10.103 15.8669 10.3077 15.8858 10.5086 15.856L13.9268 15.349C14.1397 15.3174 14.3419 15.2319 14.5164 15.1003L16.8134 13.3631C16.9955 13.1764 17.0175 12.8754 16.8644 12.6601C16.6969 12.4247 16.3807 12.3747 16.1572 12.5489L14.6634 13.422C14.27 13.6519 13.8338 13.7894 13.3847 13.8255L13.3897 13.4982C13.3348 13.1058 13.0327 12.8024 12.6581 12.7637L10.939 12.633C10.5418 12.5919 10.3385 12.4616 9.98515 12.2648C9.64031 12.0729 9.00506 11.8494 8.66261 11.7634C8.06134 11.6123 7.42396 11.7249 6.89728 12.0519L5.24609 13.078" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                </i>
                                {!! app('common')->responsibility($operation->responsibility) !!}
                            </li>
                            <li class="sicon">
                                @if($operation->preferred_currency == 'USD')
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
                                {{ app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount) }}
                            </li>
                        </ul>
                        @if($operation->cheque_type != '' || $operation->cheque_type != '' || $operation->cheque_payee_type != '' || $operation->seller?->account_type != '')
                        <ul class="second">
                            @if (isset($operation->cheque_status) && $operation->cheque_status != '')
                            <li><i><img src="{{ app('common')->operationChequeStatus($operation->cheque_status) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $operation->cheque_status }}" alt="{{ $operation->cheque_status }}"></i></li>
                            @endif
                            
                            @if (isset($operation->cheque_type) && $operation->cheque_type != '')
                            <li><i><img src="{{ app('common')->operationChequeType($operation->cheque_type) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $operation->cheque_type }}" alt="{{ $operation->cheque_type }}"></i></li>
                            @endif

                            @if (isset($operation->cheque_payee_type) && $operation->cheque_payee_type != '')
                            <li><i><img src="{{ app('common')->operationChequePayeeType($operation->cheque_payee_type) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $operation->cheque_payee_type }}" alt="{{ $operation->cheque_payee_type }}"></i></li>
                            @endif

                            @if (isset($operation->seller) && $operation->seller?->account_type != '')
                            <li><i><img src="{{ app('common')->userAccountType($operation->seller?->account_type) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $operation->seller?->account_type }}"  alt="{{ $operation->seller?->account_type }}"></i></li>
                            @endif
                        </ul>
                        @endif
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
                                        <span>{!! __('BCP') !!}</span>
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
                                        <span>{!! __('Inforconf') !!}</span>
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
                                        <span>{!! __('Infocheck') !!}</span>
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
                                        <span>{!! __('Criterium') !!}</span>
                                    </div>
                                </li>
                                @endpermission
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="rightpart">
                    <div class="userLocation">
                        @if ($operation->mipo_verified == 'Yes')
                            @permission('explore-operations-mipo-plus')
                                <div class="mipoplus"><img src="{{ asset('images/mipo/ofrmipoplus.svg') }}" alt="mipo-verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Mipo Verified') }}"></div>
                            @endpermission
                        @endif
                        <ul>
                            
                        @if ($operation->seller->address_verify == 'Yes')
                            <li><i><img src="{{ $operation->seller->address_verify_img }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ __('Address Verified')}}" alt="{{ __('Address verified')}}"></i></li>
                        @endif

                        @if(isset($operation->seller->user_level) && !empty($operation->seller->user_level))
                            <li><i><img src="{{ app('common')->userLevelImage($operation->seller->user_level) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ __('User Level') }}" alt="user level"></i></li>
                        @endif
                        
                        </ul>
                        <p>{{ $operation->seller->city?->name ?? __('Unknown City') }}</p>
                    </div>
                    <div class="expireDay">
                        {{ app('common')->diffForHumans($operation->expiration_date) }}
                        {{-- {!! __('Expires in') !!} {{ $operation->expire_days }} {{  ($operation->expire_days > 1)? __('days') :  __('day') }} --}}
                    </div>
                    <div class="down_share">
                        <ul>
                            @permission('explore-operations-export')
                            <li>
                                <a class="evt_download_pdf_btn" href="javascript:void(0);"  data-href="{{ route('export.explore-operation-detail', $operation->slug) }}"
                                data-file-name="{{ $operation->operation_number }}"
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ __('Export') }}"
                                >
                                <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="0.0922852" width="20" height="20" rx="10" fill="#FAFAFA"/>
                                <path d="M5.09229 12.5V13.75C5.09229 14.0815 5.22398 14.3995 5.4584 14.6339C5.69282 14.8683 6.01076 15 6.34229 15H13.8423C14.1738 15 14.4917 14.8683 14.7262 14.6339C14.9606 14.3995 15.0923 14.0815 15.0923 13.75V12.5M12.5923 10L10.0923 12.5M10.0923 12.5L7.59229 10M10.0923 12.5V5" stroke="#939393" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                </a>
                            </li>
                            @endpermission
                            @permission('explore-operations-share-operation')
                            <li>
                                <a class="evt_share_btn" data-share-val="{{ route('explore-operations.details', $operation->slug) }}" href="javascript:;"
                                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ __('Share') }}"
                                    >
                                <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="0.0922852" width="20" height="20" rx="10" fill="#FAFAFA"/>
                                <path d="M7.62941 9.42852C7.50501 9.20467 7.30978 9.02846 7.0744 8.92756C6.83901 8.82666 6.57678 8.80678 6.32887 8.87104C6.08096 8.9353 5.8614 9.08007 5.70467 9.28261C5.54793 9.48515 5.46289 9.734 5.46289 9.99011C5.46289 10.2462 5.54793 10.4951 5.70467 10.6976C5.8614 10.9001 6.08096 11.0449 6.32887 11.1092C6.57678 11.1734 6.83901 11.1535 7.0744 11.0526C7.30978 10.9517 7.50501 10.7755 7.62941 10.5517M7.62941 9.42852C7.7219 9.59499 7.77482 9.78613 7.77482 9.99011C7.77482 10.1941 7.7219 10.3857 7.62941 10.5517M7.62941 9.42852L12.5444 6.6982M7.62941 10.5517L12.5444 13.282M12.5444 13.282C12.4707 13.4148 12.4238 13.5607 12.4064 13.7116C12.3891 13.8625 12.4017 14.0153 12.4434 14.1613C12.4851 14.3073 12.5552 14.4437 12.6496 14.5626C12.744 14.6816 12.861 14.7807 12.9937 14.8545C13.1265 14.9282 13.2725 14.9751 13.4233 14.9924C13.5742 15.0098 13.727 14.9972 13.873 14.9555C14.019 14.9138 14.1554 14.8437 14.2743 14.7493C14.3933 14.6548 14.4925 14.5379 14.5662 14.4052C14.7151 14.1371 14.7515 13.8208 14.6672 13.5259C14.5829 13.231 14.385 12.9816 14.1169 12.8327C13.8488 12.6838 13.5325 12.6474 13.2376 12.7317C12.9427 12.8159 12.6933 13.0139 12.5444 13.282V13.282ZM12.5444 6.6982C12.6165 6.83392 12.7149 6.9539 12.8338 7.05115C12.9528 7.14839 13.09 7.22094 13.2373 7.26455C13.3847 7.30816 13.5392 7.32196 13.692 7.30515C13.8447 7.28833 13.9925 7.24124 14.1269 7.16661C14.2612 7.09199 14.3793 6.99134 14.4743 6.87054C14.5692 6.74974 14.6392 6.61122 14.68 6.46308C14.7208 6.31494 14.7316 6.16015 14.7119 6.00776C14.6922 5.85537 14.6423 5.70844 14.5652 5.57555C14.4131 5.31369 14.1644 5.12194 13.8725 5.04152C13.5805 4.9611 13.2687 4.99843 13.004 5.14548C12.7393 5.29254 12.5429 5.53758 12.4569 5.82793C12.371 6.11828 12.4024 6.43076 12.5444 6.6982V6.6982Z" stroke="#939393" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                </a>
                            </li>
                            @endpermission
                        </ul>
                    </div>
                </div>
                <a href="{{ route('explore-operations.details', $operation->slug) }}" class="full_link"></a>
            </div>
            <div class="showmore_wrap">
                <div class="openmore_data">
                    <div class="exradata_wrap">
                        <div class="userdetail">
                            <ul class="dropdown_left_dtl">
                                @permission('explore-operations-payee')
                                    <li>
                                        <div class="drop_dtl_heading">{!! __('Payer') !!}</div>
                                        <div class="drop_dtl_info"><a href="javascript:void(0)">
                                            {{ $operation->issuer?->company_name ?? '-' }}
                                        </a></div>
                                    </li>
                                @endpermission
                                <li>
                                    <div class="drop_dtl_heading">{{ __('Seller') }}</div>
                                    <div class="drop_dtl_info"><a href="javascript:void(0)">
                                        {{ app('common')->lockOperationDetail($operation, ['seller_name']) }}
                                    </a></div>
                                </li>
                                @permission('explore-operations-with-resource')
                                <li>
                                    <div class="drop_dtl_heading">{!! __('Responsibility') !!}</div>
                                    <div class="drop_dtl_info">
                                        {!! app('common')->responsibility($operation->responsibility) !!}
                                    </div>
                                </li>
                                @endpermission
                                <li>
                                    <div class="drop_dtl_heading">{!! __('Bank') !!}</div>
                                    <div class="drop_dtl_info">{{ $operation->issuer_bank?->name }}</div>
                                </li>
                                @permission('explore-operations-comercial-reference')
                                <li>
                                    <div class="drop_dtl_heading">{!! __('Commercial References') !!}</div>
                                    <div class="drop_dtl_info">{{ $operation->references->first()->name ?? __('N/A') }} </div>
                                </li>
                                @endpermission
                            </ul>
                        </div>
                        <div class="attached_doc">
                            <div class="attach_sldr owl-carousel">
                                
                                @if ($operation->documents && $operation->documents->count() > 0)
                                    @foreach ($operation->documents as $document)
                                        @if ($document->document_url != '')
                                            @if ($document->extension != 'pdf')
                                                <div class="attachbox">
                                                    <div class="imgbox">
                                                        <img src="{{ $document->document_url }}" alt="no-image"  data-fancybox>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                                
                                @if ($operation->supportingAttachments && $operation->supportingAttachments->count() > 0)
                                    @foreach ($operation->supportingAttachments as $attachments)
                                        @if ($attachments->attachment_url != '')
                                            @if ($attachments->extension != 'pdf')
                                                <div class="attachbox">
                                                    <div class="imgbox">
                                                        <img src="{{ $attachments->attachment_url }}"  alt="attachments-image" data-fancybox>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @permission('explore-operations-show-more')
                    <div class="evt_showmore showmore" id="showmore_wrap_{{$key}}">
                        <a href="javascript:void(0)" data-index="{{$key}}"><span class="show-More" id="txt_show_more_{{$key}}">{!! __('Show more') !!}</span>
                        <i><img src="{{ asset('images/mipo/bigbluedown.svg') }}" alt="no-image"></i></a>
                    </div>
                @endpermission
            </div>
        </div>
    @endforeach
</div>
@endif

{{-- pagination:st --}}
@if ($last_page > 1)
    <div class="bottom_pageSec">
        <div class="expdoc_pager evt_paginate_operations">
            {!! $operations->links() !!}
        </div>
        @if ($last_page > 1)
            <div class="exp_sortwrp">
                <span>{!! __('Go to Page') !!}</span>
                <input type="number" name="page_no" id="page_no" placeholder="" value="">
                <a href="javascript:void(0)" class="evt_got_to_page" data-last-page="{{ $last_page }}">{!! __('Go') !!} <i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <g clip-path="url(#clip0_3013_38074)">
                    <rect width="16" height="16" rx="8" transform="matrix(1.19249e-08 -1 -1 -1.19249e-08 16 16)" fill="white"/>
                    <path d="M6 12L10 8L6 4" stroke="black" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_3013_38074">
                        <rect width="16" height="16" rx="8" transform="matrix(1.19249e-08 -1 -1 -1.19249e-08 16 16)" fill="white"/>
                    </clipPath>
                    </defs>
                </svg></i></a>
            </div>
        @endif
    </div>
@endif
{{-- pagination:nd --}}

{{--no operation found :st --}}
@if (isset($operations) && $operations->count() == 0)
    <div class="ope_notfoundWrap">
        <div class="imgbox">
            <svg width="250" height="200" viewBox="0 0 250 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="250" height="200" fill="white"/>
                <path id="notf1" fill-rule="evenodd" clip-rule="evenodd" d="M207 65C210.866 65 214 68.134 214 72C214 75.866 210.866 79 207 79H167C170.866 79 174 82.134 174 86C174 89.866 170.866 93 167 93H189C192.866 93 196 96.134 196 100C196 103.866 192.866 107 189 107H178.826C173.952 107 170 110.134 170 114C170 116.577 172 118.911 176 121C179.866 121 183 124.134 183 128C183 131.866 179.866 135 176 135H93C89.134 135 86 131.866 86 128C86 124.134 89.134 121 93 121H54C50.134 121 47 117.866 47 114C47 110.134 50.134 107 54 107H94C97.866 107 101 103.866 101 100C101 96.134 97.866 93 94 93H69C65.134 93 62 89.866 62 86C62 82.134 65.134 79 69 79H109C105.134 79 102 75.866 102 72C102 68.134 105.134 65 109 65H207ZM207 93C210.866 93 214 96.134 214 100C214 103.866 210.866 107 207 107C203.134 107 200 103.866 200 100C200 96.134 203.134 93 207 93Z" fill="#F3F7FF"/>
                <path id="notf2" fill-rule="evenodd" clip-rule="evenodd" d="M153.672 63.9991L162.974 131.842L163.809 138.648C164.079 140.841 162.519 142.837 160.327 143.106L101.767 150.296C99.5738 150.565 97.5781 149.006 97.3089 146.813L88.2931 73.3859C88.1585 72.2896 88.9381 71.2917 90.0344 71.1571C90.0414 71.1562 90.0483 71.1554 90.0552 71.1546L107.5 67.999" fill="white"/>
                <path id="notf3" d="M154.91 63.8293C154.816 63.1454 154.186 62.667 153.502 62.7607C152.818 62.8545 152.34 63.485 152.433 64.1689L154.91 63.8293ZM162.974 131.842L164.214 131.69C164.214 131.684 164.213 131.678 164.212 131.672L162.974 131.842ZM97.3089 146.813L98.5495 146.661L97.3089 146.813ZM88.2931 73.3859L87.0524 73.5382L88.2931 73.3859ZM90.0552 71.1546L90.1946 72.3968C90.2224 72.3937 90.2502 72.3897 90.2777 72.3847L90.0552 71.1546ZM107.723 69.2291C108.402 69.1062 108.853 68.4559 108.73 67.7765C108.607 67.0972 107.957 66.6461 107.277 66.769L107.723 69.2291ZM152.433 64.1689L161.735 132.012L164.212 131.672L154.91 63.8293L152.433 64.1689ZM161.733 131.994L162.569 138.801L165.05 138.496L164.214 131.69L161.733 131.994ZM162.569 138.801C162.754 140.308 161.682 141.68 160.174 141.865L160.479 144.347C163.357 143.993 165.403 141.374 165.05 138.496L162.569 138.801ZM160.174 141.865L101.614 149.055L101.919 151.537L160.479 144.347L160.174 141.865ZM101.614 149.055C100.107 149.241 98.7346 148.169 98.5495 146.661L96.0682 146.966C96.4215 149.844 99.041 151.89 101.919 151.537L101.614 149.055ZM98.5495 146.661L89.5338 73.2336L87.0524 73.5382L96.0682 146.966L98.5495 146.661ZM89.5338 73.2336C89.4833 72.8224 89.7757 72.4482 90.1868 72.3978L89.8821 69.9164C88.1006 70.1351 86.8337 71.7567 87.0524 73.5382L89.5338 73.2336ZM90.1868 72.3978C90.1894 72.3974 90.192 72.3971 90.1946 72.3968L89.9159 69.9124C89.9046 69.9137 89.8934 69.915 89.8821 69.9164L90.1868 72.3978ZM90.2777 72.3847L107.723 69.2291L107.277 66.769L89.8327 69.9246L90.2777 72.3847Z" fill="#0D6EFD"/>
                <path id="notf4" fill-rule="evenodd" clip-rule="evenodd" d="M151.14 68.2686L159.559 129.752L160.317 135.921C160.561 137.908 159.167 139.714 157.203 139.955L104.761 146.394C102.797 146.635 101.008 145.22 100.764 143.233L92.6139 76.8562C92.4792 75.7599 93.2589 74.762 94.3552 74.6274L100.843 73.8308" fill="#F3F7FF"/>
                <path id="notf5" d="M107.922 54C107.922 52.4812 109.153 51.25 110.672 51.25H156.229C156.958 51.25 157.657 51.5395 158.173 52.0549L171.616 65.4898C172.132 66.0056 172.422 66.7053 172.422 67.4349V130C172.422 131.519 171.191 132.75 169.672 132.75H110.672C109.153 132.75 107.922 131.519 107.922 130V54Z" fill="white" stroke="#0D6EFD" stroke-width="2.5"/>
                <path id="notf6" d="M156.672 52.4023V63.9995C156.672 65.6564 158.015 66.9995 159.672 66.9995H171.605" stroke="#0D6EFD" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path id="notf7" d="M118 118H144M118 67H144H118ZM118 79H161H118ZM118 92H161H118ZM118 105H161H118Z" stroke="#0D6EFD" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                
        <strong class="text-20-semibold">{!! __('No operation was found') !!}</strong>
        <p class="text-16-medium">{!! __('Try different filters or upload your operations') !!}</p>

        <div class="newoprationBtn">
            <a href="{{ route('operations.create')}}" class="text-16-medium"><i><img src="{{ asset('images/mipo/addplus.png') }}" alt="no-image"></i> {!! __('Create New Operation') !!}</a>
        </div>
    </div>
@endif
{{--no operation found :nd --}}