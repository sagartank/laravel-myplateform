@include('emails.header')
    <p style="margin-top:2%">
        Hola {{ $name ?? ''}},
    </p>
    <p style="margin-top:2%">
        Le informamos que su oferta en MIPO ha sido recibida y ha sido presentada una contraoferta por parte del vendedor correspondiente. En este momento, el vendedor se encuentra a la espera de su respuesta.
    </p>
    <p style="margin-top:2%">
        Le recomendamos que revise su panel de ofertas en MIPO para ver los detalles de la contraoferta y tomar una decisión sobre cómo proceder.
    </p>
    <p style="margin-top:2%; text-align: center; margin: 0 auto">
        <a style="background-color: #0D6EFD;color: #ffff; padding: 9px 18px;border-radius: 4px;font-size: 16px;font-weight: 500;text-decoration: none" href="{{ route('offered-operations.index') }}">
            Ir a Panel de Ofertas Enviadas &gt;
        </a>
    </p>
    <p style="margin-top:2%">
        Gracias por confiar en MIPO para sus inversiones. Si tiene alguna pregunta o necesita ayuda, no dude en ponerse en contacto con nuestro equipo de soporte.
    </p>
@include('emails.footer')