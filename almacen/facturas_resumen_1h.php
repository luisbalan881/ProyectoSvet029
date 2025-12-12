<?php
header('Content-Type: text/html; charset=utf-8');
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('leerAlmacen')):
        $facturas = facturas();
        $total_facturas = 0.00;
        $control = 20;
        $inicio = 0;
        $hoja = 0;
        $total = ceil(count(facturas())/20);
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
        if ($total != 0):
            for($x = 1; $x <=$total; $x++):
                $hoja++;
                $lineas = 0;
                $contador = 1;
                ?>
                <table width="800" border="0" style=" color:#000;" cellspacing="0" cellpadding="0">
                    <tr>
                        <th align="center">
                            <h3 style="font-size:14px;">
                                VICEPRESIDENCIA DE LA REPÚBLICA <br>
                                RESUMEN DE 1-H EN SISTEMA DE INGRESO A ALMACÉN Y A INVENTARIO
                            </h3>
                        </th>
                        <th align="left">
                            Hoja <strong>No. <?php echo $hoja.' de '.$total ?></strong><br />
                        </th>
                    </tr>
                </table>
                <table width="800"  border="0" style=" margin-top:10px; font-size:12px; border:1px solid #000;  color:#000000; -webkit-border-radius: 20px;-moz-border-radius: 20px; border-radius: 20px;" cellspacing="0" cellpadding="8">
                    <tr style=" color:#000; font-weight:bold; font-size:14px; ">
                        <td width="75" height="30" align="center" style="border-bottom:1px solid #000; border-right:1px solid #000;">FECHA</td>
                        <td width="75" align="center" style="border-bottom:1px solid #000; border-right:1px solid #000;">FACTURA<br>SERIE/NUMERO</td>
                        <td width="350" align="center" style="border-bottom:1px solid #000; border-right:1px solid #000;">PROVEEDOR</td>
                        <td width="120" style="border-bottom:1px solid #000; border-right:1px solid #000;">NIT</td>
                        <td width="95" align="center" style="border-bottom:1px solid #000; border-right:1px solid #000;">FORMA 1-H</td>
                        <td width="90" align="center" style="border-bottom:1px solid #000; border-right:1px solid #000;">CONTROL No.</td>
                        <td width="90" align="center" style="border-bottom:1px solid #000; border-right:1px solid #000;">ORDEN DE C.Y.P. No.</td>
                        <td width="100" align="left" style="border-bottom:1px solid #000;">TOTAL</td>
                    </tr>
                    <?php
                    if ($hoja > 1){
                        echo '<tr>';
                        echo '<td height="30" align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;">VIENEN</td>';
                        echo '<td style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td align="right" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td align="right" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
                        echo '<td align="right" style="border-bottom:1px solid #000; color: #000;">Q '.number_format($total_facturas,2).'</td>';
                        echo '</tr>';
                        $lineas = $lineas + 1;
                        $control = $control + 19;
                        $inicio = $control - 18;
                    }
                    foreach ( $facturas as $factura){
                        if ($contador >= $inicio && $contador <= $control){
                            $total_facturas = $total_facturas + $factura['factura_total'];
                            echo '<tr>';
                            echo '<td height="40" align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;">'.fecha_dmy($factura['fac_fecha']).'</td>';
                            echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;">'.$factura['fac_serie'].' '.$factura['fac_num'].'</td>';
                            echo '<td align="left" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;">'.$factura['prov_nm'].'</td>';
                            echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;">'.$factura['prov_nit'].'</td>';
                            echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;">'.(($factura['hojas'] == 1)? $factura['fac_1h']:$factura['fac_1h'].' - '.sprintf('%05d',($factura['fac_1h']+$factura['hojas']-1))).'</td>';
                            echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;">'.(($factura['hojas'] == 1)? $factura['fac_control']:$factura['fac_control'].' - '.sprintf('%05d',($factura['fac_control']+$factura['hojas']-1))).'</td>';
                            echo '<td align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;">'.$factura['orden_id'].'</td>';
                            echo '<td align="right" style="border-bottom:1px solid #000; color: #000;">Q '.number_format($factura['factura_total'],2).'</td>';
                            echo '</tr>';
                            $lineas = $lineas + 1;
                        }
                        $contador = $contador + 1;
                    }
                    for ($l = 1; $l <= (20 - $lineas); $l++){
                        echo '<tr>';
                        echo '<td height="20" align="center" style="border-right:1px solid #333; color: #000; border-bottom:1px solid  #000;"></td>';
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
                        echo '<td colspan="7"  align="center" valign="middle">Total en facturas</td>';
                        echo '<td style="border-top:1px solid #666;  color: #000;" align="center" valign="middle">Q '.number_format($total_facturas,2).'</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<td colspan="7"  align="center" valign="top">
                                ------------------------------- Total Última Línea ------------------------------------ <br>
                                <strong>Generado el: '.$fecha.'</strong>
                               </td>';
                        echo '<td style="border-top:1px solid #666;  color: #000;" align="center" valign="middle">&nbsp;</td>';
                        echo '</tr>';
                    }else{
                        echo '<tr>';
                        echo '<td colspan="7"  align="center" valign="middle">VAN</td>';
                        echo '<td style="border-top:1px solid #666;  color: #000;" align="center" valign="middle">Q '.number_format($total_facturas,2).'</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
                <?php
                if($hoja != $total){ echo '<div class="pagebreak"></div>';}
            endfor;
        endif;
    else :
        echo include(unauthorized());
    endif;
else:
    header("Location: index.php");
endif;
?>
