<?php
//Hacemos la conexion a la base de datos
include_once "../configuraciones/conexion_bd.php";
?>
<!--Abrimos estructura html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title><!--Definimos el titulo-->
</head>
<body>
    <!--Titulo de encabezado de la pagina-->
    <h2>Registrar Cliente</h2>
    <!--De esta forma el sistema pide los datos y permite insertarlos-->
    <form action="registrar_clientes.php" method="POST">
    <label for="nombre"><b>Nombre: </b></label>
    <input type="text" name="nombre">
    <label for="  nombre"><b>Primer Apellido: </b></label>
    <input type="text" name="primer_apellido"><br><br>
    <label for="nombre"><b>Segundo Apellido: </b></label>
    <input type="text" name="segundo_apellido">
    <label for="nombre"><b>Telefono: </b></label>
    <input type="text" name="telefono"><br><br>
    <!--Boton con el que registra los datos ingresados-->
    <input type="submit" value="Registrar"></form><br>    
    <!--Boton que permite regresar a la pagina anterior-->
    <button type="button" onclick="location.href='http://localhost/Jewy_access/'">Atras</button>
</body>
</html>