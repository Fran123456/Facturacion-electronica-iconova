<?php

namespace App\Http\Controllers;

use App\help\Help;
use App\Models\MH\MHActividadEconomica;
use App\Models\MH\MHDepartamento;
use App\Models\MH\MHFormaPago;
use App\Models\MH\MHMunicipio;
use App\Models\MH\MHPais;
use App\Models\MH\MHTipoDocumento;
use App\Models\MH\MHTipoDocumentoReceptor;
use App\Models\MH\MHTipoInvalidacion;
use App\Models\MH\MHTipoPersonaModel;

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

    public function actividadEconomicaByCode(Request $request, $codigo){
        $data = MHActividadEconomica::where('codigo', $codigo)->first();
        return response()->json(
            $data
        );
    }

    public function paises(Request $request){
        return response()->json(
            MHPais::select('id', 'codigo', 'valor')->get()
        );
    }

    public function distritos(Request $request){
        return response()->json(
            MHMunicipio::select('id', 'codigo', 'valor', 'departamento')->get()
        );
    }
    
    public function distrito(Request $request){
        return response()->json(
            MHMunicipio::select('codigo')->where('id', $request->input('id'))->first()
        );
    }

    public function departamentos(Request $request){
        return response()->json(
            MHDepartamento::select('id', 'codigo', 'valor')->get()
        );
    }

    public function tiposPersona(Request $request){
        return response()->json(
            MHTipoPersonaModel::select('id', 'codigo', 'valor')->get()
        );
    }

    public function codigosActividad(Request $request){
        return response()->json(
            MHActividadEconomica::select('id', 'codigo', 'valor')->get()
        );
    }

    public function tiposDocumento(Request $request){
        return response()->json(
            MHTipoDocumento::select('id', 'codigo', 'valor')->get()
        );
    }

    public function tiposDocumentoReceptor(Request $request){
        return response()->json(
            MHTipoDocumentoReceptor::select('id', 'codigo', 'valor')->get()
        );
    }

    public function tipoInvalidacion(){
        return response()->json(
            MHTipoInvalidacion::whereIn('codigo', [2])->get()
        );
    }

}
