<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>
</head>
<body>
    <header>
    <h2 class='text-center'>Registrar Pedido</h2>
    </header>
    <section>
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
                $query=("INSERT INTO pedido(fecha_pedido,fecha_entrega,hora_entrega,precio,punto_entrega,calle,no_casa,
                        colonia,estado,pais,codigo_postal,referencia,id_cliente)
                        VALUES('$_REQUEST[fecha_pedido]','$_REQUEST[fecha_entrega]','$_REQUEST[hora_entrega]',
                        '$_REQUEST[precio]','$_REQUEST[punto_entrega]','$_REQUEST[calle]','$_REQUEST[no_casa]',
                        '$_REQUEST[colonia]','$_REQUEST[estado]','$_REQUEST[pais]','$_REQUEST[codigo_postal]',
                        '$_REQUEST[referencia]','$_REQUEST[selCliente]')");
                $consulta=pg_query($conexion,$query);
                if($consulta)
                {
                    echo "<script>
                                alert('El cliente se registro correctamente');
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

            if($boton=='Registrar producto en pedido')
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
        <form method="POST">
            <label for="nombre"><b>Fecha de pedido: </b></label>
            <input type="text" name="fecha_pedido">
            <label for="nombre"><b>Fecha de entrega: </b></label>
            <input type="text" name="fecha_entrega">
            <label for="  nombre"><b>Hora de entrega: </b></label>
            <input type="text" name="hora_entrega"><br><br>
            <label for="nombre"><b>Precio: </b></label>
            <input type="text" name="precio">
            <label for="nombre"><b>Punto de entrega: </b></label>
            <input type="text" name="punto_entrega">
            <label for="nombre"><b>Calle: </b></label>
            <input type="text" name="calle"><br><br>
            <label for="nombre"><b>Numero de casa: </b></label>
            <input type="text" name="no_casa">
            <label for="nombre"><b>Colonia: </b></label>
            <input type="text" name="colonia">
            <label for="nombre"><b>Estado: </b></label>
            <input type="text" name="estado"><br><br>
            <label for="nombre"><b>Pais: </b></label>
            <input type="text" name="pais">
            <label for="nombre"><b>Codigo Postal: </b></label>
            <input type="text" name="codigo_postal">
            <label for="nombre"><b>Referencia: </b></label>
            <input type="text" name="referencia"><br><br>
            <label for="nombre"><b>Cliente: </b></label><br>
            <select name="selCliente">
                <?php 
                        while($cliente = pg_fetch_array($rsC)){
                        echo "<option value = '$cliente[0]'> $cliente[1] </option>";
                    }      
                ?>
            </select><br>
            <br><input type="submit" name ="registro" value="Registrar pedido">
        </form><br>
        
    </section>
    <section>
        <h2>Registrar producto en pedido</h2>
            <form method="POST">
                <select name = "selProducto">
                        <option>Escoger producto(s)</option>
                        <?php 
                            //recorriendo por todos los materiales
                            while($producto = pg_fetch_array($rsP)){
                                echo "<option value = '$producto[0]'> $producto[1] </option>";
                            }      
                        ?>
                </select><br>
                <label for="nombre"><b>Cantidad</b></label>
                <input type="text" name="cantidad"><br><br>
                <br><input type="submit" name = "registro" value="Registrar producto en pedido">
            </form>
    </section><br>
    <button type="button" onclick="location.href='http://localhost/Jewy_access/secciones/vista_pedidos.php'">Atras</button>
    </body>
</html>