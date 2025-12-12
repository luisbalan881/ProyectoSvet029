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


            $mess = $_POST['mess'];
            $anio = $_POST['anio'];


                $roles = roles();
                $persona = User::getHorarios_Generales_Control($mess, $anio);
                //$datos_u = User::get_user_horario($id);

        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Horario</title>




        </head>
        <body>
          <div class="modal-r-p block  block-rounded ">
            <div class="block-header " id="cabecera">
                <ul class="block-options2">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="btn-circle"></i></button>
                    </li>
                </ul>
                <div class="tag-green">Horario entrada y Salida de Usuario</div>
            </div>

            <div class="block-content">

            <!--<button class="btn btn-succes outline" id="btnPrint"><i class="fa fa-file-pdf-o"></i> - Guardar como PDF</button>-->


            <div id="printThis" >
              <!--<a href="<?php echo ' usuarios/prueba.php?mess='.$mess.'&anio ='.$anio.' ';?>" onclick="">prueba PDF</a>
              <a href="#" onclick="HTMLtoPDF()">Download PDF</a>-->
              <style>

              @media print {

                body{
                  visibility: hidden;

                }
                #btnPrint{
                  visibility: hidden;
                  display: none;
                }
                #cabecera{
                  visibility: hidden;
                  display: none;
                }
                thead{
                  visibility: hidden;

                }
                .modal {
                  visibility: visible;
                  /**Remove scrollbar for printing.**/
                  overflow: visible !important;
                  margin-left: 1cm;
                  width: 17.5cm;
                  height: 25cm;
                }
                .modal-dialog {
                  visibility: visible !important;
                  /**Remove scrollbar for printing.**/
                  overflow: visible !important;
                }


                .col-sm-4{
                  visibility: hidden;
                  display: none;
                }
                .col-sm-6{
                  visibility: hidden;
                  display: none;
                }

                tr, th, td{
    page-break-inside:avoid !important;
    page-break-after:auto;
}
            }
              }
              </style>
            <!--<p>Print 1</p><a class="js-print-link" href="#">Click Me To Print</a>-->
            <div id="HTMLtoPDF">

              <table id="example" class="print table-bordered table-condensed table-striped js-dataTable-usuariosH-general dt-responsive display nowrap" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                        <th class="text-center">Nombre</th>
                         <th class="text-center" >Dia</th>
                          <th class="text-center" >Fecha</th>
                          <th class="text-center" >Control</th>
                          <th class="text-center">Entrada</th>
                          <th class="text-center">Salida</th>
                          <th class="text-center">Horas</th>


                      </tr>
                  </thead>
                  <tbody>
                      <?php

                          foreach ($persona as $p){
                              echo '<tr id="nueva" >';
                              echo '<td class="text-center">'.$p['NOMBRE'].'</td>';
                              echo '<td class="text-center">'.User::get_nombre_dia($p['FECHA']).'</td>';
                              echo '<td class="text-center">'.fecha_dmy($p['FECHA']).'</td>';
                              echo '<td class="text-center">';
                              if($p['LABOR'] == '0'){ echo '<span class="label label-danger">Ausente</span> ';}
                              else if($p['LABOR'] == '1'){ echo '<span class="label label-success" disabled></span>';}
                              else if($p['LABOR'] == '2'){ echo '<span class="label label-warning">Permiso</span>';}
                              else if($p['LABOR'] == '3'){ echo '<span class="label label-success" disabled>Feriado</span>';}
                              else if($p['LABOR'] == '4'){ echo '<span class="label label-info">No Laboraba</span>';}
                              else if($p['LABOR'] == '6'){ echo '<span class="label label-vacaciones">Vacaciones</span>';}
                              else if($p['LABOR'] == '7'){ echo '<span class="label label-warning"><i class="fa fa-hand-o-up"/>  Aún no marcaba</span>';}
                              else if($p['LABOR'] == '5'){ echo '<span class="label label-primary"><i class="fa fa-heartbeat"/> -   Suspendido IGSS</span';}                              
                              else{
                                echo '<span class="label label-secondary">'.$p['DIAN'].'</span>';
                              }

                              echo'</td>';
                              echo '<td class="text-center">'.$p['F_INI'].'</td>';
                              echo '<td class="text-center">'.$p['F_FIN'].'</td>';
                              echo '<td class="text-center">'.$p['HORAS'].'</td>';
                              /*echo '<td class="text-center">'.(($p['E'] == '0')? '<span class="label label-danger">Llegó Tarde</span>':'<span class="label label-info"></span>').'</td>';
                              echo '<td class="text-center">'.(($p['S'] == '1')? '<span class="label label-danger">Se fue temprano</span>':'<span class="label label-info"></span>').'</td>';*/

                              echo '</tr>';
                          }
                      ?>
                  </tbody>

              </table>

            </div>





            </div>

          </div>



      <script>
      $('.js-print-link').on('click', function() {
var printBlock = $(this).parents('.print').siblings('.print');
printBlock.hide();
window.print();
printBlock.show();
});
      </script>
          <!-- Page JS Code -->
          <script>
              jQuery(function(){
                  // Init page helpers (Select2 Inputs plugins)
                  App.initHelpers(['select2']);
              });
          </script>
          <script src="assets/js/pages/usuarios_forms_validation.js"></script>

          <script>
          $(document).ready(function() {
            var table = $('#example').DataTable({
              "pageLength": 50,

              lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
              buttons: [
      { text:'PDF',
          extend: 'pdf',
          footer : true,
          header : true,
          "stripeClasses": [ 'strip1', 'strip2', 'strip3' ],
          text: '<i class="fa fa-file-pdf-o"></i> - Generar PDF',
          className : 'btn btn-xs btn-success outline',
          filename: 'Control de Entrada y Salida de Empleados',
          orientation:'portrait',
          pageSize: 'LEGAL',
          customize: function (doc) {
              var lastColX=null;
              var lastColY=null;
              var bod = []; // this will become our new body (an array of arrays(lines))
              //Loop over all lines in the table
              doc.content[1].table.body.forEach(function(line, i){



                  //Group based on first column (ignore empty cells)
                  if(lastColX != line[0].text && line[0].text != ''){
                      //Add line with group header
                      bod.push([{text:line[0].text, style:'tableHeader'},'','','','','','']);
                      //Update last
                      lastColX=line[0].text;
                  }
                  //Group based on second column (ignore empty cells) with different styling

                  //Add line with data except grouped data

                      bod.push(['',{text:line[1].text, style:'lastLine'},
                                  {text:line[2].text,style:'lastLine'},
                                  {text:line[3].text, style:'lastLine1'},
                                  {text:line[4].text, style:'lastLine'},
                                  {text:line[5].text, style:'lastLine'},
                                  {text:line[6].text, style:'lastLine'}]);


              });
              //Overwrite the old table body with the new one.
              //doc.content[1].table.headerRows = 3;
              doc.content[1].table.widths = [100,45,50, 90, 50, 50,40];
              doc.content[1].table.body = bod;
              doc.content[1].layout = 'lightHorizontalLines';

              doc.styles = {
                  subheader: {
                      fontSize: 9,
                      bold: true,
                      color: '#fff'
                  },
                  tableHeader: {
                      bold: true,
                      fontSize: 12,
                      color: '#187cc7',
                      className : 'bg-primary'
                  },
                  lastLine: {
                      bold: false,
                      fontSize: 9,
                      color: '#696969',
                      top: 2

                  },
                  lastLine1: {
                      bold: false,
                      fontSize: 9,
                      color: '#696969',
                      alignment: 'center',
                      layout: 'lightHorizontalLines'

                  },
                  defaultStyle: {
                  fontSize: 9,
                  color: 'white'
                  }
              }
          }
      }
  ],
               "ordering": false,
              "columnDefs": [
                { "visible": false, "targets": 0 }
              ],
              "order": [[ 0, 'asc' ]],
              "displayLength": 25,
              "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;


                api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                  if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="6">'+group+'</td></tr>'
                    );
                    last = group;
                  }
                } );
              }
            } );

            // Order by the grouping
            $('#example tbody').on( 'click', 'tr.group', function () {
              var currentOrder = table.order()[0];
              if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
                table.order( [ 2, 'desc' ] ).draw();
              }
              else {
                table.order( [ 2, 'asc' ] ).draw();
              }
            } );
          } );
          </script>

          <script>

      /*    document.getElementById("btnPrint").onclick = function() {
    printElement(document.getElementById("printThis"));

    window.print();
}

function printElement(elem, append, delimiter) {
    var domClone = elem.cloneNode(true);

    var $printSection = document.getElementById("printSection");

    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);

    }

    if (append !== true) {
        $printSection.innerHTML = "";
    }

    else if (append === true) {
        if (typeof(delimiter) === "string") {
            $printSection.innerHTML += delimiter;
        }
        else if (typeof(delimiter) === "object") {
            $printSection.appendChlid(delimiter);
        }
    }

    $printSection.appendChild(domClone);
}*/


          </script>


        </body>


        </html>

        <?php
        else :
            echo include(unauthorizedModal());
        endif;
    else:
       echo "<script type='text/javascript'> window.location='../index.ph'; </script>";
    endif;
?>
