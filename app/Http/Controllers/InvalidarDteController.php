<?php

namespace App\Http\Controllers;

use App\Help\DTEIdentificacion\Invalidacion;
use App\Help\Services\InvalidarDte;
use Illuminate\Http\Request;


class InvalidarDteController extends Controller
{
    public function invalidar(Request $request){

        $dteRequest = $request->json()->all();

        $identificacion = Invalidacion::identificacion();
        $emisor = Invalidacion::emisor();

        $documento = $dteRequest['documento'];
        $motivo = $dteRequest['motivo'];

        $documento['codigoGeneracionR'] = $identificacion['codigoGeneracion'];

        $dte = compact("identificacion", "emisor");

        [$responseData, $statusCode] =  InvalidarDte::invalidar($dte);

        return response()->json([
            'data' => $responseData,
            'statusCode' => $statusCode
        ]);

    }
}
