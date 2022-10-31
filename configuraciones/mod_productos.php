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
    <section>
        <?php 
            error_reporting(0);
            include_once '../configuraciones/conexion_bd.php';
            include_once '../configuraciones/obten_mod_prod.php';

            //consultando la lista de Materiales para llenar el cuadro combinado
            $rsM = pg_query($conexion, "SELECT * FROM material");
            $id = getId();
            
            //determina que codigo selecciono el usuario
            if(isset($_POST['btnGenerico'])){
                $boton = $_POST['btnGenerico'];

                if($boton == 'Buscar'){
                    $rs = pg_query($conexion, "SELECT * FROM producto WHERE ID_PRODUCTO = $id");
                    $n = pg_num_rows($rs);
                    if($n == 0){
                        echo "<script>
                                alert('No se encontró el producto, no puedes modificarlo');   
                            </script>";
                    }
                    $producto = pg_fetch_array($rs);
                    
                }

                if($boton == 'Modificar'){
                    $id = getId();
                    $nombre = getNombre();
                    $categoria = getCategoria();
                    $precio = getPrecio();
                    $existencia = getExistencia();

                    if(!empty($_POST['selMaterial'])){
                        //eliminar todos los materiales en producto_hecho_con 
                        //con el id_producto que se esta modificando
                        $pg_mat_elim = "DELETE FROM producto_hecho_con 
                                        WHERE ID_PRODUCTO = $id";

                        $rpta = pg_query($conexion, $pg_mat_elim);
                        foreach($_POST['selMaterial'] as $selected){
                            //agregar nuevos registros a producto_hecho_con
                            //con el id_producto que se esta modificando
                            //y los id_materiales que se seleccionaron
                            $pg_mat_agr = "INSERT INTO producto_hecho_con 
                                            VALUES ($id, $selected)";
                            $rpta = pg_query($conexion, $pg_mat_agr);
                        }
                    }


                    //implementar la actualizacion de campos en el registro
                    $pg = "UPDATE producto SET NOMBRE = '$nombre', CATEGORIA = '$categoria', 
                                               PRECIO = $precio, EXISTENCIA = $existencia 
                            WHERE ID_PRODUCTO = $id";

                    //ejecutacion de la sentencia de actualizacion
                    $rpta = pg_query($conexion, $pg);

                    if($rpta){
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
            }
        ?>

        <form  method = "post">
            
            <!-- campo y boton id -->
            <table border = "0" width = "550" cellspacing = "1" cellpadding = "10">
                <tr>
                    <td>Id</td>
                    <td><input type = "number" name = "numId" value = "<?php echo getId(); ?>"/></td>
                    <td><input type = "submit" name = "btnGenerico" value = "Buscar"/></td>
                </tr>
            </table>
            <br>
             <!-- campo y boton de demas campos -->
            <table border = "0" width = "550" cellspacing = "1" cellpadding = "1">
                <tr>
                    <td>Nombre</td>
                    <td colspan = "3">
                        <input type = "text" name = "txtNombre" size = "70" value = "<?php echo $producto[1]; ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>Categoria</td>
                    <td>
                        <input type = "text" name = "txtCategoria" value = "<?php echo $producto[2]; ?>"/>
                    </td>
                    <td>Precio</td>
                    <td>
                        <input type = "number" name = "numPrecio" step = "0.01" value = "<?php echo $producto[3]; ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>Existencia</td>
                    <td>
                        <input type = "number" name = "numExistencia" value = "<?php echo $producto[4]; ?>"/>
                    </td>
                    <td>Materiales</td>
                    <td>
                        <select name = "selMaterial[]" multiple>
                            <option>Escoger material(es)</option>
                            <?php 
                                //recorriendo por todos los materiales
                                while($material = pg_fetch_array($rsM)){
                                    echo "<option value = '$material[0]'> $material[1] </option>"; //material[0] es el id (el valor) y material[1] es el nombre (que se muestra en la opcion)
                                }      
                            ?>
                        </select>
                    </td>
                    <td colspan = "4">
                        <input type = "submit" name = "btnGenerico"
                                value = "Modificar"/>
                    </td>
                </tr>
            </table>
        </form>
        <a id = "Regresar" href= "../secciones/vista_productos.php" >
            <button class = "button">Regresar</button>
        </a> 

    </section>
</body>
</html>

