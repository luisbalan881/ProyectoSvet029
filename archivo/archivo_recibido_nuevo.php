<?php
include_once '../inc/functions.php';
include_once 'funciones_archivo.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearArchivo')){
          if ( !empty($_POST)) {
            archivoRecibidoNuevo();
            header("Location: index.php?ref=_27");
          }
    }else{
        echo include(unauthorized());
    }
else:
    header("Location: index.php");
endif;
?>
