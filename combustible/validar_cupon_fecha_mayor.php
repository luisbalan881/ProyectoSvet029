<?php
include_once '../inc/functions.php';
include_once '../inc/Database.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearCupon')):

      $f1 = $_GET['fecha_emi'];
      $f2 = $_GET['fecha_ven'];
      if(!empty($_GET['fecha_emi'])){
        $f1 = $_REQUEST['fecha_emi'];
      }
      if(!empty($_GET['fecha_ven'])){
        $f2 = $_REQUEST['fecha_ven'];
      }

      $date1 = date('Y-m-d', strtotime($f1));

      $date2 = date('Y-m-d', strtotime($f2));


      if($date1 > $date2)
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
