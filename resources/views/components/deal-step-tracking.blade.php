@props(['langs', 'operation_detail', 'type', 'preferred_payment_method_deals', 'progress'])

{{-- Note
    # class   => status
    1 green  => complete
    2 current_progress  => progress
    3 progress_error  => progress error dipspute
--}}

{{-- <div class="col-lg-4"> --}}
    <div class="verticle_multistep_wrap">
        <div class="step_inner">
            <div class="titlebox">
                <h3 class="text-24-semibold">{!! __('Status') !!}</h3>
            </div>
            @if ($progress)
                @foreach ($progress as $key => $val)
                    @php
                        $is_data = app('common')->dealsTracking_new($val->title_en, $operation_detail->operations->first()->id, $operation_detail->id, $type);
                    @endphp
                    @if(isset($is_data['class']) && $is_data['class'] == 'complete')
                        <div class="stepbox green" data-status="{{$is_data['class']}}">
                            <div class="lfticon">
                                <div class="green">
                                    <div class="imgbox">
                                        <img src="{{ asset('images/mipo/only_white_right.svg') }}" alt="no-image"
                                            class="check_mark">
                                        <img src="{{ asset('images/mipo/white_exlamention.svg') }}" alt="no-image"
                                            class="error_mark">
                                    </div>
                                </div>
                            </div>
                            <div class="righttxt">
                                <div class="stinfo">
                                    <span class="text-12-medium">{{ __('STEP') }} {{ ($key+1) }} </span>
                                    <p class="text-12-medium">{{ $is_data['data_time'] ?? '' }}</p>
                                </div>
                                <p class="text-14-medium">{{ $langs == 'en' ? $val->title_en : $val->title_es }}</p>
                            </div>
                        </div>
                    @elseif(isset($is_data['class']) && $is_data['class'] == 'current')
                    <div class="stepbox current_progress" data-status="{{$is_data['class']}}">
                        <div class="lfticon">
                            <div class="green">
                                <div class="imgbox">
                                    <img src="{{ asset('images/mipo/only_white_right.svg') }}" alt="no-image"
                                        class="check_mark">
                                    <img src="{{ asset('images/mipo/white_exlamention.svg') }}" alt="no-image"
                                        class="error_mark">
                                </div>
                            </div>
                        </div>
                        <div class="righttxt">
                            <div class="stinfo">
                                <span class="text-12-medium">{{ __('STEP') }} {{ ($key+1) }} </span>
                                <p class="text-12-medium">{{ $is_data['data_time'] ?? '' }}</p>
                            </div>
                            <p class="text-14-medium">{{ $langs == 'en' ? $val->title_en : $val->title_es }}</p>
                        </div>
                    </div>
                    @elseif(isset($is_data['class']) && $is_data['class'] == 'pending')
                        <div class="stepbox" data-status="{{$is_data['class']}}">
                            <div class="lfticon">
                                <div class="green">
                                    <div class="imgbox">
                                        <img src="{{ asset('images/mipo/only_white_right.svg') }}" alt="no-image"
                                            class="check_mark">
                                        <img src="{{ asset('images/mipo/white_exlamention.svg') }}" alt="no-image"
                                            class="error_mark">
                                    </div>
                                </div>
                            </div>
                            <div class="righttxt">
                                <div class="stinfo">
                                    <span class="text-12-medium">{{ __('STEP') }} {{ ($key+1) }} </span>
                                    <p class="text-12-medium">{{ $is_data['data_time'] ?? '' }}</p>
                                </div>
                                <p class="text-14-medium">{{ $langs == 'en' ? $val->title_en : $val->title_es }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
        @if ($operation_detail->is_disputed == 'No' && $operation_detail->offer_status != 'Completed')
            <div class="report_inconvenience">
                <a href="javascript:;" class="text-14-medium evt_report_dispute" data-offer-id="{{ $operation_detail->id }}"><i><img src="{{ asset('images/mipo/tringle_exlamen.svg') }}" alt="no-image"></i>{!! __('Report Inconvenience') !!}</a>
            </div>
        @endif
    </div>
{{-- </div> --}}
