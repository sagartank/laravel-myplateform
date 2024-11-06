@include('emails.header')
    <p style="margin-top:2%">
        Hola {{ $name ?? ''}},
    </p>
    <p style="margin-top:2%">
        Felicitaciones por haber completado la cobranza de su último documento en MIPO! 
    </p>
    <p style="margin-top:2%">
        Esperamos que haya sido una experiencia satisfactoria para usted.
    </p>
    <p style="margin-top:2%">
        Nos gustaría agradecerle por confiar en nosotros como su plataforma de factoraje y también solicitarle un pequeño favor. Sabemos lo importante que es la retroalimentación de los usuarios para mejorar nuestra plataforma y hacerla aún mejor.
    </p>
    <p style="margin-top:2%">
        Por lo tanto, si disfrutó de su experiencia trabajando con el vendedor y la empresa pagadora, le agradeceríamos si pudiera tomarse unos minutos para dejar una reseña en nuestro sitio web. Esto ayudará a otros inversores a tomar una decisión informada y también será útil para el vendedor y la empresa pagadora en futuras operaciones.
    </p>
    <p style="margin-top:2%; text-align: center; margin: 0 auto">
        <a style="background-color: #0D6EFD;color: #ffff; padding: 9px 18px;border-radius: 4px;font-size: 16px;font-weight: 500;text-decoration: none" href="{{ $buyer_link ?? route('deals.index') }}">
            Dejar Reseña &gt;
        </a>
    </p>
    <p style="margin-top:2%">
        Si tiene alguna pregunta o necesita ayuda con su cuenta, no dude en ponerse en contacto con nuestro equipo de soporte.
    </p>
    <p style="margin-top:2%">
        ¡Gracias de nuevo por usar MIPO y esperamos seguir trabajando con usted en el futuro!
    </p>
@include('emails.footer')