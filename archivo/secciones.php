<?php
if (isset($u) && $u->hasPrivilege('leerArchivo')):
    switch($page)
    {
        case '_25':
            include('archivo/archivos_listado.php');
        break;
        case '_27':
            include('archivo/archivos_recibidos_listado.php');
            break;
        case '_29':
            include('archivo/instituciones_listado.php');
        break;
        case '_30':
            include('archivo/tipos_listado.php');
        break;
    }
endif;
?>
