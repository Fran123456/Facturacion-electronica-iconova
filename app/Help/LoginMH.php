<?php

namespace App\Help;
use App\Models\Config;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Empresa;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

use App\Help\Help;
use App\Help\DteCodeValidator;
use App\Http\Controllers\ServicesController;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
class LoginMH {

    public static function login(){
        $usuario = Auth::user();
        $empresa  =  Empresa::find($usuario->empresa_id);

        if ($usuario->empresa_id == null)
            return array(["error" => "El usuario no posee empresa",'code'=>Response::HTTP_NOT_FOUND])[0];

        $empresa  =  Empresa::find($usuario->empresa_id);
        if ($empresa == null)
            return array(["error" => "La empresa no existe",'code'=>Response::HTTP_NOT_FOUND])[0];

        if ($empresa->estado == false)
            return array(["error" => "La empresa existe pero se encuentra desactivada",'code'=>Response::HTTP_NOT_FOUND])[0];

        $url = Help::mhUrl();
        
        $nit = Crypt::decryptString($empresa->nit);
        $pwd = Crypt::decryptString($empresa->credenciales_api);

        $jsonRequest = [
            "user" => $nit,
            "pwd" => $pwd,
        ];
        

        try {
            $requestResponse = Http::timeout(160)
            ->connectTimeout(10)
            ->withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'User-Agent' => 'ApiLaravel/1.0',
                "Accept" => "application/json"

            ])->asForm()->post($url . "seguridad/auth", $jsonRequest);
        } catch (Exception $e) {
            return array(["error" => "No se pudo conectar con la  API de Ministerio hacienda",'code'=>500])[0];
        }
        

        $responseData = $requestResponse->json();
        $statusCode = $requestResponse->status();
        $empresa->token_mh = $responseData['body']['token'];
        $empresa->save();
        return array(["error" => "login correcto",'code'=>200])[0];
    }
}

