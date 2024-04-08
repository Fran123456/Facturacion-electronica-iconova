<?php

namespace App\Help\DTEHelper;

use App\help\Help;

class FACTDTE
{
    public static function BuildDetalle($detalle)
    {
        $data = array();
        foreach ($detalle as $key => $value) {
            $unidad = '99';
            if (isset($value['uniMedida'])) {
                $unidad = $value['uniMedida'];
            }

            $ar = array(
                "descripcion" => $value['descripcion'],
                "montoDescu" => $value['montoDescu'] ?? 0.0,
                "codigo" => $value['codigo'] ?? null,
                "ventaGravada" => $value['ventaGravada'] ?? 0.0,
                "ivaItem" => $value['ivaItem'] ?? 0.0,
                "ventaNoSuj" => $value['ventaNoSuj'] ?? 0.0,
                "ventaExenta" => $value['ventaExenta'] ?? 0.0,
                "tributos" => $value['tributos'] ?? null,
                "numItem" => $key + 1,
                "noGravado" => $value['noGravado'] ?? 0.0,
                "psv" => $value['psv'] ?? 0.0,
                "tipoItem" => $value['tipoItem'],
                "codTributo" => $value['codTributo'] ?? null,
                "uniMedida" => $unidad,
                "numeroDocumento" => $value['numeroDocumento'] ?? null,
                "cantidad" => $value['cantidad'],
                "precioUni" => $value['precioUni'],
            );

            array_push($data, $ar);
        }
        return $data;
    }

    //$condicionPago =  mh_condicion_operacion
    //codigoPago = mh_forma_pago
    //$plazoPago = mh_plazo
    //$periodoPago  =
    //$formaPago = mh_condicion_operacion
    public static function Resumen($cuerpo, $codigoPago, $plazoPago, $periodoPago, $formaPago, $numPagoElectronico)
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
            $totalIva += $value['ivaItem'];

            $totalNoSuj += $value['ventaNoSuj'];
            $totalExenta += $value['ventaExenta'];
            $subTotal += $ventaGravada;
            $totalDescu += $value['montoDescu'];

            if ($value['tributos'] != null) {
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
            'subTotal' => $subTotal,
            'reteRenta' => 0.0,
            'tributos' => $tributos,
            'pagos' => $pagos,
            'descuExenta' => 0.0,
            'totalDescu' => $totalDescu,
            'descuGravada' => 0.0,
            'porcentajeDescuento' => 0.0,
            'totalGravada' => $subTotal,
            'montoTotalOperacion' => $totalPagar,
            'totalNoGravado' => 0,
            'saldoFavor' => 0,
            'totalExenta' => $totalExenta,
            'totalPagar' => $totalPagar,
            'condicionOperacion' => $formaPago,
            'numPagoElectronico' => $numPagoElectronico
        ];

        return $resumen;
    }
}
