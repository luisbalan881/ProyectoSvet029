function asignar_fecha_autorizada(year,mes, solicitud_id,dep_id){
  $.ajax({

    type: "POST",
    url: "combustible/php/asignar_fecha_autorizado.php",
    data: {year:year,mes:mes,solicitud_id:solicitud_id,dep_id:dep_id}, //f de fecha y u de estado.

    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');

                  $('#au_fecha').fadeIn("slow");
                  $('#au_fecha').addClass("fa-refresh fa-spin");
          },
          success:function(data){
            //alert(data);

            setTimeout(function(){
                            $('#au_fecha').fadeOut("slow");
                       }, 500);

             setTimeout(function(){
                            //show_notificacion_success("Cupones asignados");
                            $('#au_fecha').fadeOut("slow");
                            load_solicitud_id(year,mes,solicitud_id,dep_id);
                            get_solicitudes_cupones_list();
                       }, 800);

          }


  }).done( function(data) {










  }).fail( function( jqXHR, textSttus, errorThrown){

    alert(errorThrown);

  });







}
