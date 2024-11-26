<?php

namespace App\Http\Controllers;

use App\Help\DteCodeValidator;
use App\Help\DTEIdentificacion\Identificacion;
use App\Help\DTEIdentificacion\Receptor;
use App\Help\DTEIdentificacion\ReceptorCR;
use App\help\Help;
use App\Help\LoginMH;
use App\Help\Services\DteApiMHService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// ^ COMPROBANTE DE RETENCIÓN
class DteCrController extends Controller
{
    public function unitario(Request $request)
    {

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
        $cliente = ReceptorCR::cliente($dte['receptor']);
        $tipoDTE = '07';
        $idCliente = $cliente['id'];

        // VARIABLES DE RESPUESTA DEL SERVICIO
        $responseData = '';
        $statusCode = '';

        // Variables de Identificación
        $contingencia = isset($json['contingencia']) ? $json['contingencia'] : null;
        $identificacion = Identificacion::identidad($tipoDTE, 1, $contingencia);

        // Variables de Emisor y Receptor
        $emisor = $dte['emisor'] ?? Identificacion::emisor($tipoDTE, '20', null);
        [$faltan, $receptor] = Receptor::generar($dte['receptor'], $tipoDTE);

        if ($faltan)
            return response()->json($receptor, 404);

        $resumen = $dte['resumen'];

        $cuerpoDocumento = $dte['cuerpoDocumento'];
        $extension = $dte['extension'] ?? null;
        $apendice = $dte['apendice'] ?? null;

        $newDTE = [
            "identificacion" => $identificacion,
            "emisor" => $emisor,
            "receptor" => $receptor,
            "cuerpoDocumento" => $cuerpoDocumento,
            "resumen" => $resumen,
            "extension" => $extension,
            "apendice" => $apendice,
        ];

        [$responseData, $statusCode] = DteApiMHService::envidarDTE($newDTE, $idCliente, $identificacion);
        
        return response()->json($responseData, $statusCode);
        
        return response()->json($newDTE, 200);

    }
}
