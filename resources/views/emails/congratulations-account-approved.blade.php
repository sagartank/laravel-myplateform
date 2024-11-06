@include('emails.header')
    <p style="margin-top:2%">
        Hola {{ $name ?? ''}},
    </p>
    <p style="margin-top:2%">
        Nos complace informarte que tu cuenta ha sido aprobada y ya puedes acceder a todas las funcionalidades de nuestra página. Ahora estás listo/a para explorar todo lo que nuestra plataforma tiene para ofrecer y comenzar a comprar y vender documentos.
    </p>
    <p style="margin-top:2%">
        Te invitamos a que navegues por la misma y explores todas las herramientas y funciones disponibles para vos. Desde nuestra intuitiva interfaz de usuario hasta nuestras opciones de búsqueda avanzada, nuestra plataforma está diseñada para ayudarte a encontrar y comprar los documentos que necesitas de manera rápida y sencilla.
    </p>
    <p style="margin-top:2%">
        Primero, te recomendamos que revises nuestro FAQ. Allí encontrarás una lista de las preguntas más frecuentes que nuestros usuarios suelen tener. Si tienes alguna pregunta o problema, es probable que encuentres la respuesta en esta sección.
    </p>
    <p style="margin-top:2%; text-align: center; margin: 0 auto">
        <a  style="background-color: #0D6EFD;color: #ffff; padding: 9px 18px;border-radius: 4px;font-size: 16px;font-weight: 500;text-decoration: none" href="{{ route('faq') }}">Ir a Preguntas Frecuentes (F.A.Q.) &gt;</a>
    </p>
    <p style="margin-top:2%">
        También hemos creado una serie de tutoriales para ayudarte a comprar y vender documentos en nuestra plataforma. Puedes acceder a estos tutoriales en formato texto o videos en el siguiente enlace. Estos tutoriales te guiarán a través de cada paso del proceso y te darán consejos útiles para asegurarte de que puedas realizar tus operaciones de manera efectiva.
    </p>
    <p style="margin-top:2%; text-align: center; margin: 0 auto">
        <a style="background-color: #0D6EFD;color: #ffff; padding: 9px 18px;border-radius: 4px;font-size: 16px;font-weight: 500;text-decoration: none" href="{{ route('dashboard') }}">Ir a Tutoriales &gt;</a>
    </p>
    <p style="margin-top:2%">
        Además, queremos recordarte que nuestra plataforma cuenta con un sistema de niveles de cuenta (NOOBIE, BRONCE, PLATA, ORO y PLATINO) cada uno de los cuales ofrece beneficios adicionales a medida que acumulas operaciones. Puedes consultar los detalles de cada nivel de cuenta en nuestra sección de Términos y Condiciones.
    </p>
    <p style="margin-top:2%">
        Si tienes alguna pregunta o necesitas ayuda en cualquier momento, no dudes en ponerte en contacto con nosotros. Nuestro equipo de soporte estará encantado de ayudarte y asegurarse de que aproveches al máximo todas las funcionalidades de nuestra página.
    </p>
    <p style="margin-top:2%">
        Gracias por unirte a nosotros y esperamos que disfrutes de nuestra plataforma.
    </p>
@include('emails.footer')