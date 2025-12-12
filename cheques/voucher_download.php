<meta  charset='utf-8'>
<?php
header('Content-Type: text/html; charset=utf-8');
include_once '../inc/functions.php';
include_once '../proveedores/funciones_proveedores.php';
include_once 'funciones_cheques.php';
include_once 'inc/Voucher.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('leerCheques')):
        $id = null;
        $voucher = array();
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $voucher = Voucher::getById(usuarioPrivilegiado(),$id);
            header("Content-Description: File Transfer");
            header("Content-Type: application/msword");
            header('Content-Disposition: attachment; filename="'.$voucher['vchr_fecha'].' - Voucher No. '.$voucher['vchr_num'].'.doc"');
        }
        if ( null==$id || $voucher['vchr_status'] == 0) {
            header("Location: index.php?ref=_21");
        }
        ?>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td height="34" width="10">&nbsp;</td>
                <td width="27">&nbsp;</td>
                <td width="15">&nbsp;</td>
                <td width="74">&nbsp;</td>
                <td width="200">&nbsp;</td>
                <td width="30">&nbsp;</td>
                <td width="365">&nbsp;</td>
                <td width="101">&nbsp;</td>
                <td width="99">&nbsp;</td>
                <td width="10" >&nbsp;</td>
            </tr>
            <tr>
                <td height="22">&nbsp;</td>
                <td></td>
                <td></td>
                <td colspan="4" style="font-size:12px; text-transform:uppercase;">&nbsp;&nbsp;GUATEMALA <?php echo date('d',strtotime($voucher['vchr_fecha'])) .' de '. monthToString($voucher['vchr_fecha']) .' del '. date('Y',strtotime($voucher['vchr_fecha']));?></td>
                <td colspan="2"><div style="margin:0px 0px 0px 0px;"><?php  echo"";    echo number_format($voucher['vchr_monto'],2);?></div></td>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td style="height:20px;">&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="4"><div style="margin:14px 0px 0px 0px; font-size:12px; text-transform:uppercase;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $voucher['prov_nm'] ?></div></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="4" style="font-size:12px;">
                    &nbsp;&nbsp;&nbsp;&nbsp;<?php
                    $numalet= new CNumeroaletra;
                    $numalet->setNumero($voucher['vchr_monto']);
                    echo $numalet->letra();
                    ?>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td height="10">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="2" style="font-size:12px;"><div style="margin:0px 0px 0px 0px;">&nbsp;&nbsp;&nbsp;&nbsp;NO NEGOCIABLE</div></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td height="14">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td height="120">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td height="166">&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="6" valign="top"><div style="font-size:12px; margin:10px 0px 0px 10px; width:100%;"><?php echo"".$voucher['vchr_desc']."";?></div></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="5" style="font-size:10px;" ><div style="margin:8px 0px 0px 0px;"><?php echo"".$voucher['user_nombre']."";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo"".$voucher['vchr_autoriza']."";?></div></td>

                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <?php
    else :
        echo include(unauthorized());
    endif;
else:
    header("Location: index.php");
endif;
?>
