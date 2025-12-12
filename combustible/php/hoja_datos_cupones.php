

<?php
include_once '../../inc/functions.php';


sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearCupon')):



      $year=$_POST['year'];
      $mes=$_POST['mes'];
      $solicitud=$_POST['solicitud_id'];
      $vehiculo=$_POST['vehiculo_id'];

      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT T1.vehiculo_id,T1.nombre,T1.linea,T1.placa,T1.modelo,T1.c_c,T1.tipo,
              T1.cilindraje,T1.combustible_id,T1.color,T1.status,T1.user_id, T1.vice_id, T1.capacidad, T1.status_uso, T1.comision_id,
              T2.monto,T2.estado_solicitud,
              CONCAT(T3.user_nm1, ' ', T3.user_nm2,' ',T3.user_ap1, ' ',T3.user_ap2)AS NOMBRE
              FROM vp_vehiculo AS T1
              INNER JOIN vp_solicitud_cupon_vehiculo AS T2 ON T2.vehiculo_id=T1.vehiculo_id
              INNER JOIN vp_user AS T3 ON T3.user_id=T2.conductor_id
              WHERE T2.year=? AND T2.mes=? AND T2.solicitud_id=? AND T2.vehiculo_id=? ";
      $q = $pdo->prepare($sql);
      $q->execute(array($year,$mes,$solicitud,$vehiculo));
      $vehiculo = $q->fetch(PDO::FETCH_ASSOC);
      Database::disconnect();

      $solicitud_id = 'Solicitud # '.$solicitud .' del mes de '. get_nombre_mes($mes). ' del año '. $year;

      $return_arr = array(

                          'solicitud'=>$solicitud_id,
                          'placa'=>$vehiculo['placa'],
                          'marca'=>$vehiculo['nombre'],
                          'linea'=>$vehiculo['linea'],
                          'modelo'=>$vehiculo['modelo'],
                          'color'=>$vehiculo['color'],
                          'cilindraje'=>$vehiculo['c_c'],
                          'responsable'=>$vehiculo['NOMBRE'],
                          'cilindros'=>$vehiculo['cilindraje']
                        );

      echo json_encode($return_arr);

else:
    echo include(unauthorized());
endif;
else:
header("Location: ../index.php");
endif;

?>
