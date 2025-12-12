$(function(){
  //get_cupones_usados_list();
  get_cupones_usados_mensual_list();
  });

  function get_cupones_usados_list(){
    var url='combustible/control_de_combustible_list.php'
    $.ajax({
        type: "POST",
        url:url,
        data:{},
        beforeSend:function(){
                      //$('#response').html('<span class="text-info">Loading response...</span>');

                      //$('#loading').addClass("fa-spin");
              },
        success: function(datos){

            $('#tablaaa').fadeOut(0).html(datos).fadeIn(0);
            setTimeout(function(){
                            //$('#loading').removeClass("fa-spin");
                       }, 1000);
        }
    });
  }

  function get_cupones_usados_mensual_list(){
    var url='combustible/control_cupones_mensuales.php'
    $.ajax({
        type: "POST",
        url:url,
        data:{},
        beforeSend:function(){
                      //$('#response').html('<span class="text-info">Loading response...</span>');

                      //$('#loading').addClass("fa-spin");
              },
        success: function(datos){

            $('#tablaaa').fadeOut(0).html(datos).fadeIn(0);
            setTimeout(function(){
                            //$('#loading').removeClass("fa-spin");
                       }, 1000);
        }
    });
  }

  function get_cupones_list(){
    var url='combustible/control_de_cupones_list.php'
    $.ajax({
        type: "POST",
        url:url,
        data:{},
        beforeSend:function(){
                      //$('#response').html('<span class="text-info">Loading response...</span>');

                      //$('#loading').addClass("fa-spin");
              },
        success: function(datos){

            $('#tablaaa').fadeOut(0).html(datos).fadeIn(0);
            setTimeout(function(){
                            //$('#loading').removeClass("fa-spin");
                       }, 1000);
        }
    });
  }

  function get_reporte_por_cupones(){
    var url='combustible/reporte_por_cupones.php'
    $.ajax({
        type: "POST",
        url:url,
        data:{},
        beforeSend:function(){
                      //$('#response').html('<span class="text-info">Loading response...</span>');

                      //$('#loading').addClass("fa-spin");
              },
        success: function(datos){

            $('#tablaaa').fadeOut(0).html(datos).fadeIn(0);
            setTimeout(function(){
                            //$('#loading').removeClass("fa-spin");
                       }, 1000);
        }
    });
  }
  function get_dashboard(){
    var url='combustible/dashboard.php'
    $.ajax({
        type: "POST",
        url:url,
        data:{},
        beforeSend:function(){
                      //$('#response').html('<span class="text-info">Loading response...</span>');

                      //$('#loading').addClass("fa-spin");
              },
        success: function(datos){

            $('#tablaaa').fadeOut(0).html(datos).fadeIn(0);
            setTimeout(function(){
                            //$('#loading').removeClass("fa-spin");
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
