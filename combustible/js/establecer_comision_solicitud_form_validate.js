function establecer_comision(year,mes,solicitud_id,dep_id,estado,status){
  //alert(mes);
      jQuery('.js-validation-comision').validate({
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
              var comision_id=$('#comision_idd').val();


              $.ajax({
                type: "POST",
                url: "combustible/php/establecer_comision_solicitud.php",
                data: {
                       year:year,
                       mes:mes,
                       solicitud_id:solicitud_id,
                       comision_id:comision_id,
                       dep_id:dep_id
                     }, //f de fecha y u de estado.

                beforeSend:function(){
                              //$('#response').html('<span class="text-info">Loading response...</span>');

                              $('#loading_com_soli').fadeIn("slow");
                      },
                      success:function(data){
                        alert(data);


                        //$("#en_form")[0].reset();
                        setTimeout(function(){
                                        $('#loading_com_soli').fadeOut("slow");
                                        //show_notificacion_success("Kilómetros establecidos");

                                   }, 900);
                         $('#message').fadeIn().html(data);
                         $("#message").addClass('alert alert-success');
                         setTimeout(function(){
                                        $('#message').fadeOut("slow");
                                        $('#loading_cu').fadeOut("slow");
                                        $('#modal-remoto').modal('hide');
                                        get_solicitudes_cupones_list();

                                        get_transporte_por_cupones(year,mes,solicitud_id,dep_id,estado,status);
                                        //get_solicitud_vehiculo_by_id(year,mes,solicitud_id,vehiculo_id,dep_id);
                                   }, 900);

                      }


              }).done( function() {










              }).fail( function( jqXHR, textSttus, errorThrown){

                alert(errorThrown);

              });
          }

      });

}

function get_transporte_por_cupones(year,mes,solicitud_id,dep_id,estado,status)
{
  $('#retornar_1').fadeIn(1000);
  $.post("combustible/php/get_solicitud_cupon_comision.php",
  { year:year,mes:mes,solicitud_id:solicitud_id,dep_id:dep_id,estado:estado,status:status},
   function(data){
  $("#tema").fadeOut(0).html(data).fadeIn(600);
  //mostrar_tabla();
  });
}

function agregar_comision_solicitud(year,mes,solicitud_id,dep_id,estado,status)
{
  $('#retornar_1').hide();
  $.post("combustible/php/agregar_comision_cupones.php",
  { year:year,mes:mes,solicitud_id:solicitud_id,dep_id:dep_id,estado:estado,status:status},
   function(data){
  $("#tema").fadeOut(0).html(data).fadeIn(600);
  //mostrar_tabla();
  });
}
