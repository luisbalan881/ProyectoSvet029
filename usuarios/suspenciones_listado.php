<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')) :
            $id = null;
            $vid = null;
            $persona = array();
            $sus = array();


            date_default_timezone_set('America/Guatemala');




                //$persona = User::getByUserId($id);
                $sus = User::get_userlist_suspenciones();






        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title> - Control de Ausencias</title>



        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">


            <div class="block-content">

              <div class="tag-green">Listado de Suspenciones</div>
              <div class="">
                  <ul class="block-options2" style="margin-top:-40px;">
                      <li>
                          <button data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                      </li>
                  </ul>


              </div>

              <form class="js-validation-iggs form-horizontal push-10-t push-10" >


                <div class="form-group">
                    <div class="col-xs-12">



                    <table id="suspenciones1" name="suspenciones" class="print table-bordered table-condensed table-striped js-dataTable-usuariosH-general dt-responsive display nowrap" cellspacing="0" width="100%" style="margin-left:auto; margin-right:auto;">
                      <thead >
                              <tr>
                                <th class="text-center" >Nombre</th>
                                <th class="text-center" >Departamento</th>
                                <th class="text-center" >Resolución</th>
                                <th class="text-center" >Descripción</th>
                                <th class="text-center" >Suspención</th>
                                <th class="text-center" >Fecha Inicial</th>
                                <th class="text-center" >Fecha Final</th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php

                              foreach ($sus as $s){
                                echo '<tr>';

                                  //echo '<td class="text-center">'.$p['NOMBRE'].'</td>';
                                  echo '<td class="text-left">'.$s['nombre'].'</td>';
                                  echo '<td class="text-center">'.$s['dep'].'</td>';

                                  echo '<td class="text-center">'.$s['a'].'</td>';
                                  echo '<td class="text-center">'.$s['b'].'</td>';
                                  echo '<td class="text-center">'.$s['c'].'</td>';
                                  echo '<td class="text-center">'.fecha_dmy($s['d']).'</td>';
                                  echo '<td class="text-center">'.fecha_dmy($s['e']).'</td>';

                                  /*echo '<td class="text-center">'.(($p['E'] == '0')? '<span class="label label-danger">Llegó Tarde</span>':'<span class="label label-info"></span>').'</td>';
                                  echo '<td class="text-center">'.(($p['S'] == '1')? '<span class="label label-danger">Se fue temprano</span>':'<span class="label label-info"></span>').'</td>';*/

                                  echo '</tr>';
                              }
                              ?>
                      </tbody>

                    </table>
                    </div>

                </div>

              </form>
            </div>

          </div>
          <!-- Page JS Code -->
          <script>

          </script>

          <script>
              
          </script>
          <script src="assets/js/pages/usuarios_forms_validation.js"></script>

          <script>
          $(document).ready(function() {
            var table = $('#suspenciones1').DataTable({
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
          filename: 'Control de Suspenciones del IGGS',
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
              doc.content[1].table.widths = [100,45,30, 90, 50, 50,50];
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
                        '<tr class="group1"><td colspan="6">'+group+'</td></tr>'
                    );
                    last = group;
                  }
                } );
              }
            } );

            // Order by the grouping
            $('#suspenciones1 tbody').on( 'click', 'tr.group1', function () {
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



          <script src="assets/js/pages/usuarios_forms_validation.js"></script>
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
