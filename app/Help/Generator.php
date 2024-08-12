<?php

namespace App\Help;

use App\Models\Config;
use App\Help\Help;

class Generator
{

    public static function saveNumeroControl($tipoDoc)
    {
        $empresa = Help::getEmpresa();
        if ($tipoDoc == '11') {
            $empresa->correlativo_fex = (int)$empresa->correlativo_fex + 1;
        }
        if ($tipoDoc == '03') {
            $empresa->correlativo_ccf =  (int) $empresa->correlativo_ccf + 1;
        }
        if ($tipoDoc == '01') {
            $empresa->correlativo_fact = (int) $empresa->correlativo_fact + 1;
        }
        if ($tipoDoc == '05') {
            $empresa->correlativo_nota_credito = (int) $empresa->correlativo_nota_credito + 1;
        }
        $empresa->save();
    }

    public static function generateNumControl($tipoDoc, $codigoEmpresa = "EIV6XMQ0")
    {

        $registroContadorDTE = null;
        // SE OBTIENEN LOS DATOS DE LOS DTE GENERADOS POR LAS EMPRESAS
        $empresa = Help::getEmpresa();


        // SE TOMA EL TOTAL DE DTE GENERADOS DEL TIPO A GENERAR Y SE LE SUMA 1 PARA PODER GENERAR UNO NUEVO
        $correlativos = [
            "03" => "correlativo_ccf",
            "15" => "correlativo_cd",
            "08" => "correlativo_cl",
            "07" => "correlativo_cr",
            "09" => "correlativo_dcl",
            "01" => "correlativo_fc",
            "11" => "correlativo_fex",
            "14" => "correlativo_fse",
            "05" => "correlativo_nota_credito",
            "06" => "correlativo_nd",
            "04" => "correlativo_nr",
        ];

        if (isset($correlativos[$tipoDoc])) {
            $campo = $correlativos[$tipoDoc];
            $registroContadorDTE = ++$empresa->$campo;
        }

        if ($registroContadorDTE != null) {
            $contadorDTEs = (int)$registroContadorDTE;

            // $contadorDTEs += 1;

            $generated = "DTE-" . $tipoDoc . '-' . $codigoEmpresa;
            $digitos = str_pad($contadorDTEs, 15, "0", STR_PAD_LEFT);
            $generated .= '-' . $digitos;

            // $registroContadorDTE = $contadorDTEs;

            $empresa->save();
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

    public static function generateStringFromNumber($number)
    {
        $numero_str = strval($number);
        $partes = explode('.', $numero_str);
        $entero = isset($partes[0]) ? intval($partes[0]) : 0;
        $decimal = isset($partes[1]) ? intval($partes[1]) : 0;

        return Help::numberToString($entero) . " con " . Help::numberToString($decimal);
    }
}
