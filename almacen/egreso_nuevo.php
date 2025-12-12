<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearAlmacen')){
          $id = null;
          if ( !empty($_GET['id'])) {
              $id = $_REQUEST['id'];
          }
          if ( null==$id ) {
              header("Location: index.php?ref=_7");
          }
          if ( !empty($_POST)) {
            egreso_nuevo($id);
            header("Location: index.php?ref=_8&id=".$id);
          }
    }else{
        echo include(unauthorized());
    }
else:
    header("Location: index.php");
endif;
?>
