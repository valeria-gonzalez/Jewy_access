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
                    <div class="item" id = "form-prod">
                        <div class = "form">
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
                                                    alert('El producto se registro correctamente, recuerda que un producto debe llevar al menos un material');
                                                    history.back();
                                                </script>";
                                        }else{
                                            echo "<script> 
                                                    alert('No se pudo registrar el producto');
                                                    history.back();
                                                </script>";
                                        }
                                    }
                                    
                                    if($boton == 'Elegir materiales'){
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
                            <div>
                                <form method="POST" autocomplete = "off" class = "insert-form">
                                    <div class = "form-heading">
                                            <h1>Registrar Producto</h1>
                                            <p>Ingresa un nuevo producto llenando los campos y dale a registrar</p>
                                    </div> <!--end from-heading-->

                                    <div class = "input-wrap">
                                        <input type="text" name="nombre" class = "input-field" autocomplete = "off" required>
                                        <label class = "label"> Nombre<span>*</span></label>
                                    </div> <!--end input-wrap nombre-->

                                    <div class = "input-wrap">
                                        <input type="text" name="categoria" class = "input-field" autocomplete = "off" required>
                                        <label class = "label">Categoria (H/M/O)<span>*</span></label>
                                    </div> <!--end input-wrap categoria-->

                                    <div class = "input-wrap">
                                        <input type="text" name="precio" class = "input-field" autocomplete = "off" required>
                                        <label class = "label">Precio (ej: 0.00)<span>*</span></label>
                                    </div> <!--end input-wrap precio-->

                                    <div class = "input-wrap">
                                        <input type="text" name="existencia" onfocus = "(this.type = 'number')" 
                                            onblur = "if(!this.value) this.type = 'text'" class = "input-field" autocomplete = "off" required>
                                        <label class = "label">Existencia<span>*</span></label>
                                    </div> <!--end input-wrap existencia-->

                                    <input type="submit" name = "registro" value="Registrar producto" class = "submit-btn">
                                </form> 
                            </div> <!--end div que contiene el form para ingresar producto-->
                            <div>
                                <form method="POST">
                                    <div class = "form-heading">
                                        <p>Selecciona los materiales que contendrá después de registrar tú producto<span>*</span></p>
                                    </div> <!--end from-heading-->
                                        
                                    <select name = "selMaterial[]" multiple class = "select" required>
                                        <option disabled>Escoger material(es)</option>
                                        <?php 
                                            //recorriendo por todos los materiales
                                            while($material = pg_fetch_array($rsM)){
                                                echo "<option value = '$material[0]'> $material[1] </option>"; //material[0] es el id (el valor) y material[1] es el nombre (que se muestra en la opcion)
                                            }      
                                        ?>
                                    </select> 
                                    <input type="submit" name = "registro" value="Elegir materiales" class = "submit-btn" id = "select"> <br>
                                    <button type="button" class = "atras" onclick="location.href='vista_productos.php'">Atrás</button>
                                </form>
                            </div> <!--end div que contiene el select para elegir materiales-->
                        </div> <!--end form-->
                            
                        <div class = "form-img">
                            <div class = "illustration">
                                <img src = "../src/icon-mat.png" alt = "form illustration" />
                            </div>  <!--end illustration-->
                        </div> <!--end form-img-->
                    </div> <!-- Fin de item -->
                </div> <!-- Fin de main_container -->
        </div> <!-- Fin de la clase wrapper -->  
        <script src="../js/labels.js"></script> <!--link al archivo js-->                     
    </body>
</html>