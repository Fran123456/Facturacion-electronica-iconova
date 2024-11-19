<?php

namespace App\Http\Controllers;

use App\Help\DteCodeValidator;
use App\Help\DTEHelper\CCFDTE;
use App\Help\DTEHelper\NDDTE;
use App\Help\DTEIdentificacion\Identificacion;
use App\Help\DTEIdentificacion\Receptor;
use App\help\Help;
use App\Help\LoginMH;
use App\Help\Services\DteApiMHService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// ^ NOTA DE DEBITO
class DteNdController extends Controller
{
    public function unitario(Request $request)
    {

        //PASO 1 , HACER LOGIN EN HACIENDA
        $responseLogin = LoginMH::login();
        if ($responseLogin['code'] != 200)
            return response()->json(DteCodeValidator::code404($responseLogin['error']), 404);

        //PASO 2 OBTENER INFORMACION Y DESFRAGMENTARLA
        $json = json_decode($request->getContent(), true);

        if (!$json) {
            return response()->json(["error" => "DTE no válido o nulo"], Response::HTTP_BAD_REQUEST);
        }

        $dte = $json['dteJson']; //OBTENER EL DTE

        $pagoTributos = $json['pagoTributos'] ?? null;

        $cliente = Help::getClienteId($dte['receptor']['nit']);
        $idCliente = $cliente['id'];
        $newDTE = [];
        $tipoDTE = '06';

        //PASO 3 GENERAR JSON VALIDO PARA  HACIENDA
        $identificacion = Identificacion::identidad($tipoDTE, 3);


        $emisor = Identificacion::emisor($tipoDTE, null, null, null);

        $tipoCliente = $dte['receptor']['granContribuyente'] ?? null;
        unset($dte['receptor']['granContribuyente']);

        [$faltan, $receptor] = Receptor::generar($dte['receptor'], $tipoDTE);

        if ( $faltan )
            return response()->json($receptor, 404);

        $documentoRelacionado = null;
        $ventaTercero = null;
        // $cuerpoDocumento = CCFDTE::getCuerpoDocumento($dte['cuerpoDocumento']);

        $resumen = null;
        $extension = null;
        $apendice = null;

        //  return response()->json($dte['documentoRelacionado'], 200);
        $documentoRelacionado = NDDTE::documentosRelacionados($dte['documentoRelacionado']);
        $ventaTercero = $dte['ventaTercero'] ?? null;
        $cuerpoDocumento =  NDDTE::cuerpo($dte['cuerpoDocumento']);
        
        $resumen = NDDTE::resumen($dte['cuerpoDocumento'], $tipoCliente);
        // return response()->json(compact('cuerpoDocumento', 'resumen'), 200);

        $extension = $dte['extension'];
        $apendice = $dte['apendice'] ?? null;

        $newDTE = compact(
            'identificacion',
            'documentoRelacionado',
            'emisor',
            'receptor',
            'cuerpoDocumento',
            'resumen',
            'ventaTercero',
            'extension',
            'apendice'
        );

        // return response()->json($newDTE, 200);

        [$responseData, $statusCode] = DteApiMHService::envidarDTE($newDTE, $idCliente, $identificacion);

        return response()->json($responseData, $statusCode);

    }
}
