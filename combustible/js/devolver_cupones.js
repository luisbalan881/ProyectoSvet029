function devolver_cupon_vehiculo(year,mes,solicitud_id,vehiculo_id,cupon_id,dep_id){
  if(confirm('¿Desea devolver este cupón?'))
  $.ajax({

    type: "POST",
    url: "combustible/php/update_devolver_cupones.php",
    data: {year:year,mes:mes,solicitud_id:solicitud_id,vehiculo_id:vehiculo_id,cupon_id:cupon_id,dep_id:dep_id}, //f de fecha y u de estado.

    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');

                  $('#loading_ascv').fadeIn("slow");
          },
          success:function(data){
            //alert(data);


                            //show_notificacion_success("Cupones asignados");
                            /*$('#loading_ascv').fadeOut("slow");
                            $('#modal-remoto').modal('hide');*/
                            get_solicitudes_cupones_list();
                            load_devolver_vehiculo(year,mes,solicitud_id,vehiculo_id,dep_id)

                              //get_horarios_usuario();



          }


  }).done( function(data) {










  }).fail( function( jqXHR, textSttus, errorThrown){

    alert(errorThrown);

  });


}
