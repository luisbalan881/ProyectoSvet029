<!DOCTYPE html>
<html>
<head>
    <title>MIS SOLICITOS DE VIATICOS</title>
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
    <script src="assets/js/plugins/jspdf/jspdf.js"></script>
    
    
            <script src="assets/js/plugins/chosen/chosen.jquery.js"></script>
            <script src="assets/js/plugins/chosen/docsupport/prism.js"></script>
            <script src="assets/js/plugins/chosen/docsupport/init.js"></script>
            <link rel="stylesheet" href="assets/js/plugins/chosen/chosen.css">
            <link rel="stylesheet" href="assets/js/plugins/bootstrap-datepicker/datepicker3.min.css">





            <script src="assets/js/plugins/timepicker/js/timepicki.js"></script>
            <link href="assets/js/plugins/timepicker/css/timepicki.css" rel="stylesheet">

            <script src="assets/js/pages/solicitud_form_validate1.js"></script>
            <script src="assets/js/pages/solicitud_form_validate2.js"></script>
            <script src="transporte/js/funciones.js"></script>
            <script src="assets/js/plugins/jspdf/pdfFromHTML.js"></script>
            <script src="assets/js/plugins/jspdf/pdfFromHTML1.js"></script>
              <script src="assets/js/plugins/jspdf/pdfFromHTML2.js"></script>
             <script src="assets/js/plugins/jspdf/pdfFromHTML3.js"></script>
             <script src="assets/js/plugins/jspdf/pdfFromHTML31.js"></script>
              <script src="assets/js/plugins/jspdf/pdfFromHTML311.js"></script>
              <script src="assets/js/plugins/jspdf/pdfFromHTML32.js"></script>
               <script src="assets/js/plugins/jspdf/pdfFromHTML321.js"></script>
              <script src="assets/js/plugins/jspdf/pdfFromHTML4.js"></script>
            
            <script src="assets/js/plugins/jspdf/hoja_cupones.js"></script>
            <script src="assets/js/plugins/jspdf/hoja_cupones5.js"></script>
            <script src="assets/js/plugins/jspdf/solicitud_cupones.js"></script>

    
</head>
<body>
<?php
if (function_exists('login_check') && login_check()):
   //  if (usuarioPrivilegiado()->hasPrivilege('leerViaticos')) :
    //$personas = personas();
        $user_id =$_SESSION['user_id'];
        include_once 'funciones_viaticos.php';
        $reportenombramientos = ReporteNombramientos();

    // $nombramientos = nombramientos();
?>
  <!-- INICIO Encabezado de Pagina -->
 <div class="content bg-gray-lighter">
     <div class="row items-push">
         <div class="col-sm-7">
             <h1 class="page-heading">
                 SOLICITUDES DE VIATICOS
             </h1>
         </div>
         <div class="col-sm-5 text-right hidden-xs">
             <ol class="breadcrumb push-10-t">
                 <li>CONTROL DE MIS SOLICITUDES DE VIATICOS</li>
                 <li><a class="link-effect" href="#">MIS VIATICOS</a></li>
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
           <h3 class="block-title">Solicitudes de Viaticos</h3>
         </div>
       
         
         <div class="block-content">
             <table class="table table-bordered table-condensed table-striped js-dataTable-Report1" >  
                 <thead>
                     <tr>
                         
                         <th>Fecha de salida</th>
                          <th class="text-center">Fecha de retorno.</th>
                         <th class="text-center">Nombre servidor publico.</th>
                         
                         <th class="hidden-xs text-center">Destino</th>
                         <th class="hidden-xs text-center">Objetivo del viaje</th>
                         <th class="text-center">costo</th>
                           <th class="text-center">Fromulario Asignado</th>
                            <th class="text-center">Accion</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                     if ($user_id == 177)
                         {
                       foreach ($reportenombramientos as $nombramientoReporte){
                         //foreach ($personas as $persona){
                           // if($persona['ext_id'] > 0 && $nombramientoReporte['user_status'] == 1){
                                echo '<tr>';
                             //   echo '<td class="hidden-xs">'.$nombramientoReporte['id_nombramiento'].'</td>';
                                //echo '<td >'.$nombramientoReporte['cod_nombramiento'].' '.fecha_dmy($nombramientoReporte['fecha']).'</td>';
                                //echo '<td >'.$nombramientoReporte['user_nm1'].' '.$nombramientoReporte['user_nm2'].' '.$nombramientoReporte['user_ap1'].' '.$nombramientoReporte['user_ap2'].'</td>';
                               
                                echo '<td class="text-center">'.fecha_dmy($nombramientoReporte['FechaRetorno']).'</td>';
                               // echo '<td class="hidden-xs" ><a href="mailto:'.$nombramientoReporte['user_mail'].'">'.$nombramientoReporte['user_mail'].'</td>';
                                echo '<td class="hidden-xs">'.fecha_dmy($nombramientoReporte['FechaRetorno']).'</td>';
                                //echo '<td >'.$nombramientoReporte['user_nm1'].' '.$nombramientoReporte['user_nm2'].' '.$nombramientoReporte['user_ap1'].' '.$nombramientoReporte['user_ap2'].'</td>';
                                 echo '<td class="hidden-xs">'.$nombramientoReporte['NombreServidorPublico'].'</td>';
                               // echo '<td >'.$nombramientoReporte['NombreServidorPublico'].' '.$nombramientoReporte['NombreServidorPublico'].'</td>';
                                echo '<td class="hidden-xs">'.$nombramientoReporte['Destino'].'</td>';
                                echo '<td class="hidden-xs">'.$nombramientoReporte['ObjetivoDelViaje'].'</td>';
                                // echo '<td class="hidden-xs">'.number_format($nombramientoReporte['CostoDeViaje'],2).'</td>';
                                   echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($nombramientoReporte['CostoDeViaje'],2).'</td>';
                               //echo '<td class="hidden-xs">'.$nombramientoReporte['objetivo'].'</td>';
                              //  echo '</tr>';
                                    echo '<td class="hidden-xs">'.$nombramientoReporte['FormularioAsignado'].'</td>';
                                 echo '<td class="text-center" style="white-space: nowrap;">';
                          //  echo '<div class="btn-group">';
                       //     echo '<span data-toggle="tooltip" title="Revisar"><a class="btn btn-default" '.(($nombramientoReporte['status'] == 1 )?' href="almacen/requisicion_impresion.php?id='.$nombramientoReporte['id_nombramiento'].'" target="_blank" ':'href="#" disabled').'><i class="fa fa-print text-info"></i></a></span>';
                          
                            
                           // if (permiso_perm(4) && usuarioPrivilegiado()->hasPrivilege('crearCupon') || usuarioPrivilege('Configuracion'))
                            //{
                              // echo '<button title="liquidacion sin Anticipo" class="btn btn-personalizado outline" title="Descargar" ';
                            /* if ($nombramientoReporte['status'] == 3)
                                {
                                 echo 'onclick="HTMLtoPDFV13('.$nombramientoReporte['id_nombramiento'].')"';
                                 
                                }
                                else {
                                    
                                    echo'disabled';
                                }
                                echo '><i class="fa fa-download"></i></button>';
                            
                            
                            echo '<button title="Imprimir Constancia" class="btn btn-personalizado outline" title="Descargar" ';
                             if ($nombramientoReporte['status'] == 2 and $user_id == 177 )
                                {
                                 echo 'onclick="HTMLtoPDFV1('.$nombramientoReporte['id_nombramiento'].')"';
                                 
                                }
                                else {
                                    
                                    echo'disabled';
                                }
                                echo '><i class="fa fa-download"></i></button>';
                                
                                
                                
                                echo '<button title="Imprimir Anticipo" class="btn btn-personalizado outline" title="Descargar" ';
                             if ($nombramientoReporte['status'] == 2 and $user_id == 177 )
                                {
                                 echo 'onclick="HTMLtoPDFV11('.$nombramientoReporte['id_nombramiento'].')"';
                                 
                                }
                                else {
                                    
                                    echo'disabled';
                                }
                                echo '><i class="fa fa-download"></i></button>';
                                
                                 echo '<button title="Sin Anticipo" class="btn btn-personalizado outline" title="Descargar" ';
                             if ($nombramientoReporte['status'] == 4 and $user_id == 177 )
                                {
                                 echo 'onclick="HTMLtoPDFV111('.$nombramientoReporte['id_nombramiento'].')"';
                                 
                                }
                                else {
                                    
                                    echo'disabled';
                                }
                                echo '><i class="fa fa-download"></i></button>';
                                
                               
                                 echo '<button title="Imprimir liquidacion" class="btn btn-personalizado outline" title="Descargar" ';
                             if ($nombramientoReporte['status'] == 3 and $user_id == 177)
                                {
                                 echo 'onclick="HTMLtoPDFV12('.$nombramientoReporte['id_nombramiento'].')"';
                                 
                                }
                                else {
                                    
                                    echo'disabled';
                                }
                                echo '><i class="fa fa-download"></i></button>';
                               
                                
                                
                              echo '<button title="Imprimir Nombramiento" class="btn btn-personalizado outline" title="Descargar" ';
                             if ($nombramientoReporte['status'] == 1)
                                {
                                 echo 'onclick="HTMLtoPDF1('.$nombramientoReporte['id_nombramiento'].')"';
                                 
                                }
                                else {
                                    
                                    echo'disabled';
                                }
                                echo '><i class="fa fa-download"></i></button>';

                                
                                
                                
                                echo '<button title="Imprimir Solicitud Viaticos" class="btn btn-personalizado outline" title="Descargar" ';
                             if ($nombramientoReporte['status'] == 1)
                                {
                                 echo 'onclick="HTMLtoPDFV('.$nombramientoReporte['id_nombramiento'].')"';
                                 
                                }
                                else {
                                    
                                    echo'disabled';
                                }
                                echo '><i class="fa fa-download"></i></button>'; 
                                
                          //  }
                                
                                  if ($nombramientoReporte['status'] == 1 and $user_id == 177 )
                                {
                                 echo '<span data-toggle="tooltip" title="Autorizar"><a class="btn btn-default"  title="Se asignara un formulario"  data-toggle="modal" data-target="#modal-remoto" href="viaticos/solicitar_viaticos_1.php?id='.$nombramientoReporte['id_nombramiento'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
                                  }
                                  
                                  
                                    if ($nombramientoReporte['status'] == 2 and $user_id == 177)
                                {
                                 echo '<span data-toggle="tooltip" title=" Anticipo"><a class="btn btn-default"  title="Anular Anticipo"  data-toggle="modal" data-target="#modal-remoto" href="viaticos/sin_anticipio.php?id='.$nombramientoReporte['id_nombramiento'].'"><i class="fa fa-eye text-info"></i></a></span>';
                                 
                                  //echo '<span data-toggle="tooltip" title="Anular"><a class="btn btn-default" ' . (($requisicion['req_status'] == 0) ? 'href="#" disabled' : ' data-toggle="modal" data-target="#modal-remoto" href="almacen/requisicion_anular.php?id='.$requisicion['req_id'].'"') . ' ><i class="fa fa-times text-danger"></i></a></span>';
                                 
                                  }
                              /*  else {
                                    
                                    echo'Asignado'; 
                               }*/
                                 
                               /*   if ($nombramientoReporte['status'] == 2 )
                                {
                                 echo '<span data-toggle="tooltip" title="Liquidar"><a class="btn btn-default"  title="Liquidar"  data-toggle="modal" data-target="#modal-remoto" href="viaticos/solicitar_viaticos_2.php?id='.$nombramientoReporte['id_nombramiento'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
                                  }
                                else {
                                    
                                    echo'-liquidado';
                                } */
                               
                                
                                
                                
                                
                                
                                
                                 
                            echo ' ';
                            echo '</div>';
                            echo '</td>';
                            echo '</tr>';
      
                                
                                }
                            //}
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
