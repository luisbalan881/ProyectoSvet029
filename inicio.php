<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    include_once 'inc/functions.php';
    sec_session_start();
    if (login_check() == true) :
        require 'inc/config.php';
        require 'inc/views/template_head_start.php';
        require 'inc/views/template_head_end.php';
        require 'inc/views/base_head.php';
        $u = usuarioPrivilegiado();
          //page content
          if (! isset($_GET['ref']))
          {
            echo '<div class="content content-boxed text-center">';
            echo '<img src="assets/img/_vice_logo_bw.png" />';
            echo '</div>';

          } else {
            $page = $_GET['ref'];
          //  include('almacen/secciones.php');
           // include('archivo/secciones.php');
        //    include('usuarios/secciones.php');
          //  include('cheques/secciones.php');
          //  include('combustible/secciones.php');
           // include('proveedores/secciones.php');
           // include('transporte/secciones.php');

            switch($page)
            {
                case '_0':
                    include('perfil.php');
                break;
				 case '_200':
                    include('herramientas/traslado_bienes.php');
                break;
				case '_201':
                    include('herramientas/traslado_bienes.php');
                break; 
				case '_79':
				include('viaticos/Nombramientos.php');
				break;
				
				case '_89':
                    include('viaticos/MisViaticos.php');
                break;
                case '_90':
                    include('viaticos/ViaticosAdmin.php');
                break;
				case '_91':
                    include('viaticos/ReporteViaticos.php');
                break;
                case '_99':
                    include('administrador/control_dias_usuario.php');
                break;
                case '_99':
                    include('administrador/control_dias_usuario.php');
                break;
                case '_100':
                include('administrador/settings.php');
                break;
                case '_101':
                include('administrador/documentos.php');
                break;
            }
          }
          //END page content
    require 'inc/views/base_footer.php';
    require 'inc/views/template_footer_start.php';
    require 'inc/views/template_footer_end.php';
    else:
        header("Location: index.php");
    endif;
