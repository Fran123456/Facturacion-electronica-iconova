<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Help\Services\DteApiMHService;
use Symfony\Component\HttpFoundation\Response;
use App\Help\Help;
use App\Help\DTEHelper\CCFDTE;
use App\Help\LoginMH;
use App\Help\DTEIdentificacion\Identificacion;
use App\Help\DTEIdentificacion\Receptor;
use App\Help\Services\SendMailFe;

// ^ COMPROBANTE CREDITO FISCAL
class DteCCFController extends Controller
{
    public function enviarDteUnitarioCCF(Request $request)
    {

        $empresa = Help::getEmpresa();
        // Login para generar token de Hacienda.

        //obtenemos el json desde el request
        $json = $request->json()->all();
        $requestCrudo = $json;


        //Se valida que si venga algo en el body.
        if (!$json) {
            return response()->json(["error" => "DTE no válido o nulo"], Response::HTTP_BAD_REQUEST);
        }

        //Generamos los pagos tributos
        $json['pagoTributos'] = CCFDTE::makePagoTributo($json['dteJson']['cuerpoDocumento']);

        // VARAIBLES DE CONFIGURACION DEL DTE
        $dte = $json['dteJson'];
        $cliente = Help::ValidarCliente($dte['receptor']['nit'], $dte['receptor']);

        $tipoDTE = '03';
        $idCliente = $cliente['id'];

        // VARIABLES DE RESPUESTA DEL SERVICIO
        $responseData = '';
        $statusCode = '';

        // Variables de Identificación
        $contingencia = isset($json['contingencia']) ? $json['contingencia'] : null;
        $identificacion = Identificacion::identidad($tipoDTE, 3, $contingencia);


        // Variables de Emisor y Receptor
        $emisor = isset($json['emisor']) ? $json['emisor'] : Identificacion::emisor('03', '20', null);
        [$faltan, $receptor] = Receptor::generar($dte['receptor'], $tipoDTE);

        if ($faltan)
            return response()->json($receptor, 404);

        // Variables de Documento Relacionado y Cuerpo del Documento
        $documentoRelacionado = isset($json['documentoRelacionado']) ? $json['documentoRelacionado'] : null;
        $otrosDocumentos = isset($json['otrosDocumentos']) ? $json['otrosDocumentos'] : null;
        $ventaTercero = isset($json['ventaTercero']) ? $json['ventaTercero'] : null;
        $cuerpoDocumento = CCFDTE::getCuerpoDocumento($dte['cuerpoDocumento']);


        $cuerpoDocumento = CCFDTE::makeCuerpoDocumento($cuerpoDocumento);
       
        


        $pagoTributos = isset($json['pagoTributos']) ? $json['pagoTributos'] : null;
        $codigoPago = isset($json['codigo_pago']) ? $json['codigo_pago'] : "01";
        $periodoPago = isset($json['periodo_pago']) ? $json['periodo_pago'] :  null;
        $plazoPago = isset($json['plazo_pago']) ? $json['plazo_pago'] :  null;
        $operacion = isset($json['operacion']) ? $json['operacion'] :  1;
        $retension = $dte['retension'] >0 ? true: false;

       
        $resumen = CCFDTE::Resumen($cuerpoDocumento,  $retension, $json['pagoTributos'], $codigoPago, $periodoPago, $plazoPago, $operacion);

        // Variables de Extensión y Apéndice
        $extension = isset($json['extension']) ? $json['extension'] : null;
        $apendice = isset($json['apendice']) ? $json['apendice'] : null;

        // Creación de newDTE

        $newDTE = [
            'identificacion' => $identificacion,
            'emisor' => $emisor,
            'receptor' => $receptor,
            'documentoRelacionado' => $documentoRelacionado,
            'otrosDocumentos' => $otrosDocumentos,
            'ventaTercero' => $ventaTercero,
            'cuerpoDocumento' => $cuerpoDocumento,
            'resumen' => $resumen,
            'extension' => $extension,
            'apendice' => $apendice
        ];
      
        
        

        $responseLogin = LoginMH::login();




        if ($responseLogin['code'] != 200) {
            //  return response()->json(DteCodeValidator::code404($responseLogin['error']), 404);
            [$responseData, $statusCode, $id] = DteApiMHService::EnviarOfflineMH(
                $newDTE,
                $idCliente,
                $identificacion,
                $requestCrudo
            );
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


        SendMailFe::sending($id, $empresa, $mailInfo, $identificacion, $receptor);


        return response()->json(
            $mailInfo,
            $statusCode
        );
    }
}
