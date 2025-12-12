<?php
include_once '../inc/functions.php';


sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearVehiculo') || usuarioPrivilegiado()->hasPrivilege('modificarVehiculo')):
      $conductor = $_GET['conductor'];

      if(!empty($_GET['placa'])){
          $conductor = $_REQUEST['conductor'];
      }

      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT user_id FROM vp_conductor WHERE user_id = ?";
      $q = $pdo->prepare($sql);
      $q->execute(array($conductor));
      $u_i = $q->fetch(PDO::FETCH_ASSOC);
      Database::disconnect();

        if ($conductor == $u_i['user_id'])
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
