@include('emails.header')
    <p style="margin-top:2%">
        Hola {{ $name ?? ''}},
    </p>
    <p style="margin-top:2%">
        Le informamos que ha recibido una contra oferta de uno de nuestros inversores. Por favor, revise su panel de operaciones para ver los detalles de la oferta.
    </p>
    <p style="margin-top:2%">
        Le recomendamos que revise su panel de ofertas en MIPO para ver los detalles de la contraoferta y tomar una decisión sobre cómo proceder.
    </p>
    <p style="margin-top:2%; text-align: center; margin: 0 auto">
        <a style="background-color: #0D6EFD;color: #ffff; padding: 9px 18px;border-radius: 4px;font-size: 16px;font-weight: 500;text-decoration: none" href="{{ route('operations.index') }}">
            Ir a Panel de Ofertas Recibidas &gt;
        </a>
    </p>
    <p style="margin-top:2%">
        Recuerde que tiene la opción de aceptar, rechazar o contra ofertar. Si tiene alguna duda o necesita más información, no dude en ponerse en contacto con nosotros.
    </p>
@include('emails.footer')