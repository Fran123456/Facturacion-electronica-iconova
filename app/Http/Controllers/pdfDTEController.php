<?php

namespace App\Http\Controllers;


use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Storage;
use App\help\Help;
use App\Help\PDF\GeneratePdfDte;
use App\Models\Empresa;
use App\Models\MH\MHDepartamento;
use App\Models\MH\MHTipoDocumentoReceptor;
use App\Models\RegistroDTE;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Illuminate\Support\Facades\Crypt;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class PdfDTEController extends Controller

{

    public function test(Request $request, $empresaId)
    {
        $dte = RegistroDTE::with([
            'tipoDocumento'
        ])->find(7);

        $empresa = Empresa::find($empresaId);
        $ambiente = $empresa->ambiente;
        $gen = $dte->codigo_generacion;
        $emision = $dte->fecha_recibido;
        $emision = \Carbon\Carbon::parse($emision)->toDateString();
        $url = 'https://admin.factura.gob.sv/consultaPublica?ambiente=' . $ambiente . '&codGen=' . $gen . '&fechaEmi=' . $emision;


        // Configurar el tamaño y otras opciones
        // Configurar tamaño y demás
        $qrCode = new QrCode($url);

        // Opciones
        $qrCode->setSize(200);
        $qrCode->setMargin(10);


        // Usar el writer
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Obtener el contenido como string
        $qrContent = $result->getString();

        // Codificar en base64
        $qr = base64_encode($qrContent);
        return $qr;


        // return (new GeneratePdfDte)->generateStructure($dte);

        $data = (new GeneratePdfDte)->generateStructure($dte);

        $pdf = DomPDF::loadView('pdf.plantillaDte', compact('data', 'empresa', 'url', 'qr')); // Carga la vista con los datos
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('dte.pdf'); // Muestra el PDF en el navegador
    }

    public function generarPdf($CodGeneracion)
    {

        $data = $this->documentData($CodGeneracion);
        $url = $data['url'];
        $qr = $data['qr'];
        $data = $data['data'];
        $pdf = DomPDF::loadView('pdf.plantillaDteNew', compact('data', 'url', 'qr')); // Carga la vista con los datos
        return $pdf->setPaper('A4', 'portrait');
    }

    public function document($CodGeneracion)
    {

        $data = $this->documentData($CodGeneracion);



        $url = $data['url'];
        $qr = $data['qr'];
        $data = $data['data'];


        //CCF, Exportacion, Factura
        $pdf = DomPDF::loadView('pdf.plantillaDteNew', compact('data', 'url', 'qr')); // Carga la vista con los datos


        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('dte.pdf'); // Muestra el PDF en el navegador
    }


    public function documentData($CodGeneracion)
    {

        $registroDTE =  RegistroDTE::where('codigo_generacion', $CodGeneracion)->first();


        //Información del DTE
        $sello = $registroDTE?->sello;
        $codigo_generacion = $registroDTE->codigo_generacion;
        $tipo_documento = $registroDTE->tipo_documento;
        $numero_dte = $registroDTE->numero_dte;
        $JsonDTE = json_decode($registroDTE->dte, true);

        //DATA DEL EMISOR
        $emisor_activida_economica = $JsonDTE["emisor"]["descActividad"];
        $emisor_nit = $JsonDTE["emisor"]["nit"];
        $emisor_nrc = $JsonDTE["emisor"]["nrc"];
        $emisor_correo = $JsonDTE["emisor"]["correo"];
        $emisor_direccion = $JsonDTE["emisor"]["direccion"]["complemento"];
        $emisor_municipio = $JsonDTE["emisor"]["direccion"]["municipio"];
        $emisor_departamento = $JsonDTE["emisor"]["direccion"]["departamento"];
        $emisor_municipio = DB::table('mh_municipio')->where('codigo', $emisor_municipio)->first()?->valor;
        $emisor_departamento = DB::table('mh_departamento')->where('codigo', $emisor_departamento)->first()?->valor;
        $emisor_nombre = $JsonDTE["emisor"]["nombre"];
        $emisor_telefono = $JsonDTE["emisor"]["telefono"];

        if ($tipo_documento == "14") {
            $emisor_nombreComercial = $JsonDTE["emisor"]["nombre"];
        } else {
            $emisor_nombreComercial = $JsonDTE["emisor"]["nombreComercial"];
        }
        //DATA DEL EMISOR


        //DATOS DEL RECEPTOR (ACTIVIDAD ECONOMICA)
        if ($tipo_documento == "11") { //Exportacion
            $receptor_codActividad = null;
            $receptor_descActividad = null;
        } else if ($tipo_documento == "14") //sujeto excluido
        {
            $receptor_codActividad = null;
            $receptor_descActividad = null;
        } else {
            $receptor_codActividad = $JsonDTE["receptor"]["codActividad"];
            $receptor_descActividad = $JsonDTE["receptor"]["descActividad"];
        }


        //DATOS DEL RECEPTOR (NUMERO Y TIPO DE DOCUMENTO)
        $receptor_nit = "";
        $receptor_tipoDocumento = null;
        $receptor_numDocumento = null;
        if ($tipo_documento == "03" || $tipo_documento == "05") { //ccf Y nota de credito
            if ($JsonDTE["receptor"]["nit"] != null) {
                $receptor_numDocumento = $JsonDTE["receptor"]["nit"];
                $receptor_tipoDocumento = "NIT";
            }
        } else if ($tipo_documento == "01") //factura
        {
            $receptor_numDocumento = isset($JsonDTE["receptor"]["numDocumento"]) ? $JsonDTE["receptor"]["numDocumento"] : "";
            $receptor_tipoDocumento = isset($JsonDTE["receptor"]["tipoDocumento"]) ? $JsonDTE["receptor"]["tipoDocumento"] : "";
            $receptor_tipoDocumento = MHTipoDocumentoReceptor::where('codigo', $receptor_tipoDocumento)->first()?->valor;
        } else if ($tipo_documento == "14") {
            $receptor_numDocumento = isset($JsonDTE["sujetoExcluido"]["numDocumento"]) ? $JsonDTE["sujetoExcluido"]["numDocumento"] : "";
            $receptor_tipoDocumento = isset($JsonDTE["sujetoExcluido"]["tipoDocumento"]) ? $JsonDTE["sujetoExcluido"]["tipoDocumento"] : "";
            $receptor_tipoDocumento = MHTipoDocumentoReceptor::where('codigo', $receptor_tipoDocumento)->first()?->valor;
        }
        //DATOS DEL RECEPTOR (NUMERO Y TIPO DE DOCUMENTO)

        //DATOS DEL RECEPTOR (MUNICIPIO, DEPARTAMENTO, DIRECCION)
        if ($tipo_documento == "11") { //Exportacion
            $receptor_municipio = null;
        } else if ($tipo_documento == "14") { //sujeto excluido
            $receptor_municipio = $JsonDTE["sujetoExcluido"]["direccion"]["municipio"];
            $receptor_municipio = DB::table('mh_municipio')->where('codigo', $receptor_municipio)->first()?->valor;
        } else { //otros
            $receptor_municipio = $JsonDTE["receptor"]["direccion"]["municipio"];
            $receptor_municipio = DB::table('mh_municipio')->where('codigo', $receptor_municipio)->first()?->valor;
        }


        if ($tipo_documento == "11") {
            $receptor_departamento = null;
        } else if ($tipo_documento == "14") {
            $receptor_departamento = $JsonDTE["sujetoExcluido"]["direccion"]["departamento"];
            $receptor_departamento = DB::table('mh_departamento')->where('codigo', $receptor_departamento)->first()?->valor;
        } else {
            $receptor_departamento = $JsonDTE["receptor"]["direccion"]["departamento"];
            $receptor_departamento = DB::table('mh_departamento')->where('codigo', $receptor_departamento)->first()?->valor;
        }

        $receptor_direccion = "";
        if ($tipo_documento == "11") {
            $receptor_direccion = $JsonDTE["receptor"]["complemento"];
        } else if ($tipo_documento == "14") {

            $receptor_direccion = $JsonDTE["sujetoExcluido"]["direccion"]['complemento'];
        } else {
            $receptor_direccion = $JsonDTE["receptor"]["direccion"]["complemento"];
        }
        //DATOS DEL RECEPTOR (MUNICIPIO, DEPARTAMENTO, DIRECCION)

        //DATOS DEL RECEPTOR (NRC)
        $receptor_nrc = isset($JsonDTE["receptor"]["nrc"]) ? $JsonDTE["receptor"]["nrc"] : null;
        //DATOS DEL RECEPTOR (NRC)



        //DATOS DEL RECEPTOR (NOMBRE , TELEFONO, CORREO)
        if ($tipo_documento == "14") {
            $receptor_nombre = $JsonDTE["sujetoExcluido"]["nombre"];
            $receptor_telefono = $JsonDTE["sujetoExcluido"]["telefono"];
            $receptor_correo = $JsonDTE["sujetoExcluido"]["correo"];
        } else {
            $receptor_nombre = $JsonDTE["receptor"]["nombre"];
            $receptor_telefono = $JsonDTE["receptor"]["telefono"];
            $receptor_correo = $JsonDTE["receptor"]["correo"];
        }
        //DATOS DEL RECEPTOR (NOMBRE , TELEFONO, CORREO)

        //DATOS DEL RECEPTOR (OPERACIONES NUMERICAS)
        $renta = 0;
        if ($tipo_documento == "11") {
            $total_subtotal  = $JsonDTE["resumen"]["montoTotalOperacion"];
            $ivaRete1 = 0;
            $total_retencionrenta = 0;
            $total_ivaretenido = 0;
            $total_totalgravado = $JsonDTE["resumen"]["totalGravada"];
            $total_montototaloperaciones = $JsonDTE["resumen"]["montoTotalOperacion"];
            $totalPagar = $JsonDTE["resumen"]["totalPagar"];
        } else if ($tipo_documento == "14") {
            $total_subtotal  = $JsonDTE["resumen"]["totalPagar"];
            $ivaRete1 = 0;
            $total_retencionrenta = 0;
            $total_ivaretenido = 0;
            $total_totalgravado = $JsonDTE["resumen"]["totalCompra"];
            $total_montototaloperaciones = $JsonDTE["resumen"]["totalPagar"];
            $renta = $JsonDTE["resumen"]["reteRenta"];
            $totalPagar = $JsonDTE["resumen"]["totalPagar"];
        } else if ($tipo_documento == "05") {
            $total_subtotal = $JsonDTE["resumen"]["subTotal"];
            $ivaRete1 = $JsonDTE["resumen"]["ivaRete1"];
            $total_retencionrenta = $JsonDTE["resumen"]["reteRenta"];
            $total_ivaretenido = $JsonDTE["resumen"]["ivaRete1"];
            $total_totalgravado = $JsonDTE["resumen"]["totalGravada"];
            $total_montototaloperaciones = $JsonDTE["resumen"]["montoTotalOperacion"];
            $totalPagar = $JsonDTE["resumen"]["montoTotalOperacion"];
        } else {
            $total_subtotal = $JsonDTE["resumen"]["subTotal"];
            $ivaRete1 = $JsonDTE["resumen"]["ivaRete1"];
            $total_retencionrenta = $JsonDTE["resumen"]["reteRenta"];
            $total_ivaretenido = $JsonDTE["resumen"]["ivaRete1"];
            $total_totalgravado = $JsonDTE["resumen"]["totalGravada"];
            $total_montototaloperaciones = $JsonDTE["resumen"]["montoTotalOperacion"];
            $totalPagar = $JsonDTE["resumen"]["totalPagar"];
        }



        $total_descuentonosujetas = isset($JsonDTE["resumen"]["descuNoSuj"]) ? $JsonDTE["resumen"]["descuNoSuj"] : 0;
        $total_totalexenta = isset($JsonDTE["resumen"]["totalExenta"]) ? $JsonDTE["resumen"]["totalExenta"] : 0;
        $total_totalnogravado =  isset($JsonDTE["resumen"]["totalNoGravado"]) ? $JsonDTE["resumen"]["totalNoGravado"] : 0;

        $fecha_emision = $JsonDTE["identificacion"]["fecEmi"];
        $hora_emision =  $JsonDTE["identificacion"]["horEmi"];
        $emision = $fecha_emision . " " . $hora_emision;

        $ambiente = $JsonDTE["identificacion"]["ambiente"];
        $tipoDte = $JsonDTE["identificacion"]["tipoDte"];
        $versionjson = $JsonDTE["identificacion"]["version"];
        $cur_datos_documento = Help::getDatosDocumento($tipoDte);
        $cur_descript_doc = strtoupper($cur_datos_documento['valor']);

        //DOCUMENTO RELACIONADO
        $dteRel = null;
        if($tipo_documento == "05")
        {
            $dteRel = RegistroDTE::where('codigo_generacion', $JsonDTE['documentoRelacionado'][0]['numeroDocumento'])?->first();
           
        // $dteRel->fecha_recibido = Carbon::createFromFormat('d/m/Y',$dteRel->fecha_recibido );

        }

        // Setup a filename
        $documentFileName = $CodGeneracion . ".pdf";
        $total_totaliva = 0;
        if ($tipoDte != '01') {
            // 01=Factura, 03=CCF
            if (isset($JsonDTE["resumen"]["tributos"]["valor"])) {
                $total_totaliva = $JsonDTE["resumen"]["tributos"]["valor"];
            } elseif (isset($JsonDTE["resumen"]["tributos"][0]["valor"])) {
                $total_totaliva = $JsonDTE["resumen"]["tributos"][0]["valor"];
            } elseif (isset($JsonDTE["resumen"]["totalIva"])) {
                $total_totaliva = $JsonDTE["resumen"]["totalIva"];
            }
        }


        $url = 'https://admin.factura.gob.sv/consultaPublica?ambiente=' . $ambiente . '&codGen=' . $codigo_generacion . '&fechaEmi=' . $fecha_emision;

        $aDetalle = $JsonDTE["cuerpoDocumento"];
        $Html_detalle = "";
        $tNoSujeta = 0;
        $tExenta   = 0;
        $tGravada  = 0;

        foreach ($aDetalle as $row) {

            $sDesc = str_split($row["descripcion"], 60);

            $cantidad = $row["cantidad"];
            $preciouni = $row["precioUni"];
            $ventasNoSuj = isset($row["ventaNoSuj"]) ? $row["ventaNoSuj"] : 0;
            $ventaExenta = isset($row["ventaExenta"]) ? $row["ventaExenta"] : 0;

            if ($tipo_documento == "14") {
                $ventaGravada = $row["compra"];
            } else {
                $ventaGravada = $row["ventaGravada"];
            }



            $tNoSujeta = $tNoSujeta + $ventasNoSuj;
            $tExenta   = $tExenta + $ventaExenta;
            $tGravada  = $tGravada + $ventaGravada;


            $LaDescrip = "";
            $nRow = 1;
            foreach ($sDesc as $Fila) {
                if ($nRow == 1) {
                    $LaDescrip = $Fila;
                } else {
                    $LaDescrip = $LaDescrip . "<br>" . $Fila;
                }
                $nRow = $nRow + 1;
            }

            $total_letras = Help::numberToString($totalPagar);


            $l1 = '<tr>';
            $l2 = '<td style="text-align: center;width: 7%;">' . $cantidad . '</td>';
            $l3 = '<td style="text-align: left;;width: 55%;">' . $LaDescrip . '</td>';
            $l4 = '<td style="text-align: right;width: 10%;">' . number_format($preciouni, 2) . '</td>';
            $l5 = '<td style="text-align: right;width: 10%;">' . number_format($ventasNoSuj, 2) . '</td>';
            $l6 = '<td style="text-align: right;width: 10%;">' . number_format($ventaExenta, 2) . '</td>';
            $l7 = '<td style="text-align: right;width: 10%;">' . number_format($ventaGravada, 2) . '</td>';

            $l8 = '</tr>';




            $Html_detalle = $Html_detalle . $l1 . $l2 . $l3 . $l4 . $l5 . $l6 . $l7 . $l8;
        }


        $cfoot = '<tr><td><span>.</span></td></tr><tr style="border-top: solid 1px;">
                 <td colspan="3"style="text-align: right;">SUMAS</td>
                 <td style="text-align: right;">' . number_format($tNoSujeta, 2) . '</td>
                 <td style="text-align: right;">' . number_format($tExenta, 2) . '</td>
                 <td style="text-align: right;">' . number_format($tGravada, 2) . '</td>
                 <tr>';


        $cfoot2 = '<tr style="border-top: solid 1px;">
                 <td colspan="4" style="text-align: right;">Suma de operaciones</td>
                 <td></td>
                 <td style="text-align: right;">' . number_format($total_totalgravado, 2) . '</td></tr>';

        $cfoot3 = "";

        if ($tipoDte != '01') {
            $cfoot3 = '<tr><td colspan="4" style="text-align: right;">IVA</td>
                 <td></td>
                 <td style="text-align: right;">' . number_format($total_totaliva, 2) . '</td></tr>';
        }
        $footRenta = null;
        if ($tipoDte ==  '14') {
            $footRenta = '<tr><td colspan="4" style="text-align: right;">Renta</td>
                 <td></td>
                 <td style="text-align: right;">' . number_format($renta, 2) . '</td></tr>';
        }


        $cfoot4 = '<tr>
                 <td colspan="4" style="text-align: right;">Suma de ventas no sujetas</td>
                 <td></td>
                 <td style="text-align: right;">' . number_format($total_descuentonosujetas, 2) . '</td></tr>';

        $cfoot5 = '<tr>
                 <td colspan="4" style="text-align: right;">Suma de ventas exentas</td>
                 <td></td>
                 <td style="text-align: right;">' . number_format($total_totalexenta, 2) . '</td></tr>';


        $cfoot6 = '<tr>
                 <td colspan="4" style="text-align: right;">Sub-total</td>
                 <td></td>
                 <td style="text-align: right;">' . number_format($total_subtotal, 2) . '</td></tr>';

        $cfoot7 = '<tr>
                 <td colspan="4" style="text-align: right;">IVA retenido</td>
                 <td></td>
                 <td style="text-align: right;">' . number_format($total_ivaretenido, 2) . '</td></tr>';

        $cfoot8 = '<tr style="border-top: solid 1px;background:black;color: white;">
                 <td colspan="4" style="text-align: right;"><b>total a pagar o saldo a favor</b></td>
                 <td></td>
                 <td style="text-align: right;"><b>' . number_format($totalPagar, 2) . '</b></td></tr>';

        $cfoot9 = '<tr style="border-top: solid 1px;">
                 <td colspan="4" style="text-align: left;"><b>Valor en letras:' . $total_letras . ' USD</b></td>
                 <td></td><td></td></tr>';

        $Html_detalle = $Html_detalle . $cfoot . $cfoot2 . $cfoot3 . $footRenta . $cfoot4 . $cfoot5 . $cfoot6 . $cfoot7 . $cfoot8 . $cfoot9;

        //-----------------------------------------------

        $data = array(
            'emisor' => array(
                'nombre' => $emisor_nombre,
                'nombreComercial' => $emisor_nombreComercial,
                'numDoc' => $emisor_nit,
                'nrc' => $emisor_nrc,
                'municipio' => $emisor_municipio,
                'departamento' => $emisor_departamento,
                'complemento' => $emisor_direccion,
                'telefono' => $emisor_telefono,
                'correo' => $emisor_correo
            ),
            'respuesta' => array(
                'tipo' => $tipoDte,
                'descripcionTipo' => $cur_descript_doc,
                'codigo' => $codigo_generacion,
                'sello' => $sello,
                'numControl' => $numero_dte,
                'ambiente' => $ambiente,
                'version' => $versionjson,
                'fecha' => $fecha_emision,
                'hora' => $hora_emision,
                'tipo_doc' => $tipo_documento
            ),
            'receptor' => array(
                'nombre' => $receptor_nombre,
                'municipio' => $receptor_municipio,
                'departamento' => $receptor_departamento,
                'complemento' => $receptor_direccion,
                'nrc' => $receptor_nit,
                'tipoDoc' => $receptor_tipoDocumento,
                'numDoc' => $receptor_numDocumento,
                'telefono' => $receptor_telefono,
                'correo' => $receptor_correo
            ),
            'detalleDoc' => $Html_detalle,
            'dteRel'=>$dteRel
        );


        //---------------------------------------------------
        // GENERANDO QR
        //----------------------------------------------------

        // $qrCode = new QrCodeQrCode($url);

        // Configurar el tamaño y otras opciones
        // Configurar tamaño y demás
        $qrCode = new QRCode($url);

        // Opciones
        $qrCode->setSize(200);
        $qrCode->setMargin(10);


        // Usar el writer
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Obtener el contenido como string
        $qrContent = $result->getString();

        // Codificar en base64
        $qr = base64_encode($qrContent);

        return array(
            "qr" => $qr,
            "data" => $data,
            "url" => $url
        );
    }
}
