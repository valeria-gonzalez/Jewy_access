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
        <link rel="stylesheet" href="../css/styles.css"> <!--link al archivo css-->
        <link rel="stylesheet" href="../css/tablas.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."metadata.html"); ?> 
        <title>Tabla de clientes</title>
    </head>
    <body>
    <div class = "wrapper" id = "vista-productos">
                <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."header-nav.html"); ?> <!--codigo php usado para incluir el header sin necesidad del codigo-->
                
                <div class = "main_container" >
                    <div class="item" id = "tabla-productos">

                        <h3 class="text-center">Tabla Dinámica Productos</h3>
                        <button type="button" class="boton-personalizado" onclick="location.href='registrar_productos.php'">Registrar</button>
                        <div class = "buscar">
                            <form action="../configuraciones/consulta_productos.php" method="get">
                                <!-- Required para que no se pueda buscar el campo vacio, se puede personalizar -->
                                <!-- Pero no se como :c -->
                                <div>
                                    <input class="box" type="text" name="search" placeholder="Ingrese el nombre a buscar" required>
                                </div>  
                                <div class = "btn-busq-wrap"> 
                                    <input class="boton-busq" type="submit" name="enviar" value="Buscar">            
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive table-hover" id="tablaconsulta">
                            <table class="styled-table">
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
                                        <a class="texto_iconos" id = "Edit" href  = "../configuraciones/mod_productos.php?id_productos=<?php echo $obj->id_producto;?>">
                                        <i class="fa-solid fa-pen" id="iconos"></i> &nbsp;&nbsp;&nbsp;Editar
                                        </a> &nbsp;&nbsp;&nbsp;&nbsp;
                                        <a class="texto_iconos" href="eliminar_producto.php?id_productos=<?php echo $obj->id_producto;?>" onclick='return confirmacion()'>
                                        <i class="fa-solid fa-trash" id="borrar"></i>&nbsp;&nbsp;&nbsp;Borrar
                                        </a>
                                        </td>
                                    </tr>
                                    <?php } } }?>
                                </tbody>
                            </table>
                        </div> <!-- Fin de la tabla -->
                        <script src="../js/alerta_eliminar.js"></script>
                    </div> <!-- Fin de item -->
                </div> <!-- Fin de main_container -->
            </div> <!-- Fin de la clase wrapper -->                            
    </body>
</html>