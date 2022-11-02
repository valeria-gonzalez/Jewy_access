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
    <h2>Registrar Materiales</h2>
    </header>
    <section>
        <?php
            error_reporting(0);
            include_once "../configuraciones/conexion_bd.php";

            $boton = $_POST['registro'];
            if($boton)
            {
                    $query=("INSERT INTO material(nombre,proveedor,precio,existencia)
                            VALUES('$_REQUEST[nombre]','$_REQUEST[proveedor]',
                            '$_REQUEST[precio]','$_REQUEST[existencia]')");

                    $consulta=pg_query($conexion,$query);
                    if($consulta)
                    {
                        echo "<script>
                                alert('El Material se registro correctamente');
                                history.back();
                              </script>";
                            
                    }else{
                        echo "<script>
                                alert('No se pudo registrar el material');
                                history.back();
                              </script>";
                    }
                    pg_close();
            }
        ?>
        <form method="POST">
            <label for="nombre"><b>Nombre: </b></label>
            <input type="text" name="nombre">
            <label for="  nombre"><b>Proveedor: </b></label>
            <input type="text" name="proveedor"><br><br>
            <label for="nombre"><b>Precio: </b></label>
             <input type="text" name="precio">               
            <label for="nombre"><b>Existencia: </b></label>
            <input type="text" name="existencia"><br><br>
            <input type="submit" name="registro" value="Registrar">
        </form><br>    
    </section>
    <button type="button" onclick="location.href='http://localhost/Jewy_access/secciones/vista_material.php'">Atras</button>
</body>
</html>