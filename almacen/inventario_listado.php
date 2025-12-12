<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerAlmacen')):
        include_once 'funciones_almacen.php';
        $errores = array();
        $productos = array();
        $productos = productos_inventario();
        $productos_total = 0;
        $productos_inactivos = 0;
        $productos_cero = 0;
        foreach ($productos as $producto):
            $productos_total++;
            if ($producto['prod_status'] == 0){
                $productos_inactivos++;
            }
            if ($producto['existencia'] == 0){
                $productos_cero++;
            }
        endforeach;
        //TODO: Agregar fecha y encabezado a exportar tabla.
        ?>
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/responsive/2.1.1/css/responsive.dataTables.min.css">
        <!-- INICIO Encabezado de Pagina -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        INVENTARIO
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>Sistema de Almacén</li>
                        <li><a class="link-effect" href="#">INVENTARIO</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- FIN Encabezado de Pagina -->
        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
            <!-- Header Tiles -->
            <div class="row">
                    <div class="col-xs-6 col-sm-4">
                        <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full">
                                <div class="h1 font-w700 text-warning" data-toggle="countTo" data-to="<?php echo $productos_inactivos; ?>"></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini bg-gray-lighter text-warning font-w600">Productos Inactivos</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-4">
                        <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full">
                                <div class="h1 font-w700 text-danger" data-toggle="countTo" data-to="<?php echo $productos_cero; ?>"></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini bg-gray-lighter text-danger font-w600">Sin Inventario</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-4">
                        <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full">
                                <div class="h1 font-w700 text-info" data-toggle="countTo" data-to="<?php echo $productos_total; ?>"></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini bg-gray-lighter text-info font-w600">Todos los Productos</div>
                        </a>
                    </div>
                </div>
            <!-- END Header Tiles -->
            <!-- Todos los Productos -->
            <div class="block">
                <div class="block-header bg-gray-lighter">
                  <ul class="block-options">
                      <li>
                          <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                      </li>
                  </ul>
                  <h3 class="block-title">Inventario de Productos</h3>
                </div>
                <div class="block-content">
                    <table class="table table-bordered table-condensed table-striped js-dataTable-inventario display nowrap dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">Código</th>
                                <th class="text-center">Renglón</th>
                                <th>Nombre</th>
                                <th class="text-left">Características</th>
                                <th class="text-center" style="white-space: nowrap;">Presentación No.</th>
                                <th class="text-center">Presentación</th>
                                <th class="text-center" style="white-space: nowrap;">Unidad y Medida</th>
                                <th class="text-center">Valor Promedio</th>
                                <th class="text-center">Existencia</th>
                                <th class="text-center">Valor Existencia</th>
                                <th class="text-center">Estado Existencia</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                              $inventario_costo = 0.00;
                              foreach ($productos as $producto){
                                  $inventario_costo = $inventario_costo + $producto['existencia_costo'];
                                  //echo '<tr '.(($producto['prod_status'] == 0)?'class="warning"':"").'>';
								  echo '<tr '.(($producto['existencia'] == 0)?'class="danger"':"").'>';
                                  echo '<td class="text-center" style="white-space: nowrap;">'.$producto['prod_cod'].'</td>';
                                  echo '<td class="text-center">'.$producto['renglon_id'].'</td>';
                                  echo '<td style="white-space: nowrap;">'.$producto['prod_nm'].'</td>';
                                  echo '<td class="text-left">'.$producto['prod_desc'].'</td>';
                                  echo '<td class="text-center">'.$producto['codigo_presentacion'].'</td>';
                                  echo '<td class="text-center" style="white-space: nowrap;">'.$producto['nombre_presentacion'].'</td>';

                                  echo '<td class="text-center" style="white-space: nowrap;">'.$producto['med_nm'].'</td>';
                                  echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($producto['costo_promedio'],2).'</td>';
                                  echo '<td class="text-center">'.number_format($producto['existencia']).'</td>';
                                  echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($producto['existencia_costo'],2).'</td>';
                                  echo '<td class="text-center" style="white-space: nowrap;"><span data-toggle="tooltip" title="MIN: '.$producto['prod_min'].' / MAX: '.$producto['prod_max'].'">';
                                  if ($producto['prod_status'] == 0){
                                      echo '<span class="label label-warning">Inactivo</span>';
                                  }else{
                                      if ($producto['existencia'] == 0){
                                          echo '<span class="label label-default">Sin existencia</span>';
                                      }else if($producto['existencia'] < $producto['prod_min']){
										   echo '<span class="label label-warning">Bajo el mÃ­nimo</span>';
                                         // echo '<span class="fa fa-times text-danger">Bajo el mínimo</span>';
                                      }else if($producto['existencia'] >= $producto['prod_min'] && $producto['existencia'] <= $producto['prod_max']){
                                          echo '<span class="label label-info">En existencia</span>';
                                      }else if($producto['existencia'] > $producto['prod_max']){
                                          echo '<span class="label label-warning">Sobre máximo</span>';
                                      
									  
									   }else if($producto['prod_status'] == 0){
                                          echo '<span class="label label-warning">Producto Inactivo</span>';
										  
										  
                                      }
                                  }
                                  echo '</span></td>';
                                  echo '<td class="text-center">';
                                  echo '<div class="btn-group">'; 
                                  echo '<span data-toggle="tooltip" title="Revisar"><a class="btn btn-default"   href="inicio.php?ref=_10&id='.$producto['prod_id'].'"><i class="fa fa-eye text-info"></i></a></span>';
                                  echo ' ';
                                  echo '</div>';
                                  echo '</td>';
                                  echo '</tr>';
                              }
                          ?>
                        </tbody>
                        <tfoot>
                          <?php
                          echo '<tr>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td class="text-center"><h4>Total</h4></td>';
                          echo '<td class="text-center" style="white-space: nowrap;"><h4>Q '.number_format($inventario_costo,2).'</h4></td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '</tr>';
                           ?>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- Final Todos los Productos -->
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