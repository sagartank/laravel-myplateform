@include('emails.header')
    <p style="margin-top:2%">
        Hola {{ $name ?? ''}},
    </p>
    <p style="margin-top:2%">
        Nos complace informarle que ya se puede proceder con el pago al vendedor.
    </p>
    <p style="margin-top:2%; text-align: center; margin: 0 auto">
        <a style="background-color: #0D6EFD;color: #ffff; padding: 9px 18px;border-radius: 4px;font-size: 16px;font-weight: 500;text-decoration: none" href="{{ $seller_link ?? route('deals.index') }}">
            Ir a Panel de Operaciones Concretada &gt;
        </a>
    </p>
    <p style="margin-top:2%">
        Una vez que haya realizado el pago, por favor notifíquenos para que podamos continuar con el proceso y efectuar la transferencia al vendedor. Si tiene alguna pregunta o necesita ayuda en el proceso, no dude en ponerse en contacto con nosotros.
    </p>
    <p style="margin-top:2%">
        Gracias por confiar en MIPO para sus inversiones de factoraje.
    </p>
@include('emails.footer')