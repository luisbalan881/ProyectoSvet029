function asignar_kilometros(year,mes,solicitud_id,vehiculo_id,dep_id){
  //alert(mes);
      jQuery('.js-validation-kilometros').validate({
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
          },
          success: function(e) {
              var elem = jQuery(e);

              elem.closest('.form-group').removeClass('has-error');
              elem.closest('.help-block').remove();
          },
          submitHandler: function(form){
              //regformhash(form,form.password,form.confirmpwd);
              //id=u_id;

              //alert(mes);

              kilometro_i=$('#km_ini').val();
              kilometro_f=$('#km_fin').val();
              galones=$('#galones').val();
              destino=$('#destino').val();

              $.ajax({
                type: "POST",
                url: "combustible/php/agregar_kilometros.php",
                data: {kilometro_i:kilometro_i,
                       kilometro_f:kilometro_f,
                       galones:galones,
                       destino:destino,
                       year:year,
                       mes:mes,
                       solicitud_id:solicitud_id,
                       vehiculo_id:vehiculo_id,
                       dep_id:dep_id
                     }, //f de fecha y u de estado.

                beforeSend:function(){
                              //$('#response').html('<span class="text-info">Loading response...</span>');

                              $('#loading_as_k').fadeIn("slow");
                      },
                      success:function(data){
                        //alert(data);


                        //$("#en_form")[0].reset();
                        setTimeout(function(){
                                        $('#loading_as_k').fadeOut("slow");
                                        //show_notificacion_success("Kilómetros establecidos");

                                   }, 2000);
                         $('#message').fadeIn().html(data);
                         $("#message").addClass('alert alert-success');
                         setTimeout(function(){
                                        $('#message').fadeOut("slow");
                                        $('#loading_cu').fadeOut("slow");
                                        $('#modal-remoto').modal('hide');
                                        get_solicitud_vehiculo_by_id(year,mes,solicitud_id,vehiculo_id,dep_id);
                                   }, 2000);

                      }


              }).done( function() {










              }).fail( function( jqXHR, textSttus, errorThrown){

                alert(errorThrown);

              });
          }/*,
          rules: {
              'km_ini': {
                  remote: {
                      url: 'combustible/validar_kilometro_mayor.php',
                      data: {
                        km_ini: function(){ return $('#km_ini').val();},
                        km_fin: function(){ return $('#km_fin').val();}

                    }
                  }
              }



          },
          messages: {
              'km_ini': {
                  remote: "El Kilómetro final no debe ser menor al inicial."
              }
          }*/

      });

}
