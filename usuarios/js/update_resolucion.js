

function mostrar(id,vid)
{

  $('#titulo').text('Modificar Resolución');

  $.ajax({
    type: "POST",
    url: "usuarios/php/get_user_suspencion_modificar.php",
    dataType:'json',
    data:{emp:vid,resolucion:id},


    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');

                  $('#loading').fadeIn(0);
          },
          success:function(data){
            //alert(data.fecha_ini);
            $('#resolucion1').val(data.resolucion);
            $('#descripcion1').val(data.descripcion);
            $('#from1').datepicker('setDate',data.fecha_ini);
            $('#to1').datepicker('setDate',data.fecha_fin);

            $('#regreso').datepicker('setDate',data.fecha_regreso);
            $('#fecha_no').datepicker('setDate',data.fecha_notificacion);
            $('#dia1').val(data.tipo_suspencion);



          }


  }).done( function() {

  }).fail( function( jqXHR, textSttus, errorThrown){

    console.log(errorThrown);

  });
}
function cargar_formulario(resolucion,vid){
  $.post("usuarios/suspencion_modificar.php",
  { resolucion:resolucion,vid:vid},
   function(data){
  $("#lista").fadeOut(0).html(data).fadeIn(600);
  mostrar(resolucion,vid);
    });
}
function cargar_forumulario_nueva_ausencia(user_id){
  $.post("usuarios/crear_ausencia_user.php",
  { user_id:user_id},
   function(data){
  $("#lista").fadeOut(0).html(data).fadeIn(600);

    });
}
function mostrar_tabla()
{

  $('#suspenciones').fadeIn(900).show();
  $('#periodo').fadeIn(600).show();
  $('#titulo').text('Ausencias');
}

function mostrar_peridos(){
  $('#formulario').fadeOut(600).hide();
  $('#regresar').fadeOut(600).hide();
  $('#periodo').fadeOut(600).hide();
  $('#back').fadeIn(600).show();
  $('#agregar_periodo').fadeIn(600).show();
  $('#back2').fadeOut(600).hide();
  $('#titulo').text('Períodos Vacacionales');
  $('#xx').removeClass('contorno');
}

function mostrar_perido2(){
  $('#formulario').fadeOut(600).hide();
  $('#regresar2').fadeOut(600).hide();
  $('#back').fadeOut(600).hide();
  $('#back2').fadeIn(600).show();
  $('#agregar_periodo').fadeIn(600).hide();
  $('#titulo').text('Detalle del Período');
}

function get_suspenciones_list(id,jefe)
{
  $.post("usuarios/php/get_user_suspenciones.php",
  { id:id,jefe:jefe },
   function(data){
  $("#lista").fadeOut(0).html(data).fadeIn(600);
  mostrar_tabla();
  });
}





function actualizar_resolucion()
{

  jQuery('.js-validation-suspencion_modificar').validate({
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
          var r=$('#resolucion1').val();
          var d=$('#descripcion1').val();
          var fi=$('#from1').val();
          var ff=$('#to1').val();
          var fr=$('#regreso').val();
          var fn=$('#fecha_no').val();
          var t=$('#dia1').val();
          var id=$('#codigo_u').val();
          var jefe=$('#codigo_jefe').val();

          $.ajax({
            type: "POST",
            url: "usuarios/php/update_resolucion.php",
            data:{r:r,d:d,fi:fi,ff:ff,fr:fr,fn:fn,id:id,t:t},

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading5').fadeIn(0);
                  },
                  success:function(data){
                    //alert(data);

                    setTimeout(function(){
                                    $('#loading5').fadeOut("slow");
                               }, 5000);
                     $('#message').fadeIn().html(data);
                     $("#message").addClass('alert alert-success');
                     setTimeout(function(){
                                    $('#message').fadeOut("slow");
                                    $('#loading5').fadeOut("slow");
                                    //$('#modal-remoto').modal('hide');
                                      mostrar_tabla();
                                      get_suspenciones_list(id,jefe);
                               }, 900);

                  }


          }).done( function() {










          }).fail( function( jqXHR, textSttus, errorThrown){

            alert(errorThrown);

          });
      }

  });


}

function load_periodo_list(id,jefe)
{
  $.post("usuarios/php/get_periodos_user.php",
  { id:id, jefe:jefe },
   function(data){
  $("#lista").fadeOut(0).html(data).fadeIn(600);
  mostrar_peridos();
  });
}

function load_vacaciones_por_periodo(id,pi,pf,jefe)
{
  $.post("usuarios/php/get_vacaciones_por_periodo.php",
  { id:id,pi:pi,pf:pf,jefe:jefe},
   function(data){
  $("#lista").fadeOut(0).html(data).fadeIn(600);
   mostrar_perido2();
  });
}

function validar_resolucion(id, resolucion, jefe, rrhh){
  if(rrhh==0)
  {
  $.ajax({
    type: "POST",
    url: "usuarios/php/validar_jefe_resolucion.php",
    data:{resolucion:resolucion, jefe,jefe},

    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');

                  $('#loading').fadeIn(0);
          },
          success:function(data){
            //alert(data);

            setTimeout(function(){
                            $('#loading').fadeOut("slow");
                       }, 5000);
             $('#message').fadeIn().html(data);
             $("#message").addClass('alert alert-success');
             setTimeout(function(){
                            $('#message').fadeOut("slow");
                            $('#loading').fadeOut("slow");
                            //$('#modal-remoto').modal('hide');

                              get_suspenciones_list(id, jefe);
                       }, 900);

          }


  }).done( function() {

  }).fail( function( jqXHR, textSttus, errorThrown){

    alert(errorThrown);

  });
}
else {
  alert('Esta resolución ya fue autorizada')
}
}


function generar_periodos(empleado,jefe)
{
  $.ajax({
    type: "POST",
    url: "usuarios/php/generar_periodos_user.php",
    data:{empleado:empleado},

    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');

                  $('#loading').fadeIn(0);
          },
          success:function(data){
            alert(data);

            setTimeout(function(){
                            $('#loading').fadeOut("slow");
                       }, 5000);
             $('#message').fadeIn().html(data);
             $("#message").addClass('alert alert-success');
             setTimeout(function(){
                            $('#message').fadeOut("slow");
                            $('#loading').fadeOut("slow");
                            //$('#modal-remoto').modal('hide');

                              load_periodo_list(empleado, jefe);
                       }, 900);

          }


  }).done( function() {

  }).fail( function( jqXHR, textSttus, errorThrown){

    alert(errorThrown);

  });
}

function delete_periodo_from_user(emp,pi,pf,jefe){
  $.ajax({
    type: "POST",
    url: "usuarios/php/delete_periodo_from_user.php",
    data:{emp:emp,pi:pi,pf:pf},

    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');

                  $('#loading').fadeIn(0);
          },
          success:function(data){
            alert(data);

            setTimeout(function(){
                            $('#loading').fadeOut("slow");
                       }, 5000);
             $('#message').fadeIn().html(data);
             $("#message").addClass('alert alert-success');
             setTimeout(function(){
                            $('#message').fadeOut("slow");
                            $('#loading').fadeOut("slow");
                            //$('#modal-remoto').modal('hide');

                              load_periodo_list(emp, jefe);
                       }, 900);

          }


  }).done( function() {

  }).fail( function( jqXHR, textSttus, errorThrown){

    alert(errorThrown);

  });
}

function eliminar_resolucion(id, resolucion, jefe, rrhh,vid,tipo,fi,ff){

  $.ajax({
    type: "POST",
    url: "usuarios/php/remover_resolucion_ausencia.php",
    data:{resolucion:resolucion, jefe,jefe,id:id,vid:vid,tipo:tipo,fi:fi,ff:ff},

    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');

                  $('#loading').fadeIn(0);
          },
          success:function(data){
            //alert(data);

            setTimeout(function(){
                            $('#loading').fadeOut("slow");
                       }, 5000);
             $('#message').fadeIn().html(data);
             $("#message").addClass('alert alert-success');
             setTimeout(function(){
                            $('#message').fadeOut("slow");
                            $('#loading').fadeOut("slow");
                            //$('#modal-remoto').modal('hide');

                              get_suspenciones_list(id, jefe);
                       }, 900);

          }


  }).done( function() {

  }).fail( function( jqXHR, textSttus, errorThrown){

    alert(errorThrown);

  });

}
