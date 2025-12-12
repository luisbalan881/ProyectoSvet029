function cargar_horarios()
{
  $("#mes option:selected").each(function (){
      mm=$(this).val();
      $("#anio option:selected").each(function () {
       yy=$(this).val();

       var url='usuarios/empleados_horarios_list.php'
       $.ajax({
           type: "POST",
           url:url,
           data:{mm: mm, yy : yy},
           beforeSend:function(){
                         //$('#response').html('<span class="text-info">Loading response...</span>');

                         $('#car_t').addClass('fa-spin').fadeIn(100);

                         $('#Recargar').addClass('parpadea')
                         $('#Recargar').text("  Cargando...");
                 },
           success: function(datos){

                             $('#car_t').fadeOut(900);
                             $('#Recargar').removeClass('parpadea');
               $('#tabla1').fadeOut(0).html(datos).fadeIn(0);
               $('#Recargar').text("");

               $('#car_t').fadeOut("slow");
           }
       });

      });
   });

}


function cargar_horarios_todos()
{
  $("#mes option:selected").each(function (){
      mess=$(this).val();
      $("#anio option:selected").each(function () {
       anio=$(this).val();

       var $modal = $('#modal-remoto-lgg2');
       $modal.load('usuarios/usuarios_horarios_general.php', {'mess':mess, 'anio':anio},
       function(){
         $modal.modal('show');
       });

      });
   });

}

function cargar_horarios_especial()
{

      $("#year option:selected").each(function () {
       year=$(this).val();
       var url='usuarios/empleados_horarios_especial_list.php'
       $.ajax({

           type: "POST",
           url:url,
           data:{year : year},
           beforeSend:function(){
                         //$('#response').html('<span class="text-info">Loading response...</span>');

                         $('#car_t').addClass('fa-spin').fadeIn(100);

                         $('#Recargar').addClass('parpadea')
                         $('#Recargar').text("  Cargando...");
                 },
           success: function(datos){

                             $('#car_t').fadeOut(900);
                             $('#Recargar').removeClass('parpadea');
               $('#tabla11').fadeOut(0).html(datos).fadeIn(0);
               $('#Recargar').text("");

               $('#car_t').fadeOut("slow");
           }
       });



      });


}

function load_horarios_8()
{
  $.post("usuarios/usuarios_horarios_listado.php",
  { },
   function(data){
  $("#pantalla").fadeOut(0).html(data).fadeIn(0);
  //mostrar_peridos();
  });
}

function load_horarios_8_dias()
{
  $.post("usuarios/usuarios_horarios_especial_listado.php",
  { },
   function(data){
  $("#pantalla").fadeOut(0).html(data).fadeIn(0);
   //mostrar_perido2();
   $('#xx').removeClass('contorno');
  });
}


function load_usuarios_por_grupo_list()
{
  $.post("usuarios/php/get_usuarios_por_grupo_list.php",
  { },
   function(data){
  $("#cuadro").fadeOut(0).html(data).fadeIn(300);
  //mostrar_peridos();
  $('#close_this_group').fadeIn(100);
  $('#este_titulo').text('Seleccionar Empleado');
  });
}

function load_usuario_detalle_por_grupo_list(user_id)
{
  $.post("usuarios/php/get_usuario_por_grupo_list_detalle.php",
  { user_id:user_id},
   function(data){
     $('#close_this_group').fadeOut(0);
  $("#cuadro").fadeOut(0).html(data).fadeIn(300);
  //mostrar_peridos();

  });
}

function show_message(){
  $('.mensajes').tooltip({
  title: fetchData,
  html: true,
  placement: 'right'
  });

  function fetchData()
  {
  var fetch_data = '';
  var element = $(this);

  var fecha = element.attr("id");

  $.ajax({
   url:"usuarios/php/get_detalle_fecha_ausencia_semana.php",
   method:"POST",
   async: false,
   data:{fecha:fecha},
   success:function(data)
   {
    fetch_data = data;

   }

  }).done( function() {










  }).fail( function( jqXHR, textSttus, errorThrown){

    fetch_data=errorThrown;

  });
  return fetch_data;
  }

}
