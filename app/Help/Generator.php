<?php

namespace App\Help;

use App\Help\Help;
use Ramsey\Uuid\Uuid;
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
            $empresa->correlativo_fc = (int) $empresa->correlativo_fc	 + 1;
        }
        if ($tipoDoc == '05') {
            $empresa->correlativo_nota_credito = (int) $empresa->correlativo_nota_credito + 1;
        }
        
        if ($tipoDoc == '15') {
            $empresa->correlativo_cd = (int) $empresa->correlativo_cd	 + 1;
        }

        if ($tipoDoc == '08') {
            $empresa->correlativo_cl = (int) $empresa->correlativo_cl	 + 1;
        }

        if ($tipoDoc == '07') {
            $empresa->correlativo_cr = (int) $empresa->correlativo_cr	 + 1;
        }

        if ($tipoDoc == '09') {
            $empresa->correlativo_dcl = (int) $empresa->correlativo_dcl	 + 1;
        }

        if ($tipoDoc == '14') {
            $empresa->correlativo_fse = (int) $empresa->correlativo_fse	 + 1;
        }

        if ($tipoDoc == '06') {
            $empresa->correlativo_nd = (int) $empresa->correlativo_nd	 + 1;
        }

        if ($tipoDoc == '04') {
            $empresa->correlativo_nr = (int) $empresa->correlativo_nr	 + 1;
        }

        if ($tipoDoc == 'contingencia') {
            $empresa->contingencia_interno = (int) $empresa->contingencia_interno	 + 1;
        }
        $empresa->save();
    }

    public static function contingencia(){
        $empresa = Help::getEmpresa();
        $empresa->contingencia_interno = (int) $empresa->contingencia_interno	 + 1;
        $empresa->save();
        $digitos = str_pad($empresa->contingencia_interno, 15, "0", STR_PAD_LEFT);
        return $digitos;
    }

    public static function generateNumControl($tipoDoc, $codigoEmpresa = "M001P001")
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

            $generated = "DTE-" . $tipoDoc . '-' . $codigoEmpresa;
            $digitos = str_pad($contadorDTEs, 15, "0", STR_PAD_LEFT);
            $generated .= '-' . $digitos;

            $empresa->save();
            return $generated;
        }

        return null;
    }

    public static function generateCodeGeneration()
    {
        return strtoupper(Uuid::uuid4()->toString());
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
       /* $numero_str = strval($number);
        $partes = explode('.', $numero_str);
        $entero = isset($partes[0]) ? intval($partes[0]) : 0;
        $decimal = isset($partes[1]) ? intval($partes[1]) : 0;

        return Help::numberToString($entero) . " con " . Help::numberToString($decimal);*/

        $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);

        $entero = floor($number);
        $centavos = round(($number - $entero) * 100);

        $texto = strtoupper($formatter->format($entero));
        $centavosTexto = str_pad($centavos, 2, '0', STR_PAD_LEFT);

        return "{$texto} {$centavosTexto}/100 USD";
    }
}
