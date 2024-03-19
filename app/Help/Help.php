<?php

namespace App\help;
use App\Models\Config;
use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;
class Help {

     public static function mhProduccion(){
        return Config::where('key_conf','AMBIENTE_API_MH_PRODUCCION')->first()->valor;
     }

     public static function urlFirmador(){
       return Config::where('key_conf',"FIRMADOR_URL_BASE")->first()?->valor;
     }

     public static function mhDev(){
       return Config::where('key_conf',"URL_MH_DTES_TEST")->first()?->valor;
     }

     public static function mhProd(){
       return Config::where('key_conf',"URL_MH_DTES")->first()?->valor;
     }

     public static  function mhUrl(){
            if(self::mhProduccion()){
                return self:: mhProd();
            }
            return self::mhDev();
     }

     public static function getEmpresa(){
      $usuario = Auth::user();
      $empresa  =  Empresa::find($usuario->empresa_id);
      return $empresa;
     }
}

