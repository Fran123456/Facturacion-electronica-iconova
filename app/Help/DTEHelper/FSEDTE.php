<?php
namespace App\Help\DTEHelper;

use App\Help\Generator;

class FSEDTE { 

    public static function cuerpo($cuerpo){

        if ($cuerpo == null)
            return null;

        // AGREGAR NUMERO DE ITEM
        foreach ($cuerpo as $key => $item) {
            $cuerpo[$key]['numItem'] = $key + 1;
        }

        return $cuerpo;
    }

    public static function resumen($cuerpo){

        $resumen = [];

        // VARIABLES PARA GUARDAR CALCULOS APARTIR DE LOS ITEMS DEL CUERPO DEL DOCUMENTO
        $totalCompra = 0.0;
        $totalDescu = 0.0;
        $totalPagar = 0.0;
        $montoTotalOperacion = 0.0;

        $descu = 0.0;
        $subTotal = 0.0;

        $ivaRete1 = 0.0;
        $reteRenta = 0.0;

        $pagos = null;
        $observaciones = null;

        // VARIABLES DE PROCESO PARA GUARDAR VALORES A USAR AFUERA DEL CICLO FOREACH
        $numItem = 1;
        foreach ($cuerpo as $key => $value) {

            $compraItem = $value['compra'];
            $cantidadItem = $value['cantidad'];
            $precioUniItem = $value['precioUni'];
            $montoDescuItem = $value['montoDescu'];

            $subTotalItem = $precioUniItem * $cantidadItem - $montoDescuItem;
            $retencionItem = $subTotalItem * 0.1;

            $subTotal += $subTotalItem;
            $totalCompra += $compraItem;
            $totalDescu += $montoDescuItem;
            $descu += $montoDescuItem;
            $totalPagar += $subTotalItem - $retencionItem;

            $reteRenta += $retencionItem;
        }

        $reteRenta = round($reteRenta, 2);
        $totalPagar = round($totalPagar, 2);

        $totalLetras = Generator::generateStringFromNumber($totalPagar);

        $resumen = compact( 
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
        );

        return $resumen;
    }

}
