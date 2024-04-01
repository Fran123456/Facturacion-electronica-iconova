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
use App\Help\DTEHelper\CCFDTE;
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
class DteController extends Controller
{
    public function enviarDteUnitarioCCF(Request $request)
    {
        //login para generar token de hacienda.
        $responseLogin = LoginMH::login();

        if ($responseLogin['code'] != 200)
            return response()->json(DteCodeValidator::code404($responseLogin['error']), 404);

        $empresa = Help::getEmpresa();
        $url = Help::mhUrl();
        $dteJson = $request;

        if ($dteJson == null)
            return response()->json(["error" => "DTE no valido o nulo"], Response::HTTP_BAD_REQUEST);


        $body = json_decode($request->getContent(), true);
        $dte = $body['dteJson'];

        $newDTE = [];

        // IDENTICACION
        $identificacion = [];
        $identificacion['version'] = 3;
        $identificacion['ambiente'] = "00";
        $identificacion['tipoDte'] = "03";
        $identificacion['numeroControl'] =  Generator::generateNumControl('03');
        $identificacion['codigoGeneracion'] = Generator::generateCodeGeneration();
        $identificacion['tipoOperacion'] = 1;
        $identificacion['tipoModelo'] = 1;
        $identificacion['tipoContingencia'] = null;
        $identificacion['motivoContin'] = null;
        $identificacion['fecEmi'] = date('Y-m-d');
        // $identificacion['fecEmi'] = date('Y-m-d');
        $identificacion['horEmi'] = date('h:i:s');
        $identificacion['tipoMoneda'] = "USD";

        $newDTE['identificacion'] = $identificacion;

        // EMISOR
        if (array_key_exists('emisor', $dte))
            $newDTE['emisor'] = $dte['emisor'];
        else
            $newDTE['emisor'] = Help::getEmisorDefault();

        // DOCUMENTO RELACIONADO
        if (array_key_exists('documentoRelacionado', $dte))
            $newDTE['documentoRelacionado'] = $dte['documentoRelacionado'];
        else
            $newDTE['documentoRelacionado'] = null;

        //  RECEPTOR
        $newDTE['receptor'] = $dte['receptor'];

        $newDTE['otrosDocumentos'] = $dte['otrosDocumentos'];
        $newDTE['ventaTercero'] = $dte['ventaTercero'];

        // Cuerpo Documento
        $newDTE['cuerpoDocumento'] = $dte['cuerpoDocumento'];

        // RESUMEN DEL CUERPO
        $codigoPago = $body['codigo_pago'];
        $periodoPago = isset($body['periodo_pago']) ? $body['periodo_pago'] : null;
        $plazoPago = isset($body['plazo_pago']) ? $body['plazo_pago'] : null;
        $newDTE['resumen'] = CCFDTE::Resumen($dte['cuerpoDocumento'], $codigoPago, $periodoPago, $plazoPago);

        $newDTE['extension'] = $dte['extension'];
        $newDTE['apendice'] = $dte['apendice'];

        $newDTE = FirmadorElectronico::firmador($newDTE);
        // return response()->json($newDTE);

        $statusSigner =  $newDTE['status'];

        if ( $statusSigner > 201 )
            return response()->json([
                "error" => $newDTE['error']
            ], $statusSigner);

        $tokenDTE = $newDTE['msg'];

        $jsonRequest = [
            'ambiente' => "00",
            'idEnvio' => 1,
            'version' => 3,
            'tipoDte' => "03",
            "documento" => $tokenDTE,
            "codigoGeneracion" => "341CA743-70F1-4CFE-88BC7E4AE72E60CB",
            "nitEmisor" => "06141802161055"
        ];

        $requestResponse = Http::withHeaders([
            'Authorization' => $empresa->token_mh,
            'User-Agent' => 'ApiLaravel/1.0',
            'Content-Type' => 'application/JSON'
        ])->post($url . "fesv/recepciondte", $jsonRequest);

        $responseData = $requestResponse->json();
        $statusCode = $requestResponse->status();

        //415 Unsupported Media Type
        if ($statusCode == 415) return response()->json(DteCodeValidator::code415($responseData), 415);
        // 401 Unauthorized de parte de login hacienda.
        if ($statusCode == 401) return response()->json(DteCodeValidator::code401(), 401);

        return response()->json($responseData, $statusCode);
    }

    public function enviarDteUnitarioFacturaExterior(Request $request)
    {

        //login para generar token de hacienda.
        $responseLogin = LoginMH::login();

        if ($responseLogin['code'] != 200)
            return response()->json(DteCodeValidator::code404($responseLogin['error']), 404);

        $empresa = Help::getEmpresa();
        $url = Help::mhUrl();
        /*
         $dteJson = $request;

        if ($dteJson == null)
            return response()->json(["error" => "DTE no valido o nulo"], Response::HTTP_BAD_REQUEST);
        if ($dteJson['cliente'] == null)
            return response()->json(["error" => "El cliente es requerido"], Response::HTTP_BAD_REQUEST);

        //GENERAR JSON VALIDO PARA  HACIENDA
        $identificacion = Identificacion::identidad('11');
        $emisor = Identificacion::emisor('20', null, null, null);
        $receptor = Identificacion::receptor($dteJson['cliente']);
        if(isset($receptor['error']))
            return response()->json(["error" => $receptor['comentario']], Response::HTTP_BAD_REQUEST);
        $detalle = FEXDTE::BuildDetalle($dteJson['cuerpoDocumento']);
        $resumen = FEXDTE::Resumen($detalle, $dteJson['condicionPago']??'1',  $dteJson['pago']??null);
   
        $dte = [
            "identificacion"=>$identificacion,
            'emisor'=>$emisor,
            'receptor'=>$receptor,
            'otrosDocumentos'=>null,
            'ventaTercero'=>null,
            'cuerpoDocumento'=>$detalle,
            'resumen'=>$resumen ,
            'apendice'=>[FEXDTE::Apendice(),FEXDTE::Apendice()]
        ];
      // return $dte;
        */ 
       
      $dte = $request;
        $dte = FirmadorElectronico::firmador($dte);
        
        $requestResponse = Http::withHeaders([
            'Authorization' => $empresa->token_mh,
            'User-Agent' => 'ApiLaravel/1.0',
            'Content-Type' => 'application/JSON'
        ])->post($url . "fesv/recepciondte", $dte);

        $responseData = $requestResponse->json();
        $statusCode = $requestResponse->status();

        //415 Unsupported Media Type
        if ($statusCode == 415) return response()->json(DteCodeValidator::code415($responseData), 415);
        // 401 Unauthorized de parte de login hacienda.
        if ($statusCode == 401) return response()->json(DteCodeValidator::code401(), 401);

        return response()->json($responseData, $statusCode);


        $correoEmpresa = Crypt::decryptString($empresa->correo_electronico);
        $telefono = Crypt::decryptString($empresa->telefono);
        $nombreEmpresa = Crypt::decryptString($empresa->nombre);


        //$nombreCliente = 'Francisco Navas';
        //return WhatsappSender::send();

        /*  Mail::to('francisco.navas@datasys.la')
        ->from($correoEmpresa, $nombreEmpresa)
        ->send(new DteMail($nombreCliente ,  $correoEmpresa,  $telefono, "9D50E003-621E-1AB5-B828-0004AC1EA976"));

        */
    }
}
