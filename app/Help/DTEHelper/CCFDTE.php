<?php

namespace App\Help\DTEHelper;

use App\Help\Generator;
use App\help\Help;

class CCFDTE
{

    public static function Resumen($cuerpo, $idTipoCliente, $pagoTributos, $codigoPago, $plazoPago = null, $periodoPago = null)
    {
        $resumen = [];

        // Obtener la descripción del método de pago
        $descripcionPago = Help::getPayWay($codigoPago);

        // Inicializar variables para almacenar totales
        $totalNoSuj = 0.0;
        $totalExenta = 0.0;
        $subTotal = 0.0;
        $totalDescu = 0.0;
        $totalPagar = 0.0;
        $ivaRetenida = 0.0;
        $totalImpuestos = 0.0;
        $tributos = [];
        $pagos = [];

        $descuentoItem = 0;

        // Recorrer cada elemento en el cuerpo
        foreach ($cuerpo as $key => $value) {
            $ventaGravada = $value['ventaGravada'];

            // Sumar los valores de venta no sujeta y exenta
            $totalNoSuj += $value['ventaNoSuj'];
            $totalExenta += $value['ventaExenta'];

            // Sumar los descuentos
            $descuentoItem = $value['montoDescu'];
            $totalDescu += $descuentoItem;

            // Sumar el subtotal de ventas gravadas
            $subTotal += $ventaGravada;

            $impuestoTotalItem = 0.0;
            $ivaRetenidoItem = 0;

            // Calcular el valor de venta sin descuento
            $ventaSinDescuento = round(($value['precioUni'] * $value['cantidad']), 2);

            // Calcular el IVA retenido si aplica
            if ($idTipoCliente == 3 && $ventaSinDescuento >= 100) {
                $ivaRetenidoItem = round($ventaSinDescuento * 0.01, 2);
                $ivaRetenida += $ivaRetenidoItem;
            }

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

            // Calcular el monto de pago
            $montoPago = $ventaGravada + $impuestoTotalItem - $ivaRetenidoItem;

            // Agregar el pago al array de pagos
            $pagos[] = [
                "codigo" => $codigoPago,
                "montoPago" => $montoPago,
                "referencia" => $descripcionPago,
                "periodo" => $periodoPago,
                "plazo" => $plazoPago
            ];
        }

        // Redondear el subtotal
        $subTotal = round($subTotal, 2);

        // Calcular el monto total de la operación
        $montoTotal = $subTotal + $totalNoSuj + $totalExenta + $totalImpuestos;

        // Calcular el total a pagar
        $totalPagar = $subTotal + $totalImpuestos - $ivaRetenida;

        // Generar el total en letras
        $numero_en_letras = Generator::generateStringFromNumber($totalPagar);

        $resumen = [
            'totalNoSuj' => $totalNoSuj,
            'totalExenta' => $totalExenta,
            'totalDescu' => $totalDescu,
            'totalGravada' => $subTotal,
            'subTotalVentas' => $subTotal,
            'subTotal' => $subTotal,
            'montoTotalOperacion' => $montoTotal,

            'descuNoSuj' => 0.0,
            'descuExenta' => 0.0,
            'descuGravada' => 0.0,
            'tributos' => $tributos ?? null,
            'ivaPerci1' => 0.0,
            'ivaRete1' => $ivaRetenida,
            'reteRenta' => 0.0,
            // 'totalPagar' => $totalPagar,
            'totalPagar' => $totalPagar,

            'condicionOperacion' => 1,
            'totalLetras' => 'USD ' . $numero_en_letras,
            'saldoFavor' => 0,
            'totalNoGravado' => 0,
            'porcentajeDescuento' => 0.0,
            'numPagoElectronico' => null,
            'pagos' => $pagos,
        ];

        return $resumen;
    }


    // TODO: calculate cuerpoDocumento
    public static function getCuerpoDocumento($items)
    {
        if ($items == null)
            return null;

        // AGREGAR NUMERO DE ITEM
        foreach ($items as $key => $item) {
            $items[$key]['numItem'] = $key + 1;
        }

        return $items;
    }
}
