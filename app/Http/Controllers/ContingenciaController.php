<?php

namespace App\Http\Controllers;

use App\Help\Services\ConsultaDte;
use App\Http\Requests\ConsultaDteRequest;
use Illuminate\Http\Request;
use App\Help\LoginMH;
use App\Help\Generator;
use App\Help\Help;
use App\Models\LogDTE;
use App\Models\RegistroDTE;
use App\Help\FirmadorElectronico;
use  App\Help\DTEIdentificacion\Identificacion;
use App\Help\Services\DteApiMHService;

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

            $registro = RegistroDTE::where('estado',false)->where('contingencia'  ,null)->orderBy('id', 'desc')->get();


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

            [$responseData, $statusCode] = DteApiMHService::contingencia(  $dte, $identificacion, 'contingencia', $registro );

           
            
            $mailInfo = array(
                'responseData'=>$responseData,
                'statusCode'=>$statusCode,
                'dte'=> $dte,
                'fecEmi'=> $identificacion['fTransmision'],
                'horEmi'=> $identificacion['hTransmision'],
                'codigoGeneracion'=> $identificacion['codigoGeneracion'],
            );
    
           
    
            return response()->json(
                $mailInfo
                , $statusCode);
            
        }
    }
}