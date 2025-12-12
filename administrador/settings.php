<?php
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('Configuracion')) :

        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Horario</title>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="administrador/js/load.js"></script>



        </head>
        <body>



          <div class="content content-boxed">
            <div class="panel panel-success sett">
              <div id="contenedor">
                <div class="backgroundh" style="height: 64px; width:64px; display:inline-block; margin-top:10px; margin-left:10px;"></div>
                <div class="h1 font-w700 text-black-op" style="display:inline-block; margin-top:20px; margin-left:5px;">Configuración</div>



                  <br><br>
              </div>
<br>
              <div id="tabla" class="panel-body bg-white-op">
                <div id="h">
                  <br>
                <div  class="row">
                  <div class="col-xs-12 col-sm-3">
                    <a class="panel panel-default block block-link-hover3 block-link-hover33 text-center"  style="cursor:pointer;">
                      <div class="block-content block-content-full">
                        <img src="<?php echo $one->assets_folder; ?>/img/settings_app.png"/>
                        <div class="h3 font-w700 text-black-op" >Editar App</div>
                      </div>
                      <div class=" block-content block-content-full block-content-mini bg-gray-lighter text-black-op font-w600">Editar Contenido Básico</div>
                    </a>
                  </div>

                  <div class="col-xs-6 col-sm-3">
                    <a class="panel panel-default block block-link-hover3 block-link-hover33 text-center" onclick="cargar('administrador/server_status.php');" style="cursor:pointer;">
                      <div class="block-content block-content-full">
                        <img src="<?php echo $one->assets_folder; ?>/img/server.png"/>
                        <div class="h3 font-w700 <?php echo (($u->hasPrivilege("crearUsuario"))?'text-black-op':'') ?>">DataBase</div>
                      </div>
                      <div class=" block-content block-content-full block-content-mini bg-gray-lighter font-w600 <?php echo (($u->hasPrivilege("Configuracion"))?'text-black-op':'') ?>">Configuración de Base de Datos</div>
                    </a>
                  </div>
                  <div class="col-xs-6 col-sm-3">
                    <a class="panel panel-default block block-link-hover3 block-link-hover33 text-center"  onclick="cargar('administrador/nuevo_role_permiso.php');" style="cursor:pointer;">
                      <div class="block-content block-content-full">
                        <img src="<?php echo $one->assets_folder; ?>/img/roles_perm.png"/>
                        <div class="h3 font-w700 text-success" >Agregar </div>
                      </div>
                      <div class=" block-content block-content-full block-content-mini bg-gray-lighter text-success font-w600">Crear Nuevos Roles y Permisos</div>
                    </a>
                  </div>
                  <div class="col-xs-6 col-sm-3">
                    <a id="permisos" class="panel panel-default block block-link-hover3 block-link-hover33 text-center" style="cursor:pointer;">
                      <div class="block-content block-content-full">
                        <img src="<?php echo $one->assets_folder; ?>/img/collaboration.png"/>
                        <div class="h3 font-w700 text-black-op" >Roles Permisos</div>
                      </div>
                      <div class=" block-content block-content-full block-content-mini bg-gray-lighter text-black-op font-w600">Asignación Roles y Permisos</div>
                    </a>
                  </div>
                </div>



                <div  class= "row">
                  <div class="col-xs-6 col-sm-3">
                    <a class="panel panel-default block block-link-hover3 block-link-hover33 text-center" onclick="cargar('administrador/horarios.php');" style="cursor:pointer;">
                      <div class="block-content block-content-full">
                        <img src="<?php echo $one->assets_folder; ?>/img/rewind-time.png"/>
                        <div class="h3 font-w700 <?php echo (($u->hasPrivilege("crearUsuario"))?'text-black-op':'') ?>">Subir Horarios</div>
                      </div>
                      <div class=" block-content block-content-full block-content-mini bg-gray-lighter font-w600 <?php echo (($u->hasPrivilege("Configuracion"))?'text-black-op':'') ?>">Horario de Entrada y Salida</div>
                    </a>
                  </div>

                  <div class="col-xs-6 col-sm-3">
                    <a class="panel panel-default block block-link-hover3 block-link-hover33 text-center" onclick="cargar('administrador/asuetos.php');" style="cursor:pointer;">
                      <div class="block-content block-content-full">
                        <img src="<?php echo $one->assets_folder; ?>/img/wall-calendar.png"/>
                        <div class="h3 font-w700 text-black-op" >Feriados - Asuetos</div>
                      </div>
                      <div class=" block-content block-content-full block-content-mini bg-gray-lighter text-black-op font-w600">Asignar Dias Festivos o Asuetos</div>
                    </a>
                  </div>
                  <div class="col-xs-12 col-sm-3">
                    <a class="panel panel-default block block-link-hover3 block-link-hover33 text-center" <?php echo (($u->hasPrivilege("Configuracion"))?' href="  "':'href="#" disabled') ?>>
                      <div class="block-content block-content-full">
                        <img src="<?php echo $one->assets_folder; ?>/img/bars-chart.png"/>
                        <div class="h3 font-w700 text-black-op" >Estadísticas</div>
                      </div>
                      <div class=" block-content block-content-full block-content-mini bg-gray-lighter text-black-op font-w600">Gráficas en base a resultados</div>
                    </a>
                  </div>

                  <div class="col-xs-6 col-sm-3">
                    <a class="panel panel-default block block-link-hover3 block-link-hover33 text-center" <?php echo (($u->hasPrivilege("Configuracion"))?' href=""':'href="#" disabled') ?>>
                      <div class="block-content block-content-full">
                        <img src="<?php echo $one->assets_folder; ?>/img/speedometer.png"/>
                        <div class="h3 font-w700 <?php echo (($u->hasPrivilege("crearUsuario"))?'text-black-op':'') ?>">Dashboard</div>
                      </div>
                      <div class=" block-content block-content-full block-content-mini bg-gray-lighter font-w600 <?php echo (($u->hasPrivilege("Configuracion"))?'text-black-op':'') ?>">Dashboard</div>
                    </a>
                  </div>
                </div>
              </div>

<br>
                <div style="display:none;" id="tabla2">


                </div>


              </div>






          <script>
              jQuery(function(){
                  // Init page helpers (Select2 Inputs plugins)
                  App.initHelpers(['select2']);
              });
          </script>

        </body>
        </html>

        <?php
        else :
            echo include(unauthorizedModal());
        endif;
    else:
       echo "<script type='text/javascript'> window.location='../index.php; </script>";
    endif;
?>
