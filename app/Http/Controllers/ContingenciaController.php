<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Help\LoginMH;
use App\Help\Generator;
use App\Help\Help;
use App\Models\LogDTE;
use App\Models\RegistroDTE;
use App\Help\FirmadorElectronico;
use  App\Help\DTEIdentificacion\Identificacion;
use App\Help\Services\DteApiMHService;
use App\Http\Resources\RegistroDTEResource;

class ContingenciaController extends Controller
{

    public function sendContingencia(Request $request){
        $responseLogin = LoginMH::login();
        $empresa = Help::getEmpresa();
        
        if ($responseLogin['code'] != 200) {
            $codigo = Generator::contingencia();
            LogDTE::create([
                'empresa_id' => $empresa->id,
                'id_cliente' => null,
                'numero_dte' => $codigo,
                'codigo_generacion'=> $codigo,
                'tipo_documento' => "contingencia",
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s'),
                'error' => "Se intento generar la contingencia sin embargo no hay respuesta de MH, por lo que se concluye que
                    posiblemente el servidor de MH no este funcionando correctamente",
                'estado' => false,
            ])->save();
        }else{

            $registro = RegistroDTE::where('estado',false)
            ->whereIn('tipo_documento',['01','03','04','05','06','07','08','09','11','14','15'])
            ->where('contingencia'  ,null)->orderBy('id', 'desc')->get();


            //FIRMARLOS
            $detallesC = array();
            foreach ($registro as $key => $value) {
                if($value->dte_firmado == null){
                    $json = json_decode($value->dte, true);
                    $value->dte_firmado = FirmadorElectronico::firmador($json );
                    $value->save();

                }

                array_push($detallesC, [
                    "noItem"=> $key+1,
                    "codigoGeneracion" => $value->codigo_generacion,
                    "tipoDoc"=> $value->tipo_documento
                ]);
            }
           
            //Codigo para contingencia.
            $identificacion = Identificacion::identidadContingencia(3);
            $emisor =Identificacion::emisorContingencia($request->responsable,$request->duiResponsable) ;
            $motivo = [
                "fInicio"=> date('Y-m-d'),
                "fFin"=> date('Y-m-d'),
                "hInicio"=>date('H:i:s'),
                "hFin"=> "23:00:00",
                "tipoContingencia"=> 1,
                "motivoContingencia"=> "No disponibilidad de sistema del MH"
            ];

            $dte = [
                "identificacion"=> $identificacion,
                "emisor"=> $emisor,
                "detalleDTE"=>  $detallesC,
                "motivo"=> $motivo
            ];


            $responseData = "No hay contingencia por ejecutar";
            $statusCode = 200;

            if(count( $detallesC)>0){
                [$responseData, $statusCode] = DteApiMHService::contingencia(  $dte, $identificacion, 'contingencia', $registro );
            }

            //vamos a ejecutar los DTE en contingencia pasados y actuales
            $registro = RegistroDTE::where('estado',false)
            ->whereIn('tipo_documento',['01','03','04','05','06','07','08','09','11','14','15'])
            ->where('contingencia', '!=', null)->orderBy('id', 'desc')->get();


            $arrayDteProcesadosResponse = array();
            foreach ($registro as $key => $value) {

               //hacemos el reenvio.
               $respuesta =  DteApiMHService::resend( $value->dte, $value, null );
               array_push($arrayDteProcesadosResponse, $respuesta);

                //validando para dar por liquidada la contingencia, se bussca la contingencia
                //en proceso que es el del dte procesado, 

                if($respuesta['procesadoEnReenvio']){

                   $value->estado = true;
                   $value->response = json_encode($respuesta['responseData']);
                   $value->save();
            

                    $registroSinProcesarContingenciaEnCola = RegistroDTE::where('estado',false)
                    ->whereIn('tipo_documento',['01','03','04','05','06','07','08','09','11','14','15'])
                    ->where('contingencia', $value->contingencia)->orderBy('id', 'asc')->get();
      
                    if(count($registroSinProcesarContingenciaEnCola) ==0){
                      $contingenciaEnCola= RegistroDTE::where('sello', $value->contingencia)
                      ->where('tipo_documento', 'contingencia')->where('estado', false)->first();
                      if($contingenciaEnCola!= null){
                          $contingenciaEnCola->estado = true;
                          $contingenciaEnCola->save();
                      }
      
                      $contingenciaEnColaLog = LogDTE::where('codigo_generacion', $value->contingencia)
                      ->where('tipo_documento', 'contingencia')->where('estado', false)->get();
                      if(count($contingenciaEnColaLog)>0){
                          foreach ($contingenciaEnColaLog as $key => $colaLog) {
                              $colaLog->estado = true;
                              $colaLog->save();
                          }
                      }
                    }


              


              }

            }
           
           

            $mailInfo = array(
                'responseData'=>$responseData,
                'statusCode'=>$statusCode,
                'dte'=> $dte,
                'fecEmi'=> $identificacion['fTransmision'],
                'horEmi'=> $identificacion['hTransmision'],
                'codigoGeneracion'=> $identificacion['codigoGeneracion'],
                "dteEnviadosEnContingencia"=> $arrayDteProcesadosResponse
            );
    
            return response()->json(
                $mailInfo
                , $statusCode);
            
        }
    }
}