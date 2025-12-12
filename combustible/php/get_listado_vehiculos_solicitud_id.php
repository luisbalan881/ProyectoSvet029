<?php
include_once '../../inc/functions.php';

sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('leerCupon')):

      include_once 'funciones.php';


$year=$_POST['year'];
$mes=$_POST['mes'];
$m = "'".$mes."'";
$solicitud=$_POST['solicitud'];
$dep_id=$_POST['dep_id'];

$cadena = $year.'/'.$m.'/'.$solicitud.'/'.$dep_id;

$vehiculos = get_carros_por_solicitud($year,$mes,$solicitud,$dep_id);
$fecha = get_fecha_autorizado_por_solicitud_by_id($year,$mes,$solicitud,$dep_id);
$estado= get_estado_solicitud($year,$mes,$solicitud,$dep_id);
$total_pendientes = 0;

foreach ($vehiculos as $v):

  if ($v['estado_solicitud'] == 0){ $total_pendientes++;}

endforeach;


echo '<table class="table dt-responsive display nowrap" cellspacing="0" width="100%" id="tb_solicitar_cupones">
  <thead >
          <tr>
              <th class="text-center">PLACA</th>
              <th class="text-center" >MARCA</th>
              <th class="text-center" >LINEA</th>

              <th class="text-center">MODELO</th>
              <th class="text-center">CILINDROS</th>
              <th class="text-center">COMBUSTIBLE</th>


              <th class="text-center">CUPONES A:</th>
              <th class="text-center">MONTO</th>
              <th class="text-center">ACCIÓN</th>


          </tr>
      </thead>
      <tbody>';


              foreach ($vehiculos as $vehiculo){

                  echo '<tr id="tr'.$vehiculo['vehiculo_id'].'">';
                  //echo '<td class="text-center">'.$p['NOMBRE'].'</td>';
                  echo '<td class="text-center" ><strong>'.$vehiculo['placa'].'</strong></td>';
                  echo '<td class="text-center" >'.$vehiculo['nombre'].'</td>';
                  echo '<td class="text-center" >'.$vehiculo['linea'].'</td>';

                  echo '<td class="text-center">'.$vehiculo['modelo'].'</td>';
                  echo '<td class="text-center">'.$vehiculo['cilindraje'].'</td>';
                  echo '<td class="text-center">'.$combustible[$vehiculo['combustible_id']].'</td>';


                    echo '<td class="text-center " >'.$vehiculo['NOMBRE'].'</td>';
                    echo '<td class="text-center">';
                    if($estado['estado_solicitud']==0 && permiso_perm(1))
                    {
                      ?>
                      <a data-name="<?php echo $vehiculo['vehiculo_id'].'/'.$vehiculo['monto']?>" class="monto_solicitado" data-type="select" data-pk="<?php echo $cadena?>" data-title="Actualizar monto"><?php echo $vehiculo['monto']?></a>

                    <?php
                    }
                    else
                    {
                      echo '<strong>Q. '.$vehiculo['monto'].'</strong>';
                    }
                    echo '</td>';
                    echo '<td class="text-center">';
                    echo '<div class="btn-group btn-group-sm" role="group">
                      <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                      <div class="btn-group mr-2" role="group" aria-label="Second group">';

                        echo '<button  class="btn btn-personalizado outline"  title="Asignar Cupones"
                        onclick="get_solicitud_vehiculo_by_id('.$year.','.$m.','.$solicitud.','.$vehiculo['vehiculo_id'].','.$vehiculo['dep_id'].')" ><i class="fa fa-ticket"></i></button>';
                        /*<button  title="Generar Informe" class="btn btn-personalizado outline"  title="Cancelar" ';

                        if($vehiculo['estado_solicitud']==1)
                        {
                          echo 'disabled';
                        }
                        else{
                          echo 'onclick=""';
                        }

                        echo '><i class="fa fa-times"></i></button>';*/

                      echo '</div>
                    </div>

                    </div>';
                    echo '<span id="regresar"';
                    if($vehiculo['estado_solicitud']==1)
                    {
                      echo 'class="btn-checkk"';
                    }
                     echo' ></span>' ;

                    echo '</td>';









                  echo '</tr>';
              }

    echo '  </tbody>';

echo '</table>';

if($total_pendientes==0 && $fecha['fecha_autorizado']=='0000-00-00' && permiso_perm(4) && usuarioPrivilegiado()->hasPrivilege('crearCupon') || ($total_pendientes==0 && $fecha['fecha_autorizado']=='0000-00-00' && usuarioPrivilegiado()->hasPrivilege('Configuracion')))
{
  echo '<div class="btn-group btn-group-sm text-right" style="float-right" role="group>
  <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
  <div class="btn-group mr-2" role="group" aria-label="Second group">';
  echo '<button  class="btn btn-success btn-sm text-right"  title="Autorizar Fecha" onclick="asignar_fecha_autorizada('.$year.','.$m.','.$solicitud.','.$dep_id.')"    ><i id="au_fecha" class="fa fa-check"></i> Asignar fecha autorización</button>';

  echo '</div></div></div><p>';
}
else {
  # code...
}

if($estado['estado_solicitud']==0 && permiso_perm(1)):

?>
<script>

$('.monto_solicitado').editable({

  url: 'combustible/php/update_monto_solicitud_vehiculo_id.php',
  type: 'POST',

  validate: function(value){
    if($.trim(value) == '')
    {
      return 'El valor no puede ser vacío';
    }
  },
  source: options
});


</script>

<?php
endif;

else:
    echo include(unauthorized());
endif;
else:
header("Location: ../index.php");
endif;

?>
