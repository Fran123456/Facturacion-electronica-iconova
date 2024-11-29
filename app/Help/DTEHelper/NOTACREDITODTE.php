<?php
namespace App\Help\DTEHelper;

use App\Help\Generator;
use App\Help\Help;

class NOTACREDITODTE
{
    public static function extension($observacion){
        return [
            "docuEntrega" => null,
            "observaciones" => $observacion,
            "nombRecibe" => null,
            "nombEntrega"=> null,
            "docuRecibe"=> null,
        ];
    }

    public static function cuerpo($cuerpo){

        if ($cuerpo == null)
            return null;

        // AGREGAR NUMERO DE ITEM
        foreach ($cuerpo as $key => $item) {
            $cuerpo[$key]['numItem'] = $key + 1;
        }

        return $cuerpo;
    }

    public static function resumen($cuerpo, $tipoCliente, $pagoTributos){

        // VARIABLES PARA GUARDAR CALCULOS APARTIR DE LOS ITEMS DEL CUERPO DEL DOCUMENTO
        $totalExenta = 0.0;
        $totalNoSuj = 0.0;
        $totalGravada = 0.0;
        $totalDescu = 0.0;
        $montoTotalOperacion = 0.0;

        $descuNoSuj = 0.0;
        $descuExenta = 0.0;
        $descuGravada = 0.0;

        $subTotal = 0.0;

        $ivaPerci1 = 0.0;
        $ivaRetenida = 0.0;
        $reteRenta = 0.0;

        $tributos = [];

        // VARIABLES DE PROCESO PARA GUARDAR VALORES A USAR AFUERA DEL CICLO FOREACH
        $totalImpuestos = 0.0;

        foreach ($cuerpo as $key => $value) {
            $ventaGravada = $value['ventaGravada'];

            $totalNoSuj += $value['ventaNoSuj'];
            $totalExenta += $value['ventaExenta'];
            $totalGravada += $value['ventaGravada'];
            $subTotal += $ventaGravada;

            $totalDescu += $value['montoDescu'];

            $ventaSinDescuento = round(($value['precioUni'] * $value['cantidad']), 2);

            // Calcular el IVA retenido si aplica
            if ($tipoCliente == 3 && $ventaSinDescuento >= 100) {
                $ivaRetenidoItem = round($ventaSinDescuento * 0.01, 2);
                $ivaRetenida += $ivaRetenidoItem;
            }

            // Procesar tributos si existen
            if ($pagoTributos != null) {
                $pagoTributo = $pagoTributos[$key];

                foreach ($pagoTributo as $keyObjec => $valorObjec) {
                    $totalImpuestos += $valorObjec;

                    // Buscar si el tributo ya existe en el array
                    $clave = array_search($keyObjec, array_column($tributos, 'codigo'));

                    if ($clave !== false) {
                        // Si el tributo ya existe, actualizar su valor
                        $tributos[$clave]['valor'] += $valorObjec;
                        continue;
                    }

                    // Si no existe, agregar un nuevo tributo al array
                    $tributos[] = [
                        'codigo' => strval($keyObjec),
                        'descripcion' => Help::getTributo($keyObjec),
                        'valor' => round($valorObjec, 2)
                    ];
                }
            }

        }

        $subTotal = round($subTotal, 2);
        $montoTotalOperacion = round($subTotal + $totalImpuestos - $ivaRetenida, 2);

        $numero_en_letras = Generator::generateStringFromNumber($montoTotalOperacion);


        return [
            'totalNoSuj' => $totalNoSuj,
            'totalExenta' => $totalExenta,
            'totalGravada' => $totalGravada,
            'totalDescu' => $totalDescu,
            'montoTotalOperacion' => $montoTotalOperacion,

            'descuNoSuj' => $descuNoSuj,
            'descuGravada' => $descuGravada,
            'descuExenta' => $descuExenta,

            'subTotalVentas' => $subTotal,
            'subTotal' => $subTotal,

            'ivaPerci1' => $ivaPerci1,
            'ivaRete1' => $ivaRetenida,
            'reteRenta' => $reteRenta,

            'tributos' => $tributos,
            'totalLetras' => 'USD ' . $numero_en_letras,
            'condicionOperacion' => 1,
        ];

    }

    public static function documentosRelacionados($relacionados){

        foreach ($relacionados as $value) {
            $value['tipoGeneracion']= 2;
        }
        return $relacionados;
    }

}












