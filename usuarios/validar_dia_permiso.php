<?php
include_once '../inc/functions.php';
include_once '../inc/Database.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')):

      $fecha = $_GET['fecha_per'];
      if(!empty($_GET['fecha_per'])){
        $fecha = $_REQUEST['fecha_per'];
      }
      $date1 = date('Y-m-d', strtotime($fecha));

      $pdo = Database::connect();
      set_time_limit(0);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT count(*) as conteo FROM vp_user_horario_general WHERE tipo_dia_laboral=? AND fecha_laboral = ?";
      $q = $pdo->prepare($sql);
      $q->execute(array(3,$date1));


      $sql2 = "SELECT count(*) as conteo FROM vp_user_horario_general WHERE tipo_dia_laboral=? AND fecha_laboral = ?";
      $q2 = $pdo->prepare($sql2);
      $q2->execute(array(50,$date1));
      Database::disconnect();

      $f1 = $q->fetch(PDO::FETCH_ASSOC);
      $f2 = $q2->fetch(PDO::FETCH_ASSOC);

      $suma = $f1['conteo'] + $f2['conteo'];

      if($suma > 0)
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
