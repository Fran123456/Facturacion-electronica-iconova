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
                <td width="50%" valign="top" style="padding-right: 10px;">
                    <div
                        style="background-color: #eee; height: 100px; text-align: center; line-height: 50px; font-weight: bold;">
                        LOGITO UWU XD
                    </div>
                    <p><strong>NIT:</strong> {{ $data['emisor']['numDoc'] }}</p>
                    <p><strong>NRC:</strong> {{ $data['emisor']['nrc'] }}</p>
                    <p style="line-height: 14px; !important"><strong>Dirección:</strong>
                        {{ $data['emisor']['municipio'] . ', ' . $data['emisor']['departamento'] . ', ' . $data['emisor']['complemento'] }}
                    </p>
                    <p><strong>Teléfono:</strong> {{ $data['emisor']['telefono'] }}</p>
                    <p><strong>Correo:</strong> {{ $data['emisor']['correo'] }}</p>
                </td>

                <!-- Columna derecha: Información de factura -->
                <td width="50%" valign="top" style="padding-left: 10px;">
                    <div
                        style="background-color: #d00; color: white; text-align: center; padding: 5px; font-weight: bold;">
                        DOCUMENTO TRIBUTARIO ELECTRÓNICO <br>
                        {{ $data['respuesta']['tipo'] }}
                    </div>
                    <div style="background-color: #eee; padding: 8px; font-size: 12px;">
                        <p style="line-height: 14px; !important"><strong>Código de generación:</strong>
                            {{ $data['respuesta']['codigo'] }}</p>
                        <p style="line-height: 14px; !important"><strong>Sello recepción:</strong> <br>
                            {{ $data['respuesta']['sello'] }}</p>
                        <p><strong>Número de control:</strong> {{ $data['respuesta']['numControl'] }}</p>
                        <p><strong>Ambiente:</strong> {{ $data['respuesta']['ambiente'] }}</p>
                        <p><strong>Versión del JSON:</strong> {{ $data['respuesta']['version'] }}</p>
                        <p><strong>Fecha de emisión:</strong> {{ $data['respuesta']['fecha'] }}</p>
                        <p><strong>Hora de emisión:</strong> {{ $data['respuesta']['hora'] }}</p>
                    </div>
                </td>
            </tr>
        </table>


        <table width="100%" style="border-collapse: collapse; margin-bottom: 10px;">
            <tr>
                <!-- Columna izquierda: Datos del receptor -->
                <td width="50%" valign="top" style="padding-right: 10px;">
                    <div style="background-color: #f5f5f5; padding: 8px; border: 1px solid #ccc;">
                        <p><strong>Nombre:</strong> {{ $data['receptor']['nombre'] }}</p>
                        <p><strong>Dirección:</strong>
                            {{ $data['receptor']['municipio'] . ', ' . $data['receptor']['departamento'] . ', ' . $data['receptor']['complemento'] }}
                        </p>
                        <p><strong>NRC:</strong> {{ $data['receptor']['nrc'] }}</p>
                    </div>
                </td>

                <!-- Columna derecha: Información personal -->
                <td width="50%" valign="top" style="padding-left: 10px;">
                    <div style="background-color: #f5f5f5; padding: 8px; border: 1px solid #ccc;">
                        <p><strong>Tipo y N° Documento:</strong>
                            {{ $data['receptor']['tipoDoc'] . ' - ' . $data['receptor']['numDoc'] }}</p>
                        <p><strong>Teléfono:</strong> {{ $data['receptor']['telefono'] }}</p>
                        <p><strong>Correo:</strong> {{ $data['receptor']['correo'] }}</p>
                    </div>
                </td>
            </tr>
        </table>


        <table width="100%" style="border-collapse: collapse; margin-bottom: 5px;">
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
                    {{-- <th class="table-border" style="width: 10%;">IVA</th> --}}
                    <th class="table-border" style="width: 10%;">Ventas exentas</th>
                    <th class="table-border" style="width: 10%;">Ventas gravadas</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($data['cuerpoDoc'] as $item)
                        <td class="table-border" style="text-align: center;">{{ $item['numItem'] }}</td>
                        <td class="table-border" style="text-align: right;">{{ $item['cantidad'] }}</td>
                        <td class="table-border" style="text-align: center;">{{ $item['medida'] }}</td>
                        <td class="table-border" style="text-align: center;">{{ $item['descripcion'] }}</td>
                        <td class="table-border" style="text-align: right;">${{ $item['precioUni'] }}</td>
                        <td class="table-border" style="text-align: right;">${{ $item['descu'] }}</td>
                        <td class="table-border" style="text-align: right;">${{ $item['noSuj'] }}</td>
                        {{-- <td class="table-border" style="text-align: right;">$100000</td> --}}
                        <td class="table-border" style="text-align: right;">${{ $item['exenta'] }}</td>
                        <td class="table-border" style="text-align: right;">${{ $item['gravada'] }}</td>
                    @endforeach ()

                    {{-- <td class="table-border" style="text-align: center;">1</td>
                    <td class="table-border" style="text-align: right;">10000</td>
                    <td class="table-border" style="text-align: center;">Unidad</td>
                    <td class="table-border" style="text-align: center;">Descripción de producto</td>
                    <td class="table-border" style="text-align: right;">$100000</td>
                    <td class="table-border" style="text-align: right;">$100000</td>
                    <td class="table-border" style="text-align: right;">$100000</td> --}}
                    {{-- <td class="table-border" style="text-align: right;">$100000</td> --}}
                    {{-- <td class="table-border" style="text-align: right;">$100000</td>
                    <td class="table-border" style="text-align: right;">$100000</td> --}}
                </tr>
            </tbody>
        </table>



        <!-- Pie -->
        {{-- <div class="footer">
            Código cliente: 6X27 | Página 1
        </div> --}}

    </div>
</body>

</html>
