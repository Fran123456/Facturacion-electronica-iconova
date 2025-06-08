<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistroDTEResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'tipo_documento' => $this->tipo_documento,
            'descripcion_tipo_documento' => $this->tipoDocumento->valor,
            'dte' => $this->dte,
            'codigo_generacion' => $this->codigo_generacion,
            'numero_dte' => $this->numero_dte,
            'sello' => $this->sello,
            'estado' => $this->estado,
            'fecha_recibido' => $this->fecha_recibido->format('Y/m/d'),
            'observaciones' => $this->observaciones,
            'fecha_invalidado' => $this->invalidado?->created_at?->format('Y/m/d H:i:s'),
        ];
    }
}
