<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
</head>
<body>
    <header>
        <h3 class="text-center">Modificar Producto</h3>
    </header>
    <!--La explixacion del archivo de pedidos podra explicar este, solo agregare mas comentarios en las partes que difieren:D-->
    <section> <!--esta seccion contiene el formulario para modificar los datos del producto-->
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
                                alert('Se eliminaron los materiales del producto correctamente');
                            </script>";
                    }else{
                        echo '<script> 
                                alert("No se pudo eliminar los materiales del producto-'.pg_error().'"); 
                            </script>';
                    }
                }
            }
        ?>

        <form  method = "post">
            <!-- campo y boton id -->
            <table border = "0" width = "550" cellspacing = "1" cellpadding = "10"> <!-- tabla mostrar el id del producto-->
                <tr>
                    <td>
                        <b>Id Producto: <?php echo getId(); ?></b>
                    </td>
                </tr>
            </table>
            <br>
             <!-- campo y boton de demas campos -->
            <table border = "0" width = "550" cellspacing = "1" cellpadding = "1"> <!-- tabla mostrar los demas campos del producto-->
                <tr> <!-- fila -->
                    <td>Nombre</td> <!-- campo nombre -->
                    <td colspan = "3"> <!--colspan indica que ocupa 3 columnas-->
                        <input type = "text" name = "txtNombre" size = "70" value = "<?php echo $producto[1]; ?>"/>
                    </td>
                </tr>

                <tr>
                    <td>Categoria</td> <!-- campo categoria -->
                    <td>
                        <input type = "text" name = "txtCategoria" value = "<?php echo $producto[2]; ?>"/>
                    </td>
                    <td>Precio</td> <!-- campo precio -->
                    <td>
                        <input type = "number" name = "numPrecio" step = "0.01" value = "<?php echo $producto[3]; ?>"/>
                    </td>
                </tr>

                <tr>
                    <td>Existencia</td> <!-- campo existencia -->
                    <td>
                        <input type = "number" name = "numExistencia" value = "<?php echo $producto[4]; ?>"/>
                    </td>
                    
                    <td colspan = "4"> <!--boton para modificar los campos del producto-->
                        <input type = "submit" name = "btnGenerico"
                                value = "Modificar"/>
                    </td>
                </tr>
            </table> <!-- fin tabla mostrar los demas campos del producto-->
        </form> <!-- fin formulario de demas campos -->
    </section> <!-- fin seccion modificar producto -->

    <section> <!--seccion para modificar los materiales que lleva el producto-->
    <br>
        <form method = "post">
            <table border = "0" width = "550" cellspacing = "1" cellpadding = "10">
                <tr> <!--Separador para indicar que se modificaran los materiales-->
                    <td colspan = "2">
                        <b>Modificar Materiales</b>
                    </td>
                </tr>

                <tr> <!--fila para mostrar los materiales que puede llevar producto-->
                    <td>
                        <input type = "submit" name = "btnGenerico" value = "Eliminar todos materiales existentes"/>
                    </td>
                </tr>

                <tr> <!--select para mostrar los materiales que puede llevar producto-->
                    <td>Escoger materiales</td>
                    <td>
                        <select name = "selMaterial[]" multiple> <!--multiple indica que se pueden seleccionar varios materiales-->
                            <option>Escoger material(es)</option>
                            <?php 
                                //recorriendo por todos los materiales que existen en la bd, rsM es el resultado de la consulta de arriba
                                while($material = pg_fetch_array($rsM)){
                                     echo "<option value = '$material[0]'> $material[1] </option>"; //material[0] es el id (el valor) y material[1] es el nombre (que se muestra en la opcion)
                                }      
                            ?>
                        </select>
                    </td>

                    <td> <!--boton para agregar los materiales seleccionados-->
                        <input type = "submit" name = "btnGenerico" value = "Agregar material(es)"/> 
                    </td>

                    <td> <!--boton para eliminar los materiales seleccionados-->
                        <input type = "submit" name = "btnGenerico" value = "Eliminar material(es)"/>
                    </td>
                </tr>
            </table> <!-- fin tabla mostrar los materiales que puede llevar producto-->
        </form> <!-- fin formulario de los materiales que puede llevar producto-->
    </section> <!-- fin seccion modificar los materiales que lleva el producto-->

    <section> <!--seccion para boton de regresar-->
        <br>
        <a id = "Regresar" href= "../secciones/vista_productos.php" >
            <button class = "button">Regresar</button>
        </a> 
    </section>
</body>

</html>

