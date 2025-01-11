<?php

namespace App\Help\DTEHelper;

use App\Help\Generator;
use App\help\Help;

class NRDTE
{

    public static function getCuerpo($items): ?array
    {
        if ($items == null) return null;

        foreach ($items as $key => $item) {
            $items[$key]["numItem"] = $key + 1;
            unset($items[$key]['iva']);
        }

        return $items;
    }

    public static function getResumen($cuerpo): array
    {

        // VARIABLES PARA GUARDAR CALCULOS APARTIR DE LOS ITEMS DEL CUERPO DEL DOCUMENTO
        $totalExenta = 0.0;
        $totalNoSuj = 0.0;
        $totalGravada = 0.0;
        $totalDescu = 0.0;
        $montoTotalOperacion = 0.0;
        $subTotal = 0.0;
        $tributos = [];
        $descuNoSuj = 0.0;
        $descuExenta = 0.0;
        $descuGravada = 0.0;
        $porcentajeDescuento = 0.0;

        // VARIABLES DE PROCESO PARA GUARDAR VALORES A USAR AFUERA DEL CICLO FOREACH
        $totalImpuestos = 0.0;

        foreach ($cuerpo as $value) {
            $ventaGravada = $value['ventaGravada'];

            $totalNoSuj   += $value['ventaNoSuj'];
            $totalExenta  += $value['ventaExenta'];
            $totalDescu  += $value['montoDescu'];
            $totalGravada += $ventaGravada;
            $subTotal     += $ventaGravada;

            // Procesar tributos si existen
            $isIva = $value['iva'] > 0.0;

            if ($isIva) {
                $clave = array_search("20", array_column($tributos, 'codigo'));

                $ivaItem = $value['iva'];

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
                    'valor' => $ivaItem 
                ];
            }
        }

        $subTotal = floor($subTotal * 100) / 100;
        $subTotalVentas = $subTotal;
        $montoTotalOperacion = floor(($subTotal + $totalImpuestos + $totalNoSuj + $totalExenta - $totalDescu) * 100) / 100;

        $totalLetras = 'USD ' . Generator::generateStringFromNumber($montoTotalOperacion);

        return compact(
            'totalNoSuj',
            'totalExenta',
            'totalGravada',
            'totalDescu',
            'subTotalVentas',
            "subTotal",
            'descuNoSuj',
            'descuExenta',
            'descuGravada',
            "porcentajeDescuento",
            'tributos',
            'montoTotalOperacion',
            'totalLetras',
        );
    }
}
