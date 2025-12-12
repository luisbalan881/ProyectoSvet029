<?php


if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerCupon')):
      $user_id = $_SESSION['user_id'];
    ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title></title>
            <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
            <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/responsive/2.1.1/css/responsive.dataTables.min.css">
            <?php if(permiso_perm(4) && usuarioPrivilegiado()->hasPrivilege('crearCupon')){
              ?>
              <script src="combustible/js/notificaciones_solicitudes.js"></script>
            <?php }?>
            <script src="combustible/js/list_solicitudes.js"></script>




        </head>
        <body >
          <div class="content bg-gray-lighter">
              <div class="row items-push">
                  <div class="col-sm-7">
                      <h1 class="page-heading">
                          CONTROL DE CUPONES
                      </h1>
                  </div>

              </div>
          </div>
          <div class="content content-boxed">
            <div class="block block-themed block-rounded">
              <div class=" block-header bg-muted ">
                <ul class="block-options">

                  <li>
                    <?php if(permiso_perm(4) && usuarioPrivilegiado()->hasPrivilege('crearCupon')){
                      ?>
                      <span id="ns1" class=" label-danger-count1 contar" style="margin-top:0px;margin-left:-18px"></span>
                    <?php } ?>
                    <button type="button" onclick="get_solicitudes_cupones_list()" ><i id="loading" class="fa fa-file"></i></button>
                  </li>
                  <?php if($u->hasPrivilege('leerCupon') && permiso_perm(2) || usuarioPrivilegiado()->hasPrivilege('Configuracion')){?>
                    <li>
                      <button title="Cupones" type="button" onclick="get_cupones_list()" ><i  class="fa fa-ticket"></i></button>
                    </li>
                  <?php }?>
                    
                    
                  <?php if($u->hasPrivilege('leerCupon') && permiso_perm(1)|| $u->hasPrivilege('leerCupon')){?>
                    <li>
                      <button title="nuevo cupon"  type="button" data-toggle="modal" data-target="#modal-remoto-lgg" href="combustible/solicitar_cupones.php"><i class="fa fa-plus"></i></button>
                    </li>
                  <?php }?>
                    
                    <?php if($u->hasPrivilege('leerCupon') && permiso_perm(1)|| $u->hasPrivilege('leerCupon')){?>
                    <li>
                      <button title="mantenimiento"  type="button" data-toggle="modal" data-target="#modal-remoto-lgg" href="combustible/solicitar_mantenimiento.php"><i class="fa fa-plus"></i></button>
                    </li>
                  <?php }?>




                    <li>
                        <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                    </li>
                </ul>
                <h3 class="block-title">Control de cupones</h3>
              </div>
              <div id="tablaaa" class="block-content">
              </div>


            </div>
          </div>



        <script>



    </script>






        </body>


        </html>
<?php
else :
    echo include(unauthorized());
endif;
else:
header("Location: index.php");
endif;
?>
