@include('emails.header')
    <p style="margin-top:2%">
        Hola {{ $name ?? ''}},
    </p>
    <p style="margin-top:2%">
        ¡Buenas noticias! 
    </p>
    <p style="margin-top:2%">
        Queremos informarle que su operación en MIPO ha sido concretada exitosamente.
    </p>
    <p style="margin-top:2%">
        Le pedimos que revise su panel de operaciones en MIPO para conocer los próximos pasos a seguir. Además, le pedimos que haga clic en el botón "Firmar Contrato" para firmar digitalmente el acuerdo de factoraje. Recuerde que este proceso es necesario para finalizar la operación y recibir el pago.
    </p>
    <p style="margin-top:2%; text-align: center; margin: 0 auto">
        <a style="background-color: #0D6EFD;color: #ffff; padding: 9px 18px;border-radius: 4px;font-size: 16px;font-weight: 500;text-decoration: none" href="{{ $seller_link ?? route('deals.index') }}">
            Firmar Contrato &gt;
        </a>
    </p>
    <p style="margin-top:2%">
        Gracias por elegir MIPO como su plataforma de factoraje. Esperamos poder seguir ayudándole en el futuro.
    </p>
    <p style="margin-top:2%">
        ¡Gracias por confiar en MIPO!
    </p>
   
@include('emails.footer')