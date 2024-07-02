<?php
namespace App\Help\DTEHelper;
use App\Models\MH\MHIncoterms;
use App\Help\Help;

class NOTACREDITODTE
{



    public static function extension($observacion){
        return [
            "docuEntrega" => null,
            "observaciones" => $observacion,
            "nombRecibe" => null,
            "nombEntrega"=> null,
            "docuRecibe"=> null,
        ];
    }

    public static function cuerpo($body){

        foreach ($body as &$value) {
            $value['tributos']= array(20);
            $value['codigo'] =null;
        }
        return $body;
    }

    public static function documentosRelacionados($relacionados){

        foreach ($relacionados as &$value) {
            $value['tipoGeneracion']= 2;
        }
        return $relacionados;
    }

    public static function resumen($body){
        $totalNoSuj =0;
        $descuNoSuj =0;
        $ivaRete1 =0;
        $subTotalVentas =0;
        $reteRenta=0;
        foreach ($body as $key => $value) {

            $totalNoSuj=$totalNoSuj+$value['ventaNoSuj'];
        }

        return array(
            "totalNoSuj"=>$totalNoSuj,
            'ivaPerci1'=>0,
            "descuNoSuj"=>0,
            "totalLetras"=> "pendiente",
            "ivaRete1"=>0,
            "subTotalVentas"=> 0,
            "subTotal"=> 0,
            "reteRenta"=> 0,
            "reteRenta"=> 0,
            "tributos"=> array(
                "descripcion"=> "Impuesto al Valor Agregado 13%",
                "codigo"=> "20",
                "valor"=> 0,
            ),
            "descuExenta"=> 0,
            "totalDescu"=> 0,
            "descuGravada"=> 0,
            "totalGravada"=> 0,
            "montoTotalOperacion"=> 0,
            "totalExenta"=> 0,
            "condicionOperacion"=> 2,
        );
    }

}












