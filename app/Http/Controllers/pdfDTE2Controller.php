<?php

namespace App\Http\Controllers;
 

use \Mpdf\Mpdf as PDF; 
use Illuminate\Support\Facades\Storage;
use App\help\Help;
use App\Models\Empresa;
use Illuminate\Support\Facades\Crypt;


class PdfDTE2Controller extends Controller

{
    public function document()
    {

        /*

            "emisor": {
        "nit": "12150301871012",
        "nrc": "2134324",
        "correo": "jslopeza@gmail.com",
        "nombre": "JAIRO ANTONIO NATIVI ZELAYA",
        "telefono": "79363368",
        "direccion": {
            "municipio": "15",
            "complemento": "San Jorge, San Miguel",
            "departamento": "12"
        },
        "codEstable": null,
        "codActividad": "47111",
        "codEstableMH": "M001",
        "codPuntoVenta": null,
        "descActividad": "Venta en supermercados",
        "codPuntoVentaMH": "M001",
        "nombreComercial": "SUPER TIENDA NUEVA",
        "tipoEstablecimiento": "20"
    },
    "resumen": {
        "pagos": [
            {
                "plazo": null,
                "codigo": "01",
                "periodo": null,
                "montoPago": 50,
                "referencia": null
            },
            {
                "plazo": null,
                "codigo": "01",
                "periodo": null,
                "montoPago": 162,
                "referencia": null
            }
        ],
        "ivaRete1": 1,
        "subTotal": 150,
        "tributos": [
            {
                "valor": 0,
                "codigo": "D5",
                "descripcion": "Otras tasas casos especiales"
            },
            {
                "valor": 13,
                "codigo": "20",
                "descripcion": "Impuesto al Valor Agregado 13%"
            }
        ],
        "ivaPerci1": 0,
        "reteRenta": 0,
        "descuNoSuj": 0,
        "saldoFavor": 0,
        "totalDescu": 0,
        "totalNoSuj": 0,
        "totalPagar": 162,
        "descuExenta": 0,
        "totalExenta": 50,
        "totalLetras": "USD ciento sesenta y dos con cero",
        "descuGravada": 0,
        "totalGravada": 100,
        "subTotalVentas": 150,
        "totalNoGravado": 0,
        "condicionOperacion": 1,
        "numPagoElectronico": null,
        "montoTotalOperacion": 163,
        "porcentajeDescuento": 0
    },
    "apendice": null,
    "receptor": {
        "nit": "06140311161022",
        "nrc": "2549009",
        "correo": "ducontabilidad@gmail.com",
        "nombre": "Human Power, S.A. De C.V.",
        "telefono": "0123-4567",
        "direccion": {
            "municipio": "01",
            "complemento": "Sin complemento",
            "departamento": "01"
        },
        "codActividad": "10005",
        "descActividad": "Otros",
        "nombreComercial": "Human Power, S.A. De C.V."
    },
    "extension": null,
    "ventaTercero": null,
    "identificacion": {
        "fecEmi": "2024-11-11",
        "horEmi": "01:02:56",
        "tipoDte": "03",
        "version": 3,
        "ambiente": "00",
        "tipoModelo": 1,
        "tipoMoneda": "USD",
        "motivoContin": null,
        "numeroControl": "DTE-03-EIV6XMQ0-000000000000825",
        "tipoOperacion": 1,
        "codigoGeneracion": "C1DD205A-97FE-A1B9-9F22-D21E0C83279D",
        "tipoContingencia": null
    },
    "cuerpoDocumento": [
        {
            "psv": 0,
            "codigo": null,
            "numItem": 1,
            "cantidad": 1,
            "tipoItem": 1,
            "tributos": [
                "D5"
            ],
            "noGravado": 0,
            "precioUni": 50,
            "uniMedida": 99,
            "codTributo": null,
            "montoDescu": 0,
            "ventaNoSuj": 0,
            "descripcion": "programación",
            "ventaExenta": 50,
            "ventaGravada": 0,
            "numeroDocumento": null
        },
        {
            "psv": 0,
            "codigo": null,
            "numItem": 2,
            "cantidad": 1,
            "tipoItem": 1,
            "tributos": [
                "20"
            ],
            "noGravado": 0,
            "precioUni": 100,
            "uniMedida": 99,
            "codTributo": null,
            "montoDescu": 0,
            "ventaNoSuj": 0,
            "descripcion": "programación",
            "ventaExenta": 0,
            "ventaGravada": 100,
            "numeroDocumento": null
        }
    ],
    "otrosDocumentos": null,
    "documentoRelacionado": null
}



        */


        /*
        // recupera todos los registros
        //$empresa = Help::getEmpresa();

        //recupera el registro de la empresa con el id enviado 
        $empresa  =  Empresa::find(1);

        $nombre_comercial = $empresa->nombre_comercial;
        $cod_actividade = $empresa->codigo_actividad;

        $nrc = crypt::decryptString($empresa->nrc);
        $nit = crypt::decryptString($empresa->nit);
        
        $email = crypt::decryptString($empresa->correo_electronico);
        $telefono = crypt::decryptString($empresa->telefono);
        $direccion = $empresa->direccion;
        
        //$actividad_economica_datos = Help::pdfActividadEconomicadatos($cod_actividade);

        */

        $nDTE = (isset($_REQUEST['ndte'])) ? $_REQUEST['ndte'] : 'ABC';

        $registroDTE = Help::pdfDTEdatos($nDTE);
        

        if(!isset($registroDTE->sello))
        {
            print 'Documento no es valido...';
            return;
        }

        //$cur_sello = $cur_datosDTE->sello;
        // DATOS TABLA 
        //----------------------------
        $cur_sello = $registroDTE->sello;
        $cur_codgen = $registroDTE->codigo_generacion;
        $cur_tipo_doc = $registroDTE->tipo_documento;
       
        $JsonDTE = json_decode($registroDTE->dte,true); 
      
        // DATOS TABLA-JSON(DTE)
        //------------------------------

        // EMISOR
             
        $emisor_activida_economica = $JsonDTE["emisor"]["descActividad"];
        $emisor_nit = $JsonDTE["emisor"]["nit"];
        $emisor_nrc = $JsonDTE["emisor"]["nrc"];
        $emisor_correo = $JsonDTE["emisor"]["correo"];
        $emisor_direccion = $JsonDTE["emisor"]["direccion"]["complemento"];
        $emisor_nombre = $JsonDTE["emisor"]["nombre"];
        $emisor_telefono = $JsonDTE["emisor"]["telefono"];
        
        // RECEPTOR
        $receptor_activida_economica = $JsonDTE["receptor"]["descActividad"];
      
        $receptor_nit = "";
        
        if(isset($JsonDTE["receptor"]["nit"]))
        {
            $receptor_nit = $JsonDTE["receptor"]["nit"];
        }
      
        $receptor_nrc = $JsonDTE["receptor"]["nrc"];
        $receptor_correo = $JsonDTE["receptor"]["correo"];
        
        $receptor_direccion ="";
        if(isset($JsonDTE["receptor"]["direccion"]["complemento"]))
        {
            $receptor_direccion = $JsonDTE["receptor"]["direccion"]["complemento"];
        }
        elseif(isset($JsonDTE["receptor"]["direccion"]))
        {
            $receptor_direccion = $JsonDTE["receptor"]["direccion"];
        }
        
        


        $receptor_nombre = $JsonDTE["receptor"]["nombre"];
        $receptor_telefono = $JsonDTE["receptor"]["telefono"];


        // RESUMEN

        /*
        "resumen": {
            "pagos": null,
            "ivaRete1": 0,
            "subTotal": 16.97,
            "totalIva": 1.95,
            "tributos": [],
            "reteRenta": 0,
            "descuNoSuj": 0,
            "saldoFavor": 0,
            "totalDescu": 5,
            "totalNoSuj": 0,
            "totalPagar": 16.97,
            "descuExenta": 0,
            "totalExenta": 0,
            "totalLetras": "dieciséis dólares con noventa y siete centavos",
            "descuGravada": 0,
            "totalGravada": 16.97,
            "subTotalVentas": 16.97,
            "totalNoGravado": 0,
            "condicionOperacion": 2,
            "numPagoElectronico": null,
            "montoTotalOperacion": 16.97,
            "porcentajeDescuento": 0
        },
        */
        $total_letras = $JsonDTE["resumen"]["totalLetras"];

        $total_subtotal = $JsonDTE["resumen"]["subTotal"];
      
        $total_totaliva = 0;
      
        if(isset($JsonDTE["resumen"]["tributos"]["valor"]))
        {
            $total_totaliva = $JsonDTE["resumen"]["tributos"]["valor"];
        }
        elseif(isset($JsonDTE["resumen"]["tributos"][0]["valor"]))
        {
            $total_totaliva = $JsonDTE["resumen"]["tributos"][0]["valor"];
        }
        elseif(isset($JsonDTE["resumen"]["totalIva"]))
        {
            $total_totaliva = $JsonDTE["resumen"]["totalIva"];
        }
        
      
        $total_totalgravado = $JsonDTE["resumen"]["totalGravada"];
        $total_montototaloperaciones = $JsonDTE["resumen"]["montoTotalOperacion"];
        $total_ivaretenido = $JsonDTE["resumen"]["ivaRete1"];
        $total_retencionrenta = $JsonDTE["resumen"]["reteRenta"];
        $total_descuentonosujetas = $JsonDTE["resumen"]["descuNoSuj"];
        $total_totalexenta = $JsonDTE["resumen"]["totalExenta"];
        $total_totalnogravado = $JsonDTE["resumen"]["totalNoGravado"];
      

        $fecha_emision = $JsonDTE["identificacion"]["fecEmi"];
        $hora_emision =  $JsonDTE["identificacion"]["horEmi"];
      
        $cur_ambiente = '00';

        $cur_datos_documento = Help::getDatosDocumento($cur_tipo_doc);
        $cur_descript_doc = strtoupper($cur_datos_documento['valor']);

        $aDetalle = $JsonDTE["cuerpoDocumento"];

        // Setup a filename 
        $documentFileName = $nDTE.".pdf";

        
       //Armando el documento HTML
       //-----------------------------------
        
        $html = '
        <html>
</body>
    <table width="100%">
        <tbody>
            <tr>
                <td>
                    <img style="width:15%;" src="../app/assets/logo.png">
                </td>
      
                <td>
                        <center>
                        <p class="data-title">DOCUMENTO DE CONSULTA PORTAL OPERATIVO</p>
                        <p class="data-title">DOCUMENTO TRIBUTARIO ELECTRONICO</p>
                        <p class="data-title-bold">'.$cur_descript_doc.'</p>
                        </center>    
                </td>
            
                <td>
                <img style="width:15%;" src="noimg.png">
                </td>

            </tr>
        </tbody>
    </table>

    <table width ="100%">
        <tbody>


            <tr>
                <td width="40%">
                    <table>
                        <tbody>
                            <tr>
                            <td style="white-space:nowrap;text-align: right;">
                                <b><p>Codigo generacion</p></b>
                            </td>
                            <td>
                                <p class="data">'.$cur_codgen.'</p>
                            </td>
                            </tr>
                            
                            <tr>
                            <td style="white-space:nowrap;text-align: right;">
                                
                                <b><p>Numero de control</p></b>
                                
                            </td>
                            <td>
                                <p class="data">'.$nDTE.'</p>
                            </td>
                            </tr>

                            <tr>
                            <td style="white-space:nowrap;text-align: right;">
                                <b><p>Sello recepcion</p></b>
                            </td>
                            <td>
                                <p class="data">'.$cur_sello.'</p>
                            </td>
                            </tr>
                                <tr>
                            <td style="white-space:nowrap;text-align: right;">
                                <b><p>Fecha y hora generacion</p></b>
                            </td>
                            <td>
                                <p class="data">'.$fecha_emision." ".$hora_emision.'</p>
                            </td>
                            </tr>
                        </tbody>
                        </table>
                
                </td>
        
                <td width="20%">
                   
                   
                    
                    <center>
                        <barcode code="https://admin.factura.gob.sv/consultaPublica?ambiente='.$cur_ambiente.'&codGen='.$nDTE.'&fechaEmi='.$fecha_emision.'" type="QR" class="barcode" size="0.87" error="M" />
                    </center>
                </td>
                
                <td width="40%">
                    
                        <table>
                        <tbody>
                            <tr>
                            <td style="white-space:nowrap;text-align: right;">
                                <b><p>Modelo facturacion</p></b>
                            </td>
                            <td>
                                <p class="data">PREVIO</p>
                            </td>
                            </tr>
                            
                            <tr>
                            <td style="white-space:nowrap;text-align: right;">
                                
                                <b><p>Tipo de transaccion</p></b>
                                
                            </td>
                            <td>
                                <p class="data">NORMAL</p>
                            </td>
                            </tr>

                            <tr>
                            <td style="white-space:nowrap;text-align: right;">
                                <b><p>&nbsp;&nbsp;Condicion operacion</p></b>
                            </td>
                            <td>
                                <p class="data">CONTADO</p>
                            </td>
                            </tr>
                            <tr>
                            <td style="white-space:nowrap;text-align: right;">
                                <b><p>Tipo de cobro</p></b>
                            </td>
                            <td>
                                <p class="data">EFECTIVO</p>
                            </td>
                            </tr>
                        </tbody>
                        </table>
                </td>

            </tr>

        
        </tbody>
    </table>


    <table width ="100%">
        <tbody>
             <tr>
               
                <td width="48%" style="border: 1px solid;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" class="personalice-title"><center>EMISOR</center></td>
                                </tr>
                            </tbody>
                        </table>    


                        <table>
                        <tbody>
                           
                            <tr>
                                <td style="white-space:nowrap;text-align: right;">
                                    <b><p>Nombre o razon social</p></b>
                                </td>
                                <td style="white-space:nowrap;text-align: right;">
                                    <p class="data">'.$emisor_nombre.'</p>
                                </td>
                            </tr>
                            
                            <tr>
                                <td style="white-space:nowrap;text-align: right;">
                                    
                                    <b><p>NIT</p></b>
                                    
                                </td>
                                <td>
                                    <p class="data">'.$emisor_nit.'</p>
                                </td>
                            </tr>

                            <tr>
                                <td style="white-space:nowrap;text-align: right;">
                                    <b><p>NRC</p></b>
                                </td>
                                <td>
                                    <p class="data">'.$emisor_nrc.'</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="white-space:nowrap;text-align: right;">
                                    <b><p>Actividad economica</p></b>
                                </td>
                                <td>
                                    <p class="data">'.$emisor_activida_economica.'</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="white-space:nowrap;text-align: right;">
                                    <b><p>Direccion</p></b>
                                </td>
                                <td>
                                    <p class="data">'.$emisor_direccion.'</p>
                                </td>
                            </tr>
                             <tr>
                                <td style="white-space:nowrap;text-align: right;">
                                    <b><p>Numero de telefono</p></b>
                                </td>
                                <td>
                                    <p class="data">'.$emisor_telefono.'</p>
                                </td>
                            </tr>
                             <tr>
                                <td style="white-space:nowrap;text-align: right;">
                                    <b><p>Correo electronico</p></b>
                                </td>
                                <td>
                                    <p class="data">'.$emisor_correo.'</p>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                </td>
             
                <td width="4%"></td>
                        
                <td width="48%" style="border: 1px solid;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" class="personalice-title"><center>RECEPTOR</center></td>
                                </tr>
                            </tbody>
                        </table>    


                              <table>
                        <tbody>
                           
                            <tr>
                                <td style="white-space:nowrap;text-align: right;">
                                    <b><p>Nombre o razon social</p></b>
                                </td>
                                <td>
                                    <p class="data">'.$receptor_nombre.'</p>
                                </td>
                            </tr>
                            
                            <tr>
                                <td style="white-space:nowrap;text-align: right;">
                                    
                                    <b><p>NIT</p></b>
                                    
                                </td>
                                <td>
                                    <p class="data">'.$receptor_nit.'</p>
                                </td>
                            </tr>

                            <tr>
                                <td style="white-space:nowrap;text-align: right;">
                                    <b><p>NRC</p></b>
                                </td>
                                <td>
                                    <p class="data">'.$receptor_nrc.'</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="white-space:nowrap;text-align: right;">
                                    <b><p>Actividad economica</p></b>
                                </td>
                                <td>
                                    <p class="data">'.$receptor_activida_economica.'</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="white-space:nowrap;text-align: right;">
                                    <b><p>Direccion</p></b>
                                </td>
                                <td>
                                    <p class="data">'.$receptor_direccion.'</p>
                                </td>
                            </tr>
                             <tr>
                                <td style="white-space:nowrap;text-align: right;">
                                    <b><p>Numero de telefono</p></b>
                                </td>
                                <td>
                                    <p class="data">'.$receptor_telefono.'</p>
                                </td>
                            </tr>
                             <tr>
                                <td style="white-space:nowrap;text-align: right;">
                                    <b><p>Correo electronico</p></b>
                                </td>
                                <td>
                                    <p class="data">'.$receptor_correo.'</p>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                </td>

            </tr>

        
        </tbody>
    </table>

    <table>
        <tbody>
            <tr><td><center><p class="data-title">OTROS DOCUMENTOS ASOCIADOS<p></center></td></tr>
        </tbody>
    </table>

     <table width ="100%">
        <tbody>
             <tr>
               
                <td width="40%" style="border: 1px solid;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" class="personalice-title2"><center>IDENTIFICACION DEL DOCUMENTO</center></td>
                                </tr>
                            </tbody>
                        </table>    


                </td>
             
                                     
                <td width="60%" style="border: 1px solid;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" class="personalice-title2"><center>DESCRIPCION</center></td>
                                </tr>
                            </tbody>
                        </table>    


               
                </td>
            </tr>

        
        </tbody>
    </table>

     <table>
        <tbody>
            <tr><td><center><p class="data-title">VENTA A CUENTA DE TERCEROS<p></center></td></tr>
        </tbody>
    </table>

     <table width ="100%">
        <tbody>
             <tr>
               
                <td width="40%" style="border: 1px solid;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" class="personalice-title2"><center>NIT</center></td>
                                </tr>
                            </tbody>
                        </table>    


                </td>
             
                                     
                <td width="60%" style="border: 1px solid;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" class="personalice-title2"><center>NOMBRE O RAZON SOCIAL</center></td>
                                </tr>
                            </tbody>
                        </table>    


                </td>
            </tr>

        
        </tbody>
    </table>


    <table>
        <tbody>
            <tr><td><center><p class="data-title">DOCUMENTOS RELACIONADOS<p></center></td></tr>
        </tbody>
    </table>

     <table width ="100%">
        <tbody>
             <tr>
               
                <td width="40%" style="border: 1px solid;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" class="personalice-title2"><center>TIPO DE DOCUMENTO</center></td>
                                </tr>
                            </tbody>
                        </table>    


                </td>
             
                                     
                <td width="30%" style="border: 1px solid;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" class="personalice-title2"><center>No DE DOCUMENTO</center></td>
                                </tr>
                            </tbody>
                        </table>    


                       
                </td>

                <td width="30%" style="border: 1px solid;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" class="personalice-title2"><center>FECHA DE EMISION</center></td>
                                </tr>
                            </tbody>
                        </table>    


                       
                </td>
            </tr>

        
        </tbody>
    </table>

    <table width ="100%">
        <tbody>
             <tr>
               
                <td width="5%" style="border: 1px solid;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" class="personalice-title2"><center>CANT.</center></td>
                                </tr>
                            </tbody>
                        </table>    


                </td>
             
                                     
                <td width="40%" style="border: 1px solid;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" class="personalice-title2"><center>DESCRIPCION</center></td>
                                </tr>
                            </tbody>
                        </table>    


                       
                </td>

                <td width="10%" style="border: 1px solid;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" class="personalice-title2"><center>PREC.UNIT</center></td>
                                </tr>
                            </tbody>
                        </table>    
                </td>

                <td width="10%" style="border: 1px solid;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" class="personalice-title2"><center>NO SUJETA</center></td>
                                </tr>
                            </tbody>
                        </table>    
                </td>

                <td width="10%" style="border: 1px solid;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" class="personalice-title2"><center>EXENTA</center></td>
                                </tr>
                            </tbody>
                        </table>    
                </td>

                <td width="15%" style="border: 1px solid;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" class="personalice-title2"><center>GRAVADA</center></td>
                                </tr>
                            </tbody>
                        </table>    
                </td>

            </tr>

        
        </tbody>
    </table>

    <!-- DETALLE DEL DOCUMETO -->

                      <table>
                            <tbody>';

        /*

          {
            "psv": 0,
            "codigo": null,
            "numItem": 2,
            "cantidad": 1,
            "tipoItem": 1,
            "tributos": [
                "20"
            ],
            "noGravado": 0,
            "precioUni": 100,
            "uniMedida": 99,
            "codTributo": null,
            "montoDescu": 0,
            "ventaNoSuj": 0,
            "descripcion": "programación",
            "ventaExenta": 0,
            "ventaGravada": 100,
            "numeroDocumento": null
        }
        */

        $Html_detalle = "";

        foreach($aDetalle as $row)
        {
            //$sDescripcion=mb_convert_encoding($row["descripcion"], "UTF-8", "Windows-1252");
             
            //$sDescripcion = mb_convert_encoding($row["descripcion"], "SJIS-2004", "UTF-8");

            $sDescripcion = $row["descripcion"];
            
            $nCantidad = $row["cantidad"];
            $nPrecioUnit = $row["precioUni"];
            $nNoSujeta = $row["ventaNoSuj"];
            $nExenta = $row["ventaExenta"];
            $nGravada = $row["ventaGravada"];


            $Html_detalle = $Html_detalle.'
            <tr>
            <td width="10%" style="white-space:nowrap;text-align: right;" class="data2">'.$nCantidad.'</td>
            <td width="45%" style="white-space:nowrap;text-align: left;" class="data2">'.$sDescripcion.'</td>
            <td width="10%" style="white-space:nowrap;text-align: right;" class="data2">'.$nPrecioUnit.'</td>
            <td width="10%" style="white-space:nowrap;text-align: right;" class="data2">'.$nNoSujeta.'</td>
            <td width="10%" style="white-space:nowrap;text-align: right;" class="data2">'.$nExenta.'</td>
            <td width="15%" style="white-space:nowrap;text-align: right;" class="data2">'.$nGravada.'</td>
            </tr>';
        }                               

        $html2 ='
              </tbody>
                      </table>
             

    <!-- RESUMEN -- TOTALIZANDO -->

     <table width ="100%">
        <tbody>
             <tr style="border: 1px solid;">
               
                                                   
                <td width="55%" class="data2">
                       Total en letras: '.$total_letras.'                       
                </td>

                <td width="10%" class="data2">
                       Sumas $
                </td>

                <td width="10%" class="data2">
                      0.00  
                </td>

                <td width="10%" class="data2">
                      0.00  
                </td>

                <td width="15%" class="data2">'.$total_subtotal.'
                </td>
                

            </tr>

            <tr style="border: 1px solid;">
               
                                                   
                <td width="50%">
                       <table>
                        <thead>
                            <tr>
                                <th  style="border: 0px;background-color: green;">OBSERVACIONES</th>
                            </tr>

                        </thead>

                        <tbody>
                            <tr>
                                <td  class="data2">
                                SIN OBSERVACIONES
                                </td>

                      
                            </tr>
                        </tbody>
                       
                       </table>
                </td>

                <td width="30%" style="border-left: 1px solid #ddd;">
                      <table>
                            <tbody>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">Suma de operaciones:</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">Monto Global Descuento, Rebajas y otros Ventas No Sujetas:</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">Monto Global Descuento, Rebajas y otros Ventas Exentas:</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">Monto Global Descuento, Rebajas y otros Ventas Gravadas:</td></tr> 
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">Sub-total:</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">IVA:</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">IVA percibido:</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">IVA retenido:</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">Retencion de renta:</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">Monto Total de la Operación:</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">Total Otros Montos No Afectos:</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">Total a Pagar o Saldo a Favor:</td></tr>
                            </tbody>
                      </table>
                </td>

               <td width="1%"></td>

                <td width="1%"></td>

                <td width="15%" style="border-left: 1px solid #ddd;">
                     <table>
                            <tbody>

                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">$'.$total_subtotal.'</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">$'.$total_descuentonosujetas.'</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">$0.00</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">$0.00</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">$'.$total_subtotal.'</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">$'.$total_totaliva.'</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">$0</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">$0</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">$'.$total_retencionrenta.'</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">$'.$total_montototaloperaciones.'</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">$0</td></tr>
                                <tr><td style="white-space:nowrap;text-align: right;" class="data2">$'.$total_montototaloperaciones.'</td></tr>
                                
                            </tbody>
                      </table>
                      
                </td>
                

            </tr>
           
          
        
        </tbody>
    </table>
            

</body>
</html>
';

        $html = $html.$Html_detalle.$html2;
        
         // Create the mPDF document
         $document = new PDF( [
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '10',
            'margin_bottom' => '10',
            'margin_footer' => '2',
        ]);     
 
        // Set some header informations for output
        $header = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$documentFileName.'"'
        ];
 
        
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
        $document->WriteHTML($html,2);
         
        // Save PDF on your public storage (fe-gral/storage/app/public)
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
         
        // Get file back from storage with the give header informations
        // return Storage::disk('public')->download($documentFileName, 'Request', $header); //

        $document->Output($documentFileName, \Mpdf\Output\Destination::INLINE);
    }

}