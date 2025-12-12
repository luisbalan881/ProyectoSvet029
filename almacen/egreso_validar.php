<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearAlmacen')) :
        $id = $_GET['prod_id'];
        $req_fecha = $_GET['req_fecha'];
        $producto = producto_info_fecha($id,$req_fecha);
        $existencia = $producto['existencia'];
        $egreso = $_GET['egr_cant'];
        if ($egreso > 0 && $egreso <= $existencia)
        {
          echo 'true';
        }else{
          echo 'false';
        }
    else :
        echo include(unauthorized());
    endif;
else:
    header("Location: index.php");
endif;
?>