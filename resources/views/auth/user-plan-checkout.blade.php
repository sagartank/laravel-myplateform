<x-guest-layout>
    @section('custom_style')
    @endsection
    <div class="inner-page-outer inner-page-outer_plan">
		<div class="inner-logo">
			<a href="javascript:;"><img src="{{ asset('images/logo.svg') }}" alt="mipo-logo"  /></a>
		</div>

		<div class="plan-page-outer">
			<div class="plan-block-inner">
				<div class="row">
                     <div class="col-md-4">
						<div class="card mb-5 mb-lg-0">
							<div class="card-body">
								<h5 class="card-title text-muted text-uppercase text-center">{{$plan->name}}</h5>
								<h6 class="card-price text-center">{{$plan->currency}}{{$plan->price}}</h6>
								<hr>
								<ul class="pricing_list">
									<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($plan->buy_sell) }}" alt=""></i>Buy & Sell </div></li>
									<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($plan->basic_dashboard) }}" alt=""></i>Basic Dashboard </div></li>
									<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($plan->enterprise_dashboard) }}" alt=""></i>Enterprise Dashboard </div></li>
									<li><div class="coman-text text-1"><i></i>Multi User Account: &nbsp;<strong><span>{{ $plan->multi_user_account }} User</span></strong></div></li>
									<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($plan->exportable_pdf) }}" alt=""></i>Exportable PDF </div></li>
									<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($plan->offer_notifications) }}" alt=""></i>Offer Notifications </div></li>
									<li><div class="coman-text text-1"><i></i>Legal Advice: &nbsp;<strong><span>{{ $plan->legal_advice }}</span></strong></div></li>
									<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($plan->monthly_reports) }}" alt=""></i>Monthly Reports </div></li>
									<li><div class="coman-text text-1"><i></i>Newsletters: &nbsp; <strong><span>{{ $plan->newsletters }}</span></strong></div></li>
									<li><div class="coman-text text-1"><i></i>Investor Commission: &nbsp; <strong><span>{{ $plan->investor_commission }}%</span></strong></div></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div style="height: 130px; width: 100%; margin: auto" id="iframe-container"/>
					</div>
				</div>
			</div>
		</div>
	</div>
    @section('custom_script')
    <script src="{{$scriptUrl}}"></script>
        <script type="text/javascript">
            window.onload = function () {

            var styles = {
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
            };

            options = {
                styles: styles
            }

            Bancard.Checkout.createForm('iframe-container', '{{$processId}}', options);
            };
        </script>
    @endsection
</x-guest-layout>