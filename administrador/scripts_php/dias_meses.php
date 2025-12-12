<?php
require_once '../../inc/Database.php';
 $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
 $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

$Month = ($_POST["elegido"]);
$Year = ($_POST["elegidoy"]);


   //Si la extensión que mencioné está instalada, usamos esa.

      //Lo hacemos a mi manera.


      $date = date("d",mktime(0,0,0,$Month+1,0,$Year));


      $fecha1 = strtotime($Year.'-'.$Month.'-01');
      $fecha2 = strtotime($Year.'-'.$Month.'-'.$date);

echo '<thead>
    <tr>
        <th class="text-center" >Fecha</th>
        <th class="text-center">Dia</th>
        <th class="text-center">Dia Feriado</th>
</thead><tbody>';

      for($fecha1;$fecha1<=$fecha2;$fecha1=strtotime('+1 day ' . date('Y-m-d',$fecha1))){
        echo '<tr>';
        if((strcmp(date('D',$fecha1),'Sun')!=0) && (strcmp(date('D',$fecha1),'Sat')!=0)){
          $dia = date('l',$fecha1);
          echo '<td class="fecha" align="center">'. date('Y-m-d',$fecha1) . '</td>

          <td align="center">'.$nombredia = str_replace($dias_EN, $dias_ES, $dia)  . '</td>
          <td align="center" valign="middle">
          <div class="checkbox checkbox-circle checkbox-success">
          <input data-id='. date('Y-m-d',$fecha1). ' type="checkbox"/>
          <label></label>
          </div>
          </td>
          ';
        }

      }

        echo '</tr></tbody>';



?>
