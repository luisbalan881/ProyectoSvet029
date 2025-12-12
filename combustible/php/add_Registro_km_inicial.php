<?php
require_once '../../inc/functions.php';
require_once '../../inc/User.php';

$lugares=$_POST['lugar'];  // lugares
$vehiculo=$_POST['n'];  // vehiculo_id
$motivo=$_POST['motivo'];  // A;o del sistema
$status="1";
$status2="2";  // nota para validar que ya hayan registrado km final
$id=$_POST['id'];   // persona peticion 
$persona = User::get_empleado_datos_id($id);

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ultimo registro id de bitacora de vehiculo




$sql0= "SELECT MAX(id_bitacora)+1 as bitacora_id FROM vp_bitacora_vehiculo ";// quitar eststus
$p0 = $pdo->prepare($sql0);
$p0->execute(array($status2));
$per_rol0 = $p0->fetch(PDO::FETCH_ASSOC);
    $id1 = $per_rol0['bitacora_id']; //ultima solicitud dada de vehiculo

//

// seleciona  ultima solicitud de cupon dado a vehiculo por id
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql1= "SELECT MAX(vp_solicitud_cupon.solicitud_id) as id FROM vp_solicitud_cupon
join vp_solicitud_cupon_vehiculo
on vp_solicitud_cupon.solicitud_id = vp_solicitud_cupon_vehiculo.solicitud_id
where vp_solicitud_cupon.year=2020 AND vp_solicitud_cupon_vehiculo.vehiculo_id=? AND vp_solicitud_cupon.estado_solicitud=2";
$p1 = $pdo->prepare($sql1);
$p1->execute(array($vehiculo));
$per_rol = $p1->fetch(PDO::FETCH_ASSOC);
    $solicitud_id = $per_rol['id']; //ultima solicitud dada de vehiculo
//
   
//consulta ultimo kilimetraje registrado de vehicuylo
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql2= "SELECT max(km_final) as kmf from vp_bitacora_vehiculo where vehiculo_id=?";
$p2 = $pdo->prepare($sql2);
$p2->execute(array($vehiculo));
$per_rol2 = $p2->fetch(PDO::FETCH_ASSOC);
    $km_fin = $per_rol2['kmf']; //ultima solicitud dada de vehiculo
  
//query $pdo = Database::connect();
//
//SELECT max(km_final) kmi from vp_bitacora_vehiculo where vehiculo_id = 
//if ($solicitud_id)  verificar si existe los cupones
    
    if ($solicitud_id != NULL and $km_fin != NULL )  /// ojo validar esto no funciona
	{
   // echo "Variable definida!!!";
	
    

//insertar a tabla
$sql = "INSERT INTO  vp_bitacora_vehiculo (id_bitacora, Destino, vehiculo_id,id_user,id_solicitud,km_inicial,status,motivo) VALUES (?,?,?,?,?,?,?,?)";

$q = $pdo->prepare($sql);
$q->execute(array($id1,$lugares,$vehiculo,$id,$solicitud_id,$km_fin,$status,$motivo));
$Id = $pdo->lastInsertId();
Database::disconnect();
echo $Id;
}else
		{
		echo "Variable NO definida!!!";
		}
    
 ?>
