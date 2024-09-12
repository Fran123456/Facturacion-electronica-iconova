<?php

namespace App\Help\DTEHelper;

use App\Help\Generator;
use App\help\Help;

class FACTDTE
{

    // TODO: calculate cuerpoDocumento
    public static function getCuerpoDocumento($items)
    {
        if ($items == null)
            return null;

        foreach ($items as $key => $item) {

            // REDONDENANDO VALORES DEFINIDOS POR LE USUARIO
            $cantidad = intval($item['cantidad']);
            $precio = round($item['precioUni'], 2);
            $montoDescu = round($item['montoDescu'], 2);

            $ventaGravada = round($item['ventaGravada'], 2);
            $iva = round($item['ivaItem'], 2);

            // CAMPOS CON VALORES PREDEFINIDOS
            $items[$key]['tributos'] = null;
            $items[$key]['ventaNoSuj'] = 0;
            $items[$key]['ventaExenta'] = 0;

            // CAMPOS CON VALORES DEFINIDOS POR EL USUARIO
            $items[$key]['cantidad'] = $cantidad;
            $items[$key]['montoDescu'] = $montoDescu;
            $items[$key]['ventaGravada'] = $ventaGravada;
            $items[$key]['precioUni'] = $precio;
            $items[$key]['ivaItem'] = $iva;
        }

        return $items;
    }
    //$condicionPago =  mh_condicion_operacion
    //codigoPago = mh_forma_pago
    //$plazoPago = mh_plazo
    //$periodoPago  =
    //$formaPago = mh_condicion_operacion


    // public static function Resumen($cuerpo, $idTipoCliente, $codigoPago, $plazoPago = null, $periodoPago = null)
    // {
    //     $resumen = [];

    //     $descripcionPago = Help::getPayWay($codigoPago);

    //     $totalNoSuj = 0.0;
    //     $totalExenta = 0.0;
    //     $subTotal = 0.0;
    //     $totalDescu = 0.0;
    //     $totalPagar = 0.0;
    //     $ivaRetenida = 0.0;
    //     $totalImpuestos = 0.0;

    //     $totalIva = 0;

    //     $totalNoGravado = 0;

    //     $tributos = [];
    //     $pagos = [];

    //     foreach ($cuerpo as $key => $value) {

    //         $ventaGravada = round($value['cantidad'] * $value['precioUni'], 2);


    //         if ($idTipoCliente == 3 && $ventaGravada >= 100) {
    //             $ivaRetenida += round(($ventaGravada * 0.01), 2);
    //         }

    //         $totalNoSuj += $value['ventaNoSuj'];
    //         $totalExenta += $value['ventaExenta'];
    //         $totalNoGravado += $value['noGravado'];
    //         $totalDescu += $value['montoDescu'];

    //         $subTotal += $ventaGravada;

    //         $totalIva += $value['ivaItem'];

    //         if ($value['tributos'] != null)
    //             foreach ($value['tributos'] as $tributo) {
    //                 $encontrado = false;
    //                 $impuesto = round($ventaGravada * 0.115, 2);

    //                 foreach ($tributos as $clave => $valor) {
    //                     if ($valor['codigo'] == $tributo) {
    //                         $encontrado = true;
    //                         $tributos[$clave]['valor'] += $impuesto;
    //                         break;
    //                     }
    //                 }

    //                 if (!$encontrado) {
    //                     $tributos[] = [
    //                         'codigo' => $tributo,
    //                         'descripcion' => Help::getTributo($tributo),
    //                         'valor' => $impuesto * 1.0
    //                     ];
    //                 }

    //                 $totalImpuestos += $impuesto;
    //             }

    //         $pagos[] = [
    //             "codigo" => $codigoPago,
    //             "montoPago" => $ventaGravada,
    //             "referencia" => $descripcionPago,
    //             "periodo" => $periodoPago,
    //             "plazo" => $plazoPago
    //         ];
    //     }

    //     // $totalPagar = $subTotal;

    //     $totalPagar = $subTotal + $totalImpuestos - $ivaRetenida - $totalDescu + $totalNoGravado;

    //     $baseImponible = $subTotal; // Este es el monto sujeto a impuestos

    //     $montoTotalOperacion = $baseImponible + $totalImpuestos + $totalNoSuj + $totalExenta - $totalDescu + $totalIva + $totalNoGravado + $totalNoSuj;

    //     $total_en_letras = Generator::generateStringFromNumber($totalPagar);

    //     $resumen = [
    //         'totalNoSuj' => $totalNoSuj,
    //         'totalExenta' => $totalExenta,
    //         'totalDescu' => $totalDescu,
    //         'totalGravada' => $subTotal,
    //         'subTotalVentas' => $subTotal,
    //         'subTotal' => $subTotal,
    //         'montoTotalOperacion' => $subTotal,
    //         // 'montoTotalOperacion' => $montoTotalOperacion,

    //         'descuNoSuj' => 0.0,
    //         'descuExenta' => 0.0,
    //         'descuGravada' => 0.0,
    //         'tributos' => $tributos ? $tributos :  null,
    //         'totalIva' => $totalIva,
    //         'ivaRete1' => $ivaRetenida,
    //         'reteRenta' => 0.0,
    //         // 'totalPagar' => $totalPagar,
    //         'totalPagar' => $totalPagar,
    //         // 'totalPagar' => $subTotal,


    //         'condicionOperacion' => 1,
    //         'totalLetras' => 'USD ' . $total_en_letras,
    //         'saldoFavor' => 0,
    //         'totalNoGravado' => $totalNoGravado,
    //         'porcentajeDescuento' => 0.0,
    //         'numPagoElectronico' => null,
    //         'pagos' => $pagos,
    //     ];

    //     return $resumen;
    // }

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
            $impuestoTotalItem = 0.0;

            $totalGravada += $ventaGravada;

            $ivaRetenidoItem = 0;
            // Calcular el valor de venta sin descuento
            $ventaSinDescuento = round(($value['precioUni'] * $value['cantidad']), 2);

            // Calcular el IVA retenido si aplica
            // if ($idTipoCliente == 3 && $ventaSinDescuento >= 100) {
            //     $ivaRetenidoItem = round($ventaSinDescuento * 0.01, 2);
            //     $ivaRetenida += $ivaRetenidoItem;
            // }

            $totalNoSuj += $value['ventaNoSuj'];
            $totalExenta += $value['ventaExenta'];
            $totalNoGravado += $value['noGravado'];
            $totalDescu += $value['montoDescu'];

            $NoSuj = $value['ventaNoSuj'];
            $Exenta = $value['ventaExenta'];
            $NoGravado = $value['noGravado'];

            $subTotal += $ventaGravada - $ivaRetenidoItem;

            $totalIva += $value['ivaItem'];

            // Procesar tributos si existen
            if ($pagoTributos != null) {
                $pagoTributo = $pagoTributos[$key];

                foreach ($pagoTributo as $keyObjec => $valorObjec) {
                    $totalImpuestos += $valorObjec;
                    $impuestoTotalItem += $valorObjec;

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

            $montoPago = $ventaGravada - $ivaRetenidoItem;

            $pagos[] = [
                "codigo" => $codigoPago,
                "montoPago" => $montoPago,
                "referencia" => $descripcionPago,
                "periodo" => $periodoPago,
                "plazo" => $plazoPago
            ];
        }


        $totalPagar = round($subTotal + $totalImpuestos + $totalNoGravado - $ivaRetenida,);

        $total_en_letras = Generator::generateStringFromNumber($totalPagar);

        $resumen = [
            // TOTALES CALCULADOS
            'totalNoSuj' => $totalNoSuj,
            'totalExenta' => $totalExenta,
            'totalNoGravado' => $totalNoGravado,
            'totalDescu' => $totalDescu,
            'totalGravada' => $totalGravada,
            'subTotalVentas' => $subTotal,
            'subTotal' => $subTotal,
            'montoTotalOperacion' => $subTotal,
            'totalIva' => $totalIva,
            'pagos' => $pagos,
            'totalPagar' => $totalPagar,

            // CAMPOS CON VALORES FIJOS
            'descuNoSuj' => 0.0,
            'descuExenta' => 0.0,
            'reteRenta' => 0.0,

            // CAMPOS JSON DE FACTURA
            'descuGravada' => $subTotal - ($subTotal - $totalDescu),
            'tributos' => $tributos ? $tributos :  null,
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
}
