<?php

namespace App\Help\DTEHelper;

use App\help\Help;

class CCFDTE
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

        $totalImpuestos = 0.0;
        $tributos = [];
        $pagos = [];


        foreach ($cuerpo as $key => $value) {

            $ventaGravada = round($value['cantidad'] * $value['precioUni'], 2);
            $impuestoTotalItem = 0.0;

            // return response()->json([
            //         'value' => $ventaGravada
            //     ]);
            $totalNoSuj += $value['ventaNoSuj'];
            $totalExenta += $value['ventaExenta'];
            $subTotal += $ventaGravada;
            $totalDescu += $value['montoDescu'];
            // $dte['cuerpoDocumento'][$key]['ventaGravada'] = $ventaGravada;

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

                // return response()->json([
                //     'value' => $impuesto
                // ]);
                $totalImpuestos += $impuesto;
                $impuestoTotalItem += $impuesto;
            }

            $pagos[] = [
                "codigo" => $codigoPago,
                "montoPago" => $impuestoTotalItem + $ventaGravada,
                "referencia" => $descripcionPago,
                "periodo" => $periodoPago,
                "plazo" => $plazoPago
            ];
        }

        $subTotal = round($subTotal, 2);
        $totalPagar = round($subTotal + $totalImpuestos, 2);

        $resumen['totalNoSuj'] = $totalNoSuj;
        $resumen['totalExenta'] = $totalExenta;
        $resumen['totalGravada'] = $subTotal;
        $resumen['subTotalVentas'] = $subTotal;
        $resumen['descuNoSuj'] = 0.0;
        $resumen['descuExenta'] = 0.0;
        $resumen['descuGravada'] = 0.0;
        $resumen['porcentajeDescuento'] = 0.0;

        $resumen['totalDescu'] = $totalDescu;
        $resumen['tributos'] = $tributos;
        $resumen['subTotal'] = $subTotal;
        $resumen['ivaPerci1'] = 0.0;
        $resumen['ivaRete1'] = 0.0;
        $resumen['reteRenta'] = 0.0;
        $resumen['montoTotalOperacion'] = $totalPagar;
        $resumen['totalNoGravado'] = 0;

        $resumen['totalPagar'] = $totalPagar;

        $numero_str = strval($totalPagar);
        $partes = explode('.', $numero_str);
        $entero = isset($partes[0]) ? intval($partes[0]) : 0;
        $decimal = isset($partes[1]) ? intval($partes[1]) : 0;
        $numero_en_letras = Help::numberToString($entero) . " con " . Help::numberToString($decimal);

        $resumen['totalLetras'] = 'USD ' . $numero_en_letras;

        $resumen['saldoFavor'] = 0;
        $resumen['condicionOperacion'] = 1;
        $resumen['pagos'] = $pagos;
        $resumen['numPagoElectronico'] = null;

        return $resumen;
    }
}
