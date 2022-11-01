<!--Archivo que recibe datos y los inserta en postgresql-->
<?php
    include_once "../configuraciones/conexion_bd.php";
    //Se define la peticion de insertado
    $query=("INSERT INTO cliente(nombre,primer_apellido,segundo_apellido,telefono)
            VALUES('$_REQUEST[nombre]','$_REQUEST[primer_apellido]',
            '$_REQUEST[segundo_apellido]','$_REQUEST[telefono]')");
    /*Se usa la misma variable de los archivos vista para interactuar
     entre php y nuestra base de datos   */
    $consulta=pg_query($conexion,$query);
    pg_close();
    //Aviso de que la insercion fue correcta
    echo 'El cliente se registro correctamente';
?>
<!-- estructura html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>
</head>
<body>
    <!-- Botones para regresar a la pagina anterior o al inicio -->
    <br><button type="button" onclick="location.href='clientes.php'">Atras</button>
    <button type="button" onclick="location.href='http://localhost/Jewy_access/'">Inicio</button>
</body>
</html>