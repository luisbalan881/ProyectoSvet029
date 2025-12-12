<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
require_once 'get_solicitudes.php';

$id=$_POST['solicitud'];

$solicitud = get_solicitud_by_id($id);
$solicitud1 = get_solicitud_by_id_solicitante($id);
$solicitud2 = get_solicitud_by_id_encargado($id);
$solicitud3 = get_solicitud_by_id_total($id);  // esto menos
$solicitud4 = get_solicitud_by_id_descripcion($id);//
$solicitud5 = get_solicitud_by_id_descripcion($id);//
$solicitud6 = get_solicitud_by_id_dia($id);
$solicitud7 = get_formulario($id);
$solicitud8 = get_solicitud_by_id_descripcion3($id); // esto total_liq
$reitegro = get_reitegro2($id);
$ampliacion= get_solicitud_by_id_total_ampliacion($id);
$t_ampliacion=get_solicitud_by_id_dia_ampliacion($id);

//$liquidado = get_liquidados($id);
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
$n2=30;
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



/*
foreach ($solicitud3 as $t1)
{
  

    //$array[]='Destino : '.$c['destino'].',   Comision : '.$c['motivo'].'/';
    //$comision = $array;
    $res1= $t1['total'];
  
}
 
 foreach ($solicitud8 as $t2)
{
  

    //$array[]='Destino : '.$c['destino'].',   Comision : '.$c['motivo'].'/';
    //$comision = $array;
    $res2 =$t2['total_liq'];
  
} 

$res= ($res1-$res2);

*/


/*
$var = get_totales($id);
foreach ($var as $d)
{
  

    //$array[]='Destino : '.$c['destino'].',   Comision : '.$c['motivo'].'/';
    //$comision = $array;
    $comi =$d['total'];
   

  
} */


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
                    'id1'=>$solicitud7['id_viatico'], //
                    'autorizado'=>$solicitud2['encargado'],
                    'solicitante'=>$solicitud['NOMBRE'],
                     'autorizado2'=>$solicitud1['nombre'],
                       'puesto'=>$solicitud1['user_puesto'],
                        'nit'=>$solicitud1['user_nit'],
                       'puesto2'=>$solicitud2['user_puesto'],
                         'desa'=>$solicitud8['tdesayunos'],//almu
                         'almu'=>$solicitud8['talmuerzos'],
                          'cena'=>$solicitud8['tcenas'],//almu
                         'hosp'=>$solicitud8['thospedaje'],
                         'tgas'=>$solicitud8['total_liq'],
                         'acantidad'=>$solicitud8['ampliacion_cantidad'],
                         'atiempo'=>$solicitud8['ampliacion_tiempo'],
                         'reitegro'=>$reitegro['total'],
                          'ampliacion'=>$ampliacion['totalAmpliacion'],
                          't_ampliacion'=>$t_ampliacion['t_ampliacion'],
                       //'desayuno'=>$liquidado['tdesayunos'],
                      // 'resu'=>$res,
                   // 'solicitante2'=>$sol doc.setFontType("normal");icitud1['user_ap1'],
                    'destino'=>$comision,
                    // 'destino2'=>$comi,
                    //'destino'=>$solicitud1['objetivo'],
                    'obj'=>$solicitud1['objetivo'],
                     'descripcion2'=>$solicitud5['descripcion'],
                    // 'fechaf'=>$solicitud5['fecha'],
                      'fechaf'=>fecha_dmy($solicitud7['fecha_liquidacion']),
                    'motivo'=>$mot,
                    'piloto'=>$pi,
                    'vehiculo'=>$ve,
                    'fecha_creacion'=>date('d-m-Y H:m:s', strtotime($solicitud1['fecha']))
                  );

echo json_encode($return_arr);

?>

