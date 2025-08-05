<?php

namespace App\Help\DTEHelper;

use App\Help\Generator;
use App\Help\Help;
class FSEDTE
{

    public static function cuerpo($cuerpo)
    {

        if ($cuerpo == null)
            return null;

        // AGREGAR NUMERO DE ITEM
        foreach ($cuerpo as $key => $item) {
            $cuerpo[$key]['numItem'] = $key + 1;
        }

        return $cuerpo;
    }

    public static function resumen($cuerpo,  $pagoTributos,$codigoPago, $periodoPago = null,
    $plazoPago = null, $operacion = 1)
    {

        // VARIABLES PARA GUARDAR CALCULOS APARTIR DE LOS ITEMS DEL CUERPO DEL DOCUMENTO
        $totalCompra = 0.0;
        $totalDescu = 0.0;
        $totalPagar = 0.0;

        $descu = 0.0;
        $subTotal = 0.0;

        $ivaRete1 = 0.0;
        $reteRenta = 0.0;

        $pagos = array();
        $observaciones = null;

        // VARIABLES DE PROCESO PARA GUARDAR VALORES A USAR AFUERA DEL CICLO FOREACH
        foreach ($cuerpo as $value) {
        
            $renta = isset($value['renta'])? $value['renta']:0;
            $compraItem = $value['compra'];
            $cantidadItem = $value['cantidad'];
            $precioUniItem = $value['precioUni'];
            $montoDescuItem = 0;

            $subTotalItem = $precioUniItem * $cantidadItem - $montoDescuItem;
            $retencionItem = $subTotalItem * 0.1;

            $subTotal += $subTotalItem;
            $totalCompra += $compraItem;
            $totalDescu += $montoDescuItem;
            $descu += $montoDescuItem;
            $reteRenta += $renta;
            $totalPagar += $subTotalItem -  $renta;

            $descripcionPago = Help::getPayWay($codigoPago);

            $pago = [
                "codigo" => $codigoPago,
                "montoPago" => $subTotalItem -  $renta,
                "referencia" => $descripcionPago,
                "periodo" => (int)$periodoPago,
                "plazo" => $plazoPago
            ];
            array_push($pagos, $pago);

            
        }

        $reteRenta = round($reteRenta, 2);
        $totalPagar = round($totalPagar, 2);

        $totalLetras = Generator::generateStringFromNumber($totalPagar);

        $condicionOperacion = $operacion;

        return compact(
            'totalCompra',
            'totalDescu',
            'totalPagar',
            'totalLetras',
            'descu',
            'subTotal',
            'ivaRete1',
            'reteRenta',
            'pagos',
            'observaciones',
            'condicionOperacion'
        );
    }
}
