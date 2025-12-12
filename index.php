<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php
include_once 'inc/functions.php';
sec_session_start();
if (function_exists('login_check') && login_check()) {
        header("Location: inicio.php");
}else{
    if ( !empty($_GET['error'])) {
        $id = $_REQUEST['error'];
        $message = NULL;
        switch ($id){
            case 1:
                $message = "Usuario o contraseña ingresada no son correctos.";
            break;
            default:
                $message = NULL;
            break;
        }
    }
?>
<!-- Login Content -->
<div class="bg-white pulldown">
    <div class="content content-boxed overflow-hidden">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <div class="push-30-t push-50 animated fadeIn">
                    <!-- Login Title -->
                    <div class="text-center">
                        <img src="assets/img/escudo_logo.png" height="100" class="animated fadeInDown .retraso1" />
                        <p class="text-muted push-15-t">Sistema Control Administrativo SVET</p>
                    </div>
                    <!-- END Login Title -->
                    <?php
                    if(isset($message)){
                        echo '<div class="form-group">';
                        echo '<div class="alert alert-danger alert-dimissable">';
                        echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>';
                        echo '<h3 class="font-w300 push-15">Error</h3>';
                        echo '<p>';
                        echo $message;
                        echo '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                    <!-- Login Form -->
                    <form class="js-validation-login form-horizontal push-30-t form-signin" action="process_login.php" method="post" name="login_form">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material input-group floating">
                                    <input class="form-control" type="text" id="email" name="email" autofocus>
                                    <label for="email">Usuario</label>
                                    <span class="input-group-addon">@svet.gob.gt</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-primary floating">
                                    <input class="form-control" type="password" id="password" name="password">
                                    <label for="password">Contraseña</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group push-30-t">
                            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                                <button class="btn btn-sm btn-block btn-primary" type="submit" onclick="formhash(this.form, this.form.password);">Ingresar</button>
                            </div>
                        </div>
						 <div class="text-center">
						 <p class="text-muted push-15-t">Reconocimineto de gastos "VIATICOS REGLON 029" </p>
							</div>
						</form>
                    <!-- END Login Form -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Login Content -->


<!-- Login Footer -->
<div class="pulldown push-30-t text-center animated fadeInUp">
    <small class="text-muted"><script>document.write(new Date().getFullYear())</script> &copy; <?php echo $one->name . ' ' . $one->version; ?></small>
</div>
<!-- END Login Footer -->

<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_pages_forms.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_pages_sha512.js"></script>

<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_pages_login.js"></script>


<?php require 'inc/views/template_footer_end.php'; ?>

<?php } ?>
