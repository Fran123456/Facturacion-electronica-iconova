<?php

namespace App\Http\Controllers;

use App\Help\DteCodeValidator;
use App\Help\DTEIdentificacion\Identificacion;
use App\Help\DTEIdentificacion\Receptor;
use App\help\Help;
use App\Help\LoginMH;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DteDclController extends Controller
{
    public function unitario(Request $request){

        // Login para generar token de Hacienda.
        $responseLogin = LoginMH::login();
        if ($responseLogin['code'] != 200) {
            return response()->json(DteCodeValidator::code404($responseLogin['error']), 404);
        }

        $json = $request->json()->all();

        if (!$json) {
            return response()->json(["error" => "DTE no válido o nulo"], Response::HTTP_BAD_REQUEST);
        }

        // VARAIBLES DE CONFIGURACION DEL DTE
        $dte = $json['dteJson'];
        $cliente = Help::getClienteId($dte['receptor']['nit']);
        $tipoDTE = '03';
        $idCliente = $cliente['id'];

        // VARIABLES DE RESPUESTA DEL SERVICIO
        $responseData = '';
        $statusCode = '';

        // Variables de Identificación
        // $identificacion = Identificacion::identidad($tipoDTE, 3);
        $contingencia = isset($json['contingencia']) ? $json['contingencia'] : null;
        $identificacion = Identificacion::identidad($tipoDTE, 3, $contingencia);

        // Variables de Emisor y Receptor
        $emisor = $dte['emisor'] ?? Identificacion::emisor('03', '20', null);
            // $receptor = Identificacion::receptorCCF($dte['receptor']);
        // [$faltan, $receptor] = Receptor::generar($dte['receptor'], $tipoDTE);
        [$faltan, $receptor] = Receptor::generar($dte['receptor'], $tipoDTE);

        if ( $faltan )
            return response()->json($receptor, 404);


        // return response()->json([
        //     "identificacion" => $identificacion,
        //     "emisor" => $emisor,
        //     "receptor" => $receptor,
        //     "contingencia" => $contingencia
        // ], 200);

    }
}
