<?php

namespace App\Help\DTEHelper;

use App\help\Help;

class FACTDTE
{

    public static function Resumen($cuerpo, $codigoPago, $plazoPago, $periodoPago)
    {
        $resumen = [];
        $descripcionPago = Help::getPayWay($codigoPago);

        $totalNoSuj = 0.0;
        $totalExenta = 0.0;
        $subTotal = 0.0;
        $totalDescu = 0.0;
        $totalPagar = 0.0;
        $totalIva = 0.0;

        $totalImpuestos = 0.0;
        $tributos = [];
        $pagos = [];

        foreach ($cuerpo as $key => $value) {

            $ventaGravada = round($value['cantidad'] * $value['precioUni'], 2);
            $impuestoTotalItem = 0.0;
            $totalIva = $value['ivaItem'];

            $totalNoSuj += $value['ventaNoSuj'];
            $totalExenta += $value['ventaExenta'];
            $subTotal += $ventaGravada;
            $totalDescu += $value['montoDescu'];

            foreach ($value['tributos'] as $tributo) {
                $encontrado = false;
                $impuesto = 0.0;

                $impuesto = round(Help::getTax($tributo, $ventaGravada), 2);

                foreach ($tributos as $clave => $valor) {

                    $codigo = $valor['codigo'];

                    if ($codigo == $tributo) {
                        $encontrado = true;
                        $tributos[$clave]['valor'] += $impuesto;
                        break;
                    }
                }

                if (!$encontrado) {
                    $tributos[] = [
                        'codigo' => $tributo,
                        'descripcion' => Help::getTributo($tributo),
                        'valor' => $impuesto
                    ];
                }

                $totalImpuestos += $impuesto;
                $impuestoTotalItem += $impuesto;
            }

            $pagos[] = [
                'codigo' => $codigoPago,
                'periodo' => $periodoPago,
                'plazo' => $plazoPago,
                'montoPago' => $ventaGravada,
                'referencia' => $descripcionPago
            ];

            $totalPagar += $ventaGravada + $impuestoTotalItem;
        }

        $numero_str = strval($totalPagar);
        $partes = explode('.', $numero_str);
        $entero = isset($partes[0]) ? $partes[0] : 0;
        $decimal = isset($partes[1]) ? $partes[1] : 0;
        $numero_en_letras = Help::numberToString($entero) . ' CON ' . Help::numberToString($decimal);

        $resumen = [
            'totalNoSuj' => $totalNoSuj,
            'descuNoSuj' => 0.0,
            'totalIva' => $totalIva,
            'totalLetras' => $numero_en_letras,
            'ivaRete1' => 0.0,
            'subTotalVentas' => $subTotal,
            'reteRenta' => 0.0,
            'tributos' => $tributos,
            'pagos' => $pagos,
            'descuExenta' => 0.0,
            'totalDescu' => $totalDescu,
            'numeroPagoElectronico' => null,
            'descuGravada' => 0.0,
            'porcentajeDescuento' => 0.0,
            'totalGravada' => $subTotal,
            'montoTotalOperacion' => $totalPagar,
            'totalNoGravado' => 0,
            'saldoFavor' => 0,
            'totalExenta' => $totalExenta,
            'totalPagar' => $totalPagar,
            'codicionOperacion' => 1,
        ];

        return $resumen;
    }
}
