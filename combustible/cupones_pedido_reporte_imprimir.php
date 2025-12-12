<?php
header('Content-Type: text/html; charset=utf-8');
include_once '../inc/functions.php';
include_once 'funciones_cupones.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('leerCupon')):
        $id = null;
        $pedido = array();
        $pedidoCupones = array();
        $pedidoCuponesMes = array();
        $pedidoCuponesAgrupados = array();
        $monthYear = null;
        $user = null;
        $date = null;
        $month = null;
        $year = null;
        $pedidoTotal = 0.00;
        $cuponTotal = 0.00;
        $cuponSubTotal = 0.00;
        if ( isset($_GET['id'])) {
            $id = $_GET['id'];
            include_once 'inc/CouponApplication.php';
            include_once 'inc/Coupon.php';
            $pedido = CouponApplication::getByID(usuarioPrivilegiado(),$id);
            $pedidoCupones = Coupon::getByApplication(usuarioPrivilegiado(),$id);
            $pedidoCuponesAgrupados = Coupon::getGroupByApplication(usuarioPrivilegiado(),$id);
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
                .pagebreakafter {page-break-after: always;}

            }
        </style>

        <html>
        <body>
        <?php
            $pedidoTotal = $pedido->application['amount'];
            $pagina = 0;
            foreach($pedidoCuponesAgrupados as $cupon):
                $currentDate = $cupon['fecha'];
                $currentMonthYear = date('m-Y',strtotime($cupon['fecha']));
                $currentUser = $cupon['usuario_id'];
                if ($currentMonthYear != $monthYear){
                    if ($monthYear != null){
                        echo '</tbody>';
                        echo '<tfoot>';
                        echo '<tr>';
                        echo '<td align="left" colspan="2" style="white-space: nowrap;"><strong>TOTAL MES</strong></td>';
                        echo '<td align="right" style="white-space: nowrap;"><strong>'.number_format($cuponSubTotal,2).'</strong></td>';
                        echo '<td align="right">'.number_format($pedidoTotal,2).'</td>';
                        echo '</tr>';
                        $pedidoTotal -= $cuponSubTotal;
                        echo '<tr>';
                        echo '<td colspan="3" align="left" style="white-space: nowrap;"></td>';
                        echo '<td align="right"><strong>'.number_format($pedidoTotal,2).'</strong></td>';
                        echo '</tr>';
                        echo '</tfoot>';
                        echo '</table>';
                        $month = idate('m',strtotime($date));
                        $year = idate('Y',strtotime($date));
                        $pedidoCuponesMes = Coupon::getByApplicationByYearMonth(usuarioPrivilegiado(),$id,$year,$month);
                        $keys = array_keys($pedidoCuponesMes);
                        $cuponMesSubTotal = 0.00;
                        $cuponesTotal = 0.00;
                        $linea=1;
                        $pagina++;
                        foreach($pedidoCuponesMes as $key=>$cuponMes){
                            $position = array_search($key,$keys);
                            if($linea == 1 && $pagina == 2){
                                echo '<div class="pagebreak"> </div>';
                                echo '<div style="position:relative;top:10px;">';
                                echo '<img src="../assets/img/_vice_logo.png" alt="Logo" height=100px" width="125px" style="position:absolute;top:-20px;left:50px;">';
                                echo '<div style="position:absolute;height:auto;top: 825px;right: 25px;"><strong>Página '.$pagina.'</strong></div>';
                                echo '</div>';
                                echo '<table width="100%" border="0" style="color:#000;" cellspacing="0" cellpadding="0">';
                                echo '<tr>';
                                echo '<td colspan="4" align="center"><h3>VICEPRESIDENCIA DE LA REPÚBLICA DE GUATEMALA</h3></td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<td colspan="4" align="center"><h3>CONTROL DE CUPONES DE GASOLINA DESGLOSADO</h3></td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<td colspan="4" align="center"><h3>'.strtoupper(monthToString($cuponMes['fecha'])).' '.date('Y',strtotime($cuponMes['fecha'])).'</h3></td>';
                                echo '</tr>';
                                echo '</table>';
                                echo '<table width="100%" border="1">';
                                echo '<thead>';
                                echo '<td align="center" style="white-space: nowrap;"><strong>FECHA</strong></td>';
                                echo '<td align="center" style="white-space: nowrap;"><strong>CUPON NO.</strong></td>';
                                echo '<td align="center"><strong>VEHÍCULO</strong></td>';
                                echo '<td align="center"><strong>PLACA</strong></td>';
                                echo '<td align="center"><strong>USUARIO</strong></td>';
                                echo '<td align="center" style="white-space: nowrap;"><strong>MONTO Q</strong></td>';
                                echo '<td align="center"><strong>KILOMETRAJE INICIAL</strong></td>';
                                echo '<td align="center"><strong>KILOMETRAJE FINAL</strong></td>';
                                echo '<td align="center"><strong>RECORRIDO KM</strong></td>';
                                echo '<td align="center"><strong>GALONES CONSUMIDOS</strong></td>';
                                echo '<td align="center"><strong>KM POR GALON</strong></td>';
                                echo '</thead>';
                                echo '<tbody>';
                                $pagina++;
                            } else if ($linea == 28) {
                                echo '</tbody>';
                                echo '</table>';
                                echo '<div class="pagebreak"> </div>';
                                echo '<div style="position:relative;top:10px;">';
                                echo '<img src="../assets/img/_vice_logo.png" alt="Logo" height=125px" width="125px" style="position:absolute;top:-20px;left:50px;">';
                                echo '<div style="position:absolute;height:auto;top: 825px;right: 25px;"><strong>Página '.$pagina.'</strong></div>';
                                echo '</div>';
                                echo '<table width="100%" border="0" style="color:#000;" cellspacing="0" cellpadding="0">';
                                echo '<tr>';
                                echo '<td colspan="4" align="center"><h3>VICEPRESIDENCIA DE LA REPÚBLICA DE GUATEMALA</h3></td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<td colspan="4" align="center"><h3>CONTROL DE CUPONES DE GASOLINA DESGLOSADO</h3></td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<td colspan="4" align="center"><h3>'.strtoupper(monthToString($cuponMes['fecha'])).' '.date('Y',strtotime($cuponMes['fecha'])).'</h3></td>';
                                echo '</tr>';
                                echo '</table>';
                                echo '<table width="100%" border="1">';
                                echo '<thead>';
                                echo '<td align="center" style="white-space: nowrap;"><strong>FECHA</strong></td>';
                                echo '<td align="center" style="white-space: nowrap;"><strong>CUPON NO.</strong></td>';
                                echo '<td align="center"><strong>VEHÍCULO</strong></td>';
                                echo '<td align="center"><strong>PLACA</strong></td>';
                                echo '<td align="center"><strong>USUARIO</strong></td>';
                                echo '<td align="center" style="white-space: nowrap;"><strong>MONTO Q</strong></td>';
                                echo '<td align="center"><strong>KILOMETRAJE INICIAL</strong></td>';
                                echo '<td align="center"><strong>KILOMETRAJE FINAL</strong></td>';
                                echo '<td align="center"><strong>RECORRIDO KM</strong></td>';
                                echo '<td align="center"><strong>GALONES CONSUMIDOS</strong></td>';
                                echo '<td align="center"><strong>KM POR GALON</strong></td>';
                                echo '</thead>';
                                echo '<tbody>';
                                $linea = 1;
                                $pagina++;
                            }
                            $linea++;
                            $cuponMesSubTotal += $cuponMes['monto'];
                            echo '<tr>';
                            echo '<td style="white-space: nowrap;">'.fecha_dmy($cuponMes['fecha']).'</td>';
                            echo '<td align="center">'.$cuponMes['num'].'</td>';
                            echo '<td>'.$cuponMes['vehiculo_nombre'].'</td>';
                            echo '<td style="white-space: nowrap;">'.$cuponMes['placa'].'</td>';
                            echo '<td style="white-space: nowrap;">'.$cuponMes['usuario_nombre'].'</td>';
                            echo '<td align="right" style="white-space: nowrap;">'.number_format($cuponMes['monto'],2).'</td>';
                            echo '<td align="right">'.number_format($cuponMes['km_inicial'],2).'</td>';
                            echo '<td align="right">'.number_format($cuponMes['km_final'],2).'</td>';
                            echo '<td align="right">'.number_format($cuponMes['km_recorridos'],2).'</td>';
                            echo '<td align="right">'.number_format($cuponMes['galones_consumidos'],2).'</td>';
                            echo '<td align="right">'.number_format($cuponMes['km_galon'],2).'</td>';
                            echo '</tr>';
                            if (isset($pedidoCuponesMes[$position + 1]['usuario_id']) && isset($pedidoCuponesMes[$position+1]['vehiculo_id'])){
                                if ($cuponMes['usuario_id'] != $pedidoCuponesMes[$position + 1]['usuario_id'] || $cuponMes['vehiculo_id'] != $pedidoCuponesMes[$position + 1]['vehiculo_id']){
                                    echo '<tr>';
                                    echo '<td colspan="5"></td>';
                                    echo '<td align="right"><strong>'.number_format($cuponMesSubTotal,2).'</strong></td>';
                                    $cuponesTotal += $cuponMesSubTotal;
                                    $cuponMesSubTotal = 0.00;
                                    echo '<td colspan="5"></td>';
                                    echo '</tr>';
                                    $linea++;
                                }
                            }else{
                                echo '<tr>';
                                echo '<td colspan="5"></td>';
                                echo '<td align="right"><strong>'.number_format($cuponMesSubTotal,2).'</strong></td>';
                                $cuponesTotal += $cuponMesSubTotal;
                                $cuponMesSubTotal = 0.00;
                                echo '<td colspan="5"></td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<td colspan="5"></td>';
                                echo '<td align="right"><strong>'.number_format($cuponesTotal,2).'</strong></td>';
                                $cuponesTotal += $cuponMesSubTotal;
                                $cuponMesSubTotal = 0.00;
                                echo '<td colspan="5"></td>';
                                echo '</tr>';
                                $linea++;
                                $linea++;
                            }
                            if ($linea >= 24) {
                                if (isset($pedidoCuponesMes[$position + 1]['usuario_id']) && isset($pedidoCuponesMes[$position + 1]['vehiculo_id'])) {
                                    if ($cuponMes['usuario_id'] != $pedidoCuponesMes[$position + 1]['usuario_id'] || $cuponMes['vehiculo_id'] != $pedidoCuponesMes[$position + 1]['vehiculo_id']) {
                                        echo '</tbody>';
                                        echo '</table>';
                                        echo '<div class="pagebreak"> </div>';
                                        echo '<div style="position:relative;top:10px;">';
                                        echo '<img src="../assets/img/_vice_logo.png" alt="Logo" height=125px" width="125px" style="position:absolute;top:-20px;left:50px;">';
                                        echo '<div style="position:absolute;height:auto;top: 825px;right: 25px;"><strong>Página '.$pagina.'</strong></div>';
                                        echo '</div>';
                                        echo '<table width="100%" border="0" style="color:#000;" cellspacing="0" cellpadding="0">';
                                        echo '<tr>';
                                        echo '<td colspan="4" align="center"><h3>VICEPRESIDENCIA DE LA REPÚBLICA DE GUATEMALA</h3></td>';
                                        echo '</tr>';
                                        echo '<tr>';
                                        echo '<td colspan="4" align="center"><h3>CONTROL DE CUPONES DE GASOLINA DESGLOSADO</h3></td>';
                                        echo '</tr>';
                                        echo '<tr>';
                                        echo '<td colspan="4" align="center"><h3>'.strtoupper(monthToString($cuponMes['fecha'])).' '.date('Y',strtotime($cuponMes['fecha'])).'</h3></td>';
                                        echo '</tr>';
                                        echo '</table>';
                                        echo '<table width="100%" border="1">';
                                        echo '<thead>';
                                        echo '<td align="center" style="white-space: nowrap;"><strong>FECHA</strong></td>';
                                        echo '<td align="center" style="white-space: nowrap;"><strong>CUPON NO.</strong></td>';
                                        echo '<td align="center"><strong>VEHÍCULO</strong></td>';
                                        echo '<td align="center"><strong>PLACA</strong></td>';
                                        echo '<td align="center"><strong>USUARIO</strong></td>';
                                        echo '<td align="center" style="white-space: nowrap;"><strong>MONTO Q</strong></td>';
                                        echo '<td align="center"><strong>KILOMETRAJE INICIAL</strong></td>';
                                        echo '<td align="center"><strong>KILOMETRAJE FINAL</strong></td>';
                                        echo '<td align="center"><strong>RECORRIDO KM</strong></td>';
                                        echo '<td align="center"><strong>GALONES CONSUMIDOS</strong></td>';
                                        echo '<td align="center"><strong>KM POR GALON</strong></td>';
                                        echo '</thead>';
                                        echo '<tbody>';
                                        $linea = 1;
                                        $pagina++;
                                    }
                                }
                            }
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '<div class="pagebreak"> </div>';
                    }
                    $monthYear = $currentMonthYear;
                    $date = $currentDate;
                    $cuponSubTotal = 0.00;
                    $pagina = 1;
                    echo '<div style="position:relative;top:10px;">';
                    echo '<img src="../assets/img/_vice_logo.png" alt="Logo" height=125px" width="125px" style="position:absolute;top:-20px;left:50px;">';
                    echo '<div style="position:absolute;height:auto;top: 825px;right: 25px;"><strong>Página '.$pagina.'</strong></div>';
                    echo '</div>';
                    echo '<table width="100%" border="0" style="color:#000;" cellspacing="0" cellpadding="0">';
                    echo '<tr>';
                    echo '<td colspan="4" align="center"><h3>VICEPRESIDENCIA DE LA REPÚBLICA DE GUATEMALA</h3></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td colspan="4" align="center"><h3>CONTROL DE CUPONES DE GASOLINA</h3></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td colspan="4" align="center"><h3>'.strtoupper(monthToString($cupon['fecha'])).' '.date('Y',strtotime($cupon['fecha'])).'</h3></td>';
                    echo '</tr>';
                    echo '</table>';
                    echo '<table width="100%" border="1">';
                    echo '<caption>';
                    echo '<table cellpadding="10" cellspacing="4">';
                    echo '<tr>';
                    echo '<td align="center"><strong>CODIGO: </strong></td>';
                    echo '<td align="center">'.$pedido->application['code'].'</td>';
                    echo '<td align="center"><strong>PEDIDO No.: </strong></td>';
                    echo '<td align="center">'.$pedido->application['number'].'</td>';
                    echo '</tr>';
                    echo '</table>';
                    echo '</caption>';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th align="center" style="white-space: nowrap;">VEHÍCULO</th>';
                    echo '<th align="center" style="white-space: nowrap;">USUARIO</th>';
                    echo '<th align="center" style="white-space: nowrap;">MONTO Q</th>';
                    echo '<th align="center">DISPONIBLE</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                }
                echo '<tr>';
                echo '<td align="center" style="white-space: nowrap;">'.$cupon['placa'].'</td>';
                echo '<td align="center" style="white-space: nowrap;">'.$cupon['usuario_nombre'].'</td>';
                echo '<td align="right" style="white-space: nowrap;">'.number_format($cupon['monto'],2).'</td>';
                echo '<td align="center"></td>';
                echo '</tr>';
                $cuponSubTotal += $cupon['monto'];
            endforeach;
            echo '</tbody>';
            echo '<tfoot>';
            echo '<tr>';
            echo '<td align="left" colspan="2" style="white-space: nowrap;"><strong>TOTAL MES</strong></td>';
            echo '<td align="right" style="white-space: nowrap;"><strong>'.number_format($cuponSubTotal,2).'</strong></td>';
            echo '<td align="right">'.number_format($pedidoTotal,2).'</td>';
            echo '</tr>';
            $pedidoTotal -= $cuponSubTotal;
            echo '<tr>';
            echo '<td colspan="3" align="left" style="white-space: nowrap;"></td>';
            echo '<td align="right"><strong>'.number_format($pedidoTotal,2).'</strong></td>';
            echo '</tr>';
            echo '</tfoot>';
            echo '</table>';
            $month = idate('m',strtotime($date));
            $year = idate('Y',strtotime($date));
            $pedidoCuponesMes = Coupon::getByApplicationByYearMonth(usuarioPrivilegiado(),$id,$year,$month);
            $keys = array_keys($pedidoCuponesMes);
            $cuponMesSubTotal = 0.00;
            $cuponesTotal = 0.00;
            $linea=1;
            $pagina++;
            foreach($pedidoCuponesMes as $key=>$cuponMes){
                $position = array_search($key,$keys);
                if($linea == 1 && $pagina == 2){
                    echo '<div class="pagebreak"> </div>';
                    echo '<div style="position:relative;top:10px;">';
                    echo '<img src="../assets/img/_vice_logo.png" alt="Logo" height=125px" width="125px" style="position:absolute;top:-20px;left:50px;">';
                    echo '<div style="position:absolute;height:auto;top: 825px;right: 25px;"><strong>Página '.$pagina.'</strong></div>';
                    echo '</div>';
                    echo '<table width="100%" border="0" style="color:#000;" cellspacing="0" cellpadding="0">';
                    echo '<tr>';
                    echo '<td colspan="4" align="center"><h3>VICEPRESIDENCIA DE LA REPÚBLICA DE GUATEMALA</h3></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td colspan="4" align="center"><h3>CONTROL DE CUPONES DE GASOLINA DESGLOSADO</h3></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td colspan="4" align="center"><h3>'.strtoupper(monthToString($cuponMes['fecha'])).' '.date('Y',strtotime($cuponMes['fecha'])).'</h3></td>';
                    echo '</tr>';
                    echo '</table>';
                    echo '<table width="100%" border="1">';
                    echo '<thead>';
                    echo '<td align="center" style="white-space: nowrap;"><strong>FECHA</strong></td>';
                    echo '<td align="center" style="white-space: nowrap;"><strong>CUPON NO.</strong></td>';
                    echo '<td align="center"><strong>VEHÍCULO</strong></td>';
                    echo '<td align="center"><strong>PLACA</strong></td>';
                    echo '<td align="center"><strong>USUARIO</strong></td>';
                    echo '<td align="center" style="white-space: nowrap;"><strong>MONTO Q</strong></td>';
                    echo '<td align="center"><strong>KILOMETRAJE INICIAL</strong></td>';
                    echo '<td align="center"><strong>KILOMETRAJE FINAL</strong></td>';
                    echo '<td align="center"><strong>RECORRIDO KM</strong></td>';
                    echo '<td align="center"><strong>GALONES CONSUMIDOS</strong></td>';
                    echo '<td align="center"><strong>KM POR GALON</strong></td>';
                    echo '</thead>';
                    echo '<tbody>';
                    $pagina++;
                } else if ($linea == 28) {
                    echo '</tbody>';
                    echo '</table>';
                    echo '<div class="pagebreak"> </div>';
                    echo '<div style="position:relative;top:10px;">';
                    echo '<img src="../assets/img/_vice_logo.png" alt="Logo" height=125px" width="125px" style="position:absolute;top:-20px;left:50px;">';
                    echo '<div style="position:absolute;height:auto;top: 825px;right: 25px;"><strong>Página '.$pagina.'</strong></div>';
                    echo '</div>';
                    echo '<table width="100%" border="0" style="color:#000;" cellspacing="0" cellpadding="0">';
                    echo '<tr>';
                    echo '<td colspan="4" align="center"><h3>VICEPRESIDENCIA DE LA REPÚBLICA DE GUATEMALA</h3></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td colspan="4" align="center"><h3>CONTROL DE CUPONES DE GASOLINA DESGLOSADO</h3></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td colspan="4" align="center"><h3>'.strtoupper(monthToString($cuponMes['fecha'])).' '.date('Y',strtotime($cuponMes['fecha'])).'</h3></td>';
                    echo '</tr>';
                    echo '</table>';
                    echo '<table width="100%" border="1">';
                    echo '<thead>';
                    echo '<td align="center" style="white-space: nowrap;"><strong>FECHA</strong></td>';
                    echo '<td align="center" style="white-space: nowrap;"><strong>CUPON NO.</strong></td>';
                    echo '<td align="center"><strong>VEHÍCULO</strong></td>';
                    echo '<td align="center"><strong>PLACA</strong></td>';
                    echo '<td align="center"><strong>USUARIO</strong></td>';
                    echo '<td align="center" style="white-space: nowrap;"><strong>MONTO Q</strong></td>';
                    echo '<td align="center"><strong>KILOMETRAJE INICIAL</strong></td>';
                    echo '<td align="center"><strong>KILOMETRAJE FINAL</strong></td>';
                    echo '<td align="center"><strong>RECORRIDO KM</strong></td>';
                    echo '<td align="center"><strong>GALONES CONSUMIDOS</strong></td>';
                    echo '<td align="center"><strong>KM POR GALON</strong></td>';
                    echo '</thead>';
                    echo '<tbody>';
                    $linea = 1;
                    $pagina++;
                }
                $linea++;
                $cuponMesSubTotal += $cuponMes['monto'];
                echo '<tr>';
                echo '<td style="white-space: nowrap;">'.fecha_dmy($cuponMes['fecha']).'</td>';
                echo '<td align="center">'.$cuponMes['num'].'</td>';
                echo '<td>'.$cuponMes['vehiculo_nombre'].'</td>';
                echo '<td style="white-space: nowrap;">'.$cuponMes['placa'].'</td>';
                echo '<td style="white-space: nowrap;">'.$cuponMes['usuario_nombre'].'</td>';
                echo '<td align="right" style="white-space: nowrap;">'.number_format($cuponMes['monto'],2).'</td>';
                echo '<td align="right">'.number_format($cuponMes['km_inicial'],2).'</td>';
                echo '<td align="right">'.number_format($cuponMes['km_final'],2).'</td>';
                echo '<td align="right">'.number_format($cuponMes['km_recorridos'],2).'</td>';
                echo '<td align="right">'.number_format($cuponMes['galones_consumidos'],2).'</td>';
                echo '<td align="right">'.number_format($cuponMes['km_galon'],2).'</td>';
                echo '</tr>';
                if (isset($pedidoCuponesMes[$position + 1]['usuario_id']) && isset($pedidoCuponesMes[$position+1]['vehiculo_id'])){
                    if ($cuponMes['usuario_id'] != $pedidoCuponesMes[$position + 1]['usuario_id'] || $cuponMes['vehiculo_id'] != $pedidoCuponesMes[$position + 1]['vehiculo_id']){
                        echo '<tr>';
                        echo '<td colspan="5"></td>';
                        echo '<td align="right"><strong>'.number_format($cuponMesSubTotal,2).'</strong></td>';
                        $cuponesTotal += $cuponMesSubTotal;
                        $cuponMesSubTotal = 0.00;
                        echo '<td colspan="5"></td>';
                        echo '</tr>';
                        $linea++;
                    }
                }else{
                    echo '<tr>';
                    echo '<td colspan="5"></td>';
                    echo '<td align="right"><strong>'.number_format($cuponMesSubTotal,2).'</strong></td>';
                    $cuponesTotal += $cuponMesSubTotal;
                    $cuponMesSubTotal = 0.00;
                    echo '<td colspan="5"></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td colspan="5"></td>';
                    echo '<td align="right"><strong>'.number_format($cuponesTotal,2).'</strong></td>';
                    $cuponesTotal += $cuponMesSubTotal;
                    $cuponMesSubTotal = 0.00;
                    echo '<td colspan="5"></td>';
                    echo '</tr>';
                    $linea++;
                    $linea++;
                }
                if ($linea >= 24) {
                    if (isset($pedidoCuponesMes[$position + 1]['usuario_id']) && isset($pedidoCuponesMes[$position + 1]['vehiculo_id'])) {
                        if ($cuponMes['usuario_id'] != $pedidoCuponesMes[$position + 1]['usuario_id'] || $cuponMes['vehiculo_id'] != $pedidoCuponesMes[$position + 1]['vehiculo_id']) {
                            echo '</tbody>';
                            echo '</table>';
                            echo '<div class="pagebreak"> </div>';
                            echo '<div style="position:relative;top:10px;">';
                            echo '<img src="../assets/img/_vice_logo.png" alt="Logo" height=125px" width="125px" style="position:absolute;top:-20px;left:50px;">';
                            echo '<div style="position:absolute;height:auto;top: 825px;right: 25px;"><strong>Página '.$pagina.'</strong></div>';
                            echo '</div>';
                            echo '<table width="100%" border="0" style="color:#000;" cellspacing="0" cellpadding="0">';
                            echo '<tr>';
                            echo '<td colspan="4" align="center"><h3>VICEPRESIDENCIA DE LA REPÚBLICA DE GUATEMALA</h3></td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td colspan="4" align="center"><h3>CONTROL DE CUPONES DE GASOLINA DESGLOSADO</h3></td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td colspan="4" align="center"><h3>'.strtoupper(monthToString($cuponMes['fecha'])).' '.date('Y',strtotime($cuponMes['fecha'])).'</h3></td>';
                            echo '</tr>';
                            echo '</table>';
                            echo '<table width="100%" border="1">';
                            echo '<thead>';
                            echo '<td align="center" style="white-space: nowrap;"><strong>FECHA</strong></td>';
                            echo '<td align="center" style="white-space: nowrap;"><strong>CUPON NO.</strong></td>';
                            echo '<td align="center"><strong>VEHÍCULO</strong></td>';
                            echo '<td align="center"><strong>PLACA</strong></td>';
                            echo '<td align="center"><strong>USUARIO</strong></td>';
                            echo '<td align="center" style="white-space: nowrap;"><strong>MONTO Q</strong></td>';
                            echo '<td align="center"><strong>KILOMETRAJE INICIAL</strong></td>';
                            echo '<td align="center"><strong>KILOMETRAJE FINAL</strong></td>';
                            echo '<td align="center"><strong>RECORRIDO KM</strong></td>';
                            echo '<td align="center"><strong>GALONES CONSUMIDOS</strong></td>';
                            echo '<td align="center"><strong>KM POR GALON</strong></td>';
                            echo '</thead>';
                            echo '<tbody>';
                            $linea = 1;
                            $pagina++;

                        }
                    }
                }
            }
            echo '</tbody>';
            echo '</table>';
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
