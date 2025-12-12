<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('leerAlmacen')):
        $id = null;
        $renglon = array();
        date_default_timezone_set('America/Guatemala');
        $fecha_fin = date('d-m-Y',time());
        $fecha_inicio = $fecha_fin;
        $fecha_inicio = date('d-m-Y', strtotime('-5 month'));
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $renglon = renglon_info($id);
        }

        if ( null==$id ) {
            header("Location: index.php?ref=_2");
        }

        if ( !empty($_POST)) {
            renglon_modificar($id);
            header("Location: index.php?ref=_2");
        }
    ?>
        <!DOCTYPE html>
        <html>
        <head>
          <meta http-equiv="content-type" content="text/html; charset=UTF-8">
          <title>Generar Reporte de Renglón</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-info">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Generar Reporte de Renglón</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-renglon form-horizontal push-10-t push-10" action="almacen/renglon_imprimir.php" method="POST" target="_blank">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="number"  id="renglon_id" name="renglon_id" value="<?php echo $renglon['renglon_id'] ?>" disabled>
                                <label for="renglon_id">Renglón ID</label>
                            </div>
                        </div>
                    </div>
                    <input id="renglon_inicio" name="renglon_inicio" value="<?php echo $renglon['renglon_id'] ?>" title="Renglon inicio" hidden>
                    <input id="renglon_fin" name="renglon_fin" value="<?php echo $renglon['renglon_id'] ?>" title="Renglon final" hidden>
                    <div class="form-group">
                      <div class="col-xs-12">
                          <div class="form-material">
                              <input class="form-control focus"  type="text"  id="renglon_nm" name="renglon_nm"  value="<?php echo $renglon['renglon_nm'] ?>" readonly>
                              <label for="renglon_nm">Titulo del Renglón</label>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="js-datepicker form-control" type="text" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fecha_inicio ?>" data-date-format="dd-mm-yyyy" data-date-language="es-ES" placeholder="dd-mm-yyyy" required>
                                <label for="fecha_inicio">Fecha Inicio*</label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="js-datepicker form-control" type="text" id="fecha_fin" name="fecha_fin" value="<?php echo $fecha_fin ?>" max="<?php echo $fecha_fin ?>" data-date-format="dd-mm-yyyy" data-date-language="es-ES" placeholder="dd-mm-yyyy" required>
                                <label for="fecha_fin">Fecha Fin*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12 text-center">
                          <button class="btn btn-sm btn-info btn-block" type="submit"><i class=""></i>Generar Reporte</button>
                      </div>
                    </div>
                </form>
            </div>
          </div>
          <!-- Page JS Code -->
          <script>
              jQuery(function(){
                  // Init page helpers (BS Datepicker plugin)
                  App.initHelpers(['datepicker']);
              });
          </script>
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
