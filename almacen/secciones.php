<?php
if (isset($u) && $u->hasPrivilege('leerAlmacen')):
  switch($page)
  {
    case '_1':
      include('almacen/productos_listado.php');
    break;
    case '_2':
      include('almacen/renglones_listado.php');
    break;
     case '_3':
      include('almacen/renglones_listado2.php');
    break;
     case '_4':
      include('almacen/kardex2.php');
    break;
    case '_5':
      include('almacen/facturas_listado.php');
    break;
    case '_6':
      include('almacen/ingresos_listado.php');
    break;
    case '_7':
      include('almacen/requisiciones_listado.php');
    break;
    case '_8':
      include('almacen/egresos_listado.php');
    break;
    case '_9':
      include('almacen/inventario_listado.php');
    break;
    case '_10':
      include('almacen/inventario_producto.php');
    break;

  }
endif;
?>
