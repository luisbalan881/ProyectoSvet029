function crear_vehiculo()
{
  jQuery('.js-validation-vehiculo-nuevo').validate({
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

        tipo=$('#tipo').val();
        marca=$('#marca').val();
        linea=$('#linea').val();
        modelo=$('#modelo').val();
        combustible=$('#combustible').val();
        placa=$('#placa').val();
        cilindros=$('#cilindros').val();
        cilindraje=$('#cilindraje').val();
        chasis=$('#chasis_no').val();
        motor=$('#motor_no').val();
        color=$('#color').val();
        capacidad=$('#capacidad').val();
        conductor=$('#conductor').val();
        departamento=$('#dep_id').val();


          $.ajax({
            type: "POST",
            url: "transporte/php/nuevo_vehiculo.php",
            data: { tipo:tipo,
                    marca:marca,
                    linea:linea,
                    modelo:modelo,
                    combustible:combustible,
                    placa:placa,
                    cilindros:cilindros,
                    cilindraje:cilindraje,
                    chasis:chasis,
                    motor:motor,
                    color:color,
                    capacidad:capacidad,
                    conductor:conductor,
                    departamento:departamento}, //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading_ve_nu').fadeIn("slow");
                  },
                  success:function(data){
                    //alert(data);

                    setTimeout(function(){
                                    $('#loading_ve_nu').fadeOut("slow");
                               }, 900);
                     setTimeout(function(){
                                    $('#modal-remoto').modal('hide');
                                    get_vehiculos_list();

                               }, 500);
                               setTimeout(function(){

                                              show_notificacion_success("Vehículo creado");
                                         }, 900);

                  }


          }).done( function() {

          }).fail( function( jqXHR, textSttus, errorThrown){

            alert(errorThrown);

          });
      },
      rules: {
          'placa': {
              remote: {
                  url: 'transporte/validar_placa.php',
                  data: {
                    from: function(){ return $('#placa').val();}


                }
              }
          }




      },
      messages: {
          'placa': {
              remote: "La placa ya existe registrada"
          }
      }

  });
}

function editar_vehiculo(id)
{

  jQuery('.js-validation-vehiculo-modificar').validate({
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


        marca=$('#marca').val();
        linea=$('#linea').val();
        modelo=$('#modelo').val();
        combustible=$('#combustible').val();
        placa=$('#placa').val();
        cilindros=$('#cilindros').val();
        cilindraje=$('#cilindraje').val();
        chasis=$('#chasis_no').val();
        motor=$('#motor_no').val();
        color=$('#color').val();
        capacidad=$('#capacidad').val();
        conductor=$('#conductor').val();
        departamento=$('#dep_id').val();


          $.ajax({
            type: "POST",
            url: "transporte/php/modificar_vehiculo.php",
            data: { id:id,
                    marca:marca,
                    linea:linea,
                    modelo:modelo,
                    combustible:combustible,
                    placa:placa,
                    cilindros:cilindros,
                    cilindraje:cilindraje,
                    chasis:chasis,
                    motor:motor,
                    color:color,
                    capacidad:capacidad,
                    conductor:conductor,
                    departamento:departamento}, //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading_ve_mo').fadeIn("slow");
                  },
                  success:function(data){
                    //alert(data);

                    setTimeout(function(){
                                    $('#loading_ve_mo').fadeOut("slow");
                               }, 900);
                     setTimeout(function(){
                                    $('#modal-remoto').modal('hide');
                                    get_vehiculos_list();

                               }, 500);

                               setTimeout(function(){

                                              show_notificacion_success("Vehículo modificado");
                                         }, 900);

                  }


          }).done( function() {

          }).fail( function( jqXHR, textSttus, errorThrown){

            alert(errorThrown);

          });
      }

  });

}
