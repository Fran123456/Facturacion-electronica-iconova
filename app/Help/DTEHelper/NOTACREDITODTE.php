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

}












