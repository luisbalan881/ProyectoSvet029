<?php
include_once '../inc/functions.php';
sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('leerCupon')):
      include_once 'php/funciones.php';
      $user_id =$_SESSION['user_id'];
      $persona = User::get_empleado_datos_id($user_id);
      $solicitudes = array();

      if(permiso_perm(7) || permiso_perm(3) && usuarioPrivilegiado()->hasPrivilege('crearCupon') || usuarioPrivilegiado()->hasPrivilege('Configuracion'))
      {
        $solicitudes = get_solicitudes_cupones();
      }
      else {
        $solicitudes= get_solicitudes_cupones_by_id($persona['dep_id']);
      }


        ?>

        <!-- INICIO Contenido de pagina -->


        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Horario</title>
            <script src="assets/js/plugins/jspdf/jspdf.js"></script>
            <script src="assets/js/plugins/jspdf/hoja_cupones.js"></script>
            <script src="assets/js/plugins/jspdf/hoja_cupones4.js"></script>
             <script src="assets/js/plugins/jspdf/hoja_cupones_anuladas.js"></script>
            <script src="assets/js/plugins/jspdf/solicitud_cupones.js"></script>
            <script src="combustible/js/anular_solicitud_cupon.js"></script>





        </head>
        <body >



                    <table id="solicitudes_cupones_list" class="table table-bordered table-condensed table-striped ">
                      <thead >
                        <tr>
                          <th class="text-center">Año</th>
                          <th class="text-center">Mes</th>
                          <!--<th class="text-center" >Dia</th>-->
                          <th class="text-center">Solicitud</th>
                          <th class="text-center" >Fecha Solicitud</th>
                          <th class="text-center" >Departamento</th>
                          <th class="text-center" >Estado</th>
                          <th class="text-center" style="width:230px;">Acción </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach ($solicitudes as $s){


                                      //echo '<td class="text-center">'.get_nombre_dia($s['FECHA']).'</td>';
                                        echo '<tr '.(($s['estado_solicitud'] == 0)?'class="danger"':'"class="warning"').'>';
                                      echo '<td class="text-center">'.$s['year'].'</td>';
                                      echo '<td class="text-center">'.get_nombre_mes($s['mes']).'</td>';
                                      echo '<td class="text-center">'.$s['IDX'].'</td>';

                                      echo '<td class="text-center">'.fecha_dmy($s['fecha']).'</td>';
                                      echo '<td class="text-center">'.$s['dep_nm'].'</td>';
                                      $mes = "".$s['mes']."";
                                      $m = "'".$s['mes']."'";
                                      $correlativo="".$s['IDX']."";
                                      echo '<td class="text-center">';
                                      if($s['estado_solicitud']==0){
                                        echo '<span class="label label-warning">Pendienteeee</span>';
                                      }
                                      else
                                      if($s['estado_solicitud']==1){
                                        echo '<span class="label label-primary">Cupones en trámite</span>';
                                      }
                                      else
                                      if($s['estado_solicitud']==2){
                                        echo '<span class="label label-success">Cupones Autorizados</span>';

                                      }
                                      else
                                      if($s['estado_solicitud']==3){
                                        echo '<span class="label label-danger">Cupones Devueltos</span>';

                                      }
                                      echo'</td>';

                                      echo '<td class="text-center">';
                                      echo '<div class="btn-group btn-group-sm" role="group">
                                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group mr-2" role="group" aria-label="Second group">';
                                        if(permiso_perm(4) && usuarioPrivilegiado()->hasPrivilege('crearCupon')  || usuarioPrivilegiado()->hasPrivilege('Configuracion'))
                                        {
                                          echo '<button  title="Generar Informe" class="btn btn-personalizado outline"  title="Descargar" ';
                                          if($s['estado_solicitud']==2 )
                                          {
                                            echo 'onclick="datos_hoja_cupones('.$s['year'].','.$m.','.$s['solicitud_id'].','.$s['dep_id'].')"  ';
                                          }
                                          else{
                                            echo 'disabled';
                                          }


                                          echo '><i class="fa fa-download"></i></button>';
                                        }
                                        
                                        if(permiso_perm(4) && usuarioPrivilegiado()->hasPrivilege('crearCupon')  || usuarioPrivilegiado()->hasPrivilege('Configuracion'))
                                        {
                                          echo '<button  title="Solitudes Anuladas" class="btn btn-personalizado outline"  title="Descargar" ';
                                          if($s['estado_solicitud']==3 )
                                          {
                                            echo 'onclick="solicitar_cupones2('.$s['year'].','.$m.','.$s['solicitud_id'].','.$s['dep_id'].')"  ';
                                          }
                                          else{
                                            echo 'disabled';
                                          }


                                          echo '><i class="fa fa-download"></i></button>';
                                        }
                                        
                                        if(permiso_perm(1) && usuarioPrivilegiado()->hasPrivilege('leerCupon'))
                                        {
                                          echo '<button  title="Generar Informe calculo de solicitud" class="btn btn-personalizado outline"  title="Descargar" ';

                                            echo 'onclick="solicitar_cupones('.$s['year'].','.$m.','.$s['solicitud_id'].','.$s['dep_id'].')"  ';


                                          echo '><i class="fa fa-download"></i></button>';
                                        }
                                       /* if(permiso_perm(1) && usuarioPrivilegiado()->hasPrivilege('leerCupon'))
                                        {
                                          echo '<button  title="Generar Informe solicitudes Anuladas" class="btn btn-personalizado outline"  title="Descargar" ';

                                            echo 'onclick="solicitar_cupones2('.$s['year'].','.$m.','.$s['solicitud_id'].','.$s['dep_id'].')"  ';


                                          echo '><i class="fa fa-download"></i></button>';
                                        }*/
                                        
                                        ///
                                        
                                         if(permiso_perm(4) && usuarioPrivilegiado()->hasPrivilege('crearCupon')  || usuarioPrivilegiado()->hasPrivilege('Configuracion'))
                                        {
                                          echo '<button  title="solicitud" class="btn btn-personalizado outline"  title="Descargar" ';
                                          if($s['estado_solicitud']==2 )
                                          {
                                            echo 'onclick="datos_hoja_cupones4('.$s['year'].','.$m.','.$s['solicitud_id'].','.$s['dep_id'].')"  ';
                                          }
                                          else{
                                            echo 'disabled';
                                          }


                                          echo '><i class="fa fa-download"></i></button>';
                                        }
                                        
                                        
                                        //
                                        if(permiso_perm(9) && usuarioPrivilegiado()->hasPrivilege('leerCupon') && $persona['dep_id']==20 || $persona['dep_id']==21)//cambari a 17 o a 20 dep_id
                                        {
                                          echo '<button  title="Generar Informe" class="btn btn-personalizado outline"  title="Descargar" ';echo 'data-toggle="modal" data-target="#modal-remoto-lg" href="combustible/php/esteblecer_solicitud_cupones_comision.php?year='.$s['year'].'&mes='.$mes.'&solicitud_id='.$s['solicitud_id'].'&correlativo='.$correlativo.'&dep_id='.$s['dep_id'].'&comision_status='.$s['comision_status'].'&estado_solicitud='.$s['estado_solicitud'].'"';echo '><i class="si si-pencil"></i></button>';
                                        }

                                        if(permiso_perm(8) && usuarioPrivilegiado()->hasPrivilege('leerCupon'))
                                        {
                                          echo '<button  title="Anular Solicitud" class="btn btn-personalizado outline"  title="Descargar" ';
                                          if($s['estado_solicitud']==0 || $s['estado_solicitud']==1 || $s['estado_solicitud']==2)
                                          {
                                            echo 'onclick="anular_solicitud_cupones('.$s['year'].','.$m.','.$s['solicitud_id'].','.$s['dep_id'].')"  ';
                                          }
                                          else{
                                            echo 'disabled';
                                          }


                                          echo '><i class="fa fa-times"></i></button>';
                                        }

                                        echo '<button class="btn btn-personalizado outline" data-toggle="modal" data-target="#modal-remoto-lgg" href="combustible/solicitudes_cupones_list_id.php?year='.$s['year'].'&mes='.$mes.'&solicitud_id='.$s['solicitud_id'].'&correlativo='.$correlativo.'&dep_id='.$s['dep_id'].'"><i class="fa fa-check"></i></button>';
                                        if(usuarioPrivilegiado()->hasPrivilege('leerCupon') && $s['comision_status']==1)
                                        {
                                          echo '<span class="btn-vicepresidencia">vp</span>';
                                        }

                                        echo '</div>
                                      </div>

                                      </div>';




                                      echo '</td>';





                                      echo '</tr>';
                                    }

                                  ?>
                        </tbody>
                    </table>
                    <script>
                    $(document).ready(function() {
                      var table = $('#solicitudes_cupones_list').DataTable({
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
        <!-- FIN Contenido de Pagina -->
        <?php
    else:
        //echo include(unauthorized());
    endif;
else:
  echo "<script type='text/javascript'> window.location='../herramientas/inicio.php'; </script>";
endif;
?>
