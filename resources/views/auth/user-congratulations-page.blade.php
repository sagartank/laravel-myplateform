<x-guest-layout>
    @section('pageTitle', 'User Congratulations') 
    @section('custom_style')
    <style>
        .user-congrestulation-info-btn-section {
            padding: 15px 25px 15px 25px;
            line-height:18px;
            color:#FFFFFF;
        }
        .ctm-text-color{
            color:#D3D3D3;
        }
    </style>
    @endsection
    <div class="congo_page">
        <div class="conacc_section">
            <div class="image">
                <img src="{{asset('images/mipo/succesverify.svg')}}" alt="mipo">
            </div>
            <h5 class="text-24-semibold">{!! __('Congratulations') !!}!</h5>
            <p class="text-16-medium">{!! __('Your account is pending review, if everything’s ok it should be approved within 12-48 hours or rejected in case we’ve find missing info') !!}.</p>
        </div>
        <div class="context_section">
            <h6 class="text-18-semibold">{!! __('Do you wish to sell documents from a Business') !!}?</h6>
            <p class="text-14-medium">{!! __('Don’t forget that in order to sell documents from a company it’s necessary to create a Business Account. With it you’ll be able to sell documents from it. In case the company has more than one legal parties to sign contracts, we will review the documents and assign them so they can sign the contracts generated.') !!}</p>
            <div class="button_sec">
                <a href="{{  route('user.company-account') }}" class="text-16-medium">
                    {!! __('Register Business') !!}
                    <i>
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_381_67)">
                                <path d="M9 15.33L13.165 11.165" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9 7L13.165 11.165" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_381_67">
                                    <rect width="22" height="22" fill="white"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </i>
                </a>
            </div>
        </div>
    </div>
        <form action="{{ route('logout') }}" id="web-logout-form" name="logout-form" method="post">
            @csrf
        </form>
    @section('custom_script')
    <!-- <script src="{{ asset('js/animation_lkaot1y9.json') }}"></script> -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script>
        var home_page_url = '/#faq-section';

        logout = () => {
            return new Promise((resolve, reject) => {
                
                setTimeout(() => {
                    $('#web-logout-form').submit();
                }, 8000);

                setTimeout(() => {
                    resolve('success');
                }, 8900);
                });
        }

        logout()
        .then((res) => {
            console.log('success', res);
            redirectHome();
        });

        redirectHome = () => {
            window.location.href = home_page_url;
        }
    </script>
    @endsection
</x-guest-layout>
