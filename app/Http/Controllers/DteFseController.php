<?php

namespace App\Http\Controllers;

use App\Help\DteCodeValidator;
use App\Help\DTEHelper\FSEDTE;
use App\Help\DTEIdentificacion\Identificacion;
use App\Help\DTEIdentificacion\Receptor;
use App\help\Help;
use App\Help\LoginMH;
use App\Help\Services\DteApiMHService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// ^ FACTURA DE SUJETO EXCLUIDO
class DteFseController extends Controller
{
    public function unitario(Request $request)
    {

        //* Login para generar token de Hacienda.
        $responseLogin = LoginMH::login();
        if ($responseLogin['code'] != 200) {
            return response()->json(DteCodeValidator::code404($responseLogin['error']), 404);
        }

        $json = $request->json()->all();

        if (!$json) {
            return response()->json(["error" => "DTE no válido o nulo"], Response::HTTP_BAD_REQUEST);
        }

        //* VARAIBLES DE CONFIGURACION DEL DTE
        $dte = $json['dteJson'];
        $condicionOperacion = $json['condicionOperacion'];
        $cliente = Help::getClienteId($dte['sujetoExcluido']['numDocumento']);
        $tipoDTE = '14';
        $idCliente = $cliente['id'];

        //* VARIABLES DE RESPUESTA DEL SERVICIO
        $responseData = '';
        $statusCode = '';

        //* Variables de Identificación
        $contingencia = isset($json['contingencia']) ? $json['contingencia'] : null;
        $identificacion = Identificacion::identidad($tipoDTE, 1, $contingencia);

        //* Variables de Emisor y Receptor
        $emisor = $dte['emisor'] ?? Identificacion::emisor($tipoDTE, '20', null);

        [$faltan, $sujetoExcluido] = Receptor::generar($dte['sujetoExcluido'], $tipoDTE);
        if ($faltan)
            return response()->json($sujetoExcluido, 404);

        //* Variables de Cuerpo y Resumen
        $cuerpoDocumento = $dte['cuerpoDocumento'] ?? null;
        $cuerpoDocumento = FSEDTE::cuerpo($cuerpoDocumento);
        $resumen = FSEDTE::resumen($cuerpoDocumento);
        $resumen['condicionOperacion'] = $condicionOperacion;

        $apendice = $json['apendice'] ?? null;

        $newDTE = compact(
            'identificacion', 
            'emisor', 
            'sujetoExcluido', 
            'cuerpoDocumento', 
            'resumen', 
            'apendice'
        );

        [$responseData, $statusCode] = DteApiMHService::envidarDTE($newDTE, $idCliente, $identificacion);

        return response()->json($responseData, $statusCode);

    }
}
