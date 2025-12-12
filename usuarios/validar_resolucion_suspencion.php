<?php
include_once '../inc/functions.php';
include_once '../inc/Database.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')):
        $resolucion = $_GET['resolucion'];

        if(!empty($_GET['resolucion'])){
            $resolucion = $_REQUEST['resolucion'];
        }



        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT resolucion FROM vp_user_suspenciones WHERE resolucion = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($resolucion));
        $r_p = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();



        if ($resolucion == $r_p['resolucion'])
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



/*

*/
?>
