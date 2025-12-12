<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('crearCupon')) :
          $id=$_SESSION['user_id'];
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Modificar</title>
            <link rel="stylesheet" href="../herramientas/assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">

        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-content">
              <div class="tag-green">Agregar Cupones</div>
            <div class="">
                <ul class="block-options2" style="margin-top:-40px;">
                    <li>
                        <button data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                    </li>
                </ul>
                <br>
            </div>
            <form class="js-validation-cupones form-horizontal push-10-t push-10">

              <div class="form-group">
                <div class="col-xs-12">
                  <div class="form-material">
                    <div class="input-group has-personalizado">


                      <input class="form-control input-sm"  type="number"  id="cupon_i" name="cupon_i" value="" placeholder="Cupón Inicial"  enabled required>
                      <span class="input-group-addon" ><span>a</span></span>
                      <input class="form-control input-sm"  type="number"  id="cupon_f" name="cupon_f" value="" placeholder="Cupón Final" enabled required>
                    </div>
                      <label for="user_mail">Cupones*</label>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="col-xs-4">
                    <div class="form-material">
                      <div class="input-group has-personalizado">
                        <span class="input-group-addon" ><span class="fa fa-calendar-check-o"></span></span>
                        <input class="js-datepicker form-control input-sm" type="text" id="fecha_emi" name="fecha_emi" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" required>
                      </div>
                        <label for="ext_id">Fecha Emisión*</label>
                    </div>
                </div>
                <div class="col-xs-4">
                  <div class="form-material">
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="fa fa-calendar-times-o"></span></span>
                            <input class="js-datepicker form-control input-sm" type="text" id="fecha_ven" name="fecha_ven" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" required>
                          </div>
                          <label for="user_vid">Fecha Vencimiento*</label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                      <div class="form-material">
                              <div class="input-group has-personalizado">
                                <span class="input-group-addon" ><span class="">Q</span></span>
                                <input class="form-control input-sm"    id="monto" name="monto"  enabled required>
                              </div>
                              <label for="monto">Monto*</label>
                            </div>
                        </div>

                </div>
                <div class="form-group">
                  <div class="col-xs-12 text-center">
                      <button class="btn btn-sm btn-success btn-block" onclick="crear_cupones(<?php echo $id ?>)" id="boton_a_u" ><i style="display:none;" id="loading_cu" class="fa fa-refresh fa-spin"></i> Crear Cupones</button>
                  </div>
                </div>
            </form>



          <!-- Page JS Code -->
          <script src="combustible/js/cupon_form_validate.js"></script>

        </body>
        </html>

        <?php
        else :
            echo include(unauthorizedModal());
        endif;
    else:
       echo "<script type='text/javascript'> window.location='../index.php'; </script>";
    endif;
?>
