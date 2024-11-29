<?php

namespace App\Help\DTEHelper;

use App\Models\MH\MHIncoterms;
use App\Help\Help;

class FEXDTE
{
    public static function BuildDetalle($detalles)
    {
        /*
            "numItem": 1,
            "codigo": null,
            "descripcion": "TELEFONO A54 5G",
            "cantidad": 100.00000000,
            "uniMedida": 59,
            "precioUni": 444.0,
            "montoDescu": 0,
            "ventaGravada": 44400.0,
            "tributos": null,
            "noGravado": 0
         */
        $data = array();
        foreach ($detalles as $key => $value) {
            $unidad = '99';
            if (isset($value['uniMedida'])) {
                $unidad = $value['uniMedida'];
            }

            $ar = array(
                "numItem" => $key + 1,
                "codigo" => null,
                "descripcion" => $value['descripcion'],
                "cantidad" => $value['cantidad'],
                "uniMedida" => $unidad,
                "precioUni" => $value['precioUni'],
                "montoDescu" => $value['montoDescu'],
                "ventaGravada" => $value['ventaGravada'],
                "tributos" => null,
                "noGravado" => $value['noGravado'],
            );

            array_push($data, $ar);
        }
        return $data;
    }


    public static function getCuerpoDocumento($items)
    {
        if ($items == null)
            return null;

        foreach ($items as $key => $item) {

            $item[$key]["numItem"] = $key + 1;

            // REDONDENANDO VALORES DEFINIDOS POR LE USUARIO
            $cantidad = intval($item['cantidad']);

            // CAMPOS CON VALORES PREDEFINIDOS

            // CAMPOS CON VALORES DEFINIDOS POR EL USUARIO
            $items[$key]['cantidad'] = $cantidad;
        }

        return $items;
    }

    public static function Resumen($cuerpoDocumento, $pagos, $codigoPago, $plazoPago = null, $periodoPago = null, $condicionPago = 1, $incoterms = '05')
    {
        /*
         * "resumen": {
                "totalGravada": 47400.0,
                "descuento": 0,
                "porcentajeDescuento": 0,
                "totalDescu": 0,
                "seguro": 0,
                "flete": 0,
                "montoTotalOperacion": 47400.0,
                "totalNoGravado": 0,
                "totalPagar": 47400.0,
                "totalLetras": "USD CUARENTA Y SIETE MIL CUATROCIENTOS  CON 00/100 ",
                "condicionOperacion": 1,
                "pagos": [
                    {
                        "codigo": "01",
                        "montoPago": 47400.0,
                        "referencia": "PAGO EN EFECTIVO",
                        "periodo": null,
                        "plazo": null
                    }
                ],
                "numPagoElectronico": null,
                "codIncoterms": "11",
                "descIncoterms": "CIF- Costo seguro y flete",
                "observaciones": null
            },
         *
         */
        $impuestos = 0.0;

        $totalGravadas = 0;
        $totalDescuentos = 0;
        $porcentajeDescuento = 0;
        $totalDescu = 0;
        $seguro = 0;
        $flete = 0;
        $montoTotalOperacion = 0;
        $totalNoGravado = 0;
        $totalPagar = 0;

        $pagosAux = null;

        foreach ($cuerpoDocumento as $key => $value) {

            $gravadaItem = $value['ventaGravada'];
            $descuentoItem = $value['montoDescu'];
            $noGravadaItem = $value['noGravado'];

            $totalGravadas += $gravadaItem;
            $totalDescuentos += $descuentoItem;
            $totalNoGravado += $noGravadaItem;

            $ivaItem = 0;
            $impuestosItem = 0;

            // Procesar tributos si existen
            if ($pagos != null) {
                $pagoTributo = $pagos[$key];

                foreach ($pagoTributo as $keyObjec => $valorObjec) {

                    // 20 es la clave para el item en la tabla MH_Tributo para identificar el iva
                    if ( $keyObjec == "20" ){
                        $ivaItem = $valorObjec;
                        continue;
                    }

                    $impuestosItem += $valorObjec;
                    $impuestos += $impuestosItem;
                }
            }

            $totalPagarItem = $gravadaItem + $noGravadaItem + $ivaItem + $impuestosItem - $descuentoItem;
            $totalPagar += $totalPagarItem;

            $pagosAux[] = [
                "codigo" => $codigoPago,
                "montoPago" =>  $totalPagarItem,
                "referencia" => "Sin referencia",
                "periodo" => $periodoPago,
                "plazo" => $plazoPago
            ];
        }

        $totalLetras = Help::numberToString($totalPagar);

        $inco = null;
        if ( is_null($incoterms) ||  empty ($incoterms) )
            $inco = MHIncoterms::where('codigo', $incoterms)->first();

        $montoTotalOperacion = $totalGravadas + $totalNoGravado + $impuestos;

        $resumen = [
            "totalDescu" => $totalDescu,
            "totalNoGravado" => $totalNoGravado,
            "totalGravada" => $totalGravadas,
            "totalPagar" =>  $totalPagar,

            "montoTotalOperacion" => $montoTotalOperacion,
            "porcentajeDescuento" => $porcentajeDescuento,
            "seguro" => $seguro,
            "flete" => $flete,

            "descuento" => $totalDescuentos,
            "codIncoterms" => $inco ? $inco->codigo : null,
            "descIncoterms" => $inco ? $inco->valor : null,
            "totalLetras" => $totalLetras,
            "pagos" => $pagosAux,
            "numPagoElectronico" => null,
            "observaciones" => null,
            "condicionOperacion" => $condicionPago
        ];
        return $resumen;
    }

    public static function Apendice()
    {
        return [
            "campo" => "Datos del Vendedor",
            "etiqueta" => "Nombre del Vendedor",
            "valor" => "000000000 - Administrador"
        ];
    }
}
