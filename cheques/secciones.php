<?php
if (isset($u) && $u->hasPrivilege('leerCheques')):
  switch($page)
  {
    case '_16':
      include('cheques/bancos_listado.php');
    break;
    case '_17':
      include('cheques/cuentas_listado.php');
    break;
    case '_19':
      include('cheques/creditos_listado.php');
    break;
    case '_20':
      include('cheques/debitos_listado.php');
    break;
    case '_21':
      include('cheques/vouchers_listado.php');
    break;
    case '_22':
      include('cheques/cuenta_balance.php');
    break;
  }
endif;
?>
