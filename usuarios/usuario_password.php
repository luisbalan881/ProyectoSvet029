<?php
include_once '../inc/functions.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')):
        $id = null;
        $persona = array();
        $user_roll = null;
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
        }

        if ( null==$id ) {
            header("Location: index.php?ref=_35");
        }
        $error_msg = '';
        if ( !empty($_POST)) {
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
                    // Modificar la contraseña del usuario.
                    User::actualizarPassword($password, $random_salt,$id);

                }
                header("Location: index.php?ref=_35");
            }
            header("Location: index.php?ref=_35");
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Modificar Contraseña</title>
        </head>
        <body>
        <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-danger">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Modificar Contraseña</h3>
            </div>

            <div class="block-content">
                <form class="js-validation-usuario form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']);?>" method="POST">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control"  type="password"  id="password" name="password" required>
                                <label for="password">Contraseña*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control"  type="password"  id="confirmpwd" name="confirmpwd" required>
                                <label for="confirmpwd">Confirmar Contraseña*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <button class="btn btn-sm btn-danger btn-block" type="submit"><i class=""></i>Modificar Contraseña</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <!-- Page JS Code -->
        <script src="assets/js/pages/usuarios_forms_validation.js"></script>
        <script src="assets/js/pages/base_pages_forms.js"></script>
        <script src="assets/js/pages/base_pages_sha512.js"></script>
        </body>
        </html>

    <?php else :
        echo include(unauthorizedModal());
    endif; ?>
<?php else:
    echo "<script type='text/javascript'> window.location='index.php'; </script>";
endif; ?>
