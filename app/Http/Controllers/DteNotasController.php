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
use App\Help\DTEIdentificacion\Receptor;
use DateTime;
use App\Models\LogDTE;
use App\Models\RegistroDTE;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;

class DteNotasController extends Controller
{

    public function enviarNotaCreditoUnitaria(Request $request)
    {

        //PASO 1 , HACER LOGIN EN HACIENDA
        $responseLogin = LoginMH::login();
        if ($responseLogin['code'] != 200)
            return response()->json(DteCodeValidator::code404($responseLogin['error']), 404);

        //PASO 2 OBTENER INFORMACION Y DESFRAGMENTARLA
        $json = json_decode($request->getContent(), true);

        if (!$json) {
            return response()->json(["error" => "DTE no válido o nulo"], Response::HTTP_BAD_REQUEST);
        }

        if ( ( isset($json['pagoTributos'] ) || $json['pagoTributos']  != null)
            && count($json['pagoTributos']) != count($json['dteJson']['cuerpoDocumento']) )
            return request()->json(401, [
                "msg" => "El campo pagoTributos tiene que tener la misma longitud que cuerpoDocumento"
            ]);

        $dte = $json['dteJson']; //OBTENER EL DTE

        $pagoTributos = $json['pagoTributos'] ?? null;

        $cliente = Help::getClienteId($dte['receptor']['nit']);
        $idCliente = $cliente['id'];
        $newDTE = [];
        $tipoDTE = '05';


        // return response()->json(Generator::generateNumControl("01"), 200);

        //PASO 3 GENERAR JSON VALIDO PARA  HACIENDA
        $identificacion = Identificacion::identidad('05', 3);


        $emisor = Identificacion::emisor($tipoDTE, null, null, null);
        [$faltan, $receptor] = Receptor::generar($dte['receptor'], $tipoDTE);

        if ( $faltan )
            return response()->json($receptor, 404);

        $documentoRelacionado = null;
        $ventaTercero = null;
        $cuerpoDocumento = CCFDTE::getCuerpoDocumento($dte['cuerpoDocumento']);

        $resumen = null;
        $extension = null;
        $apendice = null;


        //  return response()->json($dte['documentoRelacionado'], 200);
        $documentoRelacionado = NOTACREDITODTE::documentosRelacionados($dte['documentoRelacionado']);
        $ventaTercero = $dte['ventaTercero'] ?? null;
        $cuerpoDocumento =  NOTACREDITODTE::cuerpo($dte['cuerpoDocumento']);
        $resumen = NOTACREDITODTE::resumen($cuerpoDocumento, $cliente['tipoCliente'], $pagoTributos);
        $extension = $dte['extension'];
        $apendice = $dte['apendice'] ?? null;

        $newDTE = [
            "identificacion" => $identificacion,
            "documentoRelacionado" => $documentoRelacionado,
            "emisor" => $emisor,
            "receptor" => $receptor,
            "ventaTercero" => $ventaTercero,
            "cuerpoDocumento" => $cuerpoDocumento,
            "resumen" => $resumen,
            "extension" => $extension,
            "apendice" => $apendice,
        ];

        // return $newDTE;

        // PASO 4 MANDAR A HACIENDA EL NUEVO DTE FORMADO SEGUN EL DTE JSON SCHEMA DE LA DOCUMENTACION

        // return response()->json($newDTE, 200);

        [$responseData, $statusCode] = DteApiMHService::envidarDTE($newDTE, $idCliente, $identificacion);

        return response()->json($responseData, $statusCode);


    }
}
