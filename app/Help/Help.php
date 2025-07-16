<?php

namespace App\help;

use App\Models\Cliente;
use App\Models\Config;
use App\Models\Empresa;
use App\Models\MH\MHFormaPago;
use App\Models\MH\MHTributo;
use App\Models\RegistroDTE;
use App\Models\MH\MH_tipo_documento;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\MH\MHActividadEconomica;
use Illuminate\Support\Facades\Crypt;
use App\Models\MH\MHDepartamento;
use App\Models\MH\MHMunicipio;
use App\Models\MH\MHTipoDocumento;
use App\Models\MH\MHTipoEstablecimiento;

class Help
{

    public static function pdfActividadEconomicadatos($codigo_act)
    {
        $datos_actividad_economica = MHActividadEconomica::where('codigo', $codigo_act)->first();

        if ($datos_actividad_economica->id)
            return $datos_actividad_economica;
            //return $datos_dte->sello;



        return 'CODIGO DE ACTIVIDAD NO EXISTE';
    }

   

    public static function getDatosDocumento($codigo_documento)
    {
        $datos_documento = MHTipoDocumento::where('codigo', $codigo_documento)->first();

        if ($datos_documento->codigo)
            return $datos_documento;
            //return $datos_documento->codigo;



        return 'TIPO DOCUMENTO NO EXISTE';
    }



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

    
    public static function getEmpresaByCript()
    {
        $usuario = Auth::user();
        $empresa  =  Empresa::find($usuario->empresa_id);
        $empresaNombreComercial = $empresa->nombre_comercial;
        $nit = Crypt::decryptString($empresa->nit);
        $nrc = Crypt::decryptString($empresa->nrc);
        $nombreEmpresa = Crypt::decryptString($empresa->nombre);
        $telefono = Crypt::decryptString($empresa->telefono);
        $correo = Crypt::decryptString($empresa->correo_electronico);

        $departamento = MHDepartamento::where('codigo', $empresa->departamento)->first()?->valor;
        $municipio = MHMunicipio::where('codigo', $empresa->municipio)->first()?->valor;
        $direccion = $empresa->direccion;
        $codigoEsta = $empresa->codigo_establecimiento;
        $codigoEstablecimientoNombre = MHTipoEstablecimiento::where('codigo', $empresa->codigo_establecimiento)->first()?->valor;
        $codgoAcividad = $empresa->codigo_actividad;
        $codigoActividadNombre = MHActividadEconomica::where('codigo', $empresa->codigo_actividad)->first()?->valor;

        return array(
            'usuario'=> $usuario,
            'empresa_nombre_comercial'=> $empresaNombreComercial,
            'nit'=> $nit,
            'nrc'=> $nrc,
            'nombre_empresa'=> $nombreEmpresa,
            'telefono'=> $telefono,
            'correo'=> $correo,
            'departamento'=> $departamento,
            'municipio'=> $municipio,
            'direccion'=> $direccion,
            'codigo_estableclimiento'=> $codigoEsta,
            'codigo_estableclimiento_nombre'=> $codigoEstablecimientoNombre,
            'codgo_acividad'=> $codgoAcividad,
            'codigoActividad_nombre'=> $codigoActividadNombre,
             'ambiente'=> $empresa->ambiente,
             'correlativo_fex'=> $empresa->correlativo_fex,
             'correlativo_ccf'=> $empresa->correlativo_ccf, 
             'correlativo_cl'=> $empresa->correlativo_cl, 
             'correlativo_cd'=> $empresa->correlativo_cd, 
             'correlativo_cr'=> $empresa->correlativo_cr,
             'correlativo_dcl'=> $empresa->correlativo_dcl,
             'correlativo_fse'=> $empresa->correlativo_fse,    
        );

    }
    
    public static function getUsuario(){
        return Auth::user();
    }

    public static function getEmisorDefault()
    {
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

    public static function getTributo($codigo)
    {
        $tributo = MHTributo::where('codigo', $codigo)->first();

        if ($tributo->id)
            return $tributo->valor;

        return 'Sin descripcion';
    }

    public static function getTax($codigo, $subtotal, $totalGalones = 0)
    {

        $tributo = MHTributo::where('codigo', $codigo)->first();

        if (!$tributo->id)
            return 0;

        $retorno = 0;

        $porcentaje = $tributo->porcentaje;

        switch ($tributo->codigo) {
            case '20':
            case 'C3':
            case '59':
                $retorno = $subtotal * $porcentaje;
                break;
        }

        return $retorno;
    }

    public static function numberToString($numero)
    {
        $conversion = array(
            0 => 'cero',
            1 => 'uno',
            2 => 'dos',
            3 => 'tres',
            4 => 'cuatro',
            5 => 'cinco',
            6 => 'seis',
            7 => 'siete',
            8 => 'ocho',
            9 => 'nueve'
        );

        $decenas = array(
            2 => 'veinte',
            3 => 'treinta',
            4 => 'cuarenta',
            5 => 'cincuenta',
            6 => 'sesenta',
            7 => 'setenta',
            8 => 'ochenta',
            9 => 'noventa'
        );

        $centenas = array(
            1 => 'ciento',
            2 => 'doscientos',
            3 => 'trescientos',
            4 => 'cuatrocientos',
            5 => 'quinientos',
            6 => 'seiscientos',
            7 => 'setecientos',
            8 => 'ochocientos',
            9 => 'novecientos'
        );

        if ($numero < 10) {
            return $conversion[$numero];
        } elseif ($numero < 20) {
            $conversion_especial = array(
                10 => 'diez',
                11 => 'once',
                12 => 'doce',
                13 => 'trece',
                14 => 'catorce',
                15 => 'quince',
                16 => 'dieciséis',
                17 => 'diecisiete',
                18 => 'dieciocho',
                19 => 'diecinueve'
            );
            return $conversion_especial[$numero];
        } elseif ($numero < 100) {
            $decena = floor($numero / 10);
            $unidad = $numero % 10;

            $texto = $decenas[$decena];

            if ($unidad == 0) {
                return $texto;
            } else {
                return $texto . ' y ' . $conversion[$unidad];
            }
        } elseif ($numero < 1000) {
            $centena = floor($numero / 100);
            $resto = $numero % 100;

            if ($resto == 0) {
                return $centenas[$centena];
            } else {
                return $centenas[$centena] . ' ' . Help::numberToString($resto);
            }
        } elseif ($numero < 1000000) {
            $millar = floor($numero / 1000);
            $resto = $numero % 1000;

            if ($resto == 0) {
                return Help::numberToString($millar) . ' mil';
            } else {
                return Help::numberToString($millar) . ' mil ' . Help::numberToString($resto);
            }
        }
    }

    public static function getPayWay($way)
    {
        $forma = MHFormaPago::where('codigo', $way)->first();

        if ($forma!=null) {
            return $forma->valor;
        }

        return null;
    }

    public static function getClienteId($numDocumento)
    {

        $cliente = Cliente::where('nit', $numDocumento)->orWhere('dui', $numDocumento)->first();

        if ($cliente == null)
            throw new Exception("No existe ningun registro para cliente con nit/dui $numDocumento");

        // return $cliente->id;
        return [
            'id' => $cliente->id,
            'tipoCliente' => $cliente->id_tipo_cliente
        ];
    }

    //ccf y sujeto excluido
    public static function ValidarCliente($numDocumento, $clienteF)
    {

        $cliente = Cliente::where('nit', $numDocumento)->orWhere('dui', $numDocumento)->first();

        if($cliente ==null){
            $cliente = Cliente::create([
                'nit'=> $clienteF['nit']??null,
                'nrc'=> $clienteF['nrc']??null,
                'dui'=> $clienteF['dui']??null,
                'nombre'=> $clienteF['nombre']?? "Sin nombre",
                'codigo_actividad'=> $clienteF['codActividad']??null,
                'descripcion_actividad'=> $clienteF['descActividad']??null,
                'nombre_comercial'=> $clienteF['nombreComercial']??null,
                'departamento'=>  $clienteF['direccion']['departamento']??null,
                'municipio'=> $clienteF['direccion']['municipio']??null,
                'complemento'=> $clienteF['direccion']['complemento']??null,
                'telefono'=> $clienteF['telefono']??null,
                'correo'=> $clienteF['correo']??null,
                'estado'=> 1,
            ]);
        }
        return [
            'id' => $cliente->id,
            'tipoCliente' => $cliente->id_tipo_cliente
        ];
    }


    public static function ValidarClienteFex($numDocumento, $clienteF)
    {
        $cliente = null;
        $dui = null;
        $nit = null;
        if($clienteF['tipoDocumento']== '37'){ //otro doc
            $cliente = Cliente::where('otro_documento', $clienteF['numDocumento'])->first();
        }

        if($clienteF['tipoDocumento']== '13'){ //dui
            $cliente = Cliente::where('otro_documento', $clienteF['numDocumento'])->first();
            if($cliente == null){
                $cliente = Cliente::where('dui', $clienteF['numDocumento'])->first();
            }
            $dui = $clienteF['numDocumento'];
        }

        
        if($clienteF['tipoDocumento']== '36'){ //nit
            $cliente = Cliente::where('otro_documento', $clienteF['numDocumento'])->first();
            if($cliente == null){
                $cliente = Cliente::where('nit', $clienteF['numDocumento'])->first();
            }
            $nit = $clienteF['numDocumento'];
        }

        

       

        if($cliente ==null){
            $cliente = Cliente::create([
                'nit'=> $nit??null,
                'nrc'=> $clienteF['nrc']??null,
                'dui'=> $dui??null,
                'otro_documento'=> $clienteF['doc']??null,
                'tipo_documento'=> $clienteF['tipoDocumento']??null,
                'nombre'=> $clienteF['nombre']?? "Sin nombre",
                'codigo_actividad'=> $clienteF['codActividad']??null,
                'descripcion_actividad'=> $clienteF['descActividad']??null,
                'nombre_comercial'=> $clienteF['nombreComercial']??null,
                'departamento'=>  $clienteF['direccion']['departamento']??null,
                'municipio'=> $clienteF['direccion']['municipio']??null,
                'complemento'=> $clienteF['direccion']['complemento']??null,
                'telefono'=> $clienteF['telefono']??null,
                'correo'=> $clienteF['correo']??null,
                'estado'=> 1,
            ]);
        }
        return [
            'id' => $cliente->id,
            'tipoCliente' => $cliente->id_tipo_cliente
        ];
    }





    //factura
    public static function ValidarClienteByEmail($numDocumento,$correo, $clienteF)
    {
        $cliente = Cliente::where('nit', $numDocumento)->orWhere('dui', $numDocumento)->first();
        if($cliente == null){
            $cliente = Cliente::where('correo', $correo)->first();
        }
        
        if($cliente ==null){
            $cliente = Cliente::create([
                'nit'=> $clienteF['nit']??null,
                'nrc'=> $clienteF['nrc']??null,
                'dui'=> $clienteF['dui']??null,
                'nombre'=> $clienteF['nombre'],
                'codigo_actividad'=> $clienteF['codActividad'],
                'descripcion_actividad'=> $clienteF['descActividad'] ?? MHActividadEconomica::where('codigo', $clienteF['codActividad'])->first()?->valor,
                'nombre_comercial'=> $clienteF['nombreComercial'],
                'departamento'=>  $clienteF['direccion']['departamento'],
                'municipio'=> $clienteF['direccion']['municipio'],
                'complemento'=> $clienteF['direccion']['complemento'],
                'telefono'=> $clienteF['telefono'],
                'correo'=> $clienteF['correo']??null,
                'estado'=> 1,
            ]);
        }
        return [
            'id' => $cliente->id,
            'tipoCliente' => $cliente->id_tipo_cliente
        ];
    }

}
