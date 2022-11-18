<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/styles.css"> <!--link al archivo css-->
        <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."metadata.html"); ?> 
        <title>Modificar Pedido</title>
    </head>

    <body>
        <div class = "wrapper" id = "mod-ped">
            <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."header-nav.html"); ?> <!--codigo php usado para incluir el header sin necesidad del codigo-->
                    
            <div class = "main_container" >
                <div class="item" id = "mod-ped">
                    <div class = "form">  
                     <!-- Formulario para modificar pedido -->
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
                                    echo "<script>
                                            alert('Un pedido debe contener al menos un producto, recuerda elegir los productos que contendrá antes de finalizar');
                                        </script>";
                                    
                                    $pg_prod_elim = "DELETE FROM pedido_contiene 
                                                    WHERE ID_PEDIDO = $id";

                                    $rpta = pg_query($conexion, $pg_prod_elim);

                                    if($rpta){ //si se pudo actualizar mandamos una alerta, y si no, tambien
                                        echo "<script> 
                                                alert('Se eliminaron todos los productos del pedido correctamente');    
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
                                                alert('Se agrego el producto al pedido correctamente, recuerda que un pedido debe tener al menos un producto');    
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
                                                alert('Se elimino el producto del pedido correctamente, recuerda que un pedido
                                                        debe tener al menos un producto');    
                                            </script>";
                                    } else {
                                        echo '<script> 
                                                alert("No se pudo eliminar el producto del pedido-'.pg_error().'");
                                            </script>';
                                    }
                                }
                            }
                        ?>
                        <div>
                            <form  method = "post" autocomplete = "off" class = "insert-form"> <!-- formulario para modificar el pedido -->
                                <div class = "form-heading">
                                    <h1>Modificar Pedido</h1>
                                    <h2>Id Pedido: <?php echo $id; ?></h2>
                                    <p>Modifica tú pedido llenando los campos, por defecto vienen los valores originales dentro de los campos</p><br>
                                </div> <!--end from-heading-->
                                <!--FILA: Datos del pedido-->
                                <div class = "input-wrap">
                                    <input type = "text" name = "txtFecha" class = "input-field active" autocomplete = "off"
                                            onfocus = "(this.type = 'date')" onblur = "if(!this.value) this.type = 'text'" value = "<?php echo $producto[2]; ?>"/>
                                    <label class = "label">Fecha de Entrega</label> <!--Fecha de Entrega-->
                                </div> <!--end input-wrap-->

                                <div class = "input-wrap">
                                    <input type = "time" name = "txtHora" class = "input-field active" autocomplete = "off"
                                            onfocus = "(this.type = 'time')" onblur = "if(!this.value) this.type = 'text'"value = "<?php echo $producto[3]; ?>"/>
                                    <label class = "label">Hora de Entrega</label> <!--Hora de Entrega-->
                                </div> <!--end input-wrap-->
                                
                                <div class = "input-wrap">
                                    <input type = "text" class = "input-field active" autocomplete = "off" name = "numPrecio" value = "<?php echo $producto[4]; ?>"/> <!-- Step 0.01 hace que puedas escoger2 decimales-->
                                    <label class = "label">Precio (ej: 0.00)</label> <!--Precio-->
                                </div> <!--end input-wrap-->
                                    
                                <div class = "form-heading">
                                    <p>Puedes modificar el cliente que ha realizado el pedido, es necesario tener al cliente registrado antes de asignarle un pedido</p>
                                </div> <!--end from-heading-->
                                    
                                <select name = "selCliente" class = "select"> <!--el elemento select nos permite crear Cuadros combinados, este no tiene atributo multiple pq solo podra escoger un cliente-->
                                    <option disabled>Escoger cliente</option> <!--la primera opcion del cuadro combinado es una indicacion-->
                                        <?php 
                                            //recorriendo por todos los clientes para llenar el cuadro de seleccion, solo recorre si existen registros de cliente en tabla cliente
                                            while($cliente = pg_fetch_array($rsC)){  //$rsC es el resultado de la consulta de todos los clientes
                                                echo "<option value = '$cliente[0]'> $cliente[1] $cliente[2] $cliente[3] </option>"; //cliente[0] es el id (el valor) y cliente[1] es el nombre (que se muestra en la opcion)
                                                                        //ID_CLIENTE   //Nombre, primer apellido, segundo apellido
                                                }      
                                            ?>
                                </select>
                                        
                                <div class = "form-heading">
                                    <br><p>Modifica los datos relacionados al punto de entrega llenando los campos</p>
                                </div> <!--end from-heading-->
                                    
                                <div class = "input-wrap">   
                                    <input type = "text" name = "txtPuntoEntr" class = "input-field active" autocomplete = "off" value = "<?php echo $producto[5]; ?>"/>
                                    <label class = "label">Punto de Entrega</label> <!--Punto de Entrada-->
                                </div> <!--end input-wrap-->

                                <div class = "input-wrap">
                                    <input type = "text" name = "txtCalle" class = "input-field active" autocomplete = "off" value = "<?php echo $producto[6]; ?>"/>
                                    <label class = "label">Calle</label> <!--Calle-->
                                </div> <!--end input-wrap-->

                                <div class = "input-wrap">
                                    <input type = "text" name = "txtNoCasa" class = "input-field active" autocomplete = "off" value = "<?php echo $producto[7]; ?>"/>
                                    <label class = "label">No. Casa</label> <!--No. Casa-->
                                </div> <!--end input-wrap-->    
                                
                                <div class = "input-wrap">
                                    <input type = "text" name = "txtColonia" class = "input-field active" autocomplete = "off" value = "<?php echo $producto[8]; ?>"/>
                                    <label class = "label">Colonia</label> <!--Colonia-->
                                </div> <!--end input-wrap-->
                                
                                <div class = "input-wrap">
                                    <input type = "text" name = "txtEstado" class = "input-field active" autocomplete = "off" value = "<?php echo $producto[9]; ?>"/>
                                    <label class = "label">Estado</label> <!--Estado-->
                                </div> <!--end input-wrap-->

                                <div class = "input-wrap">
                                    <input type = "text"  name = "txtPais" class = "input-field active" autocomplete = "off" value = "<?php echo $producto[10]; ?>"/>
                                    <label class = "label">Pais</label> <!--Pais-->
                                </div> <!--end input-wrap-->
                                
                                <div class = "input-wrap">
                                    <input type = "text" name = "txtCodPos" class = "input-field active" autocomplete = "off" value = "<?php echo $producto[11]; ?>"/>
                                    <label class = "label">Codigo Postal</label> <!--Codigo Postal-->
                                </div> <!--end input-wrap-->

                                <div class = "input-wrap">
                                    <input type = "text" name = "txtReferencia" class = "input-field active" autocomplete = "off" value = "<?php echo $producto[12]; ?>"/>
                                    <label class = "label">Referencia</label> <!--Referencia-->
                                </div> <!--end input-wrap-->
                                    <!--boton para modificar datos generales-->
                                <input type = "submit" name = "btnGenerico" value = "Modificar Pedido" class = "submit-btn"/>

                            </form> <!--fin del formulario-->
                        </div> <!--fin de la seccion para modificar campos-->

                        <div> <!--seccion para modificar y elegir productos del pedido--> 
                            <form method = "POST">
                                <div class = "form-heading">
                                    <p>Después de modificar tú pedido, puedes modificar los materiales que contiene, puedes eliminar todos los productos que tenía o elegir uno a uno el producto a eliminar/agregar (con su cantidad)</p>
                                </div> <!--end from-heading-->
                                
                                <!--boton para eliminar todos los productos existentes-->
                                <input type = "submit" name = "btnGenerico" value = "Eliminar todos productos existentes" class = "submit-btn" id = "bigger-select"/> 
                                        
                                <!--FILA: Productos que lleva el pedido -->
                                <select name = "selProducto" class = "select"> <!--se le debe poner corchetes al nombre y atributo multiple para indicar que gurdara un arreglo de selecciones-->
                                    <option disabled>Escoger producto</option> <!--la primera opcion solo da indicaciones-->
                                        <?php 
                                            //recorriendo por todos los materiales, $rsP es el resultado de la consulta de todos los productos
                                            while($producto = pg_fetch_array($rsP)){ //primero obtenemos todos los registros uno por uno guardando sus valores en un arreglo,y recorre siempre y cuando no este vacio
                                                echo "<option value = '$producto[0]'> $producto[1] </option>"; //material[0] es el id (el valor) y material[1] es el nombre (que se muestra en la opcion)
                                            }   //se ponen esos valores en cada una de las opciones  
                                        ?>
                                </select>
                                
                                <br><br>
                                <label>Cantidad <span>*</span></label> <!--Campo para ingresar cantidad de producto-->
                                <input type="number" name="numCantidad"><br><br>

                                <!--boton para agregar producto-->
                                <input type = "submit" name = "btnGenerico" value = "Agregar Producto" class = "submit-btn" id = "select"/>  
                                
                                <!--boton para eliminar producto-->
                                <input type = "submit" name = "btnGenerico" value = "Eliminar Producto" class = "submit-btn" id = "select"/>
                                
                                <!--boton para regresar a la vista de pedidos-->
                                <button type="button" class = "atras" onclick="location.href='../secciones/vista_pedidos.php'">Atras</button>
                            </form> <!--fin del formulario para modificar productos-->
                        </div> <!--fin de la seccion para modificar productos-->
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

