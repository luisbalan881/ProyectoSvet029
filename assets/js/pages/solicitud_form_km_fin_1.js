function add_formulario_km_fin(correlativo, placa) {
  jQuery('.js-validation-solicitud').validate({
      ignore: [],
      errorClass: 'help-block animated fadeInDown',
      errorElement: 'div',
      errorPlacement: function(error, e) {
          jQuery(e).parents('.form-group > div').append(error);
      },
      highlight: function(e) {
          var elem = jQuery(e);

          elem.closest('.form-group').removeClass('has-error').addClass('has-error');
          elem.closest('.help-block').remove();
          $("#boton_s_t").removeClass('vibrar').addClass('vibrar');
      },
      success: function(e) {
          var elem = jQuery(e);

          elem.closest('.form-group').removeClass('has-error');
          $("#boton_s_t").removeClass('vibrar');
          elem.closest('.help-block').remove();


      },
      submitHandler: function(form){
        //alert('OK');
     //   var codigo;
     //   var id=userid;
        var c=correlativo;
        var palca=placa;
        // var c1=correlativo2;
        
       // alert(c);
       // var dep1=dep;
        
       // soli_tiempo


        //var p = regformhash(form,form.password,form.confirmpwd);

        //var fecha=$('#soli_fecha').val();
        //var fecha2=$('#soli_fecha2').val();
       //  var objetivo=$('#objetivo').val();
    //    var logros=$('#logros').val();
     //   var actividades=$('#actividades').val();
        
        
        var dest=$('#km_fin').val(); 
        var kmInicial=$('#km_inicial').val();
        
      //  var total2=$('#almt').val(); //cent
       // var total3=$('#cent').val();  
     //   var total4=$('#host').val(); //cent
        //var duracion1=$('#soli_tiempo2').val();
        var dur_en=$("#horas_dias option:selected");
       //var lugar=$("#soli_lugar").val(); // luares
        var especificacion = "";  // tiempo 
        
        dur_en.each(function ()
      {
         especificacion=$(this).val();
      });
        
      
         

          $.ajax({

                           type: "POST",
                            url: "combustible/php/add_Registro_km_final.php",
                            data: {c:c, dest:dest, kmInicial:kmInicial, placa:placa}, //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading1').fadeIn("slow");
                  },
                  success:function(data){
                    //alert(data);
                    
                     setTimeout(function(){
                                                    $('#loading1').fadeOut("slow");
                                               }, 500);
                                     $('#message').fadeIn().html(data);
                                     $("#message").addClass('alert alert-success');
                                     setTimeout(function(){
                                                    $('#message').fadeOut("slow");
                                                    $('#loading1').fadeOut("slow");
                                                    $('#modal-remoto-lgg').modal('hide');
                                                      show_notificacion_success("Realizado");
                                                                              
                                                  }, 300);
                                           
                    
                    
                    
                    
                    
                    
                    

                      }  //  fi de funcion data
                   
                          
                          
                        }).done( function(data) {










                          }).fail( function( jqXHR, textSttus, errorThrown){

                            alert(errorThrown);

                          });

                   // });  // fin de funcion selected
                    
                    
                      // fin de funcion selected2

                    
      } // fin de funcion data
  });

}
// });

//}


//SOLICITURD add_solicitud_manual

function redireccionar(){
  window.locationf="http://www.cristalab.com";
} 