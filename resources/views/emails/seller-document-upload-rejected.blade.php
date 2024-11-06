@include('emails.header')
    <p style="margin-top:2%">
        Hola {{ $name ?? ''}},
    </p>
    <p style="margin-top:2%">
        ¡La operación <strong>{{ $operation_number }}</strong> ha sido rechazada! 
    </p>
    <p style="margin-top:2%">
        El motivo de rechazo de un documento puede depender de varios factores, entre ellos puede ser:
    </p>
    <p>
        <ul>
            <li>Imagen Poco Clara</li>
            <li>Enmienda en documento</li>
            <li>Proveedor Posee o puede poseer muchas solicitudes de nota de crédito</li>
            <li>Usuario tiene problemas internos en la cuenta</li>
            <li>Otros</li>
        </ul>  
    </p>
    <p>
        Le recomendamos que ingrese a sus operaciones para verificar que el documento se encuentre en perfectas condiciones y vuelva a enviar para su verificación.
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