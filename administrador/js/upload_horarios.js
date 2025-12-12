$(document).ready(function(){
           $('#upload_csv').on("submit", function(e){
                e.preventDefault(); //form will not submitted
                $.ajax({
                     url:"../herramientas/administrador/scripts_php/upload_horarios.php",
                     method:"POST",
                     data:new FormData(this),
                     contentType:false,          // The content type used when sending data to the server.
                     cache:false,                // To unable request pages to be cached
                     processData:false,          // To send DOMDocument or non processed data file it is set to false
                     beforeSend:function(){
                                   //$('#response').html('<span class="text-info">Loading response...</span>');

                                   $('#loading').fadeIn("slow");
                           },
                     success: function(data){
                          if(data=='Error1')
                          {
                            borrar('Archivo Inválido');
                            $("#upload").removeClass('vibrar').addClass('vibrar');


                          }
                          else if(data == "Error2")
                          {
                            borrar('Seleccione un Archivo');
                            $("#upload").removeClass('vibrar').addClass('vibrar');


                          }
                          else
                          {
                               //$('#employee_table').html(data);
                               setTimeout(function(){
                                               $('#loading').fadeOut("slow");
                                          }, 900);

                                //$("#message").addClass('alert alert-success');
                                $("#m").fadeIn("slow");
                                $( "#message" ).removeClass( "alert alert-danger" ).addClass( "alert alert-success" );
                                $('#message').fadeIn().html('Datos Guardados');
                                setTimeout(function(){
                                               $('#message').fadeOut("slow");
                                               $('#loading').fadeOut("slow");
                                               $("#m").fadeOut("slow");
                                          }, 900);
                                          document.upload_csv.archivo.value = "";
                          }
                     }
                }).done(function(){



                }).fail(function( jqXHR, textSttus, errorThrown){
                  alert(errorThrown);
                });




           });
      });


function borrar(message)
{
  setTimeout(function(){
                  $('#loading').fadeOut("slow");
             }, 5000);
             $('#message').fadeIn().html(message);
             $("#message").addClass('alert alert-danger');
             setTimeout(function(){
                            $('#message').fadeOut("slow");
                            $('#loading').fadeOut("slow");
                       }, 5000);
}
