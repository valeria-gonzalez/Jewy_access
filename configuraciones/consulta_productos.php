<?php
include_once '../configuraciones/conexion_bd.php';
//Obtenemos el nombre o letra del producto 
$nombre = $_GET["search"];
//Hacemos la consulta
$query_consulta = "SELECT 
                        c1.ID_PRODUCTO, c1.NOMBRE, c1.CATEGORIA, c1.PRECIO, c1.EXISTENCIA, 
                        STRING_AGG(c3.NOMBRE, E',\n') MATERIALES
                    FROM
                        producto c1
                    INNER JOIN  producto_hecho_con c2 USING (ID_PRODUCTO)
                    INNER JOIN material c3 USING (ID_MATERIAL)
                    WHERE c1.NOMBRE like '%$nombre%'
                    GROUP BY
                        c1.ID_PRODUCTO;";



$consulta=pg_query($conexion,$query_consulta);
$cerrar_conexion = pg_close($conexion);
?>
<!-- Y de la misma manera solo mostramos aquellas coincidencias con alguna letra o nombre -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de clientes</title>
</head>
<body>
    <h3 class="text-center">Coincidencia con la busqueda</h3>
    <div class="table-responsive table-hover" id="tablaconsulta">
        <table class="table">
            <tbody>
                <?php                
                    if(pg_num_rows($consulta) > 0){?>
                        <div class="table-responsive table-hover" id="tablaconsulta">
                            <thead class="text-muted">
                                <th class="text-center">Id</th> <!--Le agregue la columna ID para q el cliente sepa como relacionar al ingresar otros datos-->
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Categoria</th>
                                <th class="text-center">Precio</th>
                                <th class="text-center">Existencia</th>
                                <th class="text-center">Materiales</th>
                            </thead>
                <?php
                        while($obj=pg_fetch_object($consulta)){?>  
                <tr>
                    <td><?php echo $obj->id_producto?></td>
                    <td><?php echo $obj->nombre?></td>
                    <td><?php echo $obj->categoria?></td>
                    <td><?php echo $obj->precio?></td>
                    <td><?php echo $obj->existencia?></td>
                    <td><?php echo $obj->materiales?></td> <!--Agregue el string resultante de materiales con string_agg-->
                </tr>
                <?php } }
                //Si no hay nada relacionado que nos arroje este mensaje
                else
                    echo "No hay resultados.";
                
            ?>
            </tbody>
        </table>
        <!-- Boton para retroceder o ir al inicio -->
        <button type="button" onclick="location.href='http://localhost/Jewy_access/secciones/vista_productos.php'">Atras</button>
        <button type="button" onclick="location.href='http://localhost/Jewy_access/index.php'">inicio</button>
    </div>
</body>
</html>
<!-- Se hace practicamente lo mismo con los pedidos -->