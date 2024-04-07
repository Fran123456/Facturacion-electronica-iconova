<?php

namespace App\Help;

use App\Models\Config;
use App\Help\Help;

class Generator
{

    public static function saveNumeroControl($tipoDoc){
        $empresa = Help::getEmpresa();
        if ($tipoDoc == '11') {
            $empresa->correlativo_fex = (int)$empresa->correlativo_fex+1;
        }
        if ($tipoDoc == '03') {
            $empresa->correlativo_ccf =  (int) $empresa->correlativo_ccf+1;
        }
        if ($tipoDoc == '01') {
            $empresa->correlativo_fact = (int) $empresa->correlativo_fact+1;
        }
        $empresa->save();
    }

    public static function generateNumControl($tipoDoc, $codigoEmpresa = "EIV6XMQ0")
    {

        $registroContadorDTE = null;
        $empresa = Help::getEmpresa();
        if ($tipoDoc == '11') {
            $registroContadorDTE = $empresa->correlativo_fex;
        }
        if ($tipoDoc == '03') {
            $registroContadorDTE =  $empresa->correlativo_ccf;
        }
        if ($tipoDoc == '01') {
            $registroContadorDTE =  $empresa->correlativo_fact != null ? $empresa->correlativo_fact : '0';
        }

        if ($registroContadorDTE != null) {
            $contadorDTEs = (int)$registroContadorDTE;

            $contadorDTEs += 1;

            $generated = "DTE-" . $tipoDoc . '-' . $codigoEmpresa;
            $digitos = str_pad($contadorDTEs, 15, "0", STR_PAD_LEFT);
            $generated .= '-' . $digitos;

            $registroContadorDTE = $contadorDTEs;

            
            return $generated;
        }

        return null;
    }

    public static function generateCodeGeneration()
    {
        $characters = '0123456789ABCDEF';
        $generatedCode = '';

        $lengthSections = [8, 4, 4, 4, 12];
        $lengthChars = strlen($characters) - 1;

        $loops = count($lengthSections);


        for ($i = 0; $i < $loops; $i++) {

            for ($j = 0; $j < $lengthSections[$i]; $j++) {

                $generatedCode .= $characters[rand(0, $lengthChars)];
            }

            $nextStep = ($i + 1);

            if ($nextStep != $loops)
                $generatedCode .= '-';
        }

        return $generatedCode;
    }
}
