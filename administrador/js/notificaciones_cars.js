

  function get_notificaciones_cars(){
    $.ajax({

      type: "POST",
      url: "../../herramientas/administrador/scripts_php/notificaciones_cars.php",
       //f de fecha y u de estado.

      beforeSend:function(){
                    //$('#response').html('<span class="text-info">Loading response...</span>');

                    //$('#loading').fadeIn("slow");
            },
            success:function(data){
              if(data > 0)
              {
              $('.counttts').html(data);
              
              var message;
              if(data == 1)
              {
                message='Tiene 1 solicitud autorizada';
              }
              else {
                message='Tiene '+ data +' solicitud autorizada';
              }
              document.getElementById("ns111").style.visibility = "visible";

              $('.counttts').tooltip({
                 title: message,
                 html: true,
                 placement: 'right'
                });




            }
            else if(data == 0){

              document.getElementById("ns111").style.visibility = "hidden";

            }
            }


    }).done( function() {

    }).fail( function( jqXHR, textSttus, errorThrown){

      show_notificacion2("Sin Conexión","");

    });



  }
