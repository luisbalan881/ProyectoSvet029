$(document).ready(function(){
   $("#mes").change(function () {
       $("#year option:selected").each(function (){
           elegidoy=$(this).val();
           $("#mes option:selected").each(function () {
            elegido=$(this).val();
            $.post("../herramientas/administrador/scripts_php/dias_meses.php", { elegido: elegido, elegidoy : elegidoy }, function(data){
            $("#fechas").fadeOut(0).html(data).fadeIn(500);
            $("#save").show();
            });
           });
        });
   })
});



function get_horarios_usuario(){

       $("#y option:selected").each(function (){
           yy=$(this).val();
           $("#m option:selected").each(function () {
            mm=$(this).val();

            $("#empleado option:selected").each(function (){
              em=$(this).val();



                  $.post("../herramientas/administrador/scripts_php/get_horarios_user.php",
                  { mm: mm, yy : yy, em:em },
                  function (data){
                  $("#horarios").fadeOut(0).html(data).fadeIn(500);
                  $("#save").show();
                  });






              });

           });
        });

}



function update_tipo_date(us, fe){

  $("#dia option:selected").each(function (){
    di=$(this).val();


  $.ajax({



    type: "POST",
    url: "../herramientas/administrador/scripts_php/update_control_usuario.php",
    data: {us:us, fe:fe, di:di}, //f de fecha y u de estado.

    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');

                  $('#loading').fadeIn("slow");
          },
          success:function(data){
            //alert(data);
          }


  }).done( function() {



    setTimeout(function(){
                    $('#loading').fadeOut("slow");
               }, 500);
     $('#message').fadeIn().html('Datos Guardados');
     $("#message").addClass('alert alert-success');
     setTimeout(function(){
                    $('#message').fadeOut("slow");
                    $('#loading').fadeOut("slow");
                    $('#modal-remoto').modal('hide');
                      get_horarios_usuario();
               }, 500);






  }).fail( function( jqXHR, textSttus, errorThrown){

    alert(errorThrown);

  });




});

}









function getComboA(selectObject) {
    var value = selectObject.value;
}


function load_modal(id, fee)
{
    var $modal = $('#modal-remoto');
    $modal.load('administrador/control_modificar.php', {'id':id, 'fee':fee},
    function(){
      $modal.modal('show');

  });

}









function insertDatas() {


        var diasSeleccionados = new Array();

        $('input[type=checkbox]:checked').each(function() {
            diasSeleccionados.push($(this).val() + ' : 1');
        });

        alert("Dias seleccionados => " + diasSeleccionados);



}
