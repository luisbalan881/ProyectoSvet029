<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
include_once 'funciones.php';
include_once '../../transporte/php/funciones.php';
sec_session_start();
$year=$_POST['year'];
$mes=$_POST['mes'];
$m = "'".$mes."'";
$solicitud=$_POST['solicitud_id'];
$dep_id=$_POST['dep_id'];
$estado_solicitud=$_POST['estado'];
$comision_status=$_POST['status'];
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$comisiones=get_comision_by_solicitud_id($year,$mes,$solicitud,$dep_id);

$conteo = 0;

foreach ($comisiones as $s):
  $conteo++;
endforeach;

if($conteo > 0)
{

           foreach ($comisiones as $c){

             echo '<div class="tickets-container">
               <ul class="tickets-list">
                   <li class="ticket-item">
                       <div class="row">
                       <div class="ticket-time col-md-2 col-sm-12  col-xs-12">
                           <i class="fa fa-file"></i>
                           <span>  '.$c['IDX'].'</span>
                       </div>
                           <div class="ticket-time col-md-4 col-sm-12  col-xs-12">
                           <div class="divider hidden-md hidden-sm hidden-xs"></div>
                               <i class="fa fa-map-marker"></i>
                               <span>  '.$c['destino'].'</span>
                           </div>
                           <div class="ticket-time  col-md-6 col-sm-12 col-xs-12">
                               <div class="divider hidden-md hidden-sm hidden-xs"></div>
                               <textarea >'.$c['motivo'].'</textarea >
                           </div>

                           ';
                           echo '<div class="ticket-state ';
                           if($c['status']==1)
                           {
                             echo 'bg-palegreen';
                           }
                           else{
                             echo 'bg-palered';
                           }

                           echo '">
                               <i class="fa fa-check"></i>
                           </div>';

                       echo '
                       </div>
                   </li>
                 </ul>
               </div>
';

           }

           if($estado_solicitud==0)
           {
             echo '<br>';
             echo '<p>Agregar Solicitud de transporte a esta Solicitud de Cupones';
             echo'<span id="regresar" title="Agregar Comision a solicitud" onclick="agregar_comision_solicitud('.$year.','.$m.','.$solicitud.','.$dep_id.','.$estado_solicitud.','.$comision_status.')" class="btn-add" style="margin-top:-5px;margin-right:0px;"></span>';
           }
           else if($estado_solicitud==1 || $estado_solicitud == 2  || $estado_solicitud == 3){
             echo '<br>';
               echo '<p>Ya no se pueden agregar mas solicitudes de transporte</p>';


           }
}
else {


  if($estado_solicitud==0)
  {
    echo '<p>Esta solicitud no ha sido establecida como Vicepresidencial';
    echo'<span id="regresar" title="Agregar Comision a solicitud" onclick="agregar_comision_solicitud('.$year.','.$m.','.$solicitud.','.$dep_id.','.$estado_solicitud.','.$comision_status.')" class="btn-add" style="margin-top:-5px;margin-right:0px;"></span>';
    echo '</p>';
  }
  else if($estado_solicitud==1 || $estado_solicitud == 2  || $estado_solicitud == 3){

      echo '<p>Esta solicitud ya no se puede establecer como comisión</p>';


  }
}

?>
