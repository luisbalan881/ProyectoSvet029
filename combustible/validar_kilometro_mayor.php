<?php
include_once '../inc/functions.php';
include_once '../inc/Database.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearCupon')):

      $cupon1 = $_GET['km_ini'];
      $cupon2 = $_GET['km_fin'];
      if(!empty($_GET['km_ini'])){
        $cupon1 = $_GET['km_ini'];
      }
      if(!empty($_GET['km_fin'])){
        $cupon2 = $_GET['km_fin'];
      }


      if($cupon1 > $cupon2)
      {
        echo 'false';
      }
      else {
        echo 'true';
      }

    else:
        echo include(unauthorized());
    endif;
else:
    header("Location: ../index.php");
endif;

?>
