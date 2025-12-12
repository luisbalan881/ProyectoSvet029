<?php
if (isset($u) && $u->hasPrivilege('leerUsuario')):
  switch($page)
  {
    case '_35':
      include('usuarios/usuarios_listado.php');
      break;
      case '_39':
        include('usuarios/horarios.php');
        break;
        
    case '_36':
      include('usuarios/departamentos_listado.php');
      break;

  }
endif;
?>
