<?php

namespace App\Http\Controllers;


use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Storage;
use App\help\Help;
use App\Help\PDF\GeneratePdfDte;
use App\Models\Empresa;
use App\Models\RegistroDTE;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Illuminate\Support\Facades\Crypt;



class PdfDTEController extends Controller

{
    public function document()
    {


        // recupera todos los registros
        //$empresa = Help::getEmpresa();

        //recupera el registro de la empresa con el id enviado 
        $empresa  =  Empresa::find(1);

        $nombre_comercial = $empresa->nombre_comercial;
        $nrc = crypt::decryptString($empresa->nrc);
        $nit = crypt::decryptString($empresa->nit);

        $email = crypt::decryptString($empresa->correo_electronico);
        $telefono = crypt::decryptString($empresa->telefono);
        $direccion = $empresa->direccion;

        $nDTE = (isset($_REQUEST['ndte'])) ? $_REQUEST['ndte'] : 'ABC';

        $cur_datosDTE = Help::pdfDTEdatos($nDTE);

        /*           
        $cur_sello = $cur_datosDTE['sello'];
        $cur_codgen = $cur_datosDTE['codigo_generacion'];
        $cur_tipo_doc = $cur_datosDTE['tipo_documento'];
        $cur_fecha_emi = $cur_datosDTE['fecha_recibido'];
        */

        $cur_sello = $cur_datosDTE->sello;
        $cur_codgen = $cur_datosDTE->codigo_generacion;
        $cur_tipo_doc = $cur_datosDTE->tipo_documento;
        $cur_fecha_emi = $cur_datosDTE->fecha_recibido;

        $cur_ambiente = '00';

        $cur_datos_documento = Help::getDatosDocumento($cur_tipo_doc);
        $cur_descript_doc = strtoupper($cur_datos_documento['valor']);



        // Setup a filename 
        $documentFileName = $nDTE . ".pdf";

        // Create the mPDF document
        $document = new PDF([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);

        // Set some header informations for output
        $header = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $documentFileName . '"'
        ];


        $html = '
<table border="0" width="100%">
<tbody>
    <tr>
        <td width="40%"><img src="../app/assets/tiendanueva_150x150.png">
       
          <table>
            <tbody>
           
                <tr>
                    <td align="left">
                       <p style="font-weight:bold; font-size:10pt;">' . $nombre_comercial . '</p>
                        <table>
                            <tbody>
                                 <tr>
                                     <td align="left">
                                            <tr><td>
                                                <p><b>NIT:</b></p>
                                            </td></tr>
                                            <tr><td>
                                                <p><b>NRC:</b></p>
                                            </td></tr>
                                             <tr><td>
                                                <p><b>ACTIVIDA ECONOMICA:</b></p>
                                            </td></tr>
                                             <tr><td>
                                                <p><b>DIRECCION:</b></p>
                                            </td></tr>
                                             <tr><td>
                                                <p><b>TELEFONO:</b></p>
                                            </td></tr>
                                             <tr><td>
                                                <p><b>EMAIL:</b></p>
                                            </td></tr>
                                     </td>
                                     <td aling="left">
                                            <p>' . $nit . '</p>
                                            <p><b>NRC:</b>' . $nrc . '</p>
                                            <p><b>Actividad economica:</b></p>
                                            <p>Compra y venta de productos primer necesidad</p>
                                            <p><b>Direccion</b></p>
                                            <p>' . $direccion . '</p>
                                            <p><b>Numero de telefono</b></p>
                                            <p>' . $telefono . '</p>
                                            <p><b>Correo electronico</b></p>
                                            <p>' . $email . '</p>

                                     </td>
                                  </tr>
                            </tbody>
                        </table> 

                        
                        

                    </td>
                </tr>
            
            </tbody>
            </table>




        </td>
        <td width="60%"  style="border: 1px solid;">
            
            <table>
                <tbody>
                    <tr>
                        <td width="100%" style="background-color:#084f08;color:white;">
                            <center><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>DOCUMENTO TRIBUTARIO ELECTRONICO</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></center>
                            <p>' . $cur_descript_doc . '</p>          
                        </td>
                   </tr>
                </tbody>
            </table>  

            <table>
            <tbody>
           
                <tr>
                   
                    <td>
                    <center><p style="font-size:8px;">Escanea este QR para ir al sitio del Ministerio de Hacienda y validar la información aqui contenida</p></center>
                    <barcode code="https://admin.factura.gob.sv/consultaPublica?ambiente=' . $cur_ambiente . '&codGen=' . $nDTE . '&fechaEmi=' . $cur_fecha_emi . '" type="QR" class="barcode" size="1.5" error="M" />
                    </td>

                    <td><center><b><p>Codigo de generacion</p></b></center>
                    <p style="font-size:10px;">' . $cur_codgen . '</p>
                    <b><p>Sello de recepcion</p></b></center>
                    <p style="font-size:10px;">' . $cur_sello . '</p>
                    <b><p>Numero de control DTE</p></b></center>
                    <p style="font-size:10px;">' . $nDTE . '</p>
                    </td>
                </tr>
            
            </tbody>
            </table>
           
        </td>
        
    </tr>

  
</tbody>
</table>
';



        // Write some simple Content
        /*
        $document->WriteHTML('<h1 style="color:blue">TheCodingJack</h1>');
        $document->WriteHTML('<p>Write something, just for fun!</p>');
        $document->WriteHTML('<p>Excelente...salvador</p>');
        */

        $document->SetDisplayMode('fullpage');

        $document->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list

        // Load a stylesheet
        $stylesheet = file_get_contents('../resources/css/fe-gral-pdf.css');

        $document->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
        $document->WriteHTML($html, 2);

        // Save PDF on your public storage (fe-gral/storage/app/public)
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));

        // Get file back from storage with the give header informations
        // return Storage::disk('public')->download($documentFileName, 'Request', $header); //

        $document->Output($documentFileName, \Mpdf\Output\Destination::INLINE);
    }

    public function test(Request $request)
    {
        $dte = RegistroDTE::with([
            'tipoDocumento'
        ])->find(707);

        // return (new GeneratePdfDte)->generateStructure($dte);

        $data = (new GeneratePdfDte)->generateStructure($dte);

        $pdf = DomPDF::loadView('pdf.plantillaDte', compact('data')); // Carga la vista con los datos
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('dte.pdf'); // Muestra el PDF en el navegador
    }
}
