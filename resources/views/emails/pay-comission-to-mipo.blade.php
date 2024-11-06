@include('emails.header')
    <p style="margin-top:2%">
        Hola {{ $name ?? ''}},
    </p>
    <p style="margin-top:2%">
      ¡Felicidades! Los pasos anteriores han sido aprobados y ahora puede continuar con la operación. 
    </p>
    <p style="margin-top:2%">
        Para proceder con la misma, necesitamos que abone la comisión a MIPO. Para hacerlo, puede utilizar cualquiera de nuestras formas de pago disponibles en nuestra plataforma. Una vez que se haya realizado el pago, le brindaremos los datos para poder transferir al vendedor el monto ofertado.
    </p>
    <p style="margin-top:2%">
        Por favor, verifique su panel de inversiones para obtener más detalles sobre la operación y las opciones de pago disponibles. 
    </p>
    <p style="margin-top:2%; text-align: center; margin: 0 auto">
        <a style="background-color: #0D6EFD;color: #ffff; padding: 9px 18px;border-radius: 4px;font-size: 16px;font-weight: 500;text-decoration: none" href="{{ $buyer_link ?? route('deals.index') }}">
           Ir a Panel de Operaciones Concretadas &gt;
        </a>
    </p>
    <p style="margin-top:2%">
       Si tiene alguna pregunta o necesita asistencia, no dude en ponerse en contacto con nuestro equipo de soporte al cliente.
    </p>
     <p style="margin-top:2%">
        Gracias por elegir MIPO para sus inversiones.
     </p>
@include('emails.footer')