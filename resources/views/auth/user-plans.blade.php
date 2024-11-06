<x-guest-layout>
    @section('custom_style')
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @endsection
    <div class="inner-page-outer inner-page-outer_plan">
		<div class="main_plan">
			<div class="inner-logo">
				<a href="{{ route('dashboard') }}"><img src="{{ asset('images/logo.svg') }}" alt="mipo-logo"/></a>
			</div>

			<div class="plan-page-outer">
				<div class="plan-title">
					<h1>{!! __('Get Better Benefits with our Plans') !!}</h1>
					<h4>{!! __('Choose a plan that suits your needs') !!}</h4>
				</div>
				<div class="plan-block-inner">
					<div class="top-block-plan">
						<h5>{!! __('Monthly Payments') !!}</h5>
						<form>
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" id="plan_switch" name="plan_switch" value="yes">
								<label class="form-check-label" for="plan_switch"></label>
							</div>
						</form>
						<h5>{!! __('Anual Payment') !!}</h5>
					</div>
					<div class="tab-block-bottom">
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="month-plan" role="tabpanel" aria-labelledby="month-plan-tab">
								<div class="row">
									@foreach($months as $month)
										@php
											$class = "";
											if($user_paln->plan->slug == $month->slug)
											{
												$class = "bg_plan";
											}	
										@endphp
										<div class="col-lg-4 col-md-6">
											<div class="card mb-5 mb-lg-0">
												<div class="card-body {{ $class }}">
													<h5 class="card-title text-muted text-uppercase text-center">{{$month->name}}</h5>
													<p>{!! __('Ideal para personas que necesitan un acceso rápido a las funciones básicas.') !!}</p>
													<h6 class="card-price text-center">{{$month->currency}}{{$month->price}}<span class="period">/{!! __('Month') !!}</span></h6>
													<div class="d-grid  plan-btn">
														@if($user->plan_id == $month->id) 
															<!-- <span class="btn btn-primary text-uppercase">Current Plan</span> -->
														@else
														@endif
														
														<a href="{{route('user-plan.checkout', $month->slug)}}" class="{{ $class }} text-uppercase">{{($month->is_free_plan) ? 'Try Free' : 'Pay Now'}}</a>
													</div>
													<ul class="pricing_list">
														<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($month->buy_sell) }}" alt=""></i>Buy & Sell </div></li>
														<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($month->basic_dashboard) }}" alt=""></i>	 Dashboard </div></li>
														<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($month->enterprise_dashboard) }}" alt=""></i>Enterprise Dashboard </div></li>
														<li><div class="coman-text text-1"><i></i>Multi User Account: &nbsp;<strong><span>{{ $month->multi_user_account }} User</span></strong></div></li>
														<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($month->exportable_pdf) }}" alt=""></i>Exportable PDF </div></li>
														<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($month->offer_notifications) }}" alt=""></i>Offer Notifications </div></li>
														<li><div class="coman-text text-1"><i></i>Legal Advice: &nbsp;<strong><span>{{ $month->legal_advice }}</span></strong></div></li>
														<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($month->monthly_reports) }}" alt=""></i>Monthly Reports </div></li>
														<li><div class="coman-text text-1"><i></i>Newsletters: &nbsp; <strong><span>{{ $month->newsletters }}</span></strong></div></li>
														<li><div class="coman-text text-1"><i></i>Investor Commission: &nbsp; <strong><span>{{ $month->investor_commission }}%</span></strong></div></li>
													</ul>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>

							<div class="tab-pane fade" id="year-plan" role="tabpanel" aria-labelledby="year-plan-tab">
								<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
									<div class="row">
										@foreach($years as $year)
											<div class="col-lg-4 col-md-6">
												<div class="card mb-5 mb-lg-0">
													<div class="card-body">
														<h5 class="card-title text-muted text-uppercase text-center">{{$year->name}}</h5>
														<p>Ideal para personas que necesitan un acceso rápido a las funciones básicas.</p>
														<h6 class="card-price text-center">{{$year->currency}}{{$year->price}}<span class="period">/year</span></h6>
														<div class="d-grid plan-btn">
															@if($user->plan_id == $month->id) 
																<span class="btn btn-primary text-uppercase">Current Plan</span>
															@else
																<a href="{{route('user-plan.checkout',$month->slug)}}" class="btn btn-primary text-uppercase">{{($year->is_free_plan) ? 'Try Free' : 'Pay Now'}}</a>
															@endif
														</div>
														<ul class="pricing_list">
															<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($year->buy_sell) }}" alt=""></i> Buy & Sell </div></li>
															<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($year->basic_dashboard) }}" alt=""></i> Basic Dashboard </div></li>
															<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($year->enterprise_dashboard) }}" alt=""></i> Enterprise Dashboard </div></li>
															<li><div class="coman-text text-1">Multi User Account <span>{{ $year->multi_user_account }} User</span></div></li>
															<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($year->exportable_pdf) }}" alt=""></i> Exportable PDF </div></li>
															<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($year->offer_notifications) }}" alt=""></i> Offer Notifications </div></li>
															<li><div class="coman-text text-1">Legal Advice <span>{{ $year->legal_advice }}</span></div></li>
															<li><div class="coman-text text-1"><i><img src="{{ app('common')->tfImage($year->monthly_reports) }}" alt=""></i> Monthly Reports </div></li>
															<li><div class="coman-text text-1">Newsletters <span>{{ $year->newsletters }}</span></div></li>
															<li><div class="coman-text text-1">Investor Commission <span>{{ $year->investor_commission }} %</span></div></li>
														</ul>
													</div>
												</div>
											</div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    @section('custom_script')
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
		var _year = $('#year-plan');
		var _month = $('#month-plan');
		$('input[type="checkbox"]').change(function(){
			$("#year-plan").addClass("intro");
			if($(this).is(':checked')) {
				$(_month).hide();
				$(_year).show();
			} else {
				$(_year).hide();
				$(_month).show();
			}
        });
    </script>
    @endsection
</x-guest-layout>