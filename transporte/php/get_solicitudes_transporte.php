<?php

require_once '../../inc/Database.php';




$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT LPAD(T1.solicitud_id, 8,'0') AS IDX, T1.solicitud_id as ID, T1.fecha_solicitud AS FECHA,
T1.hora_salida AS SALIDA, T1.duracion AS DURACION,T1.tipo_duracion AS TIPO_D,T1.cantidad_personas AS CANT,
CONCAT(T2.user_nm1, ' ', T2.user_nm2, ' ', T2.user_ap1, ' ', T2.user_ap2) as NOMBRE, T2.ext_id AS EXT,
T1.autorizacion_id AS ID_JEFE,T1.status_solicitud AS STATUS_SOL, T1.entregado_por_id AS ENTREGADO_POR,
T1.destino AS DESTINO, T1.motivo AS MOTIVO, T1.status_tiempo_finalizado AS FINALIZADO
FROM vp_solicitud_transporte T1 INNER JOIN
vp_user T2 on T1.solicitante_id=T2.user_id ORDER BY status_tiempo_finalizado";

$p = $pdo->prepare($sql);
$p->execute();
$solicitudes = $p->fetchAll();
Database::disconnect();



   //Si la extensión que mencioné está instalada, usamos esa.

      //Lo hacemos a mi manera.


  echo '    <thead >
          <tr>
              <th class="text-center">Solicitud</th>';
            // <th class="text-center" >Dia</th>
  echo '            <th class="text-center" >Fecha</th>
              <th class="text-center" >Salida</th>
              <th class="text-center">Duración</th>
              <th class="text-center">No. Personas</th>
              <th class="text-center">Solicitante</th>
              <th class="text-center">Ext.</th>
              <th class="text-center">Status</th>';
            // <th class="text-center" >Dia</th>
            //<th class="text-center">Destino</th>
            //<th class="text-center">motivo</th>
  echo '


              <th class="text-center">Finalizado</th>
              <th class="text-center">Acción</th>




          </tr>
      </thead>
      <tbody>';


              foreach ($solicitudes as $s){

                  echo '<tr '.(($s['STATUS_SOL'] == 0)?'class="warning"':'"class="warning"').'>';
                  //echo '<td class="text-center">'.$p['NOMBRE'].'</td>';
                  echo '<td class="text-center">'.$s['IDX'].'</td>';
                  //echo '<td class="text-center">'.get_nombre_dia($s['FECHA']).'</td>';
                  echo '<td class="text-center">'.date('d-m-Y', strtotime($s['FECHA'])).'</td>';
                  echo '<td class="text-center">'.$s['SALIDA'].'</td>';
                  echo '<td class="text-center">'.$s['DURACION'].' ';
                  if($s['TIPO_D'] == 1){
                    echo  ' Hora(s)</td>';
                  }else {
                    echo  ' Dia(s)</td>';
                  }

                  echo '<td class="text-center">'.$s['CANT'].'</td>';
                  echo '<td class="text-center">'.$s['NOMBRE'].'</td>';
                  echo '<td class="text-center">'.$s['EXT'].'</td>';
                  echo '<td class="text-center">';
                  if($s['STATUS_SOL']==0)
                  {
                    echo '<span class="label label-warning">Pendiente</span> </td>';
                  }
                  else if($s['STATUS_SOL']==1){
                    echo '<span class="label label-success">Aprobado</span> </td>';
                  }
                  else if($s['STATUS_SOL']==2){
                    echo '<span class="label label-danger">Cancelado</span> </td>';
                  }

                  //echo '<td class="text-center">'.$s['DESTINO'].'</td>';
                  //echo '<td class="text-center">'.$s['MOTIVO'].'</td>';

                  echo '<td class="text-center">';
                  if($s['FINALIZADO']==0)
                  {
                    echo '<span class="label label-warning">Sin Vehículo</span> </td>';
                  }
                  else if($s['FINALIZADO']==1){
                    echo '<span class="label label-primary">En curso</span> </td>';
                  }
                  else if($s['FINALIZADO']==2){
                    echo '<span class="label label-success">Finalizado</span> </td>';
                  }
                  else if($s['FINALIZADO']==3){
                    echo '<span class="label label-danger">Cancelado</span> </td>';
                  }

                      echo '<td class="text-center" style="white-space: nowrap;">';

                      echo '<span title="Editar"><a class="btn btn-warning outline"  title="Actualizar" onclick="load_solicitud_by_id('.$s['ID'].')" ><i class="fa fa-pencil-square-o "></i></a></span>';

                      echo '</td>';





                  echo '</tr>';
              }

    echo '  </tbody>';


    function get_nombre_dia($fecha){
    $fechats = strtotime($fecha); //pasamos a timestamp

    //el parametro w en la funcion date indica que queremos el dia de la semana
    //lo devuelve en numero 0 domingo, 1 lunes,....
    switch (date('w', $fechats)){
    case 0: return "Domingo"; break;
    case 1: return "Lunes"; break;
    case 2: return "Martes"; break;
    case 3: return "Miercoles"; break;
    case 4: return "Jueves"; break;
    case 5: return "Viernes"; break;
    case 6: return "Sabado"; break;
    }
    }








?>
