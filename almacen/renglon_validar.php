<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check() == true):
    if (usuarioPrivilegiado()->hasPrivilege('leerAlmacen')) :
        $renglon_id = $_GET['renglon_id'];
        $duplicado = duplicado_renglon($renglon_id);
        if (!$duplicado)
        {
            echo 'true';
        }else{
            echo 'false';
        }
    else :
        echo include(unauthorized());
    endif;
else:
    header("Location: ../index.php");
endif;
?>

