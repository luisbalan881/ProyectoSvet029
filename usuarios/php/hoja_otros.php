<?php
require_once '../../inc/functions.php';
$id=$_POST['emp'];
$c = $_POST['correlativo'];
$persona = User::get_empleado_datos_id_por_correlativo($id,$c);
$persona1 = User::get_empleado_sueldo_byId_por_correlativo($id,$c);
$destitucion = User::get_empleado_datos_resolucion_id_por_correlativo($id,$c);

$r = $persona['renglon'];

$grupo = substr($r, -3, 1);
$subgrupo = substr($r, -2, 1);
$renglon = substr($r, -1, 1);
$r_n=get_renglon_by_id($grupo, $subgrupo,$renglon);

$dep = get_departamento_by_id($persona['dep_id']);
$nac = get_nacionalidad_by_id($persona['user_nacionalidad']);

$user_genre = array(1=> 'Masculino',2=>'Femenino');
$e_civil = array(1 => 'Soltero (a)', 2 => 'Casado (a)', 3=> 'Viudo (a)',4=>'Divorciado (a)');

$f_con='';
$f_ini='';
$f_fin='';
$f_inicio='';
$f_posesion='';
$f_destitucion='';
$f_res='';
if($persona['contrato_fecha']!='0000-00-00'){
  $f_con=fecha_dmy($persona['contrato_fecha']);
}
if($persona['contrato_ini']!='0000-00-00'){
  $f_ini=fecha_dmy($persona['contrato_ini']);
}
if($persona['contrato_fin']!='0000-00-00'){
  $f_fin=fecha_dmy($persona['contrato_fin']);
}
if($persona['inicio_laboral']!='0000-00-00'){
  $f_inicio=fecha_dmy($persona['inicio_laboral']);
  $f_posesion=fecha_dmy($persona['inicio_laboral']);
}

if($persona['fecha_destitucion']!='0000-00-00'){
  $f_destitucion=fecha_dmy($persona['fecha_destitucion']);
}

if($destitucion['resolucion_fecha']!='0000-00-00'){
  $f_res=fecha_dmy($destitucion['resolucion_fecha']);
}

$return_arr = array(

                    'nom_1'=>$persona['user_nm1'],
                    'nom_2'=>$persona['user_nm2'],
                    'ape_1'=>$persona['user_ap1'],
                    'ape_2'=>$persona['user_ap2'],
                    'fecha_nac'=>fecha_dmy($persona['f_n']),
                    'lugar_nac'=>$persona['user_lugar_nac'],
                    'e_civil'=>$e_civil[$persona['user_estado_civil']],
                    'e_nac'=>$nac['gentilicio'],
                    'e_genero'=>$user_genre[$persona['user_genero']],
                    'e_direccion'=>$persona['user_direccion'],
                    'e_cui'=>$persona['user_cui'],
                    'e_movil'=>$persona['user_movil'],
                    'e_prof'=>$persona['user_profesion'],

                    'renglon'=>$persona['renglon'],
                    'renglon_nm'=>$r_n['renglon_nm'],
                    'e_acuerdo'=>$persona['acuerdo_vice'],
                    'e_acuerdo_fecha'=>$persona['fecha_acuerdo'],
                    'e_partida'=>$persona['partida'],
                    'e_contrato'=>$persona['contrato_num'],
                    'contrato_fecha'=>$f_con,
                    'fianza'=>$persona['fianza'],
                    'c_ini'=>$f_ini,
                    'c_fin'=>$f_fin,
                    'dep'=>$dep['dep_nm'],
                    'cargo'=>$persona['user_nom'],
                    'puesto'=>$persona['user_puesto'],
                    'igss'=>$persona['user_igss'],
                    'nit'=>$persona['user_nit'],
                    'f_posesion'=>$f_posesion,
                    'f_inicio'=>$f_inicio,
                    'f_destitucion'=>$f_destitucion,
                    's_base'=>$persona1['salario_base'],
                    'b_66'=>$persona1['bono_66_2000'],
                    'b_v'=>$persona1['bono_vicepresidencial'],
                    'c_p'=>$persona1['complemento_personal'],
                    'b_a'=>$persona1['bono_antiguedad'],
                    'b_p'=>$persona1['bono_profesional'],
                    'g_r'=>$persona1['gastos_de_representacion'],
                    'total'=>$persona1['sueldo'],

                    'resolucion'=>$destitucion['resolucion_no'],
                    'resolucion_fecha'=>$f_res,
                    'literal'=>$destitucion['literal_id'].' - '. $destitucion['literal_desc'],

                    'foto'=>$persona['fotografia']
                  );

echo json_encode($return_arr);
?>
