<?php
include_once '../inc/functions.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('leerCheques')):
        include_once 'inc/Account.php';
        date_default_timezone_set('America/Guatemala');
        $fecha_fin = date('d-m-Y',time());
        $fecha_inicio = '01-01-'.date('Y');
        $id = null;
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
        }
        if ( null==$id ) {
            header("Location: index.php?ref=_17");
        }
    ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Balance de Cuenta</title>
        </head>
        <body>
            <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-info">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Balance de Cuenta</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-credito form-horizontal push-10-t push-10" action="?ref=_22&id=<?php echo $id ?>" method="POST">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="fecha_inicio">Rango Fecha</label>
                        <div class="col-md-8">
                            <div class="input-daterange input-group" data-date-format="dd-mm-yyyy">
                                <input class="form-control" type="text" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fecha_inicio ?>" placeholder="Desde" required>
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input class="form-control" type="text" id="fecha_fin" name="fecha_fin" value="<?php echo $fecha_fin ?>" placeholder="A" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <button class="btn btn-sm btn-info btn-block" type="submit"><i class=""></i>Generar Balance</button>
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
            <script src="assets/js/pages/cheque_forms_validation.js"></script>
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
