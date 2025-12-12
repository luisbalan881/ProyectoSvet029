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
            <link rel="stylesheet" href="assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">





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
        $nombramientos = nombramientos2($user_id);

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
           <h3 class="block-title">Listado de mis solicitudes</h3>
         </div>
         <div class="block-content">
             <table class="table table-bordered table-condensed table-striped js-dataTable-directorio" >
                 <thead>
                     <tr>
                         <th class="hidden-xs"></th>
                         <th>Nombramiento</th>
                         <th class="text-center">Fecha de Inicio.</th>
                         
                         <th class="hidden-xs text-center">Fecha Fin</th>
                         <th class="hidden-xs text-center">Lugar</th>
                         <th class="text-center">Acción</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                     
                       foreach ($nombramientos as $nombramiento){
                         //foreach ($personas as $persona){
                           // if($persona['ext_id'] > 0 && $nombramiento['user_status'] == 1){
                                echo '<tr>';
                                echo '<td class="hidden-xs">'.$nombramiento['id_nombramiento'].'</td>';
                                //echo '<td >'.$nombramiento['cod_nombramiento'].' '.fecha_dmy($nombramiento['fecha']).'</td>';
                                //echo '<td >'.$nombramiento['user_nm1'].' '.$nombramiento['user_nm2'].' '.$nombramiento['user_ap1'].' '.$nombramiento['user_ap2'].'</td>';
                                echo '<td class="hidden-xs">'.($nombramiento['cod_nombramiento']).'</td>';
                                echo '<td class="text-center">'.fecha_dmy($nombramiento['fecha_inicio']).'</td>';
                               // echo '<td class="hidden-xs" ><a href="mailto:'.$nombramiento['user_mail'].'">'.$nombramiento['user_mail'].'</td>';
                                echo '<td class="hidden-xs">'.fecha_dmy($nombramiento['fecha_fin']).'</td>';
                                //echo '<td >'.$nombramiento['user_nm1'].' '.$nombramiento['user_nm2'].' '.$nombramiento['user_ap1'].' '.$nombramiento['user_ap2'].'</td>';
                                echo '<td class="hidden-xs">'.$nombramiento['lugar'].'</td>';
                               //echo '<td class="hidden-xs">'.$nombramiento['objetivo'].'</td>';
                              //  echo '</tr>';
                                 echo '<td class="text-center" style="white-space: nowrap;">';
                            echo '<div class="btn-group">';
                       //     echo '<span data-toggle="tooltip" title="Revisar"><a class="btn btn-default" '.(($nombramiento['status'] == 1 )?' href="almacen/requisicion_impresion.php?id='.$nombramiento['id_nombramiento'].'" target="_blank" ':'href="#" disabled').'><i class="fa fa-print text-info"></i></a></span>';
                          
                            
                           // if (permiso_perm(4) && usuarioPrivilegiado()->hasPrivilege('crearCupon') || usuarioPrivilege('Configuracion'))
                            //{
                          /*  echo '<button title="Imprimir Constancia" class="btn btn-personalizado outline" title="Descargar" ';
                             if ($nombramiento['status'] == 2 and $user_id == 177 )
                                {
                                 echo 'onclick="HTMLtoPDFV1('.$nombramiento['id_nombramiento'].')"';
                                 
                                }
                                else {
                                    
                                    echo'disabled';
                                }
                                echo '><i class="fa fa-download"></i></button>';
                                
                                
                                
                                echo '<button title="Imprimir Anticipo" class="btn btn-personalizado outline" title="Descargar" ';
                             if ($nombramiento['status'] == 2 and $user_id == 177 )
                                {
                                 echo 'onclick="HTMLtoPDFV11('.$nombramiento['id_nombramiento'].')"';
                                 
                                }
                                else {
                                    
                                    echo'disabled';
                                }
                                echo '><i class="fa fa-download"></i></button>';
                                
                             */  
                                 echo '<button title="Imprimir liquidación" class="btn btn-personalizado outline" title="Descargar" ';
                             if ($nombramiento['status'] == 3)
                                {
                                 echo 'onclick="HTMLtoPDFV12('.$nombramiento['id_nombramiento'].')"';
                                 
                                }
                                else {
                                    
                                    echo'disabled';
                                }
                                echo '><i class="fa fa-download"></i></button>';
                               
                                
                                
                                 echo '<button title="Imprimir Nombramiento" class="btn btn-personalizado outline" title="Descargar" ';
                             if ($nombramiento['status'] == 1)
                                {
                                 echo 'onclick="HTMLtoPDF1('.$nombramiento['id_nombramiento'].')"';
                                 
                                }
                                else {
                                    
                                    echo'disabled';
                                }
                                echo '><i class="fa fa-download"></i></button>';

                                
                                
                                
                                echo '<button title="Imprimir Solicitud Viáticos" class="btn btn-personalizado outline" title="Descargar" ';
                             if ($nombramiento['status'] == 1)
                                {
                                 echo 'onclick="HTMLtoPDFV('.$nombramiento['id_nombramiento'].')"';
                                 
                                }
                                else {
                                    
                                    echo'disabled';
                                }
                                echo '><i class="fa fa-download"></i></button>';
                                
                          //  }
                                
                                /*  if ($nombramiento['status'] == 1 and $user_id == 177 )
                                {
                                 echo '<span data-toggle="tooltip" title="Asignar formulario"><a class="btn btn-default"  title="Asignar formulario Solo Administrador"  data-toggle="modal" data-target="#modal-remoto" href="viaticos/solicitar_viaticos_1.php?id='.$nombramiento['id_nombramiento'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
                                  }
                                else {
                                    echo '<span class="label label-primary">En curso</span> </td>';
                                   // echo'Asignado'; 
                               } */
                                 
                                  if ($nombramiento['status'] == 2 or $nombramiento['status'] == 3 )
                                {
                                 echo '<span data-toggle="tooltip" title="Liquidar"><a class="btn btn-default"  title="Actualizar liquidación"  data-toggle="modal" data-target="#modal-remoto" href="viaticos/solicitar_viaticos_2.php?id='.$nombramiento['id_nombramiento'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
                                  }
                                 
                                   if ($nombramiento['status'] == 1 )
                                {
                                 echo '<span data-toggle="tooltip" title="Anular"><a class="btn btn-default"  title="Anular"  data-toggle="modal" data-target="#modal-remoto" href="viaticos/solicitar_anulacion.php?id='.$nombramiento['id_nombramiento'].'"><i class="fa fa-times text-danger"></i></a></span>';
                                  }
                                  
                                if ($nombramiento['status'] == 0 ){
                                    echo '<span class="label label-warning"> Anulado</span> </td>';
                                    //echo'-liquidado';
                                }  
                                  
                                else if ($nombramiento['status'] == 1 ){
                                    echo '<span class="label label-primary">Solicitud Envida</span> </td>';
                                    //echo'-liquidado';
                                }
                                else if ($nombramiento['status'] == 2 ){
                                    echo '<span class="label label-primary">Autorizado (a liquidar)</span> </td>';
                                    //echo'-liquidado';
                                }
                                else if ($nombramiento['status'] == 3 ){
                                    echo '<span class="label label-success">Liquidado</span> </td>';
                                    //echo'-liquidado';
                                }
                                
                                
                                
                                
                                 
                            echo ' ';
                            echo '</div>';
                            echo '</td>';
                            echo '</tr>';
      
                                
                                
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
