<?php
include_once '../configuraciones/conexion_bd.php';
$id = $_GET['id_pedidos'];
$query_update = "UPDATE pedido SET vendido = '1' WHERE id_pedido = $id";
$update=pg_query($conexion,$query_update);
header("location: vista_pedidos.php");
pg_close();
?>