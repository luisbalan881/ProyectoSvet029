<!DOCTYPE html>
<html>
<head>
    <title>Traslado de Bienes</title>
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
                 DESCARGA DISPONIBLES
             </h1>
         </div>
		 
                    
         </div>
		
		
		 
		  <h1 class="block-title">Descargar Formato Detalle de Gastos</h1>
		 
         <a href="..\svet_sis\herramientas\Detalle de Gasto.xlsx"><h4> Clic Aqui </h4></a>
		 <br>   
		 <br>   
		 <br>   
		  <h1 class="block-title">Descargar Formato para llenar Traslado de Bienes</h1>
		 
         <a href="..\svet_sis\herramientas\TRASLADO_BIENES.xlsx">  <h4> Clic Aqui </h4></a>
		 
		 
 <!-- FIN Contenido de Pagina -->
<?php else : ?>
    <p>
         <span class="error">Usted no esta autorizado para acceder a esta pagina.</span> Por favor <a href="index.php">inicie sesión</a>.
    </p>
<?php endif; ?>
</body>
</html>
