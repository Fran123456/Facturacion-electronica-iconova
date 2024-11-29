<?php
namespace App\Help\DTEHelper;

class DCLDTE {

    public static function getCuerpo($items): ?array
    {
        if ($items == null) return null;

        foreach ($items as $key => $item) {
            $item[$key]["numItem"] = $key + 1;
        }

        return $items;
    }

}
