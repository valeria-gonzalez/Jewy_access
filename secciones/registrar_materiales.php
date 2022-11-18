<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/styles.css"> <!--link al archivo css-->
        <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."metadata.html"); ?> 
        <title>Registrar Material</title>
    </head>

    <body>
        <div class = "wrapper" id = "reg-mat">
            <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."header-nav.html"); ?> <!--codigo php usado para incluir el header sin necesidad del codigo-->
                    
                <div class = "main_container" >
                    <div class="item" id = "form-mat">
                        <div class = "form">
                                <?php
                                    error_reporting(0);
                                    include_once "../configuraciones/conexion_bd.php";

                                    $boton = $_POST['registro'];
                                    if($boton){
                                        $query=("INSERT INTO material(nombre,proveedor,precio,existencia)
                                                VALUES('$_REQUEST[nombre]','$_REQUEST[proveedor]',
                                                '$_REQUEST[precio]','$_REQUEST[existencia]')");

                                        $consulta=pg_query($conexion,$query);
                                        if($consulta){
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

                                <form method="POST" autocomplete = "off" class = "insert-form">

                                    <div class = "form-heading">
                                        <h1>Registrar Material</h1>
                                        <p>Ingresa un nuevo material llenando los campos</p>
                                    </div> <!--end from-heading-->

                                    <div class = "form-inputs"> 
                                        <div class = "input-wrap">
                                            <input type="text" name="nombre" class = "input-field" autocomplete = "off" required>
                                            <label class = "label" >Nombre<span>*</span></label>
                                        </div> <!--end input-wrap nombre-->

                                        <div class = "input-wrap">
                                            <input type="text" name="proveedor" class = "input-field" autocomplete = "off" required>
                                            <label class = "label">Proveedor<span>*</span></label>
                                        </div> <!--end input-wrap proveedor-->

                                        <div class = "input-wrap">
                                            <input type="text" name="precio" class = "input-field" autocomplete = "off" required>
                                            <label class = "label">Precio<span>*</span></label>
                                        </div> <!--end input-wrap precio-->

                                        <div class = "input-wrap">
                                            <input type="text" name="existencia" class = "input-field" autocomplete = "off" required>
                                            <label class = "label">Existencia<span>*</span></label>
                                        </div> <!--end input-wrap existencia-->

                                        <input type="submit" name="registro" value="Registrar" class = "submit-btn"> <br>
                                        <button type="button" id = "atras" class = "atras" onclick="location.href='vista_material.php'">Atrás</button>
                                    </div> <!--end form-inputs-->
                                </form>
                        </div>  <!--end form-->
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