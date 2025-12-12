
<?php
include_once '../../inc/functions.php';
include_once 'funciones.php';



sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('leerCupon')):



      $data = array();

      $year=$_POST['year'];
      $mes=$_POST['mes'];
      $solicitud=$_POST['solicitud_id'];
      $dep_id=$_POST['dep_id'];

      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT T1.vehiculo_id,T1.nombre,T1.linea,T1.placa,T1.modelo,T1.rendimiento,
      T1.cilindraje,T1.combustible_id,T1.color,T1.status,T1.user_id,
      T1.vice_id, T1.capacidad, T1.status_uso, T1.comision_id,
      T2.monto,T2.estado_solicitud,T1.c_c,T1.tipo,
      CONCAT(T3.user_nm1, ' ', T3.user_nm2,' ',T3.user_ap1, ' ',T3.user_ap2)AS ENTREGADO_A,
      CONCAT(T6.user_nm1, ' ', T6.user_nm2,' ',T6.user_ap1, ' ',T6.user_ap2)AS RESPONSABLE,
      CONCAT(T8.user_nm1, ' ', T8.user_nm2,' ',T8.user_ap1, ' ',T8.user_ap2)AS solicitante,
      T7.comision_status,T7.comision_desc,DATE(T7.fecha_solicitud) as F_S,
      T9.dep_nm,T7.fecha_solicitud,T7.dis,T7.dias,T7.km_interno,T7.p_galon,T7.res_calculo

      FROM vp_vehiculo AS T1
      LEFT JOIN vp_solicitud_cupon_vehiculo AS T2 ON T2.vehiculo_id=T1.vehiculo_id
      LEFT JOIN vp_user AS T3 ON T3.user_id=T2.conductor_id
      LEFT JOIN vp_user AS T6 ON T1.user_id=T6.user_id
      LEFT JOIN vp_solicitud_cupon AS T7 ON T2.year=T7.year AND T2.mes=T7.mes AND T2.solicitud_id=T7.solicitud_id AND T2.dep_id=T7.dep_id
      LEFT JOIN vp_user AS T8 ON T7.solicitante_id=T8.user_id
      LEFT JOIN vp_deptos AS T9 ON T8.dep_id=T9.dep_id



      WHERE T2.year=? AND T2.mes=? AND T2.solicitud_id=? AND T2.dep_id=? ORDER BY T1.placa ASC, T1.vehiculo_id ASC
";

      $p = $pdo->prepare($sql);
      $p->execute(array($year,$mes,$solicitud,$dep_id));
      $vehiculos = $p->fetchAll();
      Database::disconnect();



      $comi = array();
      $comision='';
      if($dep_id==1)
      {
        $comision='Motivo: Combustible para uso de compras';
      }else
      if($dep_id==17)
      {
        $comision='Motivo: Combustible para uso de mensajería';
      }
      else
      if($dep_id==21)
      {
        $comision='Motivo: Comisiones Locales';
      }


      $array=array();
      $comi = get_comision_by_solicitud_id($year,$mes,$solicitud,$dep_id);
      if(count($comi)>0)
      {
        $comision='';
      }
      foreach ($comi as $c)
      {
        if($c['motivo']!=''){


          $comision .= 'Destino : '.$c['destino'].',   Comision : '.$c['motivo'].'f7';
        }
      }





      foreach($vehiculos as $vehiculo){
        $solicitud_id = 'Solicitud # '.$solicitud .' de la semana '. fecha_dmy($vehiculo['F_S']). ' del año '. $year;
        $sub_array = array(
                            'solicitud'=>$solicitud_id,
                            'placa'=>$vehiculo['placa'],
                            'vehiculo'=>$vehiculo['nombre'],
                            'linea'=>$vehiculo['linea'],
                             'rendimiento'=>$vehiculo['rendimiento'],
                            'modelo'=>$vehiculo['modelo'],
                            'color'=>$vehiculo['color'],
                            'cilindraje'=>$vehiculo['c_c'],
                            'responsable'=>$vehiculo['RESPONSABLE'],
                            'entregado_a'=>$vehiculo['ENTREGADO_A'],
                            'cilindros'=>$vehiculo['cilindraje'],
                            'combustible'=>$combustible[$vehiculo['combustible_id']],
                            'monto'=>$vehiculo['monto'],
                            'solicitante'=>$vehiculo['solicitante'],
                            'comision_status'=>$vehiculo['comision_status'],
                             'dis'=>$vehiculo['dis'],
                            'dias'=>$vehiculo['dias'],
                            'km_interno'=>$vehiculo['km_interno'],
                            'p_galon'=>$vehiculo['p_galon'],
                             'res_calculo'=>$vehiculo['res_calculo'],
                            'desc'=>$comision,
                            'departamento'=>$vehiculo['dep_nm'],
                            'fecha_solicitud'=>date('d-m-Y H:m:s', strtotime($vehiculo['fecha_solicitud']))
                          );
        $data[]=$sub_array;
      }

      $output = array(
        "data"    => $data
      );

echo json_encode($output);
else:
    echo include(unauthorized());
endif;
else:
header("Location: ../index.php");
endif;

?>
