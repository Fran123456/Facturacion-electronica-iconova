<?php

namespace App\Http\Controllers;

use App\Help\DteCodeValidator;
use App\Help\DTEHelper\FEXDTE;
use App\Help\DTEIdentificacion\Identificacion;
use App\Help\DTEIdentificacion\Receptor;
use App\help\Help;
use App\Help\LoginMH;
use App\Help\Services\DteApiMHService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// ^ FACTURAS DE EXPORTACION
class DteFexController extends Controller
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

        if ((isset($json['pagoTributos']) || $json['pagoTributos']  != null)
            && count($json['pagoTributos']) != count($json['dteJson']['cuerpoDocumento'])
        )
            return request()->json(401, [
                "msg" => "El campo pagoTributos tiene que tener la misma longitud que cuerpoDocumento"
            ]);

        // VARAIBLES DE CONFIGURACION DEL DTE
        $dte = $json['dteJson'];
        $cliente = Help::getClienteId($dte['receptor']['nit']);
        $tipoDTE = '11';
        $idCliente = $cliente['id'];



        // Variables de Identificación
        // $identificacion = Identificacion::identidad($tipoDTE, 3);
        $contingencia = isset($json['contingencia']) ? $json['contingencia'] : null;
        $identificacion = Identificacion::identidad($tipoDTE, 1, $contingencia);

        // Variables de Emisor y Receptor
        $emisor = $dte['emisor'] ?? Identificacion::emisor($tipoDTE, '20', null);
        [$faltan, $receptor] = Receptor::generar($dte['receptor'], $tipoDTE);

        if ($faltan)
            return response()->json($receptor, 404);


        // return response()->json([
        //     "identificacion" => $identificacion,
        //     "emisor" => $emisor,
        //     "receptor" => $receptor,
        //     "contingencia" => $contingencia
        // ], 200);

        // Variables de Documento Relacionado y Cuerpo del Documento
        $otrosDocumentos = $dte['otrosDocumentos'];
        $ventaTercero = $dte['ventaTercero'];
        $cuerpoDocumento = FEXDTE::getCuerpoDocumento($dte['cuerpoDocumento']);

        // Variables de Resumen
        $pagoTributo = isset($json['pagoTributos']) ? $json['pagoTributos'] : null;
        $codigoPago = isset($json['codigo_pago']) ? $json['codigo_pago'] : "01";
        $periodoPago = isset($json['periodo_pago']) ? $json['periodo_pago'] : null;
        $plazoPago = isset($json['plazo_pago']) ? $json['plazo_pago'] : null;

        $condicionPago= isset($json['condicion_pago']) ? $json['condicion_pago'] : 1;
        $incoterms= isset($json['incoterms']) ? $json['incoterms'] : null;
        $resumen = FEXDTE::Resumen($cuerpoDocumento, $pagoTributo, $codigoPago, $plazoPago, $periodoPago, $condicionPago, $incoterms);

        // Variables de Extensión y Apéndice
        $apendice = $dte['apendice'];

        // Creación de newDTE
        $newDTE = [
            'identificacion' => $identificacion,
            'emisor' => $emisor,
            'receptor' => $receptor,
            'cuerpoDocumento' => $cuerpoDocumento,
            'resumen' => $resumen,

            'otrosDocumentos' => $otrosDocumentos,
            'ventaTercero' => $ventaTercero,
            'apendice' => $apendice
        ];
        // $newDTE = [
        //     'identificacion' => $identificacion,
        //     'emisor' => $emisor,
        //     'receptor' => $receptor,
        //     'cuerpoDocumento' => $cuerpoDocumento,
        //     'resumen' => $resumen,
        // ];

        // return response()->json($newDTE, 200);

        // VARIABLES DE RESPUESTA DEL SERVICIO
        $responseData = '';
        $statusCode = '';

        [$responseData, $statusCode] = DteApiMHService::envidarDTE($newDTE, $idCliente, $identificacion);

        return response()->json($responseData, $statusCode);
    }
}
