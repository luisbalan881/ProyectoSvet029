<?php
include_once '../inc/functions.php';
include_once '../inc/Database.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearCupon')):

      $cupon1 = $_GET['cupon_i'];
      $cupon2 = $_GET['cupon_f'];
      if(!empty($_GET['cupon_i'])){
        $cupon1 = $_GET['cupon_i'];
      }
      if(!empty($_GET['cupon_f'])){
        $cupon2 = $_GET['cupon_f'];
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
