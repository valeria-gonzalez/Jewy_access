<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/styles.css"> <!--link al archivo css-->
        <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."metadata.html"); ?> 
        <title>Registrar Pedido</title>
    </head>

    <body>
        <div class = "wrapper" id = "reg-ped">
            <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."header-nav.html"); ?> <!--codigo php usado para incluir el header sin necesidad del codigo-->
            
            <div class = "main_container">
                <div class="item" id = "form-ped">
                    <div class = "form">    
                        <?php
                            error_reporting(0);
                            include_once "../configuraciones/conexion_bd.php";
                            $rsC = pg_query($conexion,"SELECT * FROM cliente");
                            $rsP = pg_query($conexion,"SELECT * FROM producto");
                            $rsPed=pg_query($conexion,"SELECT MAX(id_pedido) FROM pedido");
                            $id=pg_fetch_object($rsPed);
                            

                            $boton = $_POST['registro'];
                            if($boton=='Registrar pedido')
                            {
                                $query=("INSERT INTO pedido(fecha_entrega,hora_entrega,precio,punto_entrega,calle,no_casa,
                                            colonia,estado,pais,codigo_postal,referencia,id_cliente)
                                        VALUES('$_REQUEST[fecha_entrega]','$_REQUEST[hora_entrega]',
                                            '$_REQUEST[precio]','$_REQUEST[punto_entrega]','$_REQUEST[calle]','$_REQUEST[no_casa]',
                                            '$_REQUEST[colonia]','$_REQUEST[estado]','$_REQUEST[pais]','$_REQUEST[codigo_postal]',
                                            '$_REQUEST[referencia]','$_REQUEST[selCliente]')");
                                $consulta=pg_query($conexion,$query);
                                if($consulta)
                                {
                                    echo "<script>
                                                alert('El cliente se registro correctamente, recuerda que un pedido debe tener al menos un producto');
                                                history.back();
                                            </script>";
                                }else{
                                    echo "<script>
                                                alert('No se pudo registrar el pedido');
                                                history.back();
                                                </script>";
                                    }
                                    pg_close();
                            } 

                            if($boton=='Escoger productos')
                            {
                                $pg_mat_agr = "INSERT INTO pedido_contiene 
                                                VALUES ($id->max,'$_REQUEST[selProducto]', '$_REQUEST[cantidad]')";
                                $consulta_mat=pg_query($conexion,$pg_mat_agr);
                                if($consulta_mat)
                                {
                                    echo "<script> 
                                            alert('El producto se registro correctamente en el pedido');
                                            history.back();
                                        </script>";

                                }else{
                                    echo "<script> 
                                            alert('No se a ingresado nuevo pedido');
                                            history.back();
                                        </script>";
                                }
                            }
                        ?>
                        <div>
                            <form method="POST" autocomplete = "off" class = "insert-form">
                                <div class = "form-heading">
                                    <h1>Registrar Pedido</h1>
                                    <p>Ingresa un nuevo pedido llenando los campos</p>
                                </div> <!--end from-heading-->    

                                <div class = "input-wrap">
                                    <input type="text" name="fecha_entrega" onfocus = "(this.type = 'date')" onblur = "if(!this.value) this.type = 'text'" class = "input-field" autocomplete = "off" required>
                                    <label class = "label">Fecha de entrega<span>*</span></label>
                                </div> <!--end input-wrap-->
                                    
                                <div class = "input-wrap">
                                    <input type="text" name="hora_entrega" onfocus = "(this.type = 'time')" onblur = "if(!this.value) this.type = 'text'" class = "input-field" autocomplete = "off" required>
                                    <label class = "label">Hora de entrega<span>*</span></label>
                                </div> <!--end input-wrap-->
                                    
                                <div class = "input-wrap">
                                    <input type="text" name="precio" class = "input-field" autocomplete = "off" required>
                                    <label class = "label">Precio (ej: 0.00)<span>*</span></label>
                                </div> <!--end input-wrap-->

                                <div class = "input-wrap">                                                                        
                                    <input type="text" name="punto_entrega" class = "input-field" autocomplete = "off">
                                    <label class = "label">Punto de entrega</label>
                                </div> <!--end input-wrap-->
                                    
                                <div class = "input-wrap">
                                    <input type="text" name="calle" class = "input-field" autocomplete = "off">
                                    <label class = "label">Calle</label>
                                </div> <!--end input-wrap-->
                                    
                                <div class = "input-wrap">
                                    <input type="text" name="no_casa" class = "input-field" autocomplete = "off">
                                    <label class = "label">Numero de casa</label>
                                </div> <!--end input-wrap-->

                                <div class = "input-wrap">    
                                    <input type="text" name="colonia" class = "input-field" autocomplete = "off">
                                    <label class = "label">Colonia</label>
                                </div> <!--end input-wrap-->

                                <div class = "input-wrap">
                                    <input type="text" name="estado" class = "input-field" autocomplete = "off">
                                    <label class = "label">Estado</label>
                                </div> <!--end input-wrap-->
                                
                                <div class = "input-wrap">
                                    <input type="text" name="pais" class = "input-field" autocomplete = "off">
                                    <label class = "label">Pais</label>
                                </div> <!--end input-wrap-->
                                
                                <div class = "input-wrap">
                                    <input type="text" name="codigo_postal" class = "input-field" autocomplete = "off">
                                    <label class = "label">Codigo Postal</label>
                                </div> <!--end input-wrap-->
                                
                                <div class = "input-wrap">
                                    <input type="text" name="referencia" class = "input-field" autocomplete = "off">
                                    <label class = "label">Referencia</label>
                                </div> <!--end input-wrap-->

                                <div class = "form-heading">
                                    <p>Selecciona el cliente que ha realizado el pedido, es necesario tener al cliente registrado antes de asignarle un pedido <span>*</span></p>
                                </div> <!--end from-heading-->
                                <select name="selCliente" required class = "select">
                                    <option disabled>Escoger cliente</option>
                                    <?php 
                                            while($cliente = pg_fetch_array($rsC)){
                                            echo "<option value = '$cliente[0]'> $cliente[1] $cliente[2] $cliente[3] </option>";
                                        }      
                                    ?>
                                </select><br>
                                <input type="submit" name ="registro" value="Registrar pedido" class = "submit-btn">
                            </form>
                        </div> <!--fin de div que contiene form-->
                        
                        <div>
                            <form method="POST">
                                <div class = "form-heading">
                                    <p>Después de registrarlo, selecciona uno a uno el producto y la cantidad del mismo, que contendrá tú pedido <span>*</span></p>
                                </div> <!--end from-heading-->
                                <select name = "selProducto" required class = "select">
                                    <option disabled>Escoger producto(s)</option>
                                    <?php 
                                        //recorriendo por todos los materiales
                                        while($producto = pg_fetch_array($rsP)){
                                            echo "<option value = '$producto[0]'> $producto[1] </option>";
                                        }      
                                    ?>
                                </select><br><br>
                                
                                <label>Cantidad<span>*</span></label>
                                <input type="text" name="cantidad" autocomplete = "off" required><br><br>

                                <input type="submit" name = "registro" value="Escoger productos" class = "submit-btn" id = "select">
                                <button type="button" class = "atras" onclick="location.href='vista_pedidos.php'">Atras</button>
                            </form>
                        </div> <!--fin div que contiene select-->
                    </div> <!--fin form-->

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