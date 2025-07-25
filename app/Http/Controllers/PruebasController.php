<?php

namespace App\Http\Controllers;

use App\Help\Help;
use Illuminate\Http\Request;

class PruebasController extends Controller
{
    //
    public function empresa(Request $request){
        return response()->json([
            Help::getEmpresa()
        ]);
    }

    public function usuario(Request $request){
        return response()->json([
            Help::getUsuario()
        ]);
    }
}
