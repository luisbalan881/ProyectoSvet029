
$(document).ready(function() {

  var table = $('#cupones_us_listado').DataTable({
    initComplete: function () {

      this.api().columns().every(function () {
        var column = this;
        if (column.index() == 0 || column.index() == 1 || column.index() == 2 || column.index() == 3 || column.index() == 4 || column.index() == 7 || column.index() == 8 || column.index() == 9) {
          return 'hola';
        }

        var select = $('<select class="form-control" style="width:100px"><option value=""></option></select>')
        .appendTo($("#filters").find("th").eq(column.index()))
        .on('change', function () {
          var val = $.fn.dataTable.util.escapeRegex(
            $(this).val());
            column.search(val ? '' + val + '$' : '', true, false)
            .draw();
          });
          console.log(select);
          column.data().unique().sort().each(function (d, j) {
            select.append('<option value="' + d + '">' + d + '</option>')
          });
        });
      },
      dom: '<"row"<"col-sm-2"><"col-sm-2">>' +
      '<"row"<"col-sm-12"<"table-responsive"tr>>>' +
      '<"row"<"col-sm-5"i><"col-sm-7"p>>',

      "ordering": false,
      "info":     false,
      "search": true,
      "searching": true,
      "pageLength": 100,

      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
      buttons: [
        {
          extend: 'print',
          text: '<i class="fa fa-print" style=""> </i> Imprimir',
          className : 'btn btn-xs btn-secondary text-right',
          orientation: 'landscape',

          autoPrint: true,
          customize: function ( win ) {
            $(win.document.body)
            .css( 'font-size', '10pt' )
            .prepend(
              //'<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
            );
            $(win.document.body).find( 'table' )
            .addClass( 'compact' )
            .css( 'font-size', 'inherit' );
          }
        }
      ]
    });





  // Order by the grouping


} );

function imprimir(mes,mes2, m_n, year){
var div = document.querySelector("#para_print");
imprimirElemento(div, mes, mes2,m_n,year);
}
function imprimirElemento(elemento,mes, mes2, m_n,year) {

  var sum=0

$(".cell").each(function(i) {
    sum = sum + parseInt($(this).text());
});


var ventana = window.open('', 'PRINT', 'height=' + screen.height + ',width=' + screen.width);
ventana.document.write('<html><head><title>' + document.title + '</title>');

ventana.document.write('<link rel="stylesheet" href="../herramientas/assets/css/bootstrap.min.css">');
/*ventana.document.write('<link rel="stylesheet" href="../herramientas/assets/css/oneui.css">');*/
ventana.document.write('<style>@page{size: 8.5in 13.4in; margin: 5mm 5mm 5mm 5mm;}@media print{h1{position:fixed}.label{border:1px solid transparent;padding:.0em .0em .0em .0em; text-align:right;font-size:8.5px}#filters{display: none;}.pagination{display: none;}#cupones_us_listado {    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;    border-collapse: collapse;    width: 100%;}#cupones_us_listado td, #cupones_us_listado th {    border: 1px solid transparent; padding: 8px;}#cupones_us_listado tr:nth-child(even){background-color: #f9f9f9}#cupones_us_listado tr:hover {background-color: #ddd;}#cupones_us_listado th {    padding-top: 12px;    padding-bottom: 12px;    text-align: center;    background-color: #006c87;    border-bottom:1px solid #006c87; border-top:1px solid #006c87;    color: white; font-weight:normal} td{font-size:8.5px; border-bottom:1px solid #ccc} thead{font-size:10px;text-align:center}th{float:center; height:3em;font-size:10px;text-align:center}h1{font-size:18px;font-family:Arial;font-weight:normal;position:relative;} thead{border-radius:2px} td{text-align:right;border:1px solid transparent}tfoot{display:none}</style>'); //Cargamos otra hoja, no la normal
ventana.document.write('</head><body >');
//ventana.document.write('<div class="row"><div class="col-sm-4"><img src="../herramientas/assets/img/logo_vp_little.png" style="display:inline-block"></img></div>');
ventana.document.write('<div class="col-sm-8"><h1 id="heading">Control de Cupones correspondiente del 1 de '+ mes +' al '+lastday(year,m_n-1)+' de '+ mes2 +' del '+ year + ' </h1></div></div>');
ventana.document.write(elemento.innerHTML);
ventana.document.write('<br><h4 style="float:right">Total: Q '+sum+' </h4><br><br');
ventana.document.write('</body></html>');
ventana.document.close();
ventana.focus();
ventana.onload = function() {
ventana.print();
ventana.close();
};
return true;
}

var lastday = function(y,m){
return  new Date(y, m +1, 0).getDate();
}
