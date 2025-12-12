<?php
include_once '../inc/functions.php';
sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('leerCupon')):
      include_once 'php/funciones.php';
      $fechm= $_POST['mm'];
      $fechm2= $_POST['mm2'];
      $fecha= $_POST['yy'];
      $cupones = cupones_utilizados_mes($fechm,$fechm2,$fecha);

        ?>

        <!-- INICIO Contenido de pagina -->


        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title> Reporte de Cupones Mensual</title>
            <script src="combustible/js/funciones_reporte.js"></script>
            <style>
            @page{
              size: landscape;
            }

            @media print {
              .panel-heading {display:none}
              .tag-green { display:none }
              .block-options2 { display:none }
              .page-heading{display: none;}
              .pagination{display: none;}
              #tabla{ display: none;}
              #tabla1{ display: none; }
              #d{ display: none; }
              #de{display: none; }
              button{ display: none }
              #suspenciones {transform: scale(0.8);padding-top: 0.5cm;}
              #cupones_us_listado{transform: scale(1);padding-top: 1cm;padding-left:20px}
              #page-footer{display: none}
              #datos_emp{font-size: 16px;}
              #printe{display: none;}
              #filters{display: none;}
              #buscador{display: none;}
              .breadcrumb{display: none;}


            }
            @page{size:  35.7cm 25cm; margin: 5mm 5mm 5mm 5mm;}@media print{#filters{display: none;}.pagination{display: none;}#cupones_us_listado {    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;    border-collapse: collapse;    width: 100%;}#cupones_us_listado td, #cupones_us_listado th {    border: 1px solid transparent; padding: 8px;}#cupones_us_listado tr:nth-child(even){background-color: #f9f9f9}#cupones_us_listado tr:hover {background-color: #ddd;}#cupones_us_listado th {    padding-top: 12px;    padding-bottom: 12px;    text-align: left;    background-color: #006c87;    border:1px solid #006c87;    color: white; font-weight:normal} td{font-size:12px; border-bottom:1px solid #ccc} th{float:center; height:3em}h1{font-size:24px;font-family:Arial;font-weight:normal} thead{border-radius:2px} td{text-align:right;border:1px solid transparent}
            </style>
        </head>
        <body >
          <?php
          if(count($cupones)>0)
          {

            $total=0;

          ?>
          <div id="para_print">
                    <table id="cupones_us_listado" class="table table-condensed table-striped  dt-responsive display nowrap" cellspacing="0" width="100%">
                      <thead >
                        <tr id="filters" class="tr-borde-personalizado">
                          <th style="border-left:1px solid transparent; border-right:1px solid transparent"></th>

                          <th style="border-right:1px solid transparent"></th>
                          <th style="border-right:1px solid transparent"></th>
                          <th style="border-right:1px solid transparent"></th>
                          <th style="border-right:1px solid transparent"></th>
                          <th style="border-right:1px solid transparent"></th>
                          <th style="border-right:1px solid transparent"></th>
                          <th style="border-right:1px solid transparent" colspan="3"><span class="btn btn-secondary" id="btnImprimir" onclick="imprimir(<?php echo "'".get_nombre_mes($fechm)."'";?>, <?php echo "'".get_nombre_mes($fechm2)."'";?>,<?php echo $fechm2 ?>,<?php echo $fecha ?>)"><i class="fa fa-print"></i> Imprimir</span></th>

                      </tr>
                              <tr>
                                  <th id="cuposs" class="text-center">Cupon</th>
                                  <th id="cuposs" class="text-center">Monto</th>
                                  <!--<th class="text-center" >Dia</th>-->
                                  <th class="text-center" >Fecha</th>
                                  <th class="text-center" >Vechiculo</th>
                                  <th class="text-center" >Línea</th>
                                  <th class="text-center">Placa</th>
                                  <th class="text-center" width="5%">Responsable</th>
                                  <th class="text-center">Km_i/Km_f</th>
                                  <th class="text-center">Kms</th>
                                  <th class="text-center">Solicitado</th>
                                  <th class="text-center">Subtotal</th>





                              </tr>

                          </thead>
                          <tbody>
                            <?php


                                  foreach ($cupones as $s){

                                    $tickets=explode(",",$s['cupones']);
                                    $monto=explode(",",$s['monto1']);

                                      echo '<tr>';
                                      //echo '<td class="text-center">'.$p['NOMBRE'].'</td>';
                                      echo '<td class="text-center">';
                                      foreach($tickets as $t)
                                      {
                                        //echo '<i class="fa fa-ticket">';

                                          echo '</i><span class="label label-vacaciones label-personalizado" style="float:right; width:65px; margin-left:3px;margin-top:2px;">'.$t.'</span>  ';


                                        echo '<br>';
                                      }
                                      echo '</td>';
                                      echo '<td class="text-right">';
                                      foreach($monto as $t)
                                      {
                                        //echo '<i class="fa fa-ticket">';
                                        $mystring = $t;
                                        $parts = explode("-",$mystring);

                                        //break the string up around the "/" character in $mystring
                                        $mystring = $parts['0'];
                                        $valor =$parts['1'];

                                           if($valor==1)
                                           {
                                             echo '</i><span class="label label-success label-personalizado" style="float:right; width:65px; margin-left:3px;margin-top:2px;">'.$mystring.'</span>  ';
                                           }
                                           else if($valor==2){
                                             echo '</i><span class="label label-danger label-personalizado" style="float:right; width:65px; margin-left:3px;margin-top:2px;">- '.$mystring.'</span>  ';
                                           }
                                           else {
                                             echo '</i><span class="label label-warning label-personalizado" style="float:right; width:65px; margin-left:3px;margin-top:2px;">'.$mystring.'</span>  ';
                                           }



                                        echo '<br>';
                                      }
                                      echo '</td>';
                                      //echo '<td class="text-center">'.get_nombre_dia($s['FECHA']).'</td>';
                                      echo '<td class="text-center tabla-personalizada-text">';
                                      if($s['fecha_autorizado']!=null)
                                      {
                                        echo date('d-m-Y', strtotime($s['fecha_autorizado']));
                                      }
                                      else {
                                        echo 'Sin asignar';
                                      }
                                      echo '</td>';
                                      echo '<td class="text-center tabla-personalizada-text">'.$s['nombre'].'</td>';
                                      echo '<td class="text-center tabla-personalizada-text">'.$s['linea'].'</td>';
                                      echo '<td class="text-center tabla-personalizada-text">'.$s['placa'].'</td>';
                                      echo '<td class="text-center tabla-personalizada-text">'.$s['NOMBRE'].'</td>';
                                      echo '<td class="text-center tabla-personalizada-text">'.$s['km_ini'].' / '.$s['km_fin'].'</td>';
                                      //$fi = "".fecha_dmy($s['fecha_entregado'])."";
                                      echo '<td class="text-center" style="font-size:12px;">'.$s['km_re'].'</td>';
                                      echo '<td class="text-right" style="font-size:12px;">'.$s['monto'].'</td>';
                                      echo '<td class="text-right cell tabla-personalizada-text">';
                                      if($s['montos']!=''){
                                        echo $s['montos'];
                                      }else {
                                        echo '0.00';
                                      }
                                      echo '</td>';
                                      //echo '<td class="text-center" style="font-size:12px;"><span class="btn btn-xs  btn-personalizado outline" data-toggle="modal" data-target="#modal-remoto" href="combustible/cupon_vehiculo_modificar.php?fecha='.$fi.'&vehiculo_id='.$s['vehiculo_id'].'"><i class="fa fa-pencil"></i></span></td>';
                                      $total+=$s['montos'];




                                      echo '</tr>';
                                    }

                                  ?>
                        </tbody>
                        <tfoot>
                          <th style="border-right:1px solid transparent" colspan="11" class="text-right">Total: Q <?php echo $total?>.00</span></th>
                        </tfoot>
                    </table>
                  </div>
                    <?php

                  }
                  else {
                    echo '<p>El mes seleccionado no presenta ningún movimiento</p>';
                  }
                    ?>


        </body>



        </html>
        <!-- FIN Contenido de Pagina -->
        <?php
    else:
        //echo include(unauthorized());
    endif;
else:
  //echo "<script type='text/javascript'> window.location='../herramientas/inicio.php'; </script>";
endif;
?>
