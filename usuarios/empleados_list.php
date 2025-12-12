<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')) :
            $id = null;
            $vid = null;
            $personas = array();
            $sus = array();


            date_default_timezone_set('America/Guatemala');




                //$persona = User::getByUserId($id);
                if(verificar_director($_SESSION['user_id'])==1 || usuarioPrivilegiado()->hasPrivilege('Configuracion') || (permiso_dep(8)&&permiso_dep(9)))
                {
                  $personas = personas();
                }
                else if(permiso_dep(8)){
                  $personas = personas_por_renglon_011_022();
                }
                else if(permiso_dep(9)){
                  $personas = personas_por_renglon_029();
                }








        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title></title>


        </head>
        <body>

            <!-- END Header Tiles -->

            <!-- Todos los Productos -->

                <div >
                    <table id="empleados" class="table table-bordered table-condensed table-striped  dt-responsive display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" >Renglón</i></th>
                                <th class="text-center">Pref</th>
                                <th >Nombre</th>
                                <th class="text-center">Ext.</th>
                                <!--<th class="text-center">Email</th>-->
                                <th class="text-center">Departamento</th>
                                <th class="text-center">Puesto</th>
                                <th class="text-center">Cargo</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Roll</th>
                                <?php echo ((usuarioPrivilegiado()->hasPrivilege("modificarUsuario"))?'<th class="text-center">Acción</th>':'') ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($personas as $persona){
                                    echo '<tr '.(($persona['user_status'] == 0)?'class="gray"':"").'>';
                                    echo '<td class="text-center">';
                                    if(usuarioPrivilegiado()->hasPrivilege('Configuracion'))
                                    {
                                      echo '<div class="col-sm-3">';
                                      echo '<span class="btn-edit" data-toggle="modal" data-target="#modal-remoto" href="usuarios/usuario_modificar.php?id='.$persona['user_id'].'" style="margin-left:-17px;z-index:3"></span>';
                                      echo '</div>';
                                    }
                                    echo '<div class="col-sm-12">';
                                    if($persona['renglon']=='000'){
                                      echo '';
                                    }else {
                                      echo $persona['renglon'];
                                    }
                                    echo '</div>';

                                    echo '</td>';
                                    echo '<td class="text-left">'.$persona['user_pref'].'</td>';
                                    echo '<td class="text-left" style="white-space: nowrap;">';
                                    if($persona['fotografia']!='')
                                    {
                                      echo '<div class="col-sm-3"><img class="img_foto img-circle" src="usuarios/fotos/'.$persona['fotografia'].'"></img></div>';
                                    }
                                    echo '<div class="col-sm-9">'.$persona['user_nm1'].' '.$persona['user_nm2'].'<br>'.$persona['user_ap1'].' '.$persona['user_ap2'].'</div></td>';
                                    echo '<td class="text-center">';
                                    if($persona['ext_id']==0){
                                      echo ' ';
                                    }else {
                                    echo $persona['ext_id'];
                                  }
                                    echo '</td>';
                                    //echo '<td class="text-left" ><a href="mailto:'.$persona['user_mail'].'">'.$persona['user_mail'].'</td>';
                                    echo '<td class="text-center">'.$persona['dep_nm'].'</td>';
                                    echo '<td class="text-left">'.$persona['user_puesto'].'</td>';
                                    echo '<td class="text-left">'.$persona['user_nom'].'</td>';
                                    echo '<td class="text-center">';
                                    if($persona['user_status'] == '0'){ echo '<span class="label label-danger">Inactivo</span> ';}
                                    else if($persona['user_status'] == '1'){ echo '<span class="label label-success" disabled>Activo</span>';}
                                    else if($persona['user_status'] == '2'){ echo '<span class="label label-warning">Activar</span>';}
                                    echo'</td>';


                                    echo '<td class="text-center">'.$persona['role_nm'].'</td>';
                                    if(usuarioPrivilegiado()->hasPrivilege('modificarUsuario')) {
                                        echo '<td class="text-center" style="white-space: nowrap;">';
                                        echo '<div class="btn-group btn-group-sm" role="group">
                                              <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                              <div class="btn-group mr-2" role="group" aria-label="Second group">';
                                        if(permiso_dep(4) || usuarioPrivilegiado()->hasPrivilege('Configuracion'))
                                        {
                                          echo '<button title="Editar" class="btn btn-warning outline"  title="Editar"  data-toggle="modal" data-target="#modal-remoto-lgg" href="usuarios/empleado_modificar.php?id='.$persona['user_id'].'"><i class="fa fa-pencil "></i></button>';

                                          echo '<button  title="Salarios y Bonos" class="btn btn-danger outline"  title="Salarios y Bonos"  data-toggle="modal" data-target="#modal-remoto" href="usuarios/usuario_sueldo.php?id='.$persona['user_id'].'"><i class=""></i>Q</button>';
                                          echo '</div></div></div><br>';
                                        }
                                        if($persona['renglon']=='011' || $persona['renglon']=='022')
                                        {
                                          if(permiso_dep(2) || usuarioPrivilegiado()->hasPrivilege('Configuracion'))
                                          {
                                            //echo '<br>';
                                            echo '<div class="btn-group btn-group-sm" role="group">
                                                  <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                  <div class="btn-group mr-2" role="group" aria-label="Second group">';
                                            echo '<button  title="Suspención" class="btn btn-primary outline"  title="Suspencion"  data-toggle="modal" data-target="#modal-remoto" href="usuarios/suspenciones.php?id='.$persona['user_id'].'&vid='.$persona['user_vid'].'" disabled><i class="fa fa-calendar-times-o" style="font-size:12px"></i></button>';

                                            echo '<button  title="Listado de Suspenciones" class="btn btn-success outline"  title="Listado de Suspenciones" data-toggle="modal" data-target="#modal-remoto-lgg1" href="usuarios/suspenciones_listado_user.php?id='.$persona['user_id'].'"  ><i class="fa fa-file-text" style="font-size:12px"></i></button>';
                                            echo '</div></div></div>';
                                          }
                                        }



                                        echo '</td>';
                                    }
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

          </div>
        </div>
        <!-- Final Todos los Productos -->
        <div style="display:none;" id="tabla2" class="col-xs-12">
        </div>
      </div>
      <!-- FIN Contenido de Pagina -->
      <script>
          jQuery(function(){
              // Init page helpers (Select2 Inputs plugins)
              App.initHelpers(['select2']);
          });
      </script>
      <script src="assets/js/pages/usuarios_forms_validation.js"></script>

      <script>
      $(document).ready(function() {
        var table = $('#empleados').DataTable({
          "pageLength": 50,

          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
          buttons: [],
          columnDefs: [
              {responsivePriority:0, targets: [0,2,-1]},
              {responsivePriority:1, targets: [8,9]},
              {responsivePriority:2, targets: [3,4]},
              {responsivePriority:3, targets: [1]},
              {responsivePriority:4, targets: [5,6,7]}
          ],

           "ordering": false,
          "columnDefs": [
            //{ "visible": false, "targets": 0 }
          ],
          "order": [[ 0, 'asc' ]],
          "displayLength": 25
        } );

        // Order by the grouping

      } );
</script>
    </body>
    </html>
        <?php
    else:
        echo include(unauthorized());
    endif;
else:
    echo "<script type='text/javascript'> window.location='../herramientas/inicio.php'; </script>";
endif;
?>
