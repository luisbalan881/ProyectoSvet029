<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
include_once 'funciones.php';
include_once 'get_solicitud.php';

sec_session_start();
$u = usuarioPrivilegiado();
if (function_exists('login_check') && login_check() == true) :
    if ($u->hasPrivilege('autorizarSolicitudTransporte') ) :


$id=$_POST['id'];

$cars = get_carros_por_solicitud_transporte($id);


?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Solicitar Transporte</title>

</head>

<body>

  <div class="">
      <ul class="block-options2" style="margin-top:-64px;margin-right:-2px">
          <li>
              <button onclick="load_solicitud_id(<?php echo $id?>)" type="button" ><i class="btn-regresar"></i></button>
          </li>
      </ul>


  </div>



      <div  class=" form-horizontal " >
        <table class="table">
        <thead>
          <th class="text-center">Placa</th>
          <th class="text-center">Marca</th>
          <th class="text-center">Tipo</th>
          <th class="text-center">Linea</th>
          <th class="text-center">Piloto</th>
          <th class="text-center">Estado</th>
          <th class="text-center">Acción</th>

        </thead>

<?php
foreach($cars as $car)
{
  ?>
  <tr>
    <td class="text-center"><?php echo $car['placa'] ?> </td>
    <td class="text-center"><?php echo $car['nombre'] ?></td>
    <td class="text-center"><?php echo $tipo_vehiculo[$car['tipo']] ?></td>
    <td class="text-center"><?php echo $car['linea'] ?></td>
    <td class="text-center"><?php echo $car['CONDUCTOR'] ?></td>
    <td class="text-center"><span class="label <?php if($car['estado_entregado']==0){echo 'label-warning';}
                                 else if($car['estado_entregado']==1){echo 'label-success';}
                                 else if($car['estado_entregado']==3){echo 'label-danger';}?> ">
    <?php if($car['estado_entregado']==0){echo 'Pendiente';}
          else if($car['estado_entregado']==1){echo 'Entregado';}
          else if($car['estado_entregado']==3){echo 'Cancelado';}?></span>
    <td class="text-center">

      <?php
      $ver = verificar_vehiculo_entregado($id,$car['vehiculo_id'], $car['fecha_asignado']);
      echo '<button title="Cancelar este Vehículo" class="btn btn-personalizado outline"';
      if($ver['estado_entregado']==1){
        echo 'disabled';
      }else
        if($ver['estado_entregado']==2){
          echo 'disabled';
        }
        else
          if($ver['estado_entregado']==3){
            echo 'disabled';
          }
      else{
        echo 'onclick="cancelar_vehiculo_solicitud('.$id.','.$car['vehiculo_id'].')"';
      }
      echo '><i class="fa fa-times"></i></button>';
      ?>

    </td>
  </tr>




  <?php

}
?>
</table>
</div>
</body>


</html>

<?php
else :
    echo include(unauthorizedModal());
endif;
else:
//echo "<script type='text/javascript'> window.location='../index.ph'; </script>";
endif;
?>
