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

class ContingenciaController extends Controller
{

    public function sendContingencia(){
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

            $registro = RegistroDTE::where('estado',false)->orderBy('id', 'desc')->get();


            //FIRMARLOS
            foreach ($registro as $key => $value) {
                if($value->dte_firmado == null){
                    $json = json_decode($value->dte, true);
                    $value->dte_firmado = FirmadorElectronico::firmador($json );
                    $value->save();
                }
            }
           
            //Codigo para contingencia.
            $identificacion = Identificacion::identidadContingencia(3);
            $emisor =Identificacion::emisor('03', '20', null) ;
            $motivo = [
                "fInicio"
            ];
            
        }
    }
}