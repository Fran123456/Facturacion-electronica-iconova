<?php

namespace App\Help\DTEHelper;

use App\Help\Generator;
use App\Help\Help;

class FACTDTE
{
    public static function getCuerpoDocumento($items)
    {
        if ($items == null)
            return null;

        foreach ($items as $key => $item) {

            // REDONDENANDO VALORES DEFINIDOS POR LE USUARIO
            $cantidad = $item['cantidad'];
            $precio = round($item['precioUni'], 2);
            $montoDescu = round($item['montoDescu'], 2);

            $ventaGravada = round($item['ventaGravada'], 2);
            $iva = round($item['ivaItem'], 5);

            // CAMPOS CON VALORES PREDEFINIDOS
            $items[$key]['tributos'] = null;
            $items[$key]['ventaNoSuj'] = 0;
            $items[$key]['ventaExenta'] = round($item['ventaExenta'], 2);

            // CAMPOS CON VALORES DEFINIDOS POR EL USUARIO
            $items[$key]['cantidad'] = $cantidad;
            $items[$key]['montoDescu'] = $montoDescu;
            $items[$key]['ventaGravada'] = $ventaGravada;
            $items[$key]['precioUni'] = $precio;
            $items[$key]['ivaItem'] = $iva;
        }

        return $items;
    }

    public static function Resumen($cuerpo, $idTipoCliente, $pagoTributos,$codigoPago, $plazoPago = null, $periodoPago = null)
    {
        $resumen = [];

        $descripcionPago = Help::getPayWay($codigoPago);

        $totalNoSuj = 0.0;
        $totalExenta = 0.0;
        $subTotal = 0.0;
        $totalDescu = 0.0;
        $totalPagar = 0.0;
        $ivaRetenida = 0.0;
        $totalImpuestos = 0.0;

        $totalIva = 0;
        $totalGravada = 0;

        $totalNoGravado = 0;

        $tributos = [];
        $pagos = [];

        foreach ($cuerpo as $key => $value) {

            $ventaGravada = $value['ventaGravada'];

            $totalGravada += $ventaGravada;

            $ivaRetenidoItem = 0;
            // Calcular el valor de venta sin descuento

            // Calcular el IVA retenido si aplica
            /*if ($idTipoCliente === true && $ventaGravada >= 100) {
                $ivaRetenidoItem = round(($ventaGravada - $value['ivaItem'] )* 0.01, 2);
                $ivaRetenida += $ivaRetenidoItem;
            }*/

            $totalNoSuj += $value['ventaNoSuj'];
            $totalExenta += $value['ventaExenta'];
            $totalNoGravado += $value['noGravado'];
            $totalDescu += $value['montoDescu'];

            // $NoSuj = $value['ventaNoSuj']
            // $Exenta = $value['ventaExenta'];
            // $NoGravado = $value['noGravado'];

            $subTotal += $ventaGravada + $value['ventaExenta'];
           

            $totalIva += $value['ivaItem'];

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

            $montoPago = $ventaGravada - $ivaRetenidoItem + $totalExenta;

            $pagos[] = [
                "codigo" => $codigoPago,
                "montoPago" => round($montoPago,2),
                "referencia" => $descripcionPago,
                "periodo" => $periodoPago,
                "plazo" => $plazoPago
            ];
        }
   


        $totalPagar = round($subTotal + $totalImpuestos + $totalNoGravado - $ivaRetenida,2);
     
        $total_en_letras = Generator::generateStringFromNumber($totalPagar);
 

        $resumen = [
            // TOTALES CALCULADOS
            'totalNoSuj' => $totalNoSuj,
            'totalExenta' => $totalExenta,
            'totalNoGravado' => $totalNoGravado,
            'totalDescu' => $totalDescu,
            'totalGravada' => round($totalGravada,2),
            'subTotalVentas' => round($subTotal,2),
            'subTotal' => round($subTotal,2),
            'montoTotalOperacion' => round($subTotal,2),
            'totalIva' => round($totalIva,2),
            'pagos' => $pagos,
            'totalPagar' => $totalPagar,

            // CAMPOS CON VALORES FIJOS
            'descuNoSuj' => 0.0,
            'descuExenta' => 0.0,
            'reteRenta' => 0.0,

            // CAMPOS JSON DE FACTURA
            'descuGravada' => $subTotal - ($subTotal - $totalDescu),
            'tributos' => null,
            'ivaRete1' => $ivaRetenida,
            'porcentajeDescuento' => 0.0,
            'saldoFavor' => 0,

            // OTROS CAMPOS ADICIONALES QUE NO SON DE CALCULOS
            'condicionOperacion' => 1,
            'totalLetras' => 'USD ' . $total_en_letras,
            'numPagoElectronico' => null,
        ];

        return $resumen;
    }


    public static function makePagoTributo($cuerpoDocumento){
        $pagosTributos = array();
        foreach ($cuerpoDocumento as $key => $value) {
            if($value['ivaItem']>0){
                $aux = array("20"=> $value['ivaItem']);
                array_push($pagosTributos, $aux);
            }else{
                $aux = array("D5"=> 0);
                array_push($pagosTributos, $aux);
            }
        }
        return  $pagosTributos;
    }
}
