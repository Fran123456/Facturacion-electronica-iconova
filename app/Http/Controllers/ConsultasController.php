<?php

namespace App\Http\Controllers;

use App\help\Help;
use App\Help\Services\DteApiMHService;
use App\Http\Requests\ConsultaRequest;
use App\Http\Resources\RegistroDTEResource;
use App\Models\RegistroDTE;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ConsultasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ConsultaRequest $request)
    {

        $request->validated();

        $tipodocumento = $request->query('tipoDocumento');
        $fechaInicio = $request->query('fechaInicio');
        $fechaFin = $request->query('fechaFin');
        $estado = $request->query('estado');

        try {
            $fechaInicioObj = Carbon::parse($fechaInicio);
            $fechaFinObj = Carbon::parse($fechaFin);
    
    
            if ($fechaInicio && $fechaFin) {
                if (!$fechaInicioObj->greaterThanOrEqualTo($fechaFinObj)) {
                    return response()->json(['error' => 'La fecha de inicio debe ser menor o igual a la fecha de fin'], 400);
                }
            }
    
            // Inicializar la consulta y cargar la relación 'tipoDocumento' 
            $query = RegistroDTE::with('tipoDocumento');
    
            $query->where('id_empresa', Help::getEmpresa()->id);
    
            if ($tipodocumento) {
                $query->where('tipo_documento', $tipodocumento);
            }
    
            if ($fechaInicio || $fechaFin) {
    
                $fechaInicio = $fechaInicio ?? date('Y-m-d');
    
                if (!$fechaFin && $fechaInicio) {
                    $fecha = Carbon::parse($fechaInicio);
                    $fechaFin = $fecha->subMonth()->format('Y-m-d');
                }
    
                // return $fechaFin;
            }
    
            if ($fechaInicio && $fechaFin) {
                $query->whereBetween('fecha_recibido', [$fechaFin, $fechaInicio]);
            }
    
            if ($estado) {
                $query->where('estado', $estado);
            }
    
            $registros = $query->get();
    
            return RegistroDTEResource::collection($registros);

        } catch (Exception $e) {
            return response()->json(
                [
                    'error' => $e->getMessage()
                ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {
            $registro = RegistroDTE::with('tipoDocumento')->find($id);

            if (!$registro) {
                return response()->json(['error' => 'Registro no encontrado'], 404);
            }

            return new RegistroDTEResource($registro);
        } catch (Exception $e) {
            return response()->json(
                [
                    'error' => $e->getMessage()
                ], 500);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ConsultaRequest $request)
    {
        
        $json = $request->json()->all();

        $id = $json['id'];
        $dte = $json['dte'];

        try {

            $fechaHora = new \DateTime();

            $dte['identificacion']['fecEmi'] = $fechaHora->format('Y-m-d');
            $dte['identificacion']['horEmi'] = $fechaHora->format('H:i:s');

            [$responseData, $statusCode] = DteApiMHService::resend($dte, $id, $dte['identificacion']);
            return response()->json($responseData, $statusCode);

        } catch (Exception $e) {
            return response()->json(
                [
                    'error' => $e->getMessage()
                ], 500);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
