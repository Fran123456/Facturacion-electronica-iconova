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
use App\Help\Services\SendMailFe;
use DateTime;
use App\Models\LogDTE;
use App\Models\RegistroDTE;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;

// ^ NOTAS DE CREDITO
class DteNotasController extends Controller
{

    public function enviarNotaCreditoUnitaria(Request $request)
    {

        //PASO 1 , HACER LOGIN EN HACIENDA
     /*   $responseLogin = LoginMH::login();
        if ($responseLogin['code'] != 200)
            return response()->json(DteCodeValidator::code404($responseLogin['error']), 404);*/

        //PASO 2 OBTENER INFORMACION Y DESFRAGMENTARLA
        $json = json_decode($request->getContent(), true);

        if (!$json) {
            return response()->json(["error" => "DTE no válido o nulo"], Response::HTTP_BAD_REQUEST);
        }

      /*  if ( ( isset($json['pagoTributos'] ) || $json['pagoTributos']  != null)
            && count($json['pagoTributos']) != count($json['dteJson']['cuerpoDocumento']) )
            return request()->json(401, [
                "msg" => "El campo pagoTributos tiene que tener la misma longitud que cuerpoDocumento"
            ]);
*/
        
   
        $dte = $json['dteJson']; //OBTENER EL DTE

        $pagoTributos = $json['pagoTributos'] ?? null;

        //$cliente = Help::getClienteId($dte['receptor']['nit']??$dte['receptor']['dui']);
        $cliente =Help::ValidarCliente($dte['receptor']['nit']??$dte['receptor']['dui'], $dte['receptor']);
        $idCliente = $cliente['id'];
        $newDTE = [];
        $tipoDTE = '05';

        //PASO 3 GENERAR JSON VALIDO PARA  HACIENDA
        $identificacion = Identificacion::identidad('05', 3);

        $emisor = Identificacion::emisor($tipoDTE, null, null, null);
        [$faltan, $receptor] = Receptor::generar($dte['receptor'], $tipoDTE);
      

        if ( $faltan )
            return response()->json($receptor, 404);

        $documentoRelacionado = null;
        $ventaTercero = null;

        $resumen = null;
        $extension = null;
        $apendice = null;

        $documentoRelacionado = NOTACREDITODTE::documentosRelacionados($dte['documentoRelacionado']);
        $ventaTercero = $dte['ventaTercero'] ?? null;
        $cuerpoDocumento =  NOTACREDITODTE::cuerpo($dte['cuerpoDocumento']);
        
        $resumen = NOTACREDITODTE::resumen($cuerpoDocumento, $cliente['tipoCliente'], $pagoTributos);
        $extension = $dte['extension'];
        $apendice = $dte['apendice'] ?? null;

        foreach ($cuerpoDocumento as $key => $value) {
            unset($cuerpoDocumento[$key]['ivaRetenida']);
            unset($cuerpoDocumento[$key]['iva']);
        }
        
      
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
      
        $requestCrudo = $json;
        $responseLogin = LoginMH::login();
        if ($responseLogin['code'] != 200) {
            [$responseData, $statusCod,$id] = DteApiMHService::EnviarOfflineMH( $newDTE, $idCliente, $identificacion,$requestCrudo  );
        }else{
            
            [$responseData, $statusCode, $id] = DteApiMHService::envidarDTE( $newDTE, $idCliente, $identificacion ,$requestCrudo );
        }

        

        $mailInfo = array(
            'responseData'=>$responseData,
            'statusCode'=>$statusCode,
            'dte'=> $newDTE,
            'numeroControl'=>$identificacion['numeroControl'],
            'fecEmi'=> $identificacion['fecEmi'],
            'horEmi'=> $identificacion['horEmi'],
            'codigoGeneracion'=> $identificacion['codigoGeneracion'],
            'id'=> $id,
        );
        $empresa = Help::getEmpresa();
        SendMailFe::sending($id,$empresa, $mailInfo, $identificacion, $receptor);

        return response()->json(
            $mailInfo
            , $statusCode);




       //return response()->json($responseData, $statusCode);
    }
}
