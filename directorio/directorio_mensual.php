<!DOCTYPE html>
<html>
<head>
    <title>Directorio de Personal Mensual</title>
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
</head>
<body>

  <?php
  $fechi='';
  $fechf='';
  if (isset($_POST['enviar'])) {

  if($_POST['mes']<10){
    $fechi = $_POST['anio'].'-0'.$_POST['mes'].'-01';
    $fechf = $_POST['anio'].'-0'.$_POST['mes'].'-31';}
      //echo 'Fecha recibida:'.$_POST['mes'].'/'.$_POST['anio'];
  else{
  $fechi = $_POST['anio'].'-'.$_POST['mes'].'-01';
  $fechf = $_POST['anio'].'-'.$_POST['mes'].'-31';
}
  }
   ?>
<?php
if (function_exists('login_check') && login_check()):
    $personas = personas_por_mes($fechi, $fechf);
?>
  <!-- INICIO Encabezado de Pagina -->
 <div class="content bg-gray-lighter">
     <div class="row items-push">
         <div class="col-sm-7">
             <h1 class="page-heading">
                 DIRECTORIO DE PERSONAL MENSUAL
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
       <div class="block block-themed block-rounded" id="block_hide">
       <div class="block-header bg-muted">
           <ul class="block-options">
               <li>
                  <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
               </li>
           </ul>
           <span id="block_show" class="text-white"><h3 class="block-title">REPORTE MENSUAL DE EMPLEADOS ACTIVOS</h3></span>
       </div>
         <div class="block-header bg-gray-lighter">
           <ul class="block-options">
               <li>

               </li>
           </ul>




           <form class="-horizontal push-10-t push-10" action="" method="post">
             <div class="form-group">

               <div class="col-xs-2">
                   <div class="">
               <label > Seleccione Mes y Año para Generar Reporte</label>

             </div>
           </div>
               <div class="col-xs-2">
                   <div class="">
               <select name="mes" class=" form-control " >
                 <?php
                 for ($i=1; $i<=12; $i++) {
                   if ($i == date('m'))
                   echo '<option value="'.$i.'" selected>'.User::get_nombre_mes($i).'</option>';
                   else
                   echo '<option value="'.$i.'">'.User::get_nombre_mes($i).'</option>';
                 }
                 ?>
               </select>
             </div>
           </div>
           <div class="col-xs-2">
               <div class="">
               <select name="anio"  class=" form-control">
                 <?php
                 for($i=date('o'); $i>=2015; $i--){
                   if ($i == date('o'))
                   echo '<option value="'.$i.'" selected>'.$i.'</option>';
                   else
                   echo '<option value="'.$i.'">'.$i.'</option>';
                 }
                 ?>
               </select>

             </div>
           </div>
               <button class="btn btn-sm btn-success " type="submit" name='enviar'><i class=""></i>Generar Reporte</button>
               <?php
               /*echo 'REPORTE DEL : '. $fechi . '  AL   ';
               echo $fechf;*/
               ?>
             </div>
           </form>


         </div>
         <div class="block-content">
         <table class="table table-bordered table-condensed table-striped js-dataTable-directorio-m" >
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


</script>
</body>
</html>
