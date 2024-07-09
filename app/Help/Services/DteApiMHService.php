<?php

namespace App\Help\Services;

use Illuminate\Support\Facades\Http;
use Exception;
use App\help\Help;
use App\Help\DteCodeValidator;
use App\Help\FirmadorElectronico;
use App\Models\LogDTE;
use App\Models\RegistroDTE;

class DteApiMHService
{
    public static function envidarDTE($newDTE, $idCliente, $numeroDTE, $tipoDTE, $fechaEmision, $horaEmision)
    {
        $url = Help::mhUrl();
        $empresa = Help::getEmpresa();
        $responseData = "";
        $statusCode = 0;

        // CREACION DEL REGISTRO DEL DTE PARA RESPALDO EN LA DB
        $registoDTE = RegistroDTE::create([
            'id_cliente' => $idCliente,
            'numero_dte' => $numeroDTE,
            'tipo_documento' => $tipoDTE,
            'dte' => json_encode($newDTE),
            'estado' => true,
        ]);

        try {

            // FIRMAR DTE
            $DTESigned = FirmadorElectronico::firmador($newDTE);
            if ($DTESigned['status'] > 201) {
                return response()->json(["error" => $DTESigned['error']], $DTESigned['status']);
            }

            $jsonRequest = [
                'ambiente' => $empresa->ambiente,
                'idEnvio' => 1,
                'version' => 3,
                'tipoDte' => $tipoDTE,
                'documento' => $DTESigned['msg'],
                'codigoGeneracion' => "341CA743-70F1-4CFE-88BC7E4AE72E60CB",
                'nitEmisor' => "06141802161055"
            ];

            $requestResponse = Http::withHeaders([
                'Authorization' => $empresa->token_mh,
                'User-Agent' => 'ApiLaravel/1.0',
                'Content-Type' => 'application/JSON'
            ])->post($url . "fesv/recepciondte", $jsonRequest);

            $responseData = $requestResponse->json();
            $statusCode = $requestResponse->status();

            if ($statusCode >= 400) {
                $responseData = self::handleErrorResponse($statusCode, $responseData);
                throw new Exception("Error $statusCode: " . json_encode($responseData));
            }
        } catch (Exception $e) {

            // CREAR LOG DE ERROR DE DTE

            LogDTE::create([
                'id_cliente' => $idCliente,
                'numero_dte' => $numeroDTE,
                'tipo_documento' => $tipoDTE,
                'fecha' => $fechaEmision,
                'hora' => $horaEmision,
                'error' => $e->getMessage(),
                'estado' => false,
            ])->save();

            $registoDTE->estado = false;

        } finally {

            $registoDTE->save();
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
