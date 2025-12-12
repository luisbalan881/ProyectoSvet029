<?php
    include_once '../../inc/functions.php';
    include_once 'funciones.php';
    include_once '../../transporte/php/funciones.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('leerCupon')) :
          $id=$_SESSION['user_id'];
          $comisiones=array();
          $year = $_POST['year'];
          $mes = $_POST['mes'];
          $solicitud = $_POST['solicitud_id'];
          $dep_id = $_POST['dep_id'];
          $comision_status = $_POST['estado'];
          $estado_solicitud = $_POST['status'];

          $comisiones=solicitudes_list();

        ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title></title>
    <script src="assets/js/plugins/chosen/chosen.jquery.js"></script>
    <script src="assets/js/plugins/chosen/docsupport/prism.js"></script>
    <script src="assets/js/plugins/chosen/docsupport/init.js"></script>
    <link rel="stylesheet" href="assets/js/plugins/chosen/chosen.css">


</head>
<body>
  <ul class="block-options2" style="margin-top:-70px;">
      <li>
          <button  onclick="get_transporte_por_cupones(<?php echo $year?>,<?php echo $mes ?>,<?php echo $solicitud ?>,<?php echo $dep_id?>,<?php echo $estado_solicitud?>,<?php echo $comision_status ?>)" type="button" ><i class="btn-regresar"></i></button>
      </li>
  </ul>
  <form class="js-validation-comision form-horizontal form-material push-10-t push-10">
    <div class="form-group">
      <div class="col-xs-12">
        <div class="form-material">
          <div class="input-group has-personalizado">
            <span class="input-group-addon" ><span class="fa fa-user"></span></span>
            <select class ="chosen-select-width" name="comision_idd" id="comision_idd"  style="width: 100%;" data-placeholder="-- Seleccionar Comisión --" required >
              <option></option>
              <?php
              foreach ($comisiones as $comisione):
                if($comisione['STATUS_SOL']==0)
                echo '<option value="'.$comisione["ID"].'" >'.$comisione["IDX"].' - '.$comisione["MOTIVO"].'</option>';
                endforeach
                ?>
              </select>
            </div>
            <label for="comision_idd">Comision*</label>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-xs-12 ">
        <div class="form-material">
          <button class="btn btn-sm btn-success btn-block" onclick="establecer_comision(<?php echo $year?>,<?php echo "'".$mes."'" ?>,<?php echo $solicitud ?>,<?php echo $dep_id ?>,<?php echo $estado_solicitud?>,<?php echo $comision_status ?>)" id="boton_a_u" ><i style="display:none;" id="loading_com_soli" class="fa fa-refresh fa-spin"></i> Establecer Comisión Vicepresidencial</button>
        </div>
      </div>
    </div>
  </form>


  <!-- Page JS Code -->


</body>
</html>

<?php
else :
    echo include(unauthorizedModal());
endif;
else:
echo "<script type='text/javascript'> window.location='../index.php'; </script>";
endif;
?>
