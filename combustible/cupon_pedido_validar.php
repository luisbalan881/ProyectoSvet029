<?php
include_once '../inc/functions.php';
include_once 'funciones_cupones.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('leerCupon')) :
        include_once 'inc/CouponApplication.php';
        $id = 0;
        $pedido_num = 0;
        $duplicado = false;
        $pedidos = CouponApplication::getAll(usuarioPrivilegiado());
        if(isset($_GET['cupon_pedido_id'])){
            if($_GET['cupon_pedido_id'] != 'undefined'){
                $id = $_REQUEST['cupon_pedido_id'];
            }
        }
        if(isset($_GET['pedido_num'])){
            if($_GET['pedido_num'] != 'pedido_num'){
                $pedido_num = $_REQUEST['pedido_num'];
            }
        }
        foreach ($pedidos as $pedido):
            if($pedido['pedido_num'] == $pedido_num && $pedido['cupon_pedido_id'] != $id && $pedido['status'] != 0) {
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
