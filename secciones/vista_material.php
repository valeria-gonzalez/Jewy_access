<?php
include_once '../configuraciones/conexion_bd.php';
$query_consulta = "SELECT * FROM material";
$consulta=pg_query($conexion,$query_consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de clientes</title>
</head>
<script>
    function confirmacion(){
        var respuesta = confirm("¿Está seguro que desea eliminar este registro?");

        if(respuesta == true)
            return true;
        else
            return false;
    }
</script>
<body>
    <h3 class="text-center">Tabla Dinámica Materiales</h3>
    <div class="table-responsive table-hover" id="tablaconsulta">
        <table class="table">
            <thead class="text-muted">
                <th class="text-center">Nombre</th>
                <th class="text-center">Proveedor</th>
                <th class="text-center">Precio</th>
                <th class="text-center">Existencia</th>
                <th class="text-center">Opciones</th>
            </thead>
            <tbody>
                <?php
                if($consulta){
                    if(pg_num_rows($consulta) > 0){
                        while($obj=pg_fetch_object($consulta)){?>
                <tr>
                    <td><?php echo $obj->nombre?></td>
                    <td><?php echo $obj->proveedor?></td>
                    <td><?php echo $obj->precio?></td>
                    <td><?php echo $obj->existencia?></td>
                    <td>
                        <a href="#">Editar</a>
                        <a href="eliminar_material.php?id_materiales=<?php echo $obj->id_material;?>" onclick='return confirmacion()'>
                            Borrar
                        </a>
                        <a href="registar_materiales.php">Agregar</a>
                    </td>                    
                </tr>
                <?php } } }?>
                <button type="button" onclick="location.href='http://localhost/Jewy_access/'">Inicio</button>
            </tbody>

        </table>
    </div>
</body>
</html>