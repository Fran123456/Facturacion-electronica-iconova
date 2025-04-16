<!-- resources/views/factura.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura DTE</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 11px; margin: 20px; color: #000; }
        h2, h3, h4 { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { padding: 4px; vertical-align: top; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .section { border: 1px solid #000; padding: 10px; margin-bottom: 10px; }
        .double-border { border: 2px solid #000; padding: 8px; margin-bottom: 10px; }
        .table-bordered th, .table-bordered td { border: 1px solid #000; }
        .title-section { text-align: center; margin-bottom: 10px; }
        .small-text { font-size: 10px; }
    </style>
</head>
<body>
    <div class="title-section">
        <h2 class="text-bold">DOCUMENTO TRIBUTARIO ELECTRÓNICO</h2>
        <h3 class="text-bold">FACTURA</h3>
    </div>

    <div class="section">
        <table>
            <tr>
                <td><strong>CÓDIGO DE GENERACIÓN:</strong> 695F9003-B555-1AD3-B828-0004AC1EA976</td>
                <td><strong>SELLO RECEPCIÓN:</strong> 20256494F8DA1648450282635785BE8C59C6VAAI</td>
            </tr>
            <tr>
                <td><strong>NÚMERO DE CONTROL:</strong> DTE-01-S006P001-000000000878466</td>
                <td><strong>TIPO DE TRANSMISIÓN:</strong> Normal</td>
            </tr>
            <tr>
                <td><strong>FECHA DE EMISIÓN:</strong> 19/03/2025</td>
                <td><strong>HORA DE EMISIÓN:</strong> 12:55:26 PM</td>
            </tr>
            <tr>
                <td><strong>MONEDA:</strong> USD</td>
                <td><strong>MODELO FACTURACIÓN:</strong> Previo</td>
            </tr>
        </table>
    </div>

    <div class="double-border">
        <h4 class="text-bold">SUPER REPUESTOS EL SALVADOR, S.A. DE C.V.</h4>
        <p>Venta de partes, piezas y accesorios nuevos para vehículos automotores</p>
        <p><strong>NIT:</strong> 0614-151172-002-7 &nbsp;&nbsp; <strong>NRC:</strong> 275-5</p>
        <p><strong>Dirección:</strong> Blvd. Constitución #504, San Salvador</p>
        <p><strong>Teléfono:</strong> 78549926 &nbsp;&nbsp; <strong>Correo:</strong> FE.SRESA@SUPERREPUESTOS.COM</p>
        <p><strong>Sitio Web:</strong> www.superrepuestos.com</p>
    </div>

    <div class="section">
        <h4 class="text-bold">Información del Receptor</h4>
        <p><strong>Nombre:</strong> FRANCISCO JOSE NAVAS HERNANDEZ</p>
        <p><strong>Dirección:</strong> Cuscatancingo, San Salvador</p>
        <p><strong>Documento:</strong> DUI - 05509737-9</p>
        <p><strong>Teléfono:</strong> 70234903 &nbsp;&nbsp; <strong>Correo:</strong> FRANCISCO.NAVAS.DATASYS@GMAIL.COM</p>
    </div>

    <h4 class="text-bold">Detalle del Documento</h4>
    <table class="table-bordered">
        <thead>
            <tr class="text-bold">
                <th>#</th>
                <th>Cantidad</th>
                <th>Unidad</th>
                <th>Código pieza</th>
                <th>Descripción</th>
                <th>Precio unitario</th>
                <th>Gravado</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>1.00</td>
                <td>Unidad</td>
                <td>0602095550</td>
                <td>FILTRO DE AIRE</td>
                <td class="text-right">11.64</td>
                <td class="text-right">11.64</td>
            </tr>
        </tbody>
    </table>

    <p><strong>VALOR EN LETRAS:</strong> ONCE 64/100 DOLARES</p>

    <h4 class="text-bold">Resumen de la Operación</h4>
    <table>
        <tr><td><strong>Operaciones no sujetas:</strong></td><td class="text-right">0.00</td></tr>
        <tr><td><strong>Operaciones exentas:</strong></td><td class="text-right">0.00</td></tr>
        <tr><td><strong>Operaciones gravadas:</strong></td><td class="text-right">11.64</td></tr>
        <tr><td><strong>Suma operaciones sin impuesto:</strong></td><td class="text-right">11.64</td></tr>
        <tr><td><strong>IVA retenido:</strong></td><td class="text-right">0.00</td></tr>
        <tr><td><strong>Monto total de la operación:</strong></td><td class="text-right">11.64</td></tr>
        <tr><td><strong>TOTAL A PAGAR:</strong></td><td class="text-right text-bold">11.64</td></tr>
    </table>

    <div class="small-text">
        <p>Este documento tributario electrónico ha sido generado a través de la plataforma SEF de Group PBS El Salvador para Super Repuestos.</p>
        <p>Consultas: soluciones@superrepuestos.com o al teléfono +503 2520 2520</p>
    </div>
</body>
</html>
