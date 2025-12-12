<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearAlmacen') || usuarioPrivilegiado()->hasPrivilege('modificarAlmacen')) :
        $validar_req = $_GET['req_num'];
        $id = 0;
        if(isset($_GET['req_id'])){
            if($_GET['req_id'] != 'undefined'){
                $id = $_REQUEST['req_id'];
            }
        }
        $duplicado = FALSE;
        foreach (requisiciones() as $requisicion){
            $req_id = $requisicion['req_id'];
            $req_num = $requisicion['req_num'];
            if ($req_num == $validar_req &&  $req_id != $id){
                $duplicado=TRUE;
            }
        }
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
    header("Location: ../index.php");
endif;
?>

