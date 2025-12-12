<?php
include_once '../inc/functions.php';
include_once 'funciones_cupones.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('leerCupon')):
        date_default_timezone_set('America/Guatemala');
        $dia = date('w');
        $semana_inicio = date('d-m-Y',strtotime('+'.(1-$dia).' days'));
        $semana_fin = date('d-m-Y',strtotime('+'.(7-$dia).' days'));
    ?>
        <!DOCTYPE html>
        <html>
        <head>
          <meta http-equiv="content-type" content="text/html; charset=UTF-8">
          <title>Generar Reporte de Vehículo</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-info">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Generar Reporte de Vehículo</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-vehiculo-reporte form-horizontal push-10-t push-10" action="combustible/vehiculos_reporte_imprimir.php" method="POST" target="_blank">
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="js-datepicker form-control" type="text" id="fecha_inicio" name="fecha_inicio" value="<?php echo $semana_inicio ?>"  data-date-language="es-ES" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" data-date-end-date="<?php echo $semana_fin ?>" required>
                                <label for="fecha_inicio">Fecha Inicio</label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="js-datepicker form-control" type="text" id="fecha_fin" name="fecha_fin" value="<?php echo $semana_fin ?>"  data-date-language="es-ES" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" data-date-end-date="<?php echo $semana_fin ?>" required>
                                <label for="fecha_fin">Fecha Fin</label>
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
          <script src="assets/js/pages/coupons_forms_validation.js"></script>
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
