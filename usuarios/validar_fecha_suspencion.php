<?php
include_once '../inc/functions.php';
include_once '../inc/Database.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')):
        $from = $_GET['from'];
        $codigo = $_GET['codigo'];

        if(!empty($_GET['from'])){
            $from = $_REQUEST['from'];
        }
        if(!empty($_GET['codigo'])){
            $codigo = $_REQUEST['codigo'];
        }
        if($codigo > 0)
        {
          $date1 = date('Y-m-d', strtotime($from));

          $pdo = Database::connect();
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


          $sql1 = "SELECT user_horario_especial_id as COD
                   FROM vp_user WHERE user_vid = ?";
          $q1 = $pdo->prepare($sql1);
          $q1->execute(array($codigo));
          $grupo = $q1->fetch(PDO::FETCH_ASSOC);

          if($grupo['COD']==0)
          {

            $sql = "SELECT fecha_laboral FROM vp_user_horario_general WHERE fecha_laboral = ? and user_vid = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($date1, $codigo));
            $fechas = $q->fetch(PDO::FETCH_ASSOC);


            if ($date1 == $fechas['fecha_laboral'])
            {
              echo 'true';
            }else{
              echo 'false';
            }
          }
          else{
            echo 'true';
          }
          Database::disconnect();
        }
        else{
          echo 'true';
        }
    else:
        echo include(unauthorized());
    endif;
else:
    header("Location: ../index.php");
endif;



/*

*/
?>
