<!-- estructura html -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/styles.css"> <!--link al archivo css-->
        <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."metadata.html"); ?> 
        <title>Registrar Cliente</title>
    </head>
    <body>
        <div class = "wrapper" id = "reg-ped">
            <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."header-nav.html"); ?> <!--codigo php usado para incluir el header sin necesidad del codigo-->
                            
            <div class = "main_container">
                <div class="item" id = "form-clien">
                    <div class = "form">
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
                        <form method="POST" autocomplete = "off" class = "insert-form">
                            <div class = "form-heading">
                                    <h1>Registrar Cliente</h1>
                                    <p>Ingresa un nuevo cliente llenando los campos</p>
                                </div> <!--end from-heading-->    

                            <div class = "input-wrap">
                                <input type="text" name="nombre" class = "input-field" autocomplete = "off" required>
                                <label class = "label">Nombre(s)</label>
                            </div> <!--end input-wrap-->

                            <div class = "input-wrap">  
                                <input type="text" name="primer_apellido" class = "input-field" autocomplete = "off" required>
                                <label class = "label">Primer Apellido</label>
                            </div> <!--end input-wrap-->

                            <div class = "input-wrap">    
                                <input type="text" name="segundo_apellido" class = "input-field" autocomplete = "off" required>
                                <label class = "label">Segundo Apellido</label>
                            </div> <!--end input-wrap-->    
                            
                            <div class = "input-wrap">
                                <input type="text" name="telefono" class = "input-field" autocomplete = "off" required>
                                <label class = "label">Telefono</label>
                            </div> <!--end input-wrap-->
                            <!--Boton con el que registra los datos ingresados-->
                            <input type="submit" name = 'registro' value="Registrar" class = "submit-btn">
                            <!-- Botones para regresar a la pagina anterior -->
                            <button type="button" class = "atras" onclick="location.href='vista_clientes.php'">Atras</button>
                        </form>
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