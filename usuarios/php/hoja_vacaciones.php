<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
$emp = $_POST['emp'];
$resolucion = $_POST['resolucion'];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT CONCAT(T3.user_nm1, ' ',T3.user_nm2, ' ',T3.user_ap1, ' ',T3.user_ap2) AS nombre,
        T3.user_genero,
        T3.user_nom,
        T1.periodo_inicio, T1.periodo_final,
        T2.fecha_ini, T2.fecha_fin,
        T2.fecha_regreso,
        T2.fecha_notificacion,
        DAY(T2.fecha_notificacion) AS DIA,
        MONTH(T2.fecha_notificacion) AS MES,
        YEAR(T2.fecha_notificacion) AS ANIO,
        T1.dias_solicitados, (20 -T1.dias_solicitados) AS dp_primeros
        FROM vp_user_periodo_resolucion as T1
        INNER JOIN vp_user_suspenciones AS T2 ON T2.resolucion=T1.resolucion
        INNER JOIN vp_user AS T3 ON T1.user_id=T3.user_id

        WHERE T1.resolucion=? AND T1.user_id=?";
$q = $pdo->prepare($sql);
$q->execute(array($resolucion,$emp));
$hoja = $q->fetch(PDO::FETCH_ASSOC);

$sql1 = "SELECT sum(T1.dias_solicitados) AS dg, (20 - (sum(T1.dias_solicitados)+?) )as dp
         FROM vp_user_periodo_resolucion AS T1
         INNER JOIN vp_user_suspenciones AS T2 ON T2.resolucion=T1.resolucion
         WHERE T1.user_id=?
         AND T1.periodo_inicio=? AND T1.periodo_final=?
         AND T2.fecha_ini<? AND T2.fecha_fin<?";
$q1 = $pdo->prepare($sql1);
$q1->execute(array($hoja['dias_solicitados'],$emp,$hoja['periodo_inicio'],$hoja['periodo_final'],$hoja['fecha_ini'],$hoja['fecha_fin']));
$dias = $q1->fetch(PDO::FETCH_ASSOC);

$sql2 = "SELECT CONCAT(T1.user_nm1,' ', T1.user_nm2,' ',T1.user_ap1,' ',T1.user_ap2) AS nombre, T1.user_puesto
         FROM vp_user AS T1
         INNER JOIN vp_user_suspenciones AS T2 ON T2.rrhh_autorizado=T1.user_id
         WHERE T2.resolucion=?";
$q2 = $pdo->prepare($sql2);
$q2->execute(array($resolucion));
$dj = $q2->fetch(PDO::FETCH_ASSOC);


Database::disconnect();

$fr;
$f;
$fn;

if($hoja['fecha_regreso']=='0000-00-00')
{
  $fr='Debe actualizar la fecha de Regreso';
}
else
{
  $fr = fecha_dmy($hoja['fecha_regreso']);
}

if($hoja['fecha_notificacion']=='0000-00-00')
{
  $fn='Debe actualizar la fecha de Notificacion';
}
else
{
  $fn = fecha_dmy($hoja['fecha_notificacion']);
}

$pi = fecha_dmy($hoja['periodo_inicio']);
$pf = fecha_dmy($hoja['periodo_final']);
$fi = fecha_dmy($hoja['fecha_ini']);
$ff = fecha_dmy($hoja['fecha_fin']);
$date= fecha_dmy(date('Y-m-d'));
if($hoja['ANIO']=='0000')
{
  $f='Debe establecer la fecha que se le notificará al empleado';
}
else{
  $mes = $hoja['MES'];
  $f = 'Guatemala '.$hoja['DIA'] .' de '. get_nombre_mes($mes). ' del '. $hoja['ANIO'];
}

$dp;
$dg;

if($dias['dp']=='')
{
  $dp=$hoja['dp_primeros'];//esto va a ser cuando no existan días de donde sumar
}
else {
  $dp=$dias['dp'];
}

if($dias['dg']=='')
{
  $dg='0';
}
else {
  $dg=$dias['dg'];
}

$return_arr = array(
                    'fecha'=>$f,
                    'date'=>$date,
                    'emp'=>$hoja['nombre'],
                    'genre'=>$hoja['user_genero'],
                    'cargo'=>$hoja['user_nom'],
                    'periodo_i'=>$pi,
                    'periodo_f'=>$pf,
                    'fecha_i'=>$fi,
                    'fecha_f'=>$ff,
                    'fecha_n'=>$fn,
                    'fecha_r'=>$fr,
                    'dias_s'=>$hoja['dias_solicitados'],
                    'dias_p'=>$dp,
                    'dias_g'=>$dg,
                    'autorizado'=>$dj['nombre'],
                    'puesto'=>$dj['user_puesto']
                  );

echo json_encode($return_arr);

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

 ?>
