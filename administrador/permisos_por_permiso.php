<?php
//include_once '../inc/functions.php';

//sec_session_start();
    if (function_exists('login_check') && login_check() == true):
        if (usuarioPrivilegiado()->hasPrivilege('Configuracion') || verificar_director($_SESSION['user_id'])==1):
            $departamentos = array();
            $sub_permiso_dep = array();
            $personas = array();
            $rp = 0;
            if ( !empty($_POST)){
                //User::subir_horarios();
                header("Location: index.php?ref=_100");
            }else{

                $permisos_por = get_permisos_por_permiso('leerCupon');
                $personas = get_personas_por_permiso('leerCupon');
                //$permisos = permisos();

                //$rp= verificar_per_rol(1,1);

            }
        ?>

<!DOCTYPE HTML>
<html lang="en">
<head>

	<title>Permisos y Roles</title>



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
                <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
            </li>
        </ul>
        <h3 class="block-title" >Control de mis empleados</h3>
      </div>
      <div class="block-content">
        <div class="form-horizontal">




    <div class="">
      <?php

        ?>
      <table id="ejemplo" class="print  table-condensed  dt-responsive display nowrap" cellspacing="0" width="100%">
        <tr class="weekpattern">
            <th class=""style="border-top:1px solid transparent">Empleado</th>
            <?php
              foreach ($permisos_por as $sb):
                  echo '<th align="center" class="text-center" style="border-top:1px solid transparent" valign="middle"'.$sb['permiso_por_permiso_id'].'">'.$sb['permiso_por_permiso_nm'].'</th>';
              endforeach;
            ?>

        </tr>


        <?php
          foreach ($personas as $per):
              echo '<tr id="x2" style="fontSize:10px; border-top:1px solid #fbfbfb" class=""'.$per['user_id'].'"><th><span class="label label-success">'.$per['NOMBRE'].'</span></th>';

              for ($x=1; $x<=count($permisos_por); $x++) {
                echo '<td align="center" valign="middle" style="border-top:1px solid #fbfbfb">
                <div class="checkbox checkbox-circle checkbox-success">
                              <input data-tipe="'.$x.'" data-id="'.$per['user_id'].'" type="checkbox"



                ';
                if(verificar_permiso_por_permiso_user($x,$per['user_id'])==1){ echo ' checked/>';} else { echo '/>'; }   echo '<label></label>
            </div></td>';
              }
              echo '</tr>';
          endforeach;
        ?>
      </table>



      <div class="form-group">
        <div class="col-xs-12 text-right">
          <div class="btn-group btn-group-sm" role="group">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group mr-2" role="group" aria-label="Second group">
              <button id="btnGuardarSP" name="btnGuardarSP" class="btn btn-sm btn-secondary btn-block" type="submit"><i style="display:none;" id="loading" class="fa fa-refresh fa-spin"></i>  Asignar Permisos</button>
            </div>
          </div>

          </div>

        </div>
      </div>
    </div>
         <?php

          ?>






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


<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
<script src="administrador/js/save_permiso_por_permiso_user.js"></script>
