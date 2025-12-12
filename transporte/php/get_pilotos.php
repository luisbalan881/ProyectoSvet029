<?php

require_once '../../inc/functions.php';
$combustible = array(1 => 'Gasolina', 2 => 'Diesel');

function get_pilotos(){

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT T1.conductor_id,T1.user_id,T1.licencia_num,T1.licencia_cad,T1.status,T1.rev,
        CONCAT(T2.user_nm1, ' ', T2.user_nm2, ' ', T2.user_ap1,' ', T2.user_ap2)AS NOMBRE,
        T3.dep_nm
        FROM vp_conductor AS T1
        INNER JOIN vp_user AS T2 ON T1.user_id=T2.user_id
        INNER JOIN vp_deptos AS T3 ON T1.dep_id=T3.dep_id
        ORDER BY T1.conductor_id ASC";

$p = $pdo->prepare($sql);
$p->execute();
$drivers = $p->fetchAll();
Database::disconnect();

return $drivers;
}

$drivers = get_pilotos();

   //Si la extensión que mencioné está instalada, usamos esa.

      //Lo hacemos a mi manera.


  echo '    <thead >
          <tr>


              <th class="text-center" >Conductor</th>
              <th class="text-center" >Licencia num</th>
              <th class="text-center">Licencia venc.</th>
              <th class="text-center">Estado</th>
              <th class="text-center">Departamento</th>

              <th class="text-center">ACCIONES';

              echo '  <span id="" title="Agregar nuevo conductor" class="btn-add" type="button" data-toggle="modal" data-target="#modal-remoto" href="transporte/nuevo_piloto.php" style="margin-top:-18px;margin-right:-18px;" ></span>';


              echo '</th>

          </tr>
      </thead>
      <tbody>';


              foreach ($drivers as $driver){

                  echo '<tr '.(($driver['status'] == 0)?'class="warning"':'"class="warning"').'>';
                  //echo '<td class="text-center">'.$p['NOMBRE'].'</td>';


                  echo '<td class="text-center" style="white-space: nowrap;">'.$driver['NOMBRE'].'</td>';
                  echo '<td class="text-center" style="white-space: nowrap;">'.$driver['licencia_num'].'</td>';
                  echo '<td class="text-center" style="white-space: nowrap;">'.fecha_dmy($driver['licencia_cad']).'</td>';
                  echo '<td class="text-center">'.$driver['status'].'</td>';
                  echo '<td class="text-center">'.$driver['dep_nm'].'</td>';

                    echo '<td class="text-center">';
                    echo '';
                    echo '';
                    echo '';
                    echo '<div class="btn-group btn-group-sm" role="group">
                          <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                          <div class="btn-group mr-2" role="group" aria-label="Second group">
                            <button  title="Control Vehículo" class="btn btn-personalizado outline" ><i class="fa fa-gear"></i></button>
                            <button  title="Editar Vehículo" class="btn btn-personalizado outline"  data-toggle="modal" data-target="#modal-remoto" href="transporte/modificar_piloto.php?conductor_id='.$driver['user_id'].'"><i class="fa fa-pencil"></i></button>
                            <button  title="Ver Comisión" class="btn btn-personalizado outline"   title="Descargar" disabled onclick(alert("hola"))';
                            echo ' ><i class="fa fa-check"></i></button>
                          </div>
                        </div>

                    </div>';
                    echo'</td>';





                  echo '</tr>';
              }

    echo '  </tbody>';









?>
