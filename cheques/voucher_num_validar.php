<?php
include_once '../inc/functions.php';
include_once 'funciones_cheques.php';
include_once 'inc/Voucher.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearCheques') || usuarioPrivilegiado()->hasPrivilege('modificarCheques')) :
        $validar_num = $_GET['vchr_num'];
        $id = 0;
        if(isset($_GET['vchr_id'])){
            if($_GET['vchr_id'] != 'undefined'){
                $id = $_REQUEST['vchr_id'];
            }
        }
        $duplicado = Voucher::duplicadoVoucherNum(usuarioPrivilegiado(),$validar_num,$id);
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
