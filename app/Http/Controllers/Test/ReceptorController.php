<?php

namespace App\Http\Controllers;

use App\Help\DTEIdentificacion\Receptor;
use Illuminate\Http\Request;

class ReceptorController extends Controller
{
    public function receptor(Request $request){

        $receptor = json_decode($request->getContent(), true);

        [$faltan, $faltantes] = Receptor::generar($receptor, '05');

        $codigo = 200;

        if ( !$faltan )
            $codigo = 400;

        $respuesta = $faltantes ? $faltantes : [ "msg" => "ok",];

        return response()->json($respuesta, $codigo);

    }
}
