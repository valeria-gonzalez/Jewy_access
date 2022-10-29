<?php
include_once "../configuraciones/conexion_bd.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>
<body>

    <h2>Registrar Productos</h2>
    <form action="registrar_productos.php" method="POST">
    <label for="nombre"><b>Nombre: </b></label>
    <input type="text" name="nombre">
    <label for="  nombre"><b>Categoria: </b></label>
    <input type="text" name="categoria"><br><br>
    <label for="nombre"><b>Precio: </b></label>
    <input type="text" name="precio">
    <label for="nombre"><b>Existencia: </b></label>
    <input type="text" name="existencia"><br><br>
    <input type="submit" value="Registrar"></form><br>    

    <button type="button" onclick="location.href='http://localhost/Jewy_accesv3/'">Atras</button>
</body>
</html>