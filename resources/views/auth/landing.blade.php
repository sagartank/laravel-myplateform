<x-guest-layout>
    @section('pageTitle', 'User Congratulations') 
    @section('custom_style')
    @endsection

    <div class="land_page">
        <div class="conacc_section">
            <div class="image">
                <img src="{{asset('images/mipo/succesverify.svg')}}" alt="mipo">
            </div>
            <h5 class="text-24-semibold">{!! __('Congratulations') !!}!</h5>
            <p class="text-16-medium">{!! __('Your account is pending review, if everything’s ok it should be approved within 12-48 hours or rejected in case we’ve find missing info') !!}.</p>
        </div>
    </div>
    <form action="{{ route('logout') }}" id="web-logout-form" name="logout-form" method="post">
        @csrf
    </form>
    @section('custom_script')
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
