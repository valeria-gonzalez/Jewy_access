<?php
include_once "../configuraciones/conexion_bd.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
</head>
<body>

    <h2>Registrar Venta</h2>
    <form action="registrar_ventas.php" method="POST">
    <label for="nombre"><b>Fecha de pedido: </b></label>
    <input type="text" name="fecha_pedido">
    <label for="nombre"><b>Fecha de entrega: </b></label>
    <input type="text" name="fecha_entrega">
    <label for="  nombre"><b>Hora de entrega: </b></label>
    <input type="text" name="hora_entrega"><br><br>
    <label for="nombre"><b>Precio: </b></label>
    <input type="text" name="precio">
    <label for="nombre"><b>Punto de entrega: </b></label>
    <input type="text" name="punto_entrega">
    <label for="nombre"><b>Calle: </b></label>
    <input type="text" name="calle"><br><br>
    <label for="nombre"><b>Numero de casa: </b></label>
    <input type="text" name="no_casa">
    <label for="nombre"><b>Colonia: </b></label>
    <input type="text" name="colonia">
    <label for="nombre"><b>Estado: </b></label>
    <input type="text" name="estado"><br><br>
    <label for="nombre"><b>Pais: </b></label>
    <input type="text" name="pais">
    <label for="nombre"><b>Codigo Postal: </b></label>
    <input type="text" name="codigo_postal">
    <label for="nombre"><b>Referencia: </b></label>
    <input type="text" name="referencia"><br><br>
    <input type="submit" value="Registrar"></form><br>    

    <button type="button" onclick="location.href='http://localhost/Jewy_access/'">Atras</button>
</body>
</html>