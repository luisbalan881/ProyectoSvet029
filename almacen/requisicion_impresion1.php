<?php
header('Content-Type: text/html; charset=utf-8');
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('leerAlmacen')):
        $id = null;
        $requisicion = array();
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $requisicion = requisicion_info($id);
        }
        if ( null==$id || $requisicion['req_status'] == 0) {
            header("Location: index.php?ref=_7");
        }
        ?>
        <table width="980" border="0" style=" color:#000; margin-top:94px; margin-bottom:10px;" cellspacing="0" cellpadding="0">
          <tr>
            <th align="center" width="75%" >&nbsp;</th>
            <th align="left">&nbsp;<?php echo fecha_dmy($requisicion['req_fecha']);?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
          </tr>
        </table>

        <div style=" width:980px; height:300px;  solid #000; margin-top:82px; ">
          <div style=" width:980px; solid #000; height:28px;">
            <table width="100%"  border="0"  cellspacing="0" cellpadding="0">
              <?php
                $egresos = requisicion_egresos_agrupados($id);
                $costo_total = 0.00;
                foreach ($egresos as $egreso){
                  $costo_total = $costo_total + $egreso['costo_total'];
                  $fecha_dmy = date("d-m-Y", strtotime($egreso['egr_fecha']));
                  echo '<tr>';
                  echo '<td height="27" width="100" align="center">'.(($egreso['prod_cod'] != 0)? $egreso['prod_cod']:(($egreso['prod_cod'] == 'N/A')? 'N/A':$egreso['renglon_codigo'])).'</td>';
                  echo '<td width="100" align="center" >'.number_format($egreso['egr_cant'],2).'</td>';
                  echo '<td width="350" style="overflow: hidden;">'.$egreso['prod_nm'].'</td>';
                  echo '<td width="80">'.$egreso['med_nm'].' '.$egreso['nombre_presentacion'].'</td>';
                  echo '<td align="right" width="80">Q. '.number_format($egreso['costo_unitario'],2).'</td>';
                  echo '<td align="right" width="110">Q. '.number_format($egreso['costo_total'],2).'</td>';
                  echo '</tr>';
                }
              ?>
            </table>
          </div>
        </div>

        <table width="980" border="0" style=" font-size:14px; margin-top:78px;  color:#000000;  solid #000; -webkit-border-radius: 20px;-moz-border-radius: 20px; border-radius: 20px;" cellspacing="6" cellpadding="0">
          <tr>
              <td align="left" width="100" height="40" >&nbsp;</td>
              <td align="center"  >&nbsp;&nbsp;<?php echo $requisicion['user_nm1']." ".$requisicion['user_ap1'];?></td>
              <td width="30">&nbsp;</td>
              <td width="30" >&nbsp;</td>
              <td align="left" width="30" >&nbsp;</td>
              <td align="center" width="360" ><?php echo $requisicion['encargado_nm1']." ".$requisicion['encargado_ap1'] ?></td>
          </tr>
          <tr>
            <td align="left" height="30">&nbsp;</td>
            <td align="left" >&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="left"  >&nbsp;</td>
             <td align="left" >&nbsp;</td>
          </tr>
          <tr>
            <td align="left" style=" ">&nbsp;</td>
            <td align="center"><?php echo $requisicion['dep_nm'];?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="left" >&nbsp;</td>
            <td align="center" ><!--Almacen --></td>
          </tr>
        </table>
        <script type="text/javascript">
            window.print();
            setTimeout(window.close, 500);
        </script>
        <?php
    else :
        echo include(unauthorized());
    endif;
else:
    header("Location: index.php");
endif;
?>
