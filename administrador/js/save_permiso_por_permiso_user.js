

$(function(){
      $('#btnGuardarSP').click(function(){


/*        $.each($('input[type=checkbox]:not(:checked)'), function(){


          var x;
            var y;
            x = ($(this).data('tipe'));
            y = ($(this).data('id'));

          $.ajax({



            type: "POST",
            url: "delete_rp.php",
            data: {rol_id:x,perm_id:y},
            dataType: "JSON",
            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                     },
            success: function(data) {
             /*$('#response').fadeIn().html(data);
                          setTimeout(function(){
                               $('#response').fadeOut("slow");
                          }, 5000);

            },
            error: function(data) {
               setTimeout(function(){
                               $('#loading').fadeOut("slow");
                          }, 5000);
                $('#message').fadeIn().html('Algun error ocurrio delete');
                $("#message").addClass('alert alert-danger');
                setTimeout(function(){
                               $('#message').fadeOut("slow");
                          }, 5000);
            }
        });
*/


$.each($('input[type=checkbox]:not(:checked)'), function(){

  var sb;
  var us;
  sb = ($(this).data('tipe'));
  us = ($(this).data('id'));

  //alert(role_id + ' ' + perm_id)

if(sb > 0)
{
  $.ajax({



    type: "POST",

    url: "administrador/scripts_php/delete_p_por_p_user.php",

    data: {sb:sb, us:us},

    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');

                  $('#loading').fadeIn("slow");
          },
          success:function(data){
            //alert(data);

          }


  }).done( function(data) {
    //alert(data);
    setTimeout(function(){
                    $('#loading').fadeOut("slow");
               }, 5000);
     $('#message').fadeIn().html('Datos Guardados');
     $("#message").addClass('alert alert-success');
     setTimeout(function(){
                    $('#message').fadeOut("slow");
                    $('#loading').fadeOut("slow");
               }, 1000);






  }).fail( function( jqXHR, textSttus, errorThrown){

    setTimeout(function(){
                    $('#loading').fadeOut("slow");
               }, 5000);
     $('#message').fadeIn().html('Error');
     $("#message").addClass('alert alert-danger');
     setTimeout(function(){
                    $('#message').fadeOut("slow");
                    $('#loading').fadeOut("slow");
               }, 1000);

  });

} //fin if



});









//inicio checkeados




          $.each($('input[type=checkbox]:checked'), function(){

            var sb;
            var us;
            sb = ($(this).data('tipe'));
            us = ($(this).data('id'));

            //alert(role_id + ' ' + perm_id)

if(sb > 0)
{
            $.ajax({



              type: "POST",

              url: "administrador/scripts_php/insert_p_por_p_user.php",

              data: {sb:sb, us:us},

              beforeSend:function(){
                            //$('#response').html('<span class="text-info">Loading response...</span>');

                            $('#loading').fadeIn("slow");
                    },
                    success:function(data){
                      //alert(data);

                    }


            }).done( function(data) {
              //alert(data);
              setTimeout(function(){
                              $('#loading').fadeOut("slow");
                         }, 5000);
               $('#message').fadeIn().html('Datos Guardados');
               $("#message").addClass('alert alert-success');
               setTimeout(function(){
                              $('#message').fadeOut("slow");
                              $('#loading').fadeOut("slow");
                         }, 1000);






            }).fail( function( jqXHR, textSttus, errorThrown){

              setTimeout(function(){
                              $('#loading').fadeOut("slow");
                         }, 5000);
               $('#message').fadeIn().html('Error');
               $("#message").addClass('alert alert-danger');
               setTimeout(function(){
                              $('#message').fadeOut("slow");
                              $('#loading').fadeOut("slow");
                         }, 1000);

            });

          } //fin if










        });









        });

    });
