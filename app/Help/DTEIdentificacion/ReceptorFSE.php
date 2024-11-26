<?php

use App\Models\Cliente;

class ReceptorFSE {

    public static function cliente($receptor)
    {

        $tipoDocumento = $receptor['tipoDocumento'];
        $numeroDocumento = $receptor['numeroDocumento'];

        if ( $tipoDocumento !== "13" && $tipoDocumento !== "36" )
            return $receptor;

        $cliente = Cliente::where('nit', $numeroDocumento)->orWhere('dui', $numeroDocumento)->first();

        if( $cliente == null ){

            $cliente = [
                'tipo_documento'=> '14',
                'nombre'=> $receptor['nombre'],
                'codigo_actividad'=> $receptor['codActividad'],
                'descripcion_actividad'=> $receptor['descActividad'],
                'departamento'=>  $receptor['direccion']['departamento'],
                'municipio'=> $receptor['direccion']['municipio'],
                'complemento'=> $receptor['direccion']['complemento'],
                'telefono'=> $receptor['telefono'],
                'correo'=> $receptor['correo']??null,
            ];

            if ( $tipoDocumento == '36' ) {
                $cliente['nit'] = $numeroDocumento;
            } else {
                $cliente['dui'] = $numeroDocumento;
            }

            $cliente = Cliente::create($cliente);
        } else {

            if ( $tipoDocumento == '36' ) {
                $cliente['nit'] = $numeroDocumento;
            } else {
                $cliente['dui'] = $numeroDocumento;
            }

            $cliente->update([
                'tipo_documento'=> '07',
                'nombre'=> $receptor['nombre'],
                'codigo_actividad'=> $receptor['codActividad'],
                'descripcion_actividad'=> $receptor['descActividad'],
                'departamento'=>  $receptor['direccion']['departamento'],
                'municipio'=> $receptor['direccion']['municipio'],
                'complemento'=> $receptor['direccion']['complemento'],
                'telefono'=> $receptor['telefono'],
                'correo'=> $receptor['correo']??null,
            ]);

        }

        return $cliente;
    }



}