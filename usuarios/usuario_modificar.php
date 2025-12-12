<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('Configuracion')) :
            $id = null;
            $persona = array();
            $user_rol = null;
            $roles = array();
            $departamentos = array();
            if ( !empty($_GET['id'])) {
              $id = $_REQUEST['id'];
            }

            if ( null==$id ) {
              header("Location: index.php?ref=_35");
            }

            if ( !empty($_POST)) {
                //User::usuarioModificar($id);
                header("Location: index.php?ref=_35");
            }else{
                $roles = roles();
                $persona = User::get_empleado_datos_id($id);
                $user_rol = User::userRole($id);
                $departamentos = departamentos();
                $horas = tipo_de_horarios();
            }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Modificar</title>
            <script src="../herramientas/assets/js/plugins/chosen/chosen.jquery.js"></script>
            <script src="../herramientas/assets/js/plugins/chosen/docsupport/prism.js"></script>
            <script src="../herramientas/assets/js/plugins/chosen/docsupport/init.js"></script>
            <link rel="stylesheet" href="../herramientas/assets/js/plugins/chosen/chosen.css">

        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-content">
              <div class="tag-green">Datos Técnicos</div>
            <div class="">
                <ul class="block-options2" style="margin-top:-40px;">
                    <li>
                        <button data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                    </li>
                </ul>
                <br>
            </div>


              <form class="js-datos-tecnicos form-horizontal push-10-t push-10" action="" method="">
                <div class="form-group">
                    <div class="col-xs-9">
                        <div class="">
                            <label for="user_nm1">Empleado</label>
                          <div class="input-group has-personalizado" >
                            <span class="input-group-addon" disabled ><span class="si si-user"></span></span>
                            <input class="form-control"  type="text"  id="user_nm1" name="user_nm1" value="<?php echo $persona['user_nm1'].' '.$persona['user_nm2']. ' '. $persona['user_ap1'] . ' '. $persona['user_ap2']?>" disabled>
                          </div>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="">
                            <label for="user_nm1">Renglón</label>
                          <div class="input-group has-personalizado" >
                            <span class="input-group-addon" disabled ><span class="fa fa-list"></span></span>
                            <input class="form-control"  type="text"  id="user_renglon" name="user_renglon" value="<?php echo $persona['renglon']?>" disabled>
                          </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-group">
                  <div class="col-xs-6">
                      <div class="form-material">
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><span class="fa fa-phone"></span></span>
                          <input class="form-control"  type="number"  id="ext_id" name="ext_id" value="<?php echo $persona['ext_id'] ?>" enabled >
                        </div>
                          <label for="ext_id">Extensión</label>
                      </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-material">
                            <div class="input-group has-personalizado" style="width:100%">
                              <span class="input-group-addon group_input_personalizado" ><span class="material-icons fa-personalizado">fingerprint</span></span>
                              <input class="form-control"  type="number"  id="user_vid" name="user_vid" value="<?php echo $persona['user_vid'] ?>"  enabled >
                            </div>
                            <label for="user_vid">Código Biométrico*</label>
                          </div>
                      </div>

                  </div>
                  <div class="form-group">
                  <div class="col-xs-12">
                      <div class="form-material">
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><span class="fa fa-envelope"></span></span>
                          <?php
                          $mystring = $persona['user_mail'];
                          $parts = explode("@",$mystring);

                          //break the string up around the "/" character in $mystring
                          $mystring = $parts['0'];
                          //grab the first part
                          ?>
                          <input class="form-control"  type="text"  id="user_mail" name="user_mail" value="<?php echo $mystring ?>"  enabled required>
                        <span class="input-group-addon" ><span>vicepresidencia@.gob.gt</span></span>
                        </div>
                          <label for="user_mail">Correo institucional*</label>
                      </div>
                  </div>
                </div>




                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material">
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="fa fa-users"></span></span>
                            <select class ="chosen-select-width" name="role_id"  id="role_id" style="width: 100%;" data-placeholder="-- Seleccionar Roll --" required>

                                <option value="0"></option>
                                <?php foreach ($roles as $rol): ?>
                                    <option value="<?=$rol["role_id"]?>" <?php if($rol['role_id'] == $user_rol['role_id']){ echo 'selected'; } ?>><?=$rol['role_nm'];?></option>
                                <?php endforeach ?>
                            </select>
                          </div>
                            <label for="role_id">Roll</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12 text-right">
                      <div class="btn-group btn-group-sm" role="group">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="Second group">

                          <button class="btn btn-sm btn-secondary" onclick="asignar_datos_tecnicos(<?php echo $_SESSION['user_id']?>, <?php echo $persona['user_id'] ?>)"><i style="display:none;" id="loading_mous" class="fa fa-refresh fa-spin"></i> Guardar Cambios</button>
                          <?php if($persona['verificacion']!=1){?>
                            <button class="btn btn-sm btn-secondary" type="button" onclick="verificar(<?php echo $_SESSION['user_id']?>, <?php echo $persona['user_id'] ?>, <?php echo $persona['user_status'] ?>)"><i style="display:none;" id="loading_verificar" class="fa fa-refresh fa-spin"></i> Verificar</button>
                          <?php }?>
                        </div>
                      </div>

                    </div>
                </div>
              </div>
              </form>
            </div>

          </div>
          <!-- Page JS Code -->
          <script>
              jQuery(function(){
                  // Init page helpers (Select2 Inputs plugins)
                  App.initHelpers(['select2']);
              });
          </script>
          <script src="usuarios/js/usuario_datos_tecnicos_form_validate.js"></script>
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
