<?php


        ?>
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">

        <!-- INICIO Encabezado de Pagina -->

        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
            <!-- Tipo nuevo -->
            <div class="row">

                    <!-- Ingreso Tipo -->
                    <div class="block block-themed block-rounded">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title" style="color:#656262;">+ Permiso Nuevo</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <form class="js-validation-documento form-horizontal push-10-t push-10" action="" method="POST">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material">
                                            <input class="form-control"  type="text" id="inst_nombre" name="tipo_nombre" required>
                                            <label for="inst_nombre">Nombre*</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12 text-center">
                                        <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Agregar Tipo de Archivo</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- END Ingreso Tipo -->

            </div>
            <!-- END nuevo archivo -->
            <!-- Todos los tipos -->

            </div>
            <!-- Final Todos los archivos -->
        <!-- FIN Contenido de Pagina -->
        <?php

?>
