<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>MIPO all</title>

	<!--PDF Stylesheet-->
	<style>
        @page {
            /* size: 7in 9.25in;
            margin: 27mm 16mm 27mm 16mm;
			padding: 27mm 16mm 27mm 16mm; */
        }
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }
        body {
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            color: #000;
            background: #fff;
            margin: 0px;
            padding: 0px;
        }
        .pdf-wrapper {
            width: 100%;
            position: relative;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
							<h3 style="text-decoration: underline; text-align: center; font-size: 13px; ">CONTRATO DE CESIÓN DE CRÉDITOS</h3>
						</td>
					</tr>
				</table>
			</div>
		</header>
		<div class="pdf-body">
			<table class="content-table" style="max-width: 100%; margin: 0 auto; margin-top: 10px;">
				<tr>
					<td  style="padding: 0 80px;">
						<p>Los abajo firmantes, por una parte, el <strong>CEDENTE</strong> y por la otra parte <strong>CESIONARIO</strong>, y conjuntamente denominadas como “<b>LAS PARTES</b>”, convienen en celebrar el siguiente contrato de “<b>CESIÓN DE CRÉDITOS</b>”, el que se regirá por las siguientes cláusulas y condiciones:</p>
						<h6 style="font-size: 13px; text-transform: uppercase; padding: 12px 0;">ANTECEDENTES</h6>
						<ol style="list-style: lower-alpha; padding: 0 0 20px 25px;">
							<li style="margin-bottom: 10px;">Que, <b>LAS PARTES</b> han suscripto un acuerdo de “Condiciones de Uso y Política de Privacidad” de la plataforma “MIPO” (marca registrada), a través de la cual se han convertido en usuarios de la misma. Mediante tal plataforma, <b>LAS PARTES</b> tienen acceso a un sistema electrónico de intermediación para la negociación de diversos tipos de documentos (cheques, pagarés, letra de cambio, certificado de depósito de ahorro, y cualquier otro documento negociable o elegible a criterio de MIPO).</li>
							<li style="margin-bottom: 10px;">El uso de la plataforma MIPO, y la suscripción del presente contrato, implica la aceptación de todas las condiciones de uso. Así mismo, el CEDENTE manifiesta y da fe que mediante un sistema de subasta online ha decidido en pleno uso de sus facultades y sin ningún tipo de coacción, intimidación o acuerdo extra de la plataforma, que la elección de la oferta aceptada es resultado del análisis de las diferentes ofertas recibidas y de un exhaustivo análisis de sus costos y necesidades.</li>
							<li style="margin-bottom: 10px;">Que el importe del precio de venta aceptado por el CEDENTE, lo ha realiza en forma libre y conscientemente y que no se encuentra afectado de necesidad ni han incurrido en ligerezas, contando el mismo con la experiencia suficiente para apreciar el verdadero sentido y alcance de esta operación; que nada tiene que reclamar ni ahora ni en el futuro con relación al mismo, y que no se encuentra afectado por ninguna de las situaciones previstas en el artículo 671 del Código Civil Paraguayo, que podría llevarlo a cuestionar la firmeza y legitimidad de la presente cesión y mucho menos los derechos que del mismo surgen para el CESIONARIO.</li>
							<li>LAS PARTES declaran que han llegado a un acuerdo de cesión de crédito a través de la plataforma MIPO, bajo las condiciones señaladas más arriba, a las que se han suscripto voluntariamente, así como también a las cláusulas y condiciones expuestas en este documento.</li>
						</ol>
						<p>Las partes citadas acuerdan </p>
						<ol style="list-style: decimal; padding: 20px 0 20px 25px;">
							<li style="margin-bottom: 10px;"><b>EL CEDENTE</b>, de conformidad a los términos del presente contrato, cede en este acto a favor del <b>CESIONARIO</b>, todos los derechos y obligaciones que le corresponden por los créditos amparados en los documentos que se detallan en el presente instrumento y en la plataforma MIPO, asimismo se adjuntan a este contrato las imágenes de los documentos los cuales forman parte del presente instrumento, como anexo. Se detallan a continuación los documentos objeto del contrato de cesión
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
												<td>{{ $operation_val->issuance_date_iso}}</td>
												<td>
													{!! app('common')->currencyBySymbolPDF($preferred_currency) !!} {{ app('common')->currencyNumberFormat($preferred_currency, $operation_val->amount) }}
												</td>
												<td>{{ $operation_val->expire_date_iso }}</td>
												<td>{{ $offer->operations->first()->issuer?->company_name }}</td>
											</tr>
										@endforeach
									@endif
									{{-- <tr>
										<td>[Document Number]</td>
										<td>[DATE OF EMISSION]</td>
										<td>[CASH VALUE]</td>
										<td>[EXPIRATION DATE]</td>
										<td>[payer] </td>
									</tr> --}}
								</table>
							</li>
							<li style="margin-bottom: 10px;">Esta cesión comprenderá todos los derechos y obligaciones que le corresponden al CEDENTE en relación a los créditos cedidos, incluyendo el derecho a cobrar y recibir el pago de los mismos, así como los accesorios y privilegios que le pudieran corresponder al <b>CEDENTE</b> en relación con los créditos cedidos, así como la fuerza ejecutiva de los documentos (artículo 526 del Código Civil), por lo que <b>EL CESIONARIO</b> se coloca en la misma posición del <b>CEDENTE</b>, en el grado y prelación respecto al crédito cedido. El CESIONARIO acepta la cesión realizada por el CEDENTE.</li>
							<li style="margin-bottom: 10px;"><b>EL CESIONARIO</b> pagará al <b>CEDENTE</b>, por la cesión de los documentos detallados en el presente documento, la suma de
								{!! app('common')->currencyBySymbolPDF($preferred_currency) !!} {{ app('common')->currencyNumberFormat($preferred_currency,  $offer->amount) }}
								, ofertada y aceptada en la plataforma MIPO. Queda expresamente aclarado que la oferta y aceptación, lo realizan directamente el <b>CEDENTE</b> Y EL <b>CESIONARIO</b>, por lo que MIPO no tiene responsabilidad alguna, en dicha transacción.</li>
							<li style="margin-bottom: 10px;">Queda a cargo del <b>CESIONARIO</b>, el pago de la comisión por el uso de la plataforma MIPO. </li>
							<li style="margin-bottom: 10px;page-break-before:always; padding-top: 40px;">La notificación prevista en el art. 527 y 528 del Código Civil Paraguayo, para todos los efectos legales, será a cuenta y costo exclusivo del <b>CESIONARIO</b>, exonerando al <b>CEDENTE</b> de esta obligación.</li>
							<li style="margin-bottom: 10px;"><b>LAS PARTES</b> acuerdan que todos los documentos objeto del presente contrato, deberán estar endosados a favor del <b>CESIONARIO</b>.</li>
							<li style="margin-bottom: 10px;">La presente cesión se realiza {{  app('common')->responsibilityDeal($offer->operations->first()?->responsibility) }}</li>
							<li style="margin-bottom: 10px;">Es responsabilidad del <b>CEDENTE</b> la emisión de la correspondiente factura por la CESIÓN de los documentos.</li>
							<li style="margin-bottom: 10px;">La entrega de los documentos se realizará al <b>CESIONARIO</b>, y se dejará constancia en un documento por separado, salvo que el <b>CESIONARIO</b> contrate con MIPO el servicio de custodia de documentos, que se regirá por un contrato adicional.</li>
							<li style="margin-bottom: 10px;">MIPO no garantiza, ni certifica el pago de los documentos negociados entre el <b>CEDENTE</b> y el <b>CESIONARIO</b>, por lo que, en caso de incumplimientos, corresponderá al <b>CESIONARIO</b> realizar los actos necesarios para obtener el cobro de dichos instrumentos contra el endosante, en caso de que se haya realizado la operación con recurso, o directamente contra el librador del documento.</li>
							<li style="margin-bottom: 10px;"><b>El CEDENTE</b> garantiza al <b>CESIONARIO</b> la existencia del crédito cedido, y es responsable civil y penalmente, en caso de su inexistencia.</li>
							<li style="margin-bottom: 10px;">EL <b>CEDENTE</b>, acepta en forma irrevocable que todos los derechos de cobro de los documentos objeto del presente contrato, corresponden única y exclusivamente al <b>CESIONARIO</b> y deben ser pagados a éste por EL <b>LIBRADOR</b> a su vencimiento.</li>
							<li style="margin-bottom: 10px;">El <b>CEDENTE</b> reconoce y acepta que en caso de que por cualquier error por parte del <b>LIBRADOR</b> en el pago de los documentos objeto del presente contrato, lo realice a favor del <b>CEDENTE</b> en vez de realizar a favor del <b>CESIONARIO</b>. El <b>CEDENTE</b> se obliga a reembolsar y entregar al <b>CESIONARIO</b> en un plazo no mayor a 24 (veinticuatro) horas, el monto recibido del LIBRADOR, correspondiente a los documentos objeto del presente contrato. Asimismo, declara por medio del presente contrato que el uso del importe recibido erróneamente por el <b>LIBRADOR</b> en cualquier otro rubro que no sea el del pago de la obligación asumida por el presente contrato, será considerada como un incumplimiento a su obligación de pago y un engaño a un tercero para obtener un beneficio indebido. </li>
							<li style="margin-bottom: 10px;">Si alguna de las cláusulas del presente contrato fuere total o parcialmente nula, tal nulidad afectará únicamente a dicha disposición o cláusula. En todo lo demás, este convenio seguirá válido y vinculante como si la disposición o cláusula no hubiere formado parte del mismo.</li>
							<li style="margin-bottom: 10px;">Para todos los efectos de este contrato, comunicaciones, notificaciones, citaciones y diligencias judiciales o extrajudiciales, las partes constituyen domicilio en los mencionados al final de este instrumento; domicilios que se considerarán válidos para todos los actos jurídicos y administrativos emergentes de la ejecución y cumplimiento de este contrato, salvo que cualquier cambio de domicilio fuere comunicado a la otra por escrito y con acuse de recibo. </li>
							<li style="margin-bottom: 10px;">Cualquier modificación o renuncia a lo estipulado en el presente acuerdo tendrán únicamente eficacia si son hechos por escrito y firmados por las partes.</li>
							<li style="margin-bottom: 10px;">Las partes acuerdan someter cualquier controversia que surja de la ejecución de este contrato o tenga relación con el mismo, con su interpretación, validez o invalidez, a un proceso de arbitraje ante el Centro de Arbitraje y Mediación Paraguay (CAMP) de la Cámara Nacional de Comercio y Servicios de Paraguay (CNCSP). El mismo se desarrollará en la sede del Centro, de acuerdo con las normas de procedimiento para arbitraje que posee dicha institución, ante un tribunal arbitral conformado por tres árbitros designados de la lista del Cuerpo Arbitral del Centro de Arbitraje y Mediación Paraguay, que decidirá conforme a derecho, siendo el laudo definitivo y vinculante para las partes. Se aplicará el reglamento respectivo y demás disposiciones que regule dicho procedimiento al momento de ser requerido, declarando las partes conocer y aceptar los vigentes, incluso en orden a su régimen de gastos y costas, considerándolos parte integrante del presente contrato. El término “costas” comprende los honorarios de los abogados de las partes. </li>
							<li style="margin-bottom: 10px;page-break-before:always; padding-top: 40px;">El presente contrato y demás documentos serán firmados en forma electrónica entre las partes, y se aplica las disposiciones de la Ley 6822/21 “De los servicios de confianza para las transacciones electrónicas, del documento electrónico y los documentos transmisibles electrónicos”.</li>
						</ol>
						<p>Previa lectura de su contenido, y en prueba de conformidad y aceptación, suscriben las partes en dos ejemplares de un mismo tenor y a un solo efecto, en la Ciudad de Asunción, a los {{ date('d')}} días del mes {{ config('constants.MONTHS_NAME')[date('m')] }} del año {{ date('Y')}}.</p>
					</td>
				</tr>
			</table>

			<table style="border-collapse: collapse;width: 80%; margin: 0 auto;border:1px solid #eee;">
				<tr>
					<td style="width: 50%;vertical-align: top;" data-info="seller">
						<table style="border-collapse: collapse;width:100%;border:1px solid #eee;">
							<tr style="border-bottom: 1px solid #eee;">
								<td style="width:50%;border-right:1px solid #eee;padding:8px 12px;background:#FAFAFA;"><strong style="color: #000;">EL CEDENTE</strong></td>
							</tr>
							
							@if($deals_contract_buyer_and_seller->seller->is_user_company == '1')
							<tr style="border-bottom: 1px solid #eee;">
								<td style="width:50%;border-right:1px solid #eee;padding:8px 12px;"><p style="color:#007BFF;font-size:12px;font-weight:500;"> ( {{ $deals_contract_buyer_and_seller->seller->issuer->company_name }}) <span style="font-size: 10px;"> ( {{ $deals_contract_buyer_and_seller->seller->issuer->ruc_code }})</span></p></td>
							</tr>
							@endif
							
							<tr style="border-bottom: 1px solid #eee;">
								<td style="width:50%;border-right:1px solid #eee;padding:8px 12px;">
									<h4 style="font-size: 12px;padding:0;">{{  $deals_contract_buyer_and_seller->seller_signature_name }}  ( {{ $deals_contract_buyer_and_seller->seller->issuer->ruc_code }})</h4>
									<table>
										<tr>
											<td style="padding:0 5px 0 0;"><img style="height: 12px;width:12px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAACxLAAAsSwGlPZapAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAUfSURBVHgB7VpNcts2FH4PlFy1i9ZH4KqRu7F6gtBTO+0u7q5OplP5BHVOYOkE9g0sTyd2drF3reOZMCeIu6nVdsPcQLuq/uHLA/8EgqBISpS8yTfjkQCBwPuI94cHA3zCwwKhBthHzmqr0ehQUzyVTSToIPmrhLgaLEI08gV63D/ivivy4d3N/zeut+uOYE7MRaD926YDDdxnATuxsFXAz5wxmeN/nl2cwYyYiYAUnCw8QIQO1AMPfOgPn78ZQEVUItA+dWyA5hF/dWAxcAFud4c7rlf2gdIE1l5t/Qo+9aaoikcE57wrVyyEOx7DKNZxaSNfrDTtO/RtAWIbEB+zAtlGgRBG4Iv+9bM/DqEuAu3TJ/u8YC/n5wH/djzcuXShAtqnbD+EXZbgF/MI7A13LvpF8xQSyBeeXIAGb/fvHsyB9ukPNtB9z0ykmAROnzwrvHSF3MdbfFlqi8vi0cnmngDYz6rodBK5BKTOs05rQqInfPrxr+dvrmABCHYD/Le6fSCJF3k2geaJHA5Gjffpt4EegNiYV2WKYCIhDZvo9luTdxLmaZpHqvCh2ixeeAm5htxlGb3jPtaE1ch9Z5Ah0H651YWMn6f+MoSPIVXUB9D13gk8l4bsDgjY13oGdRtsGfwdrumqfYh4oI9LEfj65Ltt/rDTQ6xCX7w4WLtqi1Wpo+9CigAK1H3xYJmqoyNYm+A43YspDUkIyHCPhNvpwXQMC4Bca439fpDNFgFpkGpyAimfj9sJgZXPLEd70quaHpSBdNGtVlO66ANOxd9GTiMXkQxe3JYeqdVqJFlwQsDKeh4XakaUzbKPV+xMwOOi5/hwdK62SdGUhAChWE8/hOdQI4zCh3hX9CyRSEd+RDv+OiEQBIsJ7og8qAn5wsv4UuIQIyxXbSJQ8rIbyRgO3aRkFrc3tx6UEyw44LCPPrz+6eIFVBL+sgclMB6PR2w3SZsNOWvEehZY5sCNZO1BZDtEtNc+3TqqW3iTLKq2CKgX3ZhEXcIXISGgJk8Sqq/NA2HzMMxSU+g+evXkdZ3C67IEx84IqgqlCHz+pfgKChBGabGhk+CXYUhJZn/zzRV9rsl6CgFKuSoawwaUQB6JNOZTG0TLTs1GfnYHOAf/kBqEVumaz3QS8+u8wKDiN5mR8M/kt6STq2TqINazp1ABZhK1GayjNgSgO/keYTy+u9IM2TYdIKYhJsHzcDygjTqEjxI+W+37j+uq8fckkElfyy5Q2oEzGRqk1y5UQJR+13cAaqRTfA6252pc0OIA6YeXbujPHwbR2l21T5AspClttSFTV45yWsnEfJheDpra8Ra9a62SnYnEiKTnM87ayfd7sGQEtVjt7Rs0JK8utCWjqJMM4sh3dw8b/y6ooJVd31SXIpc1JBObcnIha1evy1gCXi/DHuIcKluXauyaxhsJSE9iqMvYcuJFkvjm5VYnP4cyFxdys9GwLpPRORux+X4RNhHUYpGMwk+rS5Uor2/29FJGhAEfe/pVblPM80+79SmO5IUEwkU2ezkkJAZ8/jwe/lzxgiO8IJRBqmseUS4NKUVAIr9+n8DjP9fnYgCfzjx5JFWvmFrAp6iVprwcXGej3M69Yqp4/1CagERY+r5f4CVf9VufSgRicJzohiplfotVQXwxKBPAWQppMxGIIYvBFtdTKVOSLLFwcGsfHKL681QA5yIQQ+q4LE0iCC6v0LoMfJyz2xSVP0JhYcS/Xfk+fuDPM5m+1/GvBp/w0PgIjI9pvXFLhAQAAAAASUVORK5CYII=" alt=""></td>
											<td>
												<p>Firmado electronicamente por </p>
												<p>{{ $deals_contract_buyer_and_seller->seller_date_time }} - IP: {{ $deals_contract_buyer_and_seller->seller_ip }}</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>

							@if(count($user_contract_sing_otps->where('user_type', 'seller')) > 0)
								@forelse ($user_contract_sing_otps as $key => $user_contract_sing_otp)
									<tr style="border-bottom: 1px solid #eee;">
										<td style="width:50%;border-right:1px solid #eee;padding:8px 12px;">
											<h4 style="font-size: 12px;padding:0;">{{ $user_contract_sing_otp->user->name }}   ({{ $user_contract_sing_otp->user->issuer->ruc_code }})</h4>
											<table>
												<tr>
													<td style="padding:0 5px 0 0;"><img style="height: 12px;width:12px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAACxLAAAsSwGlPZapAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAUfSURBVHgB7VpNcts2FH4PlFy1i9ZH4KqRu7F6gtBTO+0u7q5OplP5BHVOYOkE9g0sTyd2drF3reOZMCeIu6nVdsPcQLuq/uHLA/8EgqBISpS8yTfjkQCBwPuI94cHA3zCwwKhBthHzmqr0ehQUzyVTSToIPmrhLgaLEI08gV63D/ivivy4d3N/zeut+uOYE7MRaD926YDDdxnATuxsFXAz5wxmeN/nl2cwYyYiYAUnCw8QIQO1AMPfOgPn78ZQEVUItA+dWyA5hF/dWAxcAFud4c7rlf2gdIE1l5t/Qo+9aaoikcE57wrVyyEOx7DKNZxaSNfrDTtO/RtAWIbEB+zAtlGgRBG4Iv+9bM/DqEuAu3TJ/u8YC/n5wH/djzcuXShAtqnbD+EXZbgF/MI7A13LvpF8xQSyBeeXIAGb/fvHsyB9ukPNtB9z0ykmAROnzwrvHSF3MdbfFlqi8vi0cnmngDYz6rodBK5BKTOs05rQqInfPrxr+dvrmABCHYD/Le6fSCJF3k2geaJHA5Gjffpt4EegNiYV2WKYCIhDZvo9luTdxLmaZpHqvCh2ixeeAm5htxlGb3jPtaE1ch9Z5Ah0H651YWMn6f+MoSPIVXUB9D13gk8l4bsDgjY13oGdRtsGfwdrumqfYh4oI9LEfj65Ltt/rDTQ6xCX7w4WLtqi1Wpo+9CigAK1H3xYJmqoyNYm+A43YspDUkIyHCPhNvpwXQMC4Bca439fpDNFgFpkGpyAimfj9sJgZXPLEd70quaHpSBdNGtVlO66ANOxd9GTiMXkQxe3JYeqdVqJFlwQsDKeh4XakaUzbKPV+xMwOOi5/hwdK62SdGUhAChWE8/hOdQI4zCh3hX9CyRSEd+RDv+OiEQBIsJ7og8qAn5wsv4UuIQIyxXbSJQ8rIbyRgO3aRkFrc3tx6UEyw44LCPPrz+6eIFVBL+sgclMB6PR2w3SZsNOWvEehZY5sCNZO1BZDtEtNc+3TqqW3iTLKq2CKgX3ZhEXcIXISGgJk8Sqq/NA2HzMMxSU+g+evXkdZ3C67IEx84IqgqlCHz+pfgKChBGabGhk+CXYUhJZn/zzRV9rsl6CgFKuSoawwaUQB6JNOZTG0TLTs1GfnYHOAf/kBqEVumaz3QS8+u8wKDiN5mR8M/kt6STq2TqINazp1ABZhK1GayjNgSgO/keYTy+u9IM2TYdIKYhJsHzcDygjTqEjxI+W+37j+uq8fckkElfyy5Q2oEzGRqk1y5UQJR+13cAaqRTfA6252pc0OIA6YeXbujPHwbR2l21T5AspClttSFTV45yWsnEfJheDpra8Ra9a62SnYnEiKTnM87ayfd7sGQEtVjt7Rs0JK8utCWjqJMM4sh3dw8b/y6ooJVd31SXIpc1JBObcnIha1evy1gCXi/DHuIcKluXauyaxhsJSE9iqMvYcuJFkvjm5VYnP4cyFxdys9GwLpPRORux+X4RNhHUYpGMwk+rS5Uor2/29FJGhAEfe/pVblPM80+79SmO5IUEwkU2ezkkJAZ8/jwe/lzxgiO8IJRBqmseUS4NKUVAIr9+n8DjP9fnYgCfzjx5JFWvmFrAp6iVprwcXGej3M69Yqp4/1CagERY+r5f4CVf9VufSgRicJzohiplfotVQXwxKBPAWQppMxGIIYvBFtdTKVOSLLFwcGsfHKL681QA5yIQQ+q4LE0iCC6v0LoMfJyz2xSVP0JhYcS/Xfk+fuDPM5m+1/GvBp/w0PgIjI9pvXFLhAQAAAAASUVORK5CYII=" alt=""></td>
													<td>
														<p>Firmado electronicamente por</p>
														<p>{{ $user_contract_sing_otp->user_contract_date_time }} - IP: {{ $user_contract_sing_otp->user_contract_ip }}</p>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								@empty
								@endforelse
							@endif
							
						</table>
					</td>
					<td style="width: 50%; vertical-align: top;" data-info="buyer">
						<table style="border-collapse: collapse;width:100%;border:1px solid #eee;">
							<tr style="border-bottom: 1px solid #eee;">
								<td style="width:50%;border-right:1px solid #eee;padding:8px 12px;background:#FAFAFA;"><strong style="color: #000;">EL CEDENTE</strong></td>
							</tr>

							@if($deals_contract_buyer_and_seller->buyer->is_user_company == '1')
							<tr style="border-bottom: 1px solid #eee;">
								<td style="width:50%;border-right:1px solid #eee;padding:8px 12px;"><p style="color:#007BFF;font-size:12px;font-weight:500;"> ( {{ $deals_contract_buyer_and_seller->buyer->issuer->company_name }}) <span style="font-size: 10px;"> ( {{ $deals_contract_buyer_and_seller->buyer->issuer->ruc_code }})</span></p></td>
							</tr>
							@endif

							<tr style="border-bottom: 1px solid #eee;">
								<td style="width:50%;border-right:1px solid #eee;padding:8px 12px;">
									<h4 style="font-size: 12px;padding:0;">{{  $deals_contract_buyer_and_seller->buyer_signature_name }}  ( {{ $deals_contract_buyer_and_seller->buyer->issuer->ruc_code }})<</h4>
									<table>
										<tr>
											<td style="padding:0 5px 0 0;"><img style="height: 12px;width:12px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAACxLAAAsSwGlPZapAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAUfSURBVHgB7VpNcts2FH4PlFy1i9ZH4KqRu7F6gtBTO+0u7q5OplP5BHVOYOkE9g0sTyd2drF3reOZMCeIu6nVdsPcQLuq/uHLA/8EgqBISpS8yTfjkQCBwPuI94cHA3zCwwKhBthHzmqr0ehQUzyVTSToIPmrhLgaLEI08gV63D/ivivy4d3N/zeut+uOYE7MRaD926YDDdxnATuxsFXAz5wxmeN/nl2cwYyYiYAUnCw8QIQO1AMPfOgPn78ZQEVUItA+dWyA5hF/dWAxcAFud4c7rlf2gdIE1l5t/Qo+9aaoikcE57wrVyyEOx7DKNZxaSNfrDTtO/RtAWIbEB+zAtlGgRBG4Iv+9bM/DqEuAu3TJ/u8YC/n5wH/djzcuXShAtqnbD+EXZbgF/MI7A13LvpF8xQSyBeeXIAGb/fvHsyB9ukPNtB9z0ykmAROnzwrvHSF3MdbfFlqi8vi0cnmngDYz6rodBK5BKTOs05rQqInfPrxr+dvrmABCHYD/Le6fSCJF3k2geaJHA5Gjffpt4EegNiYV2WKYCIhDZvo9luTdxLmaZpHqvCh2ixeeAm5htxlGb3jPtaE1ch9Z5Ah0H651YWMn6f+MoSPIVXUB9D13gk8l4bsDgjY13oGdRtsGfwdrumqfYh4oI9LEfj65Ltt/rDTQ6xCX7w4WLtqi1Wpo+9CigAK1H3xYJmqoyNYm+A43YspDUkIyHCPhNvpwXQMC4Bca439fpDNFgFpkGpyAimfj9sJgZXPLEd70quaHpSBdNGtVlO66ANOxd9GTiMXkQxe3JYeqdVqJFlwQsDKeh4XakaUzbKPV+xMwOOi5/hwdK62SdGUhAChWE8/hOdQI4zCh3hX9CyRSEd+RDv+OiEQBIsJ7og8qAn5wsv4UuIQIyxXbSJQ8rIbyRgO3aRkFrc3tx6UEyw44LCPPrz+6eIFVBL+sgclMB6PR2w3SZsNOWvEehZY5sCNZO1BZDtEtNc+3TqqW3iTLKq2CKgX3ZhEXcIXISGgJk8Sqq/NA2HzMMxSU+g+evXkdZ3C67IEx84IqgqlCHz+pfgKChBGabGhk+CXYUhJZn/zzRV9rsl6CgFKuSoawwaUQB6JNOZTG0TLTs1GfnYHOAf/kBqEVumaz3QS8+u8wKDiN5mR8M/kt6STq2TqINazp1ABZhK1GayjNgSgO/keYTy+u9IM2TYdIKYhJsHzcDygjTqEjxI+W+37j+uq8fckkElfyy5Q2oEzGRqk1y5UQJR+13cAaqRTfA6252pc0OIA6YeXbujPHwbR2l21T5AspClttSFTV45yWsnEfJheDpra8Ra9a62SnYnEiKTnM87ayfd7sGQEtVjt7Rs0JK8utCWjqJMM4sh3dw8b/y6ooJVd31SXIpc1JBObcnIha1evy1gCXi/DHuIcKluXauyaxhsJSE9iqMvYcuJFkvjm5VYnP4cyFxdys9GwLpPRORux+X4RNhHUYpGMwk+rS5Uor2/29FJGhAEfe/pVblPM80+79SmO5IUEwkU2ezkkJAZ8/jwe/lzxgiO8IJRBqmseUS4NKUVAIr9+n8DjP9fnYgCfzjx5JFWvmFrAp6iVprwcXGej3M69Yqp4/1CagERY+r5f4CVf9VufSgRicJzohiplfotVQXwxKBPAWQppMxGIIYvBFtdTKVOSLLFwcGsfHKL681QA5yIQQ+q4LE0iCC6v0LoMfJyz2xSVP0JhYcS/Xfk+fuDPM5m+1/GvBp/w0PgIjI9pvXFLhAQAAAAASUVORK5CYII=" alt=""></td>
											<td>
												<p>Firmado electronicamente por</p>
												<p>{{ $deals_contract_buyer_and_seller->buyer_date_time }} - IP: {{ $deals_contract_buyer_and_seller->buyer_ip }}</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>

							@if(count($user_contract_sing_otps->where('user_type', 'buyer')) > 0)
								@forelse ($user_contract_sing_otps as $key => $user_contract_sing_otp)
									<tr style="border-bottom: 1px solid #eee;">
										<td style="width:50%;border-right:1px solid #eee;padding:8px 12px;">
											<h4 style="font-size: 12px;padding:0;">{{ $user_contract_sing_otp->user->name }} ({{$user_contract_sing_otp->user->issuer->ruc_code }})</h4>
											<table>
												<tr>
													<td style="padding:0 5px 0 0;"><img style="height: 12px;width:12px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAACxLAAAsSwGlPZapAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAUfSURBVHgB7VpNcts2FH4PlFy1i9ZH4KqRu7F6gtBTO+0u7q5OplP5BHVOYOkE9g0sTyd2drF3reOZMCeIu6nVdsPcQLuq/uHLA/8EgqBISpS8yTfjkQCBwPuI94cHA3zCwwKhBthHzmqr0ehQUzyVTSToIPmrhLgaLEI08gV63D/ivivy4d3N/zeut+uOYE7MRaD926YDDdxnATuxsFXAz5wxmeN/nl2cwYyYiYAUnCw8QIQO1AMPfOgPn78ZQEVUItA+dWyA5hF/dWAxcAFud4c7rlf2gdIE1l5t/Qo+9aaoikcE57wrVyyEOx7DKNZxaSNfrDTtO/RtAWIbEB+zAtlGgRBG4Iv+9bM/DqEuAu3TJ/u8YC/n5wH/djzcuXShAtqnbD+EXZbgF/MI7A13LvpF8xQSyBeeXIAGb/fvHsyB9ukPNtB9z0ykmAROnzwrvHSF3MdbfFlqi8vi0cnmngDYz6rodBK5BKTOs05rQqInfPrxr+dvrmABCHYD/Le6fSCJF3k2geaJHA5Gjffpt4EegNiYV2WKYCIhDZvo9luTdxLmaZpHqvCh2ixeeAm5htxlGb3jPtaE1ch9Z5Ah0H651YWMn6f+MoSPIVXUB9D13gk8l4bsDgjY13oGdRtsGfwdrumqfYh4oI9LEfj65Ltt/rDTQ6xCX7w4WLtqi1Wpo+9CigAK1H3xYJmqoyNYm+A43YspDUkIyHCPhNvpwXQMC4Bca439fpDNFgFpkGpyAimfj9sJgZXPLEd70quaHpSBdNGtVlO66ANOxd9GTiMXkQxe3JYeqdVqJFlwQsDKeh4XakaUzbKPV+xMwOOi5/hwdK62SdGUhAChWE8/hOdQI4zCh3hX9CyRSEd+RDv+OiEQBIsJ7og8qAn5wsv4UuIQIyxXbSJQ8rIbyRgO3aRkFrc3tx6UEyw44LCPPrz+6eIFVBL+sgclMB6PR2w3SZsNOWvEehZY5sCNZO1BZDtEtNc+3TqqW3iTLKq2CKgX3ZhEXcIXISGgJk8Sqq/NA2HzMMxSU+g+evXkdZ3C67IEx84IqgqlCHz+pfgKChBGabGhk+CXYUhJZn/zzRV9rsl6CgFKuSoawwaUQB6JNOZTG0TLTs1GfnYHOAf/kBqEVumaz3QS8+u8wKDiN5mR8M/kt6STq2TqINazp1ABZhK1GayjNgSgO/keYTy+u9IM2TYdIKYhJsHzcDygjTqEjxI+W+37j+uq8fckkElfyy5Q2oEzGRqk1y5UQJR+13cAaqRTfA6252pc0OIA6YeXbujPHwbR2l21T5AspClttSFTV45yWsnEfJheDpra8Ra9a62SnYnEiKTnM87ayfd7sGQEtVjt7Rs0JK8utCWjqJMM4sh3dw8b/y6ooJVd31SXIpc1JBObcnIha1evy1gCXi/DHuIcKluXauyaxhsJSE9iqMvYcuJFkvjm5VYnP4cyFxdys9GwLpPRORux+X4RNhHUYpGMwk+rS5Uor2/29FJGhAEfe/pVblPM80+79SmO5IUEwkU2ezkkJAZ8/jwe/lzxgiO8IJRBqmseUS4NKUVAIr9+n8DjP9fnYgCfzjx5JFWvmFrAp6iVprwcXGej3M69Yqp4/1CagERY+r5f4CVf9VufSgRicJzohiplfotVQXwxKBPAWQppMxGIIYvBFtdTKVOSLLFwcGsfHKL681QA5yIQQ+q4LE0iCC6v0LoMfJyz2xSVP0JhYcS/Xfk+fuDPM5m+1/GvBp/w0PgIjI9pvXFLhAQAAAAASUVORK5CYII=" alt=""></td>
													<td>
														<p>Firmado electronicamente por</p>
														<p>{{ $user_contract_sing_otp->user_contract_date_time }} - IP: {{ $user_contract_sing_otp->user_contract_ip }}</p>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								@empty
								@endforelse
							@endif
						</table>
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