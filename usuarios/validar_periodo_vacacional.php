<?php
include_once '../inc/functions.php';
include_once '../inc/Database.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')):

      $f = date('Y-m-d');
      $dia = $_GET['dia'];
      $codigo = $_GET['codigo'];

      if(!empty($_GET['dia'])){
          $dia = $_REQUEST['dia'];
      }
      /*if(!empty($_GET['codigo'])){
          $codigo = $_REQUEST['codigo'];
      }*/

      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT MIN(periodo_final) as f_l FROM vp_user_periodo WHERE user_id=? AND dias_pendiente>0";
      $q = $pdo->prepare($sql);
      $q->execute(array($codigo));
      $fechas = $q->fetch(PDO::FETCH_ASSOC);
      Database::disconnect();



      if ($dia==2 || $dia==4 ||$dia==5 ||
          $dia==7 || $dia==8 ||$dia==9 ||
          $dia==10 || $dia==11 ||$dia==12 )

      {
        echo 'true';
      }
      else
      {
        if($f < $fechas['f_l'] && $dia==6)
        {
          echo 'false';
        }
        else
        {
          echo 'true';
        }

      }



    else:
        echo include(unauthorized());
    endif;
else:
    header("Location: ../index.php");
endif;

?>
