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
            //^ Inicializar la consulta y cargar la relación 'tipoDocumento' 
            $query = RegistroDTE::with('tipoDocumento');
    
            $query->where('empresa_id', Help::getEmpresa()->id);
    
            if ($tipodocumento) {
                $query->where('tipo_documento', $tipodocumento);
            }
    
            //* Si se envía fechaInicio o fechaFin se filtra por rango de fechas
            if ($fechaInicio || $fechaFin) {
    
                $fechaInicio = $fechaInicio ?? date('Y-m-d');
    
                if (!$fechaFin && $fechaInicio) {
                    $fecha = Carbon::parse($fechaInicio);
                    //* Se resta un mes a la fecha de inicio si no se envía fecha fin
                    $fechaFin = $fecha->subMonth()->format('Y-m-d');
                }

            }

            //* Se filtra por rango de fechas
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

            //* Se crea un resource para devolver el registro
            return new RegistroDTEResource($registro);
        } catch (Exception $e) {
            //* Si ocurre un error se devuelve un mensaje de error
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
        //* Endpoint para reenviar un DTE no validado por Hacienda
        $json = $request->json()->all();

        $id = $json['id'];
        $dte = $json['dte'];

        try {
            //* Se obtiene la fecha y hora actual para el reenvío
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
}
