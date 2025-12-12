<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('leerAlmacen')):
        $id = null;
        $ingreso_info = array();
        $ingreso_egresos = array();
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $ingreso_info = ingreso_info($id);
            $ingreso_egresos = ingreso_egresos($id);
        }
        if ( null==$id ) {
            header("Location: index.php?ref=_10");
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
          <meta http-equiv="content-type" content="text/html; charset=UTF-8">
          <title>Egresos Asociados</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-primary-dark">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Egreso Asociados</h3>
            </div>
            <div class="block-content">
                    <table class="table table-borderless table-striped table-vcenter display nowrap" cellpadding="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Renglón</th>
                                <th class="text-center">Código</th>
                                <th>Producto</th>
                                <th class="text-center">Factura</th>
                                <th class="text-center">Requisición</th>
                                <th class="text-center">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center" style="white-space: nowrap;"><strong><?php echo fecha_dmy($ingreso_info['fac_fecha']); ?></strong></td>
                                <td class="text-center"><?php echo $ingreso_info['renglon_id'] ?></td>
                                <td class="text-center"><a href="?ref=_10&id=<?php echo $ingreso_info['prod_id'] ?>"><strong><?php echo $ingreso_info['prod_cod']; ?></strong></a></td>
                                <td><?php echo $ingreso_info['prod_nm']; ?></td>
                                <td class="text-center" style="white-space: nowrap;"><a href="?ref=_6&id=<?php echo $ingreso_info['fac_id'] ?>"><?php echo 'Serie: '.$ingreso_info['fac_serie'].'<br>Num: '.$ingreso_info['fac_num']; ?></a></td>
                                <td class="text-center"></td>
                                <td class="text-center font-w600 text-success"><strong>+ <?php echo number_format($ingreso_info['ing_cant'],2); ?></strong></td>
                                <?php $existencia = $ingreso_info['ing_cant']; ?>
                            </tr>
                            <?php
                                foreach ($ingreso_egresos as $egreso){
                                    echo '<tr '.(($egreso['ing_fecha'] > $egreso['egr_fecha'])?'class="danger"':"").'>';
                                    echo '<td class="text-center"><strong>'.fecha_dmy($egreso['egr_fecha']).'</strong></td>';
                                    echo '<td class="text-center">'.$egreso['renglon_id'].'</td>';
                                    echo '<td class="text-center"><a href="?ref=_10&id='.$egreso['prod_id'].'"><strong>'.$egreso['prod_cod'].'</strong></a></td>';
                                    echo '<td>'.$egreso['prod_nm'].'</td>';
                                    echo '<td class="text-center"></td>';
                                    echo '<td class="text-center"><a href="?ref=_8&id='.$egreso['req_id'].'">'.$egreso['req_num'].'</a></td>';
                                    echo '<td class="text-center font-w600 text-danger"><strong>- '.number_format($egreso['egresos'],2).'</strong></td>';
                                    echo '</tr>';
                                    $existencia = $existencia - $egreso['egresos'];
                                }
                            ?>
                            <tr class="success">
                                <td colspan="6" class="text-right text-uppercase"><strong>Total:</strong></td>
                                <td class="text-center"><strong><?php echo number_format($existencia,2); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
            </div>
          </div>
        </body>
        </html>
        <?php
    else :
        echo include(unauthorizedModal());
    endif;
else:
    header("Location: index.php");
endif;
?>

