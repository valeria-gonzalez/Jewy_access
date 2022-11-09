<?php
include_once '../configuraciones/conexion_bd.php';
//lo unico que cambie fue convertir las fechas a char para poner el formato que quisiera, y juntar fecha y hora para
//ahorrar espacio

$query_consulta = "SELECT 
                        c1.ID_PEDIDO, to_char(c1.FECHA_PEDIDO, E'DD/MM/YY\nHH:MI') AS FECHA_PEDIDO, 
                        to_char(c1.FECHA_ENTREGA, E'DD/MM/YY') ||E'\n'|| to_char(c1.HORA_ENTREGA, E'HH:MI') AS FECHA_ENTREGA,
                        c1.PRECIO, c1.PUNTO_ENTREGA, c1.CALLE, c1.NO_CASA, c1.COLONIA, c1.ESTADO, c1.PAIS, c1.CODIGO_POSTAL, 
                        c1.REFERENCIA, c1.ID_CLIENTE,
                        STRING_AGG(c3.NOMBRE, E',\n') PRODUCTOS
                    FROM
                        pedido c1
                    INNER JOIN  pedido_contiene c2 USING (ID_PEDIDO)
                    INNER JOIN producto c3 USING (ID_PRODUCTO)
                    GROUP BY
                        c1.ID_PEDIDO;";

$consulta=pg_query($conexion,$query_consulta);
$cerrar_conexion = pg_close($conexion);

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/styles.css"> <!--link al archivo css-->
        <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."metadata.html"); ?> 
        <title>Tabla de clientes</title>
    </head>
    <body>
    <div class = "wrapper" id = "vista-cliente">
            <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."header-nav.html"); ?> <!--codigo php usado para incluir el header sin necesidad del codigo-->
            
            <div class = "main_container" >
                <div class="item" id = "tabla-cliente">

                    <h3 class="text-center">Tabla Dinámica Pedidos</h3>
                    <form action="../configuraciones/consulta_pedidos.php" method="get">
                        <!-- Verificacion para solo agregar numeros -->
                        <input type="number" ondrop="return false"; onpaste="return false"; onkeypress="return event.charCode>=48 && event.charCode<=57" name="search" placeholder="Ingrese el ID a buscar" required>
                        <input type="submit" name="enviar" value="Buscar">

                    </form>
                    <div class="table-responsive table-hover" id="tablaconsulta">
                        <table class="table">
                            <thead class="text-muted">
                                <th class="text-center">Id</th>
                                <th class="text-center">Id Cliente</th>
                                <th class="text-center">Fecha del pedido</th>
                                <th class="text-center">Fecha de entrega</th>
                                <th class="text-center">Productos</th>
                                <th class="text-center">Precio</th>
                                <th class="text-center">Punto de entrega</th>
                                <th class="text-center">Calle</th>
                                <th class="text-center">No. de casa</th>
                                <th class="text-center">Colonia</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">País</th>
                                <th class="text-center">Código postal</th>
                                <th class="text-center">Referencia</th>
                                <th class="text-center">Opciones</th>
                            </thead>
                            <tbody>
                                <?php
                                if($consulta){
                                    if(pg_num_rows($consulta) > 0){
                                        while($obj=pg_fetch_object($consulta)){?>
                                <tr>
                                    <td><?php echo $obj->id_pedido?></td>
                                    <td><?php echo $obj->id_cliente?></td>
                                    <td><?php echo $obj->fecha_pedido?></td>
                                    <td><?php echo $obj->fecha_entrega?></td>
                                    <td><?php echo $obj->productos?></td>
                                    <td><?php echo $obj->precio?></td>
                                    <td><?php echo $obj->punto_entrega?></td>
                                    <td><?php echo $obj->calle?></td>
                                    <td><?php echo $obj->no_casa?></td>
                                    <td><?php echo $obj->colonia?></td>
                                    <td><?php echo $obj->estado?></td>
                                    <td><?php echo $obj->pais?></td>
                                    <td><?php echo $obj->codigo_postal?></td>
                                    <td><?php echo $obj->referencia?></td>
                                    <td>
                                        <a id = "Edit" href  = "../configuraciones/mod_pedido.php?id_pedidos=<?php echo $obj->id_pedido;?>" >Editar</a> -  
                                        <a href="eliminar_pedido.php?id_pedidos=<?php echo $obj->id_pedido;?>" onclick='return confirmacion()'>Borrar</a> -  
                                        <a href="pedido_vendido.php?id_pedidos=<?php echo $obj->id_pedido;?>" onclick='return confirmar_venta()'>Marcar Vendido</a> 
                                    </td>
                                </tr>
                                <?php } } }?>
                            </tbody>
                        </table>
                        <button type="button" onclick="location.href='registrar_pedidos.php'">Registrar</button>
                    </div>
                    <script src="../js/alerta_eliminar.js"></script>
                </div> <!-- Fin de item -->
            </div> <!-- Fin de main_container -->
        </div> <!-- Fin de la clase wrapper -->
    </body>
</html>