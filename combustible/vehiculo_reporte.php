<?php
include_once '../inc/functions.php';
include_once 'funciones_cupones.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('leerCupon')):
        $id = null;
        $vehiculo = array();
        $combustible = array(1 => 'Gasolina', 2 => 'Diesel');
        date_default_timezone_set('America/Guatemala');
        $dia = date('w');
        $date = date('d-m-Y');
        $semana_inicio = date('d-m-Y',strtotime('+'.(1-$dia).' days'));
        $semana_fin = date('d-m-Y',strtotime('+'.(7-$dia).' days'));
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            include_once 'inc/Vehicle.php';
            $vehiculo = Vehicle::getByID(usuarioPrivilegiado(),$id);
        }else{
            header("Location: index.php?ref=_43");
        }
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
                <form class="js-validation-vehiculo-reporte form-horizontal push-10-t push-10" action="combustible/vehiculo_reporte_imprimir.php" method="POST" target="_blank">
                    <input id="vehiculo_id" name="vehiculo_id" value="<?php echo $vehiculo['vehiculo_id'] ?>" title="Vehículo ID" hidden>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control focus"  type="text"  id="vehiculo_desc" name="vechiculo_des" value="<?php echo $vehiculo['placa'].' - '.$vehiculo['nombre'] ?>" disabled>
                                <label for="vehiculo_desc">Vehículo</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="js-datepicker form-control" type="text" id="fecha_inicio" name="fecha_inicio" value="<?php echo $semana_inicio ?>"  data-date-language="es-ES" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" data-date-end-date="<?php echo $semana_fin ?>" required>
                                <label for="fecha_inicio">Fecha Inicio</label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="js-datepicker form-control" type="text" id="fecha_fin" name="fecha_fin" value="<?php echo $semana_fin ?>" data-date-language="es-ES" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" data-date-end-date="<?php echo $semana_fin ?>" required>
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
