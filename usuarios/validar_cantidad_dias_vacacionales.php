<?php
include_once '../inc/functions.php';
include_once '../inc/Database.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')):
        $from = $_GET['from'];
        $to = $_GET['to'];
        $codigo = $_GET['codigo'];
        $dia = $_GET['dia'];
        $user_id = $_GET['user_id'];

        if(!empty($_GET['from'])){
            $from = $_REQUEST['from'];
        }
        if(!empty($_GET['to'])){
            $to = $_REQUEST['to'];
        }
        if(!empty($_GET['codigo'])){
            $codigo = $_REQUEST['codigo'];
        }

        if(!empty($_GET['dia'])){
            $dia = $_REQUEST['dia'];
        }


        $date1 = date('Y-m-d', strtotime($from));
        $date2 = date('Y-m-d', strtotime($to));

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT COUNT(*) as conteo FROM vp_user_horario_general
                    WHERE fecha_laboral BETWEEN ? AND ?
                    AND user_vid = ? AND tipo_dia_laboral <> 3 AND tipo_dia_laboral <> 50";
        $q = $pdo->prepare($sql);
        $q->execute(array($date1,$date2,$codigo));
        $dsol = $q->fetch(PDO::FETCH_ASSOC);
        $ds = $dsol['conteo'];


        $sql2 = "SELECT MIN(periodo_final) as f_l, dias_pendiente FROM vp_user_periodo WHERE user_id=? AND dias_pendiente>0";
        $q2 = $pdo->prepare($sql2);
        $q2->execute(array($user_id));
        $dpen = $q2->fetch(PDO::FETCH_ASSOC);
        $dp = $dpen['dias_pendiente'];

        Database::disconnect();

        if ($dia==2 || $dia==4 ||$dia==5 ||
            $dia==7 || $dia==8 ||$dia==9 ||
            $dia==10 || $dia==11 ||$dia==12 )

        {
          echo 'true';
        }
        else
        {
          if ($ds > $dp && $dia==6 )
          {
            echo 'false';
          }else
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



/*

*/
?>
