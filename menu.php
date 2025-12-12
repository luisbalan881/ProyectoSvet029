<?php require 'inc/config.php'; ?>
<?php
// Specific Page Options
$one->body_bg = $one->assets_folder . '/img/photos/imagen_svet.jpg';
?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>

<!-- Coming Soon Content -->
<div class="content pulldown bg-black-op overflow-hidden animated fadeIn">
    <div class="row text-center push">
        <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
            <!-- Login Title -->
            <div class="text-center">
                <img src="assets/img/escudo_logo.png" height="130" class="animated fadeInDown .retraso1" />
            </div>
            <!-- END Login Title -->
            <!-- Title -->
            <h1 class="text-white push-5"><?php echo $one->name; ?></h1>
            <!-- END Title -->
        </div>
    </div>
    <div class="row text-center push">
        <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
            <a href="inicio.php"><button class="btn btn-block btn-rounded btn-primary push-10" type="button"><i class="fa fa-arrow-circle-o-right pull-left"></i> Herramientas Administrativas</button></a>
			<a href="manuales/"><button class="btn btn-block btn-rounded btn-primary push-10" type="button"><i class="fa fa-arrow-circle-o-right pull-left"></i> Manuales del Sistema</button></a>
            <a href="directorio/"><button class="btn btn-block btn-rounded btn-primary push-10" type="button"><i class="fa fa-arrow-circle-o-right pull-left"></i> Directorio de Personal</button></a>
            <a href="https://www.svet.gob.gt" target="_blank"><button class="btn btn-block btn-rounded btn-primary push-10" type="button"><i class="fa fa-arrow-circle-o-right pull-left"></i> Página WEB</button></a>
            <a href="https://www.flickr.com/photos/135894900@N05/" target="_blank"><button class="btn btn-block btn-rounded btn-primary push-10" type="button"><i class="fa fa-arrow-circle-o-right pull-left"></i> Galería</button></a>

        </div>
    </div>
</div>
<!-- END Coming Soon Content -->

<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-countdown/jquery.countdown.min.js"></script>

<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_pages_coming_soon.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>
