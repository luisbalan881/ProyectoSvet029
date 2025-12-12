<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerAlmacen')):
        include_once 'funciones_almacen.php';
        $requisiciones = requisiciones();
        ?>
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/responsive/2.1.1/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">

        <!-- INICIO Encabezado de Pagina -->
        <div class="content bg-gray-lighter">
          <div class="row items-push">
              <div class="col-sm-7">
                  <h1 class="page-heading">
                      REQUISICIONES
                  </h1>
              </div>
              <div class="col-sm-5 text-right hidden-xs">
                  <ol class="breadcrumb push-10-t">
                      <li>Sistema de Almacén</li>
                      <li><a class="link-effect" href="#">Requisición</a></li>
                  </ol>
              </div>
          </div>
        </div>
        <!-- FIN Encabezado de Pagina -->
        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
          <!-- Header Tiles -->
          <div class="row">
              <div class="col-sm-6 col-lg-3">
                  <a class="block block-link-hover3 text-center" <?php if($u->hasPrivilege('crearAlmacen')){ echo 'data-toggle="modal" data-target="#modal-remoto" href="almacen/requisicion_nueva.php"'; } ?>>
                      <div class="block-content block-content-full">
                          <div class="h1 font-w700 <?php echo (($u->hasPrivilege('crearAlmacen')? 'text-success':'')) ?>"><i class="fa fa-plus"></i></div>
                      </div>
                      <div class="block-content block-content-full block-content-mini bg-gray-lighter font-w600 <?php echo (($u->hasPrivilege('crearAlmacen')? 'text-success':'')) ?>">Nueva Requisición</div>
                  </a>
              </div>
              <div class="col-sm-6 col-lg-3">
                  <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                      <div class="block-content block-content-full">
                          <div class="h1 font-w700 text-success" data-toggle="countTo" data-to="<?php echo requisiciones_validadas(); ?>"></div>
                      </div>
                      <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600 text-success">Requisiciones Validadas</div>
                  </a>
              </div>
              <div class="col-sm-6 col-lg-3">
                  <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                      <div class="block-content block-content-full">
                          <div class="h1 font-w700 text-danger" data-toggle="countTo" data-to="<?php echo requisiciones_anuladas(); ?>"></div>
                      </div>
                      <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600 text-danger">Requisiciones Anuladas</div>
                  </a>
              </div>
              <div class="col-sm-6 col-lg-3">
                  <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                      <div class="block-content block-content-full">
                          <div class="h1 font-w700 text-info" data-toggle="countTo" data-to="<?php echo requisiciones_total(); ?>"></div>
                      </div>
                      <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600 text-info">Todas las Requisiciones</div>
                  </a>
              </div>
          </div>
          <!-- END Header Tiles -->

          <!-- Todas las Requisiciones -->
          <div class="block">
              <div class="block-header bg-gray-lighter">
                  <ul class="block-options">
                  </ul>
                  <h3 class="block-title">Listado de Requisiciones</h3>
              </div>
              <div class="block-content">
                  <table class="table table-bordered table-condensed table-striped js-dataTable-requisiciones dt-responsive display nowrap" cellspacing="0" width="100%">
                      <thead>
                          <tr>
                              <th class="text-center" style="white-space: nowrap;">Fecha</th>
                              <th class="text-center" style="width: 100px;">Requisición</th>
                              <th class="text-center">Usuario</th>
                              <th class="text-center">Departamento</th>
                              <th class="text-center" style="white-space: nowrap;">No. Productos</th>
                              <th class="text-center">Total</th>
                              <th class="text-center">Acción</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach ($requisiciones as $requisicion){
                            echo '<tr '.(($requisicion['req_status'] == 0)?'class="danger"':'').(($requisicion['req_status'] == 2)?'class="warning"':'').'>';
                            echo '<td class="text-center" style="white-space: nowrap;">'.fecha_dmy($requisicion['req_fecha']).'</td>';
                            echo '<td class="text-center">'.$requisicion['req_num'].'</td>';
                            echo '<td class="text-center" style="white-space: nowrap;">'.$requisicion['user_pref'].' '.$requisicion['user_nm1'].' '.$requisicion['user_ap1'].'</td>';
                            echo '<td class="text-center">'.$requisicion['dep_nm'].'</td>';
                            echo '<td class="text-center">'.number_format($requisicion['prod_total']).'</td>';
                            echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($requisicion['req_total'],2).'</td>';
                            echo '<td class="text-center" style="white-space: nowrap;">';
                            echo '<div class="btn-group">';
                            echo '<span data-toggle="tooltip" title="Revisar"><a class="btn btn-default"  href="?ref=_8&id='.$requisicion['req_id'].'"><i class="fa fa-eye text-info"></i></a></span>';
                            echo ' ';
                            if($u->hasPrivilege('modificarAlmacen')) {
                                echo '<span data-toggle="tooltip" title="Editar"><a class="btn btn-default" ' . (($requisicion['req_status'] == 0) ? 'href="#" disabled' : ' data-toggle="modal" data-target="#modal-remoto" href="almacen/requisicion_modificar.php?id='.$requisicion['req_id'].'"') . ' ><i class="fa fa-pencil text-warning"></i></a></span>';
                                echo '<br> ';
                                echo '<span data-toggle="tooltip" title="Anular"><a class="btn btn-default" ' . (($requisicion['req_status'] == 0) ? 'href="#" disabled' : ' data-toggle="modal" data-target="#modal-remoto" href="almacen/requisicion_anular.php?id='.$requisicion['req_id'].'"') . ' ><i class="fa fa-times text-danger"></i></a></span>';
                                echo ' ';
                            }
                            echo '<span data-toggle="tooltip" title="Imprimir"><a class="btn btn-default" '.(($requisicion['req_status'] == 1 )?' href="almacen/requisicion_impresion.php?id='.$requisicion['req_id'].'" target="_blank" ':'href="#" disabled').'><i class="fa fa-print text-info"></i></a></span>';
                            echo '</div>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                      </tbody>
                  </table>
              </div>
          </div>
          <!-- Final Todas las Requisiciones -->
        </div>
        <!-- FIN Contenido de Pagina -->
        <?php
    else :
        echo include(unauthorized());
    endif;
else:
    header("Location: index.php");
endif;
?>
