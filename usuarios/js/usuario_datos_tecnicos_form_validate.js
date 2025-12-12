function asignar_datos_tecnicos(creador, empleado){

      jQuery('.js-datos-tecnicos').validate({
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
              emp=empleado;
              creador=creador;
              user_vid=$('#user_vid').val();
              ext_id=$('#ext_id').val();
              role_id=$('#role_id').val();
              user_mail=$('#user_mail').val();

              $.ajax({
                type: "POST",
                url: "usuarios/php/asignar_datos_tecnicos_empleado.php",
                data: {emp:emp,
                  creador:creador,
                  user_vid:user_vid,
                  ext_id:ext_id,
                  role_id:role_id,
                  user_mail:user_mail
              }, //f de fecha y u de estado.

                beforeSend:function(){
                              //$('#response').html('<span class="text-info">Loading response...</span>');

                              $('#loading_mous').fadeIn("slow");
                      },
                      success:function(data){
                        //alert(data);
                        //$("#su_form")[0].reset();
                        setTimeout(function(){
                                        $('#loading_mous').fadeOut("slow");
                                   }, 5000);
                         $('#message').fadeIn().html(data);
                         $("#message").addClass('alert alert-success');
                         setTimeout(function(){
                                        $('#message').fadeOut("slow");
                                        $('#loading_mous').fadeOut("slow");
                                        $('#modal-remoto').modal('hide');
                                          //cargar();
                                   }, 900);

                      }


              }).done( function() {










              }).fail( function( jqXHR, textSttus, errorThrown){

                alert(errorThrown);

              });
          }

      });

}

function verificar(user,emp,estado){


          //regformhash(form,form.password,form.confirmpwd);
          //id=u_id;
          emp=emp;
          user:user;
          //alert(emp+ ' ' + user)





          $.ajax({
            type: "POST",
            url: "usuarios/php/verificar_empleado.php",
            data: {
            emp:emp,
            user:user,
            estado:estado
          }, //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading_verificar').fadeIn("slow");
                  },
                  success:function(data){
                    //alert(data);
                    //$("#em_form")[0].reset();
                    setTimeout(function(){
                                    $('#loading_verificar').fadeOut("slow");
                                    //cargar();
                               }, 3000);
                     $('#message').fadeIn().html(data);
                     $("#message").addClass('alert alert-success');
                     setTimeout(function(){
                                    $('#message').fadeOut("slow");
                                    $('#loading_verificar').fadeOut("slow");
                                    $('#modal-remoto').modal('hide');

                               }, 2000);

                  }


          }).done( function() {










          }).fail( function( jqXHR, textSttus, errorThrown){

            alert(errorThrown);

          });


}
