<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css"> <!--link al archivo css, la ruta cambia de acuerdo al archivo-->
    <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."metadata.html"); ?> <!--codigo php usado para incluir los metadatos y script que ocupa el header-->
    <title>Inicio Jewy Access</title>
</head>
<body>
    <div class="wrapper">
        <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Jewy_access/cabeceras/"; include($IPATH."header-nav.html"); ?> <!--codigo php usado para incluir el header sin necesidad del codigo-->
  
        <div class = "main_container" >
            <div class="item" id = "home-msg-cont">
                <div class = "home-img-cont">
                    <img src="src/logo.png" alt="home-image" class = "home-img" > <!--imagen de fondo-->
                </div>

                <div class="item" id = "welcome-msg">
                    <div class = "welcome-wrap">
                        <h1>Bienvenido a <span class = "highlight"> Jewy Access </span></h1>
                        <p>En esta página podras administrar los datos de tu empresa!</p>
                    </div> <!--end welcome-wrap-->
                </div> <!--end item-->
            </div> <!--end item -->

            <!--si se quieren mas contenedores-->
            <!--<div class="item">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aut sapiente adipisci nemo atque eligendi reprehenderit minima blanditiis eum quae aspernatur!
            </div> end item

            <div class="item">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aut sapiente adipisci nemo atque eligendi reprehenderit minima blanditiis eum quae aspernatur!
            </div> end item

            <div class="item">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aut sapiente adipisci nemo atque eligendi reprehenderit minima blanditiis eum quae aspernatur!
            </div> end item-->

        </div> <!--end main_container-->
    </div> <!--end wrapper-->
	
</body>
</html>