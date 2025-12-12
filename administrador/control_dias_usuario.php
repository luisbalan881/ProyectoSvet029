
<?php

    if (function_exists('login_check') && login_check() == true):
      if ((isset($u) && verificar_director($user->persona['user_id'])==1) || (isset($u) && $u->hasPrivilege('Configuracion'))):

    $dias = array();
    $personas = array();



    if($u->hasPrivilege('Configuracion'))
    {

      $personas = personas();
    }
    else if(verificar_director($user->persona['user_id'])==1){
      $personas = personas_depto($user->persona['dep_id']);
    }

            $roles = array();
            if ( !empty($_POST)){
                //User::subir_horarios();
                header("Location: index.php?ref=_100");
            }else{

            }
        ?>

<!DOCTYPE HTML>
<html lang="en">
<head>

	<title>Asuetos</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



  <script src="administrador/js/fechas.js"></script>
  <link rel="stylesheet" href="administrador/css/build.css">


</head>
<body>
  <div class="content bg-gray-lighter">
    <div class="row items-push">
      <div class="col-sm-7">
        <h1 class="page-heading">
          Control de Permisos
        </h1>
      </div>
    </div>
  </div>



  <div class="content content-boxed">
    <div class="block block-themed block-rounded" id="block_hide">
      <div class=" block-header bg-muted ">
        <ul class="block-options">
          <li>
            <button type="button">
                <a class="text-white">
                    <img src="<?php echo $one->assets_folder; ?>/img/file.png"/> Suspenciones
                </a>
            </button>
          </li>
            <li>
                <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
            </li>
        </ul>
        <h3 class="block-title" >Control de mis empleados</h3>
      </div>
      <div class="block-content">
        <div class="form-horizontal">



          <!--<div class="form-group">

            <div class="col-xs-3 ">
              <select class ="chosen-select altura" name="empleado" id="empleado"  style="width: 100%;" data-placeholder="-- Seleccionar Empleado --">
                <option></option>
                <?php
                foreach ($personas as $persona) {
                  if ($persona['user_status'] == 1) {
                    echo '<option value="' . $persona["user_vid"] . '">'.$persona["user_nm1"] .' '.$persona['user_nm2'].' '. $persona['user_ap1'].' '.$persona['user_ap2'].'</option>';
                  }
                }
                ?>
              </select>
            </div>
            <div class="col-xs-3">
              <select name="y" id="y"  class=" form-control altura">
                <?php
                for($i=date('o'); $i>=2015; $i--){
                  if ($i == date('o'))
                  echo '<option value="'.$i.'" selected>'.$i.'</option>';
                  else
                  echo '<option value="'.$i.'">'.$i.'</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-xs-3">
              <select name="m" id="m"class=" form-control altura" >
                <option value="" disabled selected hidden>Seleccione un Mes</option>
                <?php
                for ($x=1; $x<=12; $x++) {
                  echo '<option value="'.$x.'">'.User::get_nombre_mes($x).'</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-xs-3">
              <button class="col-xs-12 btn btn-success outline" onclick="get_horarios_usuario()"><i class="fa fa-search"></i> Buscar</button>
            </div>
          </div>
          </div>

          <div class="form-group">
            <div class="form-material">
              <table id="horarios" name="horarios" class="print table-bordered table-condensed table-striped js-dataTable-usuariosH-general dt-responsive display nowrap" cellspacing="0" width="100%" style="margin-left:auto; margin-right:auto;">
              </table>
            </div>
          </div>
-->
<?php
require_once('sub_perm_user.php');
?>

      </div>

    </div>
  </div>

</body>
</html>
<?php
else :
    echo include(unauthorizedModal());
endif;
else:
//echo "<script type='text/javascript'> window.location='index.php'; </script>";
endif;
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js" type="text/javascript"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/chosen/chosen.jquery.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/chosen/docsupport/prism.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/chosen/docsupport/init.js"></script>
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/chosen/chosen.css">
