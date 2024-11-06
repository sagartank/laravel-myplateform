<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>MIPO</title>

		<!--PDF Stylesheet by k-->
		<style>
			* {
				margin: 0px;
				padding: 0px;
				box-sizing: border-box;
			}
			body {
				font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
				font-size: 13px;
				color: #000;
				background: #fff;
				margin: 0px;
				padding: 0 25px 0 25px !important;
			}
			.pdf_wrap {
				width: 100%;
				position: relative;
				font-size: 13px;
				color: #000;
				background: #fff;
				margin: 72px 0 0 0;
			}	
			table + table{margin-top: 30px;}

			tr:last-child,
			li:last-child {border-bottom: none !important;}

			ol li {list-style: none;}
		</style>
		<!--PDF Stylesheet by k-->
	</head>
	<body>
		<div class="pdf_wrap">
			<table style="width:100%; margin-bottom: 16px; border-collapse: collapse;">
				<td style="text-align: center; padding: 0;">
					<img alt="no-image" src="data:image/png;base64,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"/>
				</td>
			</table>
			<h1 style="font-size: 16px; font-weight: 500; margin-bottom: 6px; text-align: center;">VERIFICACIÓN DE DIRECCIÓN OTP</h1>
			<h2 style="font-size: 14px; font-weight: 500; color: #6B6B6B; margin-bottom: 50px; text-align: center;">“DIRECCIÓN VERIFICADA”</h2>
			<table style="width: 100%; border-collapse: collapse;">
				<tr>
					<td style="padding: 0; text-align: center;">
						<img src="data:image/png;base64,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" alt="no-image" />
					</td>
					<td style="padding: 0; border: 1px solid #707070;">
						<table style="width: 100%; border-collapse: collapse;">
							<tr style="width: 100%;">
								<td>
									<p style="font-weight: 400; border-collapse: collapse; padding: 6px 12px 8px 12px; color: #000000; width: 100%;">CODIGO OTP:<span style="font-weight: 600; margin-left: 5px; color: #000000; width: 100%;">123456</span></p>
								</td>
							</tr>
							<tr style="width: 100%; border-collapse: collapse; border-bottom: 1px solid #707070; border-top: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">Usuario:</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">Juan Jose Gomez</td>
							</tr>
							<tr style="width: 100%; border-collapse: collapse; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">Dirección:</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">Procer Juan Manuel Iturbe 727</td>
							</tr>
							<tr style="width: 100%; border-collapse: collapse; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">Ciudad:</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">Asuncion</td>
							</tr>
							<tr style="width: 100%; border-collapse: collapse; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">Telefono:</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">+595 123 123 123</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table style="width: 100%; border-collapse: collapse;">
				<tr>
					<td style="padding: 0; border-collapse: collapse; border: 1px solid #707070;">
						<table style="width: 100%; border-collapse: collapse;">
							<tr style="width: 100%;">
								<td>
									<p style="font-weight: 600; border-collapse: collapse; padding: 6px 12px 8px 12px; color: #000000; width: 100%;">Identificación</p>
								</td>
							</tr>
							<tr style="width: 100%; border-collapse: collapse; border-bottom: 1px solid #707070; border-top: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">Fecha:</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">17th June 2023</td>
							</tr>
							<tr style="width: 100%; border-collapse: collapse; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">Nro de Documento:</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">4854364-0</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table style="width: 100%; border-collapse: collapse;">
				<tr>
					<td style="padding: 0; border-collapse: collapse; border: 1px solid #707070;">
						<table style="width: 100%; border-collapse: collapse;">
							<tr style="width: 100%;">
								<td>
									<p style="font-weight: 600; border-bottom: 1px solid #707070; padding: 6px 12px 8px 12px; color: #000000;">Pasos para Verificación</p>
								</td>
							</tr>
							<tr>
								<ol>
									<li style="font-weight: 500; border-collapse: collapse; border-bottom: 1px solid #707070; padding: 6px 12px 8px 12px; color: #000000;">1. Acceder mipo.com.py</li>
									<li style="font-weight: 500; border-collapse: collapse; border-bottom: 1px solid #707070; padding: 6px 12px 8px 12px; color: #000000;">2. Ingresar a Configuración de Cuenta arriba en la esquina derecha</li>
									<li style="font-weight: 500; border-collapse: collapse; border-bottom: 1px solid #707070; padding: 6px 12px 8px 12px; color: #000000;">3. Perfil>Datos Personales>Verificación de Dirección</li>
									<li style="font-weight: 500; border-collapse: collapse; border-bottom: 1px solid #707070; padding: 6px 12px 8px 12px; color: #000000;">4. Ingresar el Código OTP</li>
									<li style="font-weight: 500; border-collapse: collapse; border-bottom: 1px solid #707070; padding: 6px 12px 8px 12px; color: #000000;">5. Presionar VERIFICAR</li>
								</ol>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table style="width: 100%; text-align:center; padding:8px 0;">
				<tr>
				  	<td>
						<a href="javascript:;" style="text-decoration:none; text-transform:uppercase; display:block; color: #000000; font-weight: 500;">
							www.mipo.com.py
						</a>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>