<?php
include_once '../inc/functions.php';
include_once 'funciones_archivo.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearInstitucion')){
        if (!empty($_POST)){
            institucion_nueva();
            header("Location: index.php?ref=_29");
        }
    }else {
        echo include(unauthorizedModal());
    }
else:
    header("Location: index.php");
endif;
?>
