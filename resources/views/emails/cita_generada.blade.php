<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cita Generada</title>
</head>
<body>
    <h1>¡Nueva Cita Generada!</h1>
    <p>Se ha creado o modificado una cita con los siguientes detalles:</p>
    <p><strong>Usuario:</strong> {{ $usuario }}</p>
    <p><strong>Fecha:</strong> {{ $fecha }}</p>
    <p><strong>Hora:</strong> {{ $hora }}</p>
    <p><strong>Descripción:</strong> {{ $descripcion }}</p>
    <p><strong>Entra en la aplicación para confirmar o denegar la cita</strong></p>
</body>
</html>
