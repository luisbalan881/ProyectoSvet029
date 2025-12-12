<?php
header('Content-Type: text/html; charset=utf-8');
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('leerAlmacen')):
        $renglon_ingresos = array();
        $renglon_control = array();
        $renglones = array();
        $renglon_final = 0;
        if ( !empty($_POST)) {
            $renglon_inicio = $_POST['renglon_inicio'];
            $renglon_fin = $_POST['renglon_fin'];
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];
            $renglon_ingresos = renglon_reporte($renglon_inicio,$renglon_fin,fecha_ymd($fecha_inicio),fecha_ymd($fecha_fin));
        }

        foreach($renglon_ingresos as $renglon_ingreso){
            $renglon_control = end($renglones);
            if ($renglon_ingreso['renglon_id'] != $renglon_control['renglon_id']){
               array_push($renglones, $renglon_ingreso);
            }
            $renglon_final = $renglon_control['renglon_id'];
        }
    ?>
        <style>
            @page {
                size: letter;
            }
            @media print {
                html, body {
                    width: 21.59cm;
                    height: 27.94cm;
                }
                .pagebreak {
                    page-break-before: always;
                }
            }
        </style>
        <?php
        foreach($renglones as $renglon):
            $ingresos_renglon = 0;
            $total_renglon = 0.00;
            $control = 20;
            $inicio = 0;
            $hoja = 0;
            foreach($renglon_ingresos as $renglon_ingreso){
                if ($renglon_ingreso['renglon_id'] == $renglon['renglon_id']){
                    $ingresos_renglon++;
                }
            }
            $total = ceil($ingresos_renglon/20);
            if ($total != 0):
              for($x = 1; $x <=$total; $x++):
                  $hoja++;
                  $lineas = 0;
                  $contador = 1;
            ?>
                <table width="800" border="0" style=" color:#000;" cellspacing="0" cellpadding="0">
                    <tr>
                        <th align="center"><h3 style="font-size:14px;">VICEPRESIDENCIA DE LA REPÚBLICA<br/>RESUMEN DE RENGLON EN SISTEMA DE INGRESO A ALMACÉN Y A INVENTARIO<br>RENGLON: <?php echo $renglon['renglon_id'] ?> - <?php echo $renglon['renglon_nm'] ?> </h3></th>
                        <th align="left">
                            Hoja <strong>No. <?php echo $hoja.' de '.$total ?></strong><br />
                        </th>
                    </tr>
                </table>
                <table width="800"  border="0" style=" margin-top:10px; font-size:12px; border:1px solid #000;  color:#000000; -webkit-border-radius: 20px;-moz-border-radius: 20px; border-radius: 20px;" cellspacing="0" cellpadding="8">
                    <tr style=" color:#000; font-weight:bold; font-size:14px; ">
                        <td width="80" height="30" align="center" style="border-bottom:1px solid #000; border-right:1px solid #000;">Fecha</td>
                        <td width="35" align="center" style="border-bottom:1px solid #000; border-right:1px solid #000;">Reng.</td>
                        <td width="35" align="center" style="border-bottom:1px solid #000; border-right:1px solid #000;">Cod.</td>
                        <td width="300" style="border-bottom:1px solid #000; border-right:1px solid #000;">Producto</td>
                        <td width="95" style="border-bottom:1px solid #000; border-right:1px solid #000;">Factura</td>
                        <td width="35" height="30" align="center" style="border-bottom:1px solid #000; border-right:1px solid #000;">Cant.</td>
                        <td width="90" align="center" style="border-bottom:1px solid #000; border-right:1px solid #000;">Costo U.</td>
                        <td width="90" align="center" style="border-bottom:1px solid #000;">Total</td>
                    </tr>
                    <?php
                    if ($hoja > 1){
                        echo '<tr>';
                        echo '<td height="40" align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;">VIENEN</td>';
                        echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td align="right" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td align="right" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td align="center" style="border-bottom:1px solid #000; color: #000;">Q. '.number_format($total_renglon,2).'</td>';
                        echo '</tr>';
                        $lineas = $lineas + 1;
                        $control = $control + 19;
                        $inicio = $control - 18;
                    }
                    foreach ( $renglon_ingresos as $renglon_ingreso){
                        if($renglon_ingreso['renglon_id'] == $renglon['renglon_id']){
                            if ($contador >= $inicio && $contador <= $control){
                                $total_renglon = $total_renglon + $renglon_ingreso['ing_costo'];
                                echo '<tr>';
                                echo '<td height="40" align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;">'.fecha_dmy($renglon_ingreso['ing_fecha']).'</td>';
                                echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;">'.$renglon_ingreso['prod_renglon'].'</td>';
                                echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;">'.$renglon_ingreso['prod_cod'].'</td>';
                                echo '<td align="left" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;">'.$renglon_ingreso['prod_nm'].'</td>';
                                echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;">'.$renglon_ingreso['fac_serie'].' '.$renglon_ingreso['fac_num'].'</td>';
                                echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;">'.number_format($renglon_ingreso['ing_cant'],2).'</td>';
                                echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;">Q '.number_format($renglon_ingreso['costo_unitario'],2).'</td>';
                                echo '<td align="center" style="border-bottom:1px solid #000; color: #000;">Q '.number_format($renglon_ingreso['ing_costo'],2).'</td>';
                                echo '</tr>';
                                $lineas = $lineas + 1;
                            }
                            $contador++;
                        }
                    }
                    for ($l = 1; $l <= (20 - $lineas); $l++){
                        echo '<tr>';
                        echo '<td height="40" align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td align="left" style="border-bottom:1px solid #000; color: #000;"></td>';
                        echo '</tr>';
                    }
                    $lineas = 0;
                    date_default_timezone_set('America/Guatemala');
                    $fecha = date('d/m/Y h:i:s a',time());
                    if ($hoja == $total){
                        echo '<tr>';
                        echo '<td colspan="7"  align="center" valign="middle">Total en renglón</td>';
                        echo '<td style="border-top:1px solid #666;  color: #000;" align="center" valign="middle">Q. '.number_format($total_renglon,2).'</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<td colspan="7"  align="center" valign="middle">------------------------------- Total Última Línea ------------------------------------<br><strong>Reporte del '.$fecha_inicio.' al '.$fecha_fin.', generado el: '.$fecha.'</strong></td>';
                        echo '<td style="border-top:1px solid #666;  color: #000;" align="center" valign="middle">&nbsp;</td>';
                        echo '</tr>';
                    }else{
                        echo '<tr>';
                        echo '<td colspan="7"  align="center" valign="middle">VAN</td>';
                        echo '<td style="border-top:1px solid #666;  color: #000;" align="center" valign="middle">Q. '.number_format($total_renglon,2).'</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
            <?php
                  if($hoja != $total){ echo '<div class="pagebreak"></div>';}
              endfor;
            endif;
            if($renglon['renglon_id'] != $renglon_final){ echo '<div class="pagebreak"></div>';}
        endforeach;
        ?>
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
