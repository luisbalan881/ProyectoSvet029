
<?php include_once '../inc/functions.php';
sec_session_start();
    if (function_exists('login_check') && login_check() == true):
        if (usuarioPrivilegiado()->hasPrivilege('Configuracion')):

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
<!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
  <script src="administrador/js/fechas.js"></script>
  <script src="administrador/js/crear_asuetos.js"></script>
  <link rel="stylesheet" href="administrador/css/build.css">

</head>
<body>
  <div class="block block-themed block-transparent remove-margin-b panel panel-default">
    <div class="panel-heading ">

      <h3 >Generar horarios por dias laborales</h3>
      <ul class="block-options2" style="margin-top:-30px;">
          <li>
              <button id="back" onclick="cargar('administrador/scripts_php/en_blanco.php')" data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
          </li>
      </ul>
    </div>
    <div class="block-content">

      <div class="form-horizontal">
        <div class="form-group">
          <div class="col-xs-4">
            <select name="year" id="year"  class=" form-control">
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

          <div class="col-xs-4">
            <select name="mes" id="mes"class=" form-control " >
              <option value="" disabled selected hidden>Seleccione un Mes</option>
                <?php
                for ($x=1; $x<=12; $x++) {

                  echo '<option value="'.$x.'">'.User::get_nombre_mes($x).'</option>';
                }
                ?>
            </select>
          </div>

        </div>
      </div>
      <div class="form-group">
        <div class="form-material">
          <table id="fechas" name="fechas" class="print table-bordered table-condensed table-striped js-dataTable-usuariosH-general dt-responsive display nowrap" cellspacing="0" width="100%" style="margin-left:auto; margin-right:auto;">
          </table>
        </div>
      </div>

      <div id="save" name="save" class="form-group" style="display:none">
      <div class="form-material">
      <div class="col-xs-13 text-center">
          <button class="btn btn-sm btn-success btn-block" onclick="insertData();"><i style="display:none;" id="loading" class="fa fa-refresh fa-spin"></i>  Generar Horarios Laborales</button>



      </div>
      </div>
      </div>



        <div class="form-group">
            <div class="form-material">
          <p id="message"></p>
        </div>
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
