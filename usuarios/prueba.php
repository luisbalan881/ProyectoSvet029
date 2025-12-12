<?php
include_once '../inc/functions.php';
sec_session_start();
if (function_exists('login_check') && login_check() == true) :
    if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')) :

        $mess = null;
        $anio = null;
        $personas = array();
        $user_rol = null;
        $roles = array();
        $departamentos = array();
        if ( !empty($_GET['id'])) {
          $id = $_REQUEST['id'];
        }

        if ( !empty($_GET['mess'])) {
          $mess = $_REQUEST['mess'];
        }

        if ( !empty($_GET['anio'])) {
          $anio = $_REQUEST['anio'];
        }

        if ( !empty($_POST)) {
            //User::usuarioModificar($id);
            header("Location: index.php?ref=_39");
        }else{
            $roles = roles();
            $persona = User::getHorarios_Generales_Control($mess, $anio);
            //$datos_u = User::get_user_horario($id);
        }




require_once('../assets/js/plugins/MPDF57/mpdf.php');


$output = '  <table id="example" class="" cellspacing="0" width="100%">
      <thead>
          <tr>
            <th class="text-center">Nombre</th>
             <th class="text-center" >Dia</th>
              <th class="text-center" >Fecha</th>
              <th class="text-center" >Control</th>
              <th class="text-center">Entrada</th>
              <th class="text-center">Salida</th>
              <th class="text-center">Horas laboradas</th>


          </tr>
      </thead>

      <tbody>';





              foreach ($persona as $p){
              $output .= '<tr>
                  <td class="text-center">'.$p['NOMBRE'].'</td>
                  <td class="text-center">'.User::get_nombre_dia($p['FECHA']).'</td>
                  <td class="text-center">'.$p['FECHA'].'</td>
                  <td class="text-center">


                  </td>
                  <td class="text-center">'.$p['F_INI'].'</td>
                  <td class="text-center">'.$p['F_FIN'].'</td>
                  <td class="text-center">'.$p['HORAS'].'</td>


                  </tr>';
              }

      $output .='
      <tr>
      <td>hola</td>
      <td>hola</td>
      <td>hola</td>
      <td>hola</td>
      <td>hola</td>
      <td>hola</td>
      <td>hola</td>
      </tr>
      </tbody>
      </table>';


$mpdf = new mPDF('c', 'Letter');
$mpdf ->writeHTML($output);
$mpdf->Output('reporte.pdf', 'I');



else :
    echo include(unauthorizedModal());
endif;
else:
echo "<script type='text/javascript'> window.location='../index.ph'; </script>";
endif;

 ?>
