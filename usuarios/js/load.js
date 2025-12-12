  $( document ).ready(function() {
    cargar();
});

function cargar(){
  var url='usuarios/empleados_list.php'
  $.ajax({
      type: "POST",
      url:url,
      data:{},
      beforeSend:function(){
        $('#Recargar').addClass('parpadea');
        $('#car_t').fadeIn(500);
        $('#car_t').addClass('fa-spin');
        $("#tabla1").fadeOut(0).html('<div class="loaderr"></div><br>').fadeIn(100);
      },
      success: function(datos){

                        $('#car_t').fadeOut(500);
                        $('#Recargar').removeClass('parpadea')
          $('#tabla1').fadeOut(0).html(datos).fadeIn(0);
          $('#Recargar').text("Recargar");

          //$('#car_t').fadeOut("slow");
      }
  });
}
