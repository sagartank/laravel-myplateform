{{-- <x-guest-layout>
    @section('custom_style')
    @endsection
    <div class="inner-page-outer inner-page-outer_plan">
		<div class="inner-logo">
			<a href="javascript:;"><img src="{{ asset('images/logo.svg') }}" alt="mipo-logo"  /></a>
		</div>

		<div class="plan-page-outer">
			<div class="plan-block-inner">
				<div class="row">
                    <div class="col-md-12 text-center">
						<div style="height: 130px; width: 100%; margin: auto" id="iframe-container"/>
					</div>
				</div>
			</div>
		</div>
	</div> --}}
    <x-app-layout>
        @section('pageTitle', 'Payment Gateway')
        @section('custom_style')
        <style>
            #iframe-container iframe {
                min-height: 400px;
            }
            
            #iframe-container iframe {
                -webkit-scrollbar{display: none;}
            }
        </style>
        @endsection
        @php
            if($offer->mipo_plus_commission > 0 && $offer->mipo_commission > 0) {
            $total_amount = ($offer->mipo_plus_commission + $offer->mipo_commission);
            } else {
                $total_amount = ($offer->mipo_commission);
            }
        @endphp
        <div class="payment_gateway">
            <div class="container">
                <div class="arobox">
                    <a href="{{ route('deals.index') }}">
                        <i><img src="{{ asset('images/mipo/topleftAro.svg') }}" class="day" alt="no-image"></i>
                        <i><img src="{{ asset('images/mipo/white_lft_aro.svg') }}" class="night" alt="no-image"></i>
                    </a>
                    <h2 class="text-24-semibold">{!! __('Payment') !!}</h2>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="" id="iframe-container">
                            {{-- <img src="{{ asset('images/mipo/pay_gatway.png') }}" alt="no-image"> --}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="payment_contain">
                            <div class="mobile_lr head">
                                <p class="text-14-medium">{!! __('Details') !!}</p>
                                <h6 class="text-14-medium">{!! __('Total') !!}</h6>
                            </div>
                        <div class="payment_content">
                            <div class="mobile_lr innerdatail">
                                    <p class="text-14-medium">{!! __('Commission') !!}</p>
                                    <h6 class="text-14-medium">{{  $offer->preferred_currency }} {{ app('common')->currencyNumberFormat($offer->preferred_currency, $offer->mipo_commission) }}</h6>
                            </div>
                            <div class="mobile_lr innerdatail">
                                <p class="text-14-medium">{!! __('MIPO+') !!}</p>
                                <h6 class="text-14-medium">{{ $offer->preferred_currency }} {{  app('common')->currencyNumberFormat($offer->preferred_currency, $offer->mipo_plus_commission) }}</h6>
                            </div>
                            <div class="mobile_lr">
                                <p class="text-14-medium">{!! __('Total') !!}</p>
                                <h6 class="text-14-medium">{{ $offer->preferred_currency }} {{  app('common')->currencyNumberFormat($offer->preferred_currency, $total_amount) }}</h6>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @section('custom_script')
    <script src="{{$scriptUrl}}"></script>
        <script type="text/javascript">
            window.onload = function () {

            /*   var styles = {
                'input-background-color' : '#453454',
                'input-text-color': '#B22222',
                'input-border-color' : '#CCCCCC',
                'input-placeholder-color' : '#999999',
                'button-background-color' : '#5CB85C',
                'button-text-color' : '#FFFFFF',
                'button-border-color' : '#4CAE4C',
                'form-background-color' : '#999999',
                'form-border-color' : '#DDDDDD',
                'header-background-color' : '#F5F5F5',
                'header-text-color' : '#333333',
                'hr-border-color' : '#B22222'
            }; */

            var styles = {
                'input-background-color' : '#FFFFFF',
                'input-text-color': '#000000',
                'input-border-color' : '#CCCCCC',
                'input-placeholder-color' : '#FFFFFF',
                'button-background-color' : '#5CB85C',
                'button-text-color' : '#FFFFFF',
                'button-border-color' : '#4CAE4C',
                'form-background-color' : '#FFFFFF',
                'form-border-color' : '#DDDDDD',
                'header-background-color' : '#F5F5F5',
                'header-text-color' : '#333333',
                'hr-border-color' : '#FAFAFA'
            };

            options = {
                styles: styles
            }

            Bancard.Checkout.createForm('iframe-container', '{{$processId}}', options);
            };
        </script>
    @endsection
{{-- </x-guest-layout> --}}
</x-app-layout>