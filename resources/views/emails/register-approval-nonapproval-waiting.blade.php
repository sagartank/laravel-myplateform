@include('emails.header')
    <p style="margin-top:2%">
        Hola {{ $name ?? ''}},
    </p>
    <p style="margin-top:2%">
        ¡Bienvenido/a a MIPO! Nos complace que hayas decidido unirte a nosotros y formar parte de nuestra comunidad de usuarios. Como nuevo/a miembro, tendrás acceso a una serie de beneficios y funciones que te ayudarán a comprar y vender documentos de manera eficiente y segura.</p>
    </p>
    <p style="margin-top:2%">
        Nuestro objetivo es proporcionar una plataforma confiable y transparente para que puedas realizar transacciones de forma rápida, segura y sin preocupaciones. Por eso, tenemos un proceso de aprobación que puede tomar hasta 48 hrs hábiles para verificar datos cargados y asegurarnos de la veracidad de los datos.
    </p>
    <p style="margin-top:2%">
        No dudes en ponerte en contacto con nosotros si necesitas ayuda en cualquier momento. Estamos aquí para ayudarte y garantizar que tengas la mejor experiencia posible en nuestra plataforma.
    </p>
    <p style="margin-top:2%">
        Gracias por unirte a MIPO y esperamos que disfrutes de la plataforma
    </p>
@include('emails.footer')