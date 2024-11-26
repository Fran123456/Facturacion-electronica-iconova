<?php

namespace App\Http\Controllers;

use App\Help\Services\ConsultaDte;
use App\Http\Requests\ConsultaDteRequest;
use Illuminate\Http\Request;

class ConsultasMHController extends Controller
{
    public function consultaDte(ConsultaDteRequest $request){

        $data = $request->json()->all();

        //^ Se realiza la consulta a la API de MH a través del servicio ConsultaDte
        [$responseData, $statusCode] =  ConsultaDte::consultar(
            $data['nitEmisor'],
            $data['tdte'],
            $data['codigoGeneracion']
        );

        return response()->json([
            'data' => $responseData,
            'statusCode' => $statusCode
        ]);
    }
}
