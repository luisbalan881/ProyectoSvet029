
<?php
include_once '../../inc/functions.php';
include_once 'funciones.php';



sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearCupon')):



      $data = array();

      $year=$_POST['year'];
      $mes=$_POST['mes'];
      $solicitud=$_POST['solicitud_id'];
      $dep_id=$_POST['dep_id'];


      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT T4.cupones,T4.montos, T1.vehiculo_id,T1.nombre,T1.linea,T1.placa,T1.modelo,
      T1.cilindraje,T1.combustible_id,T1.color,T1.status,T1.user_id,
      T1.vice_id, T1.capacidad, T1.status_uso, T1.comision_id,
      T2.monto,T2.estado_solicitud,T2.km_ini,T2.km_fin,T2.galones_consumidos,T2.destino,(T2.km_fin-T2.km_ini) AS km_re,T1.c_c,T1.tipo,
      CONCAT(T3.user_nm1, ' ', T3.user_nm2,' ',T3.user_ap1, ' ',T3.user_ap2)AS ENTREGADO_A,
      CONCAT(T6.user_nm1, ' ', T6.user_nm2,' ',T6.user_ap1, ' ',T6.user_ap2)AS RESPONSABLE,
      T5.fecha_autorizado
      FROM vp_vehiculo AS T1
      LEFT JOIN vp_solicitud_cupon_vehiculo AS T2 ON T2.vehiculo_id=T1.vehiculo_id
      LEFT JOIN vp_user AS T3 ON T3.user_id=T2.conductor_id
      LEFT JOIN vp_user AS T6 ON T1.user_id=T6.user_id
      LEFT JOIN (SELECT GROUP_CONCAT(T2.cupon_id  SEPARATOR ',') AS cupones,
                 GROUP_CONCAT(T3.monto SEPARATOR ',') AS montos,T2.dep_id,


           		T2.vehiculo_id, T2.year,T2.mes,T2.solicitud_id

				FROM vp_cupon_vehiculo_entregado AS T2
                 INNER JOIN vp_cupon AS T3 ON T3.cupon_id=T2.cupon_id
                 GROUP BY T2.vehiculo_id, T2.year,T2.mes,T2.solicitud_id


           		) AS T4 ON T4.vehiculo_id=T2.vehiculo_id AND T4.year=T2.year AND T4.mes=T2.mes AND T4.solicitud_id=T2.solicitud_id AND T4.dep_id=T2.dep_id
                LEFT JOIN vp_solicitud_cupon AS T5 ON T2.year=T5.year AND T2.mes=T5.mes AND T2.solicitud_id=T5.solicitud_id AND T2.dep_id=T5.dep_id



      WHERE T2.year=? AND T2.mes=? AND T2.solicitud_id=? AND T2.dep_id=? ORDER BY T1.placa ASC, T1.vehiculo_id ASC
";

      $p = $pdo->prepare($sql);
      $p->execute(array($year,$mes,$solicitud,$dep_id));
      $vehiculos = $p->fetchAll();
      Database::disconnect();

      $solicitud_id = 'Solicitud # '.$solicitud .' del mes de '. get_nombre_mes($mes). ' del año '. $year;


      foreach($vehiculos as $vehiculo){
        $sub_array = array(
                            'solicitud'=>$solicitud_id,
                            'placa'=>$vehiculo['placa'],
                            'vehiculo'=>$tipo_vehiculo[$vehiculo['tipo']].' - '. $vehiculo['nombre'],
                            'linea'=>$vehiculo['linea'],
                            'modelo'=>$vehiculo['modelo'],
                            'color'=>$vehiculo['color'],
                            'cilindraje'=>$vehiculo['c_c'],
                            'responsable'=>$vehiculo['RESPONSABLE'],
                            'entregado_a'=>$vehiculo['ENTREGADO_A'],
                            'cilindros'=>$vehiculo['cilindraje'],
                            'combustible'=>$combustible[$vehiculo['combustible_id']],
                            'cupones'=>$vehiculo['cupones'],
                            'montos'=>$vehiculo['montos'],
                            'km_ini'=>$vehiculo['km_ini'],
                            'km_fin'=>$vehiculo['km_fin'],
                            'galones_consumidos'=>$vehiculo['galones_consumidos'],
                            'destino'=>$vehiculo['destino'],
                            'km_re'=>$vehiculo['km_re'],
                            'fecha_autorizado'=>fecha_dmy($vehiculo['fecha_autorizado'])
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
