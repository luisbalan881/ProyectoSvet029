<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarAlmacen')):
        $id = null;
        $ingreso_info = array();
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $ingreso_info = ingreso_info($id);
        }
        if ( null==$id ) {
            header("Location: ?ref=_5");
        }
        if ( !empty($_POST)) {
            ingreso_borrar($id);
            $fac_id = null;
            if ( !empty($_GET['fac'])) {
                $fac_id = $_REQUEST['fac'];
                header("Location: ../inicio.php?ref=_6&id=".$fac_id);
            }
            if ( null==$fac_id ) {
                header("Location: ?ref=_5");
            }
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Eliminar Ingreso de Producto</title>
        </head>
        <body>
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-danger">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Eliminar Ingreso</h3>
                </div>
                <div class="block-content">
                    <form class="form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <select class ="form-control" name="prod_id" id="prod_id" disabled>
                                        <option>-- Seleccionar Producto --</option>
                                        <?php
                                          foreach (productos() as $producto):
                                              if ($producto['prod_status'] == 1){
                                                  echo '<option value="'.$producto['prod_id'].'" '.(($producto['prod_id'] == $ingreso_info['prod_id'])?'selected':'').'> Renglón: '.$producto['renglon_id'].', Código: '.$producto['prod_cod'].', Nombre: '.$producto['prod_nm'].', Presentación: '.$producto['nombre_presentacion'].' '.$producto['med_nm'].', Existencia: '.number_format($ingreso_info['disponible'],2).'</option>';
                                              }
                                          endforeach
                                        ?>
                                    </select>
                                    <label for="prod_id">Producto</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <input class="form-control"  type="text"  id="ing_desc" value="<?php echo $ingreso_info['ing_desc'] ?>" name="ing_desc"  readonly>
                                    <label for="ing_desc">Descripción en Factura</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4">
                                <div class="form-material">
                                    <input class="form-control"  type="number"  id="ing_cant" value="<?php echo number_format($ingreso_info['ing_cant'],2) ?>" name="ing_cant"  min="<?php echo number_format($ingreso_info['egresos'],2) ?>" readonly>
                                    <label for="ing_cant">Cantidad</label>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-material input-group">
                                    <span class="input-group-addon"><strong>Q</strong></span>
                                    <input class="form-control"  type="text"  id="ing_costo" value="<?php echo number_format($ingreso_info['costo_subtotal'],2) ?>" name="ing_costo"  min="1" readonly>
                                    <label for="ing_costo">Valor Sub Total</label>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-material input-group">
                                    <span class="input-group-addon"><strong>Q</strong></span>
                                    <input class="form-control"  type="number"  id="ing_descuento" value="<?php echo number_format($ingreso_info['ing_descuento'],2) ?>" name="ing_descuento" readonly>
                                    <label for="ing_descuento">Descuento</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4">
                                <div class="form-material">
                                    <input class="form-control"  type="text"  id="folio_alm" value="<?php echo $ingreso_info['folio_alm'] ?>" name="folio_alm" readonly>
                                    <label for="folio_alm">Folio Libro Almacen</label>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-material">
                                    <input class="form-control"  type="text"  id="folio_inv" value="<?php echo $ingreso_info['folio_inv'] ?>" name="folio_inv" readonly>
                                    <label for="folio_inv">Folio Libro Inventario</label>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-material">
                                    <input class="form-control"  type="text"  id="nom_id" value="<?php echo $ingreso_info['nom_id'] ?>" name="nom_id" readonly>
                                    <label for="nom_id">Nomenclatura de Cuentas</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                <p class="text_center">¿Esta seguro de <span class="text-danger">BORRAR</span> el ingreso? Esta acción no es reversible.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6 text-center">
                                <a href="?ref=_6&id=<?php echo $ingreso_info['fac_id'] ?>"> <button type="button" class="btn btn-primary btn-block" >No, regresar</button></a>
                            </div>
                            <div class="col-xs-6 text-center">
                                <button class="btn btn-sm btn-danger btn-block" type="submit"><i class=""></i>SI, BORRAR</button>
                            </div>
                        </div>
                    </form>
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

