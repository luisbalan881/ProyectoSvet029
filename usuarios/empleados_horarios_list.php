          <?php
              include_once '../inc/functions.php';
              sec_session_start();
              if (function_exists('login_check') && login_check() == true) :
                  if (usuarioPrivilegiado()->hasPrivilege('leerUsuario')) :
                      $id = null;
                      $vid = null;
                      $persona = array();
                      $sus = array();


                      date_default_timezone_set('America/Guatemala');




                          //$persona = User::getByUserId($id);
                          $fechm= $_POST['mm'];
                          $fecha= $_POST['yy'];
                          $personas = personas_por_mes_horarios($fechm,$fecha);






                  ?>
                  <!DOCTYPE html>
                  <html>
                  <head>
                      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
                      <title>Usuario Modificar</title>


                  </head>
                  <body>

         <!-- INICIO Encabezado de Pagina -->

        <!-- FIN Encabezado de Pagina -->

        <?php

        ?>

        <!-- INICIO Contenido de pagina -->
        <div class="">
            <!-- Header Tiles -->

            <!-- END Header Tiles -->

            <!-- Todos los Productos -->
            <div >
              <table id="empleados" class="table table-bordered table-condensed table-striped  dt-responsive display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>

                            <th class="hidden-xs text-center">Pref</th>
                            <th>Nombre</th>
                            <th class="text-center">Ext.</th>
                            <th class="hidden-xs text-center">Email</th>
                            <th class="hidden-xs text-center">Departamento</th>
                            <th class="hidden-xs text-center">Puesto Funcional</th>
                            <th class="hidden-xs text-center">Puesto Nominal</th>
                            <?php echo ((usuarioPrivilegiado()->hasPrivilege("modificarUsuario"))?'<th class="text-center"><i class=""></i>VER</th>':'') ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($personas as $persona){
                               if($persona['ext_id'] > 0){
                                   echo '<tr>';

                                   echo '<td class="hidden-xs">'.$persona['user_pref'].'</td>';
                                   echo '<td >'.$persona['user_nm1'].' '.$persona['user_nm2'].' '.$persona['user_ap1'].' '.$persona['user_ap2'].'</td>';
                                   echo '<td class="text-center">'.$persona['ext_id'].'</td>';
                                   echo '<td class="hidden-xs" ><a href="mailto:'.$persona['user_mail'].'">'.$persona['user_mail'].'</td>';
                                   echo '<td class="hidden-xs">'.$persona['dep_nm'].'</td>';
                                   echo '<td class="text-center">'.$persona['user_puesto'].'</td>';
                                   echo '<td class="text-center">'.$persona['user_nom'].'</td>';
                                   if(usuarioPrivilegiado()->hasPrivilege('modificarUsuario')) {
                                       echo '<td class="text-center" style="white-space: nowrap;">';
                                       echo '<div class="btn-group">';
                                       echo '<span  title="Ver Horarios"><a class="btn btn-primary outline"  title="Ver Horarios"  data-toggle="modal" data-target="#modal-remoto-lgg" href="usuarios/usuario_horario.php?mess='.$fechm.'&anio='.$fecha.'&id='.$persona['user_vid'].'"><i class="fa fa-calendar-check-o"></></i></a></span>';
                                       echo ' ';

                                       echo '</div>';
                                       echo '</td>';
                                   }
                                   echo '</tr>';
                               }
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
