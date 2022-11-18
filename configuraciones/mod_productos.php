<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/styles.css"> <!--link al archivo css-->
        <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."metadata.html"); ?> 
        <title>Modificar Producto</title>
    </head>
    <body>
        
        <div class = "wrapper" id = "mod-ped">
            <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."header-nav.html"); ?> <!--codigo php usado para incluir el header sin necesidad del codigo-->
                    
            <div class = "main_container" >
                <div class="item" id = "mod-prod">
                    <div class = "form">
                        <!--La explixacion del archivo de pedidos podra explicar este, solo agregare mas comentarios en las partes que difieren:D-->
                        <?php 
                            error_reporting(0);
                            include_once '../configuraciones/conexion_bd.php'; //Incluimos la conexion a la base de datos
                            include_once '../configuraciones/obten_mod_prod.php'; //incluimos archivo que lee los datos ingresados a los campos de texto

                            //consultando la lista de Materiales para llenar el cuadro combinado
                            $rsM = pg_query($conexion, "SELECT * FROM material");
                                
                            $id = getId(); //obtenemos el id del producto a modificar

                            $rs = pg_query($conexion, "SELECT * FROM producto WHERE ID_PRODUCTO = $id"); //obtenemos el registro del producto a modificar

                            $n = pg_num_rows($rs); //verificamos que el registro exista, es decir, que no haya cero filas

                            if($n <= 0){ //si hay cero filas, decimos que no existe el registro, alert es funcion de javascript que enseña una ventana emergente
                                echo "<script>
                                        alert('No se encontró el producto, no puedes modificarlo');   
                                    </script>";
                                }
                            else
                                $producto = pg_fetch_array($rs); //si existe el registro, guardamos el valor de sus columnas en un arreglo
                                    
                                //Este if es para ver que boton ha presionado el usuario
                            if(isset($_POST['btnGenerico'])){ //todos los botones se llaman btnGenerico, por eso se verifica si se ha presionado alguno
                                $boton = $_POST['btnGenerico']; //guardamos el valor del boton presionado en una variable

                                if($boton == 'Modificar'){ //si se presiono el boton de modificar
                                    $id = getId(); //obtenemos el valor de todos los campos de texto con las funciones de obten_mod_prod.php
                                    $nombre = getNombre();
                                    $categoria = getCategoria();
                                    $precio = getPrecio();
                                    $existencia = getExistencia();

                                    //implementar la actualizacion de campos en el registro usando las variables
                                    $pg = "UPDATE producto SET NOMBRE = '$nombre', CATEGORIA = '$categoria', 
                                                                PRECIO = $precio, EXISTENCIA = $existencia 
                                            WHERE ID_PRODUCTO = $id";

                                        //ejecutacion de la sentencia de actualizacion
                                    $rpta = pg_query($conexion, $pg);

                                    if($rpta){ //si la actualizacion se realizo correctamente (da verdadero) o no mostramos ventana emergente
                                        echo "<script> 
                                                alert('Se actualizo el producto correctamente');
                                                history.back();
                                            </script>";
                                    }else{
                                        echo '<script> 
                                                alert("No se pudo actualizar el producto-'.pg_error().'");
                                                history.back(); 
                                            </script>';
                                    }

                                }

                                if($boton == 'Eliminar todos materiales existentes'){ //este boton elimina todos los materiales existentes
                                    echo "<script>
                                            alert('Un producto debe contener al menos un material, recuerda elegir los materiales que contendrá antes de finalizar');
                                        </script>";
                                    
                                    $pg_mat_elim = "DELETE FROM producto_hecho_con 
                                                    WHERE ID_PRODUCTO = $id";

                                    $rpta = pg_query($conexion, $pg_mat_elim);

                                    if($rpta){  //ventanas emergentes que avisan si se realizo la eliminacion o no
                                        echo "<script> 
                                                alert('Se eliminaron todos los materiales del producto correctamente');
                                            </script>";
                                    }else{
                                        echo '<script> 
                                                alert("No se pudo eliminar todos los materiales del producto-'.pg_error().'"); 
                                            </script>';
                                    }       
                                }

                                if($boton == 'Agregar material(es)'){ //este boton agrega los materiales seleccionados en el cuadro combinado
                                    $rpta = false; //para poder mostrar las ventanas, se debe guardar el bool aqui, empieza como falsa siempre
                                    if(!empty($_POST['selMaterial'])){ //verificamos que se haya seleccionado al menos un material (que no este vacio)
                                        foreach($_POST['selMaterial'] as $selected){ //recorremos el arreglo de los materiales seleccionados por ser seleccion multiple
                                            //agregar nuevos registros a producto_hecho_con
                                            //con el id_producto que se esta modificando
                                            //y los id_materiales que se seleccionaron
                                            $pg_mat_agr = "INSERT INTO producto_hecho_con 
                                                                VALUES ($id, $selected)";
                                            $rpta = pg_query($conexion, $pg_mat_agr);
                                        }
                                    }

                                    if($rpta){ //ventanas emergentes que avisan si se realizo la insercion o no
                                        echo "<script> 
                                                alert('Se agregaron los materiales al producto correctamente');
                                            </script>";
                                    }else{
                                        echo '<script> 
                                            alert("No se pudo agregar los materiales al producto-'.pg_error().'"); 
                                        </script>';
                                    }
                                }

                                if($boton == 'Eliminar material(es)'){ //este boton elimina los materiales seleccionados en el cuadro combinado
                                    $rpta = false;
                                    if(!empty($_POST['selMaterial'])){ //verificamos que se haya seleccionado al menos un material (que no este vacio)
                                        foreach($_POST['selMaterial'] as $selected){ //recorremos el arreglo de los materiales seleccionados por ser seleccion multiple
                                            //eliminar registros de producto_hecho_con
                                            //con el id_producto que se esta modificando
                                            //y los id_materiales que se seleccionaron
                                            $pg_mat_elim = "DELETE FROM producto_hecho_con 
                                                                WHERE ID_PRODUCTO = $id AND ID_MATERIAL = $selected"; //se debe eliminar el registro que tenga el id del producto y el id del material
                                            $rpta = pg_query($conexion, $pg_mat_elim);
                                        }
                                    }

                                    if($rpta){ //ventanas emergentes que avisan si se realizo la eliminacion o no
                                        echo "<script> 
                                                alert('Se eliminaron los materiales del producto correctamente, recuerda que un producto
                                                debe tener al menos un material');
                                            </script>";
                                    }else{
                                        echo '<script> 
                                                alert("No se pudo eliminar los materiales del producto-'.pg_error().'"); 
                                            </script>';
                                    }
                                }
                            }
                        ?>
                        <div>
                            <form  method = "post" autocomplete = "off" class = "insert-form">
                                <div class = "form-heading">
                                    <h1>Modificar Producto</h1>
                                    <h2>Id Producto: <?php echo getId(); ?></h2>
                                    <p>Modifica tú producto llenando los campos, por defecto vienen los valores originales dentro de los campos</p>
                                </div> <!--end from-heading-->
                                <!-- campo y boton id -->
                                <div class = "input-wrap">
                                    <input type = "text" class = "input-field active" autocomplete = "off" name = "txtNombre" value = "<?php echo $producto[1]; ?>"/>
                                    <label class = "label">Nombre</label>
                                </div> <!--end from-heading-->
                                    
                                <div class = "input-wrap">
                                    <input type = "text" class = "input-field active" autocomplete = "off" name = "txtCategoria" value = "<?php echo $producto[2]; ?>"/>
                                    <label class = "label">Categoria (H/M/O)</label> <!-- campo categoria -->
                                </div> <!--end from-heading-->
                                
                                <div class = "input-wrap">
                                    <input type = "text" class = "input-field active" autocomplete = "off" name = "numPrecio" value = "<?php echo $producto[3]; ?>"/>
                                    <label class = "label">Precio (ej: 0.00)</label> <!-- campo precio -->
                                </div> <!--end from-heading-->
                               
                                <div class = "input-wrap">
                                    <input type = "text" class = "input-field active" autocomplete = "off"  onfocus = "(this.type = 'number')" 
                                            onblur = "if(!this.value) this.type = 'text'" name = "numExistencia" value = "<?php echo $producto[4]; ?>"/>
                                    <label class = "label">Existencia</label> <!-- campo existencia -->
                                </div> <!--end from-heading-->       
                                <!--boton para modificar los campos del producto-->
                                <input type = "submit" name = "btnGenerico" value = "Modificar" class = "submit-btn"/>
                                        
                            </form> <!-- fin formulario de demas campos -->
                        </div> <!-- fin seccion modificar producto -->

                        <div> <!--seccion para modificar los materiales que lleva el producto-->
                            <form method = "post">
                                <div class = "form-heading">
                                    <p>Selecciona los materiales que contendrá después de registrar tú producto, puedes eliminar todos los materiales que tenia, o elegir los materiales a eliminar o agregar</p>
                                </div> <!--end from-heading-->
                                        
                                <input type = "submit" name = "btnGenerico" value = "Eliminar todos materiales existentes" class = "submit-btn" id = "bigger-select"/>

                                <!--select para mostrar los materiales que puede llevar producto-->
                                <select name = "selMaterial[]" multiple class = "select"> <!--multiple indica que se pueden seleccionar varios materiales-->
                                    <option disabled>Escoger material(es)</option>
                                        <?php 
                                            //recorriendo por todos los materiales que existen en la bd, rsM es el resultado de la consulta de arriba
                                            while($material = pg_fetch_array($rsM)){
                                                echo "<option value = '$material[0]'> $material[1] </option>"; //material[0] es el id (el valor) y material[1] es el nombre (que se muestra en la opcion)
                                            }      
                                        ?>
                                </select> <br> 

                                <!--boton para agregar los materiales seleccionados-->
                                <input type = "submit" name = "btnGenerico" value = "Agregar material(es)" class = "submit-btn" id = "select"/> 
                                
                                <!--boton para eliminar los materiales seleccionados-->
                                <input type = "submit" name = "btnGenerico" value = "Eliminar material(es)" class = "submit-btn" id = "select"/>
                                <button type="button" class = "atras" onclick="location.href='../secciones/vista_productos.php'">Atrás</button>          
                            </form> <!-- fin formulario de los materiales que puede llevar producto-->
                        </div> <!-- fin seccion para boton de regresar-->
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

