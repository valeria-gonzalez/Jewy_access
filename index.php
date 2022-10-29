<?php 
    include_once "../jewy_access/configuraciones/conexion_bd.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Jewy_acces</title>
</head>
<body>
    <!--Botones para ingresar datos en cierta tabla o para visualizarla-->
    <h2>BASE DE DATOS MENU </h2>
    <label for="nombre"><b>CLIENTES</b></label><br>
    <button type="button" onclick="location.href='secciones/clientes.php'">Registrar</button>
    <button type="button" onclick="location.href='secciones/vista_clientes.php'">Visualizar Clientes</button>

    <br><br><label for="nombre"><b>MATERIALES</b></label><br>
    <button type="button" onclick="location.href='secciones/materiales.php'">Registrar</button>
    <button type="button" onclick="location.href='secciones/vista_material.php'">Visualizar Materiales</button>

    <br><br><label for="nombre"><b>PEDIDOS</b></label><br>
    <button type="button" onclick="location.href='secciones/pedidos.php'">Registrar</button>
    <button type="button" onclick="location.href='secciones/vista_pedidos.php'">Visualizar Pedidos</button>

    <br><br><label for="nombre"><b>PRODUCTOS</b></label><br>
    <button type="button" onclick="location.href='secciones/productos.php'">Registrar</button>
    <button type="button" onclick="location.href='secciones/vista_productos.php'">Visualizar Productos</button>

    <br><br><label for="nombre"><b>VENTAS</b></label><br>
    <button type="button" onclick="location.href='secciones/ventas.php'">Registrar</button>
    <button type="button" onclick="location.href='secciones/vista_ventas.php'">Visualizar Ventas</button>
</body>
</html>