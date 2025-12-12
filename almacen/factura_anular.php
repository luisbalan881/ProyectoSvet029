<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
include_once '../proveedores/funciones_proveedores.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarAlmacen')):
        $id = null;
        $factura = array();
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $factura = factura_info($id);
        }

        if ( null==$id ) {
            header("Location: index.php?ref=_5");
        }

        if ( !empty($_POST)) {
            factura_anular($_SESSION['user_id'],$_POST['fac_desc'],$id);
            header('Location: index.php?ref=_5');
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Anular Ingreso de Factura</title>
        </head>
        <body>
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-danger">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Anular Factura</h3>
                </div>
                <div class="block-content">
                    <form class="js-validation-factura form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST">
                        <input type="text"  id="fac_id" name="fac_id"  value="<?php echo $factura['fac_id'] ?>" hidden title="fac_id">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <select class="form-control" name="prov_id" id="prov_id" style="width: 100%;" readonly>
                                        <option value="">-- Seleccionar Proveedor --</option>
                                        <?php foreach (proveedores() as $proveedor): ?>
                                            <option value="<?=$proveedor['prov_id']?>" <?php if($proveedor[ 'prov_id'] == $factura[ 'prov_id']){ echo 'selected';} ?>>
                                                <?=$proveedor["prov_nit"]," / ",$proveedor["prov_nm"]?>
                                            </option>
                                            <?php endforeach ?>
                                    </select>
                                    <label for="prov_id">Proveedor</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <div class="form-material">
                                    <input class="form-control"  type="text"  id="fac_serie" name="fac_serie"  value="<?php echo $factura['fac_serie'] ?>" readonly>
                                    <label for="fac_serie">Factura Serie</label>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-material">
                                    <input class="form-control"  type="number"  id="fac_num" name="fac_num" value="<?php echo $factura['fac_num'] ?>" readonly>
                                    <label for="fac_num">Factura Número</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <div class="form-material">
                                    <input class="form-control"  type="number"  id="fac_control" name="fac_control" value="<?php echo $factura['fac_control'] ?>" readonly>
                                    <label for="fac_control">Número de Control</label>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-material">
                                    <input class="form-control"  type="number"  id="fac_1h" name="fac_1h" value="<?php echo $factura['fac_1h'] ?>" readonly>
                                    <label for="fac_1h">Factura 1-H</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4">
                                <div class="form-material">
                                    <input class="js-datepicker form-control" type="text" id="fac_fecha" name="fac_fecha" value="<?php echo fecha_dmy($factura['fac_fecha']); ?>" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"  data-date-language="es-ES" readonly>
                                    <label for="fac_fecha">Fecha</label>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-material form-material-success  input-group">
                                    <span class="input-group-addon"><strong>Q</strong></span>
                                    <input class="form-control"  type="number"  id="fac_descuento" name="fac_descuento" value="<?php echo number_format($factura['fac_descuento'],2) ?>" readonly>
                                    <label for="fac_descuento">Descuento</label>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-material">
                                    <input class="form-control"  type="number"  id="orden_id" name="orden_id" value="<?php echo $factura['orden_id'] ?>" readonly>
                                    <label for="orden_id">Orden de C. y P. No.</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <textarea class="form-control" id="fac_obs" name="fac_obs" rows="3" readonly><?php echo $factura['fac_obs'] ?></textarea>
                                    <label for="fac_obs">Observaciones </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <textarea class="form-control" id="fac_desc" name="fac_desc" rows="3" required></textarea>
                                    <label for="fac_desc">Comentario de modificación*</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                <p class="text_center">¿Esta seguro de <span class="text-danger">ANULAR</span> la factura? Esta acción no es reversible.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6 text-center">
                                <a href="?ref=_5"> <button type="button" class="btn btn-primary btn-block" >No, regresar</button></a>
                            </div>
                            <div class="col-xs-6 text-center">
                                <button class="btn btn-sm btn-danger btn-block" type="submit"><i class=""></i>SI, ANULAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <script src="assets/js/pages/almacen_forms_validation.js"></script>
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

