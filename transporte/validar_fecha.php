<?php



sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearSolicitudTransporte')):


      $f = $_GET['soli_fecha'];

      if(!empty($_GET['soli_fecha'])){
          $f = $_REQUEST['soli_fecha'];
      }

      $fe = date('Y-m-d', strtotime($f));

      if ($fe < date("Y-m-d"))
      {
        echo 'false';
      }else{
        echo 'true';
      }


    else:
        echo include(unauthorized());
    endif;
else:
    header("Location: ../index.php");
endif;


?>
