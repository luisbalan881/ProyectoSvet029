<?php
include_once '../inc/functions.php';
include_once 'inc/Coupon.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if(usuarioPrivilegiado()->hasPrivilege('crearCupon')) {
        $id = NULL;
        if (!empty($_GET['id'])) {
            $id = $_REQUEST['id'];
        }
        if (null == $id) {
            header("Location: index.php?ref=_40");
        }
        if (!empty($_POST)) {
            Coupon::create(usuarioPrivilegiado(),$id,$_POST['cupon_inicio'],$_POST['cupon_fin'],fecha_ymd($_POST['fecha_inicio']),fecha_ymd($_POST['fecha_fin']),$_POST['costo'],$_SESSION['user_id']);
            header('Location: index.php?ref=_41&id='.$id);
        }
    }else {
        echo include(unauthorized());
    }
else:
    header("Location: index.php");
endif;
?>
