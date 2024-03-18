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

class DteController extends Controller
{


    public function enviarDteUnitarioCCF(Request $request)
    {
        $body = json_decode($request->getContent(), true);
        $usuario = Auth::user();
        $empresa  =  Empresa::find($usuario->empresa_id);
        $url = Help::mhUrl();
        $nit = Crypt::decryptString($empresa->nit);
        $dte = $body['documento'];

        $jsonRequest = [
            'Content-Type' => 'application/JSON',
            'ambiente' => env('APP_DEBUG') ? "00" : "01",
            'idEnvio' => 1,
            'version' => 3,
            'tipoDte' => "03",
            "documento" => $dte,
            "codigoGeneracion" => "2",
        ];

        $requestResponse = Http::withHeaders([
            'Authorization' =>$empresa->token_mh,
            'User-Agent' => 'ApiLaravel/1.0',
            // 'Accept' => 'application/json',
        ])->post($url . "fesv/recepciondte", $jsonRequest);

        $responseData = $requestResponse->json();
        $statusCode = $requestResponse->status();

        //415 Unsupported Media Type
        if($statusCode==415) return response()->json(DteCodeValidator::code415($responseData), 415);
        // 401 Unauthorized
        if($statusCode==401)  return response()->json(DteCodeValidator::code401(), 401);

        return response()->json($responseData, $statusCode);

    }


}
