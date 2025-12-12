$(function(){
  get_solicitudes_cupones_list();

  });

  function get_solicitudes_cupones_list(){
    var url='combustible/solicitudes_cupones_list.php'
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
    var url='combustible/control_de_cupones_grupo_list.php'
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
