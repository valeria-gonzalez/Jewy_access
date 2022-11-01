<?php
include_once '../configuraciones/conexion_bd.php';
$id = $_GET['id_pedidos'];
$query_eliminar = "DELETE FROM pedido WHERE id_pedido = $id";
$eliminar=pg_query($conexion,$query_eliminar);
header("location: vista_pedidos.php");
pg_close();
?>