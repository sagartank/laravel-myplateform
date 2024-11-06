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
                     <div class="col-md-12 text-center">
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

           /*  var styles = {
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
</x-guest-layout>