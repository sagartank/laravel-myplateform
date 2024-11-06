@include('emails.header')
    <p style="margin-top:2%">
        Hola {{ $name ?? ''}},
    </p>
    <p style="margin-top:2%">
        Es un placer informarte que tu oferta en MIPO ha sido aprobada por el vendedor. ¡Felicitaciones por tu inversión exitosa en nuestra plataforma! Por favor haz click en el siguiente enlace para leer y firmar contrato de forma digital.
    </p>
    <p style="margin-top:2%; text-align: center; margin: 0 auto">
        <a style="background-color: #0D6EFD;color: #ffff; padding: 9px 18px;border-radius: 4px;font-size: 16px;font-weight: 500;text-decoration: none" href="{{ $buyer_link ?? route('deals.index') }}">
            Firmar Contrato &gt;
        </a>
    </p>
    <p style="margin-top:2%">
        Recuerda que en MIPO estamos comprometidos en brindar una experiencia confiable y transparente en tus inversiones. No dudes en contactarnos si tienes alguna pregunta o necesitas ayuda con cualquier asunto relacionado con tus inversiones.
    </p>
    <p style="margin-top:2%">
        ¡Gracias por confiar en MIPO!
    </p>
@include('emails.footer')