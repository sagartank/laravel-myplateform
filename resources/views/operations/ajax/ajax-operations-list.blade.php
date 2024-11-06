@if(isset($operations) && $operations->count() > 0)
    @foreach ($operations as $key => $operation)
    <div class="operatorbox_outer">
        <div class="operation_box">
            <div class="leftpart">
                <div class="top_part_cheque_select">
                    @if($operation->offers_count == 0 || $operation->operations_status !='Approved')
                    {{-- @if($operation->operations_status == 'Pending' || $operation->operations_status == 'Draft') --}}
                    <input type="checkbox" name="operations_checkbox[]" value="{{$operation->id}}" data-operation-status="{{$operation->operations_status}}" class="form-check-input operations_checkbox" id="draft_cheque_check_{{$operation->id}}">
                    @else
                    {{-- <input type="nocheckbox"> --}}
                    @endif
                </div>
                <div class="drafts_sec_imgbox">
                    <div class="img">
                        @if($operation->documents && $operation->documents->count() > 0)
                            @if($operation->documents->first()->document_url !='' && $operation->documents->first()->extension != 'pdf')
                                <img src="{{ $operation->documents->first()->document_url }}" alt="documents">
                            @else
                                <img src="{{ app('common')->setDefaultImage('operation_list') }}" alt="image">
                            @endif
                        @else
                            <img src="{{ app('common')->setDefaultImage('operation_list') }}" alt="image">
                        @endif
                    </div>
                    <div class="ds_text">
                        <div class="opecheck_all_wrp">
                            <div class="first_opecheck">
                                <a href="{{ route('operations.details', $operation->slug)}}" class="codeid text-14-medium">{!! __($operation->operation_type_number) !!}</a>

                                <span class="cash text-14-medium">{!! __($operation->preferred_payment_method) !!}</span>
                            </div>
                            <div class="second_opecheck">
                                <a href="{{ route('profile.public-seller', $operation->seller?->slug) }}" class="name text-14-medium">{!! __($operation->seller?->name) !!}</a>         
                                
                                <div class="imgbox">
                                    <i><img src="{{ asset('images/mipo/singlestr.png') }}" alt="no-image"></i>
                                    <span class="text-14-medium">{{ floor($operation->seller?->ratings_avg_rating_number) }}{!! __('/5') !!} ({{ $operation->seller?->ratings_count }})</span>
                                </div>  
                            </div>
                        </div>
                        <div class="company">
                            <a href="" class="text-14-medium">{{$operation->issuer?->company_name ?? __('N/A')}}</a>
                        </div>
                        <div class="resource_wrap">
                            <p class="text-14-medium">{!! __('Amount Req.') !!}</p>
                            <span class="text-14-medium">
                                {{ (app('common')->currencyBySymbol($operation->preferred_currency)) }}{{ app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount_requested)}}
                            </span>
                        </div>
                        <div class="whattack">
                            <p class="text-14-medium">{!! __('Bank') !!}</p>
                            <span class="text-14-medium">{!! __($operation->issuer_bank?->name) !!}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rightpart">
                @if($operation->operations_status == 'Pending')
                    <div class="pending"><p class="text-14-semibold">{{ __($operation->operations_status) }}</p></div>
                @elseif($operation->operations_status == 'Approved')
                    <div class="approved"><p class="text-14-semibold">{{ __($operation->operations_status) }}</p></div>
                @elseif($operation->operations_status == 'Rejected')
                    <div class="rejected"><p class="text-14-semibold">{{ __($operation->operations_status) }}</p></div>
                @else
                    <div class="draft"><p class="text-14-semibold">{{ __($operation->operations_status) }}</p></div>
                @endif
                
                <div class="expireDay text-14-medium">
                    {{ app('common')->diffForHumans($operation->expiration_date) }}
                    {{-- {!! __('Expires in') !!} {{ __($operation->expire_at)}} --}}
                </div>

                <div class="down_share">
                    <ul class="first">
                        <li class="ficon text-14-medium">
                            <i>
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect y="0.5" width="20" height="20" rx="10" fill="#FAFAFA"></rect>
                                    <path id="hw6" d="M12.0406 5.47443C12.1939 4.84186 13.0936 4.84186 13.2469 5.47443C13.3277 5.80774 13.6634 6.0126 13.9967 5.93182C14.059 5.91674 14.1189 5.89192 14.1739 5.85835C14.7296 5.51968 15.366 6.15566 15.0274 6.71183C14.8488 7.00476 14.9417 7.38674 15.2346 7.56532C15.2891 7.5984 15.3485 7.62322 15.4108 7.6383C16.0434 7.79158 16.0434 8.69129 15.4108 8.84457C15.0775 8.92534 14.8726 9.26109 14.9534 9.59441C14.9685 9.65669 14.9933 9.71654 15.0269 9.77153C15.3655 10.3272 14.7296 10.9637 14.1734 10.625C13.8805 10.4464 13.4985 10.5394 13.3199 10.8323C13.2868 10.8868 13.262 10.9462 13.2469 11.0084C13.0936 11.641 12.1939 11.641 12.0406 11.0084C11.9599 10.6751 11.6241 10.4703 11.2908 10.551C11.2285 10.5661 11.1687 10.5909 11.1137 10.6245C10.558 10.9632 9.92154 10.3272 10.2602 9.77104C10.4388 9.47811 10.3458 9.09614 10.0529 8.91756C9.99842 8.88447 9.93906 8.85965 9.87677 8.84457C9.2442 8.69129 9.2442 7.79158 9.87677 7.6383C10.2101 7.55753 10.4149 7.22178 10.3342 6.88847C10.3191 6.82618 10.2943 6.76633 10.2607 6.71135C9.92202 6.15566 10.558 5.51919 11.1142 5.85786C11.4743 6.07683 11.9409 5.88317 12.0406 5.47443Z" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path id="hw5" d="M11.5635 8.24064C11.5635 8.83733 12.0473 9.32111 12.644 9.32111C13.2407 9.32111 13.7244 8.83733 13.7244 8.24064C13.7244 7.64394 13.2407 7.16016 12.644 7.16016C12.0473 7.16016 11.5635 7.64394 11.5635 8.24064Z" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path id="hw4" d="M11.0337 14.0861L13.3836 13.8262" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path id="hw3" d="M11.0337 14.0861L13.3836 13.8262" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path id="hw2" d="M6.19581 14.5664L7.16316 16.0804C7.28129 16.2654 7.22714 16.5109 7.04237 16.6291L6.55976 16.9373C6.37473 17.0554 6.12918 17.0013 6.01105 16.8165L4.06254 13.7674C3.94441 13.5824 3.99857 13.3368 4.18333 13.2187L4.66594 12.9102C4.85097 12.7921 5.09652 12.8462 5.21466 13.031L5.65878 13.726" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path id="hw1" d="M7.07859 15.9466L7.56067 15.4785C7.71915 15.3248 7.94692 15.2662 8.15982 15.324L9.90976 15.8008C10.103 15.8669 10.3077 15.8858 10.5086 15.856L13.9268 15.349C14.1397 15.3174 14.3419 15.2319 14.5164 15.1003L16.8134 13.3631C16.9955 13.1764 17.0175 12.8754 16.8644 12.6601C16.6969 12.4247 16.3807 12.3747 16.1572 12.5489L14.6634 13.422C14.27 13.6519 13.8338 13.7894 13.3847 13.8255L13.3897 13.4982C13.3348 13.1058 13.0327 12.8024 12.6581 12.7637L10.939 12.633C10.5418 12.5919 10.3385 12.4616 9.98515 12.2648C9.64031 12.0729 9.00506 11.8494 8.66261 11.7634C8.06134 11.6123 7.42396 11.7249 6.89728 12.0519L5.24609 13.078" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </i>
                            {{ app('common')->responsibility($operation->responsibility) }}
                        </li>
                        <li class="sicon text-14-medium">
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
                                        <rect y="0.5" width="20" height="20" rx="10" fill="#FAFAFA"></rect>
                                        <path d="M14.125 6.87625C13.2324 6.06941 12.0717 5.62341 10.8685 5.625C9.5767 5.62673 8.33839 6.1411 7.42556 7.05515C6.51272 7.96921 6 9.2082 6 10.5C6 13.1926 8.17912 15.375 10.8685 15.375C12.069 15.3759 13.2271 14.9312 14.1185 14.127C14.7133 13.5908 14.983 12.3818 14.931 10.5L12.4937 10.5" stroke="#939393" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M10.8687 17V4" stroke="#939393" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </i>
                            @endif
                            {{ app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount)}}
                        </li>
                    </ul>
                </div>
            </div>
            <a href="{{ route('operations.details', $operation->slug)}}" class="full_link"></a>
        </div>
    </div>
    @endforeach

    @if ($last_page > 1)
    <div class="operation_pagination">
        <div class="bottom_pageSec">
            <div class="expdoc_pager evt_paginate_operations">
                {!! $operations->links() !!}
            </div>
            @if ($last_page > 1)
                <div class="exp_sortwrp">
                    <span>{!! __('Go to Page') !!}</span>
                    <input type="number" name="page_no" id="page_no" placeholder="" value="">
                    <a href="javascript:void(0)" class="evt_got_to_page" data-last-page="{{ $last_page }}">
                        {!! __('Go') !!} 
                        <i class="light"><img src="{{ asset('images/mipo/paginationlightright.svg') }}" alt="no-image"></i>
                        <i class="dark"><img src="{{ asset('images/mipo/paginationdarkright.svg') }}" alt="no-image"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endif
    @else
    <div class="op_empty">
        <div class="ope_notfoundWrap">
            <div class="imgbox">
                <i class="day"><img src="{{ asset('images/mipo/operaempty.svg') }}" alt="no-image"></i>
                <i class="night"><img src="{{ asset('images/mipo/operanightmode.svg') }}" alt="no-image"></i>
                <strong class="text-20-semibold">{{ __('There is no operation created yet')}}</strong>
                <p class="text-16-medium">{{ __('Start creating operations')}}</p>
                <div class="newoprationBtn">
                    <a href="{{route('operations.create')}}" class="text-16-medium"><i><img src="{{ asset("images/mipo/addplus.png") }}" alt="no-image"></i>{{ __('Create New Operation') }}</a>
                </div>
            </div>
        </div>
    </div>
@endif