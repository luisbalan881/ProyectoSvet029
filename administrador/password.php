
<?php include_once '../inc/functions.php';
sec_session_start();
    if (function_exists('login_check') && login_check() == true):
        if (usuarioPrivilegiado()->hasPrivilege('modificarPerfil')):

            $roles = array();
            $user_id = $_SESSION['user_id'];

        ?>

<!DOCTYPE HTML>
<html lang="en">
<head>

	<title>Asuetos</title>


</head>
<body>
  <div class=" panel panel-default ">
    <div class="panel-body ">

      <div class="tag-green">Cambiar Password</div>
      <p id="message"></id>
    </div>
    <div class="block-content">
      <form class="js-validation-usuario form-horizontal"  id="loginForm" method="" action="" novalidate="novalidate">
      <div class="form-group">
          <div class="col-xs-12">
              <label for="password">Nueva Contraseña</label>
              <div class="input-group has-personalizado">
                <span class="input-group-addon" ><span class="si si-lock"></span></span>
                <input class="form-control"  type="password"  id="password" name="password"  required>
              </div>
          </div>
      </div>
      <div class="form-group">
          <div class="col-xs-12 ">
            <label for="confirmpwd">Confirmar Nueva Contraseña</label>
            <div class="input-group has-personalizado">
              <span class="input-group-addon" ><span class="si si-lock"></span></span>
              <input class="form-control"  type="password"  id="confirmpwd" name="confirmpwd"  required>
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
            <button onclick="insertData(<?php echo $user_id ?>)" class="btn btn-success btn-block">Actualizar Contraseña</button>
        </div>
      </div>
    </form>




    </div>
    </div>
  </div>
  <script src="assets/js/pages/base_pages_forms_change_password.js"></script>
  <script src="assets/js/pages/password_form_validate.js"></script>
  <script src="assets/js/pages/base_pages_sha512.js"></script>

  <script type="text/javascript">


  </script>

</body>
</html>
<?php
else :
    echo include(unauthorizedModal());
endif;
else:
//echo "<script type='text/javascript'> window.location='index.php'; </script>";
endif;
?>
