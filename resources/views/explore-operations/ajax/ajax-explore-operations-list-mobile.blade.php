@if (isset($operations) && $operations->count() > 0)
    @foreach ($operations as $key => $operation)
        @if ($operation->offers->count() == 0)
            <div class="mb_operationbox">
        @else
            <div class="mb_operationbox bglightblue">
        @endif
            <div class="leftpart">
                <div class="checknum_namebox">
                    <div class="numbox text-14-medium">{{ $operation->operation_type_number }}</div>
                    <a class="namebox text-14-medium">{!! app('common')->lockOperationDetail($operation, ['seller_name']) !!}</a>
                </div>
                <a class="company text-14-medium">{{ $operation->issuer?->company_name }}</a>
                <p class="text-14-medium">{!! __($operation->responsibility) !!} {!! __('Recurso') !!}</p>
            </div>
            <div class="rightpart">
                <div class="star_rating">
                    <i><img src="{{ asset('images/mipo/mbstar.png') }}" alt="no-image"></i>
                    <span class="text-12-medium">{{ round($operation->seller?->ratings_avg_rating_number, 2) }}{!! __('/5') !!}</span>
                </div>
                <p class="text-12-medium">{!! __('Expires in') !!} {{  $operation->expire_at }}</p>
                {{-- @if($operation->preferred_currency == 'USD')
                <div class="prize">
                    <i><img src="{{ asset('images/mipo/dollar_light_18_18.svg') }}" alt="no-image"></i>
                <span class="text-12-medium">{{ app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount) }}</span>
                </div>
                @else
                <div class="prize">
                    <i><img src="{{ asset('images/mipo/eighteen_gurani.svg') }}" alt="no-image"></i><span class="text-12-medium">{{ app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount) }}</span></div>
                @endif --}}
                <div class="prize">
                    <i class="{{ ($operation->preferred_currency == 'USD') ? 'dlr' : 'gs'}}"></i>
                <span class="text-12-medium ">{{ app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount) }}</span>
                </div>
            </div>
            <a class="full_link" href="{{ route('explore-operations.details', $operation->slug) }}"></a>
            </div>
            
        </div>
    @endforeach
@endif

{{-- pagination:st --}}

{{-- pagination:nd --}}

{{--no operation found :st --}}

{{--no operation found :nd --}}