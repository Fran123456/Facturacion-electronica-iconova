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

    @if ($data['respuesta']['anulado'])
        <style>
            body::before {
        content: "INVALIDADO";
        position: fixed;
        top: 20%;
        left: 0%;
        font-size: 140px;
        color: rgba(255, 0, 0, 0.2);
        transform: rotate(-30deg);
        z-index: 9999;
        width: 100%;
        text-align: center;
        pointer-events: none;
    }
        </style>
    @endif
</head>



<body>

    <div class="container">

        <!-- Encabezado -->
        <table width="100%" style="border-collapse: collapse; margin-bottom: 5px;">
            <tr>
                <!-- Columna izquierda: Logo + datos básicos -->
                <td width="42%" valign="top" style="padding-right: 5px;">
                    <div style=" text-align:center; height: 80px; padding-top:10px" class="">
                        <img src="{{ $img ? $img : 'logo.jpg' }}" style="max-height: 100%; max-width: 100%;" alt="">
                    </div>

                    <h3><strong> {{ $data['emisor']['nombre'] }}</strong></h3>
                    </p>
                    <p><strong>NIT:</strong> {{ $data['emisor']['numDoc'] }} / <strong>NRC:</strong>
                        {{ $data['emisor']['nrc'] }}  </p>

                    <p style="line-height: 1.5; !important"><strong>Dirección:</strong>
                        {{--  $data['emisor']['municipio'] . ', ' . $data['emisor']['departamento'] . ', ' . $data['emisor']['complemento'] --}}
                        {{ $data['emisor']['complemento'] }}
                    </p>
                    <p><strong>Teléfono:</strong> {{ $data['emisor']['telefono'] }} / <strong>Correo:</strong>
                        {{ $data['emisor']['correo'] }}</p>

                </td>

                <!-- Columna derecha: Información de factura -->
                <td width="58%" valign="top" style="padding-left: 10px;">
                    <br>
                    <div
                        style="background-color: rgb(59, 61, 62); color: white; text-align: center; padding-top:15px; padding-bottom:4px;
                        font-weight: bold;">
                        DOCUMENTO TRIBUTARIO ELECTRÓNICO <br>
                        @if ($data['respuesta']['numControl'] == '' || $data['respuesta']['numControl'] == null)
                            <h3>PRE-FACTURA - {{ $data['respuesta']['descripcionTipo'] }}</h3>
                        @else
                            <h3>{{ $data['respuesta']['descripcionTipo'] }}</h3>
                        @endif
                    </div>
                    <div style="background-color: #eee; padding: 8px; font-size: 12px;">
                        <p style="font-size: 11px;  !important"><strong>Código de generación:</strong>
                            {{ $data['respuesta']['codigo'] }}</p>
                        <p style="font-size: 11x; !important"><strong>Sello recepción:</strong>
                            {{ $data['respuesta']['sello'] }}</p>
                        <p style="font-size: 11px"><strong>Número de control:</strong>
                            {{ $data['respuesta']['numControl'] }}</p>
                        <p style="font-size: 11px"><strong>Ambiente:</strong> {{ $data['respuesta']['ambiente'] }}</p>
                        <p style="font-size: 11px"><strong>Versión del JSON:</strong>
                            {{ $data['respuesta']['version'] }}</p>
                        <p style="font-size: 11px"> <strong>Fecha de emisión:</strong>
                            {{ $data['respuesta']['fecha'] }}</p>
                        <p style="font-size: 11px"><strong>Hora de emisión:</strong> {{ $data['respuesta']['hora'] }}
                        </p>
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
                        @switch($data['tipoDocumento'])
                            @case('03')
                                <p><strong>Nombre:</strong>
                                    @if ($data['receptor']['nombre'] == null || $data['receptor']['nombre'] == '')
                                        Sin registro
                                    @else
                                        {{ $data['receptor']['nombre'] }}
                                    @endif
                                </p>
                                <p><strong>{{ $data['receptor']['tipoDoc'] }}:</strong>
                                    @if ($data['receptor']['numDoc'] == null || $data['receptor']['numDoc'] == '')
                                        Sin registro
                                    @else
                                        {{ $data['receptor']['numDoc'] }}
                                    @endif
                                </p>
                                @if ($data['receptor']['nrc'] != null)
                                    <p style="margin-bottom:2;"><strong>NRC:</strong>
                                        {{ $data['receptor']['nrc'] ?? 'Sin registro' }}</p>
                                @endif
                                <p style="margin-top:0; margin-bottom:2; line-height:1.5;"><strong>Actividad Económica:</strong>
                                    {{ $data['receptor']['actividad'] ?? 'Sin registro' }}</p>
                                <p style="margin-top:0; margin-bottom:2; line-height:1.5;"><strong>Dirección:</strong>
                                    {{--   $data['receptor']['municipio'] . ', ' . $data['receptor']['departamento'] . ', ' . $data['receptor']['complemento'] --}}
                                    @if ($data['receptor']['complemento'] == null || $data['receptor']['complemento'] == '')
                                        Sin registro
                                    @else
                                        {{ $data['receptor']['complemento'] }}
                                    @endif
                                </p>
                                <p><strong>Teléfono:</strong> {{ $data['receptor']['telefono'] ?? 'Sin registro' }}</p>
                                <p><strong>Correo:</strong> {{ $data['receptor']['correo'] ?? 'Sin registro' }}</p>
                                <p><strong>Condición Pago:</strong> {{ $data['receptor']['condicionPago'] }}

                                    @if ($data['receptor']['plazo'] != null)
                                        <strong>Plazo:</strong> {{ $data['receptor']['plazo'] }}
                                    @endif


                                    @if ($data['receptor']['periodo'] != null)
                                        <strong>Periodo:</strong> {{ $data['receptor']['periodo'] }}
                                    @endif

                                </p>
                            @break

                            @case('01')
                                <p><strong>Nombre:</strong>
                                    @if ($data['receptor']['nombre'] == null || $data['receptor']['nombre'] == '')
                                        Sin registro
                                    @else
                                        {{ $data['receptor']['nombre'] }}
                                    @endif
                                </p>
                                <p style="margin-bottom:2;">
                                    <strong>{{ $data['receptor']['tipoDoc'] ? $data['receptor']['tipoDoc'] : 'Documento' }}:</strong>
                                    @if ($data['receptor']['numDoc'] == null || $data['receptor']['numDoc'] == '')
                                        Sin registro
                                    @else
                                        {{ $data['receptor']['numDoc'] }}
                                    @endif
                                </p>
                                <p style="margin-top:0; margin-bottom:0; line-height:1.5;"><strong>Dirección:</strong>
                                    {{--   $data['receptor']['municipio'] . ', ' . $data['receptor']['departamento'] . ', ' . $data['receptor']['complemento'] --}}
                                    @if ($data['receptor']['complemento'] == null || $data['receptor']['complemento'] == '')
                                        Sin registro
                                    @else
                                        {{ $data['receptor']['complemento'] }}
                                    @endif
                                </p>
                                <p><strong>Teléfono:</strong> {{ $data['receptor']['telefono'] ?? 'Sin registro' }}</p>
                                <p><strong>Correo:</strong> {{ $data['receptor']['correo'] ?? 'Sin registro' }}</p>
                                <p><strong>Condición Pago:</strong> {{ $data['receptor']['condicionPago'] }}
                                    @if ($data['receptor']['plazo'] != null)
                                        <strong>Plazo:</strong> {{ $data['receptor']['plazo'] }}
                                    @endif


                                    @if ($data['receptor']['periodo'] != null)
                                        <strong>Periodo:</strong> {{ $data['receptor']['periodo'] }}
                                    @endif
                                </p>
                            @break

                            @default
                                <p><strong>Nombre:</strong>
                                    @if ($data['receptor']['nombre'] == null || $data['receptor']['nombre'] == '')
                                        Sin registro
                                    @else
                                        {{ $data['receptor']['nombre'] }}
                                    @endif
                                </p>


                                <p><strong>Dirección:</strong>
                                    {{--   $data['receptor']['municipio'] . ', ' . $data['receptor']['departamento'] . ', ' . $data['receptor']['complemento'] --}}
                                    @if ($data['receptor']['complemento'] == null || $data['receptor']['complemento'] == '')
                                        Sin registro
                                    @else
                                        {{ $data['receptor']['complemento'] }}
                                    @endif
                                </p>
                                @if ($data['receptor']['nrc'] != null)
                                    <p><strong>NRC:</strong> {{ $data['receptor']['nrc'] ?? 'Sin registro' }}</p>
                                @endif

                                <p><strong>Tipo Documento: </strong>

                                    @if ($data['receptor']['tipoDoc'] == null || $data['receptor']['tipoDoc'] == '')
                                        Sin registro
                                    @else
                                        {{ $data['receptor']['tipoDoc'] }}
                                    @endif
                                </p>

                                <p><strong>Documento:</strong>

                                    @if ($data['receptor']['numDoc'] == null || $data['receptor']['numDoc'] == '')
                                        Sin registro
                                    @else
                                        {{ $data['receptor']['numDoc'] }}
                                    @endif
                                </p>
                                <p><strong>Teléfono:</strong> {{ $data['receptor']['telefono'] ?? 'Sin registro' }}</p>
                                <p><strong>Correo:</strong> {{ $data['receptor']['correo'] ?? 'Sin registro' }}</p>
                        @endswitch
                    </div>

                </td>

                <!-- Columna derecha: Información personal -->
                <td width="30%" valign="top" style="margin-top:-10px;text-align: center;">




                    <img src="data:image/png;base64, {!! $qr !!}" alt="QR Code" width="160"
                        height="160" style="margin-button:10px">




                </td>
            </tr>
        </table>
        <br>



        @if ($data['respuesta']['tipo_doc'] == '05')
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
                        <td class="table-border" style="text-align: center;">
                            {{ \Carbon\Carbon::parse($data['dteRel']['fecha_recibido'])->format('d/m/Y') }}</td>
                        <td class="table-border" style="text-align: center;">{{ $data['dteRel']['codigo_generacion'] }}
                        </td>
                        <td class="table-border" style="text-align: center;">{{ $data['dteRel']['numero_dte'] }}</td>
                    </tr>
                </tbody>
            </table>
            <br>
        @endif

        @if ($data['comentario'] != null)
            <caption style="background-color: #eeeeeeab; height: 20px; vertical-align: right; text-align: left">
                <strong>Comentario: </strong> {{ $data['comentario'] }}
            </caption>



            <br>
        @endif



        <table width="100%" style="border-collapse: collapse; margin-bottom: 5px;margin-top:5px">

            <caption style="background-color: #eeeeeeab; font-weight: bold; height: 20px; vertical-align: center;">
                CUERPO DEL DOCUMENTO</caption>



            <thead style="background-color: #eeeeeeab;">
                <tr>

                    <th class="table-border">Cantidad</th>
                    <th class="table-border">Codigo</th>
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




            </tbody>

        </table>








        <!-- Pie -->
        {{-- <div class="footer">
            Código cliente: 6X27 | Página 1
        </div> --}}

    </div>

 
</body>

</html>
