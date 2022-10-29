<?php
include_once '../configuraciones/conexion_bd.php';
$query_consulta = "SELECT * FROM producto";
$consulta=pg_query($conexion,$query_consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de clientes</title>
</head>
<body>
    <h3 class="text-center">Tabla Dinámica Prodcutos</h3>
    <div class="table-responsive table-hover" id="tablaconsulta">
        <table class="table">
            <thead class="text-muted">
                <th class="text-center">Nombre</th>
                <th class="text-center">Categoria</th>
                <th class="text-center">Precio</th>
                <th class="text-center">Existencia</th>
            </thead>
            <tbody>
                <?php
                if($consulta){
                    if(pg_num_rows($consulta) > 0){
                        while($obj=pg_fetch_object($consulta)){?>
                <tr>
                    <td><?php echo $obj->nombre?></td>
                    <td><?php echo $obj->categoria?></td>
                    <td><?php echo $obj->precio?></td>
                    <td><?php echo $obj->existencia?></td>
                    <td><a href="#">Editar</a> - <a href="eliminar_producto.php?id_productos=<?php echo $obj->id_producto;?>">Borrar</a> - <a href="registar_productos.php">Agregar</a> </td>
                    
                </tr>
                <?php } } }?>
                <button type="button" onclick="location.href='http://localhost/Jewy_access/'">Inicio</button>
            </tbody>

        </table>
    </div>
</body>
</html>