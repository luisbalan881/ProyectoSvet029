<?php
header('Content-Type: text/html; charset=utf-8');
include_once '../inc/functions.php';
include_once 'funciones_cupones.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('leerCupon')):
        $id = null;
        $fecha_inicio = null;
        $fecha_fin = null;
        $vehiculo = array();
        $vehiculo_cupones = array();
        $monthYear = null;
        $user = null;
        $cuponTotal = 0.00;
        $maxLineas = 12;
        if ( !empty($_POST)) {
            $vehiculo_id = $_POST['vehiculo_id'];
            $fecha_inicio = fecha_ymd($_POST['fecha_inicio']);
            $fecha_fin = fecha_ymd($_POST['fecha_fin']);
            include_once 'inc/Vehicle.php';
            include_once 'inc/CouponDispatch.php';
            $vehiculo = Vehicle::getByID(usuarioPrivilegiado(),$vehiculo_id);
            $vehiculo_cupones = CouponDispatch::getByVehicleID(usuarioPrivilegiado(),$vehiculo_id,$fecha_inicio,$fecha_fin);
        }
    ?>
        <style>

            @media print {
                @page {
                    size: landscape;
                    width: 27.94cm;
                    height: 21.59cm;
                    margin-top: 2.5cm;
                    margin-right: 2.5cm;
                    margin-left: 2.5cm;
                    margin-bottom: 2.5cm;
                }
                .pagebreak {page-break-before: always; }
            }
            td {
                padding-left: 6px;
                padding-right: 6px;
                padding-top: 2px;
                padding-bottom: 2px;
            }

            div.firma {
                position:absolute;
                top: 100px;
                right: 75px;
            }
        </style>

        <html>
        <body>
        <?php
        foreach($vehiculo_cupones as $cupon):
            $currentMonthYear = date('m-Y',strtotime($cupon['fecha']));
            $currentUser = $cupon['usuario_id'];
            $maxLineas--;
            if ($currentMonthYear != $monthYear || $currentUser != $user || $maxLineas == 0){
                if ($monthYear != null && $user != null){
                    echo '</tbody>';
                    echo '<tfoot>';
                    echo '<tr>';
                    echo '<td align="left" colspan="2" style="white-space: nowrap;"><strong>TOTAL MES</strong></td>';
                    echo '<td align="center"></td>';
                    echo '<td align="center" style="white-space: nowrap;"><strong>'.number_format($cuponTotal,2).'</strong></td>';
                    echo '<td align="center"></td>';
                    echo '<td align="center"></td>';
                    echo '<td align="center"></td>';
                    echo '<td align="center"></td>';
                    echo '<td align="center"></td>';
                    echo '<td align="center"></td>';
                    echo '<td align="center"></td>';
                    echo '</tr>';
                    echo '</tfoot>';
                    echo '</table>';
                    echo '<div style="position:relative">';
                    echo '<div class="firma"><strong>Autoriza:</strong> <span>______________________________</span></div>';
                    echo '</div>';
                }
                $user = $currentUser;
                $monthYear = $currentMonthYear;
                $cuponTotal = 0.00;
                $maxLineas = 12;
                echo '<div class="pagebreak"> </div>';
                echo '<div style="position:relative;top:10px;">';
                echo '<img src="../assets/img/_vice_logo.png" alt="Logo" height=125px" width="125px" style="position:absolute;top:-20px;left:50px;">';
                echo '</div>';
                echo '<table width="100%" border="0" style="color:#000;" cellspacing="3" cellpadding="2">';
                echo '<tr></tr>';
                echo '<tr>';
                echo '<td align="center"><h3>VICEPRESIDENCIA DE LA REPÚBLICA DE GUATEMALA</h3></td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td align="center"><h4>CONSUMO DE COMBUSTIBLE DEL '.fecha_dmy($fecha_inicio).' AL '.fecha_dmy($fecha_fin).'</h4></td>';
                echo '</tr>';
                echo '<tr></tr>';
                echo '</table>';
                echo '<table width="100%" border="1">';
                echo '<caption>';
                echo '<table width="100%" frame="box">';
                echo '<caption>';
                echo '</caption>';
                echo '<tr>';
                echo '<td></td>';
                echo '<td><strong>VEHÍCULO: </strong></td>';
                echo '<td colspan="2">'.$vehiculo['nombre'].'</td>';
                echo '<td><strong>LINEA O ESTILO: </strong></td>';
                echo '<td colspan="2">'.$vehiculo['linea'].'</td>';
                echo '<td><strong>PLACA: </strong></td>';
                echo '<td>'.$vehiculo['placa'].'</td>';
                echo '<td><strong>MODELO: </strong></td>';
                echo '<td>'.$vehiculo['modelo'].'</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td></td>';
                echo '<td><strong>CILINDRAJE: </strong></td>';
                echo '<td colspan="2">'.$vehiculo['cilindraje'].'</td>';
                echo '<td><strong>COMBUSTIBLE: </strong></td>';
                echo '<td colspan="2">'.$vehiculo['combustible'].'</td>';
                echo '<td><strong>COLOR: </strong></td>';
                echo '<td colspan="3">'.$vehiculo['color'].'</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td></td>';
                echo '<td><strong>USUARIO:</strong></td>';
                echo '<td colspan="9">'.$cupon['usuario_nombre'].'</td>';
                echo '</tr>';
                echo '</table>';
                echo '</caption>';
                echo '<thead>';
                echo '<tr>';
                echo '<th align="center" colspan="2" style="white-space: nowrap;"><h4>FECHA</h4></th>';
                echo '<th align="center" style="white-space: nowrap;"><h4>No. CUPÓN</h4></th>';
                echo '<th align="center" style="white-space: nowrap;"><h4>MONTO Q.</h4></th>';
                echo '<th align="center"><h4>CANTIDAD DE GALONES</h4></th>';
                echo '<th align="center"><h4>KILOMETRAJE INICIAL</h4></th>';
                echo '<th align="center"><h4>KILOMETRAJE FINAL</h4></th>';
                echo '<th align="center"><h4>RECORRIDO KM</h4></th>';
                echo '<th align="center"><h4>GALONES CONSUMIDOS</h4></th>';
                echo '<th align="center"><h4>KMS. POR GALON</h4></th>';
                echo '<th align="center"><h4>RECIBIDO</h4></th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
            }
            echo '<tr>';
            echo '<td align="center" colspan="2" style="white-space: nowrap;">'.fecha_dmy($cupon['fecha']).'</td>';
            echo '<td align="center" style="white-space: nowrap;">'.$cupon['num'].'</td>';
            echo '<td align="center" style="white-space: nowrap;">'.number_format($cupon['monto'],2).'</td>';
            echo '<td align="center"></td>';
            echo '<td align="center"></td>';
            echo '<td align="center"></td>';
            echo '<td align="center"></td>';
            echo '<td align="center"></td>';
            echo '<td align="center"></td>';
            echo '<td align="center"></td>';
            echo '</tr>';
            $cuponTotal += $cupon['monto'];
        endforeach;
        echo '</tbody>';
        echo '<tfoot>';
        echo '<tr>';
        echo '<td align="left" colspan="2" style="white-space: nowrap;"><strong>TOTAL MES</strong></td>';
        echo '<td align="center"></td>';
        echo '<td align="center" style="white-space: nowrap;"><strong>'.number_format($cuponTotal,2).'</strong></td>';
        echo '<td align="center"></td>';
        echo '<td align="center"></td>';
        echo '<td align="center"></td>';
        echo '<td align="center"></td>';
        echo '<td align="center"></td>';
        echo '<td align="center"></td>';
        echo '<td align="center"></td>';
        echo '</tr>';
        echo '</tfoot>';
        echo '</table>';
        echo '<div style="position:relative">';
        echo '<div class="firma"><strong>Autoriza:</strong> <span>______________________________</span></div>';
        echo '</div>';
        ?>
        </body>
        </html>
        <script type="text/javascript">
            window.print();
            setTimeout(window.close, 500);
        </script>
    <?php
    else :
        echo include(unauthorizedModal());
    endif;
else:
    header("Location: index.php");
endif;
?>
