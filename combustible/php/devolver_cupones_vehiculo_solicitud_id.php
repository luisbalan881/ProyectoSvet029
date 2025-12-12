<?php
    include_once '../../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('leerCupon')) :
          include_once 'funciones.php';


          $year=$_POST['year'];
          $mes=$_POST['mes'];
          $m = "'".$mes."'";
          $solicitud=$_POST['solicitud_id'];
          $vehiculo=$_POST['vehiculo_id'];
          $dep_id=$_POST['dep_id'];
          $cupones_utilizados = array();



          $cupones_utilizados=get_cupones_utilizados_by_id($year,$mes,$solicitud,$vehiculo,$dep_id);


          $id=$_SESSION['user_id'];
          $cupones = cupones_disponibles();
          $fecha = date('d-m-Y',time());
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Modificar</title>


        </head>
        <body>
          <div class="">
              <ul class="block-options2" style="margin-top:-70px;">
                  <li>
                      <button id="return2" onclick="get_solicitud_vehiculo_by_id(<?php echo $year ?>,<?php echo $m ?>,<?php echo $solicitud?>,<?php echo $vehiculo?>,<?php echo $dep_id ?>)" type="button" ><i class="btn-regresar"></i></button>
                  </li>
              </ul>


          </div>
          <div class="block block-themed block-transparent remove-margin-b">

                <table id="cupones_asignados_list_id" class="table table-condensed" width="100%">
                  <thead >
                          <tr>

                             <th class="text-left">Estado</th>
                              <th class="text-right">Cupon</th>
                              <th class="text-right">Monto</th>
                              <th class="text-center">Acción</th>



                          </tr>
                      </thead>
                      <tbody>
                        <?php


                              foreach ($cupones_utilizados as $cu){


                                  //echo '<td class="text-center">'.get_nombre_dia($s['FECHA']).'</td>';
                                  echo '<td class="text-left"><strong>';
                                  if($cu['cupon_status']==1)
                                  {
                                    echo '<span class="label label-success">Cupon Asignado</span>';
                                  }
                                  else {

                                    echo '<span class="label label-danger">Cupon Devuelto</span>';
                                  }

                                  echo '</strong></td>';
                                  echo '<td class="text-right"><strong>'.$cu['cupon_id'].'</strong></td>';
                                  echo '<td class="text-right"><strong>'.$cu['monto'].'</strong></td>';
                                  ?>
                                  <td class="text-center">
                                    <?php echo '<button title="Devolver cupón" class="btn btn-personalizado outline"';
                                    if($cu['cupon_status']==1){
                                      echo 'onclick="devolver_cupon_vehiculo('.$year.','.$m.','. $solicitud.','.$vehiculo.','.$cu['cupon_id'].','. $dep_id .')"';
                                    } else { echo 'disabled';}

                                    echo '><i class="fa fa-times"></i></button>';

                                    ?>
                                  <?php


                                  echo '</tr>';
                                }

                              ?>
                    </tbody>
                </table>







          <!-- Page JS Code -->
          <div id="dialog" title="Confirmation Required">
  
</div>
        </body>
        </html>

        <script src="combustible/js/devolver_cupones.js"></script>


        <?php
        else :
            echo include(unauthorizedModal());
        endif;
    else:
       echo "<script type='text/javascript'> window.location='../index.php'; </script>";
    endif;
?>
