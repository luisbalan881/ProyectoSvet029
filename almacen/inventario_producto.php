<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerAlmacen')):
        include_once 'funciones_almacen.php';
        $id = null;
        $producto = array();
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $producto = producto_info($id);
        }
        if ( null==$id ) {
          header("Location: ?ref=_9");
        }
        ?>
        <!-- INICIO Encabezado de Pagina -->
        <div class="content bg-gray-lighter">
          <div class="row items-push">
              <div class="col-sm-7">
                  <h1 class="page-heading">
                      DETALLE DE MOVIMIENTO
                  </h1>
              </div>
              <div class="col-sm-5 text-right hidden-xs">
                  <ol class="breadcrumb push-10-t">
                      <li>Sistema de Almacén</li>
                      <li><a class="link-effect" href="?ref=_25">Inventario</a></li>
                      <li><a class="link-effect" href="#"><?php echo $producto['prod_nm'] ;?></a></li>
                  </ol>
              </div>
          </div>
        </div>
        <!-- FIN Encabezado de Pagina -->
        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
        <!-- Detalle del producto -->
        <div class="block">
          <div class="block-header bg-gray-lighter">
            <ul class="block-options">
              <li>
                  <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
              </li>
            </ul>
            <h3 class="block-title">Detalle Movimiento de Producto</h3>
          </div>
          <div class="block-content">
              <div class="row items-push">
                <!-- Informacion Producto -->
                  <div class="col-sm-6">
                    <span style="font-weight:bold;">Nombre: </span><?php echo $producto['prod_nm']; ?><br>
                    <span style="font-weight:bold;">Descripción: </span><?php echo $producto['prod_desc']; ?><br>
                    <span style="font-weight:bold;">Unidad de Medida: </span><?php echo $producto['nombre_presentacion'].' '.$producto['med_nm']; ?><br>
                  </div>
                  <div class="col-sm-6">
                    <span style="font-weight:bold;">Código: </span><?php echo (($producto['prod_cod'] != 0)? $producto['prod_cod']:(($producto['prod_cod'] == 'N/A')? 'N/A':$producto['renglon_codigo'])) ?><br>
                    <span style="font-weight:bold;">Rubro: </span><?php echo $producto['renglon_id']; ?><br>
                    <span style="font-weight:bold;">Kardex: <a target="_blank" href='almacen/inventario_kardex.php?id=<?php echo $producto['prod_id']; ?>'><i class="fa fa-print"> Imprimir</i></a></span><br>
                  </div>
                <!-- END Informacion Producto -->
              </div>
              <div class="table-responsive">
              <table class="table table-bordered table-condensed table-striped" >
                  <thead>
                      <tr>
                          <th class="text-center" style="white-space: nowrap;">Fecha</th>
                          <th class="text-center">Descripción</th>
                          <th class="text-center">No. Fac.</th>
                          <th class="text-center">No. Req.</th>
                          <th class="text-center">Ingresos</th>
                          <th class="text-center">Egresos</th>
                          <th class="text-center" style="white-space: nowrap;">Costo U Q.</th>
                          <th class="text-center" style="white-space: nowrap;">Debe</th>
                          <th class="text-center" style="white-space: nowrap;">Haber</th>
                          <th class="text-center">Saldo</th>
                          <th class="text-center" style="white-space: nowrap;">Valor Q.</th>
                          <th class="text-center" style="white-space: nowrap;">Costo Prom.</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                        $existencia = 0;
                        $ingreso_acumulado = 0;
                        $costo_acumulado = 0.00;
                        $costo_promedio = 0.00;
                        $debe = 0.00;
                        $haber = 0.00;
                        $saldo = 0.00;
                        foreach (producto_inventario($id) as $producto_inventario){
                            if($producto_inventario['prod_id'] == $id){
                                if ($producto_inventario['tipo'] == 'ing') {
                                    $existencia = $existencia + $producto_inventario['ie_ing_cant'];
                                    $ingreso_acumulado = $ingreso_acumulado + $producto_inventario['ie_ing_cant'];
                                    $costo_acumulado = $costo_acumulado + $producto_inventario['ie_ing_costo'];
                                    $costo_promedio = $costo_acumulado/$ingreso_acumulado;
                                    $debe = $producto_inventario['ie_ing_cant']*$producto_inventario['ie_costo_unitario'];
                                    $saldo = $saldo + $debe;
                                    echo '<tr '.(($existencia < 0 || $saldo < 0)?'class="danger"':"").'>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.fecha_dmy($producto_inventario['ie_fecha']).'</td>';
                                    echo '<td class="text-left"> Proveedor: '.$producto_inventario['prov_nm'].' <br>NIT: '.$producto_inventario['prov_nit'].'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;"><a href="?ref=_6&id='.$producto_inventario['ie_fac_id'].'"> Serie: '.$producto_inventario['fac_serie'].' <br>No. '.$producto_inventario['fac_num'].'</a></td>';
                                    echo '<td></td>';
                                    echo '<td class="text-center"><a data-toggle="modal" data-target="#modal-remoto-lg" href="almacen/ingreso_egresos.php?id='.$producto_inventario['ie_ing_id'].'" >'.number_format($producto_inventario['ie_ing_cant'],2).'</a></td>';
                                    echo '<td></td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($producto_inventario['ie_costo_unitario'],2).'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($debe,2).'</td>';
                                    echo '<td></td>';
                                    echo '<td class="text-center">'.$existencia.'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($saldo,2).'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($costo_promedio,2).'</td>';
                                    echo '</tr>';
                                }else if ($producto_inventario['tipo'] == 'egr') {
                                    $existencia = $existencia - $producto_inventario['ie_egr_cant'];
                                    $haber = $producto_inventario['ie_egr_cant']*$producto_inventario['ie_costo_unitario'];
                                    $saldo = $saldo - $haber;
                                    echo '<tr '.(($existencia < 0 || $saldo < 0 || $producto_inventario['ing_fecha'] > $producto_inventario['egr_fecha'])?'class="danger"':"").'>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.fecha_dmy($producto_inventario['ie_fecha']).'</td>';
                                    echo '<td class="text-left">'.$producto_inventario['user_nm1'].' '.$producto_inventario['user_ap1'].'</td>';
                                    echo '<td class="text-center"></td>';
                                    echo '<td class="text-center"><a href="?ref=_8&id='.$producto_inventario['ie_req_id'].'">'.$producto_inventario['req_num'].'</a></td>';
                                    echo '<td></td>';
                                    echo '<td class="text-center"><a data-toggle="modal" data-target="#modal-remoto-lg" href="almacen/ingreso_egresos.php?id='.$producto_inventario['ie_ing_id'].'" >'.number_format($producto_inventario['ie_egr_cant'],2).'</a></td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($producto_inventario['ie_costo_unitario'],2).'</td>';
                                    echo '<td></td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($haber,2).'</td>';
                                    echo '<td class="text-center">'.$existencia.'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($saldo,2).'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($costo_promedio,2).'</td>';
                                    echo '</tr>';
                                }
                            }
                        }
                    ?>
                  </tbody>
              </table>
              </div>
          </div>
        </div>
        </div>
        <?php
    else :
        echo include(unauthorized());
    endif;
else:
    header("Location: index.php");
endif;
?>