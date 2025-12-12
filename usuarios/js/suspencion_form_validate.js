function insertData(id, creado_por){

      jQuery('.js-validation-iggss').validate({
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
                data: {codigo:codigo,user_id:creado_por,vid:vid,from:from,to:to,resolucion:resolucion,dia:dia,sus_desc:sus_desc}, //f de fecha y u de estado.

                beforeSend:function(){
                              //$('#response').html('<span class="text-info">Loading response...</span>');

                              $('#loading').fadeIn("slow");
                      },
                      success:function(data){
                        //alert(data);
                        show_notificacion_success("Aunsencia generada");
                        $("#s_form")[0].reset();
                        setTimeout(function(){
                                        $('#loading').fadeOut("slow");
                                   }, 5000);
                         $('#message').fadeIn().html(data);
                         $("#message").addClass('alert alert-success');
                         setTimeout(function(){
                                        $('#message').fadeOut("slow");
                                        $('#loading').fadeOut("slow");
                                        mostrar_tabla();
                                        get_suspenciones_list(id,creado_por);
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
                        from: function(){ return $('#resolucion').val();}

                    }
                  }
              },
              'to': {
                  remote: {
                      url: 'usuarios/validar_cantidad_dias_vacacionales.php',
                      data: {
                        from: function(){ return $('#from').val();},
                        to: function(){ return $('#to').val();},
                        codigo: function(){ return $('#codigo').val();},
                        dia: function(){ return $('#dia').val();},
                        user_id: id

                    }
                  }
              },
              'dia': {
                  remote: {
                      url: 'usuarios/validar_periodo_vacacional.php',
                      data: {
                        dia: function(){ return $('#dia').val();},
                        codigo: id

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
              },
              'to':{
                remote: "La cantidad de dias solicitados excede a los días pendientes del período disponible."
              },
              'dia':{
                remote: "El empleado no tiene dias vacacionales disponibles. (No ha cumplido período vacacional)"
              }
          }

      });

}


/*$('#from').datepicker()
.on('changeDate', function(e) {
// `e` here contains the extra attributes
from = $('#from').val();
to =$('#to').val();

$.ajax({
  type: "POST",
  url: "usuarios/php/get_dias_para_ausencia.php",
  data: {user_vid:158,from:from,to:to}, //f de fecha y u de estado.

  beforeSend:function(){
                //$('#response').html('<span class="text-info">Loading response...</span>');

                $('#loading').fadeIn("slow");
        },
        success:function(data){
          alert(data);

          $('#calendario').html(data);

        }


}).done( function() {










}).fail( function( jqXHR, textSttus, errorThrown){

  alert(errorThrown);

});
});

$('#to').datepicker()
.on('changeDate', function(e) {
// `e` here contains the extra attributes
from = $('#from').val();
to =$('#to').val();

});*/


  $('#from').datepicker()
  .on('changeDate', function(e) {

  var from = $('#from').val();
  var to =$('#to').val();
  user_vid=$('#codigo').val();

  $.ajax({
    type: "POST",
    url: "usuarios/php/get_dias_para_ausencia.php",
    data: {user_vid:user_vid,from:from,to:to}, //f de fecha y u de estado.

    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');


          },
          success:function(data){
            //alert(data);

            $('#calendario').html(data);

          }


  }).done( function() {


  }).fail( function( jqXHR, textSttus, errorThrown){

    alert(errorThrown);

  });
});

$('#to').datepicker()
.on('changeDate', function(e) {

var from = $('#from').val();
var to =$('#to').val();
user_vid=$('#codigo').val();

$.ajax({
  type: "POST",
  url: "usuarios/php/get_dias_para_ausencia.php",
  data: {user_vid:user_vid,from:from,to:to}, //f de fecha y u de estado.

  beforeSend:function(){
                //$('#response').html('<span class="text-info">Loading response...</span>');


        },
        success:function(data){
          //alert(data);

          $('#calendario').html(data);

        }


}).done( function() {


}).fail( function( jqXHR, textSttus, errorThrown){

  alert(errorThrown);

});
});
