$(function(){
  //show_notificacion('hola');
  });

function show_notificacion(mensaje, clase){
  $('.notificacion_alerta').show();
  $('#message_notificacion').text(mensaje);
  $('#icono_n').addClass("fa fa-warning");

  setTimeout(function(){
                 $('.notificacion_alerta').fadeOut("slow");

            }, 3000);
}

function show_notificacion_success_modal(mensaje, clase){
  $('.notificacion_alerta_success_modal').show();
  $('#message_notificacion11').text(mensaje);
  $('#icono_n11').addClass("fa fa-check");

  setTimeout(function(){
                 $('.notificacion_alerta_success_modal').fadeOut("slow");

            }, 3000);
}

function show_notificacion_success(mensaje){
  $('.notificacion_alerta_warning').hide();
  $('.notificacion_alerta_success').show();

  $('#title2').text(mensaje);
  $('#icono_n2').addClass("fa fa-check");
}

function show_notificacion_warning(mensaje){
  $('.notificacion_alerta_success').hide("slow");
  $('.notificacion_alerta_warning').show("slow");

  $('#title3').text(mensaje);
  $('#icono_n3').addClass("fa fa-check");
}


function show_notificacion2(mensaje, clase){
  $('.notificacion_alerta2').fadeIn("slow");
  $('#titulo2').text(mensaje);
  $('#icono_n2').addClass("fa fa-warning");
}
