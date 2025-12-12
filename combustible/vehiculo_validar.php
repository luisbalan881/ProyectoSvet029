<?php
include_once '../inc/functions.php';
include_once 'inc/Vehicle.php';
include_once 'funciones_cupones.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearCupon') || usuarioPrivilegiado()->hasPrivilege('modificarCupon')):
        $placa = $_GET['placa'];
        $vehiculo_id = 0;
        if(!empty($_GET['vehiculo_id'])){
            if($_GET['vehiculo_id'] != 'undefined'){
                $vehiculo_id = $_REQUEST['vehiculo_id'];
            }
        }
        $vehiculos = Vehicle::getAll(usuarioPrivilegiado());
        $duplicado = false;
        foreach ($vehiculos as $vehiculo){
            if (strpos(strtoupper($vehiculo['placa']),strtoupper($placa)) !== false || strtoupper($placa) == strtoupper($vehiculo['placa']) && $vehiculo['vehiculo_id'] != $vehiculo_id){
                $duplicado=true;
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
