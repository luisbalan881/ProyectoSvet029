function crear_conductor()
{
  jQuery('.js-validation-piloto-nuevo').validate({
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

        conductor=$('#conductor').val();
        dep_id=$('#dep_id').val();
        licencia=$('#licencia').val();
        fecha_cad=$('#fecha_cad').val();

          $.ajax({
            type: "POST",
            url: "transporte/php/nuevo_piloto.php",
            data: { conductor:conductor,dep_id:dep_id,licencia:licencia,fecha_cad:fecha_cad}, //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading_pi_nu').fadeIn("slow");
                  },
                  success:function(data){
                    //alert(data);

                    setTimeout(function(){
                                    $('#loading_pi_nu').fadeOut("slow");
                               }, 900);
                     setTimeout(function(){
                                    $('#modal-remoto').modal('hide');
                                    get_drivers_list();

                               }, 500);
                               setTimeout(function(){

                                              show_notificacion_success("Conductor creado");
                                         }, 900);

                  }


          }).done( function() {

          }).fail( function( jqXHR, textSttus, errorThrown){

            alert(errorThrown);

          });
      },
      rules: {
          'conductor': {
              remote: {
                  url: 'transporte/validar_conductor.php',
                  data: {
                    from: function(){ return $('#conductor').val();}


                }
              }
          }




      },
      messages: {
          'conductor': {
              remote: "El empleado ya existe como conductor"
          }
      }

  });
}

function editar_conductor(conductor)
{
  jQuery('.js-validation-piloto-modificar').validate({
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

        dep_id=$('#dep_id').val();
        licencia=$('#licencia').val();
        fecha_cad=$('#fecha_cad').val();

          $.ajax({
            type: "POST",
            url: "transporte/php/modificar_piloto.php",
            data: { conductor:conductor,dep_id:dep_id,licencia:licencia,fecha_cad:fecha_cad}, //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading_pi_nu').fadeIn("slow");
                  },
                  success:function(data){
                    //alert(data);

                    setTimeout(function(){
                                    $('#loading_pi_nu').fadeOut("slow");
                               }, 900);
                     setTimeout(function(){
                                    $('#modal-remoto').modal('hide');
                                    get_drivers_list();

                               }, 500);
                               setTimeout(function(){

                                              show_notificacion_success("Conductor modificado");
                                         }, 900);

                  }


          }).done( function() {

          }).fail( function( jqXHR, textSttus, errorThrown){

            alert(errorThrown);

          });
      }
  });
}
