<?php

namespace App\help;

use App\help\Help;
use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class FirmadorElectronico
{

    public static function firmador($token)
    {

        $usuario = Auth::user();
        if ($usuario->empresa_id == null)
            return ["error" => "El usuario no posee empresa", "status" => Response::HTTP_NOT_FOUND];


        $empresa  =  Empresa::find($usuario->empresa_id);
        if ($empresa == null)
            return ["error" => "La empresa no existe", "status" => Response::HTTP_NOT_FOUND];

        if ($empresa->estado == false)
            return ["error" => "La empresa existe pero se encuentra en estado inactivo", "status" =>  Response::HTTP_NOT_FOUND];


        $nit = Crypt::decryptString($empresa->nit);
        $passwordPrivate = Crypt::decryptString($empresa->private_key);

        if ($token == null)
            return ["error" => "Enviar un DTE valido por favor.", "status" =>  Response::HTTP_NOT_FOUND];

        $jsonDocumento = [
            "nit" => $nit,
            "activo" => true,
            "passwordPri" => $passwordPrivate,
            "dteJson" => $token
        ];

        $url = Help::urlFirmador() . "firmardocumento/";

        $response = Http::post($url, $jsonDocumento);


        $response = Http::post($url, $jsonDocumento);

        $statusCode = $response->status();
        $responseData = $response->json(); // Accede al contenido JSON

        $value = $responseData['body'];

        if (isset($value['mensaje'])) {
            return ["msg" => "No se pudo firmar el DTE solicitado", "error" => $value['mensaje'], "status" => Response::HTTP_BAD_REQUEST];
        }

        return ["msg" => $value, "error" => "", "status" => $statusCode];

    }
}
