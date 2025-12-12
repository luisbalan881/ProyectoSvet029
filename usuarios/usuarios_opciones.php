<?php
if (function_exists('login_check') && login_check() == true):
  if (isset($u) && $u->hasPrivilege('leerUsuario')):
    ?>
    <!-- Page JS Plugins CSS -->
    <!DOCTYPE html>
    <html>
    <head>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <title>Usuario Horario</title>
      <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
      <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/responsive/2.1.1/css/responsive.dataTables.min.css">

      <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
      <script src="../herramientas/administrador/js/load.js"></script>

      <!-- INICIO Encabezado de Pagina -->
      <div class="content bg-gray-lighter">
        <div class="row items-push">
          <div class="col-sm-7">
            <h1 class="page-heading">
              EMPLEADOS
            </h1>
          </div>
          <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
              <li>CONTROL DE USUARIOS</li>
              <li><a class="link-effect" href="#">Usuarios</a></li>
            </ol>
          </div>
        </div>
      </div>
      <!-- FIN Encabezado de Pagina -->
      <?php
      $total_personas = 0;
      $personas_inactivas = 0;
      $personas_pendientes = 0;
      $personas = personas();
      foreach ($personas as $persona):
        $total_personas++;
        if ($persona['user_status'] == 0){ $personas_inactivas++;}
        if ($persona['user_status'] == 2){ $personas_pendientes++;}
      endforeach;
      ?>
      <!-- INICIO Contenido de pagina -->
      <div class="content content-boxed">

        <div style="margin-top:30px;"> <a id="back" tooltip="Regresar" class="btn-circle" style="float:right;display:none;  cursor:pointer;" onclick="cargar('../herramientas/administrador/scripts_php/en_blanco.php')">.</a></div>
        <!-- Header Tiles -->
        <div id="tabla" class=" ">
          <div id="h">
            <div class="row">
                    <div class="col-xs-6 col-sm-25 ">
                        <a class="block block-rounded card block-link-hover3 text-center " <?php $dir='usuarios/usuario_nuevo.php';  if ($u->hasPrivilege("crearUsuario")){ ?> onclick="cargar('usuarios/usuarios_listado.php')" <?php } else {echo'href="#" disabled';} ?> >
                            <div class="block-content-full ">
                                <div class="h1 font-w1000"><div  class=" <?php echo (($u->hasPrivilege("crearUsuario"))?'user_add':'user_add_deny') ?>"></div></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini font-w900 h5 <?php echo (($u->hasPrivilege("crearUsuario"))?'text-green':'') ?>">Listado Usuarios</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-25 ">
                        <a class="block block-rounded card block-link-hover3 text-center " <?php $dir='usuarios/usuario_nuevo.php';  if ($u->hasPrivilege("crearUsuario")){ ?> onclick="cargar('usuarios/usuario_nuevo.php')" <?php } else {echo'href="#" disabled';} ?> >
                            <div class="block-content-full ">
                                <div class="h1 font-w1000"><div  class=" <?php echo (($u->hasPrivilege("crearUsuario"))?'user_add':'user_add_deny') ?>"></div></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini font-w900 h5 <?php echo (($u->hasPrivilege("crearUsuario"))?'text-green':'') ?>">Nuevo Empleado</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-25">
                        <a class="block block-rounded card block-link-hover3 text-center" <?php echo (($u->hasPrivilege("crearUsuario"))?'data-toggle="modal" data-target="#modal-remoto-lgg" href="usuarios/suspenciones_listado.php"':'href="#" disabled') ?>>
                            <div class="block-content-full ">
                                <div class="h1 font-w700 "><div  class=" <?php echo (($u->hasPrivilege("crearUsuario"))?'igss_list':'igss_list_deny') ?>"></div></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini h5 font-w900 <?php echo (($u->hasPrivilege("crearUsuario"))?'text-green':'') ?>">Suspenciones</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-25">
                        <a class="block block-rounded card  text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full ">
                                <div class="h1 font-w700 text-primary" data-toggle="countTo" data-to="<?php echo $total_personas; ?>"></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini  text-primary h5 font-w900">Total</div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-25">
                        <a class="block block-rounded card text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full ">
                                <div class="h1 font-w700 text-danger" data-toggle="countTo" data-to="<?php echo $personas_inactivas ?>"></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini  text-danger h5 font-w900">Inactivos</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-25">
                        <a class="block block-rounded card text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full ">
                                <div class="h1 font-w700 text-warning" data-toggle="countTo" data-to="<?php echo $personas_pendientes; ?>"></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini  text-warning h5 font-w900">Pendientes</div>
                        </a>
                    </div>
                </div>
            <!-- END Header Tiles -->

            <!-- Todos los Productos -->
            <div class="block">
              <div class="block block-themed block-rounded" id="block_hide">
              <div class="block-header bg-muted">
                  <ul class="block-options">
                    <li>
                         <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                      </li>
                  </ul>
                  <span id="block_show" class="text-white"><h3 class="block-title">CONTROL DE HORARIO DE EMPLEADOS</h3></span>
              </div>
                <div class="block-content">

                </div>
            </div>
          </div>
        </div>
        <!-- Final Todos los Productos -->
        <div style="display:none;" id="tabla2" class="col-xs-12">
        </div>
      </div>
      <!-- FIN Contenido de Pagina -->
    </body>
    </html>
        <?php
    else:
        echo include(unauthorized());
    endif;
else:
    echo "<script type='text/javascript'> window.location='../directorio/index.php'; </script>";
endif;
?>
