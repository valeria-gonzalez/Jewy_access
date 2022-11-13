<!-- Empezaremos abriendo código php, por lo tanto se comentara de una manera distinta -->
<?php
//Incluimos nuestra conexión a la base de datos
include_once '../configuraciones/conexion_bd.php';
/*Creamos con $ una nueva variable llamada "query_consulta" en donde almacenaremos 
nuestra petición como si estuvieramos en postgres*/
$query_consulta = "SELECT * FROM cliente";
/* Creamos otra variable en donde mandaremos a llamar una función de php
que hace que podamos interactuar desde php a nuestra base de datos, por lo tanto
le pasaremos dos parármetros, primero la varible de nuestra conexión que creamos
en el archivo de "conexion_bd.php" y el otro parámetro será nuestra consulta*/
$consulta=pg_query($conexion,$query_consulta);
?>
<!-- Estructura html básica-->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/styles.css"> <!--link al archivo css-->
        <link rel="stylesheet" href="../css/tabla_sin_busq.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."metadata.html"); ?> 
        <!-- Título de la página -->
        <title>Tabla de clientes</title>
    </head>
    <body>
        <section class="main-content">
            <div class = "wrapper" id = "vista-clientes">
                <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."header-nav.html"); ?> <!--codigo php usado para incluir el header sin necesidad del codigo-->
                
                <div class = "main_container" >
                    <div class="item" id = "tabla-cliente">
                        <!-- Nombre de la tabla -->
                        <h3 class="text-center">Tabla Dinámica Clientes</h3>
                        <button type="button" class="boton-personalizado" onclick="location.href='registrar_clientes.php'">Registrar</button>
                        <div class="table-responsive table-hover" id="tablaconsulta">
                            <!-- Creando la tabla -->
                            
                            <table class="styled-table"> 
                                <thead class="text-muted">
                                    <!-- Aquí pondremos las columnas que mostraremos en nuestra tabla -->
                                    <th class="user-info__basic">Nombre</th>
                                    <th class="user-info__basic">Apellido Paterno</th>
                                    <th class="user-info__basic">Apellido Materno</th>
                                    <th class="user-info__basic">Telefono</th>
                                    <th class="user-info__basic">Opciones</th>
                                </thead>
                                <tbody>
                                    <!-- De nuevo abrimos código php -->
                                    <?php
                                    /* Si nuestra consulta fue efectuada de manera correcta (abrimos llaves) */
                                    if($consulta){
                                        /* Si el número de datos es mayor a 0 en nuestra consulta (abrimos llaves) */
                                        if(pg_num_rows($consulta) > 0){
                                            /* Mientras nuestra variable obj tenga almacenado un objeto (con ayuda
                                            de la función pg_fetch_object) cuyas propiedades se corresponden 
                                            con los campos de la fila obtenida de nuestra base de datos con ayuda
                                            de la consulta (abrimos llaves)*/ 
                                            while($obj=pg_fetch_object($consulta)){?>
                                    <tr>
                                        <!-- Imprimiremos con obj todo aquella columna a mostrar junto con sus 
                                        datos -->
                                        <td><?php echo $obj->nombre?></td>
                                        <td><?php echo $obj->primer_apellido?></td>
                                        <td><?php echo $obj->segundo_apellido?></td>
                                        <td><?php echo $obj->telefono?></td>
                                        <td>
                                        <!-- Botones que podrían tener utilidad 
                                            UPDATE: dando utilidad al boton de "borrar" para eliminar clientes, llamando a "eliminar_clientes.php" y guardando el id del cliente en variable "id_clientes" con ayuda de código php y el obj que apunta a "id_cliente" en la base de datos-->
                                            <a class="texto_iconos" href="eliminar_cliente.php?id_clientes=<?php echo$obj->id_cliente;?>" onclick='return confirmacion()'>
                                            <i class="fa-solid fa-trash" id="iconos"></i>&nbsp;&nbsp;&nbsp;Borrar
                                            </a> 
                                        </td>
                                    
                                    </tr>
                                    <!-- Abrimos de nuevo código php para cerrar todas nuestras iteraciones
                                        abiertas-->
                                    <?php } } }?>
                                </tbody>
                                                <!-- Básicamente en los demás archivos de visualización es lo mismo
                                                solamente debes cambiar en el query_consulta el nombre de la tabla,
                                                en la tabla de html las columnas que quieres que se vean,
                                                y en la etiqueta td cambiar el nombre de aquellas columnas que
                                                imprimiras y que tienen que ser iguales a los nombres que se
                                                tienen en la base de datos de las respectivas tablas
                                                (siempre todo en minúscula, por que por alguna extraña razón
                                                no agarra el mayúscula como esta en la base de datos)-->
                            </table>
                        </div>
                        <script src="../js/alerta_eliminar.js"></script>
                    </div> <!-- Fin de item -->
                </div> <!-- Fin de main_container -->
            </div> <!-- Fin de la clase wrapper -->
        </section>
    </body>
</html>