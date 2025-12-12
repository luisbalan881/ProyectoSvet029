<?php
include_once '../inc/functions.php';
include_once 'funciones_proveedores.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearProveedor') || usuarioPrivilegiado()->hasPrivilege('modificarProveedor')):
        $prov_nit = $_GET['prov_nit'];
        $prov_id = 0;
        if(!empty($_GET['prov_id'])){
            if($_GET['prov_id'] != 'undefined'){
                $prov_id = $_REQUEST['prov_id'];
            }
        }
        $duplicado = proveedor_duplicado($prov_nit,$prov_id);
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