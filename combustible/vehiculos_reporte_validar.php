<?php
include_once '../inc/functions.php';
include_once 'funciones_cupones.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('leerCupon')) :
        include_once 'inc/CouponDispatch.php';
        $existe = 0;
        $fecha_fin = null;
        $fecha_inicio = fecha_ymd($_GET['fecha_inicio']);
        if(isset($_GET['fecha_fin'])){
            if($_GET['fecha_fin'] != 'undefined'){
                $fecha_fin = fecha_ymd($_REQUEST['fecha_fin']);
            }
        }
        $vehiculos_cupones = CouponDispatch::getByDate(usuarioPrivilegiado(),$fecha_inicio,$fecha_fin);
        $existe = count($vehiculos_cupones);
        echo $existe;
        if ($existe > 0)
        {
            echo $existe;
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
