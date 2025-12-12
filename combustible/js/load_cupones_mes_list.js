function cargar_cupones_mes()
{
  $("#mes option:selected").each(function (){
      mm=$(this).val();
      if(mm<10)
      {
        mm='0'+mm;
      }
      $("#mes2 option:selected").each(function (){
          mm2=$(this).val();
          if(mm2<10)
          {
            mm2='0'+mm2;
          }

            $("#anio option:selected").each(function () {
             yy=$(this).val();

             var url='combustible/control_cupones_mensual_list.php'
             $.ajax({
                 type: "POST",
                 url:url,
                 data:{mm: mm, mm2:mm2, yy : yy},
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


   });

}



function cargar_cupones_mes_listado()
{
  $("#mes option:selected").each(function (){
      mm=$(this).val();
      if(mm<10)
      {
        mm='0'+mm;
      }
      $("#mes2 option:selected").each(function (){
          mm2=$(this).val();
          if(mm2<10)
          {
            mm2='0'+mm2;
          }

            $("#anio option:selected").each(function () {
             yy=$(this).val();

             var url='combustible/reporte_por_cupones_list.php'
             $.ajax({
                 type: "POST",
                 url:url,
                 data:{mm: mm, mm2:mm2, yy : yy},
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


   });

}
