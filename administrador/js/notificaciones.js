$(function(){



              get_notificaciones_count();
              get_notificaciones();


              setInterval(function(){
               get_notificaciones_count();
               get_notificaciones();
              }, 5000);
  });


  function get_notificaciones_count(){
    $.ajax({

      type: "POST",
      url: "../../herramientas/administrador/scripts_php/notificaciones_count.php",
       //f de fecha y u de estado.

      beforeSend:function(){
                    //$('#response').html('<span class="text-info">Loading response...</span>');

                    //$('#loading').fadeIn("slow");
            },
            success:function(data){
              if(data > 0)
              {
              $('.count').html(data);
              $('#bell').addClass('text-danger-live');
              $('#noti').addClass('text-danger-live');
              document.getElementById("ns1").style.visibility = "visible";
            }
            else if(data == 0){
              $('#bell').removeClass('text-danger-live');
              $('#noti').removeClass('text-danger-live');
              document.getElementById("ns1").style.visibility = "hidden";
            }
            }


    }).done( function() {

    }).fail( function( jqXHR, textSttus, errorThrown){

      show_notificacion2("Sin Conexión","");

    });



  }


  function get_notificaciones(){
    $.ajax({

      type: "POST",
      url: "../../herramientas/administrador/scripts_php/get_notificaciones.php",
       //f de fecha y u de estado.

      beforeSend:function(){
                    //$('#response').html('<span class="text-info">Loading response...</span>');

                    //$('#loading').fadeIn("slow");
            },
            success:function(data){
              $('.dropdown-menu1').html(data);
            }


    }).done( function() {

    }).fail( function( jqXHR, textSttus, errorThrown){

      show_notificacion2("Sin Conexión","");

    });



  }
