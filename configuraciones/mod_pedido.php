<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modificar Pedido</title>
    </head>
    <body>
        <header>
            <h3 class="text-center">Modificar Pedido</h3>
        </header>
        <section> <!-- Formulario para modificar pedido -->
            <?php 
                include_once '../configuraciones/conexion_bd.php'; //incluimos conexion a la base de datos
                include_once '../configuraciones/obten_mod_pedido.php'; //incluimos archivo para obtener dato ingresado en campos de texto

                //consultando la lista de Productos para llenar el cuadro combinado selProducto[]
                $rsP = pg_query($conexion, "SELECT * FROM producto");
                //consultamos la lista de Clientes para llenar el select de selCliente
                $id = $_GET['id_pedidos']; //obtenemos el id del pedido a modificar obtenido por vista_pedidos.php, en este no usamos el archivo mod_pedido.php
                
                $rsC = pg_query($conexion, "SELECT * FROM  cliente"); //consultamos la lista de Clientes para llenar el select de selCliente

                $rs = pg_query($conexion, "SELECT * FROM pedido WHERE ID_PEDIDO = $id"); //obtenemos los datos del pedido a modificar

                $n = pg_num_rows($rs); //contamos el numero de filas obtenidas con la consulta, debe ser 1

                if($n<=0){    //si no se encontro el pedido, hubo cero filas recuperadas, la query devolvio falso, hacemos una alerta con javascript
                    echo "<script> 
                            alert('No se encontró el pedido, no puedes modificarlo');   
                        </script>";
                    }
                else
                    $producto = pg_fetch_array($rs); //si hubo una fila, guardamos los valores del registro en un arreglo, esto sirve para llenar los campos automaticamente cuando se encuentra el pedido
                    
                //determina que codigo selecciono el usuario
                if(isset($_POST['btnGenerico'])){ //todos los botones se llaman btnGenerico
                    $boton = $_POST['btnGenerico']; //guardamos el valor del boton en una variable

                    if($boton == 'Modificar Pedido'){ //si el boton generico tiene el valor de MODIFICAR
                        $fecha_entr = getFechaEntr();  //obtenemos los valores de los campos de texto
                        $hora_entr = getHoraEntr(); 
                        $precio = getPrecio();
                        $punto_entr = getPuntoEntr();
                        $calle = getCalle();
                        $no_casa = getNoCasa();
                        $colonia = getColonia();
                        $estado = getEstado();
                        $pais = getPais();
                        $cod_pos = getCodPos();
                        $referencia = getRef();

                        //CAMBIAR EL ID_CLIENTE POR EL CLIENTE ELEGIDO EN pedido
                        if(!empty($_POST['selCliente'])){ //revisamos que se haya elegido algo
                                $selected = $_POST['selCliente']; //guardamos el id del cliente que escogio
                                //ajustaremos el id_cliente en pedido para que sea el mismo que el 
                                //elegido, pero no eliminaremos al cliente de la base de datos
                                $pg_cliente_up = "UPDATE pedido
                                                SET ID_CLIENTE = $selected
                                                WHERE ID_PEDIDO = $id";

                                $rpta = pg_query($conexion, $pg_cliente_up); //mandamos a llamar la query
                            }

                        //implementar la actualizacion de campos en el registro
                        $pg = "UPDATE pedido SET PRECIO = $precio, FECHA_ENTREGA = '$fecha_entr', HORA_ENTREGA = '$hora_entr',
                                                 PUNTO_ENTREGA = '$punto_entr', CALLE = '$calle', NO_CASA = '$no_casa', 
                                                 COLONIA = '$colonia', ESTADO = '$estado', PAIS = '$pais', CODIGO_POSTAL = '$cod_pos',
                                                 REFERENCIA = '$referencia'
                                WHERE ID_PEDIDO = $id";
                                

                        //ejecutacion de la sentencia de actualizacion
                        $rpta = pg_query($conexion, $pg);

                        if($rpta){ //si se pudo actualizar mandamos una alerta, y si no, tambien
                            echo "<script> 
                                    alert('Se actualizo el pedido correctamente');
                                    history.back();
                                </script>";
                        }else{
                            echo '<script> 
                                    alert("No se pudo actualizar el pedido-'.pg_error().'");
                                    history.back(); 
                                </script>';
                        }

                    }

                    if($boton == 'Eliminar todos productos existentes'){ //este boton elimina todos los productos que contien el pedido, esto hace que ya no salga en la tabla
                        //eliminar todos los productos en pedido_contiene 
                        //con el id_edido que se esta modificando
                        $pg_prod_elim = "DELETE FROM pedido_contiene 
                                        WHERE ID_PEDIDO = $id";

                        $rpta = pg_query($conexion, $pg_prod_elim);

                        if($rpta){ //si se pudo actualizar mandamos una alerta, y si no, tambien
                            echo "<script> 
                                    alert('Se eliminaron los productos existentes del pedido correctamente');    
                                </script>";
                        } else {
                            echo '<script> 
                                    alert("No se pudo eliminar los productos del pedido-'.pg_error().'");
                                </script>';
                        }
                    }

                    if($boton == 'Agregar Producto'){ //este boton agrega un producto al pedido
                        $sel_product = $_POST['selProducto']; //guardamos el id del cliente que escogio
                        $cantidad = getCantidad(); //guardamos la cantidad del producto que escogio
                                //ajustaremos el id_cliente en pedido para que sea el mismo que el 
                                //elegido, pero no eliminaremos al cliente de la base de datos
                        $pg_prod_agr = "INSERT INTO pedido_contiene
                                        VALUES ($id, $sel_product, $cantidad)";

                        $rpta = pg_query($conexion, $pg_prod_agr);

                        if($rpta){ //si se pudo actualizar mandamos una alerta, y si no, tambien
                            echo "<script> 
                                    alert('Se agrego el producto al pedido correctamente');    
                                </script>";
                        } else {
                            echo '<script> 
                                    alert("No se pudo agregar el producto al pedido-'.pg_error().'");
                                </script>';
                        }
                    }

                    if($boton == 'Eliminar Producto'){ //este boton elimina un producto del pedido
                        $sel_product = $_POST['selProducto']; //guardamos el id del cliente que escogio
                        $pg_prod_elim = "DELETE FROM pedido_contiene 
                                        WHERE ID_PEDIDO = $id AND ID_PRODUCTO = $sel_product";

                        $rpta = pg_query($conexion, $pg_prod_elim);

                        if($rpta){
                            echo "<script> 
                                    alert('Se elimino el producto del pedido correctamente');    
                                </script>";
                        } else {
                            echo '<script> 
                                    alert("No se pudo eliminar el producto del pedido-'.pg_error().'");
                                </script>';
                        }
                    }
                }
            ?>

            <form  method = "post"> <!-- formulario para modificar el pedido -->
                <!-- campo y boton id -->
                <table border = "0" width = "550" cellspacing = "1" cellpadding = "10"> <!-- tabla para los campos -->
                    <tr>
                        <td>
                            <b>Id Pedido: <?php echo $id; ?></b> <!--en cada campo de texto pondremos el valor del campo correspondiente-->
                        </td>                                       <!--para que puedan ver los valores originales-->
                    </tr>
                </table>
                <!-- campo y boton de demas campos -->
                <table border = "0" width = "550" cellspacing = "1" cellpadding = "6">
                    <tr> <!--FILA: Datos del pedido-->
                        <td> Fecha de Entrega </td> <!--Fecha de Entrega-->
                        <td>
                            <input type = "date" name = "txtFecha" value = "<?php echo $producto[2]; ?>"/>
                        </td>

                        <td> Hora de Entrega </td> <!--Hora de Entrega-->
                        <td>
                            <input type = "time" name = "txtHora" value = "<?php echo $producto[3]; ?>"/>
                        </td>
                    
                        <td> Precio </td> <!--Precio-->
                        <td>
                            <input type = "number" name = "numPrecio" step = "0.01" value = "<?php echo $producto[4]; ?>"/> <!-- Step 0.01 hace que puedas escoger2 decimales-->
                        </td>
                    </tr>
                    <tr> <!--SEPRADOR FILA: Datos de cliente-->
                        <td colspan = "2">
                            <b> Datos del Cliente </b>
                        </td>
                    </tr>

                    <tr> <!--FILA: Select Cliente-->
                        <td>Cliente</td> 
                        <td>
                            <select name = "selCliente"> <!--el elemento select nos permite crear Cuadros combinados, este no tiene atributo multiple pq solo podra escoger un cliente-->
                                <option>Escoger cliente</option> <!--la primera opcion del cuadro combinado es una indicacion-->
                                <?php 
                                    //recorriendo por todos los clientes para llenar el cuadro de seleccion, solo recorre si existen registros de cliente en tabla cliente
                                    while($cliente = pg_fetch_array($rsC)){  //$rsC es el resultado de la consulta de todos los clientes
                                        echo "<option value = '$cliente[0]'> $cliente[1] $cliente[2] $cliente[3] </option>"; //cliente[0] es el id (el valor) y cliente[1] es el nombre (que se muestra en la opcion)
                                                            //ID_CLIENTE   //Nombre, primer apellido, segundo apellido
                                    }      
                                ?>
                            </select>
                        </td>
                    </tr>
                    
                    <tr> <!--FILA Separador: Datos de la entrega-->
                        <td colspan = "2"> <b>Datos de Entrega</b> </td>
                        <!--colspan = "2" hace que la celda ocupe 2 columnas-->
                    </tr>
                
                    <tr>  <!--FILA: Datos de entrega-->
                        <td>Punto de Entrega </td> <!--Punto de Entrada-->
                        <td> <!--size en input indica que tan grande es el cuadro de texto-->
                            <input type = "text" name = "txtPuntoEntr"  size = "10" value = "<?php echo $producto[5]; ?>"/>
                        </td>

                        <td>Calle</td> <!--Calle-->
                        <td>
                            <input type = "text" name = "txtCalle" size = "30" value = "<?php echo $producto[6]; ?>"/>
                        </td>

                        <td>No. Casa</td> <!--No. Casa-->
                        <td>
                            <input type = "text" name = "txtNoCasa" size = "5" value = "<?php echo $producto[7]; ?>"/>
                        </td>
                    </tr>

                    <tr> 
                        <td>Colonia </td> <!--Colonia-->
                        <td>
                            <input type = "text" name = "txtColonia"  size = "25" value = "<?php echo $producto[8]; ?>"/>
                        </td>

                        <td>Estado</td> <!--Estado-->
                        <td>
                            <input type = "text" name = "txtEstado" size = "25" value = "<?php echo $producto[9]; ?>"/>
                        </td>

                        <td>País</td> <!--Pais-->
                        <td>
                            <input type = "text" name = "txtPais" size = "25" value = "<?php echo $producto[10]; ?>"/>
                        </td>
                    </tr>
                    

                    <tr> <!--FILA: Tercera fila de datos de entrega-->
                        <td>Codigo Postal </td> <!--Codigo Postal-->
                        <td>
                            <input type = "text" name = "txtCodPos"  size = "25" value = "<?php echo $producto[11]; ?>"/>
                        </td>

                        <td>Referencia</td> <!--Referencia-->
                        <td>
                            <input type = "text" name = "txtReferencia" size = "30" value = "<?php echo $producto[12]; ?>"/>
                        </td>
                        <td> <!--boton para modificar datos generales-->
                            <input type = "submit" name = "btnGenerico"
                                    value = "Modificar Pedido"/>
                        </td>
                    </tr>
                </table> <!--fin de la tabla-->
            </form> <!--fin del formulario-->
        </section> <!--fin de la seccion para modificar campos-->

        <section> <!--seccion para modificar y elegir productos del pedido-->
            <br> 
            <form method = "POST">
                <table border = "0" width = "550" cellspacing = "1" cellpadding = "10">
                    <tr> <!--FILA Separador: Productos que lleva el pedido -->
                        <td colspan = "2">
                            <b>Escoger productos del pedido</b>
                        </td>
                    </tr>

                    <tr>
                        <td> <!--boton para eliminar todos los productos existentes-->
                            <input type = "submit" name = "btnGenerico" value = "Eliminar todos productos existentes"/> 
                        </td>
                    </tr>
                        
                    <tr> <!--FILA: Productos que lleva el pedido -->
                        <td>Elegir producto</td> <!--Hare un multiselect que permita escoger los productos que lleva el pedido-->
                        <td>
                            <select name = "selProducto"> <!--se le debe poner corchetes al nombre y atributo multiple para indicar que gurdara un arreglo de selecciones-->
                                <option>Escoger producto</option> <!--la primera opcion solo da indicaciones-->
                                <?php 
                                    //recorriendo por todos los materiales, $rsP es el resultado de la consulta de todos los productos
                                    while($producto = pg_fetch_array($rsP)){ //primero obtenemos todos los registros uno por uno guardando sus valores en un arreglo,y recorre siempre y cuando no este vacio
                                        echo "<option value = '$producto[0]'> $producto[1] </option>"; //material[0] es el id (el valor) y material[1] es el nombre (que se muestra en la opcion)
                                    }   //se ponen esos valores en cada una de las opciones  
                                ?>
                            </select>
                        </td>

                        <td>Cantidad</td> <!--Campo para ingresar cantidad de producto-->
                        <td>
                            <input type="number" name="numCantidad">
                        </td>

                        <td> <!--boton para agregar producto-->
                            <input type = "submit" name = "btnGenerico" value = "Agregar Producto"/>  
                        </td>   
                        
                        <td> <!--boton para eliminar producto-->
                            <input type = "submit" name = "btnGenerico" value = "Eliminar Producto"/>
                        </td>
                    </tr>
                </table> <!--fin de la tabla para modificar productos-->
            </form> <!--fin del formulario para modificar productos-->
        </section> <!--fin de la seccion para modificar productos-->
        
        <section> 
            <br>
            <!--boton para regresar a la vista de pedidos-->
            <a id = "Regresar" href= "../secciones/vista_pedidos.php" >
                <button class = "button">Regresar</button>
            </a> 
        </section>
    </body>
</html>

