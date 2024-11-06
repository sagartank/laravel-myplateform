@include('emails.header')
    <p style="margin-top:2%">
        Hola {{ $name ?? ''}},
    </p>
    <p style="margin-top:2%">
        Le informamos que la operación de factoraje que realizó a través de nuestra plataforma ha sido aprobada y se encuentra pendiente de verificación para el correspondiente pago del inversor.
    </p>
    <p style="margin-top:2%">
        Para continuar con el proceso de pago, es necesario que nos envíe los documentos físicos originales de la factura o documentos a través de un servicio de mensajería a nuestras oficinas o solicitar servicio de retiro de documento.
    </p>
    <p style="margin-top:2%">
        Una vez recibidos los documentos físicos originales, procederemos con la verificación y autorización de pago al inversor. 
    </p>
    <p style="margin-top:2%; text-align: center; margin: 0 auto">
        <a style="background-color: #0D6EFD;color: #ffff; padding: 9px 18px;border-radius: 4px;font-size: 16px;font-weight: 500;text-decoration: none" 
        href="https://tawk.to/chat/646352fe74285f0ec46bb89b/1h0hvocm4" target="_blank">
            Contactar con MIPO &gt;
        </a>
    </p>
    <p style="margin-top:2%">
        Le recordamos que este proceso puede tardar unos días hábiles, por lo que le agradecemos su paciencia y colaboración.
    </p>
    <p style="margin-top:2%">
        Cualquier duda o consulta, no dude en ponerse en contacto con nosotros.
    </p>
@include('emails.footer')