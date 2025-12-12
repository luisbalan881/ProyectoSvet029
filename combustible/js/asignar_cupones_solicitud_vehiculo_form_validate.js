function asignar_cupones(year,mes,solicitud_id,vehiculo_id,monto,dep_id)
{
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
          //$("#boton_s_t").removeClass('vibrar').addClass('vibrar');
      },
      success: function(e) {
          var elem = jQuery(e);

          elem.closest('.form-group').removeClass('has-error');
          //$("#boton_a_v").removeClass('vibrar');
          elem.closest('.help-block').remove();


      },
      submitHandler: function(form){
        //alert('OK');

        var suma=0;
        var selected =$("#cupones option:selected");
          var message = "";
        selected.each(function () {
          var cupon_id = $(this).text();
          cupon_id = cupon_id.substring(cupon_id.indexOf("-") + 1);

          suma+=parseFloat(cupon_id);


          //alert(cupon_id);
        });

        if(monto==suma)
        {


                      var selected =$("#cupones option:selected");
                        var message = "";
                      selected.each(function () {
                        var cupon_id = $(this).val();

                            //alert(message);



                            var inst = $(this).val();
                            //vp_solicitud_transporte_departamento
                            $.ajax({

                              type: "POST",
                              url: "combustible/php/asignar_cupones_vehiculo.php",
                              data: {year:year,mes:mes,solicitud_id:solicitud_id,vehiculo_id:vehiculo_id,cupon_id:cupon_id,dep_id:dep_id}, //f de fecha y u de estado.

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
                                                      //show_notificacion_success("Cupones asignados");
                                                      $('#loading_ascv').fadeOut("slow");
                                                      $('#modal-remoto').modal('hide');
                                                      get_solicitudes_cupones_list();
                                                        //get_horarios_usuario();

                                                 }, 800);

                                    }


                            }).done( function(data) {










                            }).fail( function( jqXHR, textSttus, errorThrown){

                              alert(errorThrown);

                            });





                      });
                      load_solicitud_id(year,mes,solicitud_id,dep_id);







        }
        else
        {
          //alert(suma);
          show_notificacion("La suma de los cupones debe ser igual al monto solicitado");
        }








          //SOLICITUD Departamentos
















      }


  });




}
