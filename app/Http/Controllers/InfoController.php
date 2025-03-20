<?php

namespace App\Http\Controllers;

use App\help\Help;
use App\Models\MH\MHActividadEconomica;
use App\Models\MH\MHFormaPago;
use Database\Seeders\MHCodigoActividadEconomica;
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

    public function actividadEconomicaByCode(Request $request){
        return response()->json(
          MHActividadEconomica::where('codigo', $request->codigo)->first()
        );
    }
 
}
