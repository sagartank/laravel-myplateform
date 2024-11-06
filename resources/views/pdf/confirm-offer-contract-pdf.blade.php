<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>MIPO</title>

		<style>
			* {
				margin: 0px;
				padding: 0px;
				box-sizing: border-box;
			}
			body {
				font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
				font-size: 14px;
				background: #fff;
				margin: 0px;
				padding: 0 25px 0 25px !important;
			}
			.confirm_offer_pdf_wrap {
				width: 100%;
				position: relative;
				font-size: 13px;
				color: #939393;
				background: #fff;
			}	
			table + table{margin-top: 10px;}

			tr:last-child,
			li:last-child {border-bottom: none !important;}

			.confirm_offer_pdf_wrap ol li,.confirm_offer_pdf_wrap ul li {list-style: none;}
			.confirm_offer_pdf_wrap ul li+li{padding: 15px 0 0 0;}
			.confirm_offer_pdf_wrap ul{padding: 0 0 24px;}
			.confirm_offer_pdf_wrap h4{padding: 0 0 8px;}
		</style>
	</head>
	<body>
		<div class="confirm_offer_pdf_wrap">
			<table style="width: 100%;">
				<tr>
					<td style="text-align: center;margin:0 auto;">
						<img alt="no-img" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEMAAAAlCAYAAAAZZ1Q0AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAApQSURBVHgB3VlrbFxHFT4z9+56N/Fj0yStVVCziRJa0ao4/IPQxOZPeStBtKVFwQ4Vz1LVURHvqhuoBEiQbH4EKCKKKxQqVJrYohVIRNhJipRCgaSJoI+guGkcu3mt7fVjXzOHM2fm7l6vd92HlHXEka/vY+beOfPNOWe+c1ZAowVRwA4QfJ0SGq4hEdAgSaVQTt420yOE7qZBNyLAOGo8ksvhwz/f2nYargGR0BBBceWWyR8g6F8TABs1IUHnBDV8KhYTf//y/ol1cA1II8AQydRwkxSwlQAATYdSiJqvwZwTTQJ64S70YJHl6oOBCHfc0LYWNdxkwEATJTQKc0Z0Z4CO5NKhCCyyXH0wKEAcfXniHFnDJCoUmgGxh1bWUgolNVKabmpY/KonDXATgbP+ZHG6gGmtwYKA7B58rTSeP3uxsLMVWhUssjTET6ej9+BoJHKqvcXP+J7XRv7RSsBczhVh8NXR6W/849zMybOrbsnB0A6ERZTGmeaXMNJ23clmr7Ck2dcqIiGqm0DkZwpT2c7OW2efulssumX4b7XjfT/NrNLFnMjlc+P9qdXjC/Xt2Xcm4alEm6L+EMuN922j/r+C0vrU5ey56fhMKXueFiEJy6Or1CdvBJW6e2Hy9cCzs6uEn1svpYfoRcY9kTuR7lq2oA69g5kERCNJ8sMOuh0HTw6nNzQfX+gd8fHvje2iMTYLUk8aO5HmLODAI+2rN6fOJKLx5ofI03vJ9duoXQj+B8P0ry8K/u6+7RWlevZc6KH2biHlJmaaQrDZC8TDFECPRqLy82bvEPQBdA4x3gIQLQB6PnU3Y9P3ZQTSe7cs2/3Fg5keL0Lf80SnDNrIsaVnPi36hOelfrYh/tocEI5mO2mIR+mys8Z8SVfRD6q4g8AcngfGx747uo/GoAmwjsCHJ0yUW0ODDtLzpJTWm6yywB1NP3KyYS1UVw5y4y1+80F6xEo7wNyk7ayJaUJxFiGxXPJeGshEQkCkgPwOT5gmKgWmhe8npNQ9ZYC8ULu0wLFOQmzfubE5TZaQBM/fVweEGmYAqfQdLTvmPProt0f66IPdwlmEiSJuwsMGiDJADgSyHJQMBgpzT4oN0dInaDLvqzyzgFhlee6Yz6O48LqCZSsktCYkWNMQkF0mwMujXfEQINUgiMAqHBDmmvWxY6Q1iM300SS8PelPb2zZEtxIJj3u4O0O7ZmOpOUBZhukZ8q12+1RlLdJrTvpeQcGRMoyS7NlIvMJQkqYf84aJq5oUCVkgzHtLFjRIRjfkTJ3QNXZHOar1g3HsqqXxkvC25fNvUemdpXB0A4EN3FHhuzZKSYCGu0UFg40novtKxxYwUGNCoQFUQsd+ArY9ty0LgOHYPuD++OeaFfcTDgMRNm9EMrATJJVFelbmdl3mgBjb+8gxRkSn5RikI35oVPKmCQDU5wdm7r8yn56cim2dNmmJdfd9BGjnvUStF5j4gKwz+PslfPP5iZGno/Em5tbV67u9qPxdvY7YQENJJcDaIrbsSBkHMIALxgAC3gx98Z0ZmTva0efPrRi3e3vXrmu456W69/1CWliGnU6fykvMGpZfL7EZA5kQBYQTbDcDdrvAyglyQd6SOvumnh4HHCHfLPyzDaQfRC1ZHUImPzY2eNPbPnPoR3H3CvpOx9+8cl4y8rN4HzVvEf9ea6zE28M/OGxjnvNXE3T+z/9WP/NG+7/s+d7zaa7rhiHtUJl34fAKgwQUpTNA/OFsVf+8pstz/d961hI7d/37H/5F0tXtPdMzpTYIsLcIFdEWBIVwSBdtGMEW+mwmWzv4SztgjzxaumkANxBbqLL8UKTvVsXEOTXxcMhIHis/PTEXm0sHNH1p1cVT06UZiZ+EgBh5J8Hvn+MOh03/VHZeBAIGwQ6t4NwjADrG3Q9O5XZUwUE69D3uZu/WsgXpyZmiiD9uQQ6rwLARV8IiLKkN7WkgLfXGuLJTolKYiWIGt8nXZRxmyUvVfdPJNaeIvAEAVAGIchE/7jzQy9U91dKnwAVBNsQGOWAWXGVIKC6UIWxlpXPQW3JTWRnnuErOZdAV8ZQJ6CeoB6o/RySvkEClWCf5zggbeCrxdPNsntmQONY0kRPYf6CvqV5L4joJc39rSWFBrb3ZjdAO560l3Rj/lF/6Z+BOpL3ojF266rnlSHEMNSX2m3Ca6OYAeyokqfoorghDFA7Z2KgzK4GlkPIBbIb44EMGq+1C0x2BOciujwMli3EmIZcOGHTxOUXzqoSC7Ql6zXIwF+181mljI6keZ2dquxSyqXg7DJ1OpfYpWwMCm2vvGU7rmC3SAjO3BdNoFGlLfWUJitOWl3mYhbaSTqg7sveptoN6oTlGc5slbLamGelWvPLAZfslCNW2lWrdB0suKjlOIwp7EAIDFT2ebCTuLPjN8ZT5EM9+zLzVvj+gUy3dCuv1dxENxpsLUJ2Mz2vkt4jkz11WaqSxzlSBAxQByttmSXUwIJJF1QTrDpGbdwEHYutXkVX3CkDxJ9BEWKYOlnw9eB9+y/wKptM+AtPZx6lsdO+c2ddtWLxSLlWlQAvMshJG9gMdvvRKUo4xa6aiiIOp7tahnxDc6TLepwluwBa228NaEpagiRdKECsHWDIRQTnNJpjc+gj1h0g8BHtchhtoyK7oeD3OkiPf2397WWTENl2+l7Ek5B3fq2LirJcD5ooh/Hm1O3IAhAGe49kw3OrLeaXHOAgLjBYjeClIL+YJ0Qd2WI08OTCuUrNQZjDiIDqz4kZ5GsQbMtMyAx3gwrtDngHlgMsBl2gSVb4RalQ4tplW/wd16mG0htb+xiMyjMRVrYujJyEmYkEuYxb2VpSInoakDjEcMwwtU9HMyouysVym6O4nCVYoIB8sIVxfQRizgyiZDGx6Uv9EU8sWOypKeQexC63BbchMNgwrZ8wQdeiHhg2gXOTIJKmVN2gISz11vNIF28lKkAD3DZSIXGFmezpSlCtWEkQo5ojEfBI0cLF//7yic+uvZcmtZ4n99ZliBRbHy7yyLn1cQtIPf+yARQr9N1FvQUCaGUyYetBm58YjKAcNOe6Rv+Da9ZPjLz6eCmfG3PglRmruafS6emLf3tm28ADH9huVDOTSm9qXU2t294ElCHTh+oYXdWlQz978fgARaeXrCVINAUv3gSU/mv1V4rnTk7lI9537J1JdSmIelytqGlF2dEXD2nPYGgqQn6sIJqWApWwovGWmVhs6ayJ0Utn1A/NuAGoAsv8YepPj3zwK3ROffibBz+zZHn7rRSxRTF7kTLp1194bs/XDV2f5xrO//s4Lfeo/omOgGnDSiND6a74MNSRhlXH33vXqejomng8limVfzmTEY23r0pcMmVGLmC5CpdH5wNfu77hPyo16IdngH8/dVsh8+M1k6OPv+fy6I1PXjHnkZW/y7CnzalqVeUxDZRF/0nvzh+dRxEq9HJtk84DD97w/2sZ9aS8bZaTNABYHMO4BsCwSXOopvEmbPEqyuKDESrshLbZRUFj0WMGSXud52PQYPkfvzYP1qussyIAAAAASUVORK5CYII="/>
						<h3 style="padding: 12px 0 24px 0;color:#000;text-align:center;">CONTRATO DE FACTORING</h3>
					</td>
				</tr>
				<tr>
					<td>
						<p>Los abajo firmantes, por una parte,el CEDENTE y por la otra parte el FACTOR, y conjuntamente denominadas como “LAS PARTES”, convienen en celebrar el presente CONTRATO DE FACTORING, el que se regirá por las siguientes cláusulas y condiciones</p>
					</td>
				</tr>
				<tr>
					<td>
						<h4 style="color: #000;">CONSIDERANDO:</h4>
						<ul>
							<li>(a) Que EL FACTORo CESIONARIO, es un inversor, persona física o jurídica, que tiene intenciones de adquirir facturas emitidas a empresas, supermercados, locales comerciales, y personas físicas, por la venta de bienes o servicios.</li>
							<li>(b) Que EL CEDIDO es una persona física o jurídica, que cuenta con la verificación de MIPO, con relación a la identidad, denominación social o razón social, conforme a los documentos presentados por los mismos.</li>
							<li>(c) Que EL CEDENTE, vende bienes o servicios a crédito, y está interesado en negociar las facturas cambiarias conformadas por el CEDIDO.Asimismo, el CEDENTE manifiesta y da fe que mediante un sistema de subasta online ha decidido en pleno uso de sus facultades y sin ningún tipo de coacción, intimidación o acuerdo extra de la plataforma, que la elección de la oferta aceptada es resultado del análisis de las diferentes ofertas recibidas y de un exhaustivo análisis de sus costos y necesidades.</li>
							<li>(d) Que el importe del precio de venta aceptado por el CEDENTE, lo ha realiza en forma libre y conscientemente y que no se encuentra afectado de necesidad ni han incurrido en ligerezas, contando el mismo con la experiencia suficiente para apreciar el verdadero sentido y alcance de esta operación; que nada tiene que reclamar ni ahora ni en el futuro con relación al mismo, y que no se encuentra afectado por ninguna de las situaciones previstas en el artículo 671 del Código Civil Paraguayo, que podría llevarlo a cuestionar la firmeza y legitimidad de la presente cesión y mucho menos los derechos que del mismo surgen para el FACTOR.</li>
							<li>(e) LAS PARTES declaran que han llegado a un acuerdo de cesión de crédito a través de la plataforma MIPO, bajo las condiciones señaladas más arriba, a las que se han suscripto voluntariamente, así como también a las cláusulas y condiciones expuestas en este documento</li>
						</ul>
						<h4 style="color: #000;">Las partes citadas acuerdan:</h4>
						<ul>
							<li>1. EL CEDENTEde conformidad a los términos del presente contrato, cede en este acto a favor del FACTOR, todos los derechos y obligaciones que le corresponden por los créditos amparados en las facturas a crédito o factura cambiaria, que se detallan en este instrumento y en la plataforma MIPO. Así mismo se anexan las imágenes de dichas facturas a este instrumento y forman parte del presente contrato, cómo anexo.Se detallan a continuación los documentos objeto del contrato de factoring:</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>
						<table class="desktable" style="border-collapse: collapse; width: 100%;border:1px solid #EEE;text-align:center;font-family: GeneralSans;margin:16px 0;">
							<thead>
								<tr style="background: #FAFAFA;">
									<th style="padding: 10px 0;font-size:14px;font-weight:500;">No Operacion</th>
									<th style="padding: 10px 0;font-size:14px;font-weight:500;">Fecha de emision</th>
									<th style="padding: 10px 0;font-size:14px;font-weight:500;">Monto nominal</th>
									<th style="padding: 10px 0;font-size:14px;font-weight:500;">Vencimieento/pago</th>
									<th style="padding: 10px 0;font-size:14px;font-weight:500;">Cliente/credido</th>
								</tr>
							</thead>
							<tbody>
										<tr style="font-size: 12px;color:#939393;border-bottom:1px solid #EEE;">
											<td style="padding: 12px 0 10px;">Cheque OP0029</td>
											<td style="padding: 12px 0 10px;">14th june 2023</td>
											<td style="padding: 12px 0 10px;">$32.000,00</td>
											<td style="padding: 12px 0 10px;">29th june 2023</td>
											<td style="padding: 12px 0 10px;">Tata</td>
										</tr>
										<tr style="font-size: 12px;color:#939393;border-bottom:1px solid #EEE;">
											<td style="padding: 12px 0 10px;">Cheque OP0029</td>
											<td style="padding: 12px 0 10px;">14th june 2023</td>
											<td style="padding: 12px 0 10px;">$32.000,00</td>
											<td style="padding: 12px 0 10px;">29th june 2023</td>
											<td style="padding: 12px 0 10px;">Tata</td>
										</tr>
										<tr style="font-size: 12px;color:#939393;border-bottom:1px solid #EEE;">
											<td style="padding: 12px 0 10px;">Cheque OP0029</td>
											<td style="padding: 12px 0 10px;">14th june 2023</td>
											<td style="padding: 12px 0 10px;">$32.000,00</td>
											<td style="padding: 12px 0 10px;">29th june 2023</td>
											<td style="padding: 12px 0 10px;">Tata</td>
										</tr>
										<tr style="font-size: 12px;color:#939393;border-bottom:1px solid #EEE;">
											<td style="padding: 12px 0 10px;">Cheque OP0029</td>
											<td style="padding: 12px 0 10px;">14th june 2023</td>
											<td style="padding: 12px 0 10px;">$32.000,00</td>
											<td style="padding: 12px 0 10px;">29th june 2023</td>
											<td style="padding: 12px 0 10px;">Tata</td>
										</tr>
										<tr style="font-size: 12px;color:#939393;border-bottom:1px solid #EEE;">
											<td style="padding: 12px 0 10px;">Cheque OP0029</td>
											<td style="padding: 12px 0 10px;">14th june 2023</td>
											<td style="padding: 12px 0 10px;">$32.000,00</td>
											<td style="padding: 12px 0 10px;">29th june 2023</td>
											<td style="padding: 12px 0 10px;">Tata</td>
										</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<ul>
							<li>2. Esta cesión comprenderá todos los derechos y obligaciones que le corresponden al CEDENTE en relación a Las facturas conformadas o cambiarias cedidos, incluyendo el derecho a cobrar y recibir el pago de los mismos, así como la fuerza ejecutiva de los documentos (artículo 526 del Código Civil), por lo que ELFACTOR se coloca en la misma posición del CEDENTE, en el grado y prelación respecto a los documentos cedidos. El FACTOR acepta la cesión realizada por el CEDENTE.</li>
							<li>3. EL FACTOR pagará al CEDENTE, por la cesión de las facturas a crédito o facturas cambiarias detallados en el presente documento, la suma de <b style="color: #000">VALUE OF OFFER</b> ofertada y aceptada en la plataforma MIPO. Queda expresamente aclarado que la oferta y aceptación, lo realizan directamente el CEDENTE Y EL FACTOR, por lo que MIPO no tiene responsabilidad alguna, en dicha transacción.</li>
							<li>4. Queda a cargo del CESIONARIO, el pago de la comisión por el uso de la plataforma MIPO.</li>
							<li>5. La notificación de la cesión, lo podrá realizar cualquiera de las partes, por medio de notario, telegrama colacionado, correo certificado o correo con acuse de recibo. Así mismo cualquiera de las partes podrá realizar la inscripción del presente contrato de factoraje en el sistema electrónico de operaciones garantizadas.</li>
							<li>6. LAS PARTES acuerdan que todas las facturas créditos o facturas cambiarias, deberán estar conformadas por el CEDIDO, y endosado a favor del FACTOR.</li>
							<li>7. La presente cesión se realiza: <b style="color: #000;">con recurso / sin recurso</b></li>
							<li>8. Es responsabilidad del CEDENTE la emisión de la correspondiente factura por la CESIÓN realizada.</li>
							<li>9. La entrega de las facturas conformadas o facturas cambiarias se realizará al FACTOR, y se dejará constancia en un documento por separado, salvo que el FACTOR contrate con MIPO el servicio de custodia de documentos, que se regirá por un contrato adicional.</li>
							<li>10. MIPO no garantiza, ni certifica el pago de los documentos negociados entre el CEDENTE y el CESIONARIO, por lo que, en caso de incumplimiento, corresponderá al CESIONARIO realizar los actos necesarios para obtener el cobro de dichos instrumentos contra el endosante, en caso de que se haya realizado la operación con recurso, o directamente contra el librador del documento.</li>
							<li>11. Prevalecen sobre este contrato, las disposiciones de la Ley 6542/20 “De Factoraje, factura cambiaria y Sistema electrónico de operaciones garantizadas”.</li>
							<li>12. El CEDENTE garantiza al FACTOR la existencia del crédito cedido, y es responsable civil y penalmente, en caso de su inexistencia.</li>
							<li>13. EL CEDENTE, acepta en forma irrevocable que todos los derechos de cobro de las facturas a crédito o facturas cambiariasobjeto del presente contrato, corresponden única y exclusivamente alFACTOR y deben ser pagados a éste por EL CEDIDO a su vencimiento.</li>
							<li>14. En caso de que el CEDIDO realice un descuento no previsto, o exija del CEDENTE la emisión de una nota de crédito, por devoluciones, bonificaciones u otra clase de descuento, no previsto en el momento de la oferta y aceptación, en la plataforma de MIPO, el CEDENTE se obliga a reembolsar al FACTOR, toda sumar descontada por el CEDIDO, dentro del plazo de 48 (cuarenta y ocho) horas de requerido por el FACTOR.</li>
							<li>15. ElCEDENTEreconoce y acepta que en caso de que por cualquier error por parte del CEDIDO en el pago de los documentos objeto del presente contrato, lo realice a favor del CEDENTE en vez de realizar a favor delFACTOR. El CEDENTE se obliga a reembolsar y entregar al FACTORen un plazo no mayor a 24 (veinticuatro) horas, el monto recibido del CEDIDO, correspondiente a los documentos objeto del presente contrato.Asimismo, declara por medio del presente contrato que el uso del importe recibido erróneamente por el CEDID0 en cualquier otro rubro que no sea el del pago de la obligación asumida por el presente contrato, será considerada como un incumplimiento a su obligación de pago y un engaño a un tercero para obtener un beneficio indebido.</li>
							<li>16. Si alguna de las cláusulas del presente contrato fuere total o parcialmente nula, tal nulidad afectará únicamente a dicha disposición o cláusula. En todo lo demás, este convenio seguirá válido y vinculante como si la disposición o cláusula no hubiere formado parte del mismo.</li>
							<li>17. Para todos los efectos de este contrato, comunicaciones, notificaciones, citaciones y diligencias judiciales o extrajudiciales, las partes constituyen domicilio en los mencionados al final de este instrumento; domicilios que se considerarán válidos para todos los actos jurídicos y administrativos emergentes de la ejecución y cumplimiento de este contrato, salvo que cualquier cambio de domicilio fuere comunicado a la otra por escrito y con acuse de recibo.</li>
							<li>18. Cualquier modificación o renuncia a lo estipulado en el presente acuerdo tendrán únicamente eficacia si son hechos por escrito y firmados por las partes.</li>
							<li>19. Las partes acuerdan someter cualquier controversia que surja de la ejecución de este contrato o tenga relación con el mismo, con su interpretación, validez o invalidez, a un proceso de arbitraje ante el Centro de Arbitraje y Mediación Paraguay (CAMP) de la Cámara Nacional de Comercio y Servicios de Paraguay (CNCSP). El mismo se desarrollará en la sede del Centro, de acuerdo con las normas de procedimiento para arbitraje que posee dicha institución, ante un tribunal arbitral conformado por tres árbitros designados de la lista del Cuerpo Arbitral del Centro de Arbitraje y Mediación Paraguay, que decidirá conforme a derecho, siendo el laudo definitivo y vinculante para las partes. Se aplicará el reglamento respectivo y demás disposiciones que regule dicho procedimiento al momento de ser requerido, declarando las partes conocer y aceptar los vigentes, incluso en orden a su régimen de gastos y costas, considerándolos parte integrante del presente contrato. El término “costas” comprende los honorarios de los abogados de las partes.</li>
							<li>20. El presente contrato y demás documentos, serán firmados en forma electrónica entre las partes, y se aplica las disposiciones de la Ley 6822/21 “De los servicios de confianza para las transacciones electrónicas, del documento electrónico y los documentos transmisibles electrónicos”.</li>
							<li>Previa lectura de su contenido, y en prueba de conformidad y aceptación, suscriben las partes en dos ejemplares de un mismo tenor y a un solo efecto, en la Ciudad de Asunción, a los _____ días del mes _______ del año ______.</li>
						</ul>
					</td>
				</tr>
				<tr>
					<table style="border-collapse: collapse;width:100%;border:1px solid #eee;margin:35px 0 0 0">
						<tr style="border-bottom: 1px solid #eee;">
						  <td style="width:50%;border-right:1px solid #eee;padding:8px 12px;">
							<h4 style="font-size: 12px;padding:0;">Julio Ramirez  (123456789)</h4>
							<table>
								<tr>
									<td style="padding:0 5px 0 0;"><img style="height: 12px;width:12px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAACxLAAAsSwGlPZapAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAUfSURBVHgB7VpNcts2FH4PlFy1i9ZH4KqRu7F6gtBTO+0u7q5OplP5BHVOYOkE9g0sTyd2drF3reOZMCeIu6nVdsPcQLuq/uHLA/8EgqBISpS8yTfjkQCBwPuI94cHA3zCwwKhBthHzmqr0ehQUzyVTSToIPmrhLgaLEI08gV63D/ivivy4d3N/zeut+uOYE7MRaD926YDDdxnATuxsFXAz5wxmeN/nl2cwYyYiYAUnCw8QIQO1AMPfOgPn78ZQEVUItA+dWyA5hF/dWAxcAFud4c7rlf2gdIE1l5t/Qo+9aaoikcE57wrVyyEOx7DKNZxaSNfrDTtO/RtAWIbEB+zAtlGgRBG4Iv+9bM/DqEuAu3TJ/u8YC/n5wH/djzcuXShAtqnbD+EXZbgF/MI7A13LvpF8xQSyBeeXIAGb/fvHsyB9ukPNtB9z0ykmAROnzwrvHSF3MdbfFlqi8vi0cnmngDYz6rodBK5BKTOs05rQqInfPrxr+dvrmABCHYD/Le6fSCJF3k2geaJHA5Gjffpt4EegNiYV2WKYCIhDZvo9luTdxLmaZpHqvCh2ixeeAm5htxlGb3jPtaE1ch9Z5Ah0H651YWMn6f+MoSPIVXUB9D13gk8l4bsDgjY13oGdRtsGfwdrumqfYh4oI9LEfj65Ltt/rDTQ6xCX7w4WLtqi1Wpo+9CigAK1H3xYJmqoyNYm+A43YspDUkIyHCPhNvpwXQMC4Bca439fpDNFgFpkGpyAimfj9sJgZXPLEd70quaHpSBdNGtVlO66ANOxd9GTiMXkQxe3JYeqdVqJFlwQsDKeh4XakaUzbKPV+xMwOOi5/hwdK62SdGUhAChWE8/hOdQI4zCh3hX9CyRSEd+RDv+OiEQBIsJ7og8qAn5wsv4UuIQIyxXbSJQ8rIbyRgO3aRkFrc3tx6UEyw44LCPPrz+6eIFVBL+sgclMB6PR2w3SZsNOWvEehZY5sCNZO1BZDtEtNc+3TqqW3iTLKq2CKgX3ZhEXcIXISGgJk8Sqq/NA2HzMMxSU+g+evXkdZ3C67IEx84IqgqlCHz+pfgKChBGabGhk+CXYUhJZn/zzRV9rsl6CgFKuSoawwaUQB6JNOZTG0TLTs1GfnYHOAf/kBqEVumaz3QS8+u8wKDiN5mR8M/kt6STq2TqINazp1ABZhK1GayjNgSgO/keYTy+u9IM2TYdIKYhJsHzcDygjTqEjxI+W+37j+uq8fckkElfyy5Q2oEzGRqk1y5UQJR+13cAaqRTfA6252pc0OIA6YeXbujPHwbR2l21T5AspClttSFTV45yWsnEfJheDpra8Ra9a62SnYnEiKTnM87ayfd7sGQEtVjt7Rs0JK8utCWjqJMM4sh3dw8b/y6ooJVd31SXIpc1JBObcnIha1evy1gCXi/DHuIcKluXauyaxhsJSE9iqMvYcuJFkvjm5VYnP4cyFxdys9GwLpPRORux+X4RNhHUYpGMwk+rS5Uor2/29FJGhAEfe/pVblPM80+79SmO5IUEwkU2ezkkJAZ8/jwe/lzxgiO8IJRBqmseUS4NKUVAIr9+n8DjP9fnYgCfzjx5JFWvmFrAp6iVprwcXGej3M69Yqp4/1CagERY+r5f4CVf9VufSgRicJzohiplfotVQXwxKBPAWQppMxGIIYvBFtdTKVOSLLFwcGsfHKL681QA5yIQQ+q4LE0iCC6v0LoMfJyz2xSVP0JhYcS/Xfk+fuDPM5m+1/GvBp/w0PgIjI9pvXFLhAQAAAAASUVORK5CYII=" alt=""></td>
									<td>
										<p>Firmado electronicamente por</p>
										<p> 02/07/2023 15:55:31 hrs - IP: 187.654.54.445</p>
									</td>
								</tr>
							</table>
						  </td>
						  <td style="width:50%;border-right:1px solid #eee;padding:8px 12px;">
							<h4 style="font-size: 12px;padding:0;">Andrea L. Peralta (123456789)</h4>
							<table>
								<tr>
									<td style="padding:0 5px 0 0;"><img style="height: 12px;width:12px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAACxLAAAsSwGlPZapAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAUfSURBVHgB7VpNcts2FH4PlFy1i9ZH4KqRu7F6gtBTO+0u7q5OplP5BHVOYOkE9g0sTyd2drF3reOZMCeIu6nVdsPcQLuq/uHLA/8EgqBISpS8yTfjkQCBwPuI94cHA3zCwwKhBthHzmqr0ehQUzyVTSToIPmrhLgaLEI08gV63D/ivivy4d3N/zeut+uOYE7MRaD926YDDdxnATuxsFXAz5wxmeN/nl2cwYyYiYAUnCw8QIQO1AMPfOgPn78ZQEVUItA+dWyA5hF/dWAxcAFud4c7rlf2gdIE1l5t/Qo+9aaoikcE57wrVyyEOx7DKNZxaSNfrDTtO/RtAWIbEB+zAtlGgRBG4Iv+9bM/DqEuAu3TJ/u8YC/n5wH/djzcuXShAtqnbD+EXZbgF/MI7A13LvpF8xQSyBeeXIAGb/fvHsyB9ukPNtB9z0ykmAROnzwrvHSF3MdbfFlqi8vi0cnmngDYz6rodBK5BKTOs05rQqInfPrxr+dvrmABCHYD/Le6fSCJF3k2geaJHA5Gjffpt4EegNiYV2WKYCIhDZvo9luTdxLmaZpHqvCh2ixeeAm5htxlGb3jPtaE1ch9Z5Ah0H651YWMn6f+MoSPIVXUB9D13gk8l4bsDgjY13oGdRtsGfwdrumqfYh4oI9LEfj65Ltt/rDTQ6xCX7w4WLtqi1Wpo+9CigAK1H3xYJmqoyNYm+A43YspDUkIyHCPhNvpwXQMC4Bca439fpDNFgFpkGpyAimfj9sJgZXPLEd70quaHpSBdNGtVlO66ANOxd9GTiMXkQxe3JYeqdVqJFlwQsDKeh4XakaUzbKPV+xMwOOi5/hwdK62SdGUhAChWE8/hOdQI4zCh3hX9CyRSEd+RDv+OiEQBIsJ7og8qAn5wsv4UuIQIyxXbSJQ8rIbyRgO3aRkFrc3tx6UEyw44LCPPrz+6eIFVBL+sgclMB6PR2w3SZsNOWvEehZY5sCNZO1BZDtEtNc+3TqqW3iTLKq2CKgX3ZhEXcIXISGgJk8Sqq/NA2HzMMxSU+g+evXkdZ3C67IEx84IqgqlCHz+pfgKChBGabGhk+CXYUhJZn/zzRV9rsl6CgFKuSoawwaUQB6JNOZTG0TLTs1GfnYHOAf/kBqEVumaz3QS8+u8wKDiN5mR8M/kt6STq2TqINazp1ABZhK1GayjNgSgO/keYTy+u9IM2TYdIKYhJsHzcDygjTqEjxI+W+37j+uq8fckkElfyy5Q2oEzGRqk1y5UQJR+13cAaqRTfA6252pc0OIA6YeXbujPHwbR2l21T5AspClttSFTV45yWsnEfJheDpra8Ra9a62SnYnEiKTnM87ayfd7sGQEtVjt7Rs0JK8utCWjqJMM4sh3dw8b/y6ooJVd31SXIpc1JBObcnIha1evy1gCXi/DHuIcKluXauyaxhsJSE9iqMvYcuJFkvjm5VYnP4cyFxdys9GwLpPRORux+X4RNhHUYpGMwk+rS5Uor2/29FJGhAEfe/pVblPM80+79SmO5IUEwkU2ezkkJAZ8/jwe/lzxgiO8IJRBqmseUS4NKUVAIr9+n8DjP9fnYgCfzjx5JFWvmFrAp6iVprwcXGej3M69Yqp4/1CagERY+r5f4CVf9VufSgRicJzohiplfotVQXwxKBPAWQppMxGIIYvBFtdTKVOSLLFwcGsfHKL681QA5yIQQ+q4LE0iCC6v0LoMfJyz2xSVP0JhYcS/Xfk+fuDPM5m+1/GvBp/w0PgIjI9pvXFLhAQAAAAASUVORK5CYII=" alt=""></td>
									<td>
										<p>Firmado electronicamente por</p>
										<p> 02/07/2023 15:55:31 hrs - IP: 187.654.54.445</p>
									</td>
								</tr>
							</table>
						  </td>
						</tr>
						<tr style="border-bottom: 1px solid #eee;">
							<td style="width:50%;border-right:1px solid #eee;padding:8px 12px;">
							  <h4 style="font-size: 12px;padding:0;">Julio Ramirez  (123456789)</h4>
							  <table>
								  <tr>
									  <td style="padding:0 5px 0 0;"><img style="height: 12px;width:12px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAACxLAAAsSwGlPZapAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAUfSURBVHgB7VpNcts2FH4PlFy1i9ZH4KqRu7F6gtBTO+0u7q5OplP5BHVOYOkE9g0sTyd2drF3reOZMCeIu6nVdsPcQLuq/uHLA/8EgqBISpS8yTfjkQCBwPuI94cHA3zCwwKhBthHzmqr0ehQUzyVTSToIPmrhLgaLEI08gV63D/ivivy4d3N/zeut+uOYE7MRaD926YDDdxnATuxsFXAz5wxmeN/nl2cwYyYiYAUnCw8QIQO1AMPfOgPn78ZQEVUItA+dWyA5hF/dWAxcAFud4c7rlf2gdIE1l5t/Qo+9aaoikcE57wrVyyEOx7DKNZxaSNfrDTtO/RtAWIbEB+zAtlGgRBG4Iv+9bM/DqEuAu3TJ/u8YC/n5wH/djzcuXShAtqnbD+EXZbgF/MI7A13LvpF8xQSyBeeXIAGb/fvHsyB9ukPNtB9z0ykmAROnzwrvHSF3MdbfFlqi8vi0cnmngDYz6rodBK5BKTOs05rQqInfPrxr+dvrmABCHYD/Le6fSCJF3k2geaJHA5Gjffpt4EegNiYV2WKYCIhDZvo9luTdxLmaZpHqvCh2ixeeAm5htxlGb3jPtaE1ch9Z5Ah0H651YWMn6f+MoSPIVXUB9D13gk8l4bsDgjY13oGdRtsGfwdrumqfYh4oI9LEfj65Ltt/rDTQ6xCX7w4WLtqi1Wpo+9CigAK1H3xYJmqoyNYm+A43YspDUkIyHCPhNvpwXQMC4Bca439fpDNFgFpkGpyAimfj9sJgZXPLEd70quaHpSBdNGtVlO66ANOxd9GTiMXkQxe3JYeqdVqJFlwQsDKeh4XakaUzbKPV+xMwOOi5/hwdK62SdGUhAChWE8/hOdQI4zCh3hX9CyRSEd+RDv+OiEQBIsJ7og8qAn5wsv4UuIQIyxXbSJQ8rIbyRgO3aRkFrc3tx6UEyw44LCPPrz+6eIFVBL+sgclMB6PR2w3SZsNOWvEehZY5sCNZO1BZDtEtNc+3TqqW3iTLKq2CKgX3ZhEXcIXISGgJk8Sqq/NA2HzMMxSU+g+evXkdZ3C67IEx84IqgqlCHz+pfgKChBGabGhk+CXYUhJZn/zzRV9rsl6CgFKuSoawwaUQB6JNOZTG0TLTs1GfnYHOAf/kBqEVumaz3QS8+u8wKDiN5mR8M/kt6STq2TqINazp1ABZhK1GayjNgSgO/keYTy+u9IM2TYdIKYhJsHzcDygjTqEjxI+W+37j+uq8fckkElfyy5Q2oEzGRqk1y5UQJR+13cAaqRTfA6252pc0OIA6YeXbujPHwbR2l21T5AspClttSFTV45yWsnEfJheDpra8Ra9a62SnYnEiKTnM87ayfd7sGQEtVjt7Rs0JK8utCWjqJMM4sh3dw8b/y6ooJVd31SXIpc1JBObcnIha1evy1gCXi/DHuIcKluXauyaxhsJSE9iqMvYcuJFkvjm5VYnP4cyFxdys9GwLpPRORux+X4RNhHUYpGMwk+rS5Uor2/29FJGhAEfe/pVblPM80+79SmO5IUEwkU2ezkkJAZ8/jwe/lzxgiO8IJRBqmseUS4NKUVAIr9+n8DjP9fnYgCfzjx5JFWvmFrAp6iVprwcXGej3M69Yqp4/1CagERY+r5f4CVf9VufSgRicJzohiplfotVQXwxKBPAWQppMxGIIYvBFtdTKVOSLLFwcGsfHKL681QA5yIQQ+q4LE0iCC6v0LoMfJyz2xSVP0JhYcS/Xfk+fuDPM5m+1/GvBp/w0PgIjI9pvXFLhAQAAAAASUVORK5CYII=" alt=""></td>
									  <td>
										  <p>Firmado electronicamente por</p>
										  <p> 02/07/2023 15:55:31 hrs - IP: 187.654.54.445</p>
									  </td>
								  </tr>
							  </table>
							</td>
							<td style="width:50%;border-right:1px solid #eee;padding:8px 12px;">
							  <h4 style="font-size: 12px;padding:0;">Andrea L. Peralta (123456789)</h4>
							  <table>
								  <tr>
									  <td style="padding:0 5px 0 0;"><img style="height: 12px;width:12px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAACxLAAAsSwGlPZapAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAUfSURBVHgB7VpNcts2FH4PlFy1i9ZH4KqRu7F6gtBTO+0u7q5OplP5BHVOYOkE9g0sTyd2drF3reOZMCeIu6nVdsPcQLuq/uHLA/8EgqBISpS8yTfjkQCBwPuI94cHA3zCwwKhBthHzmqr0ehQUzyVTSToIPmrhLgaLEI08gV63D/ivivy4d3N/zeut+uOYE7MRaD926YDDdxnATuxsFXAz5wxmeN/nl2cwYyYiYAUnCw8QIQO1AMPfOgPn78ZQEVUItA+dWyA5hF/dWAxcAFud4c7rlf2gdIE1l5t/Qo+9aaoikcE57wrVyyEOx7DKNZxaSNfrDTtO/RtAWIbEB+zAtlGgRBG4Iv+9bM/DqEuAu3TJ/u8YC/n5wH/djzcuXShAtqnbD+EXZbgF/MI7A13LvpF8xQSyBeeXIAGb/fvHsyB9ukPNtB9z0ykmAROnzwrvHSF3MdbfFlqi8vi0cnmngDYz6rodBK5BKTOs05rQqInfPrxr+dvrmABCHYD/Le6fSCJF3k2geaJHA5Gjffpt4EegNiYV2WKYCIhDZvo9luTdxLmaZpHqvCh2ixeeAm5htxlGb3jPtaE1ch9Z5Ah0H651YWMn6f+MoSPIVXUB9D13gk8l4bsDgjY13oGdRtsGfwdrumqfYh4oI9LEfj65Ltt/rDTQ6xCX7w4WLtqi1Wpo+9CigAK1H3xYJmqoyNYm+A43YspDUkIyHCPhNvpwXQMC4Bca439fpDNFgFpkGpyAimfj9sJgZXPLEd70quaHpSBdNGtVlO66ANOxd9GTiMXkQxe3JYeqdVqJFlwQsDKeh4XakaUzbKPV+xMwOOi5/hwdK62SdGUhAChWE8/hOdQI4zCh3hX9CyRSEd+RDv+OiEQBIsJ7og8qAn5wsv4UuIQIyxXbSJQ8rIbyRgO3aRkFrc3tx6UEyw44LCPPrz+6eIFVBL+sgclMB6PR2w3SZsNOWvEehZY5sCNZO1BZDtEtNc+3TqqW3iTLKq2CKgX3ZhEXcIXISGgJk8Sqq/NA2HzMMxSU+g+evXkdZ3C67IEx84IqgqlCHz+pfgKChBGabGhk+CXYUhJZn/zzRV9rsl6CgFKuSoawwaUQB6JNOZTG0TLTs1GfnYHOAf/kBqEVumaz3QS8+u8wKDiN5mR8M/kt6STq2TqINazp1ABZhK1GayjNgSgO/keYTy+u9IM2TYdIKYhJsHzcDygjTqEjxI+W+37j+uq8fckkElfyy5Q2oEzGRqk1y5UQJR+13cAaqRTfA6252pc0OIA6YeXbujPHwbR2l21T5AspClttSFTV45yWsnEfJheDpra8Ra9a62SnYnEiKTnM87ayfd7sGQEtVjt7Rs0JK8utCWjqJMM4sh3dw8b/y6ooJVd31SXIpc1JBObcnIha1evy1gCXi/DHuIcKluXauyaxhsJSE9iqMvYcuJFkvjm5VYnP4cyFxdys9GwLpPRORux+X4RNhHUYpGMwk+rS5Uor2/29FJGhAEfe/pVblPM80+79SmO5IUEwkU2ezkkJAZ8/jwe/lzxgiO8IJRBqmseUS4NKUVAIr9+n8DjP9fnYgCfzjx5JFWvmFrAp6iVprwcXGej3M69Yqp4/1CagERY+r5f4CVf9VufSgRicJzohiplfotVQXwxKBPAWQppMxGIIYvBFtdTKVOSLLFwcGsfHKL681QA5yIQQ+q4LE0iCC6v0LoMfJyz2xSVP0JhYcS/Xfk+fuDPM5m+1/GvBp/w0PgIjI9pvXFLhAQAAAAASUVORK5CYII=" alt=""></td>
									  <td>
										  <p>Firmado electronicamente por</p>
										  <p> 02/07/2023 15:55:31 hrs - IP: 187.654.54.445</p>
									  </td>
								  </tr>
							  </table>
							</td>
						</tr>
						<tr style="border-bottom: 1px solid #eee;">
							<td style="width:50%;border-right:1px solid #eee;padding:8px 12px;"><p style="color:#007BFF;font-size:12px;font-weight:500;">Biggie S.A. <span style="font-size: 10px;">(123456789)</span></p></td>
							<td style="width:50%;border-right:1px solid #eee;padding:8px 12px;"><p style="color:#007BFF;font-size:12px;font-weight:500;">Retail S.A. <span style="font-size: 10px;">(123456789)</span></p></td>
						</tr>
						<tr style="border-bottom: 1px solid #eee;">
							<td style="width:50%;border-right:1px solid #eee;padding:8px 12px;background:#FAFAFA;"><strong style="color: #000;">EL CEDENTE</strong></td>
							<td style="width:50%;border-right:1px solid #eee;padding:8px 12px;background:#FAFAFA;"><strong style="color: #000;">EL CESIONARIO</strong></td>
						</tr>
					</table>
				</tr>
			</table>
		</div>
	</body>
</html>