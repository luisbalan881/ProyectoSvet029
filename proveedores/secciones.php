<?php
if (isset($u) && $u->hasPrivilege('leerProveedor')):
  switch($page)
  {
    case '_18':
      include('proveedores/proveedores_listado.php');
    break;
  }
endif;
?>
