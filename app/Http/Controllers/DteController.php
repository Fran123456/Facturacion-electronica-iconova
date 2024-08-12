<?php

namespace App\Http\Controllers;

use App\Help\Services\DteApiMHService;
use App\Models\User;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Empresa;
use Illuminate\Http\Request;
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
use App\Models\LogDTE;
use App\Models\RegistroDTE;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;

class DteController extends Controller
{

//     public function enviarDteUnitarioCCF(Request $request)
//     {
//         // Login para generar token de Hacienda.
//         $responseLogin = LoginMH::login();
//         if ($responseLogin['code'] != 200) {
//             return response()->json(DteCodeValidator::code404($responseLogin['error']), 404);
//         }

//         $dteJson = $request->json()->all();

//         if (!$dteJson) {
//             return response()->json(["error" => "DTE no válido o nulo"], Response::HTTP_BAD_REQUEST);
//         }

//         // VARAIBLES DE CONFIGURACION DEL DTE
//         $dte = $dteJson['dteJson'];
//         $cliente = Help::getClienteId($dte['receptor']['nit']);
//         $tipoDTE = '03';
//         $idCliente = $cliente['id'];

//         // VARIABLES DE RESPUESTA DEL SERVICIO
//         $responseData = '';
//         $statusCode = '';

//         // Variables de Identificación
//         $identificacion = Identificacion::identidad($tipoDTE, 3);

//         // Variables de Emisor y Receptor
//         $emisor = $dte['emisor'] ?? Identificacion::emisor('03', '20', null);
//         $receptor = Identificacion::receptorCCF($dte['receptor']);

//         // Variables de Documento Relacionado y Cuerpo del Documento
//         $documentoRelacionado = $dte['documentoRelacionado'] ?? null;
//         $otrosDocumentos = $dte['otrosDocumentos'];
//         $ventaTercero = $dte['ventaTercero'];
//         $cuerpoDocumento = CCFDTE::getCuerpoDocumento($dte['cuerpoDocumento']);

//         // Variables de Resumen
//         $codigoPago = $dteJson['codigo_pago'];
//         $periodoPago = $dteJson['periodo_pago'] ?? null;
//         $plazoPago = $dteJson['plazo_pago'] ?? null;
//         $resumen = CCFDTE::Resumen($cuerpoDocumento, $cliente['tipoCliente'], $codigoPago, $periodoPago, $plazoPago);

//         // Variables de Extensión y Apéndice
//         $extension = $dte['extension'];
//         $apendice = $dte['apendice'];

//         // Creación de newDTE
//         $newDTE = [
//             'identificacion' => $identificacion,
//             'emisor' => $emisor,
//             'receptor' => $receptor,
//             'documentoRelacionado' => $documentoRelacionado,
//             'otrosDocumentos' => $otrosDocumentos,
//             'ventaTercero' => $ventaTercero,
//             'cuerpoDocumento' => $cuerpoDocumento,
//             'resumen' => $resumen,
//             'extension' => $extension,
//             'apendice' => $apendice
//         ];

//         // return response()->json($newDTE, 200);

//         [$responseData, $statusCode] = DteApiMHService::envidarDTE( $newDTE, $idCliente, $identificacion );

//         return response()->json($responseData, $statusCode);
//     }

//     private function handleErrorResponse($statusCode, $responseData)
//     {
//         switch ($statusCode) {
//             case 415:
//                 return DteCodeValidator::code415($responseData);
//             case 401:
//                 return DteCodeValidator::code401();
//             case 404:
//                 return DteCodeValidator::code404();
//             default:
//                 return $responseData;
//         }
//     }


//     public function enviarDteUnitarioFacturaExterior(Request $request)
//     {

//         //login para generar token de hacienda.
//         $responseLogin = LoginMH::login();

//         if ($responseLogin['code'] != 200)
//             return response()->json(DteCodeValidator::code404($responseLogin['error']), 404);

//         $empresa = Help::getEmpresa();
//         $url = Help::mhUrl();
//         /*
//          $dteJson = $request;

//         if ($dteJson == null)
//             return response()->json(["error" => "DTE no valido o nulo"], Response::HTTP_BAD_REQUEST);
//         if ($dteJson['cliente'] == null)
//             return response()->json(["error" => "El cliente es requerido"], Response::HTTP_BAD_REQUEST);

//         //GENERAR JSON VALIDO PARA  HACIENDA
//         $identificacion = Identificacion::identidad('11');
//         $emisor = Identificacion::emisor('20', null, null, null);
//         $receptor = Identificacion::receptor($dteJson['cliente']);
//         if(isset($receptor['error']))
//             return response()->json(["error" => $receptor['comentario']], Response::HTTP_BAD_REQUEST);
//         $detalle = FEXDTE::BuildDetalle($dteJson['cuerpoDocumento']);
//         $resumen = FEXDTE::Resumen($detalle, $dteJson['condicionPago']??'1',  $dteJson['pago']??null);

//         $dte = [
//             "identificacion"=>$identificacion,
//             'emisor'=>$emisor,
//             'receptor'=>$receptor,
//             'otrosDocumentos'=>null,
//             'ventaTercero'=>null,
//             'cuerpoDocumento'=>$detalle,
//             'resumen'=>$resumen ,
//             'apendice'=>[FEXDTE::Apendice(),FEXDTE::Apendice()]
//         ];
//       // return $dte;
//         */

//         $dte = $request;
//         $dte = FirmadorElectronico::firmadorNew($dte);



//         $jsonRequest = [
//             'ambiente' => "00",
//             'idEnvio' => 1,
//             'version' => 1,
//             'tipoDte' => "11",
//             "documento" => $dte['msg'],
//             "codigoGeneracion" => "341CA743-70F1-4CFE-88B57E4AE72E60CB",
//             "nitEmisor" => "06141802161055"
//         ];


//         $requestResponse = Http::withHeaders([
//             'Authorization' => $empresa->token_mh,
//             'User-Agent' => 'ApiLaravel/1.0',
//             'Content-Type' => 'application/JSON'
//         ])->post($url . "fesv/recepciondte", $jsonRequest);

//         $responseData = $requestResponse->json();
//         $statusCode = $requestResponse->status();

//         //415 Unsupported Media Type
//         if ($statusCode == 415) return response()->json(DteCodeValidator::code415($responseData), 415);
//         // 401 Unauthorized de parte de login hacienda.
//         if ($statusCode == 401) return response()->json(DteCodeValidator::code401(), 401);

//         return response()->json($responseData, $statusCode);





//         //$nombreCliente = 'Francisco Navas';
//         //  $correoEmpresa = Crypt::decryptString($empresa->correo_electronico);
//         // $telefono = Crypt::decryptString($empresa->telefono);
//         // $nombreEmpresa = Crypt::decryptString($empresa->nombre);
//         //return WhatsappSender::send();

//         /*  Mail::to('francisco.navas@datasys.la')
//         ->from($correoEmpresa, $nombreEmpresa)
//         ->send(new DteMail($nombreCliente ,  $correoEmpresa,  $telefono, "9D50E003-621E-1AB5-B828-0004AC1EA976"));

//         */
//     }

//     public function enviarDteUnitarioFactura(Request $request)
//     {

//         //PASO 1 , HACER LOGIN EN HACIENDA

//         $responseLogin = LoginMH::login();
//         if ($responseLogin['code'] != 200)
//             return response()->json(DteCodeValidator::code404($responseLogin['error']), 404);


//         //PASO 2 OBTENER INFORMACION Y DESFRAGMENTARLA
//         $body = json_decode($request->getContent(), true);
//         $dte = $body['dteJson']; //OBTENER EL DTE
//         $codigoPago = $body['codigo_pago'];
//         $periodoPago = isset($body['periodo_pago']) ? $body['periodo_pago'] : null;
//         $plazoPago = isset($body['plazo_pago']) ? $body['plazo_pago'] : null;
//         $newDTE = [];
//         $tipoDTE = '01';
//         $numeroDTE = Generator::generateNumControl($tipoDTE);
//         $fechaEmision = Carbon::now()->format('Y-m-d');
//         $horaEmision = Carbon::now()->format('H:i:s'); //24 horas

//         $empresa = Help::getEmpresa();
//         $url = Help::mhUrl();

//         //PASO 3 GENERAR JSON VALIDO PARA  HACIENDA
//         $identificacion = Identificacion::identidad('01');
//         $emisor = Identificacion::emisor('01', null, null, null);
//         $receptor = Identificacion::receptorFactura($dte['receptor']);

//         $newDTE['extension'] = null;
//         $newDTE['receptor'] = $receptor;
//         $newDTE['identificacion'] = $identificacion;
//         $newDTE['resumen'] = FACTDTE::Resumen($dte['cuerpoDocumento'], $codigoPago, $periodoPago, $plazoPago, $body['forma_pago'], $body['numPagoElectronico']);

//         $newDTE['cuerpoDocumento'] = $dte['cuerpoDocumento'];
//         $newDTE['otrosDocumentos'] = $dte['otrosDocumentos'] ?? null;
//         $newDTE['ventaTercero'] = $dte['ventaTercero'] ?? null;
//         $newDTE['apendice'] = $dte['apendice'] ?? null;
//         if (array_key_exists('documentoRelacionado', $dte))
//             $newDTE['documentoRelacionado'] = $dte['documentoRelacionado'];
//         else
//             $newDTE['documentoRelacionado'] = null;

//         $newDTE['emisor'] = $emisor;

//         try {
//             $idCliente = Help::getClienteId($dte['receptor']['numDocumento']);

//             $DTESigned = FirmadorElectronico::firmador($newDTE);

//             $statusSigner =  $DTESigned['status'];

//             if ($statusSigner > 201)
//                 return response()->json([
//                     "error" => $DTESigned['error']
//                 ], $statusSigner);

//             $documento = $DTESigned['msg'];


//             $jsonRequest = [
//                 'ambiente' => $empresa->ambiente,
//                 'idEnvio' => 1,
//                 'version' => 1,
//                 'tipoDte' => $tipoDTE,
//                 "documento" => $documento,
//                 "codigoGeneracion" => Generator::generateCodeGeneration(),
//                 "nitEmisor" => $empresa->nit
//             ];

//             $requestResponse = Http::withHeaders([
//                 'Authorization' => $empresa->token_mh,
//                 'User-Agent' => 'ApiLaravel/1.0',
//                 'Content-Type' => 'application/JSON'
//             ])->post($url . "fesv/recepciondte", $jsonRequest);

//             $responseData = $requestResponse->json();
//             $statusCode = $requestResponse->status();

//             //415 Unsupported Media Type
//             if ($statusCode == 415)
//                 $responseData = DteCodeValidator::code415($responseData);
//             // 401 Unauthorized de parte de login hacienda.
//             if ($statusCode == 401)
//                 $responseData = DteCodeValidator::code401();

//             if ($statusCode == 404)
//                 $responseData = DteCodeValidator::code404();

//             if ($statusCode >= 400) {
//                 $errorMessage = "Error $statusCode: " . json_encode($responseData);
//                 throw new Exception($errorMessage);
//             }
//             $registroDTE = RegistroDTE::create([
//                 'id_cliente' => $idCliente,
//                 'numero_dte' => $numeroDTE,
//                 'tipo_documento' => $tipoDTE,
//                 'dte' => json_encode($newDTE),
//                 'estado' => true,
//                 'empresa_id' => $empresa->id
//             ]);
//             Generator::saveNumeroControl($tipoDTE);

//             return response()->json($responseData, $statusCode);
//         } catch (Exception $e) {
//             $logDTE = LogDTE::create([
//                 'id_cliente' => $idCliente,
//                 'numero_dte' => $numeroDTE,
//                 'tipo_documento' => $tipoDTE,
//                 'fecha' => $fechaEmision,
//                 'hora' => $horaEmision,
//                 'error' => $e->getMessage(),
//                 'estado' => false,
//                 'empresa_id' => $empresa->id
//             ]);

//             $logDTE->save();
//             return response()->json($responseData, $statusCode);
//         }
//     }
}
