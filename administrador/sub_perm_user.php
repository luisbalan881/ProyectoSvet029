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

                $sub_permiso_dep = get_sub_permiso_dep($user->persona['dep_id']);
                $personas = personas_depto($user->persona['dep_id']);
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




    <div class="">
      <?php
      if(verificar_exist_sub_perm($user->persona['dep_id'])>0)
      {
        ?>
      <table id="ejemplo" class="print  table-condensed  dt-responsive display nowrap" cellspacing="0" width="100%">
        <tr class="weekpattern">
            <th class=""style="border-top:1px solid transparent">Empleado</th>
            <?php
              foreach ($sub_permiso_dep as $sb):
                  echo '<th align="center" class="text-center" style="border-top:1px solid transparent" valign="middle"'.$sb['sub_perm_id'].'">'.$sb['sub_perm_nm'].'</th>';
              endforeach;
            ?>

        </tr>


        <?php
          foreach ($personas as $per):
              echo '<tr id="x2" style="fontSize:10px; border-top:1px solid #fbfbfb" class=""'.$per['user_id'].'"><th><span class="label label-success">'.$per['user_nm1'].' '.$per['user_nm2'].' '.$per['user_ap1'].' '.$per['user_ap2'].'</span></th>';

              for ($x=1; $x<=count($sub_permiso_dep); $x++) {
                echo '<td align="center" valign="middle" style="border-top:1px solid #fbfbfb">
                <div class="checkbox checkbox-circle checkbox-success">
                              <input data-tipe="'.$x.'" data-id="'.$per['user_id'].'" type="checkbox"



                ';
                if(verificar_subperm_user($x,$per['user_id'])==1){ echo ' checked/>';} else { echo '/>'; }   echo '<label></label>
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
       }
       else {
         echo '<p>El departamento no tiene permisos específicos</p>';

       }
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
<script src="administrador/js/save_subp_user.js"></script>
