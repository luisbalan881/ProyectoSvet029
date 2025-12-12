<?php
require_once '../../inc/Database.php';
$empleado = $_POST['empleado'];
$pdo = Database::connect();

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql1 = "SELECT MAX(periodo_inicio) as p_i, MAX(periodo_final) as p_f FROM vp_user_periodo
        WHERE user_id=?";
$q1 = $pdo->prepare($sql1);
$q1->execute(array($empleado));
$per1 = $q1->fetch(PDO::FETCH_ASSOC);

if ($per1['p_i']!=''&&$per1['p_f']!='')
{
  $diferencia=contar_dias($per1['p_i'],$per1['p_f']);
  $nf1 = strtotime ( '+1 year' , strtotime ( $per1['p_i'] ) ) ;
  $pi = date ( 'Y-m-j' , $nf1 );
  $nf2 = strtotime ( '+1 year' , strtotime ( $per1['p_f'] ) ) ;
  $pf = date ( 'Y-m-j' , $nf2 );
  echo "Periodo Generado";

  $sql3 = "INSERT INTO vp_user_periodo (periodo_inicio,periodo_final,user_id,dias_total,dias_gozados,dias_pendiente)
          VALUES(?,?,?,?,?,?)";
  $q3 = $pdo->prepare($sql3);
  $q3->execute(array($pi,$pf,$empleado,20,0,20));

}
else
{
  $sql2 = "SELECT inicio_laboral FROM vp_user_datos_laborales
          WHERE user_id=?";
  $q2 = $pdo->prepare($sql2);
  $q2->execute(array($empleado));
  $per2 = $q2->fetch(PDO::FETCH_ASSOC);
  if($per2['inicio_laboral']!='0000-00-00')
  {
    $nf22 = strtotime ( '+1 year' , strtotime ( $per2['inicio_laboral'] ) ) ;
    $pf22 = date ( 'Y-m-j' , $nf22 );
    echo "Periodo Generado";
    $sql4 = "INSERT INTO vp_user_periodo (periodo_inicio,periodo_final,user_id,dias_total,dias_gozados,dias_pendiente)
            VALUES(?,?,?,?,?,?)";
    $q4 = $pdo->prepare($sql4);
    $q4->execute(array($per2['inicio_laboral'],$pf22,$empleado,20,0,20));
  }
  else {
    echo "El empleado no tiene establecido inicio laboral ";
  }
}

/*    else if ($width > 600 || $height > 600)
    {
        echo "<span class='label label-danger'>Error la anchura y la altura maxima permitida es 500px</span>";
    }
    else if($width < 200 || $height < 200)
    {
        echo "<span class='label label-danger'>Error la anchura y la altura mínima permitida es 200px</span>";
    }
    else
    {
        $src = $carpeta.$nombre;
        move_uploaded_file($ruta_provisional, $src);
        //echo "<img src='$src'>";

        echo $nombre;

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql2 = "UPDATE vp_user_datos_laborales SET fotografia=?WHERE user_id=?";
        $q2 = $pdo->prepare($sql2);
        $q2->execute(array($nombre,$empleado));


    }
*/

Database::disconnect();
function contar_dias($f1,$f2){
  $datetime1 = new DateTime($f1);
$datetime2 = new DateTime($f2);
$interval = $datetime1->diff($datetime2);
  $x = $interval->format('%R%a');
  return $x;

}
?>
