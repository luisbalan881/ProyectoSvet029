function add_formulario_ampliacion1(userid, dep, correlativo) {
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
        var codigo;
        var id=userid;
        var c=correlativo;
        var dep1=dep;
        
       // soli_tiempo


        //var p = regformhash(form,form.password,form.confirmpwd);

        //var fecha=$('#soli_fecha').val();
        //var fecha2=$('#soli_fecha2').val();
         var justificacion=$('#justificacion').val();
       // var logros=$('#logros').val();
      //  var actividades=$('#actividades').val();
        
       
       
        var dur_en=$("#horas_dias option:selected");
       //var lugar=$("#soli_lugar").val(); // luares
        var especificacion = "";  // tiempo 
        
        dur_en.each(function ()
      {
         especificacion=$(this).val();
      });
        
          
         var codigo1=$('#codigo').val();
         var year = (new Date).getFullYear();
          //var s = "SVET-";                      // preubas add codigo
          //var codigo3 = s + dep1 +"-" + ano;
    
         

          $.ajax({

            type: "POST",
            url: "viaticos/php/add_solicitud_justificacion_ampliacion.php",
            data: {codigo:c, justificacion:justificacion}, //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading').fadeIn("slow");
                  },
                  success:function(data){
                    //alert(data);
                    
                     setTimeout(function(){
                                                    $('#loading1').fadeOut("slow");
                                               }, 50);
                                     $('#message').fadeIn().html(data);
                                     $("#message").addClass('alert alert-success');
                                     setTimeout(function(){
                                                    $('#message').fadeOut("slow");
                                                    $('#loading1').fadeOut("slow");
                                                    $('#modal-remoto-lgg1').modal('hide');
                                                      show_notificacion_success("Realizado");
                                                  //get_horarios_usuario();
                                           }, 30);
                                           
                    
                    
                    
                    codigo= data;
                    
                    
                    

                        //  
                   
                          
                          
                          
                          // HTMLtoPDF
                          $.ajax({

                            type: "POST",
                            url: "viaticos/php/add_solicitud_detalle_status_ampliacion.php",
                            data: {codigo:c}, //f de fecha y u de estado.

                            beforeSend:function(){
                                          //$('#response').html('<span class="text-info">Loading response...</span>');

                                          $('#loading1').fadeIn("slow");
                                  },
                                  //
                                  success:function(data){
                                    //alert(data);

                                    setTimeout(function(){
                                                    $('#loading1').fadeOut("slow");
                                               }, 50);
                                     $('#message').fadeIn().html(data);
                                     $("#message").addClass('alert alert-success');
                                     setTimeout(function(){
                                                    $('#message').fadeOut("slow");
                                                    $('#loading1').fadeOut("slow");
                                                    $('#modal-remoto-lgg1').modal('hide');
                                                      show_notificacion_success("Liquidado");
                                                  //get_horarios_usuario();
                                           }, 30);
                                           
                                        //  HTMLtoPDF1(codigo);
                                         // HTMLtoPDFV(codigo);
                                            
                                           // datos_hoja_cupones5(codigo);
                                  }  // fin de data


                          }).done( function(data) {










                          }).fail( function( jqXHR, textSttus, errorThrown){

                            alert(errorThrown);

                          });


// inicio 

                    var selected2 =$("#d_solicitantes2 option:selected"); // inicio de funcion selected22
                      var message2 = "";
                    selected2.each(function () {
                      var inst2 = $(this).val();
                        message2 = $(this).val();
                                  
                         var inst2 = $(this).val();
                          //vp_solicitud_transporte_departamento
                          
                          
                          
                          
                          //
                          $.ajax({

                            type: "POST",
                            url: "viaticos/php/add_solicitud_detalle3.php",
                            data: {codigo:c, inst2:inst2}, //f de fecha y u de estado.

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
                                                      show_notificacion_success("Satisfactoriamente");
                                                  //get_horarios_usuario();
                                           }, 300);
                                           
                                          //  HTMLtoPDFV4(codigo);
                                           //  datos_hoja_cupones5(codigo);
                                  }


                          }).done( function(data) {



                          }).fail( function( jqXHR, textSttus, errorThrown){

                            alert(errorThrown);

                          });

                    });  // fin de funcion selected2
// fin



                   // });  // fin de funcion selected
                    
                    
                      // fin de funcion selected2

                    
      } // fin de funcion data
  });

}
 });

}


//SOLICITURD add_solicitud_manual

