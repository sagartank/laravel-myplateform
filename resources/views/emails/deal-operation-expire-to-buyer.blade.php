@include('emails.header')
    <p style="margin-top:2%">
        Hola {{ $name ?? ''}},
    </p>
    <p style="margin-top:2%">
        Le recordamos que hoy vence un documento comprado por su parte en MIPO. Para evitar demoras en la cobranza, es importante que se comunique con la parte pagadora para asegurarse de que el pago se realice en tiempo y forma.
    </p>
    <p style="margin-top:2%">
        Recuerde que en MIPO nos preocupamos por garantizar el éxito de sus inversiones, por lo que le recomendamos que mantenga un seguimiento constante a todas sus operaciones.
    </p>
    <p style="margin-top:2%">
        Si tiene alguna duda o necesita ayuda para realizar alguna gestión, no dude en contactarnos. 
    </p>
    <p style="margin-top:2%">
        Estamos aquí para ayudarlo.
    </p>
@include('emails.footer')