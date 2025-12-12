function asignar_cupones(creador) {
  jQuery('.js-validation-asignar-cupones').validate({
      ignore: [],
      errorClass: 'help-block animated fadeInDown',
      errorElement: 'div',
      errorPlacement: function(error, e) {
          jQuery(e).parents('.form-group > div').append(error);
      },
      highlight: function(e) {
          var elem = jQuery(e);

          elem.closest('.form-group').removeClass('has-error').addClass('has-error');
          elem.closest('.help-block').remove();
          $("#boton_s_t").removeClass('vibrar').addClass('vibrar');
      },
      success: function(e) {
          var elem = jQuery(e);

          elem.closest('.form-group').removeClass('has-error');
          $("#boton_a_v").removeClass('vibrar');
          elem.closest('.help-block').remove();


      },
      submitHandler: function(form){
        //alert('OK');

        fecha_asi=$('#fecha_asi').val();
        conductor_id=$('#conductor_id').val();
        vehiculo_id=$('#vehiculo').val();


          $.ajax({

            type: "POST",
            url: "combustible/php/vehiculo_cupones.php",
            data: {vehiculo_id:vehiculo_id,conductor_id:conductor_id,fecha_asi:fecha_asi,creador:creador}, //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading_ascv').fadeIn("slow");
                  },
                  success:function(data){
                    //alert(data);



                    var selected =$("#cupones option:selected");
                      var message = "";
                    selected.each(function () {
                      var cupon_id = $(this).val();

                          //alert(message);



                          var inst = $(this).val();
                          //vp_solicitud_transporte_departamento
                          $.ajax({

                            type: "POST",
                            url: "combustible/php/asignar_cupones.php",
                            data: {cupon_id:cupon_id,vehiculo_id:vehiculo_id,creador:creador,fecha_asi:fecha_asi}, //f de fecha y u de estado.

                            beforeSend:function(){
                                          //$('#response').html('<span class="text-info">Loading response...</span>');

                                          $('#loading_ascv').fadeIn("slow");
                                  },
                                  success:function(data){
                                    //alert(data);

                                    setTimeout(function(){
                                                    $('#loading_ascv').fadeOut("slow");
                                               }, 500);

                                     setTimeout(function(){
                                                    show_notificacion_success("Cupones asignados");
                                                    $('#loading_ascv').fadeOut("slow");
                                                    $('#modal-remoto').modal('hide');
                                                      //get_horarios_usuario();
                                                      get_cupones_usados_list();
                                               }, 800);

                                  }


                          }).done( function(data) {










                          }).fail( function( jqXHR, textSttus, errorThrown){

                            alert(errorThrown);

                          });





                    });







                  }


          }).done( function() {










          }).fail( function( jqXHR, textSttus, errorThrown){

            alert(errorThrown);

          });




          //SOLICITUD Departamentos
















      }/*,

    rules: {
      'soli_fecha': {
          remote: {
              url: 'transporte/validar_fecha.php',
              data: {
                from: function(){ return $('#soli_fecha').val();},

            }
          }
        }
    },
    messages: {

          'soli_fecha': {
              remote: "La fecha no existe en los horarios."
          }

    }*/


  });

}
