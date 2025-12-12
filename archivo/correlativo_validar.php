<?php
include_once '../inc/functions.php';
include_once 'funciones_archivo.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearArchivo') || usuarioPrivilegiado()->hasPrivilege('modificarArchivo')):
        $arch_correlativo = $_GET['arch_correlativo'];
        $arch_id = 0;
        if(!empty($_GET['arch_id'])){
            $arch_id = $_REQUEST['arch_id'];
        }
        $duplicado = correlativo_duplicado($arch_correlativo,$arch_id);
        if (!$duplicado)
        {
          echo 'true';
        }else{
          echo 'false';
        }
    else:
        echo include(unauthorized());
    endif;
else:
    header("Location: ../index.php");
endif;
?>