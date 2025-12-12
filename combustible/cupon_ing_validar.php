<?php
include_once '../inc/functions.php';
include_once 'funciones_cupones.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('leerCupon')) :
        include_once 'inc/Coupon.php';
        $id = 0;
        $coupons = array();
        $cupon_inicio = null;
        $cupon_final = null;
        $duplicado = false;
        if(isset($_GET['cupon_pedido_id'])){
            if($_GET['cupon_pedido_id'] != 'undefined'){
                $id = $_REQUEST['cupon_pedido_id'];
                $coupons = Coupon::getByApplication(usuarioPrivilegiado(),$id);
            }
        }
        if(isset($_GET['cupon_inicio'])){
            if($_GET['cupon_inicio'] != 'undefined'){
                $cupon_inicio = $_REQUEST['cupon_inicio'];
            }
        }
        if(isset($_GET['cupon_final'])){
            if($_GET['cupon_final'] != 'undefined'){
                $cupon_final = $_REQUEST['cupon_final'];
            }
        }
        foreach ($coupons as $cupon):
            if($cupon_inicio == $cupon['num'] || $cupon_final == $cupon['num']) {
                $duplicado = true;
            }
        endforeach;
        if (!$duplicado)
        {
            echo 'true';
        }else{
            echo 'false';
        };
    else :
        echo include(unauthorized());
    endif;
else:
    header("Location: index.php");
endif;
?>
