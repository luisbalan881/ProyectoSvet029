$(function(){
  get_solicitudes_list();
    get_vehiculos_list();
  });

  function get_solicitudes_list(){
    var url='transporte/solicitudes_transporte_list.php'
    $.ajax({
        type: "POST",
        url:url,
        data:{},
        beforeSend:function(){
                      //$('#response').html('<span class="text-info">Loading response...</span>');

                      $('#loading').addClass("fa-spin");
              },
        success: function(datos){

            $('#tablaaa').fadeOut(0).html(datos).fadeIn(0);
            setTimeout(function(){
                            $('#loading').removeClass("fa-spin");
                       }, 1000);
        }
    });
  }

    function get_vehiculos_list(){
      $.ajax({

        type: "POST",
        url: "transporte/php/get_vehiculos.php",
         //f de fecha y u de estado.

        beforeSend:function(){
                      //$('#response').html('<span class="text-info">Loading response...</span>');

                      $('#loading').addClass("fa-spin");
              },
              success:function(data){
                $('#vehiculos_list').html(data);
                setTimeout(function(){
                                $('#loading').removeClass("fa-spin");
                           }, 1000);
              }


      }).done( function() {

      }).fail( function( jqXHR, textSttus, errorThrown){

        alert(errorThrown);

      });



    }
    
     function get_vehiculos_list2(){
      $.ajax({

        type: "POST",
        url: "transporte/php/get_vehiculos_mantenimiento.php",
         //f de fecha y u de estado.

        beforeSend:function(){
                      //$('#response').html('<span class="text-info">Loading response...</span>');

                      $('#loading').addClass("fa-spin");
              },
              success:function(data){
                $('#vehiculos_list').html(data);
                setTimeout(function(){
                                $('#loading').removeClass("fa-spin");
                           }, 1000);
              }


      }).done( function() {

      }).fail( function( jqXHR, textSttus, errorThrown){

        alert(errorThrown);

      });



    }
    

    function get_drivers_list(){
      $.ajax({

        type: "POST",
        url: "transporte/php/get_pilotos.php",
         //f de fecha y u de estado.

        beforeSend:function(){
                      //$('#response').html('<span class="text-info">Loading response...</span>');

                      $('#loading').addClass("fa-spin");
              },
              success:function(data){
                $('#vehiculos_list').html(data);
                setTimeout(function(){
                                $('#loading').removeClass("fa-spin");
                           }, 1000);
              }


      }).done( function() {

      }).fail( function( jqXHR, textSttus, errorThrown){

        alert(errorThrown);

      });



    }


    function get_solicitudes_list_perfil(emp){
      var url='transporte/solicitudes_listado_perfil_list.php'
      $.ajax({
          type: "POST",
          url:url,
          data:{emp:emp},
          beforeSend:function(){
                        //$('#response').html('<span class="text-info">Loading response...</span>');

                        $('#loading').addClass("fa-spin");
                },
          success: function(datos){

              $('#t_p_solicitudes').fadeOut(0).html(datos).fadeIn(0);
              setTimeout(function(){
                              $('#loading').removeClass("fa-spin");
                         }, 1000);
          }
      });
    }


/*    function myFunction() {
      var input, filter, table, tr, td, i, td1, i1, td2, i2;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("solicitudes_list");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }


    }
*/
