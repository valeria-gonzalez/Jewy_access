<!-- estructura html -->
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
        <h2 class='text-center'>Registrar Cliente</h2>
    </header>
    <section>
            <!--se abre php para hacer mandar las inserciones postgrsql-->
            <?php
                error_reporting(0);
                include_once "../configuraciones/conexion_bd.php";
                
                $boton = $_POST['registro'];
                if($boton)
                {
                    //Se define la peticion de insertado
                    $query=("INSERT INTO cliente(nombre,primer_apellido,segundo_apellido,telefono)
                            VALUES('$_REQUEST[nombre]','$_REQUEST[primer_apellido]',
                            '$_REQUEST[segundo_apellido]','$_REQUEST[telefono]')");
                    /*Se usa la misma variable de los archivos vista para interactuar
                    entre php y nuestra base de datos   */
                    $consulta=pg_query($conexion,$query);
                    if($consulta)
                    {
                        //Aviso de que la insercion fue correcta
                        echo "<script>
                                alert('El cliente se registro correctamente');
                                history.back();
                              </script>";
                    }else{
                        //Aviso de que la insercion no fue correcta
                        echo "<script>
                                alert('No se pudo registrar el cliente');
                                history.back();
                              </script>";
                    }
                    pg_close();                  
                }
            ?>
            <form method="POST">
                <label for="nombre"><b>Nombre: </b></label>
                <input type="text" name="nombre">
                <label for="  nombre"><b>Primer Apellido: </b></label>
                <input type="text" name="primer_apellido"><br><br>
                <label for="nombre"><b>Segundo Apellido: </b></label>
                <input type="text" name="segundo_apellido">
                <label for="nombre"><b>Telefono: </b></label>
                <input type="text" name="telefono"><br><br>
                <!--Boton con el que registra los datos ingresados-->
                <input type="submit" name = 'registro' value="Registrar">
        </form><br>
        <!-- Botones para regresar a la pagina anterior -->
        <button type="button" onclick="location.href='http://localhost/Jewy_access/secciones/vista_clientes.php'">Atras</button>
    </section>
    </body>
</html>