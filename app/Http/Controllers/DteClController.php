<?php

namespace App\Http\Controllers;

use App\Help\DteCodeValidator;
use App\Help\DTEHelper\CLDTE;
use App\Help\DTEIdentificacion\Identificacion;
use App\Help\DTEIdentificacion\Receptor;
use App\help\Help;
use App\Help\LoginMH;
use App\Help\Services\DteApiMHService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// ^ COMPROBANTE DE LIQUIDACION
class DteClController extends Controller
{
    public function unitario(Request $request){

        // Login para generar token de Hacienda.
        $responseLogin = LoginMH::login();
        if ($responseLogin['code'] != 200)
            return response()->json(DteCodeValidator::code404($responseLogin['error']), 404);

        $json = $request->json()->all();

        if (!$json)
            return response()->json(["error" => "DTE no válido o nulo"], Response::HTTP_BAD_REQUEST);

        // VARAIBLES DE CONFIGURACION DEL DTE
        $dte = $json['dteJson'];
        $cliente = Help::getClienteId($dte['receptor']['nit']);
        $tipoDTE = '08';
        $idCliente = $cliente['id'];

        // VARIABLES DE RESPUESTA DEL SERVICIO
        $responseData = '';
        $statusCode = '';

        // Variables de Identificación
        $identificacion = Identificacion::identidad($tipoDTE, 1);

        // Variables de Emisor y Receptor
        $emisor = $dte['emisor'] ?? Identificacion::emisor($tipoDTE, '20', null);

        // Validación de Receptor
        [$faltan, $receptor] = Receptor::generar($dte['receptor'], $tipoDTE);
        if ($faltan)
            return response()->json($receptor, 404);

        $cuerpoDocumento = $dte['cuerpoDocumento'];

        $resumen = CLDTE::getResumen($cuerpoDocumento);

        // Variables de Extensión y Apéndice
        $extension = isset($json['extension']) ? $json['extension'] : null;
        $apendice = isset($json['apendice']) ? $json['apendice'] : null;

        // Creación de newDTE
        $newDTE = compact(
            'identificacion',
            'emisor',
            'receptor',
            'cuerpoDocumento',
            'resumen',
            'extension',
            'apendice'
        );

        return response()->json($newDTE);

        [$responseData, $statusCode] = DteApiMHService::envidarDTE($newDTE, $idCliente, $identificacion);

        return response()->json($responseData, $statusCode);
    }
}
