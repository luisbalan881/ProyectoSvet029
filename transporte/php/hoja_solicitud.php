<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
require_once 'get_solicitud.php';

$id=$_POST['solicitud'];

$solicitud = get_solicitud_by_id($id);
$tipod='Minutos';
if($solicitud['TIPO_D']==1)
{
  $tipod='Hora(s)';
}
else if($solicitud['TIPO_D']==2){
  $tipod='Dia(s)';
}

$a = get_vehiculo_by_id($id);

$b = get_nombre_conductor($a['conductor_id']);
$c = get_nombre_vehiculo($a['vehiculo_id']);

$des='';
$mot='';
$ve='';
$pi='';
if($solicitud['DESTINO']!=''){
  $des=$solicitud['DESTINO'];
  $mot=$solicitud['MOTIVO'];
  $ve=$b['VEHICULO'];
  $pi=$c['NOMBRE'];
}

$comision='';
$array=array();
$comi = get_comision_by_solicitud_id($id);
foreach ($comi as $c)
{
  if($c['motivo']!=''){

    //$array[]='Destino : '.$c['destino'].',   Comision : '.$c['motivo'].'/';
    //$comision = $array;
    $comision .='Destino : '.$c['destino'].',   Comision : '.$c['motivo'].'f7';
  }
}

$return_arr = array(
                    'correlativo'=>$solicitud['IDX'],
                    'departamentos'=>$solicitud['DEP'],
                    'fecha'=>fecha_dmy($solicitud['FECHA']),
                    'salida'=>$solicitud['SALIDA'],
                    'duracion'=>$solicitud['DURACION'],
                    'tipo_duracion'=>$tipod,
                    'personas'=>$solicitud['CANT'],
                    'autorizado'=>$solicitud['ID_JEFE'],
                    'solicitante'=>$solicitud['NOMBRE'],
                    'destino'=>$comision,
                    'motivo'=>$mot,
                    'piloto'=>$pi,
                    'vehiculo'=>$ve,
                    'fecha_creacion'=>date('d-m-Y H:m:s', strtotime($solicitud['FECHA_C']))
                  );

echo json_encode($return_arr);

?>
