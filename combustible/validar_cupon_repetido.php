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

      $pdo = Database::connect();
      set_time_limit(0);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT cupon_id FROM vp_cupon WHERE cupon_id=?";
      $q = $pdo->prepare($sql);
      $q->execute(array($cupon1));
      $cu = $q->fetch(PDO::FETCH_ASSOC);


      if($cupon1 ==$cu['cupon_id'] || $cupon2 ==$cu['cupon_id'])
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
