<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Factura</title>
    <style>
        @page {
            margin: 5px;
            /* Elimina todos los márgenes */
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            border-bottom: 2px solid #d00;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .left-section,
        .right-section {
            width: 50%;
            box-sizing: border-box;
        }

        .logo-placeholder {
            width: 100%;
            height: 50px;
            background-color: #eee;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .info-block {
            line-height: 1.5;
        }

        .right-section {
            width: 48%;
        }

        .red-title {
            background-color: #d00;
            color: white;
            padding: 6px;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .gray-box {
            background-color: #eee;
            padding: 8px;
            font-size: 11px;
        }

        p {
            line-height: 0.7;
        }

        .box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }

        .receiver-info {
            line-height: 1.6;
        }

        .additional-info {
            font-size: 11px;
        }

        .additional-info td {
            padding: 4px;
        }

        .footer {
            text-align: right;
            font-size: 10px;
            margin-top: 20px;
        }

        .section-title {
            background-color: #d00;
            color: white;
            padding: 5px;
            font-weight: bold;
            margin-bottom: 6px;
            font-size: 11px;
        }

        .table-border {
            border: 0.5px solid black;
        }
    </style>
</head>



<body>

    <div class="container">

        <!-- Encabezado -->
        <table width="100%" style="border-collapse: collapse; margin-bottom: 5px;">
            <tr>
                <!-- Columna izquierda: Logo + datos básicos -->
                <td width="42%" valign="top" style="padding-right: 5px;">
                    <div
                        style="background-color: #ffffff; height: 80px; text-align: center; line-height: 50px; font-weight: bold;">

                        <img class="mt-2" src="apopsa.jpg" width="120" height="110" alt="">
                       <div>

                       </div>
                    </div>
                    <p>
                       <h2><strong> {{ $data['emisor']['nombre']}}</strong></h2>
                    </p>
                    <p><strong>NIT:</strong> {{ $data['emisor']['numDoc'] }}</p>
                    <p><strong>NRC:</strong> {{ $data['emisor']['nrc'] }}</p>
                    <p style="line-height: 1.5; !important"><strong>Dirección:</strong>
                        {{--  $data['emisor']['municipio'] . ', ' . $data['emisor']['departamento'] . ', ' . $data['emisor']['complemento'] --}}
                        {{ $data['emisor']['complemento'] }}
                    </p>
                    <p><strong>Teléfono:</strong> {{ $data['emisor']['telefono'] }}</p>
                    <p><strong>Correo:</strong> {{ $data['emisor']['correo'] }}</p>
                </td>

                <!-- Columna derecha: Información de factura -->
                <td width="58%" valign="top" style="padding-left: 10px;">
                    <br>
                    <div
                        style="background-color: rgb(59, 61, 62); color: white; text-align: center; padding: 5px; font-weight: bold;">
                        DOCUMENTO TRIBUTARIO ELECTRÓNICO <br>
                        @if ($data['respuesta']['numControl'] =="" || $data['respuesta']['numControl'] == null)

                            <h3>PRE-FACTURA - {{ $data['respuesta']['descripcionTipo'] }}</h3>

                        @else
                            <h3>{{ $data['respuesta']['descripcionTipo'] }}</h3>


                        @endif

                        {{-- <h3>{{ $data['respuesta']['tipo'] }}</h3> --}}



                    </div>
                    <div style="background-color: #eee; padding: 8px; font-size: 12px;">
                        <p  style="font-size: 11px;  !important"><strong>Código de generación:</strong>
                            {{ $data['respuesta']['codigo'] }}</p>
                        <p  style="font-size: 11x; !important"><strong>Sello recepción:</strong>
                            {{ $data['respuesta']['sello'] }}</p>
                        <p style="font-size: 11px"><strong>Número de control:</strong> {{ $data['respuesta']['numControl'] }}</p>
                        <p style="font-size: 11px"><strong>Ambiente:</strong> {{ $data['respuesta']['ambiente'] }}</p>
                        <p style="font-size: 11px"><strong>Versión del JSON:</strong> {{ $data['respuesta']['version'] }}</p>
                        <p style="font-size: 11px"> <strong>Fecha de emisión:</strong> {{ $data['respuesta']['fecha'] }}</p>
                        <p style="font-size: 11px"><strong>Hora de emisión:</strong> {{ $data['respuesta']['hora'] }}</p>
                    </div>
                </td>
            </tr>
        </table>


        <table width="100%" style="border-collapse: collapse; margin-bottom: 1px;">
            <tr>
                <td>
                    <br>
                    <strong> Informacion del receptor</strong>
                </td>
            </tr>

            <tr>
                <!-- Columna izquierda: Datos del receptor -->
                <td width="70%" valign="top" style="padding-right: 10px;">
                    <div style="background-color: #f5f5f5; padding: 8px; border: 1px solid #ccc;">
                        <p ><strong>Nombre:</strong>
                            @if ($data['receptor']['nombre'] == null ||  $data['receptor']['nombre']  == "" )
                                Sin registro
                             @else 
                             {{ $data['receptor']['nombre']  }}
                            @endif
                        </p>


                        <p ><strong>Dirección:</strong>
                            {{--   $data['receptor']['municipio'] . ', ' . $data['receptor']['departamento'] . ', ' . $data['receptor']['complemento'] --}}
                            @if ($data['receptor']['complemento'] == null ||  $data['receptor']['complemento'] == "" )
                                Sin registro
                             @else 
                             {{ $data['receptor']['complemento'] }}
                            @endif
                        </p>
                        @if ($data['receptor']['nrc'] != null)
                            <p><strong>NRC:</strong> {{ $data['receptor']['nrc'] ?? "Sin registro" }}</p>
                        @endif

                        <p><strong>Tipo Documento: </strong>
                          
                             @if ($data['receptor']['tipoDoc']  == null ||  $data['receptor']['tipoDoc']  == "" )
                                Sin registro
                             @else 
                             {{ $data['receptor']['tipoDoc']  }}
                            @endif
                        </p>

                        <p><strong>Documento:</strong>
                           
                          @if ($data['receptor']['numDoc'] == null ||  $data['receptor']['numDoc']  == "" )
                                Sin registro
                             @else 
                             {{ $data['receptor']['numDoc']  }}
                            @endif
                        </p>
                        <p><strong>Teléfono:</strong> {{ $data['receptor']['telefono'] ?? "Sin registro" }}</p>
                        <p><strong>Correo:</strong> {{ $data['receptor']['correo'] ?? "Sin registro" }}</p>
                    </div>

                </td>

                <!-- Columna derecha: Información personal -->
                <td width="30%" valign="top" style="margin-top:-10px;text-align: center;">




                    <img src="data:image/png;base64, {!! $qr !!}" alt="QR Code" width="160" height="160"  style="margin-button:10px">




                </td>
            </tr>
        </table>
        <br>


        
        @if ($data['respuesta']['tipo_doc']== "05")
            <table width="100%" style="border-collapse: collapse; margin-bottom: 5px;margin-top:5px"> 
            <caption style="background-color: #eeeeeeab; font-weight: bold; height: 20px; vertical-align: center;">
                DOCUMENTO RELACIONADO</caption>

             <thead style="background-color: #eeeeeeab;">
                <tr>
                    <th class="table-border">Fecha</th>
                    <th class="table-border">Codigo Generación</th>
                    <th class="table-border">Número de control</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="table-border" style="text-align: center;">{{ \Carbon\Carbon::parse($data['dteRel']['fecha_recibido'])->format('d/m/Y') }}</td>
                    <td class="table-border" style="text-align: center;">{{$data['dteRel']['codigo_generacion']}}</td>
                    <td class="table-border" style="text-align: center;">{{$data['dteRel']['numero_dte']}}</td>
                </tr>
            </tbody>
        </table>
        <br>
        @endif


        <table width="100%" style="border-collapse: collapse; margin-bottom: 5px;margin-top:5px">

            <caption style="background-color: #eeeeeeab; font-weight: bold; height: 20px; vertical-align: center;">
                CUERPO DEL DOCUMENTO</caption>

            <thead style="background-color: #eeeeeeab;">
                <tr>

                    <th class="table-border">Cantidad</th>

                    <th class="table-border">Descripción</th>
                    <th class="table-border" style="width: 10%;">Precio unitario</th>

                    <th class="table-border" style="width: 10%;">Ventas no sujetas</th>

                    <th class="table-border" style="width: 10%;">Ventas exentas</th>
                    <th class="table-border" style="width: 10%;">Ventas gravadas</th>
                </tr>
            </thead>
            <tbody>

                @php
                    print $data['detalleDoc'];
                @endphp


                {{--
                <tr>
                    @php
                        print_r($data['cuerpoDoc']);
                    @endphp

                    @foreach ($data['cuerpoDoc'] as $item)



                        <td class="table-border" style="text-align: center;width: 7%; ">{{ $item['cantidad'] }}</td>

                        <td class="table-border" style="text-align: left;">{{ $item['descripcion'] }}</td>
                        <td class="table-border" style="text-align: right;">${{ $item['precioUni'] }}</td>

                        <td class="table-border" style="text-align: right;">${{ $item['noSuj'] }}</td>
                        <td class="table-border" style="text-align: right;">${{ $item['exenta'] }}</td>
                        <td class="table-border" style="text-align: right;">${{ $item['gravada'] }}</td>
                    @endforeach ()



                </tr>

                --}}


            </tbody>

        </table>

        {{--

            <table width="100%" style="border-collapse: collapse; margin-bottom: 5px;margin-top:5px">

            <caption style="background-color: #eeeeeeab; font-weight: bold; height: 20px; vertical-align: center;">
                CUERPO DEL DOCUMENTO</caption>

            <thead style="background-color: #eeeeeeab;">
                <tr>
                    <th class="table-border">Num Item</th>
                    <th class="table-border">Cantidad</th>
                    <th class="table-border">Unidad de Medida</th>
                    <th class="table-border">Descripción</th>
                    <th class="table-border" style="width: 10%;">Precio unitario</th>
                    <th class="table-border" style="width: 10%;">Descuentos</th>
                    <th class="table-border" style="width: 10%;">Ventas no sujetas</th>

                    <th class="table-border" style="width: 10%;">Ventas exentas</th>
                    <th class="table-border" style="width: 10%;">Ventas gravadas</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @php
                        print_r($data['cuerpoDoc']);
                    @endphp

                    @foreach ($data['cuerpoDoc'] as $item)


                        <td class="table-border" style="text-align: center;">{{ $item['numItem'] }}</td>
                        <td class="table-border" style="text-align: right;">{{ $item['cantidad'] }}</td>
                        <td class="table-border" style="text-align: center;">{{ $item['medida'] }}</td>
                        <td class="table-border" style="text-align: center;">{{ $item['descripcion'] }}</td>
                        <td class="table-border" style="text-align: right;">${{ $item['precioUni'] }}</td>
                        <td class="table-border" style="text-align: right;">${{ $item['descu'] }}</td>
                        <td class="table-border" style="text-align: right;">${{ $item['noSuj'] }}</td>
                        <td class="table-border" style="text-align: right;">${{ $item['exenta'] }}</td>
                        <td class="table-border" style="text-align: right;">${{ $item['gravada'] }}</td>
                    @endforeach ()



                </tr>
            </tbody>
        </table>

        --}}




        <!-- Pie -->
        {{-- <div class="footer">
            Código cliente: 6X27 | Página 1
        </div> --}}

    </div>

@if ($data['respuesta']['anulado']  )
    
    

    <div style="
    position: fixed;
    top: 35%;
    left: 5%;
    width: 100%;
    font-size: 80px;
    color: rgba(12, 12, 12, 0.4);
    transform: rotate(-30deg);
    z-index: -1;
    text-align: center;
    pointer-events: none;
">
    DOCUMENTO NO VÁLIDO
</div>

@endif
</body>

</html>
