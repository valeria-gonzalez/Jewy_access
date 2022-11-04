<?php 
    //En este documento vamos a crear funciones para poder guardar lo que se ingrese en 
    //los campos de texto del formulario mediante POST
    function getFechaEntr(){
        if($_SERVER['REQUEST_METHOD'] == 'POST') //esta linea resulta necesaria pq se debe diferenciar si se manda por post o get
            return $_POST['txtFecha']; //guardamos el valor del campo referenciandolo por su nombre
    }

    function getHoraEntr(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            return $_POST['txtHora'];
    }

    function getPrecio(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            return $_POST['numPrecio'];
    }

    function getPuntoEntr(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            return $_POST['txtPuntoEntr'];
    }

    function getCalle(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            return $_POST['txtCalle'];
    }

    function getNoCasa(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            return $_POST['txtNoCasa'];
    }

    function getColonia(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            return $_POST['txtColonia'];
    }

    function getEstado(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            return $_POST['txtEstado'];
    }

    function getPais(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            return $_POST['txtPais'];
    }

    function getCodPos(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            return $_POST['txtCodPos'];
    }

    function getRef(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            return $_POST['txtReferencia'];
    }

    function getCantidad(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
            return $_POST['numCantidad'];
    }

?>