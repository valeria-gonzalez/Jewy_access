<?php
include_once '../configuraciones/conexion_bd.php';
$query_consulta = "SELECT * FROM venta";
$consulta=pg_query($conexion,$query_consulta);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/styles.css"> <!--link al archivo css-->
        <link rel="stylesheet" href="../css/tabla_opc.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."metadata.html"); ?> 
        <title>Tabla de clientes</title>
    </head>
    <body>
    <div class = "wrapper" id = "vista-ventas">
                <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."header-nav.html"); ?> <!--codigo php usado para incluir el header sin necesidad del codigo-->
                
                <div class = "main_container" >
                    <div class="item" id = "tabla">

                        <h3 class="text-center">Tabla Dinámica Ventas</h3>
                        <button type="button" class="boton-personalizado" onclick="location.href='vista_pedidos.php'">Pedidos</button>
                        <div class="outer-wrapper">
                            <div class="table-wrapper">
                                <table class="styled-table">
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
                                        </tr>
                                        <?php } } }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>                        
                    </div> <!-- Fin de item -->
                </div> <!-- Fin de main_container -->
            </div> <!-- Fin de la clase wrapper -->
    </body>
</html>