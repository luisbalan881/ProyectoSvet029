<?php
include_once '../inc/functions.php';
include_once 'funciones_cupones.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('leerCupon')) :
        include_once 'inc/CouponDispatch.php';
        $id = 0;
        $existe = 0;
        $fecha_fin = null;
        $fecha_inicio = fecha_ymd($_GET['fecha_inicio']);
        if(isset($_GET['fecha_fin'])){
            if($_GET['fecha_fin'] != 'undefined'){
                $fecha_fin = fecha_ymd($_REQUEST['fecha_fin']);
            }
        }
        if(isset($_GET['vehiculo_id'])){
            if($_GET['vehiculo_id'] != 'undefined'){
                $id = $_REQUEST['vehiculo_id'];
            }
        }
        if ($id != 0){
            $vehiculo_cupones = CouponDispatch::getByVehicleID(usuarioPrivilegiado(),$id,$fecha_inicio,$fecha_fin);
        }else{
            $vehiculo_cupones = CouponDispatch::getByDate(usuarioPrivilegiado(),$fecha_inicio,$fecha_fin);
        }
        $existe = count($vehiculo_cupones);
        if ($existe > 0)
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
