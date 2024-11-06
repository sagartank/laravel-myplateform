@props(['user']) 
<div class="protabdetail">
    <div class="protab_outerbox">
        <div class="planrow">
            <div class="planbox">
                <p class="text-14-medium">{!! __('Plan') !!}</p>
                <div class="planinfo">
                    <h3 class="text-20-semibold">{!! __('Basic') !!}</h3>
                    <div class="status">
                        <a href="javascript:;" class="text-14-semibold"><span>{!! __('Active') !!}</span></a>
                    </div>
                </div>
            </div>
            <div class="planbox">
                <p class="text-14-medium">{!! __('Payment') !!}</p>
                <div class="planinfo">
                    <h3 class="text-20-semibold">{{$user->plan?->name}}</h3>
                        <p class="text-14-medium">{!! __('Month') !!}</p>
                </div>
            </div>
            <div class="planbox">
                <div class="upgradebtn">
                    <a href="{{route('user.plans')}}" class="text-16-medium">{!! __('Upgrade Account') !!} <i><img src="{{ asset('images/mipo/upgradebtnAro.svg') }}" alt="no-image"></i></a>
                </div>
            </div>
        </div>

        <div class="plans_Table">
            <table>
                <thead>
                    <tr class="forbg">
                        <th class="text-14-medium">{!! __('Subscription Number') !!}</th>
                        <th class="text-14-medium">{!! __('Plan') !!}</th>
                        <th class="text-14-medium">{!! __('Price') !!}</th>
                        <th class="text-14-medium">{!! __('Start Date') !!}</th>
                        <th class="text-14-medium">{!! __('Expiration Date') !!}</th>
                    </tr>
                </thead>
                <tbody>
                    @if($user->subscriptionPlans)
                        @foreach($user->subscriptionPlans as $row)
                            <tr>
                                <td class="text-12-medium">{{$row->subscription_no}}</td>
                                <td class="text-12-medium">{{$row->name}}</td>
                                <td class="text-12-medium">{{$row->currency}}{{$row->price}}</td>
                                <td class="text-12-medium">{{$row->starts_at}}</td>
                                <td class="text-12-medium">{{$row->ends_at}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>    
            </table>
        </div>

        {{-- mobile paln:st --}}
        <div class="mb_planrow">
            <div class="planbox">
                <div class="lft"><p class="text-16-medium">{{ __('Plan') }}</p></div>
                <div class="right">
                    <div class="tag">
                        <a href="javascript:;" class="text-12-semibold"><span>{{ __('Active') }}</span></a>
                    </div>
                    <p class="text-16-medium">{{$user->plan?->name}}</p>
                </div>
            </div>
            <div class="planbox">
                <div class="lft"><p class="text-16-medium">{{ __('Payment') }}</p></div>
                <div class="right">
                    <h6 class="text-14-medium">{{ __('Month') }}<span class="text-14-semibold">
                        {{-- Gs.000.00 --}}
                        {{ $user->plan?->currency }} {{ $user->plan?->price }}
                    </span></h6>
                </div>
            </div>
            <div class="mbupgrade_btn">
                <a href="{{route('user.plans')}}">{{ __('Upgrade Account')}} <i><img src="{{ asset('images/mipo/upgradebtnAro.svg') }}" alt="no-image"></i></a>
            </div>
        </div>

        <div class="mobile_cmn_table_wrap">
            @foreach($user->subscriptionPlans as $row)
            <div class="mb_plan_table">
                <div class="mb_boxdata">
                    <div class="lft"><p class="text-16-medium">{!! __('Subscription Number') !!}</p></div>
                    <div class="right"><p class="text-16-medium">{{$row->subscription_no}}</p></div>
                </div>
                <div class="mb_boxdata">
                    <div class="lft"><p class="text-16-medium">{!! __('Plan') !!}</p></div>
                    <div class="right"><p class="text-16-medium">{{$row->name}}</p></div>
                </div>
                <div class="mb_boxdata">
                    <div class="lft"><p class="text-16-medium">{!! __('Price') !!}</p></div>
                    <div class="right"><p class="text-16-medium">{{$row->currency}}{{$row->price}}</p></div>
                </div>
                <div class="mb_boxdata">
                    <div class="lft"><p class="text-16-medium">{!! __('Start Date') !!}</p></div>
                    <div class="right"><p class="text-16-medium">{{$row->starts_at}}</p></div>
                </div>
                <div class="mb_boxdata">
                    <div class="lft"><p class="text-16-medium">{!! __('Expiration Date') !!}</p></div>
                    <div class="right"><p class="text-16-medium">{{$row->ends_at}}</p></div>
                </div>
            </div>
            @endforeach
        </div>
        {{-- mobile paln:nd --}}
    </div>
</div>