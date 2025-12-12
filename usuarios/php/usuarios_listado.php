<?php
if (function_exists('login_check') && login_check() == true):
    if (isset($u) && $u->hasPrivilege('leerUsuario')):
    ?>
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/responsive/2.1.1/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">

         <!-- INICIO Encabezado de Pagina -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        EMPLEADOS
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>CONTROL DE USUARIOS</li>
                        <li><a class="link-effect" href="#">Usuarios</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- FIN Encabezado de Pagina -->

        <?php
            $total_personas = 0;
            $personas_inactivas = 0;
            $personas_pendientes = 0;
            $personas = personas();
            foreach ($personas as $persona):
                $total_personas++;
                if ($persona['user_status'] == 0){ $personas_inactivas++;}
                if ($persona['user_status'] == 2){ $personas_pendientes++;}
            endforeach;
         ?>

        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
            <!-- Header Tiles -->
            <div class="row">
                    <div class="col-xs-6 col-sm-25 ">
                        <a class="block block-rounded card block-link-hover3 text-center " <?php echo (($u->hasPrivilege("crearUsuario"))?'data-toggle="modal" data-target="#modal-remoto" href="usuarios/usuario_nuevo.php"':'href="#" disabled') ?>>
                            <div class="block-content-full ">
                                <div class="h1 font-w1000"><div  class=" <?php echo (($u->hasPrivilege("crearUsuario"))?'user_add':'user_add_deny') ?>"></div></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini font-w900 h5 <?php echo (($u->hasPrivilege("crearUsuario"))?'text-green':'') ?>">Nuevo Empleado</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-25">
                        <a class="block block-rounded card block-link-hover3 text-center" <?php echo (($u->hasPrivilege("crearUsuario"))?'data-toggle="modal" data-target="#modal-remoto-lgg" href="usuarios/suspenciones_listado.php"':'href="#" disabled') ?>>
                            <div class="block-content-full ">
                                <div class="h1 font-w700 "><div  class=" <?php echo (($u->hasPrivilege("crearUsuario"))?'igss_list':'igss_list_deny') ?>"></div></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini h5 font-w900 <?php echo (($u->hasPrivilege("crearUsuario"))?'text-green':'') ?>">Suspenciones</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-25">
                        <a class="block block-rounded card  text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full ">
                                <div class="h1 font-w700 text-primary" data-toggle="countTo" data-to="<?php echo $total_personas; ?>"></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini  text-primary h5 font-w900">Total</div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-25">
                        <a class="block block-rounded card text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full ">
                                <div class="h1 font-w700 text-danger" data-toggle="countTo" data-to="<?php echo $personas_inactivas ?>"></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini  text-danger h5 font-w900">Inactivos</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-25">
                        <a class="block block-rounded card text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full ">
                                <div class="h1 font-w700 text-warning" data-toggle="countTo" data-to="<?php echo $personas_pendientes; ?>"></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini  text-warning h5 font-w900">Pendientes</div>
                        </a>
                    </div>
                </div>
            <!-- END Header Tiles -->

            <!-- Todos los Productos -->
            <div class="block">
              <div class="block block-themed block-rounded" id="block_hide">
              <div class="block-header bg-muted">
                  <ul class="block-options">
                    <li>
                         <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                      </li>
                  </ul>
                  <span id="block_show" class="text-white"><h3 class="block-title">CONTROL DE HORARIO DE EMPLEADOS</h3></span>
              </div>
                <div class="block-content">
                    <table class="table table-bordered table-condensed table-striped js-dataTable-usuarios dt-responsive display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" >Reloj</i></th>
                                <th class="text-center">Pref</th>
                                <th >Nombre</th>
                                <th class="text-center">Ext.</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Departamento</th>
                                <th class="text-center">Puesto Funcional</th>
                                <th class="text-center">Puesto Nominal</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Roll</th>
                                <?php echo (($u->hasPrivilege("modificarUsuario"))?'<th class="text-center">Acción</th>':'') ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($personas as $persona){
                                    echo '<tr '.(($persona['user_status'] == 0)?'class="warning"':"").'>';
                                    echo '<td class="text-center">';
                                    if($persona['user_vid']==0){
                                      echo ' ';
                                    }else {
                                      echo $persona['user_vid'];
                                    }

                                    echo '</td>';
                                    echo '<td class="text-left">'.$persona['user_pref'].'</td>';
                                    echo '<td class="text-left" style="white-space: nowrap;">'.$persona['user_nm1'].' '.$persona['user_nm2'].'<br>'.$persona['user_ap1'].' '.$persona['user_ap2'].'</td>';
                                    echo '<td class="text-center">'.$persona['ext_id'].'</td>';
                                    echo '<td class="text-left" ><a href="mailto:'.$persona['user_mail'].'">'.$persona['user_mail'].'</td>';
                                    echo '<td class="text-center">'.$persona['dep_nm'].'</td>';
                                    echo '<td class="text-left">'.$persona['user_puesto'].'</td>';
                                    echo '<td class="text-left">'.$persona['user_nom'].'</td>';
                                    echo '<td class="text-center">';
                                    if($persona['user_status'] == '0'){ echo '<span class="label label-danger">Inactivo</span> ';}
                                    else if($persona['user_status'] == '1'){ echo '<span class="label label-success" disabled>Activo</span>';}
                                    else if($persona['user_status'] == '2'){ echo '<span class="label label-warning">Activar</span>';}
                                    echo'</td>';


                                    echo '<td class="text-center">'.$persona['role_nm'].'</td>';
                                    if($u->hasPrivilege('modificarUsuario')) {
                                        echo '<td class="text-center" style="white-space: nowrap;">';
                                        echo '<div class="btn-group">';
                                        echo '<span title="Editar"><a class="btn btn-warning outline"  title="Editar"  data-toggle="modal" data-target="#modal-remoto" href="usuarios/usuario_modificar.php?id='.$persona['user_id'].'"><i class="fa fa-pencil "></i></a></span>';
                                        echo ' ';
                                        echo '<span  title="Contraseña"><a class="btn btn-danger outline"  title="Password"  data-toggle="modal" data-target="#modal-remoto" href="usuarios/usuario_password.php?id='.$persona['user_id'].'"><i class="fa fa-unlock "></i></a></span>';
                                        if($persona['user_vid']>0)
                                        {
                                        echo '<br>';

                                        echo '<span  title="Suspención"><a class="btn btn-primary outline"  title="Suspencion"  data-toggle="modal" data-target="#modal-remoto" href="usuarios/suspenciones.php?id='.$persona['user_id'].'&vid='.$persona['user_vid'].'"><i class="fa fa-calendar-times-o"></i></a></span>';
                                        echo ' ';
                                        echo '<span  title="Listado de Suspenciones"><a class="btn btn-success outline"  title="Listado de Suspenciones" data-toggle="modal" data-target="#modal-remoto-lgg" href="usuarios/suspenciones_listado_user.php?id='.$persona['user_id'].'"  ><i class="fa fa-file-text"></i></a></span>';
                                        }

                                        echo '</div>';
                                        echo '</td>';
                                    }
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Final Todos los Productos -->
        </div>
        <!-- FIN Contenido de Pagina -->
        <?php
    else:
        echo include(unauthorized());
    endif;
else:
    echo "<script type='text/javascript'> window.location='../directorio/index.php'; </script>";
endif;
?>
