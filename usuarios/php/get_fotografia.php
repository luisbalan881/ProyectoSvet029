<?php
require_once '../../inc/functions.php';
$id=$_POST['emp'];
$c = $_POST['correlativo'];
$persona = User::get_empleado_datos_id_por_correlativo($id,$c);


$return_arr = array(

                  
                    'foto'=>$persona['fotografia']
                  );

echo json_encode($return_arr);
?>
