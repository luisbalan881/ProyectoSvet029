<?php
include_once '../inc/functions.php';
sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('leerCupon')):
      include_once 'php/funciones.php';
      $id=$_SESSION['user_id'];
      $inicio = null;
      $fin = null;
      if ( !empty($_GET['inicio'])) {
        $inicio = $_REQUEST['inicio'];
      }

      if ( !empty($_GET['fin'])) {
        $fin = $_REQUEST['fin'];
      }
      $cupones = cupones_list($inicio,$fin);

        ?>

        <!-- INICIO Contenido de pagina -->


        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Horario</title>




        </head>
        <body >
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-content">
              <div class="col-xs-4">
                  <div class="input-group has-personalizado" style="margin-left:-15px">
                    <span class="input-group-addon" disabled><strong class="">Cupones </strong></span>
                    <span class="input-group-addon span-personalizado" type="text"><?php echo 'del: <strong class="text-danger">'. $inicio .'</strong> al: <strong class="text-danger">'.$fin.'</strong>'?> </span>
                  </div>
              </div>
              <div class="">
                  <ul class="block-options2" style="margin-top:0px;">
                      <li>
                          <button id="cerrar_this" data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                      </li>
                  </ul>
              </div>
              <br><br>
              <div class="form-material">



                    <table id="cupones_listado" class="table table-bordered table-condensed table-striped">
                      <thead >
                              <tr>
                                  <th class="text-center">Cupon</th>
                                <!--<th class="text-center" >Dia</th>-->
                                <th class="text-center" >Fecha Emisión</th>
                                  <th class="text-center" >Fecha Caducidad</th>
                                  <th class="text-center">Monto</th>
                                  <th class="text-center">Estado</th>






                              </tr>
                          </thead>
                          <tbody>
                            <?php


                                  foreach ($cupones as $s){

                                      echo '<tr>';
                                      //echo '<td class="text-center">'.$p['NOMBRE'].'</td>';
                                      echo '<td class="text-center"><i class=""></i>';
                                      if($s['cupon_status'] == 0){
                                        echo '<span class="btn-checkk" style="margin-left:-20px; margin-top:2px"></span>';
                                      }else if($s['cupon_status'] == 1){
                                        echo '<span class="btn-checkk_primary" style="margin-left:-20px; margin-top:2px"></span>';
                                      }
                                      else if($s['cupon_status'] == 2){
                                        echo '<span class="btn-checkk-no"  style="margin-left:-20px; margin-top:2px"></span>';
                                      }

                                      echo '<strong> '.$s['cupon_id'].'</strong>';

                                      echo '</td>';
                                      //echo '<td class="text-center">'.get_nombre_dia($s['FECHA']).'</td>';
                                      echo '<td class="text-center">'.date('d-m-Y', strtotime($s['fecha_emision'])).'</td>';
                                      echo '<td class="text-center">'.date('d-m-Y', strtotime($s['fecha_caducidad'])).'</td>';
                                      echo '<td class="text-center">'.$s['monto'].'</td>';
                                      echo '<td class="text-center">';
                                      echo '<div ">';
                                      if($s['cupon_status'] == 0){
                                        echo '<span class="label label-success">Disponible</span></span>';
                                      }else if($s['cupon_status'] == 1){
                                        echo '<span class="label label-vacaciones">Utilizado</span></span>';
                                      }
                                      else if($s['cupon_status'] == 2){
                                        echo '<span class="label label-vacaciones">Anulado</span></span>';
                                      }
                                      echo '</div></td>';






                                      echo '</tr>';
                                  }
                                  ?>
                        </tbody>
                    </table>
                  </div>
                    <script>
                    $(document).ready(function() {
                      var table = $('#cupones_listado').DataTable({
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
