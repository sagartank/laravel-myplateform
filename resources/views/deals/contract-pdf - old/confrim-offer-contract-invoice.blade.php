<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>MIPO Invoice</title>

	<!--PDF Stylesheet-->
	<style>
        @page {
        /*    size: 7in 9.25in;
            margin: 27mm 16mm 27mm 16mm;
			padding: 27mm 16mm 27mm 16mm; */
        }
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #000;
            background: #fff;
            margin: 0px;
            padding: 0px;
        }
        .pdf-wrapper {
            width: 100%;
            position: relative;
        }	
		header {position: relative;top: 0;left: 0;right: 0;}
		.pdf-header {padding: 30px 20px 20px;}
		.pdf-header table {width: 100%;}
		table.table_vol_1 { width: 100%; border: solid 1px #000; border-collapse: collapse; margin-top: 15px; }
		table.table_vol_1 td,
		table.table_vol_1 th,
		table.table_vol_1 tr { width: 100%; border: solid 1px #000; }
		table.table_vol_1 td,
		table.table_vol_1 th { padding: 5px 10px; }
		
		
	</style>
	<!--PDF Stylesheet-->
</head>
@php
	$seller_name = $offer->operations->first()->seller?->name;
	$seller_address = $offer->operations->first()->seller?->address;

	$date_of_agreement = date('d/m/Y');
	if($user_type == 'seller') {
		$buyer_name = $offer->buyer->address;
		// $buyer_name = app('common')->lockOfferDetail($offer, ['buyer_name']);
	} else if($user_type == 'buyer'){
		$buyer_name = $offer->buyer->name;
	}
	$buyer_address = $offer->buyer->address;

	$buyer_bank_payment_options = $offer->buyer->bank_details?->payment_options ?? '';
	$buyer_bank_identification_id = $offer->buyer->bank_details?->identification_id ?? '';
	$buyer_bank_name = $offer->buyer->bank_details?->bank_name ?? '';
	$buyer_bank_account_name = $offer->buyer->bank_details?->account_name ?? '';
	$buyer_bank_account_number = $offer->buyer->bank_details?->account_number ?? '';
	$buyer_bank_phone_company = $offer->buyer->bank_details?->phone_company ?? '';
	$buyer_bank_phone_number = $offer->buyer->bank_details?->phone_number ?? '';
@endphp
<body>
	<div class="pdf-wrapper">
		<header style="padding: 0 80px; margin-top: 20px;">
			<div class="pdf-header">
				<table>
					<tr>
						<td>
							<h3 style="text-decoration: underline; text-align: center; font-size: 13px; ">CONTRATO DE FACTORING</h3>
						</td>
					</tr>
				</table>
			</div>
		</header>
		<div class="pdf-body">
			<table class="content-table" style="max-width: 100%; margin: 0 auto; margin-top: 10px;" >
				<tr>
					<td  style="padding: 0 80px;">
						<p>Los abajo firmantes, por una parte, el <b>CEDENTE</b> y por la otra parte el <b>FACTOR</b>, y conjuntamente denominadas como “<b>LAS PARTES</b>”, convienen en celebrar el presente <b>CONTRATO DE FACTORING</b>, el que se regirá por las siguientes cláusulas y condiciones:</p>
						<h6 style="font-size: 13px; text-transform: uppercase; padding: 12px 0;">CONSIDERANDO:</h6>
						<ol style="list-style: lower-alpha; padding: 0 0 20px 25px;">
							<li style="margin-bottom: 10px;">Que <b>EL FACTOR</b> o <b>CESIONARIO</b>, es un inversor, persona física o jurídica, que tiene intenciones de adquirir facturas emitidas a empresas, supermercados, locales comerciales, y personas físicas, por la venta de bienes o servicios. </li>
							<li style="margin-bottom: 10px;">Que <b>EL CEDIDO</b> es una persona física o jurídica, que cuenta con la verificación de MIPO, con relación a la identidad, denominación social o razón social, conforme a los documentos presentados por los mismos. </li>
							<li style="margin-bottom: 10px;">Que <b>EL CEDENTE</b>, vende bienes o servicios a crédito, y está interesado en negociar las facturas cambiarias conformadas por el <b>CEDIDO</b>. Asimismo, el <b>CEDENTE</b> manifiesta y da fe que mediante un sistema de subasta online ha decidido en pleno uso de sus facultades y sin ningún tipo de coacción, intimidación o acuerdo extra de la plataforma, que la elección de la oferta aceptada es resultado del análisis de las diferentes ofertas recibidas y de un exhaustivo análisis de sus costos y necesidades.</li>
							<li style="margin-bottom: 10px;">Que el importe del precio de venta aceptado por el CEDENTE, lo ha realiza en forma libre y conscientemente y que no se encuentra afectado de necesidad ni han incurrido en ligerezas, contando el mismo con la experiencia suficiente para apreciar el verdadero sentido y alcance de esta operación; que nada tiene que reclamar ni ahora ni en el futuro con relación al mismo, y que no se encuentra afectado por ninguna de las situaciones previstas en el artículo 671 del Código Civil Paraguayo, que podría llevarlo a cuestionar la firmeza y legitimidad de la presente cesión y mucho menos los derechos que del mismo surgen para el FACTOR.</li>
							<li>LAS PARTES declaran que han llegado a un acuerdo de cesión de crédito a través de la plataforma MIPO, bajo las condiciones señaladas más arriba, a las que se han suscripto voluntariamente, así como también a las cláusulas y condiciones expuestas en este documento.</li>
						</ol>
						<p>Las partes citadas acuerdan</p>
						<ol style="list-style: decimal; padding: 20px 0 20px 25px;">
							<li style="margin-bottom: 10px;">EL <b>CEDENTE</b> de conformidad a los términos del presente contrato, cede en este acto a favor del <b>FACTOR</b>, todos los derechos y obligaciones que le corresponden por los créditos amparados en las facturas a crédito o factura cambiaria, que se detallan en este instrumento y en la plataforma MIPO. Así mismo se anexan las imágenes de dichas facturas a este instrumento y forman parte del presente contrato, cómo anexo. Se detallan a continuación los documentos objeto del contrato de factoring 
								<table class="table_vol_1">
									<tr>
										<th>No Operación</th>
										<th>Fecha de emisión</th>
										<th>Monto Nominal</th>
										<th>Vencimiento/pago</th>
										<th>Cliente/Cedido</th>
									</tr>
									@if($offer->operations->count())
										@php
											$preferred_currency = $offer->operations->first()->preferred_currency;
										@endphp
										@foreach ($offer->operations as $operation_val)
											<tr>
												<td>{{ $operation_val->operation_type_number }}</td>
												<td>{{ $offer->offer_created_date_iso }}</td>
												<td>
													{!! app('common')->currencyBySymbolPDF($preferred_currency) !!} {{ app('common')->currencyNumberFormat($preferred_currency, $operation_val->amount) }}
												</td>
												<td>{{ $operation_val->expire_date_iso }}</td>
												<td>{{ $offer->operations->first()->issuer?->company_name }}</td>
											</tr>
										@endforeach
									@endif
								</table>
							</li>
							<li style="margin-bottom: 10px;">Esta cesión comprenderá todos los derechos y obligaciones que le corresponden al CEDENTE en relación a Las facturas conformadas o cambiarias cedidos, incluyendo el derecho a cobrar y recibir el pago de los mismos, así como la fuerza ejecutiva de los documentos (artículo 526 del Código Civil), por lo que <b>EL FACTOR</b> se coloca en la misma posición del <b>CEDENTE</b>, en el grado y prelación respecto a los documentos cedidos. El <b>FACTOR</b> acepta la cesión realizada por el CEDENTE.</li>
							<li style="margin-bottom: 10px;"><b>EL FACTOR</b> pagará al <b>CEDENTE</b>, por la cesión de las facturas a crédito o facturas cambiarias detallados en el presente documento, la suma de 
								{!! app('common')->currencyBySymbolPDF($preferred_currency) !!} {{ app('common')->currencyNumberFormat($preferred_currency,  $offer->amount) }}
								, ofertada y aceptada en la plataforma MIPO. Queda expresamente aclarado que la oferta y aceptación, lo realizan directamente el <b>CEDENTE</b> Y EL <b>FACTOR</b>, por lo que MIPO no tiene responsabilidad alguna, en dicha transacción.</li>
							<li style="margin-bottom: 10px;">Queda a cargo del <b>CESIONARIO</b>, el pago de la comisión por el uso de la plataforma MIPO.</li>
							<li style="margin-bottom: 10px;page-break-before:always; padding-top: 40px;">La notificación de la cesión, lo podrá realizar cualquiera de las partes, por medio de notario, telegrama colacionado, correo certificado o correo con acuse de recibo. Así mismo cualquiera de las partes podrá realizar la inscripción del presente contrato de factoraje en el sistema electrónico de operaciones garantizadas.</li>
							<li style="margin-bottom: 10px;">LAS PARTES acuerdan que todas las facturas créditos o facturas cambiarias, deberán estar conformadas por el <b>CEDIDO</b>, y endosado a favor del <b>FACTOR</b>.</li>
							<li style="margin-bottom: 10px;">La presente cesión se realiza {{ app('common')->responsibilityDeal($offer->operations->first()?->responsibility) }}</li>
							<li style="margin-bottom: 10px;">Es responsabilidad del <b>CEDENTE</b> la emisión de la correspondiente factura por la <b>CESIÓN</b> realizada.</li>
							<li style="margin-bottom: 10px;">La entrega de las facturas conformadas o facturas cambiarias se realizará al <b>FACTOR</b>, y se dejará constancia en un documento por separado, salvo que el <b>FACTOR</b> contrate con MIPO el servicio de custodia de documentos, que se regirá por un contrato adicional.</li>
							<li style="margin-bottom: 10px;">MIPO no garantiza, ni certifica el pago de los documentos negociados entre el <b>CEDENTE</b> y el <b>CESIONARIO</b>, por lo que, en caso de incumplimiento, corresponderá al <b>CESIONARIO</b> realizar los actos necesarios para obtener el cobro de dichos instrumentos contra el endosante, en caso de que se haya realizado la operación con recurso, o directamente contra el librador del documento.</li>
							<li style="margin-bottom: 10px;">Prevalecen sobre este contrato, las disposiciones de la Ley 6542/20 “De Factoraje, factura cambiaria y Sistema electrónico de operaciones garantizadas”. </li>
							<li style="margin-bottom: 10px;"><b>El CEDENTE</b> garantiza al <b>FACTOR</b> la existencia del crédito cedido, y es responsable civil y penalmente, en caso de su inexistencia.</li>
							<li style="margin-bottom: 10px;">EL <b>CEDENTE</b>, acepta en forma irrevocable que todos los derechos de cobro de las facturas a crédito o facturas cambiarias objeto del presente contrato, corresponden única y exclusivamente al <b>FACTOR</b> y deben ser pagados a éste por EL <b>CEDIDO</b> a su vencimiento.</li>
							<li style="margin-bottom: 10px;">En caso de que el <b>CEDIDO</b> realice un descuento no previsto, o exija del <b>CEDENTE</b> la emisión de una nota de crédito, por devoluciones, bonificaciones u otra clase de descuento, no previsto en el momento de la oferta y aceptación, en la plataforma de MIPO, el <b>CEDENTE</b> se obliga a reembolsar al <b>FACTOR</b>, toda sumar descontada por el CEDIDO, dentro del plazo de 48 (cuarenta y ocho) horas de requerido por el <b>FACTOR</b>.</li>
							<li style="margin-bottom: 10px;">El <b>CEDENTE</b> reconoce y acepta que en caso de que por cualquier error por parte del <b>CEDIDO</b> en el pago de los documentos objeto del presente contrato, lo realice a favor del <b>CEDENTE</b> en vez de realizar a favor del <b>FACTOR</b>. El <b>CEDENTE</b> se obliga a reembolsar y entregar al <b>FACTOR</b> en un plazo no mayor a 24 (veinticuatro) horas, el monto recibido del CEDIDO, correspondiente a los documentos objeto del presente contrato. Asimismo, declara por medio del presente contrato que el uso del importe recibido erróneamente por el <b>CEDIDO</b> en cualquier otro rubro que no sea el del pago de la obligación asumida por el presente contrato, será considerada como un incumplimiento a su obligación de pago y un engaño a un tercero para obtener un beneficio indebido. </li>
							<li style="margin-bottom: 10px;">Si alguna de las cláusulas del presente contrato fuere total o parcialmente nula, tal nulidad afectará únicamente a dicha disposición o cláusula. En todo lo demás, este convenio seguirá válido y vinculante como si la disposición o cláusula no hubiere formado parte del mismo.</li>
							<li style="margin-bottom: 10px;">Para todos los efectos de este contrato, comunicaciones, notificaciones, citaciones y diligencias judiciales o extrajudiciales, las partes constituyen domicilio en los mencionados al final de este instrumento; domicilios que se considerarán válidos para todos los actos jurídicos y administrativos emergentes de la ejecución y cumplimiento de este contrato, salvo que cualquier cambio de domicilio fuere comunicado a la otra por escrito y con acuse de recibo. </li>
							<li style="margin-bottom: 10px;page-break-before:always; padding-top: 40px;">Cualquier modificación o renuncia a lo estipulado en el presente acuerdo tendrán únicamente eficacia si son hechos por escrito y firmados por las partes.</li>
							<li style="margin-bottom: 10px;">Las partes acuerdan someter cualquier controversia que surja de la ejecución de este contrato o tenga relación con el mismo, con su interpretación, validez o invalidez, a un proceso de arbitraje ante el Centro de Arbitraje y Mediación Paraguay (CAMP) de la Cámara Nacional de Comercio y Servicios de Paraguay (CNCSP). El mismo se desarrollará en la sede del Centro, de acuerdo con las normas de procedimiento para arbitraje que posee dicha institución, ante un tribunal arbitral conformado por tres árbitros designados de la lista del Cuerpo Arbitral del Centro de Arbitraje y Mediación Paraguay, que decidirá conforme a derecho, siendo el laudo definitivo y vinculante para las partes. Se aplicará el reglamento respectivo y demás disposiciones que regule dicho procedimiento al momento de ser requerido, declarando las partes conocer y aceptar los vigentes, incluso en orden a su régimen de gastos y costas, considerándolos parte integrante del presente contrato. El término “costas” comprende los honorarios de los abogados de las partes. </li>
							<li style="margin-bottom: 10px;">El presente contrato y demás documentos, serán firmados en forma electrónica entre las partes, y se aplica las disposiciones de la Ley 6822/21 “De los servicios de confianza para las transacciones electrónicas, del documento electrónico y los documentos transmisibles electrónicos”.</li>
						</ol>
						<p>Previa lectura de su contenido, y en prueba de conformidad y aceptación, suscriben las partes en dos ejemplares de un mismo tenor y a un solo efecto, en la Ciudad de Asunción, a los {{ date('d')}} días del mes {{ config('constants.MONTHS_NAME')[date('m')] }} del año {{ date('Y')}}.</p>
						<p style="margin: 25px 0 0 0;">
							<b>
								EL CEDENTE <br> 
								Nombre completo/Razón Social/Denominación Social <span class="add_sing_name_contract_pdf" id="add_seller_name_contract_pdf">{{ $offer->deals_contract->seller_signature_name }}</span><br>
								{{ __('Date time')}} <span>{{ $offer->deals_contract->seller_date_time }}</span><br>
								{{ __('IP address')}} <span>{{ $offer->deals_contract->seller_ip }}</span><br>
								@if(count($user_contract_sing_otps) > 0)
									@forelse ($user_contract_sing_otps as $key => $user_contract_sing_otp)

										{{ __('Name')}} <span>{{ $user_contract_sing_otp->user->name }}   {{ '(C.I '.$user_contract_sing_otp->user->issuer->ruc_text_id.')' }} </span><br>
										{{ __('Date Time')}} <span>{{ $user_contract_sing_otp->user_contract_date_time }} </span><br>
										{{ __('IP address')}} <span>{{ $user_contract_sing_otp->user_contract_ip }}</span><br>

									@if($loop->last)
										@if($deals_contract->seller && $deals_contract->seller->is_user_company == '1')
											{{ __('Company Name ' )}} <span>{{ $deals_contract->seller->issuer->company_name }}   {{ '(RUC :'.$deals_contract->seller->issuer->ruc_text_id.')' }} </span><br>
										@endif
									@endif

									@empty
								
									@endforelse
								@endif

								{{-- Pasaporte/CI/Ruc: __________________________ <br> --}}
								{{-- Domicilio: __________________________________ <br> --}}
								
								<br>FACTOR <br>
								Nombre completo/Razón Social/Denominación Social <span class="add_sing_name_contract_pdf"  id="add_seller_name_contract_pdf">{{ $offer->deals_contract->buyer_signature_name }}</span><br>
								{{ __('Date time')}} <span>{{ $offer->deals_contract->buyer_date_time }}</span><br>
								{{ __('IP address')}} <span>{{ $offer->deals_contract->buyer_ip }}</span><br>
								@if(count($user_contract_sing_otps) > 0)
									@forelse ($user_contract_sing_otps as $key => $user_contract_sing_otp)

										{{ __('Name')}} <span>{{ $user_contract_sing_otp->user->name }}   {{ '(C.I '.$user_contract_sing_otp->user->issuer->ruc_text_id.')' }} </span><br>
										{{ __('Date Time')}} <span>{{ $user_contract_sing_otp->user_contract_date_time }} </span><br>
										{{ __('IP address')}} <span>{{ $user_contract_sing_otp->user_contract_ip }}</span><br>
										@if($loop->last)
											@if($deals_contract->buyer && $deals_contract->buyer->is_user_company == '1')
												{{ __('Company Name ' )}} <span>{{ $deals_contract->buyer->issuer->company_name }}   {{ '(RUC :'.$deals_contract->buyer->issuer->ruc_text_id.')' }} </span><br>
											@endif
										@endif
									
									@empty
								
									@endforelse
								@endif

							</b>
						</p>
					</td>
				</tr>
			</table>
			<table class="content-table" style="max-width: 100%; margin: 0 auto; margin-top: 10px; page-break-before:always; padding-top: 40px;">
				@if ($documents && $documents->count() > 0)
					@foreach ($documents->chunk(2) as $documents)
					<tr style="width: 100% padding-top: 10px;">
						@foreach ($documents as $document)
							@if ($document->path != '')
								@php
									$file_ext = strtolower(pathinfo($document->path, PATHINFO_EXTENSION));
								@endphp
								@if ($file_ext != 'pdf')
									<td style="width: 50%"><img width="250" src="{{  app('common')->pdfImagePath($document->path) }}" alt="no-image" /></td>
								@endif
							@endif
						@endforeach
					</tr>
					@endforeach
				@endif
				@if ($supportingAttachments && $supportingAttachments->count() > 0)
					@foreach ($supportingAttachments->chunk(2) as $supportingAttachments)
						<tr style="width: 100% padding-top: 10px;">
							@foreach ($supportingAttachments as $attachment)
								@if ($attachment->path != '')
									@php
										$file_ext = strtolower(pathinfo($attachment->path, PATHINFO_EXTENSION));
									@endphp
									@if ($file_ext != 'pdf')
									<td  style="width: 50%"><img width="250" src="{{ app('common')->pdfImagePath($attachment->path) }}" alt="no-image" /></td>
									@endif
								@endif
							@endforeach
						<tr>
					@endforeach
				@endif
		</table>
		</div>
	</div>
</body>
</html>