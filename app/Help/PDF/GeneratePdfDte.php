<?php

namespace App\Help\PDF;

use App\Models\MH\MHDepartamento;
use App\Models\MH\MHMunicipio;
use App\Models\MH\MHTipoDocumentoReceptor;
use App\Models\MH\MHUnidadMedidaModel;
use App\Models\RegistroDTE;
use Carbon\Carbon;

class GeneratePdfDte
{
    public function generateStructure(RegistroDTE $data)
    {

        $dte = json_decode($data->dte, true);
        $response = json_decode($data->response, true);
        $numControl = $data->numero_dte;
        $tipoDoc = $data->tipoDocumento->valor;

        $receptor = $this->generateClient($dte['receptor']);
        $emisor = $this->generateEmisor($dte['emisor']);
        $respuesta = $this->generateDteInfo($response, $numControl, $tipoDoc);
        $cuerpoDoc = $this->generateCuerpoDocumento($dte['cuerpoDocumento']);

        return compact(['receptor', 'emisor', 'respuesta', 'cuerpoDoc']);
    }

    private function generateClient($client)
    {

        return [
            'tipoDoc' => isset($client['nit']) ? 'NIT' : (MHTipoDocumentoReceptor::where($client['tipoDocumento'])->first())?->valor,
            'numDoc' => isset($client['nit']) ? $client['nit'] : $client['numDocumento'],
            'nrc' => $client['nrc'],
            'departamento' => (MHDepartamento::where('codigo', $client['direccion']['departamento'])->first())?->valor,
            'municipio' => (MHMunicipio::where('departamento', $client['direccion']['departamento'])
                ->where('codigo', $client['direccion']['municipio'])->first())?->valor,
            'complemento' => $client['direccion']['complemento'],
            'nombre' => $client['nombre'],
            'telefono' => $client['telefono'] ?? 'No definido',
            'correo' => $client['correo'] ?? 'No definido',
        ];
    }

    private function generateEmisor($emisor)
    {

        return [
            'numDoc' => isset($emisor['nit']) ? $emisor['nit'] : $emisor['numDocumento'],
            'nrc' => $emisor['nrc'],
            'departamento' => (MHDepartamento::where('codigo', $emisor['direccion']['departamento'])->first())?->valor,
            'municipio' => (MHMunicipio::where('departamento', $emisor['direccion']['departamento'])
                ->where('codigo', $emisor['direccion']['municipio'])->first())?->valor ?? 'No definido',
            'complemento' => $emisor['direccion']['complemento'],
            'telefono' => $emisor['telefono'] ?? 'No definido',
            'correo' => $emisor['correo'] ?? 'No definido',
        ];
    }

    private function generateDteInfo($info, $numControl, $tipoDoc)
    {

        $fechaRaw = Carbon::createFromFormat('d/m/Y H:i:s', $info['fhProcesamiento']);

        $fecha = $fechaRaw->format('d/m/Y');
        $hora = $fechaRaw->format('H:i:s');

        return [
            "tipo" => strtoupper($tipoDoc),
            "codigo" => $info['codigoGeneracion'],
            "sello" => $info['selloRecibido'],
            "version" => $info['version'],
            "ambiente" => $info['ambiente'] == '00' ? 'Prueba' : 'Productivo',
            "numControl" => $numControl,
            "fecha" => $fecha,
            "hora" => $hora,
        ];
    }

    private function generateCuerpoDocumento($cuerpo)
    {

        $array = [];

        foreach ($cuerpo as $item) {

            $gravada = $item['ventaGravada'];

            if ( isset($item['ivaItem']) )
                $gravada += $item['ivaItem'];
            else 
                $gravada += $gravada * 0.13;

            $piece = [
                'numItem' => $item['numItem'],
                'cantidad' => $item['cantidad'],
                'medida' => (MHUnidadMedidaModel::where("codigo", $item['uniMedida'])->first())?->valor ?? 'Indefinido',
                'descripcion' => $item['descripcion'],
                'precioUni' => number_format($item['precioUni'], 2, '.', ''),
                'descu' => number_format($item['montoDescu'], 2, '.', ''),
                'noSuj' => number_format($item['ventaNoSuj'], 2, '.', ''),
                'exenta' => number_format($item['ventaExenta'], 2, '.', ''),
                'gravada' => number_format($gravada, 2, '.', ''),
            ];

            $array[] = $piece;
        }

        return $array;
    }

    private function format_number(int|float $number)
    {
        return floor($number * 10000) / 10000;
    }
}
