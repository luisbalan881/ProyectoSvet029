<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerAlmacen')):
        include_once 'funciones_almacen.php';
        $id = null;
        $requisicion = array();
        $egresos_agrupados = array();
        $egresos_unitarios = array();
        if ( !empty($_GET['id'])) {
          $id = $_REQUEST['id'];
          $requisicion = requisicion_info($id);
          $egresos_agrupados = requisicion_egresos_agrupados($id);
          $egresos_unitarios = requisicion_egresos_unitarios($id);
        }
        if ( null==$id ) {
          echo "<script type='text/javascript'> window.location='index.php?ref=_7'; </script>";
        }
        ?>
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">

        <!-- INICIO Encabezado de Pagina -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        Egreso de Productos
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>Sistema de Almacén</li>
                        <li><a class="link-effect" href="?ref=_15">Requisición</a></li>
                        <li><a class="link-effect" href="#">Egreso de Productos</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- FIN Encabezado de Pagina -->
        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
          <!-- Factura -->
          <div class="row">
              <div class="col-lg-3">
                  <!-- Información Factura -->
                  <div class="block block-themed block-rounded">
                      <div class="block-header bg-primary">
                          <h3 class="block-title">Requisición</h3>
                      </div>
                      <div class="block-content block-content-full">
                          <?php
                            echo '<div class="h4 push-5">';
                            echo $requisicion['user_pref'].' '.$requisicion['user_nm1'].' '.$requisicion['user_ap1'] ;
                            echo '</div>';
                            echo '<article>';
                            echo '<strong>Requisición No. </strong>'.$requisicion['req_num'].'<br>';
                            echo '<strong>Fecha: </strong>'.fecha_dmy($requisicion['req_fecha']).'<br>';
                            echo '<strong>Observaciones: </strong>'.$requisicion['req_obs'].'<br>';
                            echo '</article>';
                            if($requisicion['req_status'] == 2 && $u->hasPrivilege('crearAlmacen')){
                                echo '<br><a class="btn btn-rounded btn-primary btn-block" data-toggle="modal" data-target="#modal-remoto" href="almacen/requisicion_congelar.php?id='.$requisicion['req_id'].'"><i class="fa fa-check"></i> Congelar Requisición</a>';
                            }else if($requisicion['req_status'] == 1 && $u->hasPrivilege('modificarAlmacen')){
                                echo '<br><a class="btn btn-rounded btn-warning btn-block" data-toggle="modal" data-target="#modal-remoto" href="almacen/requisicion_modificar.php?id='.$requisicion['req_id'].'"><i class="fa fa-check"></i> Modificar Requisición</a>';
                                echo '<br><a class="btn btn-rounded btn-primary btn-block"  href="almacen/requisicion_impresion.php?id='.$requisicion['req_id'].'" target="_blank"><i class="fa fa-print"></i> Imprimir Requisición</a>';
                            }
                          ?>
                      </div>
                  </div>
                  <!-- END Información Factura -->
              </div>
              <div class="col-lg-9">
                  <?php if ($requisicion['req_status'] == 2 && $requisicion['prod_total'] < 22 && $u->hasPrivilege('crearAlmacen')): ?>
                  <!-- Ingreso Producto -->
                  <div class="block block-themed block-rounded">
                      <div class="block-header bg-success">
                          <h3 class="block-title">Nuevo Egreso</h3>
                      </div>
                      <div class="block-content block-content-full">
                        <form class="js-validation-egreso_nuevo form-horizontal push-10-t push-10" action="almacen/egreso_nuevo.php?id=<?php echo $id;?>" method="post">
                            <input type="text"  id="req_fecha" name="req_fecha" value="<?php echo $requisicion['req_fecha'] ?>" hidden title="req_fecha">
                            <div class="form-group">
                              <div class="col-xs-12">
                                  <div class="form-material">
                                      <select class ="js-select2 form-control" name="prod_id" id="prod_id"  style="width: 100%;" data-placeholder="-- Seleccionar Producto --" required>
                                          <option></option>
                                          <?php
                                            foreach (productos_fecha($requisicion['req_fecha']) as $producto):
                                                if ($producto['prod_status']){
                                                    echo '<option value="'.$producto['prod_id'].'" '.( ($producto['existencia'] == 0)? 'disabled':'').'>Renglon: '.$producto['renglon_id'].', Código: '.$producto['prod_cod'].', Nombre: '.$producto['prod_nm'].', Presentación: '.$producto['nombre_presentacion'].' '.$producto['med_nm'].', Disponible: '.number_format($producto['existencia'],2).'</option>';
                                                }
                                            endforeach
                                          ?>
                                      </select>
                                      <label for="prod_id">Producto</label>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-xs-6">
                                  <div class="form-material">
                                      <input class="form-control"  type="number" id="egr_cant" name="egr_cant">
                                      <label for="egr_cant">Cantidad</label>
                                  </div>
                              </div>
                              <div class="col-xs-6">
                                  <div class="form-material">
                                      <input class="form-control js-datepicker" type="text" id="egr_fecha" name="egr_fecha" data-date-language="es-ES"  data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo fecha_dmy($requisicion['req_fecha']) ?>"  data-date-end-date="<?php echo fecha_dmy($requisicion['req_fecha']) ?>" readonly>
                                      <label for="egr_fecha">Fecha</label>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-xs-12 text-center">
                                  <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Entregar Producto</button>
                              </div>
                          </div>
                        </form>
                      </div>
                  </div>
                  <!-- END Ingreso Producto -->
                  <?php endif; ?>
              </div>
          </div>
          <!-- END Factura -->
          <!-- Todos los Ingresos -->
          <div class="block">
              <div class="block-header bg-gray-lighter">
                  <ul class="block-options">
                  </ul>
                  <h3 class="block-title">Productos Entregados</h3>
              </div>
              <div class="block-content">
                  <div class="table-responsive">
                      <table class="js-table-sections table table-hover" cellpadding="0" width="100%">
                          <thead>
                          <tr>
                              <th class="text-center"></th>
                              <th class="text-center">Fecha</th>
                              <th class="text-center">Producto</th>
                              <th class="hidden-xs text-center">Cantidad</th>
                              <th class="hidden-xs text-center">Medida</th>
                              <th class="hidden-xs text-center">Costo Unitario</th>
                              <th class="text-center">TOTAL</th>
                              <?php if($requisicion['req_status'] == 2 && $u->hasPrivilege('modificarAlmacen')){ echo '<th class="text-center">Acción</th>'; } ?>
                          </tr>
                          </thead>
                          <?php
                          $requisicion_total = 0.00;
                          foreach ($egresos_agrupados as $egreso){
                              $requisicion_total = $requisicion_total + $egreso['costo_total'];
                              echo '<tbody class="js-table-sections-header">';
                              echo '<tr>';
                              echo '<td class="text-center"><i class="fa fa-angle-right"></i></td>';
                              echo '<td class="text-center" style="white-space: nowrap;">'.fecha_dmy($egreso['egr_fecha']).'</td>';
                              echo '<td class="text-center" style="white-space: nowrap;"><strong>'.$egreso['renglon_id'].' - '.$egreso['prod_cod'].' - '.$egreso['prod_nm'].'</strong></td>';
                              echo '<td class="hidden-xs text-center">'.number_format($egreso['egr_cant'],2).'</td>';
                              echo '<td class="hidden-xs text-center" style="white-space: nowrap;">'.$egreso['med_nm'].' '.$egreso['nombre_presentacion'].'</td>';
                              echo '<td class="hidden-xs text-center" style="white-space: nowrap;">Q '.number_format($egreso['costo_unitario'],2).'</td>';
                              echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($egreso['costo_total'],2).'</td>';
                              if($requisicion['req_status'] == 2 && $u->hasPrivilege('modificarAlmacen')){ echo '<td class="text-center"></td>'; }
                              echo '</tr>';
                              echo '</tbody>';
                              echo '<tbody>';
                              foreach ($egresos_unitarios as $egreso_unitario){
                                  if ($egreso['prod_id'] == $egreso_unitario['prod_id']){
                                      echo '<tr>';
                                      echo '<td class="text-center"></td>';
                                      echo '<td class="text-center">'.fecha_dmy($egreso_unitario['egr_fecha']).'</td>';
                                      echo '<td class="text-center"><strong>'.$egreso_unitario['renglon_id'].' - '.$egreso_unitario['prod_cod'].' - '.$egreso_unitario['prod_nm'].'</strong></td>';
                                      echo '<td class="hidden-xs text-center"><a data-toggle="modal" data-target="#modal-remoto-lg" href="almacen/ingreso_egresos.php?id='.$egreso_unitario['ing_id'].'" >'.number_format($egreso_unitario['egr_cant'],2).'</a></td>';
                                      echo '<td class="hidden-xs text-center" style="white-space: nowrap;">'.$egreso_unitario['med_nm'].' '.$egreso_unitario['nombre_presentacion'].'</td>';
                                      echo '<td class="hidden-xs text-center" style="white-space: nowrap;">Q '.number_format($egreso_unitario['costo_unitario'],2).'</td>';
                                      echo '<td class="text-center">Q '.number_format($egreso_unitario['costo_total'],2).'</td>';
                                      if($requisicion['req_status'] == 2 && $u->hasPrivilege('modificarAlmacen')){
                                          echo '<td class="text-center" style="white-space: nowrap;">';
                                          echo '<span data-toggle="tooltip" title="Editar"><a  class="btn btn-default" data-toggle="modal" data-target="#modal-remoto-lg" href="almacen/egreso_modificar.php?id='.$egreso_unitario['egr_id'].'&req='.$id.'" '.(($egreso_unitario['prod_status'] == 0)?'disabled':"").'><i class="fa fa-edit text-warning"></i></a></span>';
                                          echo ' ';
                                          echo '<span data-toggle="tooltip" title="Borrar"><a class="btn btn-default" data-toggle="modal" data-target="#modal-remoto-lg" href="almacen/egreso_borrar.php?id='.$egreso_unitario['egr_id'].'&req='.$id.'" '.(($egreso_unitario['prod_status'] == 0)?'disabled':"").'><i class="fa fa-trash  text-danger"></a></span>';
                                          echo '</td>';
                                      }
                                      echo '</tr>';
                                  }
                              }
                              echo '</tbody>';
                          }
                          ?>
                          <tfoot>
                          <tr>
                              <td colspan="2"></td>
                              <td colspan="3" class="hidden-xs text-center"></td>
                              <td class="text-center"><h4>Total</h4></td>
                              <td class="text-center"><h5>Q <?php echo number_format($requisicion_total,2); ?></h5></td>
                              <?php if($requisicion['req_status'] == 2 && $u->hasPrivilege('modificarAlmacen')){ echo '<td></td>'; } ?>
                          </tr>
                          </tfoot>
                      </table>
                  </div>
              </div>
          </div>
          <!-- Final Todos los Ingresos -->
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
