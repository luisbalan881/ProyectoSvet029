
<?php
include_once '../inc/functions.php';
sec_session_start();
$u=usuarioPrivilegiado();
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('modificarUsuario')):
      $id = null;
        $error_msg = '';
        $departamentos = array();
        $roles = array();
        $horas = array();
        $renglones = array();
        $nacionalidades = array();
        $persona = array();
        $genero = array();
        $estado_civil = array();

        $sueldo = array();
        if ( !empty($_GET['id'])) {
          $id = $_REQUEST['id'];
        }

        if ( !empty($_POST)){
            //User::usuarioNuevo();
            //User::update_empleado_datos_id($id);
            header("Location: index.php?ref=_35");
        }else{
            $persona = User::get_empleado_datos_id($id);
            $departamentos = departamentos();
            $roles = roles();
            $horas = tipo_de_horarios();

            $nacionalidades = get_nacionalidades();
            $estado_civil = get_estado_civil();
            $genero = get_genero();
            $sueldo = User::get_empleado_sueldo_byId($id);

            if(verificar_director($_SESSION['user_id'])==1 || usuarioPrivilegiado()->hasPrivilege('Configuracion') || (permiso_dep(8)&&permiso_dep(9)))
            {
              $renglones = get_renglones(0);
            }
            else if(permiso_dep(8)){
              $renglones = get_renglones_011_022(0);
            }
            else if(permiso_dep(9)){
              $renglones = get_renglones_029(0);
            }

        }
?>



      <!-- INICIO Encabezado de Pagina -->
      <div class="block block-themed card remove-margin-b">
      <div class="block-content">
        <div class="col-xs-6">
            <div id="datos_emp" class="input-group has-personalizado" style="margin-left:-15px">
              <span id="titulo_h"  class="input-group-addon" disabled><strong class="">Perfil :</strong></span>
              <span class="input-group-addon span-personalizado" type="text"><?php echo $persona['user_nm1'] . ' '.$persona['user_nm2'].' '.$persona['user_ap1'].' '.$persona['user_ap2'] ?> </span>
            </div>
        </div>
        <div class="">
            <ul class="block-options2" style="margin-top:0px;">
                <li>
                    <button data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                </li>
            </ul>


        </div>
          <!-- FIN Encabezado de Pagina -->

          <!-- INICIO Contenido de pagina -->
        </div>
          <!-- FIN Encabezado de Pagina -->

          <!-- INICIO Contenido de pagina -->
          <div class="content content-boxed">

            <div class="row">

              <div class="col-sm-3" style="margin-left:-10px">
                <div class="userProfileInfo panel panel-default">
                  <div class="image text-center">
                    <?php if($persona['fotografia']==''){?>
                    <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="#" class="img-responsive">
                  <?php } else { echo '<img src="../herramientas/usuarios/fotos/'.$persona['fotografia'].'"></img>';
                  }?>
                    <p href="" title="image" class="editImage">
                      <i class="fa fa-camera"></i>
                    </p>
                  </div>
          				<div class="box" >
                    <?php
                    $mystring = $persona['user_mail'];
                    $parts = explode("@",$mystring);

                    //break the string up around the "/" character in $mystring
                    $mystring = $parts['0'];
                    //grab the first part
                    ?>

          					<div class="name"><strong><?php echo $persona['user_nm1'].' '. $persona['user_nm2'].' '.$persona['user_ap1'].' '.$persona['user_ap2'] ?></strong></div>
          					<div class="info "style="width:90%; margin-left:auto; margin-right:auto;" >
          						<span><i class="fa fa-fw fa-envelope"></i> <?php echo  $mystring?></span>
          						<span><i class="fa fa-fw fa-phone"></i> <?php echo $persona['ext_id'] ?></span>
          						<span><i class="fa fa-fw fa-user"></i> <?php
                          foreach ($departamentos as $n):
                              if($n['dep_id'] == $persona['dep_id']){ echo $n['dep_nm']; }
                          endforeach
                      ?><br><?php echo $persona['user_puesto'];?></span>
          					</div>
          					<div class="socialIcons clearfix" style="width:90%; margin-left:auto; margin-right:auto; border-top:1px solid #e6e7ed">
                      <div class="text-center clearfix">
                          <a class="social-icon-sm si-border si-facebook si-border-round" title="Cambiar Password" onclick="cargar('administrador/password.php');" style="cursor:pointer;">
                              <i class="fa fa-lock"></i>
                          </a>
                          <a href="#" class="social-icon-sm si-border si-twitter si-border-round" onclick="cargar('transporte/solocitudes_listado_perfil.php');">
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


                  <div class="col-md-9 mb30">
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
          <!-- FIN Contenido de Pagina -->

        <?php
    else:
        echo include(unauthorizedModal());
    endif;
else:
    echo "<script type='text/javascript'> window.location='index.php'; </script>";
endif;
?>
