<?php

namespace App\Help\Services;

use App\Help\DteCodeValidator;
use App\Help\FirmadorElectronico;
use App\Help\Generator;
use App\help\Help;
use App\Models\InvalidacionDte;
use App\Models\LogDTE;
use App\Models\RegistroDTE;
use Exception;
use Illuminate\Support\Facades\Http;

class InvalidarDte
{

    public static function invalidar($dte)
    {
        $empresa = Help::getEmpresa();
        $url = Help::mhUrl();

        $codigoGeneracion = $dte['documento']['codigoGeneracion'];
        $registroDte = RegistroDTE::where('codigo_generacion', $codigoGeneracion)->first();

        $documento = $dte['documento']; 
        $dteNum = $documento['numeroControl'];
        $identificacion = $dte['identificacion'];
   

        $tipoDTE = $documento['tipoDte'];
        $fechaEmision = $identificacion['fecAnula'];
        $horaEmision = $identificacion['horAnula'];
        $version = $identificacion['version'];
        $responseData = null;
        $statusCode = null;

        $codigoGeneracionDte = $identificacion['codigoGeneracion'];

        try {
            
            $DTESigned = FirmadorElectronico::firmador($dte);

            $ambiente = Help::getEmpresa()?->ambiente;
            $idEnvio = 1;
            $version = 2;
            $documento = $DTESigned['msg'];


           
            $jsonRequest = compact("ambiente", "idEnvio", "version", "documento");

            $requestResponse = Http::withHeaders([
                'Authorization' => $empresa->token_mh,
                'User-Agent' => 'ApiLaravel/1.0',
                'Content-Type' => 'application/JSON'
            ])->post($url . "fesv/anulardte", $jsonRequest);

            $responseData = $requestResponse->json();
            $statusCode = $requestResponse->status();

            if ($statusCode >= 400) {
                $responseData = self::handleErrorResponse($statusCode, $responseData);
                throw new Exception("Error $statusCode: " . json_encode($responseData));
            }

            $dteInvalidado = InvalidacionDte::create([
                'respuesta' => json_encode($responseData),
                'codigo_generacion' => $codigoGeneracionDte,
                //documento firmado
                'dte_firmado' => $documento,
                'sello' => $responseData['selloRecibido'],
                'dte' => json_encode($dte),
            ]);

            $registroDte->invalidacion_id = $dteInvalidado->id;
            $registroDte->save();

        } catch (Exception $e) {
            LogDTE::create([
                'empresa_id' => $empresa->id,
                'id_cliente' => $registroDte->id_cliente,
                'codigo_generacion' => $identificacion['codigoGeneracion'],
                'tipo_documento' => $tipoDTE,
                'fecha' => $fechaEmision,
                'hora' => $horaEmision,
                'error' => $e->getMessage(),
                'numero_dte'=> $dteNum,
                'estado' => false,
            ])->save();
        } 

        return [$responseData, $statusCode];
    }

    private static function handleErrorResponse($statusCode, $responseData)
    {
        switch ($statusCode) {
            case 415:
                return DteCodeValidator::code415($responseData);
            case 401:
                return DteCodeValidator::code401();
            case 404:
                return DteCodeValidator::code404();
            default:
                return $responseData;
        }
    }
}
