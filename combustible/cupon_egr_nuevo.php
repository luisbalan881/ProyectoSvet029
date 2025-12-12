<?php
include_once '../inc/functions.php';
include_once 'inc/CouponDispatch.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if(usuarioPrivilegiado()->hasPrivilege('crearCupon')) {
        if (!empty($_POST)) {
            CouponDispatch::create(usuarioPrivilegiado(),fecha_ymd($_POST['fecha']),$_POST['cupon_key'],$_POST['vehiculo_id'],$_POST['conductor_id'],$_POST['usuario_id'],0,0,0,$_POST['cantidad'],$_SESSION['user_id']);
            header('Location: index.php?ref=_42');
        }
    }else {
        echo include(unauthorized());
    }
else:
    header("Location: index.php");
endif;
?>
