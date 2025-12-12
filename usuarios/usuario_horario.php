<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')) :
            $id = null;
            $mess = null;
            $anio = null;
            $personas = array();
            $user_rol = null;
            $roles = array();
            $departamentos = array();
            if ( !empty($_GET['id'])) {
              $id = $_REQUEST['id'];
            }

            if ( !empty($_GET['mess'])) {
              $mess = $_REQUEST['mess'];
            }

            if ( !empty($_GET['anio'])) {
              $anio = $_REQUEST['anio'];
            }

            if ( null==$id ) {
              header("Location: index.php?ref=_39");
            }
            if ( !empty($_POST)) {
                //User::usuarioModificar($id);
                header("Location: index.php?ref=_39");
            }else{
                $roles = roles();
                $persona = User::getByUser_HorarioId($id, $mess, $anio);
                $datos_u = User::get_user_horario($id);
            }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Horario</title>
            <script src="assets/js/plugins/jspdf/jspdf.js"></script>
            <script src="assets/js/plugins/jspdf/hoja_horario_user.js"></script>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">


            <div class="block-content">
              <div class="col-xs-6">
                  <div id="datos_emp" class="input-group has-personalizado" style="margin-left:-15px">
                    <span id="titulo"  class="input-group-addon" disabled><strong class="">Control de entrada y Salida</strong></span>
                    <span style="border-radius:0px 3px 3px 0px" class="input-group-addon span-personalizado" type="text"><?php echo ' '.$datos_u->persona['user_nm1']. ' '.
                                $datos_u->persona['user_nm2']. ' '.
                                $datos_u->persona['user_ap1']. ' '.
                                $datos_u->persona['user_ap2']. '   -   '.
                                  ' '.$datos_u->persona['dep_nm']. ' ';?> </span>

                                  <span style="margin-left:10px;"class="btn btn-personalizado outline btn-sm" onclick="generar_horario(<?php echo $datos_u->persona['user_id'] ?>,<?php echo $mess ?>,<?php echo $anio ?>)"><i class="fa fa-download"></i> Descargar Horario</span>
                  </div>

              </div>

                <div class="">
                  <ul class="block-options2" style="margin-top:0px;">
                      <li>
                          <button data-dismiss="modal" type="button"><i class="btn-circle"></i></button>
                      </li>
                  </ul>


              </div>
              <br>

              <table id="example11" class="table table-bordered table-condensed table-striped js-dataTable-usuarios dt-responsive display nowrap" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                         <th class="text-center" >Dia</th>
                          <th class="text-center" >Fecha</th>
                          <th class="text-center" >Control</th>
                          <th class="text-center">Entrada  </th>
                          <th class="text-center">Salida  </th>
                          <th class="text-center">Horas laboradas</th>


                      </tr>
                  </thead>
                  <tbody>
                      <?php
                          foreach ($persona as $p){
                              echo '<tr>';
                              echo '<td class="text-center">'.User::get_nombre_dia($p['FECHA']).'</td>';
                              echo '<td class="text-center">'.fecha_dmy($p['FECHA']).'</td>';
                              echo '<td class="text-center">';
                              echo '<div style="display:inline-block">';
                              if($p['LABOR'] == '0'){ echo '<span  id="'.$p['FECHA'].'/'.$p['LABOR'].'" class="label label-danger">Ausente</span> ';}
                              else if($p['LABOR'] == '1'){ echo '<span id="'.$p['FECHA'].'/'.$p['LABOR'].'" class="label label-success" disabled></span>';}
                              else if($p['LABOR'] == '2'){ echo '<span id="'.$p['FECHA'].'/'.$p['LABOR'].'" class="label label-warning mensajes">Permiso</span>';}
                              else if($p['LABOR'] == '3'){ echo '<span id="'.$p['FECHA'].'/'.$p['LABOR'].'" class="label label-success" disabled>Feriado</span>';}
                              else if($p['LABOR'] == '4'){ echo '<span id="'.$p['FECHA'].'/'.$p['LABOR'].'" class="label label-info" mensajes>No Laboraba</span>';}
                              else if($p['LABOR'] == '6'){ echo '<span id="'.$p['FECHA'].'/'.$p['LABOR'].'" class="label label-vacaciones" mensajes>Vacaciones</span>';}
                              else if($p['LABOR'] == '7'){ echo '<span id="'.$p['FECHA'].'/'.$p['LABOR'].'" class="label label-warning" mensajes><i class="fa fa-hand-o-up"/>  Aún no marcaba</span>';}
                              else if($p['LABOR'] == '5'){ echo '<span id="'.$p['FECHA'].'/'.$p['LABOR'].'" class="label label-primary" mensajes><i class="fa fa-heartbeat"/> -   Suspendido IGSS</span';}
                              else if($p['LABOR'] == '50'){ echo '<span id="'.$p['FECHA'].'/'.$p['LABOR'].'" class="label label-warning" mensajes>Permiso VP</span>';}
                              else{
                                echo '<span  id="'.$p['FECHA'].'/'.$p['LABOR'].'" class="label label-secondary mensajes">'.$p['DIAN'].'</span>';
                              }
                              echo '</div>';
                              echo '<div style="margin-top:-22px; margin-right:-105px;">';
                              $n_p = User::verificar_permiso_parcial($id,$p['FECHA'],49);
                              $n_p2 = User::verificar_permiso_parcial($id,$p['FECHA'],15);
                              $n_p3 = User::verificar_permiso_parcial_horas($id,$p['FECHA']);

                              $evaluar=0;
                              if($n_p['tipo_suspencion']==49 && $p['LABOR'] != 3 && $p['LABOR'] != 50)
                              {

                                echo '<span id="'.$p['FECHA'].'/'.$n_p['tipo_suspencion'].'" class="material-icons mensajes" >alarm_on</span> ';
                                $evaluar=1;
                              }
                              /*if($n_p2['tipo_suspencion']==15 && $p['LABOR'] != 3 && $p['LABOR'] != 50)
                              {

                                echo '<span id="'.$p['FECHA'].'/'.$n_p2['tipo_suspencion'].'" class="material-icons mensajes" >alarm_on</span> ';
                              }*/
                              if($n_p3['resolucion']!='' && $p['LABOR']==1)
                              {
                                if($evaluar==0)
                                {
                                  echo '<span id="'.$p['FECHA'].'/'.$n_p3['tipo_suspencion'].'" class="material-icons mensajes">alarm_on</span> ';
                                }
                              }
                              echo '</div>';
                              echo'</td>';
                              echo '<td class="text-center">'.$p['F_INI'].'

                              </td>';
                              echo '<td class="text-center">'.$p['F_FIN'].'
                              ';


                              echo '</span>
                              </td>';
                              echo '<td class="text-center">'.substr($p['HORAS'], 0, -3).'</td>';


                              echo '</tr>';
                          }
                      ?>
                  </tbody>
              </table>
              <br>
            </div>

          </div>
          <!-- Page JS Code -->
          <script>
              jQuery(function(){
                  // Init page helpers (Select2 Inputs plugins)
                  App.initHelpers(['select2']);
              });
              var n = $('#datos').text();
              $(document).ready(function() {
                $('#example11').DataTable( {
                  dom: 'Bfrtip',
                  "paging":   false,
                  "ordering": false,
                  "info":     true,
                  "search": false,
                  "searching": false,
                  buttons:[]/*,
                  buttons: [
                    {
                      extend: 'print',
                      text: '<i class="fa fa-print"> </i> Imprimir',
                      className : 'btn btn-xs btn-secondary text-right',
                      orientation: 'horizontal',
                      title: 'Horarios: ' + n,
                      autoPrint: true,
                      customize: function ( win ) {
                        $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .prepend(
                          //'<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                        );
                        $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                      }
                    }
                  ]*/
                } );



 // initialize tooltip
 $('.mensajes').tooltip({
    title: fetchData,
    html: true,
    placement: 'right'
   });

   function fetchData()
   {
    var fetch_data = '';
    var element = $(this);
    var id=<?php echo $id?>;
    var fecha = element.attr("id");

    $.ajax({
     url:"usuarios/php/get_detalle_fecha_ausencia.php",
     method:"POST",
     async: false,
     data:{id:id,fecha:fecha},
     success:function(data)
     {
      fetch_data = data;

     }

    }).done( function() {










    }).fail( function( jqXHR, textSttus, errorThrown){

      fetch_data=errorThrown;

    });
    return fetch_data;
   }


              } );
          </script>
          <script src="assets/js/pages/usuarios_forms_validation.js"></script>
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
