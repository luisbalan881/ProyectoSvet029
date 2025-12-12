<?php
/**
 * base_header.php
 *
 * Author: pixelcave
 *
 * The header of each page (Backend)
 *
 */
 $nombre = null;
 if($user->persona['user_vid']==42)
 {
   $nombre = $user->persona['user_nm2'];
 }
 else {
   $nombre = $user->persona['user_nm1'];
 }
 ?>

<!-- Header -->
<header id="header-navbar" class="content-mini content-mini-full">
  <div class="cabecera">
    <!-- Header Navigation Right -->
    <ul class="nav-header pull-right">

        <li>
          <div class="btn-group">
          </div>
        </li>
      </ul>
      <ul class="nav-header pull-right">

          <li>
            <div class="btn-group">
            </div>
          </li>
        </ul>

    <ul class="nav-header pull-right">

        <li>
          <div class="btn-group">
            <?php
            if (function_exists('login_check') && login_check() == true):
              if (isset($u) && $u->hasPrivilege('Configuracion')):
                ?>
                <span><a class="btn btn-success " href="?ref=_100"><img src="
                  <?php echo $one->assets_folder; ?>/img/settings.png" class="configuracion"/>
                  Configurar</i></a><span>


                <?php
              endif;
            endif;
            ?>
          </div>
            <div class="btn-group">

                <button class="btn btn-secondary agrandar dropdown-toggle" data-toggle="dropdown" style="font-weight:normal">
                    <i class="fa fa-user"></i> <?php echo  $nombre . ' '. $user->persona['user_ap1']?>
                    <span class="caret"></span>
                </button>

                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-header">Perfil</li>
                    <li>
                      <?php
                      if (function_exists('login_check') && login_check() == true):
                        if($u->hasPrivilege('crearSolicitudTransporte')):
                          ?>
                          <script src="administrador/js/notificaciones_cars.js"></script>
                          <span id="ns111" class="label-danger-count counttts" style="margin-top:5px;"></span>
                          <?php
                        endif;
                        endif;
                           ?>
                        <a tabindex="-1" href="?ref=_0">
                            <i class="si si-user pull-right"></i>
                            <span class="badge badge-success pull-right"></span>Perfil
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Acciones</li>

                    <li>
                      <?php
                      if (function_exists('login_check') && login_check() == true):
                        if(verificar_director($user->persona['user_id'])==1 || $u->hasPrivilege('Configuracion')):

                       ?>
                      <a tabindex="-1" href="?ref=_99">
                          <i class="si si-speedometer pull-right"></i>Control de Usuarios
                      </a>
                      <?php
                    endif;
                    endif;
                       ?>

                       <?php
                       if (function_exists('login_check') && login_check() == true):
                         if($u->hasPrivilege('crearSolicitudTransporte')):

                        ?>
                       <script src="transporte/js/load_solicitud.js"></script>
                       		
						<a tabindex="-1" data-toggle="modal" data-target="#modal-remoto-lgg" href="viaticos/solicitar_viaticos.php"  style="cursor:pointer;">
                            <i class="fa fa-car pull-right"></i>Solicitar viáticos
                             </a>
							 
							 <a tabindex="-1" data-toggle="modal" data-target="#modal-remoto-lgg" href="viaticos/solicitar_nombramiento.php"  style="cursor:pointer;"> 
                           <i class="fa fa-car pull-right"></i>Crear Asignación de Actividades  
                        </a>
                           

                    <?php
                  endif;
                  endif;
                     ?>


                        <a tabindex="-1" href="logout.php">
                            <i class="si si-logout pull-right"></i>Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
            <?php
            if (function_exists('login_check') && login_check() == true):
              if (isset($u) && $u->hasPrivilege('Configuracion')):
                ?>
                <script src="administrador/js/notificaciones.js"></script>
                <span id="ns1" class="label-danger-count count" ></span>
                <button class="btn btn-secondary" data-toggle="layout" data-action="side_overlay_toggle" type="button">
                  <i class="fa fa-tasks"></i>
                </button>

                <?php
              endif;
            endif;
            ?>
            <!--Layout API, functionality initialized in App() -> uiLayoutApi() -->
        </li>


    </ul>

    <!-- END Header Navigation Right -->

    <!-- Header Navigation Left -->
    <ul class="nav-header pull-left">
        <li class="hidden-md hidden-lg">
            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
            <button class="btn btn-default" data-toggle="layout" data-action="sidebar_toggle" type="button">
                <i class="fa fa-navicon"></i>
            </button>
        </li>

            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
            <a class="boton_personalizado fa fa-arrow-left" data-toggle="layout" data-action="sidebar_mini_toggle">

            </a>

    </ul>
  </div>
  <div class="ancho_noti">
  <div  class="notificacion_alerta2">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    <i id="icono_n2"></i><h1 id="titulo2"></h1>
  </div>
  <div class="notificacion_alerta_success">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    <i id="icono_n2" class="fa fa-check"></i><h1 id="title2"></h1>
  </div>
  <div class="notificacion_alerta_warning">
    <span class="closebtn black_cb" onclick="this.parentElement.style.display='none';">&times;</span>
    <i id="icono_n3"></i><h1 id="title3"></h1>
  </div>
</div>
    <!-- END Header Navigation Left -->
</header>
<!-- END Header -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(function(){




              get_notificaciones_cars();


              setInterval(function(){
               get_notificaciones_cars();

              }, 5000);
  });

</script>

</script>
