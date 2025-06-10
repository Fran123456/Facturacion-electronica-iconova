<?php

namespace App\Http\Controllers;

use App\Help\Help;
use App\Models\MH\MHActividadEconomica;
use App\Models\MH\MHDepartamento;
use App\Models\MH\MHFormaPago;
use App\Models\MH\MHMunicipio;
use App\Models\MH\MHPais;
use App\Models\MH\MHTipoDocumento;
use App\Models\MH\MHTipoDocumentoReceptor;
use App\Models\MH\MHTipoInvalidacion;
use App\Models\MH\MHTipoPersonaModel;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class InfoController extends Controller
{

    public function pdf()
    {
        $data = [
            'cliente' => 'Juan Pérez',
            'nit_cliente' => '0614-XXXXXX-101-1',
            'direccion_cliente' => 'San Salvador',
            'fecha' => now()->format('d/m/Y'),
            'items' => [
                ['cantidad' => 2, 'descripcion' => 'Servicio de mantenimiento', 'precio' => 50, 'total' => 100],
                ['cantidad' => 1, 'descripcion' => 'Instalación de software', 'precio' => 75, 'total' => 75],
            ],
            'subtotal' => 175,
            'iva' => 22.75,
            'total' => 197.75,
            'observaciones' => 'Pago recibido en efectivo. Gracias por su preferencia.',
        ];
    
        $pdf =Pdf::loadView('factura.plantilla', $data);
        return $pdf->stream('factura.pdf'); // o ->download('factura.pdf')
    }


    
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
