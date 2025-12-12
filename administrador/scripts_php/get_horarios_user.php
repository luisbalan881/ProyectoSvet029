<?php
require_once '../../inc/Database.php';


$mes = ($_POST["mm"]);
$year = ($_POST["yy"]);
$em = ($_POST["em"]);





$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT t4.user_vid, CONCAT(t4.user_nm1, ' ', t4.user_nm2, ' ', t4.user_ap1, ' ' , t4.user_ap2) as NOMBRE,
        t1.fecha_laboral , t1.hora_en AS F_INI, t1.hora_sal AS F_FIN,
        t1.tipo_dia_laboral AS LABOR,
        concat( MOD(HOUR(TIMEDIFF((t1.hora_en), (t1.hora_sal))), 24),
        ' : ', MINUTE(TIMEDIFF((t1.hora_en), (t1.hora_sal))), ' ') as HORAS
        FROM vp_user_horario_general t1
        INNER JOIN vp_user t4 ON t1.user_vid = t4.user_vid
        INNER JOIN vp_catalogo_dia_laboral t3 ON t1.tipo_dia_laboral = t3.dia_laboral_id
        INNER JOIN vp_user_horario AS T5 ON t1.user_vid = T5.user_id_huella
        WHERE MONTH(t1.fecha_laboral) = ? AND YEAR(t1.fecha_laboral) = ? AND t1.user_vid = ?
        GROUP BY t1.fecha_laboral, t1.user_vid
        ORDER BY t1.user_vid, t1.fecha_laboral ASC";

$p = $pdo->prepare($sql);
$p->execute(array($mes, $year,$em));
$persona = $p->fetchAll();
Database::disconnect();



   //Si la extensión que mencioné está instalada, usamos esa.

      //Lo hacemos a mi manera.


  echo '    <thead >
          <tr>

             <th class="text-center" >Dia</th>
              <th class="text-center" >Fecha</th>
              <th class="text-center" >Control</th>
              <th class="text-center">Entrada</th>
              <th class="text-center">Salida</th>
              <th class="text-center">Horas laboradas</th>



          </tr>
      </thead>
      <tbody>';


              foreach ($persona as $p){
                echo $p['NOMBRE'];
                $fech = "'".$p['fecha_laboral']."'";
                $dia = date('l',$p['FECHA']);

                  echo '<tr '.(($p['LABOR'] == 'Ausente')?'class="warning"':'"class="warning"').'>';
                  //echo '<td class="text-center">'.$p['NOMBRE'].'</td>';
                  echo '<td class="text-center">'.get_nombre_dia($p['fecha_laboral']).'</td>';
                  echo '<td class="text-center">'.$p['fecha_laboral'].'</td>';
                  echo '<td class="text-center">';
                                    if($p['LABOR'] == '0'){ echo '<span class="label label-danger">Ausente</span>
                                      <span data-toggle="tooltip" title="Ver Horarios"><a class="label label-warning outline"  title="Ver Horarios"
                                              onclick="load_modal('.$p['user_vid'].', '.$fech.')" ><i class="fa fa-pencil-square-o"></i> Editar</a></span>

                                      ';

                                    }
                                    else if($p['LABOR'] == '1'){ echo '<span class="label label-success" disabled></span>';}
                                    else if($p['LABOR'] == '2'){ echo '<span class="label label-warning">Permiso</span>';}
                                    else if($p['LABOR'] == '3'){ echo '<span class="label label-success" disabled>Feriado</span>';}
                                    else if($p['LABOR'] == '4'){ echo '<span class="label label-info">No Laboraba</span>';}
                                    else if($p['LABOR'] == '6'){ echo '<span class="label label-success">Vacaciones</span>';}
                                    else if($p['LABOR'] == '7'){ echo '<span class="label label-warning"><i class="fa fa-hand-o-up"/>  Aún no marcaba</span>';}
                                    else if($p['LABOR'] == '5'){ echo '<span class="label label-primary"><i class="fa fa-heartbeat"/> -   Suspendido IGSS</span';}

                  echo'</td>';
                  echo '<td class="text-center">'.$p['F_INI'].'</td>';
                  echo '<td class="text-center">'.$p['F_FIN'].'</td>';
                  echo '<td class="text-center">'.$p['HORAS'].'</td>';
                  /*echo '<td class="text-center">'.(($p['E'] == '0')? '<span class="label label-danger">Llegó Tarde</span>':'<span class="label label-info"></span>').'</td>';
                  echo '<td class="text-center">'.(($p['S'] == '1')? '<span class="label label-danger">Se fue temprano</span>':'<span class="label label-info"></span>').'</td>';*/

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
