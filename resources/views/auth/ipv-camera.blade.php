<x-guest-layout>
    @section('custom_style')

    @endsection
	<section>
		<div class="ipv_main_page ipv_filled_main_page">
			<div class="ipv_inner">
				<div class="ipv_inner_top">
					<div class="icon_ipv_camera">
						<img src="{{ asset('images/ipv-white-camera-icon.svg') }}" alt="">
					</div> 
					<div class="icon_ipv_btn">
						<a href="#" class="btn btn-primary">La cámara no está activa</a>
					</div> 
				</div>
				<div class="ipv_inner_bottom">
					<div class="ivp_box_modal">
						<div class="ivp_modal_head">
							<div class="ivp_modal_head_left">
								<h6>Este sitio quiere:</h6>
								<div class="dtl_ivp_mod">
									<i>
										<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
											<g clip-path="url(#clip0_96_630)">
											<path d="M10 7.16665L13.0353 5.64932C13.1369 5.59854 13.2499 5.57457 13.3633 5.57969C13.4768 5.5848 13.5871 5.61882 13.6837 5.67852C13.7804 5.73823 13.8602 5.82164 13.9155 5.92084C13.9709 6.02003 13.9999 6.13173 14 6.24532V10.7547C13.9999 10.8682 13.9709 10.9799 13.9155 11.0791C13.8602 11.1783 13.7804 11.2617 13.6837 11.3215C13.5871 11.3812 13.4768 11.4152 13.3633 11.4203C13.2499 11.4254 13.1369 11.4014 13.0353 11.3507L10 9.83332V7.16665Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M2 5.83333C2 5.47971 2.14048 5.14057 2.39052 4.89052C2.64057 4.64048 2.97971 4.5 3.33333 4.5H8.66667C9.02029 4.5 9.35943 4.64048 9.60948 4.89052C9.85952 5.14057 10 5.47971 10 5.83333V11.1667C10 11.5203 9.85952 11.8594 9.60948 12.1095C9.35943 12.3595 9.02029 12.5 8.66667 12.5H3.33333C2.97971 12.5 2.64057 12.3595 2.39052 12.1095C2.14048 11.8594 2 11.5203 2 11.1667V5.83333Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											</g>
											<defs>
											<clipPath id="clip0_96_630">
											<rect width="16" height="16" fill="white" transform="translate(0 0.5)"/>
											</clipPath>
											</defs>
										</svg>
									</i>
									Usa tu cámara
								</div>
							</div>
							<div class="ivp_modal_head_right">
								<a href="#">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<g clip-path="url(#clip0_96_635)">
										<path d="M18 6L6 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M6 6L18 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
										</g>
										<defs>
										<clipPath id="clip0_96_635">
										<rect width="24" height="24" fill="white"/>
										</clipPath>
										</defs>
									</svg>
								</a>
							</div>
						</div>
						<div class="cust_modal_btns">
							<a href="#" class="btn btn-outline-secondary">Bloquear</a>
							<a href="#" class="btn btn-outline-secondary">Permitir</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

    @section('custom_script')
    <script>
      
    </script>
    @endsection
</x-guest-layout>
