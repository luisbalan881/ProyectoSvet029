<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
$emp = $_POST['id'];
$mes = $_POST['mes'];
$year = $_POST['year'];
$data = array();

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT CONCAT(T1.user_nm1, ' ',T1.user_nm2, ' ' , T1.user_ap1, ' ', T1.user_ap2) AS nombre,
T2.fecha_laboral, T2.tipo_dia_laboral,T2.hora_en,T2.hora_sal,
T3.dep_nm,T4.dia_nm,
SEC_TO_TIME((TIMESTAMPDIFF(MINUTE , T2.hora_en, T2.hora_sal ))*60) as HORAS

FROM vp_user AS T1
INNER JOIN vp_user_horario_general AS T2 ON T2.user_vid=T1.user_vid
INNER JOIN vp_deptos AS T3 ON T1.dep_id=T3.dep_id
INNER JOIN vp_catalogo_dia_laboral AS T4 ON T2.tipo_dia_laboral=T4.dia_laboral_id
WHERE T1.user_id=? AND MONTH(T2.fecha_laboral)=? AND YEAR(T2.fecha_laboral)=?";
$q = $pdo->prepare($sql);
$q->execute(array($emp,$mes,$year));
$horarios = $q->fetchAll();

$sql1 = "SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( SEC_TO_TIME((TIMESTAMPDIFF(MINUTE , T2.hora_en, T2.hora_sal ))*60) ) ) ) AS TOTAL
FROM vp_user AS T1
INNER JOIN vp_user_horario_general AS T2 ON T2.user_vid=T1.user_vid

WHERE T1.user_id=? AND MONTH(T2.fecha_laboral)=? AND YEAR(T2.fecha_laboral)=?";
$q1 = $pdo->prepare($sql1);
$q1->execute(array($emp,$mes,$year));
$hh=$q1->fetch();

Database::disconnect();


foreach($horarios as $h){
  $dia_trabajado='';
  if($h['tipo_dia_laboral']!=1)
  {
    $dia_trabajado=$h['dia_nm'];
  }

  $sub_array = array(

                      'emp'=>$h['nombre'],
                      'fecha_laboral'=>fecha_dmy($h['fecha_laboral']),
                      'departamento'=>$h['dep_nm'],
                      'hora_en'=>$h['hora_en'],
                      'hora_sal'=>$h['hora_sal'],
                      'dia'=>get_nombre_dia($h['fecha_laboral']),
                      'tipo_dia'=>$dia_trabajado,
                      'horas'=>substr($h['HORAS'], 0, -3),
                      'titulo'=>get_nombre_mes($mes). ' del '.$year,
                      'total'=>substr($hh['TOTAL'], 0, -3)
                    );
                    $data[]=$sub_array;
                  }

                  $output = array(
                    "data"    => $data
                  );

                  echo json_encode($output);

function get_nombre_mes($n){

//el parametro w en la funcion date indica que queremos el dia de la semana
//lo devuelve en numero 0 domingo, 1 lunes,....
switch ($n){
case 1: return "enero"; break;
case 2: return "febrero"; break;
case 3: return "marzo"; break;
case 4: return "abril"; break;
case 5: return "mayo"; break;
case 6: return "junio"; break;
case 7: return "julio"; break;
case 8: return "agosto"; break;
case 9: return "septiembre"; break;
case 10: return "octubre"; break;
case 11: return "noviembre"; break;
case 12: return "diciembre"; break;
}
}

function get_nombre_dia($fecha){
$fechats = strtotime($fecha); //pasamos a timestamp

//el parametro w en la funcion date indica que queremos el dia de la semana
//lo devuelve en numero 0 domingo, 1 lunes,....
switch (date('w', $fechats)){
case 0: return "Domingo"; break;
case 1: return "Lunes"; break;
case 2: return "Martes"; break;
case 3: return "Miercoles"; break;
case 4: return "Jueves"; break;
case 5: return "Viernes"; break;
case 6: return "Sabado"; break;
}
}

 ?>
