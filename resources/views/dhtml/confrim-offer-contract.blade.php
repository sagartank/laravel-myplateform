<x-app-layout>
    @section('custom_style')
      <style>
        .contract_head .arobox{display: flex;align-items: center;padding: 36px 0 32px;}
        .contract_head .arobox a{display: flex;}
        .contract_head .arobox a .day{display: block;}
        .contract_head .arobox a .night{display: none;}
        .dark-mode .contract_head .arobox a .day{display: none;}
        .dark-mode .contract_head .arobox a .night{display: block;}
        .contract_head .arobox h2{color: var(--m-text-blue);margin: 0 0 0 8px;}
        .contra_table_wrapper h5{padding: 40px 0 0 0;}
        .contra_table_wrapper ul{padding: 0 0 40px;}
        .contra_table_wrapper ul li+li{padding: 30px 0 0 0;}

        .contract_twobox_wrap{padding: 36px 0;}
		.contract_twobox_wrap .left ul li:last-child,.contract_twobox_wrap .right ul li:last-child{background: var(--m-background-light-white);}
		.contract_twobox_wrap {display: flex;width: 100%;justify-content: space-between;column-gap: 36px;}
		.contract_twobox_wrap .left{border: 1px solid var(--m-stroke-stroke);}
		.contract_twobox_wrap .left ul li,.contract_twobox_wrap .right ul li{padding: 8px 24px;color: var(--m-text-black)}
		.contract_twobox_wrap .left ul li,.contract_twobox_wrap .right ul li span{font-weight: 400;}
		.contract_twobox_wrap .left ul li a,.contract_twobox_wrap .right ul li a{display: block;color: var( --m-text-blue);}
		.contract_twobox_wrap .left ul li a span,.contract_twobox_wrap .right ul li a span{font-weight: 400; }
		.contract_twobox_wrap .left ul li+li,.contract_twobox_wrap .right ul li+li{border-top: 1px solid var(--m-stroke-stroke)}
		.contract_twobox_wrap .right{border: 1px solid var(--m-stroke-stroke);}
		.contract_twobox_wrap .row{width:100%;}

        .contra_atencion_sec {border-radius: var(--m-border-radius-8);border: 1px solid var(--m-border-blue);background: var(--m-bgblue-light);padding: 12px;}
 		.contra_atencion_sec .head {display: flex;align-items: center;padding: 0 0 4px 0;} 
 		.contra_atencion_sec .head i {max-width: 20px;margin: 0 8px 0 0;}
 		.contra_atencion_sec .head i img {width: 100%;height: auto;}
 		.contra_atencion_sec .head h6 {color: var(--m-text-blue);}
 		.contra_atencion_sec p {color: var(--m-text-light-grey);padding: 0 0 0 24px;}

         .otpverify_box_wrap{ display: flex;justify-content: space-between;width:100%;column-gap: 33px;padding: 36px 0 24px;border-bottom: 1px solid var(--m-stroke-stroke);}
		.otpverify_box_wrap .row{width: 100%;}
		.otpverify_box_wrap .confirm_otpbox{margin: 16px 0 0 0;}
		.otpverify_box_wrap .confirm_otpbox{display:flex;justify-content: space-between;}
		.otpverify_box_wrap .confirm_otpbox button{border: none; display: flex;align-items: center;justify-content: center;color: var(--m-text-white);background: var(--m-button-bg-blue);border-radius: var(--m-border-radius-4);padding: 7px 14px; transition: all 0.3s ease-in-out;}
		.otpverify_box_wrap .confirm_otpbox button:hover{background: var(--m-button-bg-blue-hover);}
		.otpverify_box_wrap .confirm_otpbox a{display: flex;}
		.otpverify_box_wrap .confirm_otpbox a span{color: var(--m-text-grey);}
        .otpverify_box_wrap .row .lft + .lft{margin-top:15px;}
		.otpverify_box_wrap .row .right + .right{margin-top:15px;}

        .check_privacy{padding: 48px 0 0 0;}
        .check_privacy a{display: inline-flex;}
        .btnbox{display: flex;padding: 24px 0 0 0;}
        .btnbox a{display: flex;align-items: center;justify-content: center;color: var(--m-text-white);padding: 9px 18px;background: var(--m-button-bg-blue);border-radius: var(--m-border-radius-4);transition: all 0.3s ease-in-out;}
        .btnbox a:hover{background: var(--m-button-bg-blue-hover);}

        .contraboxdata{display:flex;justify-content: space-between;}
		.contraboxdata .lft p{color:var(--m-text-black);}

        .desktable{display: table;}
        .mbtable{display: none;}
        @media (min-width: 992px) and (max-width: 1199px) {}
		@media (min-width: 768px) and (max-width: 991px) {
			.otpverify_box_wrap {flex-wrap: wrap;}
			.otpverify_box_wrap .lft, .otpverify_box_wrap .right {width: 100%;}
			.contra_privacy p {flex-wrap: wrap;}
		}
		@media (max-width: 767px) {
            .desktable{display: none;}
            .mbtable{display: block;}
			.mb_boxtable{display: block;border-bottom: 1px solid;padding: 0 0 5px;}
			.contraboxdata + .contraboxdata{padding:6px 0 0 0;}
			.mb_boxtable + .mb_boxtable{margin: 10px 0 0 0;}
			.contract_twobox_wrap{flex-wrap: wrap;row-gap: 20px;}	
			.contract_twobox_wrap .left{width:100%;}
			.contract_twobox_wrap .right{width:100%;}
			.otpverify_box_wrap{flex-wrap: wrap;row-gap: 20px;padding: 20px 0 20px;}
			.otpverify_box_wrap .lft, .otpverify_box_wrap .right {width: 100%;}
			.contra_privacy{padding:10px 0 0 15px;}
			.contra_privacy p{flex-wrap:wrap;}
			.contract_twobox_wrap .left ul li, .contract_twobox_wrap .right ul li span {font-size: 12px;}
			.contra_atencion_sec p{padding:0;font-size:12px;}
			.contract_twobox_wrap .right ul li{font-size: 12px;}
			.contract_twobox_wrap .left ul li a,.contract_twobox_wrap .right ul li a{font-size: 12px;}
			.contract_twobox_wrap .row {row-gap: 10px;}
			.otpverify_box_wrap .row {row-gap: 15px;}
		}
        @page {
            size: 7in 9.25in;
            margin: 27mm 16mm 27mm 16mm;
			padding: 27mm 16mm 27mm 16mm;
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
      </style>
    @endsection

<div class="contract_contain">
    <div class="container">
        <div class="contract_head">
            <div class="arobox">
                <a href="#">
                    <i><img src="{{ asset('images/mipo/topleftAro.svg') }}" class="day" alt="no-image" alt="no-image"></i>
                    <i> <img src="{{ asset('images/mipo/white_lft_aro.svg') }}" class="night" alt="no-image" alt="no-image"></i>
                </a>
                <h2 class="text-24-semibold">Contrato de factoring</h2>
            </div>
        </div>
        <div class="contra_table_wrapper">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <p style="color: #939393;font-size:16px">Los abajo firmantes, por una parte,el CEDENTE y por la otra parte el FACTOR, y conjuntamente denominadas como “LAS PARTES”, convienen en celebrar el presente CONTRATO DE FACTORING, el que se regirá por las siguientes cláusulas y condiciones</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5 style="font-size: 16px;font-weight:700;line-height:26px;">CONSIDERANDO:</h5>
                        <ul>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">(a) Que EL FACTORo CESIONARIO, es un inversor, persona física o jurídica, que tiene intenciones de adquirir facturas emitidas a empresas, supermercados, locales comerciales, y personas físicas, por la venta de bienes o servicios.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">(b) Que EL CEDIDO es una persona física o jurídica, que cuenta con la verificación de MIPO, con relación a la identidad, denominación social o razón social, conforme a los documentos presentados por los mismos.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">(c) Que EL CEDENTE, vende bienes o servicios a crédito, y está interesado en negociar las facturas cambiarias conformadas por el CEDIDO.Asimismo, el CEDENTE manifiesta y da fe que mediante un sistema de subasta online ha decidido en pleno uso de sus facultades y sin ningún tipo de coacción, intimidación o acuerdo extra de la plataforma, que la elección de la oferta aceptada es resultado del análisis de las diferentes ofertas recibidas y de un exhaustivo análisis de sus costos y necesidades.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">(d) Que el importe del precio de venta aceptado por el CEDENTE, lo ha realiza en forma libre y conscientemente y que no se encuentra afectado de necesidad ni han incurrido en ligerezas, contando el mismo con la experiencia suficiente para apreciar el verdadero sentido y alcance de esta operación; que nada tiene que reclamar ni ahora ni en el futuro con relación al mismo, y que no se encuentra afectado por ninguna de las situaciones previstas en el artículo 671 del Código Civil Paraguayo, que podría llevarlo a cuestionar la firmeza y legitimidad de la presente cesión y mucho menos los derechos que del mismo surgen para el FACTOR.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">(e) LAS PARTES declaran que han llegado a un acuerdo de cesión de crédito a través de la plataforma MIPO, bajo las condiciones señaladas más arriba, a las que se han suscripto voluntariamente, así como también a las cláusulas y condiciones expuestas en este documento</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5 style="font-size: 16px;font-weight:700;line-height:26px;">Las partes citadas acuerdan:</h5>
                        <p style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;"></p>
                        <ul>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">1. EL CEDENTEde conformidad a los términos del presente contrato, cede en este acto a favor del FACTOR, todos los derechos y obligaciones que le corresponden por los créditos amparados en las facturas a crédito o factura cambiaria, que se detallan en este instrumento y en la plataforma MIPO. Así mismo se anexan las imágenes de dichas facturas a este instrumento y forman parte del presente contrato, cómo anexo.Se detallan a continuación los documentos objeto del contrato de factoring:</li>
                            <table class="desktable" style="width: 100%;border:1px solid #EEE;text-align:center;font-family: GeneralSans;margin:16px 0;">
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
                            {{-- mobile table:st --}}
                            <div class="mbtable">
                                <div class="mb_boxtable">
                                    <div class="contraboxdata">
                                        <div class="lft"><p>No Operación</p></div>
                                        <div class="right"><p>Invoice OP0039</p></div>
                                    </div>
                                    <div class="contraboxdata">
                                        <div class="lft"><p>Fecha de emisión</p></div>
                                        <div class="right"><p>10th August 2023</p></div>
                                    </div>
                                    <div class="contraboxdata">
                                        <div class="lft"><p>Monto Nominal</p></div>
                                        <div class="right"><p>₲40.000</p></div>
                                    </div>
                                    <div class="contraboxdata">
                                        <div class="lft"><p>Vencimiento/pago</p></div>
                                        <div class="right"><p>28th July 2023</p></div>
                                    </div>
                                    <div class="contraboxdata">
                                        <div class="lft"><p>Cliente/Cedido</p></div>
                                        <div class="right"><p>tata</p></div>
                                    </div>
                                </div>
                                <div class="mb_boxtable">
                                    <div class="contraboxdata">
                                        <div class="lft"><p>No Operación</p></div>
                                        <div class="right"><p>Invoice OP0039</p></div>
                                    </div>
                                    <div class="contraboxdata">
                                        <div class="lft"><p>Fecha de emisión</p></div>
                                        <div class="right"><p>10th August 2023</p></div>
                                    </div>
                                    <div class="contraboxdata">
                                        <div class="lft"><p>Monto Nominal</p></div>
                                        <div class="right"><p>₲40.000</p></div>
                                    </div>
                                    <div class="contraboxdata">
                                        <div class="lft"><p>Vencimiento/pago</p></div>
                                        <div class="right"><p>28th July 2023</p></div>
                                    </div>
                                    <div class="contraboxdata">
                                        <div class="lft"><p>Cliente/Cedido</p></div>
                                        <div class="right"><p>tata</p></div>
                                    </div>
                                </div>
                                <div class="mb_boxtable">
                                    <div class="contraboxdata">
                                        <div class="lft"><p>No Operación</p></div>
                                        <div class="right"><p>Invoice OP0039</p></div>
                                    </div>
                                    <div class="contraboxdata">
                                        <div class="lft"><p>Fecha de emisión</p></div>
                                        <div class="right"><p>10th August 2023</p></div>
                                    </div>
                                    <div class="contraboxdata">
                                        <div class="lft"><p>Monto Nominal</p></div>
                                        <div class="right"><p>₲40.000</p></div>
                                    </div>
                                    <div class="contraboxdata">
                                        <div class="lft"><p>Vencimiento/pago</p></div>
                                        <div class="right"><p>28th July 2023</p></div>
                                    </div>
                                    <div class="contraboxdata">
                                        <div class="lft"><p>Cliente/Cedido</p></div>
                                        <div class="right"><p>tata</p></div>
                                    </div>
                                </div>
                            </div>
                             {{-- mobile table:nd --}}
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">2. Esta cesión comprenderá todos los derechos y obligaciones que le corresponden al CEDENTE en relación a Las facturas conformadas o cambiarias cedidos, incluyendo el derecho a cobrar y recibir el pago de los mismos, así como la fuerza ejecutiva de los documentos (artículo 526 del Código Civil), por lo que ELFACTOR se coloca en la misma posición del CEDENTE, en el grado y prelación respecto a los documentos cedidos. El FACTOR acepta la cesión realizada por el CEDENTE.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">3. EL FACTOR pagará al CEDENTE, por la cesión de las facturas a crédito o facturas cambiarias detallados en el presente documento, la suma de <b style="color: #000;">VALUE OF OFFER</b> ofertada y aceptada en la plataforma MIPO. Queda expresamente aclarado que la oferta y aceptación, lo realizan directamente el CEDENTE Y EL FACTOR, por lo que MIPO no tiene responsabilidad alguna, en dicha transacción.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">4. Queda a cargo del CESIONARIO, el pago de la comisión por el uso de la plataforma MIPO.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">5. La notificación de la cesión, lo podrá realizar cualquiera de las partes, por medio de notario, telegrama colacionado, correo certificado o correo con acuse de recibo. Así mismo cualquiera de las partes podrá realizar la inscripción del presente contrato de factoraje en el sistema electrónico de operaciones garantizadas.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">6. LAS PARTES acuerdan que todas las facturas créditos o facturas cambiarias, deberán estar conformadas por el CEDIDO, y endosado a favor del FACTOR.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">7. La presente cesión se realiza:<b style="color: #000;">con recurso / sin recurso</b></li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">8. Es responsabilidad del CEDENTE la emisión de la correspondiente factura por la CESIÓN realizada.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">9. La entrega de las facturas conformadas o facturas cambiarias se realizará al FACTOR, y se dejará constancia en un documento por separado, salvo que el FACTOR contrate con MIPO el servicio de custodia de documentos, que se regirá por un contrato adicional.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">10. MIPO no garantiza, ni certifica el pago de los documentos negociados entre el CEDENTE y el CESIONARIO, por lo que, en caso de incumplimiento, corresponderá al CESIONARIO realizar los actos necesarios para obtener el cobro de dichos instrumentos contra el endosante, en caso de que se haya realizado la operación con recurso, o directamente contra el librador del documento.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">11. Prevalecen sobre este contrato, las disposiciones de la Ley 6542/20 “De Factoraje, factura cambiaria y Sistema electrónico de operaciones garantizadas”.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">12. El CEDENTE garantiza al FACTOR la existencia del crédito cedido, y es responsable civil y penalmente, en caso de su inexistencia.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">13. EL CEDENTE, acepta en forma irrevocable que todos los derechos de cobro de las facturas a crédito o facturas cambiariasobjeto del presente contrato, corresponden única y exclusivamente alFACTOR y deben ser pagados a éste por EL CEDIDO a su vencimiento.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">14. En caso de que el CEDIDO realice un descuento no previsto, o exija del CEDENTE la emisión de una nota de crédito, por devoluciones, bonificaciones u otra clase de descuento, no previsto en el momento de la oferta y aceptación, en la plataforma de MIPO, el CEDENTE se obliga a reembolsar al FACTOR, toda sumar descontada por el CEDIDO, dentro del plazo de 48 (cuarenta y ocho) horas de requerido por el FACTOR.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">15. ElCEDENTEreconoce y acepta que en caso de que por cualquier error por parte del CEDIDO en el pago de los documentos objeto del presente contrato, lo realice a favor del CEDENTE en vez de realizar a favor delFACTOR. El CEDENTE se obliga a reembolsar y entregar al FACTORen un plazo no mayor a 24 (veinticuatro) horas, el monto recibido del CEDIDO, correspondiente a los documentos objeto del presente contrato.Asimismo, declara por medio del presente contrato que el uso del importe recibido erróneamente por el CEDID0 en cualquier otro rubro que no sea el del pago de la obligación asumida por el presente contrato, será considerada como un incumplimiento a su obligación de pago y un engaño a un tercero para obtener un beneficio indebido.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">16. Si alguna de las cláusulas del presente contrato fuere total o parcialmente nula, tal nulidad afectará únicamente a dicha disposición o cláusula. En todo lo demás, este convenio seguirá válido y vinculante como si la disposición o cláusula no hubiere formado parte del mismo.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">17. Para todos los efectos de este contrato, comunicaciones, notificaciones, citaciones y diligencias judiciales o extrajudiciales, las partes constituyen domicilio en los mencionados al final de este instrumento; domicilios que se considerarán válidos para todos los actos jurídicos y administrativos emergentes de la ejecución y cumplimiento de este contrato, salvo que cualquier cambio de domicilio fuere comunicado a la otra por escrito y con acuse de recibo.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">18. Cualquier modificación o renuncia a lo estipulado en el presente acuerdo tendrán únicamente eficacia si son hechos por escrito y firmados por las partes.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">19. Las partes acuerdan someter cualquier controversia que surja de la ejecución de este contrato o tenga relación con el mismo, con su interpretación, validez o invalidez, a un proceso de arbitraje ante el Centro de Arbitraje y Mediación Paraguay (CAMP) de la Cámara Nacional de Comercio y Servicios de Paraguay (CNCSP). El mismo se desarrollará en la sede del Centro, de acuerdo con las normas de procedimiento para arbitraje que posee dicha institución, ante un tribunal arbitral conformado por tres árbitros designados de la lista del Cuerpo Arbitral del Centro de Arbitraje y Mediación Paraguay, que decidirá conforme a derecho, siendo el laudo definitivo y vinculante para las partes. Se aplicará el reglamento respectivo y demás disposiciones que regule dicho procedimiento al momento de ser requerido, declarando las partes conocer y aceptar los vigentes, incluso en orden a su régimen de gastos y costas, considerándolos parte integrante del presente contrato. El término “costas” comprende los honorarios de los abogados de las partes.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">20. El presente contrato y demás documentos, serán firmados en forma electrónica entre las partes, y se aplica las disposiciones de la Ley 6822/21 “De los servicios de confianza para las transacciones electrónicas, del documento electrónico y los documentos transmisibles electrónicos”.</li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;">Previa lectura de su contenido, y en prueba de conformidad y aceptación, suscriben las partes en dos ejemplares de un mismo tenor y a un solo efecto, en la Ciudad de Asunción,<b style="color: #000;">a los 24 días del mes Diciembre año 2023.</b></li>
                            <li style="font-size: 16px;font-weight:500;line-height:26px;color:#939393;"></li>
                        </ul>
                    </td>
                </tr>
            </table>
            {{-- two box:st --}}
            <div class="contract_twobox_wrap">
                <div class="row">
                    <div class="col-md-6">
                        <div class="left">
                            <ul style="padding: 0">
                                <li class="text-16-medium">Julio Ramirez<span>(123456789)</span></li>
                                <li class="text-16-medium">Julio Ramirez<span>(123456789)</span></li>
                                <li><a href="javascript:;" class="text-16-medium">Sarah Santacruz <span>(123456789)</span></a></li>
                                <li class="text-14-semibold">EL CEDENTE</li>
                            </ul>
                        </div>
                    </div>   
                    <div class="col-md-6">
                        <div class="right">
                            <ul style="padding: 0">
                                <li class="text-16-medium">Andrea L. Peralta <span>(123456789)</span></li>
                                <li class="text-16-medium">Ernesto Gonzalez <span>(123456789)</span></li>
                                <li><a href="javascript:;" class="text-16-medium">Retail S.A.. <span>(123456789)</span></a></li>
                                <li class="text-14-semibold">EL CEDENTE</li>
                            </ul>
                        </div>
                    </div>     
                </div>
            </div>
            {{-- two box:nd --}}
            {{-- attention:st --}}
						<div class="contra_atencion_sec">
							<div class="head">
								<i><img src="{{ asset('images/mipo/cr-op-img9.svg')}}" alt="no-image"></i>
								<h6 class="text-16-semibold">{!! __('Atención') !!}</h6>
							</div>
							<p class="text-16-medium">{!! __('Se debe enviar una OTP (contraseña de un solo uso) a la dirección de correo electrónico de cada firmante para su verificación. A continuación, ingrese la OTP recibida por cada firmante y verifique para completar el proceso de verificación antes de enviar.') !!}</p>
						</div>
			{{-- attention:nd --}}

            <div class="otpverify_box_wrap">
                <div class="row">
                        <div class="col-md-6">
                            <div class="lft">
                                <div class="profile_inputbox">
                                    <label for="name" class="text-14-medium">Martin Blumenfeld</label>
                                    <input type="text" class="text-14-medium" name="deal_otp" placeholder="Ingrese OTP Verificar">
                                </div>
                                <div class="confirm_otpbox">
                                    <button type="button" class="text-16-medium">Verificar OTP</button>
                                    <a href="javacript:;"><span class="text-16-medium">Reenviar OTP</span></a>
                                </div>
                            </div>
                        </div>
                    
                    <div class="col-md-6">
                        <div class="right">
                            <div class="profile_inputbox">
                                <label for="name" class="text-14-medium">Martin Blumenfeld</label>
                                <input type="text" class="text-14-medium" id="name" name="name" placeholder="Ingrese OTP Verificar">
                            </div>
                            <div class="confirm_otpbox">
                                <button type="button" class="text-16-medium">Verificar OTP</button>
                                <a href="javacript:;"><span class="text-16-medium">Reenviar OTP</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="check_privacy" style="display:flex;">
                <input type="checkbox">
                <p style="color:#707070;margin:0 0 0 8px;">Al continuar, reconozco haber leído <a href="javascript:"style="color:#0D6EFD">Bases y Condiciones</a> y <a href="javascript:"style="color:#0D6EFD;">Politicas de Privacidad.</a></p>
            </div>
            <div class="btnbox">
                <a href="javascript:;">Enviar</a>
            </div>
        </div>
        
    </div>
</div>


@section('custom_script')
<script>
  
</script>
@endsection
</x-app-layout>
