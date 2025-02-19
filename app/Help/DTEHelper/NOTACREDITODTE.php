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

    /*public static function cuerpo($cuerpo){

        if ($cuerpo == null)
            return null;

        // AGREGAR NUMERO DE ITEM
        foreach ($cuerpo as $key => $item) {
            $cuerpo[$key]['numItem'] = $key + 1;
        }

        return $cuerpo;
    }*/
    public static function cuerpo($cuerpo){
        if ($cuerpo == null) {
            return null;
        }
    
        // Iterar y agregar número de item y campo 'tributos'
        foreach ($cuerpo as $key => $item) {
            // Agregar número de item
            $cuerpo[$key]['numItem'] = $key + 1;
    
            // Revisar el valor de 'iva' y asignar 'tributos'
            if (isset($item['iva']) && $item['iva'] > 0) {
                $cuerpo[$key]['tributos'] = ["20"];
            } else {
                $cuerpo[$key]['tributos'] = null;
            }
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
          /*  if ($tipoCliente == 3 && $ventaSinDescuento >= 100) {
                $ivaRetenidoItem = round($ventaSinDescuento * 0.01, 2);
                $ivaRetenida += $ivaRetenidoItem;
            }*/
            $ivaRetenida =$ivaRetenida+ $value['ivaRetenida'];

            if($value['iva']>0){
                $tributos[] = [
                    'codigo' => "20",
                    'descripcion' => Help::getTributo("20"),
                    'valor' => $value['iva']
                ];
                $totalImpuestos = $value['iva']+$totalImpuestos;
            }
            
            // Procesar tributos si existen
            /*if ($pagoTributos != null) {
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
            }*/
            

        }

        $subTotal = round($subTotal, 2);
        $montoTotalOperacion = round($subTotal + $totalImpuestos - $ivaRetenida, 2);

        $numero_en_letras = Generator::generateStringFromNumber($montoTotalOperacion);

        // Agrupar y sumar valores con el mismo código
        $resultado = [];
        foreach ($tributos as $tributo) {
            $codigo = $tributo['codigo'];
            if (isset($resultado[$codigo])) {
                $resultado[$codigo]['valor'] += $tributo['valor'];
            } else {
                $resultado[$codigo] = $tributo;
            }
        }
        $resultado = array_values($resultado);

        $tributos= $resultado;
        // Convertir a un array numerado si es necesario
       
        return [
            'totalNoSuj' => $totalNoSuj,
            'totalExenta' => $totalExenta,
            'totalGravada' => round($totalGravada,2),
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












