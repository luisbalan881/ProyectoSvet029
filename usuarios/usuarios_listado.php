<?php
if (function_exists('login_check') && login_check() == true):
  if (isset($u) && $u->hasPrivilege('leerUsuario')):
    ?>
    <!-- Page JS Plugins CSS -->
    <!DOCTYPE html>
    <html>
    <head>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <title></title>
      <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
      <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/responsive/2.1.1/css/responsive.dataTables.min.css">

      <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
      <script src="usuarios/js/load.js"></script>
      <script src="usuarios/js/get_conteo_personas.js"></script>

      <!-- INICIO Encabezado de Pagina -->
      <div class="content bg-gray-lighter">
        <div class="row items-push">
          <div class="col-sm-7">
            <h1 class="page-heading">
              EMPLEADOS
            </h1>
          </div>
          <div  class="" style="z-index:5000; position:absolute;">

          </div>
          <div class="col-sm-5 text-right hidden-xs">

          </div>
        </div>
      </div>
      <!-- FIN Encabezado de Pagina -->

      <!-- INICIO Contenido de pagina -->
      <div class="content content-boxed">


        <!-- Header Tiles -->
        <div id="tabla" class=" ">
          <div id="h">
            <div class="row">
              <div class="col-xs-6 col-sm-25 ">
                  <a class="block block-rounded card block-link-hover3 text-center " <?php echo (($u->hasPrivilege("crearUsuario") && permiso_dep(1) || $u->hasPrivilege("Configuracion"))?'data-toggle="modal" data-target="#modal-remoto-lgg" href="usuarios/usuario_nuevo.php"':'href="#" disabled') ?>>
                      <div class="block-content-full ">
                          <div class="h1 font-w1000"><div  class=" <?php echo (($u->hasPrivilege("crearUsuario")&& permiso_dep(1)|| $u->hasPrivilege("Configuracion"))?'user_add':'user_add_deny') ?>"></div></div>
                      </div>
                      <div class="block-content block-content-full block-content-mini font-w900 h5 <?php echo (($u->hasPrivilege("crearUsuario")&& permiso_dep(1)|| $u->hasPrivilege("Configuracion"))?'text-green':'') ?>">Nuevo Empleado</div>
                  </a>
              </div>
              <div class="col-xs-6 col-sm-25">
                  <a class="block block-rounded card block-link-hover3 text-center" <?php echo (($u->hasPrivilege("crearUsuario")&& permiso_dep(6)|| $u->hasPrivilege("Configuracion"))?'data-toggle="modal" data-target="#modal-remoto-lgg" href="usuarios/suspenciones_listado.php"':'href="#" disabled') ?>>
                      <div class="block-content-full ">
                          <div class="h1 font-w700 "><div  class=" <?php echo (($u->hasPrivilege("crearUsuario")&& permiso_dep(6)|| $u->hasPrivilege("Configuracion"))?'igss_list':'igss_list_deny') ?>"></div></div>
                      </div>
                      <div class="block-content block-content-full block-content-mini h5 font-w900 <?php echo (($u->hasPrivilege("crearUsuario")&& permiso_dep(6)|| $u->hasPrivilege("Configuracion"))?'text-green':'') ?>">Suspenciones</div>
                  </a>
              </div>
              <div class="col-xs-6 col-sm-25">
                <a class="block block-rounded card  text-center" href="javascript:void(0)">
                  <div class="block-content block-content-full ">
                    <div id="total" class="h1 font-w700 text-primary conteo11 " ><i class="fa fa-refresh fa-spin"></i></div>
                  </div>
                  <div class="block-content block-content-full block-content-mini  text-primary h5 font-w900">Total</div>
                </a>
              </div>
              <div class="col-xs-12 col-sm-25">
                <a class="block block-rounded card text-center" href="javascript:void(0)">
                  <div class="block-content block-content-full ">
                    <div id="inactivas" class="h1 font-w700 text-danger" ><i class="fa fa-refresh fa-spin"></i></div>
                  </div>
                  <div class="block-content block-content-full block-content-mini  text-danger h5 font-w900">Inactivos</div>
                </a>
              </div>
              <div class="col-xs-6 col-sm-25">
                <a class="block block-rounded card text-center" href="javascript:void(0)">
                  <div class="block-content block-content-full ">
                    <div id="activar" class="h1 font-w700 text-warning"><i class="fa fa-refresh fa-spin"></i></div>
                  </div>
                  <div class="block-content block-content-full block-content-mini  text-warning h5 font-w900">Pendientes</div>
                </a>
              </div>
            </div>
            <!-- END Header Tiles -->

            <!-- Todos los Productos -->
            <div class="block">
              <div class="block block-themed block-rounded">
              <div class="block-header bg-muted">
                  <ul class="block-options">

                    <li>
                        <button id="Recargar" type="button" onclick="cargar()"></button>
                    </li>
                    <li>
                        <button type="button"><i id="car_t" class="fa fa-refresh"></i></button>
                    </li>
                     <!--<span id="car_t" class=""><i class="fa fa-refresh fa-spin"></i> </span>-->
                    <li>
                         <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                      </li>
                  </ul>
                  <span id="block_show" class="text-white"><h3 class="block-title">CONTROL DE EMPLEADOS</h3></span>
              </div>
            <div id="tabla1" class="block-content">
            </div>
          </div>

        </div>
        <!-- Final Todos los Productos -->

      </div>
      <!-- FIN Contenido de Pagina -->
    </body>
    </html>
        <?php
    else:
        echo include(unauthorized());
    endif;
else:
    echo "<script type='text/javascript'> window.location='../herramientas/inicio.php'; </script>";
endif;
?>
