<?php
if (isset($u) && $u->hasPrivilege('leerSolicitudTransporte')):
  switch($page)
  {
    case '_50':
      include('transporte/solicitudes_transporte.php');
      break;
      case '_51':
        include('transporte/vehiculos.php');
        break;
     case '_39':
        include('combustible/MisRegistrosKm.php');
        break;
     case '_40':
        include('combustible/control_km_todos.php');
        break;


  }
endif;
?>
