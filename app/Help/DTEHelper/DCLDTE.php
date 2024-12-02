<?php
namespace App\Help\DTEHelper;

use App\Help\Generator;

class DCLDTE {

    public static function getCuerpo($item): ?array
    {
        if ($item == null) return null;


        $total = $item['subTotal'];
        $item['totalLetras'] = 'USD ' . Generator::generateStringFromNumber($total);
        
        return $item;
    }

}
