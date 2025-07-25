<?php

namespace App\Http\Controllers;

use App\Help\DteCodeValidator;
use App\Help\DTEIdentificacion\Invalidacion;
use App\Help\Generator;
use App\help\Help;
use App\Help\LoginMH;
use App\Help\Services\InvalidarDte;
use App\Help\Services\SendMailFe;
use App\Http\Requests\InvalidarRequest;
use App\Models\RegistroDTE;
use Illuminate\Http\Request;


class InvalidarDteController extends Controller
{
    public function invalidar(InvalidarRequest $request){

        $responseLogin = LoginMH::login();
        if ($responseLogin['code'] != 200) {
            return response()->json(DteCodeValidator::code404($responseLogin['error']), 404);
        }

        $dteRequest = $request->json()->all();

        $identificacion = Invalidacion::identificacion();
        $emisor = Invalidacion::emisor();

        $documento = $dteRequest['documento'];
        $motivo = $dteRequest['motivo'];

        $documento['codigoGeneracionR'] = null;

        $dte = compact("identificacion", "emisor", "documento", "motivo");
        
        [$responseData, $statusCode] =  InvalidarDte::invalidar($dte);


        $codigoGeneracion = $dte['documento']['codigoGeneracion'];
        $registroDte = RegistroDTE::where('codigo_generacion', $codigoGeneracion)->first();
      
        $dte = json_decode($registroDte?->dte, true);
        $mailInfo = array(
            'responseData'=>$responseData,
            'statusCode'=>$statusCode,
            'dte'=> json_decode($registroDte?->dte, true),
            'numeroControl'=>$dte['identificacion']['numeroControl'],
            'fecEmi'=> $dte['identificacion']['fecEmi'],
            'horEmi'=> $dte['identificacion']['horEmi'],
            'codigoGeneracion'=> $dte['identificacion']['codigoGeneracion'],
            'sello'=>$registroDte?->sello,
            'id'=>$registroDte?->id
        );

        
        $empresa = Help::getEmpresa();
        

        $anulado = true;
        if($responseData['estado']=="RECHAZADO"){
            $anulado = false;
        }else{
             SendMailFe::sendingInvalidacion($registroDte?->id,$empresa, $mailInfo, $dte['identificacion'],  $dte['receptor']?? $dte['sujetoExcluido']);
        }

        return response()->json([
            'responseData' => $responseData,
            'statusCode' => $statusCode,
            'anulado'=>$anulado,
        ], $statusCode);
    }


}
