
<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('modificarPerfil')):
        $user_id = $_SESSION['user_id'];

        $persona = User::getByUserId($user_id);
?>


<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/responsive/2.1.1/css/responsive.dataTables.min.css">
<script src="administrador/js/load.js"></script>

      <!-- INICIO Encabezado de Pagina -->
          <div class="content bg-gray-lighter">
              <div class="row items-push">
                  <div class="col-sm-7">
                      <h1 class="page-heading">
                          PERFIL
                      </h1>
                  </div>

              </div>
          </div>
          <!-- FIN Encabezado de Pagina -->

          <!-- INICIO Contenido de pagina -->
          <div class="content content-boxed">
            <div class="">
            <div class="row">

              <div class="col-md-3 mb30">
                <div class="userProfileInfo panel panel-default">
                  <div class="image text-center">
                    <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="#" class="img-responsive">
                    <p href="" title="image" class="editImage">
                      <i class="fa fa-camera"></i>
                    </p>
                  </div>
          				<div class="box" >
                    <?php
                    $mystring = $persona->persona['user_mail'];
                    $parts = explode("@",$mystring);

                    //break the string up around the "/" character in $mystring
                    $mystring = $parts['0'];
                    //grab the first part
                    ?>

          					<div class="name"><strong><?php echo $persona->persona['user_nm1'].' '. $persona->persona['user_nm2'].' '.$persona->persona['user_ap1'].' '.$persona->persona['user_ap2'] ?></strong></div>
          					<div class="info "style="width:90%; margin-left:auto; margin-right:auto;" >
          						<span><i class="fa fa-fw fa-envelope"></i> <?php echo  $mystring?></span>
          						<span><i class="fa fa-fw fa-phone"></i> <?php echo $persona->persona['ext_id'] ?></span>
          						<span><i class="fa fa-fw fa-user"></i> <?php echo $persona->persona['dep_nm'];?><br><?php echo $persona->persona['user_puesto'];?></span>
          					</div>
          					<div class="socialIcons clearfix" style="width:90%; margin-left:auto; margin-right:auto; border-top:1px solid #e6e7ed">
                      <div class="text-center clearfix">
                          <a class="social-icon-sm si-border si-facebook si-border-round" title="Cambiar Password" onclick="cargar('administrador/password.php');" style="cursor:pointer;">
                              <i class="fa fa-lock"></i>
                          </a>
                          <a href="#" class="social-icon-sm si-border si-twitter si-border-round" onclick="cargar('transporte/solocitudes_listado_perfil.php');">
                            <?php
                            if (function_exists('login_check') && login_check() == true):
                              if($u->hasPrivilege('crearSolicitudTransporte')):
                                ?>
                                <script src="../herramientas/administrador/js/notificaciones_cars_perfil.js"></script>
                                <span id="ns112" class="label-danger-count countttss"></span>
                                <?php
                              endif;
                              endif;
                                 ?>
                              <i class="fa fa-car"></i>
                          </a>
                          <a href="#" class="social-icon-sm si-border si-g-plus si-border-round">
                              <i class="fa fa-tasks"></i>
                          </a>
                          <a href="logout.php" title="Salir" class="social-icon-sm si-border si-skype si-border-round outline">
                              <i class="fa fa-power-off"></i>
                          </a>
                      </div>
          					</div>
          				</div>
          			</div>
          		</div>


                  <div class="col-md-8 mb30">
                      <div  class="">
                          <div>

                              <!-- Nav tabs -->


                              <!-- Tab panes -->
                              <div class="">
                                  <div role="tabpanel" class="tab-pane active show" id="t1">
                                      <ul class="activity-list list-unstyled">
                                          <li id="tabla2" class="clearfix">

                                          </li>
                                      </ul>
                                  </div>


                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <!-- FIN Contenido de Pagina -->

        <?php
    else:
        echo include('inc/401.php');
    endif;
else:
    echo "<script type='text/javascript'> window.location='index.php'; </script>";
endif;
?>
