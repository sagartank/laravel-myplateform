<x-guest-layout>
    <style>
        .congratulations_page_userplan {
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            justify-content: center;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .congratulations_page_userplan .plan-page-outer .plan-title {
            padding-bottom: 0;
        }

        .congratulations_page_userplan .plan-page-outer h3 {
            font-weight: 600;
            padding-bottom: 20px;
            font-size: calc(20px + (32 - 20) * ((100vw - 375px) / (1920 - 375)));
        }

        .congratulations_page_userplan .plan-page-outer h1 {
            font-size: calc(35px + (48 - 35) * ((100vw - 375px) / (1920 - 375)));
        }

        .back_btn_wrps {
            padding: 30px 0 0 0;
            text-align: center;
        }
    </style>
    <div class="inner-page-outer congratulations_page_userplan  inner-page-outer_plan">
        <div class="inner-logo">
            <a href="/"><img src="{{ asset('images/logo.svg') }}" alt="mipo-logo" /></a>
        </div>
        @if ($confirmation['response'] == 'S')
            <div class="plan-page-outer">
                <div class="plan-title">
                    <h1>{{ __('Congratulations') }}</h1>
                </div>
                <div class="plan-block-inner">
                    <div class="top-block-plan">
                        <h3>{{ __('Plans') }}</h3>
                        <p> {{ __('Your plan purchase successfully you can see in your plan history') }}</p>
                    </div>
                </div>
                <div class="back_btn_wrps">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">{{ __('Back Dashboard') }}</a>
                </div>
            </div>
        @else
            <div class="plan-page-outer">
                <div class="plan-title">
                    <h1>{{ __('Failed') }}</h1>
                </div>
                <div class="plan-block-inner">
                    <div class="top-block-plan">
                        <h3>{{ __('Plans') }}</h3>
                        <p>{{ __('Your plan purchase was failed due to') }} <b>{{ $confirmation['response_details'] }}</b>{{ __('.please
                            try again.') }}</p>
                    </div>
                </div>
                <div class="back_btn_wrps">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">{{ __('Back Dashboard') }}</a>
                </div>
            </div>
        @endif
    </div>
</x-guest-layout>
