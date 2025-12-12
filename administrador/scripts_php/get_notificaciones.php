<?php

require_once '../../inc/Database.php';

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT user_id, user_nm1, user_nm2, user_ap1, user_ap2, verificacion
FROM vp_user where verificacion = 0 OR verificacion = 2";

$p = $pdo->prepare($sql);
$p->execute(array());
$notify = $p->fetchAll();
Database::disconnect();


foreach ($notify as $n){
echo '<li style="list-style:none">
<span title="Editar">
<a  data-toggle="modal" data-target="#modal-remoto" href="../herramientas/usuarios/usuario_modificar.php?id='.$n['user_id'].'">
     <strong>'.$n["user_nm1"]. ' '.$n["user_nm2"].' '.$n["user_ap1"].' '.$n["user_ap2"].'</strong><br />
     <small><em>
     ';

     if($n["verificacion"]==0)
     {
       echo 'Empleado nuevo';
     }
     else if($n['verificacion']==2){
       echo 'Empleado desactivado';
     }

     echo'</em></small>
</a>
</span>
   </li>
   <br>
   ';
}


?>
