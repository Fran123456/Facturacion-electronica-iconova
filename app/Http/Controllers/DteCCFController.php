<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Help\Services\DteApiMHService;
use App\Models\User;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Empresa;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use App\Models\Config;
use App\Help\Help;
use App\Help\DteCodeValidator;
use App\Help\DTEHelper\CCFDTE;
use App\Help\DTEHelper\FACTDTE;
use App\help\FirmadorElectronico;
use App\help\Generator;
use App\Help\LoginMH;
use Monolog\Handler\FirePHPHandler;
use JsonSchema\Validator;
use App\Mail\DteMail;
use Illuminate\Support\Facades\Mail;
use App\Help\WhatsappSender;
use App\Help\DTEIdentificacion\Identificacion;
use DateTime;
use App\Help\DTEHelper\FEXDTE;
use App\Help\DTEIdentificacion\Receptor;
use App\Models\LogDTE;
use App\Models\RegistroDTE;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;

class DteCCFController extends Controller
{
    public function enviarDteUnitarioCCF(Request $request)
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

        if ( ( isset($json['pagoTributos'] ) || $json['pagoTributos']  != null)
            && count($json['pagoTributos']) != count($json['dteJson']['cuerpoDocumento']) )
            return request()->json(401, [
                "msg" => "El campo pagoTributos tiene que tener la misma longitud que cuerpoDocumento"
            ]);


        // $schemaValidacion = [
        //     'dteJson.receptor' => 'required|array',
        //     'dteJson.cuerpoDocumento' => 'required|array',
        //     'dteJson.emisor' => 'nullable|array',
        //     'dteJson.documentoRelacionado' => 'nullable|array',
        //     'dteJson.otrosDocumentos' => 'nullable|array',
        //     'dteJson.ventaTercero' => 'nullable|array',
        //     'dteJson.extension' => 'nullable|array',
        //     'dteJson.apendice' => 'nullable|array',

        // ];

        // $request->validate($schemaValidacion);

        // VARAIBLES DE CONFIGURACION DEL DTE
        $dte = $json['dteJson'];
       
        $cliente = Help::ValidarCliente($dte['receptor']['nit'],$dte['receptor']);
        
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
        

        if ( $faltan )
            return response()->json($receptor, 404);

        // Variables de Documento Relacionado y Cuerpo del Documento
        $documentoRelacionado = isset($json['documentoRelacionado']) ? $json['documentoRelacionado'] : null;
        $otrosDocumentos = isset($json['otrosDocumentos']) ? $json['otrosDocumentos'] : null;
        $ventaTercero = isset($json['ventaTercero']) ? $json['ventaTercero'] : null;
        $cuerpoDocumento = CCFDTE::getCuerpoDocumento($dte['cuerpoDocumento']);

        // Variables de Resumen
        $pagoTributo = isset($json['pagoTributos']) ? $json['pagoTributos'] : null;
        $codigoPago = isset($json['codigo_pago']) ? $json['codigo_pago'] : "01";
        $periodoPago = isset($json['periodo_pago']) ? $json['periodo_pago'] : null;
        $plazoPago = isset($json['plazo_pago']) ? $json['plazo_pago'] : null;
        $resumen = CCFDTE::Resumen($cuerpoDocumento, 
        $cliente['tipoCliente'], $pagoTributo, $codigoPago, $periodoPago, $plazoPago);

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

        // return response()->json($newDTE, 200);
        //return $newDTE;
       
        [$responseData, $statusCode] = DteApiMHService::envidarDTE( $newDTE, $idCliente, $identificacion );

        return response()->json(  
            array(
                'responseData'=>$responseData,
                'statusCode'=>$statusCode,
                'dte'=> $newDTE,
                'numeroControl'=>$identificacion['numeroControl'],
                'fecEmi'=> $identificacion['fecEmi'],
                'horEmi'=> $identificacion['horEmi'],
            )
            , $statusCode);
    }

}
