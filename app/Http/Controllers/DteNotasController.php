<?php

namespace App\Http\Controllers;

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
use App\Help\DTEHelper\NOTACREDITODTE;

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
use App\Models\LogDTE;
use App\Models\RegistroDTE;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;

class DteNotasController extends Controller{

    public function enviarNotaCreditoUnitaria(Request $request)
    {

         //PASO 1 , HACER LOGIN EN HACIENDA
         $responseLogin = LoginMH::login();
         if ($responseLogin['code'] != 200)
             return response()->json(DteCodeValidator::code404($responseLogin['error']), 404);


         //PASO 2 OBTENER INFORMACION Y DESFRAGMENTARLA
         $body = json_decode($request->getContent(), true);
         $dte = $body['dteJson']; //OBTENER EL DTE
         $newDTE = [];
         $tipoDTE = '05';
         $numeroDTE = Generator::generateNumControl($tipoDTE);
         $fechaEmision = Carbon::now()->format('Y-m-d');
         $horaEmision = Carbon::now()->format('H:i:s'); //24 horas

         $empresa = Help::getEmpresa();
         $url = Help::mhUrl();

         //PASO 3 GENERAR JSON VALIDO PARA  HACIENDA
         $identificacion = Identificacion::identidad('05');
         $emisor = Identificacion::emisor('05', null, null, null);
         $receptor = Identificacion::receptorNotaCredito($dte['receptor']);

         $newDTE['extension'] = NOTACREDITODTE::extension("obj");
         $newDTE['receptor'] = $receptor;
         $newDTE['identificacion'] = $identificacion;
         return $newDTE;
     /*    $newDTE['resumen'] = FACTDTE::Resumen($dte['cuerpoDocumento'], $codigoPago, $periodoPago, $plazoPago, $body['forma_pago'], $body['numPagoElectronico']);

         $newDTE['cuerpoDocumento'] = $dte['cuerpoDocumento'];
         $newDTE['otrosDocumentos'] = $dte['otrosDocumentos'] ?? null;
         $newDTE['ventaTercero'] = $dte['ventaTercero'] ?? null;
         $newDTE['apendice'] = $dte['apendice'] ?? null;
         if (array_key_exists('documentoRelacionado', $dte))
             $newDTE['documentoRelacionado'] = $dte['documentoRelacionado'];
         else
             $newDTE['documentoRelacionado'] = null;

         $newDTE['emisor'] = $emisor;

         try {
             $idCliente = Help::getClienteId($dte['receptor']['numDocumento']);

             $DTESigned = FirmadorElectronico::firmador($newDTE);

             $statusSigner =  $DTESigned['status'];

             if ($statusSigner > 201)
                 return response()->json([
                     "error" => $DTESigned['error']
                 ], $statusSigner);

             $documento = $DTESigned['msg'];


             $jsonRequest = [
                 'ambiente' => $empresa->ambiente,
                 'idEnvio' => 1,
                 'version' => 1,
                 'tipoDte' => $tipoDTE,
                 "documento" => $documento,
                 "codigoGeneracion" => Generator::generateCodeGeneration(),
                 "nitEmisor" => $empresa->nit
             ];

             $requestResponse = Http::withHeaders([
                 'Authorization' => $empresa->token_mh,
                 'User-Agent' => 'ApiLaravel/1.0',
                 'Content-Type' => 'application/JSON'
             ])->post($url . "fesv/recepciondte", $jsonRequest);

             $responseData = $requestResponse->json();
             $statusCode = $requestResponse->status();

             //415 Unsupported Media Type
             if ($statusCode == 415)
                 $responseData = DteCodeValidator::code415($responseData);
             // 401 Unauthorized de parte de login hacienda.
             if ($statusCode == 401)
                 $responseData = DteCodeValidator::code401();

             if ($statusCode == 404)
                 $responseData = DteCodeValidator::code404();

             if ($statusCode >= 400) {
                 $errorMessage = "Error $statusCode: " . json_encode($responseData);
                 throw new Exception($errorMessage);
             }
             $registroDTE = RegistroDTE::create([
                 'id_cliente' => $idCliente,
                 'numero_dte' => $numeroDTE,
                 'tipo_documento' => $tipoDTE,
                 'dte' => json_encode($newDTE),
                 'estado' => true,
                 'empresa_id' => $empresa->id
             ]);
             Generator::saveNumeroControl($tipoDTE);

             return response()->json($responseData, $statusCode);
         } catch (Exception $e) {
             $logDTE = LogDTE::create([
                 'id_cliente' => $idCliente,
                 'numero_dte' => $numeroDTE,
                 'tipo_documento' => $tipoDTE,
                 'fecha' => $fechaEmision,
                 'hora' => $horaEmision,
                 'error' => $e->getMessage(),
                 'estado' => false,
                 'empresa_id' => $empresa->id
             ]);

             $logDTE->save();
             return response()->json($responseData, $statusCode);
         }*/
    }
}
