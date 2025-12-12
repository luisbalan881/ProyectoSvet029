function insertData(id, creado_por){

      jQuery('.js-validation-iggs').validate({
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
              codigo=id;
              vid=$('#codigo').val();
              user_id=creado_por;
              from=$('#from').val();
              to=$('#to').val();
              resolucion=$('#resolucion').val();
              dia=$('#dia').val();
              sus_desc=$('#sus_desc').val();
              $.ajax({
                type: "POST",
                url: "../herramientas/usuarios/php/crear_suspencion.php",
                data: {codigo:codigo,
                  user_id:creado_por,
                  vid:vid,
                  from:from,
                  to:to,
                  resolucion:resolucion,
                  dia:dia,
                  sus_desc:sus_desc}, //f de fecha y u de estado.

                beforeSend:function(){
                              //$('#response').html('<span class="text-info">Loading response...</span>');

                              $('#loading').fadeIn("slow");
                      },
                      success:function(data){
                        //alert(data);
                        $("#s_form")[0].reset();
                        setTimeout(function(){
                                        $('#loading').fadeOut("slow");
                                   }, 5000);
                         $('#message').fadeIn().html(data);
                         $("#message").addClass('alert alert-success');
                         setTimeout(function(){
                                        $('#message').fadeOut("slow");
                                        $('#loading').fadeOut("slow");
                                        $('#modal-remoto').modal('hide');
                                          cargar();
                                   }, 500);

                      }


              }).done( function() {










              }).fail( function( jqXHR, textSttus, errorThrown){

                alert(errorThrown);

              });
          },
          rules: {
              'from': {
                  remote: {
                      url: 'usuarios/validar_fecha_suspencion.php',
                      data: {
                        from: function(){ return $('#from').val();},
                        codigo: function(){ return $('#codigo').val();}

                    }
                  }
              },

              'resolucion': {
                  remote: {
                      url: 'usuarios/validar_resolucion_suspencion.php',
                      data: {
                        from: function(){ return $('#resolucion').val();},

                    }
                  }
              }




          },
          messages: {
              'from': {
                  remote: "La fecha no existe en los horarios."
              },
              'resolucion':{
                remote: "La resolución ya existe."
              }
          }

      });

}
