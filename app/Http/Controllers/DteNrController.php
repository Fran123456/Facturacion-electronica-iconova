<?php

namespace App\Http\Controllers;

use App\Help\DteCodeValidator;
use App\Help\DTEHelper\NRDTE;
use App\Help\DTEIdentificacion\Identificacion;
use App\Help\DTEIdentificacion\Receptor;
use App\help\Help;
use App\Help\LoginMH;
use App\Help\Services\DteApiMHService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// ^ NOTA DE REMISION
class DteNrController extends Controller
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
       // $cliente = Help::getClienteId($dte['receptor']['numDocumento']);
        $cliente = Help::ValidarCliente($dte['receptor']['numDocumento'],$dte['receptor']);
        $tipoDTE = '04';
        $idCliente = $cliente['id'];

        // VARIABLES DE RESPUESTA DEL SERVICIO
        $responseData = '';
        $statusCode = '';

        // Variables de Identificación
        $contingencia = isset($json['contingencia']) ? $json['contingencia'] : null;
        $identificacion = Identificacion::identidad($tipoDTE, 3, $contingencia);
       

        // Variables de Emisor y Receptor
        $emisor = $dte['emisor'] ?? Identificacion::emisor($tipoDTE, '20', null);
        [$faltan, $receptor] = Receptor::generar($dte['receptor'], $tipoDTE);

        if ( $faltan )
            return response()->json($receptor, 404);

        $documentoRelacionado = $dte['documentoRelacionado'] ?? null;

        $ventaTercero = $dte['ventaTercero'] ?? null;

        $cuerpoDocumento = NRDTE::getCuerpo($dte['cuerpoDocumento']);
        $resumen = NRDTE::getResumen($dte['cuerpoDocumento']);

        $extension = $json['extension'] ?? null;
        $apendice = $json['apendice'] ?? null;

        $newDTE = compact(
            'identificacion',
            'emisor',
            'receptor',
            'documentoRelacionado',
            'ventaTercero',
            'cuerpoDocumento',
            'resumen',
            'extension',
            'apendice'
        );


        [$responseData, $statusCode] = DteApiMHService::envidarDTE($newDTE, $idCliente, $identificacion);

        return response()->json( array($responseData, $newDTE), $statusCode);

        

    }
}
