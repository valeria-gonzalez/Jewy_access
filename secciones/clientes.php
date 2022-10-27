<?php
include_once '../configuraciones/conexion_bd.php';
$id = $_GET['id_clientes'];
$query_eliminar = "DELETE FROM cliente WHERE id_cliente = $id";
$eliminar=pg_query($conexion,$query_eliminar);
header("location: vista_clientes.php");
?>