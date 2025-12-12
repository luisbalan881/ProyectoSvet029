<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearAlmacen') || usuarioPrivilegiado()->hasPrivilege('modificarAlmacen')):
        $prod_id = 0;
        $renglon_id = 0;
        $codigo = 0;
        $codigo_presentacion = 0;
        $duplicado = false;
        if(!empty($_GET['prod_id'])){
            if($_GET['prod_id'] != 'undefined') {
                $prod_id = $_REQUEST['prod_id'];
            }
        }
        if(!empty($_GET['renglon_id'])){
            if($_GET['renglon_id'] != 'undefined') {
                $renglon_id = $_REQUEST['renglon_id'];
            }
        }
        if(!empty($_GET['codigo'])){
            $codigo = $_REQUEST['codigo'];
        }
        if(!empty($_GET['codigo_presentacion'])){
            $codigo_presentacion = $_REQUEST['codigo_presentacion'];
        }
        $productos = productos();
        if ($renglon_id == 285 || $renglon_id == 298 || $renglon_id==196){
            if($codigo == 0 && $codigo_presentacion == 0){
                $duplicado = false;
            }else{
                $duplicado = true;
            }
        }else{
            if($codigo != 0 || $codigo_presentacion != 0){
                foreach ($productos as $producto){
                    if ($producto['prod_cod'] == $codigo && $producto['codigo_presentacion'] == $codigo_presentacion && $producto['prod_id'] != $prod_id){
                        $duplicado = true;
                    }
                }
            }else{
                $duplicado = true;
            }

        }
        if (!$duplicado)
        {
          echo 'true';
        }else{
          echo 'false';
        }
    else:
        echo include(unauthorized());
    endif;
else:
    header("Location: ../index.php");
endif;
?>
