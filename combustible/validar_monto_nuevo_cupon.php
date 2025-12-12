<?php
include_once '../inc/functions.php';
include_once '../inc/Database.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearCupon')):

      $monto = $_GET['monto'];

      if(!empty($_GET['monto'])){
        $monto = $_GET['monto'];
      }


      if($monto==50 || $monto==100)
      {
        echo 'true';
      }
      else {
        echo 'false';
      }

    else:
        echo include(unauthorized());
    endif;
else:
    header("Location: ../index.php");
endif;

?>
