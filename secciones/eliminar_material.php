<?php
include_once '../configuraciones/conexion_bd.php';
$id = $_GET['id_materiales'];
$query_eliminar = "DELETE FROM material WHERE id_material = $id";
$eliminar=pg_query($conexion,$query_eliminar);
header("location: vista_material.php");
pg_close();
?>