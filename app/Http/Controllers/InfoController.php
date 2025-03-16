<?php

namespace App\Http\Controllers;

use App\help\Help;
use App\Models\MH\MHFormaPago;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    //
    public function empresa(Request $request){
        return response()->json([
            Help::getEmpresaByCript()
        ]);
    }



    public function formaPagoCatalogo(Request $request){
        return response()->json(
            MHFormaPago::all()
        );
    }
 
}
