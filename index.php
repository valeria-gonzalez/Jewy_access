<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/styles.css"> <!--link al archivo css-->
     <!-- adding boxicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script> <!--link a fontawesome (donde sacamos iconos)-->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> <!--link a jquery (hace posible el menu responsive)-->
	<script>
		$(document).ready(function(){
			$(".hamburger").click(function(){ 
                //cuando se haga click en el icono de hamburguesa
			   $(".wrapper").toggleClass("collapse"); //se agrega la clase collapse al wrapper cuando le haces click
			});
		});
	</script>
</head>
<body>
    <div class="wrapper">
        <div class="top_navbar"> <!--Barra superior de navegacion-->
            <div class="hamburger"> <!--Boton para el menu responsive-->
                <!--lines inside the hamburger menu -->
                <div class="one"></div> <!--end class one div--> 
                <div class="two"></div> <!--end class two div-->
                <div class="three"></div> <!--end class three div-->
            </div> <!--end hamburger-->

            <div class="top_menu"> <!--menu superior que contiene nombre de empresa e iconos-->
                <div class="logo">Jewy Access</div>
                    <ul>
                        <li><a href="#">
                                <i class="fas fa-search"></i> <!--icono de busqueda, asi se integra con fontawesome-->
                            </a>
                        </li>
                        <li><a href="#">
                            <i class='bx bxs-home'></i> <!--icono de casa, este lo saque de la pagina boxicons-->
                            </a>
                        </li>
                        <li><a href="#">
                                <i class="fas fa-user"></i> <!--icono de usuario-->
                            </a>
                        </li>
                    </ul>
            </div> <!--end top_menu-->
        </div> <!--end top_navbar-->
  
        <div class="sidebar"> <!--menu lateral de navegcion-->
            <ul> <!--link a cada pagina-->
                <li><a href="secciones/vista_material.php">  <!--link a materiales-->
                        <span class="icon"><i class='bx bxs-layer' ></i></span> <!--icono de cada link-->
                        <span class="title">Materiales</span> <!--elemento span usado como un div pero inline-->
                    </a>
                </li>

                <li><a href="secciones/vista_productos.php"> <!--link a productos-->
                        <span class="icon"><i class='bx bxs-store-alt'></i></span> 
                        <span class="title">Productos</span>
                    </a>
                </li>

                <li><a href="secciones/vista_clientes.php"> <!--link a clientes-->
                    <span class="icon"><i class='bx bxs-contact' ></i></span>
                    <span class="title">Clientes</span>
                    </a>
                </li>

                <li><a href="secciones/vista_pedidos.php"> <!--link a pedidos-->
                    <span class="icon"><i class='bx bxs-package'></i></span>
                    <span class="title">Pedidos</span>
                    </a>
                </li>

                <li><a href="secciones/vista_ventas.php"> <!--link a ventas-->
                    <span class="icon"><i class='bx bxs-receipt'></i></span>
                    <span class="title">Ventas</span>
                    </a>
                </li>
            </ul>
        </div> <!--end sidebar-->
  
        <div class="main_container">
            <div class="item" id = "home-msg-cont">
                <div class = "home-img-cont">
                    <img src="src/logo.png" alt="home-image" class = "home-img" > <!--imagen de fondo-->
                </div>

                <div class="item" id = "welcome-msg">
                    <h1>Bienvenido a <span class = "highlight"> Jewy Access </span></h1>
                    <p>En esta página podras administrar los datos de tu empresa!</p>
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