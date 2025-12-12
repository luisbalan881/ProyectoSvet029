<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
sec_session_start();
if (function_exists('login_check') && login_check() == true) :
  if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')) :

    $user = $_POST['user_id'];
    $year=2018;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT CONCAT(T1.user_nm1, ' ', T1.user_nm2, ' ', T1.user_ap1, ' ', T1.user_ap2) as nombre,T1.user_id,T1.user_vid,T3.semana
            FROM vp_user AS T1

            INNER JOIN vp_user_horario_semana_detalle AS T3 ON T3.user_id=T1.user_id

            WHERE  T3.year=? AND T1.user_id=?";
    $p = $pdo->prepare($sql);
    $p->execute(array($year,$user));
    $semanas = $p->fetchAll();
    Database::disconnect();


    $emp = User::get_empleado_datos_id($user);



?>
  <!DOCTYPE html>
  <html>
  <head>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <title></title>


  </head>
  <body>
    <div class="">
        <ul class="block-options2" style="margin-top:-31px;margin-left:15px">
            <li>
                <button onclick="load_usuarios_por_grupo_list()"><i class="btn-regresar"></i></button>
            </li>
        </ul>


    </div>
    <br>
<?php





foreach($semanas as $s)
{
  $week=$s['semana'];
  $timestamp=mktime(0, 0, 0, 1, 1, $year);
  $timestamp+=$week*7*24*60*60;
  $ultimoDia=$timestamp-date("w", mktime(0, 0, 0, 1, 1, $year))*24*60*60;
  $primerDia=$ultimoDia-86400*(date('N',$ultimoDia)-1);
  $lastday = date("d-m-Y",$ultimoDia);

?>
 <table id="user_detalle_grupo_h" class="table-sm table-bordered table-condensed table-striped   display nowrap" cellspacing="0" width="100%" style="margin-left:auto; margin-right:auto;">
   <thead >
           <tr>
           <th class="text-center">SEMANA</th>
           <?php
           for($x=0;$x<8;$x++){
             echo '<th align="center" class="text-center "';

             echo 'style="">';
             echo '<span class="label" style="color:#7f7f7f">'.User::get_nombre_dia(date("d-m-Y",strtotime('+'.$x.' day', $primerDia))).'</span><br>';
             echo date("d-m-Y",strtotime('+'.$x.' day', $primerDia));

             echo '</th>';
           }
           ?>
           </tr>
       </thead>
       <tbody>
         <tr>
           <td class="text-center"><strong><?php echo $s['semana']?></strong></td>
           <?php
           for ($x=1; $x<=8; $x++) {
             echo '<td align="center" valign="middle" ';

               echo 'style="border:1px solid #f7f7f7">';


             $y=$x-1;
             $datess = date("Y-m-d",strtotime('+'.$y.' day', $primerDia));


             $verificar= User::verificar_horario_empleado_semanal($s['user_vid'],$datess);
             if($verificar['FECHA']==$datess){
               echo '<span class="btn-checkk" style="margin-top:-8px;"></span>';
             }
             $n_p3= User::verificar_permiso_parcial_horas($s['user_vid'],$datess);


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
           ?>
         </tr>




   </tbody>

 </table>
 <br>
<?php }?>
 <script>
 $(document).ready(function(){
   var nm = <?php echo "'".$emp['user_nm1']. '  '.$emp['user_nm2'].' '.$emp['user_ap1'].' '.$emp['user_ap2']."'"?>;
   $('#este_titulo').text(nm);
   show_message();
 });
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
