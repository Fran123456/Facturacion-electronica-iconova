<?php

namespace App\Help\Services;

use Illuminate\Support\Facades\Http;
use Exception;
use App\help\Help;
use App\Help\DteCodeValidator;
use App\Help\FirmadorElectronico;
use App\Models\LogDTE;
use App\Models\RegistroDTE;
use DateTime;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DteApiMHService
{

   

    public static function FirmadorOffline($dte, $idCliente, $identificacion){
        DB::beginTransaction();
        $url = Help::mhUrl();
        $empresa = Help::getEmpresa();
        $responseData = "";
        $statusCode = 0;

        $codigoGeneracionDTE = $identificacion['numeroControl'];
        $tipoDTE = $identificacion['tipoDte'];
        $fechaEmision = $identificacion['fecEmi'];
        $horaEmision = $identificacion['horEmi'];
        $version = $identificacion['version'];

         // CREACION DEL REGISTRO DEL DTE PARA RESPALDO EN LA DB
         $registoDTE = RegistroDTE::create([
            'empresa_id' => $empresa->id,
            'id_cliente' => $idCliente,
            'codigo_generacion' => $identificacion['codigoGeneracion'] ,
            "numero_dte"=>$identificacion['numeroControl'],
            'tipo_documento' => $tipoDTE,
            'dte' => json_encode($dte),
            'estado' => false,
        ]);
        DB::commit();
        $responseData = "Error desconocido, se intento guardar de modo offline pero no se pudo firmar correctamente";
        $statusCode = 400;
        return [$responseData, $statusCode];

    }

    public static function EnviarOfflineMH($dte, $idCliente, $identificacion){
        DB::beginTransaction();
        $url = Help::mhUrl();
        $empresa = Help::getEmpresa();
        $responseData = "";
        $statusCode = 0;

        $codigoGeneracionDTE = $identificacion['numeroControl'];
        $tipoDTE = $identificacion['tipoDte'];
        $fechaEmision = $identificacion['fecEmi'];
        $horaEmision = $identificacion['horEmi'];
        $version = $identificacion['version'];

         // CREACION DEL REGISTRO DEL DTE PARA RESPALDO EN LA DB
         $registoDTE = RegistroDTE::create([
            'empresa_id' => $empresa->id,
            'id_cliente' => $idCliente,
            'codigo_generacion' => $identificacion['codigoGeneracion'] ,
            "numero_dte"=>$identificacion['numeroControl'],
            'tipo_documento' => $tipoDTE,
            'dte' => json_encode($dte),
            'estado' => true,
        ]);


       
        $registoDTE->estado = false;
        //Generar un Log por mala conexión a MH


        try {

            $DTESigned = FirmadorElectronico::firmador($dte);

            $registoDTE['dte_firmado'] =  $DTESigned ;
            if ($DTESigned['status'] > 201) {
                self::FirmadorOffline($dte, $idCliente, $identificacion);
                return;
            }
            $registoDTE->save();

            DB::commit();
            $responseData = "Se ha guardo pero sin envio exitoso a MH";
            $statusCode = 400;
            return [$responseData, $statusCode];
        } catch (Exception $e) {
            // CREAR LOG DE ERROR DE DTE
            LogDTE::create([
                'empresa_id' => $empresa->id,
                'id_cliente' => $idCliente,
                'numero_dte' => $codigoGeneracionDTE,
                'codigo_generacion'=> $identificacion['codigoGeneracion'],
                'tipo_documento' => $tipoDTE,
                'fecha' => $fechaEmision,
                'hora' => $horaEmision,
                'error' => $e->getMessage(),
                'estado' => false,
            ])->save();

            $responseData = "Error desconocido, se intento guardar de modo offline pero ha generado error";
            $registoDTE->estado = false;
            $registoDTE->response  = $responseData;
            $registoDTE->save();
            DB::commit();
            
            $statusCode = 400;
            return [$responseData, $statusCode];

        } finally {

            $registoDTE->save();
            DB::commit();
        }

    }

    public static function envidarDTE($dte, $idCliente, $identificacion)
    {
        $url = Help::mhUrl();
        $empresa = Help::getEmpresa();
        $responseData = "";
        $statusCode = 0;

     

        $codigoGeneracionDTE = $identificacion['numeroControl'];
        $tipoDTE = $identificacion['tipoDte'];
        $fechaEmision = $identificacion['fecEmi'];
        $horaEmision = $identificacion['horEmi'];
        $version = $identificacion['version'];

        // CREACION DEL REGISTRO DEL DTE PARA RESPALDO EN LA DB
        $registoDTE = RegistroDTE::create([
            'empresa_id' => $empresa->id,
            'id_cliente' => $idCliente,
            'codigo_generacion' => $identificacion['codigoGeneracion'] ,
            "numero_dte"=>$identificacion['numeroControl'],
            'tipo_documento' => $tipoDTE,
            'dte' => json_encode($dte),
            'estado' => true,
        ]);

        try {

            // FIRMAR DTE
            $DTESigned = FirmadorElectronico::firmador($dte);
            $registoDTE['dte_firmado'] =  $DTESigned ;
            if ($DTESigned['status'] > 201) {
                return response()->json(["error" => $DTESigned['error']], $DTESigned['status']);
            }
            $registoDTE->save();

            $jsonRequest = [
                'ambiente' => $empresa->ambiente,
                'idEnvio' => 1,
                'version' => $version,
                'tipoDte' => $tipoDTE,
                'documento' => $DTESigned['msg'],
                'codigoGeneracion' => $identificacion['codigoGeneracion'],
                'nitEmisor' => Crypt::decryptString($empresa->nit)
            ];

            $requestResponse = Http::withHeaders([
                'Authorization' => $empresa->token_mh,
                'User-Agent' => 'ApiLaravel/1.0',
                'Content-Type' => 'application/JSON'
            ])->post($url . "fesv/recepciondte", $jsonRequest);

            $responseData = $requestResponse->json();
            $statusCode = $requestResponse->status();

            $registoDTE['sello'] = $responseData['selloRecibido'];
           // $registoDTE['numero_dte'] = $responseData['codigoGeneracion'];

            $fechaCompleta = $responseData['fhProcesamiento'];

            // Convierte la cadena en un objeto DateTime
            $dateTime = DateTime::createFromFormat('d/m/Y H:i:s', $fechaCompleta);

            // Obtiene solo la parte de la fecha
            $fechaSolo = $dateTime->format('Y-m-d');
            // Asigna la fecha a tu variable $registoDTE['fecha_recibido']
            $registoDTE['fecha_recibido'] = $fechaSolo;
            
            // $registoDTE['descripcion_recibido'] = $responseData['descripcionMsg'];
            $registoDTE['observaciones'] = json_encode(self::observaciones($responseData['observaciones']));
            $registoDTE['response'] = $responseData;

            if ($statusCode >= 400) {
                $registoDTE->save();
                $responseData = self::handleErrorResponse($statusCode, $responseData);
                throw new Exception("Error $statusCode: " . json_encode($responseData));
            }
        } catch (Exception $e) {

            // CREAR LOG DE ERROR DE DTE
            LogDTE::create([
                'empresa_id' => $empresa->id,
                'id_cliente' => $idCliente,
                'numero_dte' => $codigoGeneracionDTE,
                'codigo_generacion'=> $identificacion['codigoGeneracion'],
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

    public static function contingencia($dte, $identificacion,$tipoDTE, $registros){
        $url = Help::mhUrl();
        $empresa = Help::getEmpresa();
        $responseData = "";
        $statusCode = 0;

        $DTESigned = FirmadorElectronico::firmador($dte);
        $registoDTE['dte_firmado'] =  $DTESigned ;
        if ($DTESigned['status'] > 201) {
                return response()->json(["error" => $DTESigned['error']], $DTESigned['status']);
        }

        $jsonRequest = [
            
            'ambiente' => $empresa->ambiente,
            'idEnvio' => 1,
            'version' => 3,
            'documento' => $DTESigned['msg'],
            'codigoGeneracion' => $identificacion['codigoGeneracion'],
            'nitEmisor' => Crypt::decryptString($empresa->nit),
            'nit' => Crypt::decryptString($empresa->nit),
        ];

        $requestResponse = Http::withHeaders([
            'Authorization' => $empresa->token_mh,
            'User-Agent' => 'ApiLaravel/1.0',
            'Content-Type' => 'application/JSON'
        ])->post($url . "fesv/contingencia", $jsonRequest);

        $responseData = $requestResponse->json();
        $statusCode = $requestResponse->status();

        if($responseData['estado'] == "RECHAZADO"){
            LogDTE::create([
                'empresa_id' => $empresa->id,
                'id_cliente' => null,
                'numero_dte' =>$identificacion['codigoGeneracion'],
                'codigo_generacion'=> $identificacion['codigoGeneracion'],
                'tipo_documento' => $tipoDTE,
                'fecha' => $identificacion['fTransmision'],
                'hora' => $identificacion['hTransmision'],
                'error' => json_encode($responseData['observaciones']) ,
                'estado' => false,
            ])->save();

        }

        $registoDTE = RegistroDTE::create([
            'empresa_id' => $empresa->id,
            'id_cliente' => null,
            'codigo_generacion' => $identificacion['codigoGeneracion'] ,
            "numero_dte"=>$identificacion['codigoGeneracion'],
            'tipo_documento' => $tipoDTE,
            'dte' => json_encode($dte),
            'dte_firmado'=>  json_encode($DTESigned) ,
            'estado' => false,
            'fecha_recibido'=>   Carbon::createFromFormat('d/m/Y H:i:s', $responseData['fechaHora'])->format('Y-m-d H:i:s'),
            'response'=>json_encode($responseData), 
            'observaciones'=> json_encode($responseData['observaciones']) ,
            'sello'=> $responseData['selloRecibido']
        ]);

         LogDTE::where('tipo_documento', 'contingencia')->where('estado', false)->update(
           [ 'estado'=>true, 'updated_at'=> now()]
         );

         if($responseData['estado'] == "RECIBIDO"){
            foreach ($registros as $key => $value) {
                $value->contingencia = $responseData['selloRecibido'] ;
                $value->save();
            }

           // $registoDTE->estado = true;
           // $registoDTE->save();
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

    private static function observaciones($observaciones){

        $obj = [];

        if ( count( $observaciones ) == 0 )
            return [];

        foreach ( $observaciones as $key => $item ){
            $obj[ "observacion" . $key + 1 ] = $item;
        }

        return $obj;

    }

    public static function resend( $dte, $idDte, $identificacion ){
        $url = Help::mhUrl();
        $empresa = Help::getEmpresa();
        $responseData = "";
        $statusCode = 0;

        $codigoGeneracionDTE = $identificacion['numeroControl'];
        $tipoDTE = $identificacion['tipoDte'];
        $fechaEmision = $identificacion['fecEmi'];
        $horaEmision = $identificacion['horEmi'];
        
        $version = $identificacion['version'];

        // CREACION DEL REGISTRO DEL DTE PARA RESPALDO EN LA DB
        $registoDTE = RegistroDTE::find( $idDte );

        $registoDTE->update([
            'dte' => json_encode($dte),
            'estado' => true,
        ]);

        try {

            // FIRMAR DTE
            $DTESigned = FirmadorElectronico::firmador($dte);
            if ($DTESigned['status'] > 201) {
                return response()->json(["error" => $DTESigned['error']], $DTESigned['status']);
            }

            $jsonRequest = [
                'ambiente' => $empresa->ambiente,
                'idEnvio' => 1,
                'version' => $version,
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

            $registoDTE['sello'] = $responseData['selloRecibido'];
            $registoDTE['numero_dte'] = $responseData['codigoGeneracion'];

            
            //oCursor.responsedata.codigogeneracion

            $fechaCompleta = $responseData['fhProcesamiento'];

            // Convierte la cadena en un objeto DateTime
            $dateTime = DateTime::createFromFormat('d/m/Y H:i:s', $fechaCompleta);

            // Obtiene solo la parte de la fecha
            $fechaSolo = $dateTime->format('Y-m-d');
            // Asigna la fecha a tu variable $registoDTE['fecha_recibido']
            $registoDTE['fecha_recibido'] = $fechaSolo;

            // $registoDTE['descripcion_recibido'] = $responseData['descripcionMsg'];
            $registoDTE['observaciones'] = json_encode(self::observaciones($responseData['observaciones']));


            // Guardando la firma electronica de MH
            // add LPSoftware

            //$registoDTE['dte_mh'] = $requestResponse; 
            $registoDTE['dte_mh'] = $DTESigned;
          
            if ($statusCode >= 400) {
                $responseData = self::handleErrorResponse($statusCode, $responseData);
                throw new Exception("Error $statusCode: " . json_encode($responseData));
            }
        } catch (Exception $e) {

            // CREAR LOG DE ERROR DE DTE
            LogDTE::create([
                'empresa_id' => $empresa->id,
                'id_cliente' => $registoDTE->id_cliente,
                'numero_dte' => $codigoGeneracionDTE,
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
}
