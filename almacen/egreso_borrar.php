<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarAlmacen')):
        $id = null;
        $req_id = null;
        $egreso = array();
        $disponible = 0;
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $egreso = egreso_info($id);
            $disponible = $egreso['existencia'];
        }
        if ( null==$id ) {
            header("Location: index.php?ref=_7");
        }
        if ( !empty($_POST)) {
            if ( !empty($_GET['req'])) {
                $req_id = $_REQUEST['req'];
            }

            if ( null == $req_id ) {
                header("Location: index.php?ref=_7");
            }
            egreso_eliminar($id);
            header("Location: index.php?ref=_8&id=".$req_id);
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
          <meta http-equiv="content-type" content="text/html; charset=UTF-8">
          <title>Eliminar Egreso de Producto</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-danger">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Eliminar Egreso</h3>
            </div>
            <div class="block-content">
                <form class="form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']) ?>" method="POST">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control"  type="text"  id="prod_id" value="<?php echo 'Renglon: '.$egreso['renglon_id'].', Código: '.$egreso["prod_cod"].', Nombre: '.$egreso["prod_nm"].', Presentación: '.$egreso["med_nm"].' '.$egreso['nombre_presentacion'].', Disponible: '.number_format($disponible,2); ?>" name="prod_id" disabled>
                                <label for="prod_id">Producto</label>
                            </div>
                        </div>
                    </div>
                  <div class="form-group">
                      <div class="col-xs-6">
                          <div class="form-material">
                              <input class="form-control"  type="text"  id="egr_cant" value="<?php echo number_format($egreso['egr_cant'],2); ?>" name="egr_cant"  readonly>
                              <label for="egr_cant">Cantidad</label>
                          </div>
                      </div>
                      <div class="col-xs-6">
                          <div class="form-material">
                              <input class="form-control" type="text" id="egr_fecha" name="egr_fecha" value="<?php echo fecha_dmy($egreso['egr_fecha']); ?>" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" readonly>
                              <label for="fac_fecha">Fecha</label>
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12 text-center">
                          <p class="text_center">¿Esta seguro de <span class="text-danger">BORRAR</span> el egreso? Esta acción no es reversible.</p>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-6 text-center">
                          <a href="?ref=_8&id=<?php echo $egreso['req_id'] ?>"> <button type="button" class="btn btn-primary btn-block" >No, regresar</button></a>
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
