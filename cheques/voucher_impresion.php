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
        }
        if ( null==$id || $voucher['vchr_status'] == 0) {
            header("Location: index.php?ref=_21");
        }
        ?>
        <link rel="stylesheet" href="voucher_print.css">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <div class="inline" style="width:14.06cm; font-size:9pt; text-transform:uppercase; margin:2.06cm 0 0 2.15cm;">
                    GUATEMALA <?php echo date('d',strtotime($voucher['vchr_fecha'])) .' de '. monthToString($voucher['vchr_fecha']) .' del '. date('Y',strtotime($voucher['vchr_fecha']));?>
                    </div>
                    <div class="inline" style="font-size:11pt; text-align:right; margin:1.9cm 0 0 0;"><?php  echo number_format($voucher['vchr_monto'],2);?></div>
                </td>
            </tr>
            <tr>
                <td><div style="margin:0.42cm 0 0.05cm 2.29cm; font-size:9pt; text-transform:uppercase;"><?php echo $voucher['prov_nm'] ?></div></td>
            </tr>
            <tr>
                <td>
                    <div style="margin:0 0 0.1cm 2.29cm; font-size:9pt; text-transform:uppercase;">
                    <?php
                    $numalet= new CNumeroaletra;
                    $numalet->setNumero($voucher['vchr_monto']);
                    echo $numalet->letra();
                    ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><div style="margin:0 0 0.65cm 2.29cm; font-size:9pt; text-transform:uppercase;">NO NEGOCIABLE</div></td>
            </tr>
            <tr>
                <td><div style="height:1.5cm;"></div></td>
            </tr>
            <tr>
                <td><div style="height: 5.3cm; display: flex; justify-content:center; align-items: center; font-size:9pt; margin:0 2.27cm 0.5cm 2.10cm;"><?php echo $voucher['vchr_desc']."";?></div></td>
            </tr>
            <tr>
                <td><div class="inline" style=" width: 2.7cm; text-align:center; font-size:7.5pt; margin:0.35cm 0 0 0.3cm;"><?php echo $voucher['user_nombre'];?></div><div class="inline" style="width: 4.5cm; text-align:center; font-size:7.5pt; margin:0.35cm 0.4cm 0 0;"><?php echo $voucher['vchr_autoriza'];?></div></td>
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
