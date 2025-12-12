$(function(){
  get_notificaciones_count1();




              setInterval(function(){
               get_notificaciones_count1();
              }, 5000);
  });


  function get_notificaciones_count1(){
    $.ajax({

      type: "POST",
      url: "transporte/php/notificaciones_count.php",
       //f de fecha y u de estado.

      beforeSend:function(){
                    //$('#response').html('<span class="text-info">Loading response...</span>');

                    //$('#loading').fadeIn("slow");
            },
            success:function(data){
              if(data > 0)
              {
              $('.contar').html(data);
              document.getElementById("ns").style.visibility = "visible";
              //$('#campana').addClass('text-danger-live');
              //$('#notif').addClass('text-danger-live');
            }
            else if(data == 0){
              //$('#campana').removeClass('text-danger-live');
              //$('#notif').removeClass('text-danger-live');
              document.getElementById("ns").style.visibility = "hidden";
            }
            }


    }).done( function() {

    }).fail( function( jqXHR, textSttus, errorThrown){

      //  alert(errorThrown);

    });



  }
