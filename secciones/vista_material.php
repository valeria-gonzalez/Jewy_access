<?php
include_once '../configuraciones/conexion_bd.php';
$query_consulta = "SELECT * FROM material";
$consulta=pg_query($conexion,$query_consulta);
?>

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
        <title>Tabla de clientes</title>
    </head>
    <body>
    <div class = "wrapper" id = "vista-material">
            <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."header-nav.html"); ?> <!--codigo php usado para incluir el header sin necesidad del codigo-->
            
            <div class = "main_container" >
                <div class="item" id = "tabla-material">
                    <h3 class="text-center">Tabla Dinámica Materiales</h3>
                    <button type="button" class="boton-personalizado" onclick="location.href='registrar_materiales.php'">Registrar</button>
                    <div class="table-responsive table-hover" id="tablaconsulta">
                        <table class="styled-table">
                            <thead class="text-muted">
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Proveedor</th>
                                <th class="text-center">Precio</th>
                                <th class="text-center">Existencia</th>
                                <th class="text-center">Opciones</th>
                            </thead>
                            <tbody>
                                <?php
                                if($consulta){
                                    if(pg_num_rows($consulta) > 0){
                                        while($obj=pg_fetch_object($consulta)){?>
                                <tr>
                                    <td><?php echo $obj->nombre?></td>
                                    <td><?php echo $obj->proveedor?></td>
                                    <td><?php echo $obj->precio?></td>
                                    <td><?php echo $obj->existencia?></td>
                                    <td>
                                    <a class="texto_iconos" href="eliminar_material.php?id_materiales=<?php echo $obj->id_material;?>" onclick='return confirmacion()'>
                                    <i class="fa-solid fa-trash" id="iconos"></i>&nbsp;&nbsp;&nbsp;Borrar
                                        </a>
                                    </td>                    
                                </tr>
                                <?php } } }?>
                            </tbody>
                        </table>
                    </div>
                    <script src="../js/alerta_eliminar.js"></script>
                </div> <!-- Fin de item -->
            </div> <!-- Fin de main_container -->
        </div> <!-- Fin de la clase wrapper -->
    </body>
</html>