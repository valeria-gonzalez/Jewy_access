<?php
    include_once "../configuraciones/conexion_bd.php";

    $query=("INSERT INTO venta(fecha_pedido,fecha_entrega,hora_entrega,precio,punto_entrega,calle,no_casa,
            colonia,estado,pais,codigo_postal,referencia)
            VALUES('$_REQUEST[fecha_pedido]','$_REQUEST[fecha_entrega]','$_REQUEST[hora_entrega]',
            '$_REQUEST[precio]','$_REQUEST[punto_entrega]','$_REQUEST[calle]','$_REQUEST[no_casa]',
            '$_REQUEST[colonia]','$_REQUEST[estado]','$_REQUEST[pais]','$_REQUEST[codigo_postal]',
            '$_REQUEST[referencia]')");

    $consulta=pg_query($conexion,$query);
    pg_close();
    echo 'La venta se registro correctamente';
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
    <br><button type="button" onclick="location.href='ventas.php'">Atras</button>
    <button type="button" onclick="location.href='http://localhost/Jewy_access/'">Inicio</button>
</body>
</html>