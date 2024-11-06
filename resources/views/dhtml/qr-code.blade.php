<x-app-layout>
    @section('custom_style')
      
    @endsection
<div class="qr_pay_wrap">
    <div class="container">
            <div class="arobox">
                <a href="javascript:;">
                    <i><img src="{{ asset('images/mipo/topleftAro.svg') }}" class="day" alt="no-image"></i>
                    <i><img src="{{ asset('images/mipo/white_lft_aro.svg') }}" class="night" alt="no-image"></i>
                </a>
                <h2 class="text-24-semibold">{!! __('Payment') !!}</h2>
            </div>
            <div class="qr_container">
                <div class="profilebox">
                    <img src="{{ asset('images/mipo/qr_profile.png') }}" class="night" alt="no-image">
                </div>
                <div class="inner_qr">
                    <div class="qrinfo">
                        <strong class="text-24-medium">James</strong>
                        <p class="text-14-medium">{!! __('Payment QR') !!}</p>
                    </div>
                    <div class="imgbox">
                        <img src="{{ asset('images/mipo/qr_pay.png') }}" class="day" alt="no-image">
                    </div>
                </div>
                <div class="notes">
                    <p class="text-14-medium">{!! __('OBSERAVATION: Keep in mind that once this QR is scanned by the buyer, the system will automatically proceed to take it as paid, please ONLY show this QR once you received the funds in cash. MIPO recommends to use bank transfer for every operation for your own security.') !!}</p>
                </div>
            </div>
    </div>
</div>
  
    @section('custom_script')
        <script>
          
        </script>
    @endsection
</x-app-layout>
