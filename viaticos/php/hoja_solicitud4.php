<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
require_once 'get_solicitud.php';

$id=$_POST['solicitud'];

$solicitud = get_solicitud_by_id($id);
$solicitud1 = get_solicitud_by_id_solicitante($id);
$solicitud2 = get_solicitud_by_id_encargado($id);
$solicitud3 = get_solicitud_by_id_total($id);
$solicitud4 = get_solicitud_by_id_descripcion($id);
$solicitud5 = get_solicitud_by_id_descripcion($id);
$solicitud6 = get_solicitud_by_id_dia($id);
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
//$id2 = 921;
$comi = get_comision_by_solicitud_id2($id);
foreach ($comi as $c)
{
  

    //$array[]='Destino : '.$c['destino'].',   Comision : '.$c['motivo'].'/';
    //$comision = $array;
    $comision .='Descripcion : '.$c['descripcion'].',   Dia : '.$c['dia'].'f7';
  
}

$return_arr = array(
                    'correlativo'=>$solicitud1['cod_nombramiento'],
                    'departamentos'=>$solicitud1['dep_nm'],
                    'fecha'=>fecha_dmy($solicitud1['fecha_inicio']),
                    'fecha2'=>fecha_dmy($solicitud1['fecha_fin']),
                    'fecha1'=>fecha_dmy($solicitud1['fecha']),
                    //'salida'=>$solicitud['SALIDA'],
                    //'duracion'=>$solicitud['DURACION'],
                     'lugar1'=>$solicitud1['lugar'],
                    //'tipo_duracion'=>$tipod,
                    'Total'=>$solicitud3['total'], 
                    'Total2'=>$solicitud6['totald'], 
                    'id1'=>$solicitud1['id_nombramiento'],
                    'autorizado'=>$solicitud2['encargado'],
                    'solicitante'=>$solicitud['NOMBRE'],
                     'autorizado2'=>$solicitud1['nombre'],
                       'puesto'=>$solicitud1['user_puesto'],
                       'puesto2'=>$solicitud2['user_puesto'],
                   // 'solicitante2'=>$sol doc.setFontType("normal");icitud1['user_ap1'],
                    'destino'=>$comision,
                    //'destino'=>$solicitud1['objetivo'],
                    'obj'=>$solicitud1['objetivo'],
                     'descripcion2'=>$solicitud5['descripcion'],
                    'motivo'=>$mot,
                    'piloto'=>$pi,
                    'vehiculo'=>$ve,
                    'fecha_creacion'=>date('d-m-Y H:m:s', strtotime($solicitud1['fecha']))
                  );

echo json_encode($return_arr);

?>
