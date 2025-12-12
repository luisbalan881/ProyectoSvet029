<?php
    include_once '../../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('leerCupon')) :
            include_once 'funciones.php';
          $id=$_SESSION['user_id'];
          $year=$_POST['year'];
          $mes=$_POST['mes'];
          $solicitud=$_POST['solicitud_id'];
          $vehiculo=$_POST['vehiculo_id'];
          $dep_id=$_POST['dep_id'];
         $carro = get_carro_por_solicitud_by_id($year,$mes,$solicitud,$vehiculo,$dep_id);
         
         echo 'kilometraje inicial a Registrar:';
            echo $carro['km_ini'];
          //echo '--------------------- ';
          //echo 'Ultimo kilometraje final registrado, "NOTA IMPORTANTE" se vuelve kilometraje inicial: ';
           // echo $carro['km_fin'];
            
                                    
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Modificar</title>
            <link rel="stylesheet" href="../herramientas/assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">

        </head>
        <body>



            <form class="js-validation-kilometros form-horizontal push-10-t push-10">
              <br>
              <br>


              <div class="form-group">
                <div class="col-xs-4">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">


                      <input class="form-control input-sm"  type="number"  id="km_ini" name="km_ini"  placeholder="Kilometraje Inicial"  >
                      <span class="input-group-addon" ><span>a</span></span>
                      <input class="form-control input-sm"  type="number"  id="km_fin" name="m_fin"  placeholder="Kilometraje Final" >
                    </div>
                      
                      
                      <label for="user_mail">Kilometraje*</label>
                  </div>
                </div>
                  
                  <div class="col-xs-4 text-center">
                  <div class="form-material">
                    <div class="input-group has-personalizado">
                        <span class="input-group-addon" ><span>Destino</span></span>
                      <input class="form-control input-sm"  type="text"  id="destino" name="destino"  placeholder="Destino" >
                    </div>
                  </div>
                </div>
                  
                  
                <div class="col-xs-4 text-center">
                  <div class="form-material">
                    <div class="input-group has-personalizado">
                        <span class="input-group-addon" ><span>Galones</span></span>
                      <input class="form-control input-sm"  type="number"  id="galones" name="galones"  placeholder="Galones" >
                    </div>
                  </div>
                </div>

                  <div class="col-xs-4 text-center">
                    <div class="form-material">
                      <button class="btn btn-sm btn-success btn-block"
                      onclick="asignar_kilometros(<?php echo $year?>,<?php echo "'".$mes."'" ?>,<?php echo $solicitud ?>,<?php echo $vehiculo?>,<?php echo $dep_id ?>)"
                      id="boton_a_u" ><i style="display:none;" id="loading_as_k" class="fa fa-refresh fa-spin"></i> Asignar Kilómetros</button>
                    </div>
                  </div>
                </div>
            </form>



          <!-- Page JS Code -->
          <script src="combustible/js/kilometros_form_validate.js"></script>

        </body>
        </html>

        <?php
        else :
            echo include(unauthorizedModal());
        endif;
    else:
       echo "<script type='text/javascript'> window.location='../index.php'; </script>";
    endif;
?>
