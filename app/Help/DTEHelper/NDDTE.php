<?php

namespace App\Help\DTEHelper;

use App\Help\Generator;
use App\Help\Help;

class NDDTE
{

    public static function extension($observacion)
    {
        return [
            "docuEntrega" => null,
            "observaciones" => $observacion,
            "nombRecibe" => null,
            "nombEntrega" => null,
            "docuRecibe" => null,
        ];
    }

    public static function cuerpo($cuerpo)
    {

        if ($cuerpo == null)
            return null;

        // AGREGAR NUMERO DE ITEM
        foreach ($cuerpo as $key => $item) {
            $object = $cuerpo[$key];
            $cuerpo[$key]['numItem'] = $key + 1;

            $ivaItem = $object['iva'];
            $renta = $object['renta'];

            $tributos = [];
            if ($ivaItem > 0)
                $tributos[] = "20";

            unset($cuerpo[$key]['iva']);
            unset($cuerpo[$key]['renta']);

            $cuerpo[$key]['tributos'] = $tributos;
        }

        return $cuerpo;
    }

    public static function resumen($cuerpo, $tipoCliente, $pagoTributos = null)
    {
        $resumen = [];

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
        $ivaRete1 = 0.0;
        $reteRenta = 0.0;

        $tributos = [];

        // VARIABLES DE PROCESO PARA GUARDAR VALORES A USAR AFUERA DEL CICLO FOREACH
        $totalImpuestos = 0.0;

        foreach ($cuerpo as $key => $value) {
            $ventaGravada = $value['ventaGravada'];
            $impuestoTotalItem = 0.0;

            $totalNoSuj += $value['ventaNoSuj'];
            $totalExenta += $value['ventaExenta'];
            $totalGravada += $value['ventaGravada'];
            $subTotal += $ventaGravada;

            $totalDescu += $value['montoDescu'];

            $ventaSinDescuento = round(($value['precioUni'] * $value['cantidad']), 2);

            $ivaRetenidoItem = 0.0;

            // Calcular el IVA retenido si aplica
            if ($tipoCliente && $ventaSinDescuento >= 100) {
                $ivaRetenidoItem = round($ventaSinDescuento * 0.01, 2);
                $ivaRete1 += $ivaRetenidoItem;
            }

            // Procesar tributos si existen
            $isIva = $value['iva'] > 0.0;

            if ($isIva) {
                $clave = array_search("20", array_column($tributos, 'codigo'));

                $ivaItem = $value['iva'];

                $impuestoTotalItem += $ivaItem;
                $totalImpuestos += $ivaItem;

                if ($clave !== false) {
                    // Si el tributo ya existe, actualizar su valor
                    $tributos[$clave]['valor'] += round($ivaItem, 2);
                    continue;
                }

                // Si no existe, agregar un nuevo tributo al array
                $tributos[] = [
                    'codigo' => "20",
                    'descripcion' => Help::getTributo("20"),
                    'valor' => round($ivaItem, 2)
                ];
            }
        }

        $subTotal = round($subTotal, 2);
        $subTotalVentas = $subTotal;
        $montoTotalOperacion = round($subTotal + $totalImpuestos + $ivaRete1, 2);

        $totalLetras = 'USD ' . Generator::generateStringFromNumber($montoTotalOperacion);

        $condicionOperacion = 1;
        $numPagoElectronico = null;

        $resumen = compact(
            'totalNoSuj',
            'totalExenta',
            'totalGravada',
            'totalDescu',
            'montoTotalOperacion',
            'descuNoSuj',
            'descuGravada',
            'descuExenta',
            'subTotalVentas',
            'subTotal',
            'ivaPerci1',
            'ivaRete1',
            'reteRenta',
            'tributos',
            'totalLetras',
            'condicionOperacion',
            'numPagoElectronico'
        );

        return $resumen;
    }

    public static function documentosRelacionados($relacionados)
    {
        foreach ($relacionados as $value) {
            $value['tipoGeneracion'] = 2;
        }
        return $relacionados;
    }
}
