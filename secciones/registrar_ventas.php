<!--ESTE DOC NO DEBERIA EXISTIR, LAS VENTAS SE INSERTAN CON EL TRIGGER-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta</title>
</head>
<body>
    <header>
    <h2 class='text-center'>Registrar Venta</h2>
    </header>
    <section>
        <?php
            error_reporting(0);
            include_once "../configuraciones/conexion_bd.php";

            $boton = $_POST['registro'];
            if($boton)
            {
                $query=("INSERT INTO venta(fecha_pedido,fecha_entrega,hora_entrega,precio,punto_entrega,calle,no_casa,
                        colonia,estado,pais,codigo_postal,referencia)
                        VALUES('$_REQUEST[fecha_pedido]','$_REQUEST[fecha_entrega]','$_REQUEST[hora_entrega]',
                        '$_REQUEST[precio]','$_REQUEST[punto_entrega]','$_REQUEST[calle]','$_REQUEST[no_casa]',
                        '$_REQUEST[colonia]','$_REQUEST[estado]','$_REQUEST[pais]','$_REQUEST[codigo_postal]',
                        '$_REQUEST[referencia]')");

                $consulta=pg_query($conexion,$query);
                if($consulta)
                {
                    echo "<script>
                                alert('La venta se registro correctamente');
                                history.back();
                              </script>";
                }else{
                    echo "<script>
                                alert('No se pudo registrar la venta');
                                history.back();
                              </script>";
                }
                pg_close();
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
            <input type="submit" name ="registro" value="Registrar">
        </form><br>
        <button type="button" onclick="location.href='http://localhost/Jewy_access/secciones/vista_ventas.php'">Atras</button>
    </section>
    </body>
</html>