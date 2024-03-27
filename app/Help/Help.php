<?php

namespace App\help;

use App\Models\Config;
use App\Models\Empresa;
use App\Models\MH\MHTributo;
use Illuminate\Support\Facades\Auth;

class Help
{

    public static function mhProduccion()
    {
        return Config::where('key_conf', 'AMBIENTE_API_MH_PRODUCCION')->first()->valor;
    }

    public static function urlFirmador()
    {
        return Config::where('key_conf', "FIRMADOR_URL_BASE")->first()?->valor;
    }

    public static function mhDev()
    {
        return Config::where('key_conf', "URL_MH_DTES_TEST")->first()?->valor;
    }

    public static function mhProd()
    {
        return Config::where('key_conf', "URL_MH_DTES")->first()?->valor;
    }

    public static  function mhUrl()
    {
        if (self::mhProduccion()) {
            return self::mhProd();
        }
        return self::mhDev();
    }

    public static function getEmpresa()
    {
        $usuario = Auth::user();
        $empresa  =  Empresa::find($usuario->empresa_id);
        return $empresa;
    }

    public static function getEmisorDefault() {
        $emisor = [];

        $emisor['nit'] = '06141802161055';
        $emisor['nrc'] = '2496424';
        $emisor['nombre'] = 'XPERTIS, S.A de C.V.';
        $emisor['codActividad'] = '70200';
        $emisor['descActividad'] = 'Actividades de consultoría en gestión empresarial';
        $emisor['nombreComercial'] = 'Iconova Consulting Group';
        $emisor['tipoEstablecimiento'] = '20';
        $emisor['direccion']['departamento'] = '06';
        $emisor['direccion']['municipio'] = '14';
        $emisor['direccion']['complemento'] = 'Calle Los Abetos y Calle Los Bambúes #37, Col. San Francisco';
        $emisor['telefono'] = '617542485';
        $emisor['correo'] = 'contacto@iconovasv.com';
        $emisor['codEstableMH'] = 'M001';
        $emisor['codEstable'] = null;
        $emisor['codPuntoVentaMH'] = 'M001';
        $emisor['codPuntoVenta'] = null;

        return $emisor;
    }

    public static function getTributo($codigo) {
        $tributo = MHTributo::where('codigo', $codigo)->first();

        if ( $tributo->id )
            return $tributo->valor;

        return 'Sin descripcion';
    }

    public static function getTax($codigo, $subtotal, $totalGalones = 0){

        $tributo = MHTributo::where('codigo', $codigo)->first();

        if ( !$tributo->id )
            return 0;

        $retorno = 0;

        $porcentaje = $tributo->porcentaje;

        switch( $tributo->codigo ){
            case '20':
            case 'C3':
            case '59':
                $retorno = $subtotal * $porcentaje;
            break;
        }

        return $retorno;

    }

}
