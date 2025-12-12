<?php

$fechi='';
$fechf='';

$fechm='';
$fecha='';

if (isset($_POST['enviar'])) {

if($_POST['mes']<10){
  $fechi = $_POST['anio'].'-0'.$_POST['mes'].'-01';
  $fechf = $_POST['anio'].'-0'.$_POST['mes'].'-20';
    }
else{
$fechi = $_POST['anio'].'-'.$_POST['mes'].'-01';
$fechf = $_POST['anio'].'-'.$_POST['mes'].'-20';
}

if($_POST['mes']<10){
  $fechm = '0'.$_POST['mes'];
  $fecha = $_POST['anio'];
    }
else{
$fechm = $_POST['mes'];
$fecha = $_POST['anio'];

}
}
 ?>
<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('modificarPerfil')):
        $user_id = $_SESSION['user_id'];
        $error_msg = '';
        $persona= null;
        if (!empty($_POST)){
            if (isset($_POST['p'])) {
                $password = $_POST['p']; // The hashed password.
                if (strlen($password) != 128) {
                    // La contraseña con hash deberá ser de 128 caracteres.
                    $error_msg .= '<p class="error">Contraseña no cumple los requisitos.</p>';
                }
                if (empty($error_msg)) {
                    $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
                    // Crea una contraseña con sal.
                    $password = hash('sha512', $password . $random_salt);
                    // Crear usuario con contraseña definida.
                    User::actualizarPassword($password, $random_salt, $user_id);
                    echo "<script type='text/javascript'> window.location='index.php'; </script>";
                }
            }
        }
        $persona = User::getByUserId($user_id);
?>
      <!-- INICIO Encabezado de Pagina -->
          <div class="content bg-gray-lighter">
              <div class="row items-push">
                  <div class="col-sm-7">
                      <h1 class="page-heading">
                          PERFIL
                      </h1>
                  </div>
                  <div class="col-sm-5 text-right hidden-xs">
                      <ol class="breadcrumb push-10-t">
                          <li>Vicepresidencia</li>
                          <li><a class="link-effect" href="#">Usuario</a></li>
                          <li><a class="link-effect" href="#">Configuración</a></li>
                      </ol>
                  </div>
              </div>
          </div>
          <!-- FIN Encabezado de Pagina -->
          <?php
              if (!empty($error_msg)){
                  echo $error_msg;
              }
          ?>
          <!-- INICIO Contenido de pagina -->
          <div class="content content-boxed">
            <div class="row">
                <div class="col-lg-3">
                  <!-- Inforamcion Usuario -->
                  <div class="block block-themed block-rounded">
                      <div class="block-header bg-primary">
                          <h3 class="block-title">Usuario</h3>
                      </div>
                      <div class="block-content block-content-full">
                          <div class="h4 push-5"><?php echo $persona->persona['user_pref']." ".$persona->persona['user_nm1']." ".$persona->persona['user_ap1'];?></div>
                          <article>
                              <?php echo"Departmento: ".$persona->persona['dep_nm'];?><br>
                              <?php echo"Puesto: ".$persona->persona['user_puesto'];?><br>
                              <?php echo"Extensión: ".$persona->persona['ext_id'];?><br>
                          </article>
                      </div>
                  </div>
                  <!-- END Inforamcion Usuario -->

                  <div class="block block-themed block-rounded">
                      <div class="block-header bg-primary">
                          <h3 class="block-title">Mis horarios</h3>
                      </div>
                      <div class="block-content block-content-full">
                        <form class="-horizontal push-10-t push-10" action="<?php ?>" method="post">
                          <div class="form-group">


                            <label > Generar mi horario</label>
                          </div>
                            <div >
                                <div class="form-group">
                            <select name="mes" class=" form-control " >
                              <?php
                              for ($x=1; $x<=12; $x++) {
                                if ($x == date('m'))
                                echo '<option value="'.$x.'" selected>'.User::get_nombre_mes($x).'</option>';
                                else
                                echo '<option value="'.$x.'">'.User::get_nombre_mes($x).'</option>';
                              }
                              ?>
                            </select>
                          </div>

                        <div class="form-group">

                            <select name="anio"  class=" form-control">
                              <?php
                              for($i=date('o'); $i>=2015; $i--){
                                if ($i == date('o'))
                                echo '<option value="'.$i.'" selected>'.$i.'</option>';
                                else
                                echo '<option value="'.$i.'">'.$i.'</option>';
                              }
                              ?>
                            </select>


                        </div>
                        <div class="form-group">
                          <div class="col-xs-13 text-center">
                            <button class="btn btn-sm btn-success btn-block" type="submit" name='enviar'><i class=""></i>Generar Reporte</button>
                              <?php //echo '<a style="width:100%;" class="btn btn-primary"  title="Ver Horarios"  data-toggle="modal" data-target="#modal-remoto-lgg" href="usuarios/usuario_horario.php?mess='.$fechm.'&anio='.$fecha.'&id='.$user_id.'"><i style="font-weight:normal; font-style:normal; font-size:15px;" >Ver mi Horario</i></a>';?>
                          </div>
                          </div>
                          </div>
                        </form>
                      </div>
                  </div>
                </div>



                <div class="col-lg-9">
                  <!-- Modificar Contraseña -->
                  <div class="block block-themed block-rounded">
                      <div class="block-header bg-success">
                          <h3 class="block-title">Nueva contraseña</h3>
                      </div>
                      <div class="block-content block-content-full">
                        <form class="js-validation-usuario form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']);?>" method="POST">
                          <div class="form-group">
                              <div class="col-xs-12">
                                  <div class="form-material form-material-success  input-group">
                                      <input class="form-control"  type="password"  id="password" name="password"  required>
                                      <label for="password">Nueva Contraseña</label>
                                      <span class="input-group-addon"><i class=""></i></span>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-xs-12">
                                  <div class="form-material form-material-success  input-group">
                                      <input class="form-control"  type="password"  id="confirmpwd" name="confirmpwd"  required>
                                      <label for="confirmpwd">Confirmar Nueva Contraseña</label>
                                      <span class="input-group-addon"><i class=""></i></span>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-12 text-left">
                                <ul>
                                    <li>Las contraseñas deberán tener al menos 6 caracteres.</li>
                                    <li>Las contraseñas deberán estar compuestas por:
                                        <ul>
                                            <li> Por lo menos una letra mayúscula (A-Z)</li>
                                            <li> Por lo menos una letra minúscula (a-z)</li>
                                            <li> Por lo menos un número (0-9)</li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-success btn-block">Actualizar Contraseña</button>
                            </div>
                          </div>
                        </form>
                      </div>
                  </div>


                  <!-- END Ingreso Producto -->
                </div>

            </div>
          </div>
          <!-- FIN Contenido de Pagina -->
        <script src="assets/js/pages/base_pages_forms.js"></script>
        <script src="assets/js/pages/base_pages_sha512.js"></script>
        <?php
    else:
        echo include(unauthorized());
    endif;
else:
    echo "<script type='text/javascript'> window.location='index.php'; </script>";
endif;
?>
