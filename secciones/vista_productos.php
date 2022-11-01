<?php
include_once '../configuraciones/conexion_bd.php';

//Esta consulta permite mostrar los datos de la tabla productos y la lista de nombres de materiales que usa 
//relacionando las tablas: PRODUCTO, PRODUCTO_HECHO_CON Y MATERIALES
//le llamaremos a tabla productos c1, a producto_hecho_con c2 y a materiales c3
//resulta necesario incluir la tabla materiales pq asi primero consultamos id_producto en producto= id_producto en hecho_con
//y despues relacionamos el valor id_material en hecho_con = id_material en tabla materiales, sacando de ahi el nombre del material
//string_agg es una funcion que permite concatenar los valores de columnas en un solo string, separado por un delimitador
//GROUP_BY se encarga de agrupar regisros que tengan el mismo valor en la columna especificada
$query_consulta = "SELECT 
                        c1.ID_PRODUCTO, c1.NOMBRE, c1.CATEGORIA, c1.PRECIO, c1.EXISTENCIA, 
                        STRING_AGG(c3.NOMBRE, E',\n') MATERIALES
                    FROM
                        producto c1
                    INNER JOIN  producto_hecho_con c2 USING (ID_PRODUCTO)
                    INNER JOIN material c3 USING (ID_MATERIAL)
                    GROUP BY
                        c1.ID_PRODUCTO;";



$consulta=pg_query($conexion,$query_consulta);
$cerrar_conexion = pg_close($conexion);
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
                <th class="text-center">Id</th> <!--Le agregue la columna ID para q el cliente sepa como relacionar al ingresar otros datos-->
                <th class="text-center">Nombre</th>
                <th class="text-center">Categoria</th>
                <th class="text-center">Precio</th>
                <th class="text-center">Existencia</th>
                <th class="text-center">Materiales</th> <!--Le agregue la columna materiales para enlistarlos aqui-->
                <th class="text-center">Acciones</th> <!--Le puse un nombre a las acciones pero dicen q opinan-->   
            </thead>
            <tbody>
                <?php
                if($consulta){
                    if(pg_num_rows($consulta) > 0){
                        while($obj=pg_fetch_object($consulta)){?>
                <tr>
                    <td><?php echo $obj->id_producto?></td>
                    <td><?php echo $obj->nombre?></td>
                    <td><?php echo $obj->categoria?></td>
                    <td><?php echo $obj->precio?></td>
                    <td><?php echo $obj->existencia?></td>
                    <td><?php echo $obj->materiales?></td> <!--Agregue el string resultante de materiales con string_agg-->
                    <td>
                        <a id = "Edit" href  = "../configuraciones/mod_productos.php">
                            <button class = "button">Editar</button>
                        </a> 
                        <a href="eliminar_producto.php?id_productos=<?php echo $obj->id_producto;?>">
                            <button class = "button">Borrar</button>
                        </a> 
                        <a href="productos.php">
                            <button class = "button">Agregar</button>
                        </a> 
                    </td>
                    
                </tr>
                <?php } } }?>
                <button type="button" onclick="location.href='http://localhost/Jewy_access/'">Inicio</button>
            </tbody>

        </table>
    </div> <!-- Fin de la tabla -->
</body>
</html>