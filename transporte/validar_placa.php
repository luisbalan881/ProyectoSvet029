<?php
include_once '../inc/functions.php';


sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearVehiculo') || usuarioPrivilegiado()->hasPrivilege('modificarVehiculo')):
      $placa = $_GET['placa'];

      if(!empty($_GET['placa'])){
          $placa = $_REQUEST['placa'];
      }

      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT placa FROM vp_vehiculo WHERE placa = ?";
      $q = $pdo->prepare($sql);
      $q->execute(array($placa));
      $placa = $q->fetch(PDO::FETCH_ASSOC);
      Database::disconnect();

        if ($placa != $placa['placa'])
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
