<?php

namespace App\Help\Services;

use App\help\Help;
use Illuminate\Support\Facades\Http;

class ConsultaDte
{

    public static function consultar($nitEmisor = null, $tdte = null, $codigoGeneracion = null)
    {

        $empresa = Help::getEmpresa();
        $url = Help::mhUrl();

        $jsonRequest = compact('nitEmisor', 'tdte', 'codigoGeneracion');

        $requestResponse = Http::withHeaders([
            'Authorization' => $empresa->token_mh,
            'User-Agent' => 'ApiLaravel/1.0',
            'Content-Type' => 'application/JSON'
        ])->post($url . "fesv/recepcion/consultadte/", $jsonRequest);

        $responseData = $requestResponse->json();
        $statusCode = $requestResponse->status();

        return [$responseData, $statusCode];
    }
}
