<!DOCTYPE html>
<html>
<head>
    <title>Directorio de Personal</title>
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
</head>
<body>
<?php
if (function_exists('login_check') && login_check()):
    $personas = personas();
?>
  <!-- INICIO Encabezado de Pagina -->
 <div class="content bg-gray-lighter">
     <div class="row items-push">
         <div class="col-sm-7">
             <h1 class="page-heading">
                 DIRECTORIO DE PERSONAL
             </h1>
         </div>
         <div class="col-sm-5 text-right hidden-xs">
             <ol class="breadcrumb push-10-t">
                 <li>CONTROL DE PERSONAL</li>
                 <li><a class="link-effect" href="#">Directorio</a></li>
             </ol>
         </div>
     </div>
 </div>
 <!-- FIN Encabezado de Pagina -->
 <!-- INICIO Contenido de pagina -->
 <div class="content content-boxed">
     <!-- Todos los Productos -->
     <div class="block">
         <div class="block-header bg-gray-lighter">
           <ul class="block-options">
               <li>
                   <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
               </li>
           </ul>
           <h3 class="block-title">Listado de Personas</h3>
         </div>
         <div class="block-content">
             <table class="table table-bordered table-condensed table-striped js-dataTable-directorio" >
                 <thead>
                     <tr>
                         <th class="hidden-xs">Pref</th>
                         <th>Nombre</th>
                         <th class="text-center">Ext.</th>
                         <th class="hidden-xs text-center">Email</th>
                         <th class="hidden-xs text-center">Departamento</th>
                         <th class="hidden-xs text-center">Puesto Funcional</th>
                         <th class="hidden-xs text-center">Puesto Nominal</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                         foreach ($personas as $persona){
                            if($persona['ext_id'] > 0 && $persona['user_status'] == 1){
                                echo '<tr>';
                                echo '<td class="hidden-xs">'.$persona['user_pref'].'</td>';
                                echo '<td >'.$persona['user_nm1'].' '.$persona['user_nm2'].' '.$persona['user_ap1'].' '.$persona['user_ap2'].'</td>';
                                echo '<td class="text-center">'.$persona['ext_id'].'</td>';
                                echo '<td class="hidden-xs" ><a href="mailto:'.$persona['user_mail'].'">'.$persona['user_mail'].'</td>';
                                echo '<td class="hidden-xs">'.$persona['dep_nm'].'</td>';
                                echo '<td class="hidden-xs">'.$persona['user_puesto'].'</td>';
                                echo '<td class="hidden-xs">'.$persona['user_nom'].'</td>';
                                echo '</tr>';
                            }
                         }
                     ?>
                 </tbody>
             </table>
         </div>
     </div>
     <!-- Final Todos los Productos -->
 </div>
 <!-- FIN Contenido de Pagina -->
<?php else : ?>
    <p>
         <span class="error">Usted no esta autorizado para acceder a esta pagina.</span> Por favor <a href="index.php">inicie sesión</a>.
    </p>
<?php endif; ?>
</body>
</html>
