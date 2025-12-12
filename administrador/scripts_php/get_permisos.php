<?php
require_once '../../inc/Database.php';


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM vp_permisos";

$p = $pdo->prepare($sql);
$p->execute(array());
$roles = $p->fetchAll();
Database::disconnect();



echo '<thead >
        <tr>
          <th class="text-center" >ID</th>
          <th class="text-center" >PERMISO</th>
          <th class="text-center" >Acción</th>
        </tr>
    </thead>
    <tbody>';


        foreach ($roles as $rol){

            //echo '<td class="text-center">'.$p['NOMBRE'].'</td>';
            echo '<td class="text-center">'.($rol['perm_id']).'</td>';
            echo '<td class="text-center">'.$rol['perm_desc'].'</td>';
            echo '<td></td>';

            /*echo '<td class="text-center">'.(($p['E'] == '0')? '<span class="label label-danger">Llegó Tarde</span>':'<span class="label label-info"></span>').'</td>';
            echo '<td class="text-center">'.(($p['S'] == '1')? '<span class="label label-danger">Se fue temprano</span>':'<span class="label label-info"></span>').'</td>';*/

            echo '</tr>';
        }

echo '  </tbody>';

?>
