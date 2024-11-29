<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Venta - Confirmación</title>
</head>

<body>
    <h1>Formulario de Venta Recibido</h1>
    <p>Hola {{ $nombre }},</p>
    <p>Hemos recibido tu formulario de venta. Aquí están los detalles de tu coche:</p>

    <ul>
        <li><strong>Nombre:</strong> {{ $nombre }}</li>
        <li><strong>Email:</strong> {{ $email }}</li>
        <li><strong>Marca:</strong> {{ $marca }}</li>
        <li><strong>Carrocería:</strong> {{ $carroceria }}</li>
        <li><strong>Modelo:</strong> {{ $modelo }}</li>
        <li><strong>Año:</strong> {{ $anio }}</li>
        <li><strong>Color:</strong> {{ $color }}</li>
        <li><strong>Cambio:</strong> {{ $cambio }}</li>
        <li><strong>Kilómetros:</strong> {{ $kilometros }}</li>
        <li><strong>Autonomía:</strong> {{ $autonomia }} Km</li>
        <li><strong>Potencia:</strong> {{ $potencia }} CV</li>
        <li><strong>Descripción:</strong> {{ $descripcion }}</li>
    </ul>

    <p><strong>Fotos enviadas:</strong> {{ $numeroDeImagenes }} imágenes</p>

    <p>Gracias por contactar con nosotros. Nos pondremos en contacto contigo pronto.</p>

    <p>Atentamente,<br>El equipo de Villablancars</p>
</body>

</html>
