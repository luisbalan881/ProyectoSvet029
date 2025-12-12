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
        buttons: [
{ text:'PDF',
    extend: 'pdf',
    footer : true,
    header : true,
    text: 'Generar PDF',
    filename: 'Control de Entrada y Salida de Empleados',
    orientation:'portrait',
    customize: function (doc) {
        var lastColX=null;
        var lastColY=null;
        var bod = []; // this will become our new body (an array of arrays(lines))
        //Loop over all lines in the table
        doc.content[1].table.body.forEach(function(line, i){



            //Group based on first column (ignore empty cells)
            if(lastColX != line[0].text && line[0].text != ''){
                //Add line with group header
                bod.push([{text:line[0].text, style:'tableHeader'},'','','','','']);
                //Update last
                lastColX=line[0].text;
            }
            //Group based on second column (ignore empty cells) with different styling

            //Add line with data except grouped data

                bod.push(['',{text:line[1].text, style:'lastLine'},
                            {text:line[2].text,style:'lastLine'},
                            {text:line[3].text, style:'lastLine'},
                            {text:line[4].text, style:'lastLine'},
                            {text:line[5].text, style:'lastLine'}]);


        });
        //Overwrite the old table body with the new one.
        //doc.content[1].table.headerRows = 3;
        doc.content[1].table.widths = [80,50,120, 50, 50, 80];
        doc.content[1].table.body = bod;
        doc.content[1].layout = 'lightHorizontalLines';

        doc.styles = {
            subheader: {
                fontSize: 10,
                bold: true,
                color: 'black'
            },
            tableHeader: {
                bold: true,
                fontSize: 10.5,
                color: 'black'
            },
            lastLine: {
                bold: true,
                fontSize: 11,
                color: 'gray'
            },
            defaultStyle: {
            fontSize: 10,
            color: 'black'
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
                  '<tr class="group"><td colspan="5">'+group+'</td></tr>'
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
