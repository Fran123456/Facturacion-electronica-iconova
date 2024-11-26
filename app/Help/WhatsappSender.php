<?php

namespace App\Help;

use Illuminate\Support\Facades\Http;

class WhatsappSender
{
    public static function send()
    {
        $token = 'EAALK3ZAAx1JMBOZBpYCyfX3LsDEZCmSl4RolfS69bB3RqdbHH4EPkjQjqeq48QDOAoeKsTkZBPhYxpj6MqQrz0Hj0oUuhtEWu3GQL7owkla0ahqHd9gK0wjKA427mknp99wH7nGo3FZBbLTVetXskMTmffNdAGmUGNXCAz9DAjPESBwnO9mJ3w5vBsa7Jc6N10Hz5DHEBKU6wmMYjYGMZAfTQg8vXslICHPiIZD';
        $numeroDestino = 'whatsapp:+50370234903';
        $mensaje = 'Hola enviado desde laravel. ';

// Configurar los datos del mensaje
        $datosMensaje = [
            'messaging_product'=>'whatsapp',
            'to' => $numeroDestino,
            'message' => [
                'text' => $mensaje,
            ],
        ];

// Realizar la solicitud POST a la API de WhatsApp Business de Facebook
        $response = Http::withToken($token)->post("https://graph.facebook.com/v18.0/251363918066309/messages", $datosMensaje);

// Verificar si la solicitud fue exitosa y retornar la respuesta
        return$response;

    }

}
