<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
require_once 'get_solicitudes.php';

$id=$_POST['solicitud'];

$solicitud = get_solicitud_by_id($id);
$solicitud1 = get_solicitud_by_id_solicitante($id);
$solicitud2 = get_solicitud_by_id_encargado($id);
$solicitud3 = get_solicitud_by_id_total($id);
$solicitud4 = get_solicitud_by_id_descripcion($id);
$solicitud5 = get_solicitud_by_id_descripcion($id);
$solicitud6 = get_solicitud_by_id_dia($id);
$solicitud7 = get_formulario($id);
$solicitud8 = get_solicitud_by_id_1ertotal ($id);
$solicitud9 = get_solicitud_by_id_dia1er($id);
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

$comision2='';
$array=array();
$comi2 = get_detalle_ampliacion($id);
foreach ($comi2 as $c2)
{
  

    //$array[]='Destino : '.$c['destino'].',   Comision : '.$c['motivo'].'/';
    //$comision = $array;
    $comision2 .='Descripcion : '.$c2['descripcion'].',   Dia : '.$c2['dia'].',   Valor : '.$c2['valor2'].'f7';
  
}

$return_arr = array(
                    'correlativo'=>$solicitud1['cod_nombramiento'],
                    'departamentos'=>$solicitud1['dep_nm'],
                    'fecha'=>fecha_dmy($solicitud1['fecha_inicio']),
                    'fecha2'=>fecha_dmy($solicitud1['fecha_fin']),
                    'fecha1'=>fecha_dmy($solicitud1['fecha']),
                    'fecha_liq'=>fecha_dmy($solicitud1['fecha_liquidacion']),
                    //'salida'=>$solicitud['SALIDA'],
                    //'duracion'=>$solicitud['DURACION'],
                     'lugar1'=>$solicitud1['lugar'],
					 
					 
                    //'tipo_duracion'=>$tipod,
                    'Total'=>$solicitud3['total'], 
					'TotalRecibido'=>$solicitud8['total'], 
                    'Total2'=>$solicitud6['totald'], 
					 'Totalsolicitado'=>$solicitud9['totald'],
                    'id1'=>$solicitud7['id_viatico'], //
                    'autorizado'=>$solicitud2['encargado'],
                    'solicitante'=>$solicitud['NOMBRE'],
                     'autorizado2'=>$solicitud1['nombre'],
                       'puesto'=>$solicitud1['user_puesto'],
                        'nit'=>$solicitud1['user_nit'],
						'cui'=>$solicitud1['user_cui'],
						// 'nit'=>$solicitud1['user_nit'],
                         'obj2'=>$solicitud1['objetivod'],
                         'act'=>$solicitud1['actividades'],
                         'log'=>$solicitud1['logros'],
                       'puesto2'=>$solicitud2['user_puesto'],
                   // 'solicitante2'=>$sol doc.setFontType("normal");icitud1['user_ap1'],
                    'destino'=>$comision,
					 'destino2'=>$comision2,
                    //'destino'=>$solicitud1['objetivo'],
                    'obj'=>$solicitud1['objetivo'],
					  'just'=>$solicitud1['justificacion_ampliacion'],
                     'descripcion2'=>$solicitud5['descripcion'],
                    'motivo'=>$mot,
                    'piloto'=>$pi,
                    'vehiculo'=>$ve,
                    'fecha_creacion'=>date('d-m-Y H:m:s', strtotime($solicitud1['fecha']))
                  );

echo json_encode($return_arr);

?>

