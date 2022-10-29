<?php
    include_once "../configuraciones/conexion_bd.php";

    $query=("INSERT INTO material(nombre,proveedor,precio,existencia)
            VALUES('$_REQUEST[nombre]','$_REQUEST[proveedor]',
            '$_REQUEST[precio]','$_REQUEST[existencia]')");

    $consulta=pg_query($conexion,$query);
    pg_close();
    echo 'El material se registro correctamente';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>
</head>
<body>
    <br><button type="button" onclick="location.href='materiales.php'">Atras</button>
    <button type="button" onclick="location.href='http://localhost/Jewy_accesv3/'">Inicio</button>
</body>
</html>