<?php

require_once '../../inc/Database.php';
$combustible = array(1 => 'Gasolina', 2 => 'Diesel');
$tipo_vehiculo = array(1 => 'Camioneta', 2 => 'Vehículo',3=>'Pick up',4=>'Microbus',5=>'Motocicleta');

function get_carros(){

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT vehiculo_id,nombre,linea,placa,modelo,tipo,
cilindraje,combustible_id,color,status,user_id, vice_id, capacidad, status_uso, comision_id
FROM vp_vehiculo WHERE vice_id=1 ORDER BY placa ASC, vehiculo_id ASC";

$p = $pdo->prepare($sql);
$p->execute();
$vehiculos = $p->fetchAll();
Database::disconnect();

return $vehiculos;
}

$vehiculos = get_carros();

   //Si la extensión que mencioné está instalada, usamos esa.

      //Lo hacemos a mi manera.


  echo '    <thead >
          <tr>
          <th class="text-center">TIPO</th>
              <th class="text-center" >MARCA</th>
              <th class="text-center" >LINEA</th>
              <th class="text-center">PLACA</th>
              <th class="text-center">MODELO</th>

              <th class="text-center">CILINDROS</th>
              <th class="text-center">COMBUSTIBLE</th>
              <th class="text-center">COLOR</th>

              <th class="text-center">ESTADO</th>
              <th class="text-center">ACCIONES';

              echo '  <span id="" title="Agregar nuevo vehículo" class="btn-add" type="button" data-toggle="modal" data-target="#modal-remoto" href="transporte/nuevo_vehiculo.php" style="margin-top:-18px;margin-right:-18px;" ></span>';


              echo '</th>

          </tr>
      </thead>
      <tbody>';


              foreach ($vehiculos as $vehiculo){

                  echo '<tr '.(($vehiculo['status_uso'] == 1)?'class="warning"':'"class="warning"').'>';
                  //echo '<td class="text-center">'.$p['NOMBRE'].'</td>';
                  echo '<td class="text-center">'.$tipo_vehiculo[$vehiculo['tipo']].'</td>';

                  echo '<td class="text-center" style="white-space: nowrap;">'.$vehiculo['nombre'].'</td>';
                  echo '<td class="text-center" style="white-space: nowrap;">'.$vehiculo['linea'].'</td>';
                  echo '<td class="text-center" style="white-space: nowrap;">'.$vehiculo['placa'].'</td>';
                  echo '<td class="text-center">'.$vehiculo['modelo'].'</td>';

                  echo '<td class="text-center">'.$vehiculo['cilindraje'].'</td>';
                  echo '<td class="text-center">'.$combustible[$vehiculo['combustible_id']].'</td>';
                  echo '<td class="text-center">'.$vehiculo['color'].'</td>';

                    echo '<td class="text-center">';
                    if($vehiculo['status_uso']==0)
                    {
                      echo '<span class="label label-success">Disponible</span>';
                    }
                    else if($vehiculo['status_uso']==1){
                      echo '<span class="label label-danger">En Comisión</span>';
                    }
                    else if($vehiculo['status_uso']==2){
                      echo '<span class="label label-secondary">En Reparación</span>';
                    }
                    else if($vehiculo['status_uso']==3){
                      echo '<span class="label label-secondary">En Mantenimiento</span>';
                    }
                    else if($vehiculo['status_uso']==4){
                      echo '<span class="label label-danger">De baja</span>';
                    }
                    echo '</td>';
                    echo '<td class="text-center">';
                    echo '';
                    echo '';
                    echo '';
                    echo '<div class="btn-group btn-group-sm" role="group">
                          <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                          <div class="btn-group mr-2" role="group" aria-label="Second group">
                            <button  title="Control Vehículo" class="btn btn-personalizado outline" ><i class="fa fa-gear"></i></button>
                            <button  title="Editar Vehículo" class="btn btn-personalizado outline" data-toggle="modal" data-target="#modal-remoto" href="transporte/modificar_vehiculo.php?vehiculo_id='.$vehiculo['vehiculo_id'].'"><i class="fa fa-pencil"></i></button>
                            <button  title="Ver Comisión" class="btn btn-personalizado outline" ';
                            if($vehiculo['comision_id'] != 0)
                            {
                              echo '  title="Descargar"';
                            }
                            else {
                              echo 'disabled onclick(alert("hola"))';
                            }
                            echo ' ><i class="fa fa-check"></i></button>
                          </div>
                        </div>

                    </div>';
                    echo'</td>';





                  echo '</tr>';
              }

    echo '  </tbody>';









?>
