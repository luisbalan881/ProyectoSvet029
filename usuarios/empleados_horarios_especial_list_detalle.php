<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')) :

          $yearr = null;
          $semana = null;
          $personas = array();

            date_default_timezone_set('America/Guatemala');


            if ( !empty($_GET['year'])) {
              $yearr = $_REQUEST['year'];
            }

            if ( !empty($_GET['semana'])) {
              $semana = $_REQUEST['semana'];
            }



            if ( !empty($_POST)) {

                //User::suspencion_nueva($id);
                header("Location: index.php?ref=_35");

            }else{
              $personas=personas_por_semana_horario_especial($semana,$yearr);
            }





        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Modificar</title>



            <style>


            </style>

        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">


            <div class="block-content">

              <div class="col-xs-6">
                  <div id="datos_emp" class="input-group has-personalizado" style="margin-left:-15px">
                    <span  class="input-group-addon" disabled><strong id="titulo" class="">Detalle Horario </strong></span>
                    <span class="input-group-addon span-personalizado" type="text"><?php echo 'Semana No. '. $semana . ' del año: '.$yearr ?></span>
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
              <div>
                <?php
                $year=$yearr;
                $week=$semana;

                # obtenemos el timestamp del primer dia del año
                $timestamp=mktime(0, 0, 0, 1, 1, $year);

                # sumamos el timestamp de la suma de las semanas actuales
                $timestamp+=$week*7*24*60*60;

                # restamos la posición inicial del primer dia del año
                $ultimoDia=$timestamp-date("w", mktime(0, 0, 0, 1, 1, $year))*24*60*60;

                # le restamos los dias que hay hasta llegar al lunes
                $primerDia=$ultimoDia-86400*(date('N',$ultimoDia)-1);

                # mostramos la fecha correcta
                //echo "<br>Semana: ".$week." - año: ".$year;
                /*echo "<br><span style='width:160px'>Fecha ingreso :</span>".date("d-m-Y",$primerDia);
                echo "<br><span style='width:160px'>Fecha salida :</span>".date("d-m-Y",$ultimoDia);*/
                $lastday = date("d-m-Y",$ultimoDia);
                //echo '<br>'.date("d-m-Y",strtotime('+1 day', $lastday));


                ?>
                <br>
                <br>
                <table  class="table dt-responsive display nowrap" cellspacing="0" width="100%">
                  <tr class="weekpattern">
                      <th class="text-center "style="border-top:1px solid transparent"><br>Empleado</th>
                      <?php

                      for($x=0;$x<8;$x++){
                        echo '<th align="center" class="text-center "';

                        echo 'style="border-top:1px solid transparent">';
                        echo '<span class="label" style="color:#7f7f7f">'.User::get_nombre_dia(date("d-m-Y",strtotime('+'.$x.' day', $primerDia))).'</span><br>';
                        echo date("d-m-Y",strtotime('+'.$x.' day', $primerDia));

                        echo '</th>';
                      }

                      ?>

                  </tr>


                  <?php
                    foreach ($personas as $per):
                        echo '<tr id="x2" style="" ><th class="" style="border:1px solid #f7f7f7"><span class="">'.$per['nombre'].'</span></th>';

                        for ($x=1; $x<=8; $x++) {
                          echo '<td align="center" valign="middle" ';

                            echo 'style="border:1px solid #f7f7f7">';


                          $y=$x-1;
                          $datess = date("Y-m-d",strtotime('+'.$y.' day', $primerDia));


                          $verificar= User::verificar_horario_empleado_semanal($per['user_vid'],$datess);
                          if($verificar['FECHA']==$datess){
                            echo '<span class="btn-checkk" style="margin-top:5px;"></span>';
                          }
                          $n_p3= User::verificar_permiso_parcial_horas($per['user_vid'],$datess);


                          if($n_p3['descripcion']!='')
                          {

                            if($n_p3['tipo_suspencion'] == '2'){ echo '<span id="'.$datess.'/'.$n_p3['tipo_suspencion'].'/'.$per['user_id'].'" class="label label-warning mensajes">Permiso</span>';}
                            else if($n_p3['tipo_suspencion'] == '3'){ echo '<span id="'.$datess.'/'.$n_p3['tipo_suspencion'].'/'.$per['user_id'].'" class="label label-success" disabled>Feriado</span>';}
                            else if($$n_p3['tipo_suspencion'] == '4'){ echo '<span id="'.$datess.'/'.$n_p3['tipo_suspencion'].'/'.$per['user_id'].'" class="label label-info" mensajes>No Laboraba</span>';}
                            else if($n_p3['tipo_suspencion'] == '6'){ echo '<span id="'.$datess.'/'.$n_p3['tipo_suspencion'].'/'.$per['user_id'].'" class="label label-vacaciones" mensajes>Vacaciones</span>';}
                            else if($n_p3['tipo_suspencion'] == '7'){ echo '<span id="'.$datess.'/'.$n_p3['tipo_suspencion'].'/'.$per['user_id'].'" class="label label-warning" mensajes><i class="fa fa-hand-o-up"/>  Aún no marcaba</span>';}
                            else if($n_p3['tipo_suspencion'] == '5'){ echo '<span id="'.$datess.'/'.$n_p3['tipo_suspencion'].'/'.$per['user_id'].'" class="label label-primary" mensajes><i class="fa fa-heartbeat"/> -   Suspendido IGSS</span';}
                            //else if($n_p3['tipo_suspencion'] == '50'){ echo '<span id="'.$p['FECHA'].'/'.$p['LABOR'].'" class="label label-warning" mensajes>Permiso VP</span>';}
                            else{
                              echo '<span  id="'.$datess.'/'.$n_p3['tipo_suspencion'].'/'.$per['user_id'].'" class="label label-secondary mensajes">'.$n_p3['dia_nm'].'</span>';
                            }
                            echo '</div>';
                          }

                      echo '</td>';
                    }
                        echo '</tr>';
                    endforeach;
                  ?>
                </table>
                <?php
                //echo "<br>Semana: ".$week." - año: ".$year;
                $name = User::get_nombre_grupo_por_semana_year($semana,$yearr);
                echo '<br>Grupo: <strong style="margin-left:10px">'.$name['horario_especial_desc'].'</strong>';
                echo "<span style='margin-left:50px'>Fecha ingreso: </span><strong style='margin-left:10px'>".date("d-m-Y",$primerDia).'</strong>';
                echo "<span style='margin-left:50px'>Fecha salida: </span><strong style='margin-left:10px'>".date("d-m-Y",strtotime('+7 day', $primerDia)).'</strong>';


                ?>
              </div>
              <br>


            </div>

          </div>

          <!-- Page JS Code -->
          <script>
          $(document).ready(function() {
            // initialize tooltip
            show_message();

          } );
          </script>

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
