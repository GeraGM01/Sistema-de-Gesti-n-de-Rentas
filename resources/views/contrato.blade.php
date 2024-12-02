<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Renta</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 30px;
            font-weight: 700;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 15px;
        }

        .contenido {
            margin-top: 20px;
        }

        .strong-text {
            font-weight: bold;
            color: #333;
        }

        .firma {
            margin-top: 50px;
            display: grid;
            grid-template-columns: 1fr 1fr; /* Crear dos columnas */
            gap: 40px;
            border-top: 2px solid #ddd;
            padding-top: 20px;
        }

        .firma div {
            text-align: center;
        }

        .firma p {
            margin: 0;
            font-size: 16px;
        }

        .firma .line {
            border-top: 1px solid #333;
            margin: 0 auto;
            width: 70%;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Contrato de Arrendamiento</h1>
        <div class="contenido">
            <p>En la ciudad de <span class="strong-text">{{ $ciudad }}</span>, a {{ $fecha }}, se celebra el presente contrato de arrendamiento entre:</p>

            <p><span class="strong-text">Arrendador:</span> {{ $arrendador }}<br>
            <span class="strong-text">Arrendatario:</span> {{ $arrendatario }}</p>

            <p><span class="strong-text">Dirección del inmueble:</span> {{ $direccion }}</p>

            <p><span class="strong-text">Fecha de inicio:</span> {{ $inicio }}<br>
            <span class="strong-text">Fecha de fin:</span> {{ $fin }}</p>

            <p><span class="strong-text">Renta mensual:</span> ${{ number_format($renta, 2) }}</p>

            <p><span class="strong-text">Condiciones del arrendamiento:</span> El arrendatario se compromete a pagar la renta mensual durante el periodo de arrendamiento...</p>

            <div class="firma">
                <br><br><br><br><div>
                    <p class="line"></p>
                    <p><strong>Arrendador:</strong> {{ $arrendador }}</p>
                </div><br><br><br><br>
                <div>
                    <p class="line"></p>
                    <p><strong>Arrendatario:</strong> {{ $arrendatario }}</p>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Contrato elaborado por <strong>TRENTA DE CASAS LARAVEL</strong>. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
