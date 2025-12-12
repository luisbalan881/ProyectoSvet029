<?php

require_once '../../inc/functions.php';
require_once '../../inc/User.php';

sec_session_start();

$solicitud=$_POST['solicitud'];
$fecha=$_POST['fecha'];
$date1 = date('Y-m-d', strtotime($fecha));
$salida=$_POST['salida'];
$duracion=$_POST['duracion'];
$especificacion=$_POST['especificacion'];
$cantidad=$_POST['cantidad'];
$desc='';

$id=$_SESSION['user_id'];
$persona = User::get_empleado_datos_id($id);
//$dep=$_POST['dep'];


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if($_POST['desc']!=''){
  $desc=' - - - '. $_POST['desc'];
}


$sql = "UPDATE vp_solicitud_transporte SET fecha_solicitud=?,
        hora_salida=?,duracion=?,tipo_duracion=?,cantidad_personas=?,
        soli_desc=CONCAT(soli_desc,?)
        WHERE solicitud_id=?";
$q = $pdo->prepare($sql);
$q->execute(array($date1,$salida,$duracion,$especificacion,$cantidad,$desc,$solicitud));

Database::disconnect();


 ?>
