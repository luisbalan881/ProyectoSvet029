

$(function(){
      $('#btnGuardar').click(function(){


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

  var role_id;
  var perm_id;
  role_id = ($(this).data('tipe'));
  perm_id = ($(this).data('id'));

  //alert(role_id + ' ' + perm_id)

if(role_id > 0)
{
  $.ajax({



    type: "POST",

    url: "administrador/scripts_php/delete_rp.php",

    data: {role_id:role_id, perm_id:perm_id},

    beforeSend:function(){
                  //$('#response').html('<span class="text-info">Loading response...</span>');

                  $('#loading').fadeIn("slow");
          },
          success:function(data){
            //alert(data);

          }


  }).done( function() {


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

            var role_id;
            var perm_id;
            role_id = ($(this).data('tipe'));
            perm_id = ($(this).data('id'));

            //alert(role_id + ' ' + perm_id)

if(role_id > 0)
{
            $.ajax({



              type: "POST",

              url: "administrador/scripts_php/insert_rp.php",

              data: {role_id:role_id, perm_id:perm_id},

              beforeSend:function(){
                            //$('#response').html('<span class="text-info">Loading response...</span>');

                            $('#loading').fadeIn("slow");
                    },
                    success:function(data){
                      //alert(data);

                    }


            }).done( function() {


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
