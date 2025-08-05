<?php

namespace App\Http\Controllers;

use App\Help\DteCodeValidator;
use App\Help\DTEHelper\FSEDTE;
use App\Help\DTEIdentificacion\Identificacion;
use App\Help\DTEIdentificacion\Receptor;
use App\Help\Help;
use App\Help\LoginMH;
use App\Help\Services\DteApiMHService;
use App\Help\Services\SendMailFe;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// ^ FACTURA DE SUJETO EXCLUIDO
class DteFseController extends Controller
{
    public function unitario(Request $request)
    {

        //* Login para generar token de Hacienda.

        $json = $request->json()->all();

        if (!$json) {
            return response()->json(["error" => "DTE no válido o nulo"], Response::HTTP_BAD_REQUEST);
        }

        //* VARAIBLES DE CONFIGURACION DEL DTE
        $dte = $json['dteJson'];
        $condicionOperacion = $json['operacion'];
        //  $cliente = Help::getClienteId($dte['sujetoExcluido']['numDocumento']);
        $cliente = Help::ValidarCliente($dte['sujetoExcluido']['numDocumento'], $dte['sujetoExcluido']);
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


        $pagoTributos = isset($json['pagoTributos']) ? $json['pagoTributos'] : null;
        $codigoPago = isset($json['codigo_pago']) ? $json['codigo_pago'] : "01";
        $periodoPago = isset($json['periodo_pago']) ? $json['periodo_pago'] :  null;
        $plazoPago = isset($json['plazo_pago']) ? $json['plazo_pago'] :  null;
        $operacion = isset($json['operacion']) ? $json['operacion'] :  1;

        $resumen = FSEDTE::resumen($cuerpoDocumento,
        $pagoTributos, $codigoPago, $periodoPago, $plazoPago, $operacion);

        $cuerpoDocumento = array_map(function ($item) {
            if (isset($item['renta'])) {
                unset($item['renta']);
            }
            return $item;
        }, $cuerpoDocumento);

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
        


        $responseLogin = LoginMH::login();
        $requestCrudo = $json;
        if ($responseLogin['code'] != 200) {
            [$responseData, $statusCode, $id] = DteApiMHService::EnviarOfflineMH($newDTE, $idCliente, $identificacion, $requestCrudo);
        } else {

            [$responseData, $statusCode, $id] = DteApiMHService::envidarDTE($newDTE, $idCliente, $identificacion, $requestCrudo);
        }

        $mailInfo = array(
            'responseData' => $responseData,
            'statusCode' => $statusCode,
            'dte' => $newDTE,
            'numeroControl' => $identificacion['numeroControl'],
            'fecEmi' => $identificacion['fecEmi'],
            'horEmi' => $identificacion['horEmi'],
            'codigoGeneracion' => $identificacion['codigoGeneracion'],
            'id' => $id
        );

        $empresa = Help::getEmpresa();
        SendMailFe::sending($id,$empresa, $mailInfo, $identificacion, $sujetoExcluido);

        return response()->json(
            $mailInfo,
            $statusCode
        );

        //return response()->json($responseData, $statusCode);

    }
}
