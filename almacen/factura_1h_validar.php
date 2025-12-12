<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearAlmacen') || usuarioPrivilegiado()->hasPrivilege('modificarAlmacen')) :
        $validar_1h = $_GET['fac_1h'];
        $fac_id = 0;
        if(isset($_GET['fac_id'])){
            if($_GET['fac_id'] != 'undefined'){
                $fac_id = $_REQUEST['fac_id'];
            }
        }
        $duplicado = duplicado_1h($validar_1h,$fac_id);
        if (!$duplicado)
        {
          echo 'true';
        }else{
          echo 'false';
        };
    else :
        echo include(unauthorized());
    endif;
else:
    header("Location: ../index.php");
endif;
?>

