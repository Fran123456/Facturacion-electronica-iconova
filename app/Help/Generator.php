<?php

namespace App\help;

use App\Models\Config;

class Generator
{

    public static function generateNumControl($tipoDoc, $codigoEmpresa = "EIV6XMQ0")
    {
        $registroContadorDTE = Config::where('key_conf', $tipoDoc)->first();

        if ($registroContadorDTE) {

            $contadorDTEs = $registroContadorDTE->valor;

            $contadorDTEs += 1;

            $generated = "DTE-" . $tipoDoc . '-' . $codigoEmpresa;
            $digitos = str_pad($contadorDTEs, 15, "0", STR_PAD_LEFT);
            $generated .= '-' . $digitos;

            $registroContadorDTE->valor = $contadorDTEs;
            $registroContadorDTE->save();

            return $generated;
        }

        return null;
    }

    public static function generateCodeGeneration(){
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $generatedCode = '';

        $lengthSections = [8,4,4,4,12];
        $lengthChars = strlen($characters) - 1;

        $loops = count($lengthSections);


        for( $i = 0; $i < $loops; $i++ ){

            for( $j = 0; $j < $lengthSections[$i]; $j++ ){

                $generatedCode .= $characters[rand(0, $lengthChars)];

            }

            $nextStep = ($i + 1);

            if ( $nextStep != $loops )
                $generatedCode .= '-';
        }

        return $generatedCode;
    }
}
