function crear_cupones(creador){

      jQuery('.js-validation-cupones').validate({
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

              cupon_i=$('#cupon_i').val();
              cupon_f=$('#cupon_f').val();
              fecha_emi=$('#fecha_emi').val();
              fecha_ven=$('#fecha_ven').val();
              monto=$('#monto').val();

              $.ajax({
                type: "POST",
                url: "combustible/php/crear_cupon.php",
                data: {cupon_i:cupon_i,
                       cupon_f:cupon_f,
                       fecha_emi:fecha_emi,
                       fecha_ven:fecha_ven,
                       monto:monto,
                       creador:creador}, //f de fecha y u de estado.

                beforeSend:function(){
                              //$('#response').html('<span class="text-info">Loading response...</span>');

                              $('#loading_cu').fadeIn("slow");
                      },
                      success:function(data){
                        //alert(data);


                        //$("#en_form")[0].reset();
                        setTimeout(function(){
                                        $('#loading_cu').fadeOut("slow");

                                   }, 5000);
                         $('#message').fadeIn().html(data);
                         $("#message").addClass('alert alert-success');
                         setTimeout(function(){
                                        $('#message').fadeOut("slow");
                                        $('#loading_cu').fadeOut("slow");
                                        $('#modal-remoto').modal('hide');
                                        get_cupones_list();
                                   }, 500);
                                   setTimeout(function(){

                                                  show_notificacion_success("Cupones creados");
                                             }, 900);

                      }


              }).done( function() {










              }).fail( function( jqXHR, textSttus, errorThrown){

                alert(errorThrown);

              });
          },
          rules: {

              'cupon_i': {
                  remote: {
                      url: 'combustible/validar_cupon_mayor.php',
                      data: {
                        cupon_i: function(){ return $('#cupon_i').val();},
                        cupon_f: function(){ return $('#cupon_f').val();}

                    }
                  }
              },
              'cupon_f': {
                  remote: {
                      url: 'combustible/validar_cupon_repetido.php',
                      data: {
                        cupon_i: function(){ return $('#cupon_i').val();},
                        cupon_f: function(){ return $('#cupon_f').val();}

                    }
                  }
              },
              'fecha_ven': {
                  remote: {
                      url: 'combustible/validar_cupon_fecha_mayor.php',
                      data: {
                        fecha_emi: function(){ return $('#fecha_emi').val();},
                        fecha_ven: function(){ return $('#fecha_ven').val();}

                    }
                  }
              },
              'monto': {
                  remote: {
                      url: 'combustible/validar_monto_nuevo_cupon.php',
                      data: {
                        monto: function(){ return $('#monto').val();}


                    }
                  }
              }



          },
          messages: {

              'cupon_i': {
                  remote: "El cupón final no debe ser menor al inicial."
              },
              'cupon_f': {
                  remote: "Está ingresando un cupón repetido."
              },
              'fecha_ven': {
                  remote: "La fecha de Vencimiento no puede ser menor a la fecha de emisión."
              },
              'monto': {
                  remote: "Debe ser 50 o 100 Quetzales."
              }
          }

      });

}
