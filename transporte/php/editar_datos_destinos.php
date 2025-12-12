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

$d_m = get_destinos_motivos_por_solicitud_transporte($id);
$solicitud = get_solicitud_by_id($id);
$conteo2 = verificar_vehiculo_asignado($id);
$veri_devueltos = verificar_vehiculo_devueltos($id);


?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Solicitar Transporte</title>
    <link href="assets/js/plugins/x-editable/bootstrap-editable.css" rel="stylesheet"/>
    <script src="assets/js/plugins/x-editable/bootstrap-editable.min.js"></script>

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
          <th class="text-center">Destino</th>
          <th class="text-center">Motivo</th>

          <th class="text-center">Estado</th>
          <th class="text-center">Acción</th>
        </thead>
<tbody  id="table_destinos_motivos">
<?php
foreach($d_m as $dm)
{
  ?>
  <tr>
    <td  class="text-center"><a data-name="<?php echo $dm['correlativo'] ?>" class="destino" data-type="text" data-pk="<?php echo $id?>" data-title="Actualizar Destino"><?php echo $dm['destino'] ?></a></td>
    <td class="text-center"><a data-name="<?php echo $dm['correlativo'] ?>" class="motivo" data-type="textarea" data-pk="<?php echo $id?>" data-title="Actualizar Motivo"><?php echo $dm['motivo']?></a></td>
    <td class="text-center"><span class="label <?php if($dm['status']==1){echo 'label-success';}else if($dm['status']==0){echo 'label-danger';}?> ">
    <?php if($dm['status']==1){echo 'Autorizada';}else if($dm['status']==0){echo 'Cancelado';}?></span>
    <td class="text-center">
      <?php echo '<button class="btn btn-personalizado outline"';
      if($solicitud['FINALIZADO']==0 || $solicitud['FINALIZADO']==2 || $solicitud['FINALIZADO']==3 || ($conteo2-$veri_devueltos)>0 && $dm['status']==1){
        echo 'onclick=eliminar_destino_motivo('.$id.','.$dm['correlativo'].')';
      } else if($dm['status']==0){ echo 'disabled';}

      echo '><i class="fa fa-times"></i></button>';

      ?>

    </td>

  </tr>




  <?php

}
?>
<tr><td colspan="4" style="border-bottom:1px solid transparent"></td></tr>
<tr><td colspan="4" style="border-bottom:1px solid transparent">Agregar otro destino y motivo</td></tr>
<tr id="new_row" >
 <td><input class="form-control" type="text" id="new_name"></td>
 <td  colspan="2"><input class="form-control" type="text" id="new_age"></td>

 <td class="text-center"><span class="btn-add"type="button"onclick=""></span></td>
</tr>
</tbody>
</table>
</div>
</body>

<script type="text/javascript">
    $('.destino').editable({

      url: 'transporte/php/update_contenido_destino.php',
      type: 'POST',
      title: 'Actualizar información',
      validate: function(value){
        if($.trim(value) == '')
        {
          return 'El valor no puede ser vacío';
        }
      }
    });

    $('.motivo').editable({

      url: 'transporte/php/update_contenido_motivo.php',
      type: 'POST',
      title: 'Actualizar información',
      validate: function(value){
        if($.trim(value) == '')
        {
          return 'El valor no puede ser vacío';
        }
      }
    });
</script>
</html>

<?php
else :
    echo include(unauthorizedModal());
endif;
else:
//echo "<script type='text/javascript'> window.location='../index.ph'; </script>";
endif;
?>
