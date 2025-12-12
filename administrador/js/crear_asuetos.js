$(function(){
  $('#save').click(function(){

$.each($('input[type=checkbox]:not(:checked)'), function(){

  var f = ($(this).data('id'));
  var u;




         u = 0;



  $.ajax({



    type: "POST",

    url: "../herramientas/administrador/scripts_php/generar_horarios.php",

    data: {f:f, u:u}, //f de fecha y u de estado.
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
               }, 500);






  }).fail( function( jqXHR, textSttus, errorThrown){

    alert(errorThrown);

  });




});

$.each($('input[type=checkbox]:checked'), function(){

  var f = ($(this).data('id'));
  var u;




         u = 3;



    $.ajax({



      type: "POST",

      url: "../herramientas/administrador/scripts_php/generar_horarios.php",

      data: {f:f, u:u}, //f de fecha y u de estado.
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
                 }, 500);






    }).fail( function( jqXHR, textSttus, errorThrown){

      alert(errorThrown);

    });

});











  }); //fin click boton
});//fin función
