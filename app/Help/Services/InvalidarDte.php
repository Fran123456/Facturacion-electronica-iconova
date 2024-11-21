<?php

namespace App\Help\Services;

use App\Help\FirmadorElectronico;
use App\help\Help;
use Illuminate\Support\Facades\Http;

class InvalidarDte
{


    public static function invalidar($dte)
    {
        $empresa = Help::getEmpresa();
        $url = Help::mhUrl();

        $DTESigned = FirmadorElectronico::firmador($dte);

        $ambiente = "00";
        $idEnvio = 1;
        $version = 2;
        $documento = $DTESigned['msg']; 

        $jsonRequest = compact("ambiente", "idEnvio", "version", "documento");


        $requestResponse = Http::withHeaders([
            'Authorization' => $empresa->token_mh,
            'User-Agent' => 'ApiLaravel/1.0',
            'Content-Type' => 'application/JSON'
        ])->post($url . "fesv/anulardte", $jsonRequest);

        $responseData = $requestResponse->json();
        $statusCode = $requestResponse->status();

        // return [$jsonRequest, 200];

        return [$responseData, $statusCode];
    }
}
