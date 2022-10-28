<?php
include_once '../configuraciones/conexion_bd.php';
$query_consulta = "SELECT * FROM pedido";
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
    <h3 class="text-center">Tabla Dinámica Pedidos</h3>
    <div class="table-responsive table-hover" id="tablaconsulta">
        <table class="table">
            <thead class="text-muted">
                <th class="text-center">Fecha del pedido</th>
                <th class="text-center">Fecha de entrega</th>
                <th class="text-center">Hora de entrega</th>
                <th class="text-center">Precio</th>
                <th class="text-center">Punto de entrega</th>
                <th class="text-center">Calle</th>
                <th class="text-center">No. de casa</th>
                <th class="text-center">Colonia</th>
                <th class="text-center">Estado</th>
                <th class="text-center">País</th>
                <th class="text-center">Código postal</th>
                <th class="text-center">Referencia</th>
                <th class="text-center">Precio</th>
            </thead>
            <tbody>
                <?php
                if($consulta){
                    if(pg_num_rows($consulta) > 0){
                        while($obj=pg_fetch_object($consulta)){?>
                <tr>
                    <td><?php echo $obj->fecha_pedido?></td>
                    <td><?php echo $obj->fecha_entrega?></td>
                    <td><?php echo $obj->hora_entrega?></td>
                    <td><?php echo $obj->precio?></td>
                    <td><?php echo $obj->punto_entrega?></td>
                    <td><?php echo $obj->calle?></td>
                    <td><?php echo $obj->no_casa?></td>
                    <td><?php echo $obj->colonia?></td>
                    <td><?php echo $obj->estado?></td>
                    <td><?php echo $obj->pais?></td>
                    <td><?php echo $obj->codigo_postal?></td>
                    <td><?php echo $obj->referencia?></td>
                    <td><a href="#">Editar</a> - <a href="#">Borrar</a></td>
                </tr>
                <?php } } }?>
            </tbody>

        </table>
    </div>
</body>
</html>