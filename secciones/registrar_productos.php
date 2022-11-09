<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/styles.css"> <!--link al archivo css-->
        <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."metadata.html"); ?> 
        <title>Registar Producto</title>
    </head>

    <body>
        <div class = "wrapper" id = "reg-prod">
            <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."header-nav.html"); ?> <!--codigo php usado para incluir el header sin necesidad del codigo-->
                    
                <div class = "main_container" >
                    <div class="item" id = "reg-prod">
                        <header>
                            <h2 class="text-center">Registrar Producto</h2>
                        </header>
                        <section>
                            <?php
                                error_reporting(0);
                                include_once "../configuraciones/conexion_bd.php";

                                $rsM = pg_query($conexion, "SELECT * FROM material");
                                $rsP = pg_query($conexion,"SELECT MAX(id_producto) FROM producto");
                                $id = pg_fetch_object($rsP);
                                    $boton = $_POST['registro'];
                                    if($boton=="Registrar producto")
                                    {
                                        $query=("INSERT INTO producto(nombre,categoria,precio,existencia)
                                                VALUES('$_REQUEST[nombre]','$_REQUEST[categoria]',
                                                '$_REQUEST[precio]','$_REQUEST[existencia]')");
                                        $consulta=pg_query($conexion,$query);
                                        if($consulta)
                                        {
                                            echo "<script> 
                                                    alert('El producto se registro correctamente');
                                                    history.back();
                                                </script>";
                                        }else{
                                            echo "<script> 
                                                    alert('No se pudo registrar el producto');
                                                    history.back();
                                                </script>";
                                        }
                                    }
                                    
                                    if($boton == 'Registrar material del producto'){
                                        foreach($_POST['selMaterial'] as $selected){
                                            $pg_mat_agr = "INSERT INTO producto_hecho_con 
                                                            VALUES ($id->max, $selected)";
                                            $consulta_mat=pg_query($conexion,$pg_mat_agr);
                                            }
                                        if($consulta_mat)
                                        {
                                            echo "<script> 
                                                    alert('El material se registro correctamente en el producto');
                                                    history.back();
                                                </script>";
                    
                                        }else{
                                            echo "<script> 
                                                    alert('No se a ingresado nuevo producto');
                                                    history.back();
                                                </script>";
                                        }

                                    }
                            ?>
                                <form method="POST">
                                    <label for="nombre"><b>Nombre: </b></label>
                                    <input type="text" name="nombre">
                                    <label for="  nombre"><b>Categoria: </b></label>
                                    <input type="text" name="categoria"><br><br>
                                    <label for="nombre"><b>Precio: </b></label>
                                    <input type="text" name="precio">
                                    <label for="nombre"><b>Existencia: </b></label>
                                    <input type="text" name="existencia"><br><br>
                                    <input type="submit" name = "registro" value="Registrar producto">
                                </form><br>    
                        </section>
                        <section>
                            <h2>Registrar material del producto</h2>
                                <form method="POST">
                                    <select name = "selMaterial[]" multiple>
                                            <option>Escoger material(es)</option>
                                            <?php 
                                                //recorriendo por todos los materiales
                                                while($material = pg_fetch_array($rsM)){
                                                    echo "<option value = '$material[0]'> $material[1] </option>"; //material[0] es el id (el valor) y material[1] es el nombre (que se muestra en la opcion)
                                                }      
                                            ?>
                                    </select><br>
                                <br><input type="submit" name = "registro" value="Registrar material del producto">
                            </form>
                        </section>
                        <br><button type="button" onclick="location.href='vista_productos.php'">Atras</button>
                    </div> <!-- Fin de item -->
                </div> <!-- Fin de main_container -->
        </div> <!-- Fin de la clase wrapper -->                       
    </body>
</html>