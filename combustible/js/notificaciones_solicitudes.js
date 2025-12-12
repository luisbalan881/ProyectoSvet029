$(function(){
  get_notificaciones_count1();




              setInterval(function(){
               get_notificaciones_count1();
              }, 5000);
  });


  function get_notificaciones_count1(){
    $.ajax({

      type: "POST",
      url: "combustible/php/notificaciones_count.php",
       //f de fecha y u de estado.

      beforeSend:function(){
                    //$('#response').html('<span class="text-info">Loading response...</span>');

                    //$('#loading').fadeIn("slow");
            },
            success:function(data){
              if(data > 0)
              {
              $('.contar').html(data);
              document.getElementById("ns1").style.visibility = "visible";

            }
            else if(data == 0){
            
              document.getElementById("ns1").style.visibility = "hidden";
            }
            }


    }).done( function() {

    }).fail( function( jqXHR, textSttus, errorThrown){

      //  alert(errorThrown);

    });



  }
