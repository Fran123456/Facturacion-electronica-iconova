<?php

namespace App\Help\DTEHelper;

use App\Help\Generator;
use App\help\Help;

class CLDTE
{
    public static function getCuerpo($items): ?array
    {

        if ($items == null) return null;

        foreach ($items as $key => $item) {
            $item[$key]["numItem"] = $key + 1;
        }

        return $items;
    }

    public static function getResumen($cuerpo): array
    {

        // VARIABLES PARA GUARDAR CALCULOS APARTIR DE LOS ITEMS DEL CUERPO DEL DOCUMENTO
        $totalExenta = 0.0;
        $totalNoSuj = 0.0;
        $totalGravada = 0.0;
        $totalExportacion = 0.0;
        $montoTotalOperacion = 0.0;
        $subTotal = 0.0;
        $ivaPerci = 0.0;
        $tributos = [];

        // VARIABLES DE PROCESO PARA GUARDAR VALORES A USAR AFUERA DEL CICLO FOREACH
        $totalImpuestos = 0.0;

        foreach ($cuerpo as $value) {
            $ventaGravada = $value['ventaGravada'];

            $totalNoSuj += $value['ventaNoSuj'];
            $totalExenta += $value['ventaExenta'];
            $totalGravada += $ventaGravada;
            $totalExportacion += $value['exportaciones'];
            $subTotal += $ventaGravada;

            // Procesar tributos si existen
            $isIva = $value['ivaItem'] > 0.0;

            if ($isIva) {
                $clave = array_search("20", array_column($tributos, 'codigo'));

                $ivaItem = $value['ivaItem'];

                $totalImpuestos += $ivaItem;
                $ivaPerci += $ivaItem;

                if ($clave !== false) {
                    // Si el tributo ya existe, actualizar su valor
                    $tributos[$clave]['valor'] += round($ivaItem, 2);
                    continue;
                }

                // Si no existe, agregar un nuevo tributo al array
                $tributos[] = [
                    'codigo' => "20",
                    'descripcion' => Help::getTributo("20"),
                    'valor' => floor($ivaItem * 100) / 100
                ];
            }
        }

        $subTotal = floor($subTotal * 100) / 100;
        $subTotalVentas = $subTotal;
        $total = $subTotal;
        $montoTotalOperacion = floor(($subTotal + $totalImpuestos) * 100) / 100;

        $totalLetras = 'USD ' . Generator::generateStringFromNumber($montoTotalOperacion);

        $condicionOperacion = 1;

        return compact(
            'totalNoSuj',
            'totalExenta',
            'totalGravada',
            'totalExportacion',
            'subTotalVentas',
            'tributos',
            'montoTotalOperacion',
            'ivaPerci',
            'total',
            'totalLetras',
            'condicionOperacion',
        );
    }
}
