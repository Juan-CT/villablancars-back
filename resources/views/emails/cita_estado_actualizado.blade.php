<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El estado de tu cita ha sido actualizado</title>
</head>
<body>
    <h1>Estado de tu cita actualizado</h1>
    <p>Hola {{ $cita->usuario->nombre }},</p>
    <p>El estado de tu cita programada para el {{ $cita->fecha }} a las {{ $cita->hora }} ha cambiado a:</p>
    <p><strong>{{ ucfirst($nuevoEstado) }}</strong></p>
    <p>Si tienes alguna duda, no dudes en contactarnos.</p>
</body>
</html>
