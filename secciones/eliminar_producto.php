<?php
include_once '../configuraciones/conexion_bd.php';
$id = $_GET['id_productos'];
$query_eliminar = "DELETE FROM producto WHERE id_producto = $id";
$eliminar=pg_query($conexion,$query_eliminar);
header("location: vista_productos.php");
pg_close();
?>