@include('emails.header')
    <p style="margin-top:2%">
        Hola {{ $name ?? ''}},
    </p>
    <p style="margin-top:2%">
        ¡Felicitaciones se ha aprobado la operación <strong>{{ $operation_number }}</strong>! 
    </p>
    <p style="margin-top:2%">
        En caso de modificaciones o intención de sacar del mercado de operaciones, es importante de que ingrese a MIS OPERACIONES y realice la reversión de la misma.
    </p>
    <p style="margin-top:2%">
        Desde ese panel verifique las ofertas recibidas para lograr efectivizar lo mas rápido posible.
    </p>
    <p style="margin-top:2%; text-align: center; margin: 0 auto">
        <a style="background-color: #0D6EFD;color: #ffff; padding: 9px 18px;border-radius: 4px;font-size: 16px;font-weight: 500;text-decoration: none" href="{{ $operation_detail_link ?? route('operations.index') }}">
            Ir a Mis Operaciones &gt;
        </a>
    </p>
    <p style="margin-top:2%">
        Si tiene alguna pregunta o necesita ayuda con su cuenta, no dude en ponerse en contacto con nuestro equipo de soporte.
    </p>
    <p style="margin-top:2%">
        ¡Gracias de nuevo por usar MIPO y esperamos seguir trabajando con usted en el futuro!
    </p>
@include('emails.footer')