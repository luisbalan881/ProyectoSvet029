function asignar()
{
  jQuery('.js-validation-asignar').validate({
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
          fecha_per=$('#fecha_per').val();
          $.ajax({
            type: "POST",
            url: "../herramientas/usuarios/php/asignar_permiso_todos.php",
            data: {fecha_per:fecha_per}, //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading').fadeIn("slow");
                  },
                  success:function(data){
                    alert(data);
                    //$("#s_form")[0].reset();
                    setTimeout(function(){
                                    $('#loading').fadeOut("slow");
                               }, 5000);
                     $('#message').fadeIn().html(data);
                     $("#message").addClass('alert alert-success');
                     setTimeout(function(){
                                    $('#message').fadeOut("slow");
                                    $('#loading').fadeOut("slow");
                                    $('#modal-remoto').modal('hide');
                                      //cargar();
                               }, 500);

                  }
                }).done( function() {

                }).fail( function( jqXHR, textSttus, errorThrown){
                  alert(errorThrown);
                });




              },
              rules: {
                  'fecha_per': {
                      remote: {
                          url: 'usuarios/validar_dia_permiso.php',
                          data: {
                            fecha_per: function(){ return $('#fecha_per').val();}

                        }
                      }
                  }
                },


                messages: {
                    'fecha_per': {
                        remote: "La fecha ya fué asignada como permiso o es feriado oficial."
                    }
                  }






  });
}
