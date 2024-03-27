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
use App\help\FirmadorElectronico;
use App\help\Generator;
use App\Help\LoginMH;
use Monolog\Handler\FirePHPHandler;
use JsonSchema\Validator;
use App\Mail\DteMail;
use Illuminate\Support\Facades\Mail;

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

        $dteFirmado = FirmadorElectronico::firmadorNew($request);

        //$dteFirmado = FirmadorElectronico::firmador($dteJson);

        if ($dteFirmado["status"] > 201)
            return response()->json($dteFirmado, $dteFirmado["status"]);


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
        $identificacion['horEmi'] = date('h:i:s');
        $identificacion['tipoMoneda'] = "USD";

        $newDTE['identificacion'] = $identificacion;

        // EMISOR
        if (array_key_exists('emisor', $dte))
            $newDTE['emisor'] = $dte['emisor'];
        else
            $newDTE['emisor'] = Help::getEmisorDefault();

        // DOCUMENTO RELACIONADO
        if (array_key_exists('emisor', $dte))
            $newDTE['documentoRelacionado'] = $dte['documentoRelacionado'];
        else
            $newDTE['documentoRelacionado'] = null;

        //  RECEPTOR
        $newDTE['receptor'] = $dte['receptor'];

        $newDTE['otrosDocumentos'] = $dte['otrosDocumentos'];
        $newDTE['ventaTercero'] = $dte['ventaTercero'];

        // Cuerpo Documento
        $totalNoSuj = 0;
        $totalExenta = 0;
        $subTotal = 0;
        $totalDescu = 0;
        $totalPagar = 0;

        $totalImpuestos = 0;
        $tributos = [];
        $pagos = [];

        $newDTE['cuerpoDocumento'] = $dte['cuerpoDocumento'];

        foreach ($dte['cuerpoDocumento'] as $key => $value) {

            $ventaGravada = $value['cantidad'] * $value['precioUni'];
            $totalNoSuj += $value['ventaNoSuj'];
            $totalExenta += $value['ventaExenta'];
            $subTotal += $ventaGravada;
            $totalDescu += $value['montoDescu'];
            $dte['cuerpoDocumento'][$key]['ventaGravada'] = $ventaGravada;

            foreach($value['tributos'] as $tributo){

                $encontrado = false;

                $impuesto = Help::getTax($tributo, $subTotal);

                foreach($tributos as $clave => $valor){

                    $codigo = $valor['codigo'];

                    if( $codigo == $tributo ){
                        $encontrado = true;
                        $tributos[$clave]['valor'] += $impuesto ;
                        break;
                    }

                }

                if( !$encontrado ){
                    $tributos[] = [
                        'codigo' => $tributo,
                        'descripcion' => Help::getTributo($value),
                        'valor' => $impuesto
                    ];
                }

                $$totalImpuestos += $impuesto;

            }

            $totalNoSuj += $value['ventaNoSuj'];
            $totalNoSuj += $value['ventaNoSuj'];
            $totalNoSuj += $value['ventaNoSuj'];


        }

        $totalPagar = $subTotal += $totalImpuestos;

        // RESUMEN CUERPO
        $newDTE['resumen']['totalNoSuj'] = $totalNoSuj;
        $newDTE['resumen']['totalExenta'] = $totalExenta;
        $newDTE['resumen']['totalGravada'] = $subTotal;
        $newDTE['resumen']['subTotalVentas'] = $subTotal;
        $newDTE['resumen']['descuNoSuj'] = 0;
        $newDTE['resumen']['descuExenta'] = 0;
        $newDTE['resumen']['descuGravada'] = 0;
        $newDTE['resumen']['porcentajeDescuento'] = 0;

        $newDTE['resumen']['totalDescu'] = $totalDescu;
        $newDTE['resumen']['subTotal'] = $subTotal;
        $newDTE['resumen']['ivaPerci1'] = 0;
        $newDTE['resumen']['ivaRete1'] = 0;
        $newDTE['resumen']['reteRenta'] = 0;
        $newDTE['resumen']['montoTotalOperacion'] = $totalPagar;
        $newDTE['resumen']['totalNoGravado'] = 0;

        $newDTE['resumen']['totalPagar'] = $totalPagar;
        $newDTE['resumen']['totalLetras'] = 'zero zero';
        $newDTE['resumen']['saldoFavor'] = 0;
        $newDTE['resumen']['condicionOperacion'] = 1;
        $newDTE['resumen']['pagos'] = $pagos;
        $newDTE['resumen']['numPagoElectronico'] = $null;



        $newDTE['extension'] = $dte['extension'];
        $newDTE['apendice'] = $dte['apendice'];

        // $dte['identificacion'] = $identificacion;


        return response()->json($newDTE);

        $jsonRequest = [
            'ambiente' => "00",
            'idEnvio' => 1,
            'version' => 3,
            'tipoDte' => "03",
            "documento" => $newDTE,
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
        $correo = new DteMail();
        Mail::to('francisco.navas@datasys.la')->send($correo);
    }
}
