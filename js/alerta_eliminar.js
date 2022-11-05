function confirmacion(){
    var respuesta = confirm("¿Está seguro que desea eliminar este registro?");

    if(respuesta == true)
        return true;
    else
        return false;
}

function confirmar_venta(){
    var respuesta = confirm("El pedido ha sido vendido\n¿Es correcto?");

    if(respuesta == true)
        return true;
    else
        return false;
}