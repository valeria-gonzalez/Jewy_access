<?php
//Incluyendo la conexión a la base de datos
include_once '../configuraciones/conexion_bd.php';
//Asignandole a una variable de php la variable de html en donde guardamos el id del cliente
$id = $_GET['id_clientes'];
/*haciendo el query en donde si el id de la base de datos es igual al id que extraimos de la
variable html*/
$query_eliminar = "DELETE FROM cliente WHERE id_cliente = $id";
/*ejecutando la acción pasando con ayuda de "pg_query" pasando por parametros nuestra
conexión y nuestro query (como ya se había visto para visualizar las distinas tablas)*/
$eliminar=pg_query($conexion,$query_eliminar);
//devolvíendo el resultado a la ventana de "vista_clientes"
header("location: vista_clientes.php");
//Cerrando las consultas
pg_close();
?>
<!-- Lo mismo se hace en todas las demás ventanas -->