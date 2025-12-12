
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

  <script src="administrador/js/get_roles_permisos.js"></script>

  <link rel="stylesheet" href="administrador/css/build.css">

</head>
<body>
  <div class="block block-themed block-transparent remove-margin-b panel panel-default">
    <div class="panel-heading ">

      <h3 >Agregar Roles o Permisos</h3>
      <ul class="block-options2" style="margin-top:-30px;">
          <li>
              <button id="back" onclick="cargar('administrador/scripts_php/en_blanco.php')" data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
          </li>
      </ul>
    </div>
    <div class="block-content">
      <div class="col-xs-6">
      <form class="js-validation-role form-horizontal " id="loginFormR" method="POST" enctype="multipart/form-data">

            <div class="form-group">
              <div class="col-xs-12">
                  <div class="form-material">
                      <label for="role">Agregar un nuevo Rol*</label>
                      <div class="input-group has-personalizado">
                        <span class="input-group-addon" ><span class="fa fa-plus-square"></span></span>
                        <input class="form-control" type="text" id="role" name="role" required/>
                      </div>
                  </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12 text-center">
                  <button id="add_roler" class="btn btn-sm btn-success btn-block" onclick="add_role()" ><i style="display:none;" id="loading1" class="fa fa-refresh fa-spin"></i>  Agregar Rol</button>

              </div>
            </div>
        </form>
      </div>
      <div class="col-xs-6">
      <form class="js-validation-perm form-horizontal " id="loginFormP" method="post" enctype="multipart/form-data">

            <div class="form-group">
              <div class="col-xs-12">
                  <div class="form-material">
                      <label for="role">Agregar un nuevo Permiso*</label>
                      <div class="input-group has-personalizado">
                        <span class="input-group-addon" ><span class="fa fa-plus-square"></span></span>
                        <input class="form-control" type="text" id="perm" name="perm" required/>
                      </div>
                  </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12 text-center">
                  <button id="add_permiso" class="btn btn-sm btn-success btn-block" onclick="add_perm()"><i style="display:none;" id="loading2" class="fa fa-refresh fa-spin"></i>  Agregar Permiso</button>

              </div>
            </div>
        </form>
      </div>

      <div class="form-horizontal">
        <div class="form-group">
          <div class="col-xs-4">



          </div>

          <div class="col-xs-4">

          </div>

        </div>
      </div>

      <div class="form-group">
        <div class="col-xs-6">

          <table id="roles" name="roles" class="print table-bordered table-condensed table-striped js-dataTable-usuariosH-general dt-responsive display nowrap" cellspacing="0" width="100%" style="margin-left:auto; margin-right:auto;">

          </table>


        </div>

        <div class="col-xs-6">
          <table id="permisoss" name="permisoss" class="print table-bordered table-condensed table-striped js-dataTable-usuariosH-general dt-responsive display nowrap" cellspacing="0" width="100%" style="margin-left:auto; margin-right:auto;">

          </table>
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
