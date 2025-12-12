<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerAlmacen')):
        include_once 'funciones_almacen.php';
        $id = null;
        $descuento = FALSE;
        $factura = array();
        $factura_subtotal = 0.00;
        $factura_descuento = 0.00;
        $factura_total = 0.00;
        $productos = productos();
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $factura = factura_info($id);
        }
        if ( null==$id ) {
            echo "<script type='text/javascript'> window.location='index.php?ref=_5'; </script>";
        }
        $factura_ingresos = factura_ingresos($id);
        foreach ($factura_ingresos as $ingreso){
            $factura_subtotal= $factura_subtotal + $ingreso['costo_subtotal'];
            $factura_descuento= $factura_descuento +  $ingreso['descuento'];
            $factura_total= $factura_total + $ingreso['ing_costo'];
        }
        if ($factura_descuento > 0){
            $descuento = TRUE;
        }
        ?>
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/responsive/2.1.1/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/dropzonejs/dropzone.min.css">
        <!-- INICIO Encabezado de Pagina -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        Ingreso de Productos
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>Sistema de Almacén</li>
                        <li><a class="link-effect" href="?ref=_5">Facturas</a></li>
                        <li><a class="link-effect" href="#">Ingreso de Productos</a></li>
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
                            <h3 class="block-title">Factura</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="h4 push-5"><?php echo $factura['prov_nm'];?></div>
                            <article>
                                <?php echo "<span style='font-weight:bold;''>NIT: </span>".$factura['prov_nit'];?><br>
                                <?php echo "<span style='font-weight:bold;''>Factura: </span>".$factura['fac_serie']." ".$factura['fac_num'];?><br>
                                <?php echo "<span style='font-weight:bold;''>Fecha: </span>".fecha_dmy($factura['fac_fecha']);?><br>
                                <?php echo "<span style='font-weight:bold;''>Número de Control: </span>".$factura['fac_control'];?><br>
                                <?php echo "<span style='font-weight:bold;''>1-H: </span>".$factura['fac_1h'];?><br>
                                <?php echo "<span style='font-weight:bold;''>Tipo Documento: </span>".$factura['orden_id'];?><br>
                                <?php echo "<span style='font-weight:bold;''>Observaciones: </span>".$factura['fac_obs'];?><br>
                                <?php echo "<span style='font-weight:bold;''>Comentarios: </span>".$factura['fac_desc'];?>
                            </article>
                            <?php
                            if($factura['fac_status'] == 2 && $u->hasPrivilege('modificarAlmacen')){
                              echo '<br><a class="btn btn-rounded btn-primary btn-block" '.(($factura['fac_status'] != 2 )?'href="#" disabled':'data-toggle="modal" data-target="#modal-remoto" href="almacen/factura_congelar.php?id='.$factura['fac_id'].'" ').'><i class="fa fa-check"></i> Congelar 1-H</a>';
                            }else if($factura['fac_status'] == 1 && $u->hasPrivilege('modificarAlmacen')){
                              echo '<br><a class="btn btn-rounded btn-warning btn-block" '.(($factura['fac_status'] != 1 )?'href="#" disabled':'data-toggle="modal" data-target="#modal-remoto" href="almacen/factura_modificar.php?id='.$factura['fac_id'].'" ').'><i class="fa fa-check"></i> Modificar 1-H</a>';
                              echo '<br><a class="btn btn-rounded btn-primary btn-block" href="almacen/factura_1h.php?id='.$factura['fac_id'].'" target="_blank"><i class="fa fa-print"></i> Imprimir 1-H</a>';

                            }
                            ?>
                        </div>
                    </div>
                    <!-- END Información Factura -->
                </div>
                <div class="col-lg-9">
                <?php if ($factura['fac_status'] == 2 && $u->hasPrivilege('crearAlmacen')): ?>
                <!-- Ingreso Producto -->
                  <div class="block block-themed block-rounded">
                      <div class="block-header bg-success">
                          <h3 class="block-title">Nuevo Ingreso</h3>
                      </div>
                      <div class="block-content block-content-full">
                        <form class="js-validation-ingreso form-horizontal push-10-t push-10" action="almacen/ingreso_nuevo.php?id=<?php echo $id;?>" method="post">
                          <div class="form-group">
                              <div class="col-xs-12">
                                  <div class="form-material">
                                      <select class ="js-select2 form-control" name="prod_id" id="prod_id" style="width: 100%;" data-placeholder="-- Seleccionar Producto --" required>
                                          <option></option>
                                          <?php
                                            foreach ($productos as $producto):
                                                if ($producto['prod_status']){
                                                    echo '<option value="'.$producto["prod_id"].'"> Renglón: '.$producto["renglon_id"].', Código: '.$producto["prod_cod"].', Nombre: '.$producto["prod_nm"].', Presentación: '.$producto["nombre_presentacion"].' '.$producto["med_nm"].', Existencia: '.number_format($producto["existencia"],2).'</option>';
                                                }
                                            endforeach
                                          ?>
                                      </select>
                                      <label for="prod_id">Producto*</label>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-xs-12">
                                  <div class="form-material">
                                      <input class="form-control"  type="text"  id="ing_desc" name="ing_desc"  required>
                                      <label for="ing_desc">Descripción en Factura*</label>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-xs-4">
                                  <div class="form-material">
                                      <input class="form-control"  type="number"  id="ing_cant" name="ing_cant"  min="0" required>
                                      <label for="ing_cant">Cantidad*</label>
                                  </div>
                              </div>
                              <div class="col-xs-4">
                                  <div class="form-material input-group">
                                      <span class="input-group-addon"><strong>Q</strong></span>
                                      <input class="form-control"  type="number"  id="ing_costo" name="ing_costo" min="0" required onchange="document.getElementById('ing_descuento').max=this.value;">
                                      <label for="ing_costo">Valor Sub Total*</label>
                                  </div>
                                  <div class="help-block text-right">Costo total del producto.</div>
                              </div>
                              <div class="col-xs-4">
                                  <div class="form-material input-group">
                                      <span class="input-group-addon"><strong>Q</strong></span>
                                      <input class="form-control"  type="number"  id="ing_descuento" name="ing_descuento">
                                      <label for="ing_descuento">Descuento</label>
                                  </div>
                                  <div class="help-block text-right">Descuento del producto.</div>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-xs-4">
                                  <div class="form-material">
                                      <input class="form-control"  type="text"  id="folio_alm" name="folio_alm">
                                      <label for="folio_alm">Folio Libro Almacen</label>
                                  </div>
                              </div>
                              <div class="col-xs-4">
                                  <div class="form-material">
                                      <input class="form-control"  type="text"  id="folio_inv" name="folio_inv">
                                      <label for="folio_inv">Folio Libro Inventario</label>
                                  </div>
                              </div>
                              <div class="col-xs-4">
                                  <div class="form-material">
                                      <input class="form-control"  type="text"  id="nom_id" name="nom_id">
                                      <label for="nom_id">Nomenclatura de Cuentas</label>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-xs-12 text-center">
                                  <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Agregar Producto</button>
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
                      <li>
                          <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                      </li>
                  </ul>
                  <h3 class="block-title">Listado de Ingresos</h3>
              </div>
              <div class="block-content">
                  <div class="table-responsive">
                  <table class="table table-bordered table-striped js-dataTable-ingresos-1h dt-responsive display nowrap" cellspacing="0" width="100%">
                      <thead>
                          <tr>
                            <th class="text-left">Kardex</th>
                              <th class="text-left">Producto</th>
                              <th class="text-center">Descripción</th>
                              <th class="text-center">Folio <br> Almacén</th>
                              <th class="text-center">Folio <br> Inv.</th>
                              <th class="text-center">Nom. de <br> Cuentas</th>
                              <th class="text-center">Cant.</th>
                              <th class="text-center">Medida</th>
                              <?php
                              if($descuento){
                                  echo '<th class="text-center">Sub Total</th>';
                                  echo '<th class="text-center">Descuento</th>';
                              }
                              ?>
                              <th class="text-center">TOTAL</th>
                              <th class="text-center">Costo Unidad</th>
                              <?php
                                if($factura['fac_status'] == 2 && $u->hasPrivilege('modificarAlmacen')){
                                  echo '<th class="text-center">Acción</th>';
                                }
                              ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                            foreach (factura_ingresos($id) as $ingreso){
                                echo '<tr>';
                                echo '<td class="text-center">';
                                echo '<div class="btn-group">';
                                echo '<span data-toggle="tooltip" title="Revisar"><a class="btn btn-xs btn-personalizado outline"   href="inicio.php?ref=_10&id='.$ingreso['prod_id'].'"><i class=""></i>Kardex</a></span>';
                                echo ' ';
                                echo '</div>';
                                echo '</td>';
                                echo '<td class="text-left" style="white-space: nowrap;"><strong>'.$ingreso['renglon_id'].' - '.$ingreso['prod_cod'].' - '.$ingreso['prod_nm'].'</strong>';

                                echo '</td>';
                                echo '<td class="text-center">'.$ingreso['ing_desc'].'</td>';
                                echo '<td class="text-center" style="white-space: nowrap;">'.$ingreso['folio_alm'].'</td>';
                                echo '<td class="text-center" style="white-space: nowrap;">'.$ingreso['folio_inv'].'</td>';
                                echo '<td class="text-center" style="white-space: nowrap;">'.$ingreso['nom_id'].'</td>';
                                echo '<td class="text-center"><a data-toggle="modal" data-target="#modal-remoto-lg" href="almacen/ingreso_egresos.php?id='.$ingreso['ing_id'].'" >'.number_format($ingreso['ing_cant'],2).'</a></td>';
                                echo '<td class="text-center">'.$ingreso['med_nm'].' '.$ingreso['nombre_presentacion'].'</td>';
                                if($descuento) {
                                    echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($ingreso['costo_subtotal'], 2).'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($ingreso['descuento'], 2).'</td>';
                                }
                                echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($ingreso['ing_costo'],2).'</td>';
                                echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($ingreso['costo_unitario'],5).'</td>';
                                if($factura['fac_status'] == 2 && $u->hasPrivilege('modificarAlmacen')) {
                                    echo '<td class="text-center" style="white-space: nowrap;">';
                                    echo '<span data-toggle="tooltip" title="Editar"><a  class="btn btn-default" '.(($ingreso['prod_status'] == 0 || $ingreso['fac_status'] != 2) ? 'href="#" disabled' : 'data-toggle="modal" data-target="#modal-remoto-lg" href="almacen/ingreso_modificar.php?id='.$ingreso['ing_id'].'&fac='.$id.'" ') . '><i class="fa fa-edit text-warning"></i></a></span>';
                                    echo ' ';
                                    echo '<span data-toggle="tooltip" title="Borrar"><a class="btn btn-default" '.(($ingreso['prod_status'] == 0 || $ingreso['disponible'] < $ingreso['ing_cant'] || $ingreso['fac_status'] != 2) ? 'href="#" disabled' : 'data-toggle="modal" data-target="#modal-remoto-lg" href="almacen/ingreso_borrar.php?id='. $ingreso['ing_id'].'&fac='.$id.'"') . '><i class="fa fa-trash  text-danger"></a></span>';
                                    echo '</td>';
                                }

                                echo '</tr>';
                            }
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-center"></td>
                            <?php
                            if($descuento){
                                echo '<td class="text-center" style="white-space: nowrap;"><strong>Q '.number_format($factura_subtotal,2).'</strong></td>';
                                echo '<td class="text-center" style="white-space: nowrap;"><strong>Q '.number_format($factura_descuento,2).'</strong></td>';
                            }
                            ?>
                            <td class="text-center" style="white-space: nowrap;"><strong>Q <?php echo number_format($factura_total,2); ?></strong></td>
                            <td class="text-center"></td>
                            <?php if($factura['fac_status'] == 2){ echo '<td class="text-center"></td>'; } ?>
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
