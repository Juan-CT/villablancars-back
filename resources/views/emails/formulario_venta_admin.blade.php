<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo formulario de venta de coche</title>
</head>

<body>
    <h1>Nuevo formulario de venta de coche recibido</h1>

    <p><strong>Detalles del coche:</strong></p>
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

    <p>Este formulario ha sido enviado por un usuario interesado en vender su coche eléctrico.</p>

    <p><strong>¡Por favor, revisa la información y contacta con el usuario!</strong></p>

    <hr>
    <p><strong>Detalles del Formulario:</strong></p>
    <ul>
        <li><strong>Formulario enviado el:</strong> {{ now()->format('d/m/Y H:i') }}</li>
    </ul>

    <p>Atentamente,<br>El sistema de Villablancars</p>
</body>

</html>
