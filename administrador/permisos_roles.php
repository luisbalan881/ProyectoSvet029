<?php include_once '../inc/functions.php';

sec_session_start();
    if (function_exists('login_check') && login_check() == true):
        if (usuarioPrivilegiado()->hasPrivilege('Configuracion')):
            $departamentos = array();
            $roles = array();
            $permisos = array();
            $rp = 0;
            if ( !empty($_POST)){
                //User::subir_horarios();
                header("Location: index.php?ref=_100");
            }else{
                $roles = roles();
                $permisos = permisos();

                $rp= verificar_per_rol(1,1);
            }
        ?>

<!DOCTYPE HTML>
<html lang="en">
<head>

	<title>Permisos y Roles</title>



  <link rel="stylesheet" href="administrador/css/build.css">
</head>
<body>
  <div class="modal-r-p block  block-rounded ">
    <div class="block-header">
      <ul class="block-options2" >
          <li>
              <button data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
          </li>
      </ul>
      <div class="tag-green">Asignar Roles y Permisos</div>
      <div id="message"></div>
    </div>



    <div class="block-content">
      <table id="ejemplo" class="print table-bordered table-condensed table-striped js-dataTable-usuariosH-general dt-responsive display nowrap" cellspacing="0" width="100%">
        <tr class="weekpattern">
            <th class=""></th>
            <?php
              foreach ($roles as $rol):
                  echo '<th align="center" class="" valign="middle"'.$rol['role_id'].'">'.$rol['role_nm'].'</th>';
              endforeach;
            ?>

        </tr>


        <?php
          foreach ($permisos as $per):
              echo '<tr id="x2" style="fontSize:10px;" class=""'.$per['perm_id'].'"><th>'.$per['perm_desc'].'</th>';

              for ($x=1; $x<=count($roles); $x++) {
                echo '<td align="center" valign="middle">
                <div class="checkbox checkbox-circle checkbox-success">
                              <input data-tipe="'.$x.'" data-id="'.$per['perm_id'].'" type="checkbox"



                ';
                if(verificar_per_rol($x,$per['perm_id'])==1){ echo ' checked/>';} else { echo '/>'; }   echo '<label></label>
            </div></td>';
              }
              echo '</tr>';
          endforeach;
        ?>
      </table>
      <br>


      <div class="form-group">

        <div class="col-xs-13 text-center">
            <button id="btnGuardar" name="btnGuardar" class="btn btn-sm btn-success btn-block" type="submit"><i style="display:none;" id="loading" class="fa fa-refresh fa-spin"></i>  Asignar Roles y Permisos</button>



        </div>
      </div>
         </div>
  </div>




<br/>

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
<script src="administrador/js/save_rp.js"></script>
