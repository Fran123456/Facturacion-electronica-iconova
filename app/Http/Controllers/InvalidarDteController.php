<?php

namespace App\Http\Controllers;

use App\Help\DteCodeValidator;
use App\Help\DTEIdentificacion\Invalidacion;
use App\Help\LoginMH;
use App\Help\Services\InvalidarDte;
use App\Http\Requests\InvalidarRequest;
use Illuminate\Http\Request;


class InvalidarDteController extends Controller
{
    public function invalidar(InvalidarRequest $request){

        $responseLogin = LoginMH::login();
        if ($responseLogin['code'] != 200) {
            return response()->json(DteCodeValidator::code404($responseLogin['error']), 404);
        }

        $dteRequest = $request->json()->all();

        $identificacion = Invalidacion::identificacion();
        $emisor = Invalidacion::emisor();

        $documento = $dteRequest['documento'];
        $motivo = $dteRequest['motivo'];

        $documento['codigoGeneracionR'] = null;

        $dte = compact("identificacion", "emisor", "documento", "motivo");

        [$responseData, $statusCode] =  InvalidarDte::invalidar($dte);

        return response()->json([
            'data' => $responseData,
            'statusCode' => $statusCode
        ], $statusCode);
    }
}
