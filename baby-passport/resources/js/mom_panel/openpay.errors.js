var errors = [
    {
        code: 1000,
        description: "Ocurrió un error interno en el servidor de Openpay"
    },
    {
        code: 1001,
        description:
            "El formato de la petición no es JSON, los campos no tienen el formato correcto, o la petición no tiene campos que son requeridos."
    },
    {
        code: 1002,
        description:
            "La llamada no esta autenticada o la autenticación es incorrecta."
    },
    {
        code: 1003,
        description:
            "La operación no se pudo completar por que el valor de uno o más de los parametros no es correcto."
    },
    {
        code: 1004,
        description:
            "Un servicio necesario para el procesamiento de la transacción no se encuentra disponible."
    },
    {
        code: 1005,
        description: "Uno de los recursos requeridos no existe."
    },
    {
        code: 1006,
        description: "Ya existe una transacción con el mismo ID de orden."
    },
    {
        code: 1007,
        description:
            "La transferencia de fondos entre una cuenta de banco o tarjeta y la cuenta de Openpay no fue aceptada."
    },
    {
        code: 1008,
        description:
            "Una de las cuentas requeridas en la petición se encuentra desactivada."
    },
    {
        code: 1009,
        description: "El cuerpo de la petición es demasiado grande."
    },
    {
        code: 1010,
        description:
            "Se esta utilizando la llave pública para hacer una llamada que requiere la llave privada, o bien, se esta usando la llave privada desde JavaScript."
    },
    {
        code: 1011,
        description: "Se solicita un recurso que esta marcado como eliminado."
    },
    {
        code: 1012,
        description: "El monto transacción esta fuera de los limites permitidos."
    },
    {
        code: 1013,
        description: "La operación no esta permitida para el recurso."
    },
    {
        code: 1014,
        description: "La cuenta esta inactiva."
    },
    {
        code: 1015,
        description:
            "No se ha obtenido respuesta de la solicitud realizada al servicio."
    },
    {
        code: 1016,
        description: "El mail del comercio ya ha sido procesada."
    },
    {
        code: 1017,
        description: "El gateway no se encuentra disponible en ese momento."
    },
    {
        code: 1018,
        description: "	El número de intentos de cargo es mayor al permitido."
    },
    {
        code: 1020,
        description: "El número de dígitos decimales es inválido para esta moneda"
    },
    {
        code: 2001,
        description:
            "La cuenta de banco con esta CLABE ya se encuentra registrada en el cliente."
    },
    {
        code: 2002,
        description:
            "La tarjeta con este número ya se encuentra registrada en el cliente."
    },
    {
        code: 2003,
        description:
            "El cliente con este identificador externo (External ID) ya existe."
    },
    {
        code: 2004,
        description:
            "El dígito verificador del número de tarjeta es inválido de acuerdo al algoritmo Luhn."
    },
    {
        code: 2005,
        description:
            "La fecha de expiración de la tarjeta es anterior a la fecha actual."
    },
    {
        code: 2006,
        description:
            "El código de seguridad de la tarjeta (CVV2) no fue proporcionado."
    },
    {
        code: 2007,
        description:
            "El número de tarjeta es de prueba, solamente puede usarse en Sandbox."
    },
    {
        code: 2008,
        description: "La tarjeta no es valida para puntos Santander."
    },
    {
        code: 2009,
        description: "El código de seguridad de la tarjeta (CVV2) es inválido."
    },
    {
        code: 2010,
        description: "Autenticación 3D Secure fallida."
    },
    {
        code: 2011,
        description: "Tipo de tarjeta no soportada"
    },
    {
        code: 3001,
        description: "La tarjeta fue declinada."
    },
    {
        code: 3002,
        description: "La tarjeta ha expirado."
    },
    {
        code: 3003,
        description: "La tarjeta no tiene fondos suficientes."
    },
    {
        code: 3004,
        description: "La tarjeta ha sido identificada como una tarjeta robada."
    },
    {
        code: 3005,
        description: "La tarjeta ha sido rechazada por el sistema antifraudes."
    },
    {
        code: 3006,
        description:
            "La operación no esta permitida para este cliente o esta transacción."
    },
    {
        code: 3007,
        description: "Deprecado. La tarjeta fue declinada."
    },
    {
        code: 3008,
        description: "La tarjeta no es soportada en transacciones en línea."
    },
    {
        code: 3009,
        description: "La tarjeta fue reportada como perdida."
    },
    {
        code: 3010,
        description: "El banco ha restringido la tarjeta."
    },
    {
        code: 3011,
        description:
            "El banco ha solicitado que la tarjeta sea retenida. Contacte al banco."
    },
    {
        code: 3012,
        description:
            "Se requiere solicitar al banco autorización para realizar este pago."
    },
    {
        code: 4001,
        description: "La cuenta de Openpay no tiene fondos suficientes."
    },
    {
        code: 4002,
        description:
            "La operación no puede ser completada hasta que sean pagadas las comisiones pendientes."
    },
    {
        code: 5001,
        description:
            "La orden con este identificador externo (external_order_id) ya existe."
    },
    {
        code: 6001,
        description:
            "La orden con este identificador externo (external_order_id) ya existe."
    },
    {
        code: 6002,
        description: "No se ha podido conectar con el servicio de webhook."
    },
    {
        code: 6003,
        description: "El servicio respondio con errores."
    }
];

$.getSpanishError = function ($code) {
    var spanishError = errors.find(function (error) {
        return error.code === $code;
    });

    return spanishError.description;
}

