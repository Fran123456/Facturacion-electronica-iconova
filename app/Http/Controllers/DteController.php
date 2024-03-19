<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use App\Models\Config;
use App\Help\Help;
use App\Help\DteCodeValidator;
use App\help\FirmadorElectronico;
use App\Help\LoginMH;
use Monolog\Handler\FirePHPHandler;

class DteController extends Controller
{


    public function enviarDteUnitarioCCF(Request $request)
    {
        //login para generar token de hacienda.
        $responseLogin = LoginMH::login();

        if ($responseLogin['code'] != 200)
            return response()->json(DteCodeValidator::code404($responseLogin['error']), 404);

        // $body = json_decode($request->getContent(), true);
        // $dteJson = $body['documento'];
        $empresa = Help::getEmpresa();
        $url = Help::mhUrl();
        $dteJson = $request->documento;


        if ($dteJson == null)
            return response()->json(["error" => "DTE no valido o nulo"], Response::HTTP_BAD_REQUEST);

        $dteFirmado = FirmadorElectronico::firmador($dteJson);

        if ( $dteFirmado["status"] > 201 )
            return response()->json($dteFirmado, $dteFirmado["status"]);


        $jsonRequest = [
            'Content-Type' => 'application/JSON',
            'ambiente' => 00,
            'idEnvio' => 1,
            'version' => 3,
            'tipoDte' => "03",
            "documento" => $dteFirmado["msg"],
            "codigoGeneracion" => "2",
        ];

        $requestResponse = Http::withHeaders([
            'Authorization' => $empresa->token_mh,
            'User-Agent' => 'ApiLaravel/1.0',
            // 'Accept' => 'application/json',
        ])->post($url . "fesv/recepciondte", $jsonRequest);

        $responseData = $requestResponse->json();
        $statusCode = $requestResponse->status();

        //415 Unsupported Media Type
        if ($statusCode == 415) return response()->json(DteCodeValidator::code415($responseData), 415);
        // 401 Unauthorized de parte de login hacienda.
        if ($statusCode == 401) return response()->json(DteCodeValidator::code401(), 401);

        return response()->json($responseData, $statusCode);

    }
}
