<!DOCTYPE html>

<?php
/*if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerCupon')):
        include_once 'inc/CouponApplication.php';
        include_once 'funciones_cupones.php';
        $cupones_pedido = CouponApplication::getAll($u);
         $user_id =$_SESSION['user_id'];
         $list_bitacora = list_bitacora_por_usuario_admin($user_id);
        */  
        
        ?>


<html>
<head>
    <title>MIS Registros KM </title>
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
            <script src="assets/js/plugins/jspdf/pdfKMinicial.js"></script>
            <script src="assets/js/plugins/jspdf/pdfFromHTML1.js"></script>
              <script src="assets/js/plugins/jspdf/pdfFromHTML2.js"></script>
             <script src="assets/js/plugins/jspdf/pdfFromHTML3.js"></script>
             <script src="assets/js/plugins/jspdf/pdfFromHTML31.js"></script>
              <script src="assets/js/plugins/jspdf/pdfFromHTML32.js"></script>
               <script src="assets/js/plugins/jspdf/pdfFromHTML321.js"></script>
              <script src="assets/js/plugins/jspdf/pdfFromHTML4.js"></script>
                 <script src="assets/js/plugins/jspdf/pdf_detalle_comision.js"></script>
            
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
        include_once 'funciones_cupones.php';
       // $list_bitacora = list_bitacora_por_usuario($user_id);
        $list_bitacora = list_bitacora_por_usuario_admin($user_id);

    // $list_bitacora = list_bitacora();
?>

    
  <!-- INICIO Encabezado de Pagina -->
 <div class="content bg-gray-lighter">
     <div class="row items-push">
         <div class="col-sm-7">
             <h1 class="page-heading">
                 Registros
             </h1>
         </div>
         <div class="col-sm-5 text-right hidden-xs">
             <ol class="breadcrumb push-10-t">
                 <li>CONTROL DE VEHICULOS</li>
                 <li><a class="link-effect" href="#">MIS Registros</a></li>
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
           <h3 class="block-title">Listado de mi Registros</h3>
         </div>
         <div class="block-content">
             <table class="table table-bordered table-condensed table-striped js-dataTable-directorio-3" >
                 <thead>
                     <tr>
                         <th class="hidden-xs"></th>
                         <th>placa</th>
                         <th class="text-center">Fecha.</th>
                         
                         <th class="hidden-xs text-center">Marca</th>
                         <th class="hidden-xs text-center">Linea</th>
                         <th class="hidden-xs text-center">piloto</th>
                         <th class="hidden-xs text-center">Motivo</th>
                         <th class="hidden-xs text-center">Destino</th>
                         <th class="hidden-xs text-center">km inicial</th>
                         <th class="hidden-xs text-center">km final</th>
                          <th class="hidden-xs text-center">km recorridos</th>
                           <th class="hidden-xs text-center">recorridos para mante</th>
                          
                         <th class="text-center">Acción</th>
                          <th class="text-center">Acción para mantenimiento</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                     
                       foreach ($list_bitacora as $list_bitacora1){
                         //foreach ($personas as $persona){
                           // if($persona['ext_id'] > 0 && $list_bitacora1['user_status'] == 1){
                                echo '<tr>';
                                echo '<td class="hidden-xs">'.$list_bitacora1['id_bitacora'].'</td>';
                                //echo '<td >'.$list_bitacora1['cod_list_bitacora1'].' '.fecha_dmy($list_bitacora1['fecha']).'</td>';
                                //echo '<td >'.$list_bitacora1['user_nm1'].' '.$list_bitacora1['user_nm2'].' '.$list_bitacora1['user_ap1'].' '.$list_bitacora1['user_ap2'].'</td>';
                                echo '<td class="hidden-xs">'.($list_bitacora1['placa']).'</td>';
                                echo '<td class="text-center">'.fecha_dmy($list_bitacora1['fecha']).'</td>';
                               // echo '<td class="hidden-xs" ><a href="mailto:'.$list_bitacora1['user_mail'].'">'.$list_bitacora1['user_mail'].'</td>';
                                 echo '<td class="hidden-xs">'.($list_bitacora1['nombre']).'</td>';
                                 
                                   echo '<td class="hidden-xs">'.($list_bitacora1['linea']).'</td>';
                                     echo '<td class="hidden-xs">'.($list_bitacora1['user_nm1']).''.(" ").''.($list_bitacora1['user_ap1']).'</td>';
                                //echo '<td >'.$list_bitacora1['user_nm1'].' '.$list_bitacora1['user_nm2'].' '.$list_bitacora1['user_ap1'].' '.$list_bitacora1['user_ap2'].'</td>';
                                      echo '<td class="hidden-xs">'.$list_bitacora1['motivo'].'</td>';
                                echo '<td class="hidden-xs">'.$list_bitacora1['Destino'].'</td>';
                                     echo '<td class="hidden-xs">'.$list_bitacora1['km_inicial'].'</td>';
                                       echo '<td class="hidden-xs">'.$list_bitacora1['km_final'].'</td>';
                                        echo '<td class="hidden-xs">'.$list_bitacora1['km_recorrido'].'</td>';
                                         echo '<td class="hidden-xs">'.$list_bitacora1['contador_km_mantenimiento'].'</td>';
                               //echo '<td class="hidden-xs">'.$list_bitacora1['objetivo'].'</td>';
                              //  echo '</tr>';
                                 echo '<td class="text-center" style="white-space: nowrap;">';
                            echo '<div class="btn-group">';
                       //     echo '<span data-toggle="tooltip" title="Revisar"><a class="btn btn-default" '.(($list_bitacora1['status'] == 1 )?' href="almacen/requisicion_impresion.php?id='.$list_bitacora1['id_list_bitacora1'].'" target="_blank" ':'href="#" disabled').'><i class="fa fa-print text-info"></i></a></span>';
                          
                            
                           // if (permiso_perm(4) && usuarioPrivilegiado()->hasPrivilege('crearCupon') || usuarioPrivilege('Configuracion'))
                            //{
                          /*  echo '<button title="Imprimir Constancia" class="btn btn-personalizado outline" title="Descargar" ';
                             if ($list_bitacora1['status'] == 2 and $user_id == 177 )
                                {
                                 echo 'onclick="HTMLtoPDFV1('.$list_bitacora1['id_list_bitacora1'].')"';
                                 
                                }
                                else {
                                    
                                    echo'disabled';
                                }
                                echo '><i class="fa fa-download"></i></button>';
                                
                                
                                
                                echo '<button title="Imprimir Anticipo" class="btn btn-personalizado outline" title="Descargar" ';
                             if ($list_bitacora1['status'] == 2 and $user_id == 177 )
                                {
                                 echo 'onclick="HTMLtoPDFV11('.$list_bitacora1['id_list_bitacora1'].')"';
                                 
                                }
                                else {
                                    
                                    echo'disabled';
                                }
                                echo '><i class="fa fa-download"></i></button>';
                                
                             */  
                                 
                                
                               
                                
                              
                                
                          //  }
                                
                                /*  if ($list_bitacora1['status'] == 1 and $user_id == 177 )
                                {
                                 echo '<span data-toggle="tooltip" title="Asignar formulario"><a class="btn btn-default"  title="Asignar formulario Solo Administrador"  data-toggle="modal" data-target="#modal-remoto" href="viaticos/solicitar_viaticos_1.php?id='.$list_bitacora1['id_list_bitacora1'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
                                  }
                                else {
                                    echo '<span class="label label-primary">En curso</span> </td>';
                                   // echo'Asignado'; 
                               } */
                                 
                                
                                  
                                /*   if ($list_bitacora1['status'] == 2 or $list_bitacora1['status'] == 3 )
                                {
                                 echo '<span data-toggle="tooltip" title="Detalle de comision"><a class="btn btn-default"  title="Detallar comision"  data-toggle="modal" data-target="#modal-remoto" href="viaticos/detalle_comision.php?id='.$list_bitacora1['id_bitacora'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
                                  }*/
                                 
                              //     if ($list_bitacora1['status'] == 1 )
                               // {
                                // echo '<span data-toggle="tooltip" title="Anular"><a class="btn btn-default"  title="Anular"  data-toggle="modal" data-target="#modal-remoto" href="viaticos/solicitar_anulacion.php?id='.$list_bitacora1['id_bitacora'].'"><i class="fa fa-times text-danger"></i></a></span>';
                                 
                                  //echo '<span data-toggle="tooltip" title="Anular"><a class="btn btn-default" ' . (($requisicion['req_status'] == 0) ? 'href="#" disabled' : ' data-toggle="modal" data-target="#modal-remoto" href="almacen/requisicion_anular.php?id='.$requisicion['req_id'].'"') . ' ><i class="fa fa-times text-danger"></i></a></span>';
                                 
                                  //}
                                  
                              //  if ($list_bitacora1['status'] == 0 ){
                                //    echo '<span class="label label-warning"> Anulado</span> </td>';
                                    //echo'-liquidado';
                                //}  
                                /* if ($list_bitacora1['status'] == 1 )
                                {
                                 echo '<span data-toggle="tooltip" title="registra KM final"><a class="btn btn-default"  title="Registrar Km final"  data-toggle="modal" data-target="#modal-remoto" href="combustible/reg_km_fin_user.php?id='.$list_bitacora1['id_bitacora'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
                                  }
                                  
                                else if ($list_bitacora1['status'] == 1 ){
                                    echo '<span class="label label-primary">Registra KM final</span> </td>';
                                    //echo'-liquidado';
                                }  */
                                 if ($list_bitacora1['status'] == 2 ){
                                    echo '<span class="label label-primary">KM Registrado</span> </td>';
                                    //echo'-liquidado';
                                }
                               
                                 if ($list_bitacora1['status'] == 0 ){
                                    echo '<span class="label label-warning"> Anulado</span> </td>';
                                    //echo'-liquidado';
                                }  
                                  
                                else if ($list_bitacora1['status'] == 1 ){
                                    echo '<span class="label label-primary">Por registrar KM final</span> </td>';
                                    //echo'-liquidado';
                                }
                                //else if ($list_bitacora1['status'] == 2 ){
                                //  echo '<span class="label label-primary">KM Registrados</span> </td>';
                                    //echo'-liquidado';
                                //}
                               
                                
                                
                                 
                            echo ' ';
                            echo '</div>';
                            echo '</td>';
                            
                            
                              echo '<td class="text-center" style="white-space: nowrap;">';
                            echo '<div class="btn-group">';
                       //     echo '<span data-toggle="tooltip" title="Revisar"><a class="btn btn-default" '.(($list_bitacora1['status'] == 1 )?' href="almacen/requisicion_impresion.php?id='.$list_bitacora1['id_list_bitacora1'].'" target="_blank" ':'href="#" disabled').'><i class="fa fa-print text-info"></i></a></span>';
                          
                            
                           // if (permiso_perm(4) && usuarioPrivilegiado()->hasPrivilege('crearCupon') || usuarioPrivilege('Configuracion'))
                            //{
                          /*  echo '<button title="Imprimir Constancia" class="btn btn-personalizado outline" title="Descargar" ';
                             if ($list_bitacora1['status'] == 2 and $user_id == 177 )
                                {
                                 echo 'onclick="HTMLtoPDFV1('.$list_bitacora1['id_list_bitacora1'].')"';
                                 
                                }
                                else {
                                    
                                    echo'disabled';
                                }
                                echo '><i class="fa fa-download"></i></button>';
                                
                                
                                
                                echo '<button title="Imprimir Anticipo" class="btn btn-personalizado outline" title="Descargar" ';
                             if ($list_bitacora1['status'] == 2 and $user_id == 177 )
                                {
                                 echo 'onclick="HTMLtoPDFV11('.$list_bitacora1['id_list_bitacora1'].')"';
                                 
                                }
                                else {
                                    
                                    echo'disabled';
                                }
                                echo '><i class="fa fa-download"></i></button>';
                                
                             */  
                                 
                                
                               
                                
                              
                                
                          //  }
                                
                                /*  if ($list_bitacora1['status'] == 1 and $user_id == 177 )
                                {
                                 echo '<span data-toggle="tooltip" title="Asignar formulario"><a class="btn btn-default"  title="Asignar formulario Solo Administrador"  data-toggle="modal" data-target="#modal-remoto" href="viaticos/solicitar_viaticos_1.php?id='.$list_bitacora1['id_list_bitacora1'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
                                  }
                                else {
                                    echo '<span class="label label-primary">En curso</span> </td>';
                                   // echo'Asignado'; 
                               } */
                                 
                                
                                  
                                /*   if ($list_bitacora1['status'] == 2 or $list_bitacora1['status'] == 3 )
                                {
                                 echo '<span data-toggle="tooltip" title="Detalle de comision"><a class="btn btn-default"  title="Detallar comision"  data-toggle="modal" data-target="#modal-remoto" href="viaticos/detalle_comision.php?id='.$list_bitacora1['id_bitacora'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
                                  }*/
                                 
                              //     if ($list_bitacora1['status'] == 1 )
                               // {
                                // echo '<span data-toggle="tooltip" title="Anular"><a class="btn btn-default"  title="Anular"  data-toggle="modal" data-target="#modal-remoto" href="viaticos/solicitar_anulacion.php?id='.$list_bitacora1['id_bitacora'].'"><i class="fa fa-times text-danger"></i></a></span>';
                                 
                                  //echo '<span data-toggle="tooltip" title="Anular"><a class="btn btn-default" ' . (($requisicion['req_status'] == 0) ? 'href="#" disabled' : ' data-toggle="modal" data-target="#modal-remoto" href="almacen/requisicion_anular.php?id='.$requisicion['req_id'].'"') . ' ><i class="fa fa-times text-danger"></i></a></span>';
                                 
                                  //}
                                  
                              //  if ($list_bitacora1['status'] == 0 ){
                                //    echo '<span class="label label-warning"> Anulado</span> </td>';
                                    //echo'-liquidado';
                                //}  
                                /* if ($list_bitacora1['status'] == 1 )
                                {
                                 echo '<span data-toggle="tooltip" title="registra KM final"><a class="btn btn-default"  title="Registrar Km final"  data-toggle="modal" data-target="#modal-remoto" href="combustible/reg_km_fin_user.php?id='.$list_bitacora1['id_bitacora'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
                                  }
                                  
                                else if ($list_bitacora1['status'] == 1 ){
                                    echo '<span class="label label-primary">Registra KM final</span> </td>';
                                    //echo'-liquidado';
                                }  */
                                 if ($list_bitacora1['contador_km_mantenimiento'] < 100 ){
                                    echo '<span class="label label-success"> no nesesita </span> </td>';
                                    //echo'-liquidado';
                                }
                               
                                 if ($list_bitacora1['contador_km_mantenimiento'] == 100 ){
                                    echo '<span class="label label-primary"> Para mantenimiento </span> </td>';
                                    //echo'-liquidado';
                                }  
                                
                                  
                                else if ($list_bitacora1['contador_km_mantenimiento'] > 100 ){
                                    echo '<span class="label label-warning">sobre KM mantenimiento   <a class="btn btn-default"  title="Registrar Mantenimiento"  data-toggle="modal" data-target="#modal-remoto" href="combustible/reg_mantenimiento.php?id='.$list_bitacora1['id_bitacora'].'"><i class="fa fa-pencil text-warning"></i></a> </span> </td>';
                                    //echo'-liquidado';
                                    
                               //      if ($list_bitacora1['status'] == 1 )
                                //{
                               //  echo '<span data-toggle="tooltip" title="registra KM final"><a class="btn btn-default"  title="Registrar Km final"  data-toggle="modal" data-target="#modal-remoto" href="combustible/reg_km_fin_user.php?id='.$list_bitacora1['id_bitacora'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
                                 // }
                                
                                    
                                }
                                //else if ($list_bitacora1['status'] == 2 ){
                                //  echo '<span class="label label-primary">KM Registrados</span> </td>';
                                    //echo'-liquidado';
                                //}
                               
                                
                                
                                 
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
 