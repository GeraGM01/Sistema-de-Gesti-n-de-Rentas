<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Contrato (Arrendatario)</title>
</head>
<body>
    <h1>Haz adquirido el arrendamiento de tu casa seleccionada</h1>
    <h2>Detalles del Contrato de Renta</h2>
    <p><strong>Dirección:</strong> {{ $data['direccion'] }}</p>
    <p><strong>Precio de Renta:</strong> ${{ $data['renta'] }}</p>
    <p><strong>Duración:</strong> {{ $data['inicio'] }} a {{ $data['fin'] }}</p>
    <p>Adjunto encontrarás el contrato de renta en formato PDF.</p>
    <p style="color: red;">
    <br>
    <strong>NOTA:</strong> ESTE CONTRATO DEBERÁ SER FIRMADO POR AMBAS PARTES PARA QUE TENGA VALIDEZ LEGAL</p>
</body>
</html>
