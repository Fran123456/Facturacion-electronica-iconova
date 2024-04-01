<?php
namespace App\Help\DTEHelper;
use App\Models\MH\MHIncoterms;
use App\Help\Help;

class FEXDTE
{
    public static function BuildDetalle($detalles){
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
            $unidad='99';
            if(  isset($value['uniMedida'] )  ){
                $unidad=$value['uniMedida'] ;
            }else{

            }

            $ar = array(
                "numItem"=> $key+1, 
                "codigo"=>null,
                "descripcion"=> $value['descripcion'],
                "cantidad"=> $value['cantidad'],
                "uniMedida"=> $unidad, 
                "precioUni"=> $value['precioUni'],
                "montoDescu"=> $value['montoDescu'],
                "ventaGravada"=> $value['ventaGravada'],
                "tributos"=> null,
                "noGravado"=> $value['noGravado'],
            );

            array_push($data, $ar);
        }
        return $data;

    }

    public static function Resumen($detalles, $condicionPago=1,  $pagos, $incoterms='05'){
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
        
        $totalGravadas=0;
        $totalDescuentos=0;
        $porcentajeDescuento=0;
        $totalDescu=0;
        $seguro=0;
        $flete=0;
        $montoTotalOperacion=0;
        $totalNoGravado=0;
        $totalPagar=0;
        foreach ($detalles as $key => $value) {
            $totalGravadas=$totalGravadas+$value['ventaGravada'];
            $totalDescuentos=$totalDescuentos+$value['montoDescu'];
            $totalDescu=$totalDescu+$totalDescuentos+$value['montoDescu'];
            $montoTotalOperacion=$montoTotalOperacion+$value['ventaGravada'];
            $totalPagar=$totalPagar+$value['ventaGravada'];

        }
        $totalLetras=Help::numberToString($totalPagar);
        $arrayPagos = array();
        $pagosAux=[
                "codigo"=> $pagos['codigo']??'01',
                "montoPago"=>  $totalPagar,
                "referencia"=>  $pagos['referencia']??"Sin referencia",
                "periodo"=> null,
                "plazo"=>$pagos['plazo']??'01'
        ];
        array_push($arrayPagos, $pagosAux);

        $inco =MHIncoterms::where('codigo', $incoterms)->first();

        $resumen = [
            "totalGravada"=> $totalGravadas,
            "descuento"=> $totalDescuentos,
            "porcentajeDescuento"=> $porcentajeDescuento,
            "totalDescu"=> $totalDescu,
            "seguro"=> $seguro,
            "flete"=> $flete,
            "montoTotalOperacion"=> $montoTotalOperacion,
            "totalNoGravado"=> $totalNoGravado,
            "totalPagar"=>  $totalPagar,
            "totalLetras"=>$totalLetras,
            "condicionOperacion"=> $condicionPago,
            "pagos"=> [$pagosAux],
            "numPagoElectronico"=> null,
            "codIncoterms"=>$inco->codigo,
            "descIncoterms"=> $inco->valor,
            "observaciones"=>null
        ];
        return $resumen;



    }

    public static function Apendice(){
        return [
            "campo" => "Datos del Vendedor",
            "etiqueta" => "Nombre del Vendedor",
            "valor" => "000000000 - Administrador"
        ];
        
    }

}












