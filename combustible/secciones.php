<?php
if (isset($u) && $u->hasPrivilege('leerCupon')):
  switch($page)
  {
    case '_40':
      include('combustible/solicitudes_cupones.php');
    break;
    case '_41':
      include('administrador/permisos_por_permiso.php');
    break;
    case '_42':
    include('combustible/control_km.php');
    break;

    case '_46':
      include('combustible/control_de_combustible.php');
    break;

  }
endif;
