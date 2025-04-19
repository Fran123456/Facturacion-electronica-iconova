<?php

namespace App\Http\Controllers;

use App\Help\DteCodeValidator;
use App\Help\DTEHelper\FACTDTE;
use App\Help\DTEIdentificacion\Identificacion;
use App\Help\DTEIdentificacion\Receptor;
use App\help\Help;
use App\Help\LoginMH;
use App\Help\Services\DteApiMHService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// ^ FACTURA
class DteFcController extends Controller
{

    public function unitario(Request $request)
    {
        // Login para generar token de Hacienda.
      /*  $responseLogin = LoginMH::login();
        if ($responseLogin['code'] != 200) {
            return response()->json(DteCodeValidator::code404($responseLogin['error']), 404);
        }*/

        $json = $request->json()->all();

        if (!$json) {
            return response()->json(["error" => "DTE no válido o nulo"], Response::HTTP_BAD_REQUEST);
        }

        // VARAIBLES DE CONFIGURACION DEL DTE
        $dte = $json['dteJson'];
        $cliente = Help::ValidarClienteByEmail($dte['receptor']['numDocumento'],$dte['receptor']['correo'], $dte['receptor']);
        $tipoDTE = "01";
        $idCliente = $cliente['id'];

        // VARIABLES DE RESPUESTA DEL SERVICIO
        $responseData = '';
        $statusCode = '';

        // Variables de Identificación
        $contingencia = isset($json['contingencia']) ? $json['contingencia'] : null;
        $identificacion = Identificacion::identidad($tipoDTE, 1, $contingencia);

        // Variables de Emisor y Receptor
        $emisor = $dte['emisor'] ?? Identificacion::emisor($tipoDTE, '20', null);

        [$faltan, $receptor] = Receptor::generar($dte['receptor'] ?? null, $tipoDTE);

        if ( $faltan )
            return response()->json($receptor, 404);

        $cuerpoDocumento = FACTDTE::getCuerpoDocumento($dte['cuerpoDocumento']);

        $pagoTributos = isset($json['pagoTributos']) ? $json['pagoTributos'] : null;
        $codigoPago = isset($json['codigo_pago']) ? $json['codigo_pago'] : "01";
        $periodoPago = isset($json['periodo_pago']) ? $json['periodo_pago'] :  null;
        $plazoPago = isset($json['plazo_pago']) ? $json['plazo_pago'] :  null;
        $resumen = FACTDTE::Resumen($cuerpoDocumento, $dte['receptor']['grancontribuyente'] ?? false, $pagoTributos, $codigoPago, $periodoPago, $plazoPago);

        // Variables de Documento Relacionado y Cuerpo del Documento
        $documentoRelacionado = $json['documentoRelacionado'] ?? null;
        $otrosDocumentos = $json['otrosDocumentos']??null;
        $ventaTercero = $json['ventaTercero'] ?? null;

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
       
        // return response()->json($newDTE);
            

        //return response()->json($responseData, $statusCode);
    

        // retornando el json para mh
        //print_r(json_encode($newDTE));
        //return;
        $responseLogin = LoginMH::login();
        if ($responseLogin['code'] != 200) {
            [$responseData, $statusCode, $id] = DteApiMHService::EnviarOfflineMH( $newDTE, $idCliente, $identificacion );
        }else{
            [$responseData, $statusCode, $id] = DteApiMHService::envidarDTE( $newDTE, $idCliente, $identificacion );
        }
  
      

         $mailInfo = array(
            'responseData'=>$responseData,
            'statusCode'=>$statusCode,
            'dte'=> $newDTE,
            'numeroControl'=>$identificacion['numeroControl'],
            'fecEmi'=> $identificacion['fecEmi'],
            'horEmi'=> $identificacion['horEmi'],
            'codigoGeneracion'=> $identificacion['codigoGeneracion'],
            'id'=>$id
        );


        return response()->json(
            $mailInfo
            , $statusCode);

        //return response()->json($responseData, $statusCode);
    }
}
