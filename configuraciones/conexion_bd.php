<?php
    $conexion = pg_connect("host=localhost dbname=jewy_acces user=postgres password=usuario1234");

    if ($conexion) {
        echo "Se conectó correctamente!\n";
    }
    else {
        echo "Ha ocurrido un problema.\n";
    }	
?>