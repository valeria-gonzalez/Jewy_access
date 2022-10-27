<?php
include_once '../configuraciones/conexion_bd.php';
$query_consulta = "SELECT * FROM cliente";
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
    <h3 class="text-center">Tabla Dinámica</h3>
    <div class="table-responsive table-hover" id="tablaconsulta">
        <table class="table">
            <thead class="text-muted">
                <th class="text-center">Nombre</th>
                <th class="text-center">Apellido Paterno</th>
                <th class="text-center">Apellido Materno</th>
                <th class="text-center">Telefono</th>
                <th class="text-center">Opciones</th>
            </thead>
            <tbody>
                <?php
                if($consulta){
                    if(pg_num_rows($consulta) > 0){
                        while($obj=pg_fetch_object($consulta)){?>
                <tr>
                    <td><?php echo $obj->nombre?></td>
                    <td><?php echo $obj->primer_apellido?></td>
                    <td><?php echo $obj->segundo_apellido?></td>
                    <td><?php echo $obj->telefono?></td>
                    <td><a href="#">Editar</a> - <a href="clientes.php?id_clientes=<?php echo $obj->id_cliente;?>">Borrar</a></td>
                </tr>
                <?php } } }?>
            </tbody>

        </table>
    </div>
</body>
</html>