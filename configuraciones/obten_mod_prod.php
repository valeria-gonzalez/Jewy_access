<?php 
    function getNombre(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            return $_POST['txtNombre'];
        
    }

    function getCategoria(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            return $_POST['txtCategoria'];
    }

    function getPrecio(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            return $_POST['numPrecio'];
    }

    function getExistencia(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            return $_POST['numExistencia'];
    }
    
    function getId(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            return $_POST['numId'];
    }

?>