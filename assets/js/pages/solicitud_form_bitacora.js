function add_solicitud_bitacora(userid, dep) {
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
        //var dep1=de;
        
       // soli_tiempo


        //var p = regformhash(form,form.password,form.confirmpwd);

        //var fecha=$('#soli_fecha').val();
        //var fecha2=$('#soli_fecha2').val();
       var motivo=$('#motivo').val();
        //var duracion1=$('#soli_tiempo2').val();
      // var dur_en=$("#horas_dias option:selected");
        var lugar=$("#soli_lugar").val(); // luares
      
      var n =$("#d_solicitantes option:selected").val();
                    
      
      
          
         var codigo1=$('#codigo').val();
         var year = (new Date).getFullYear();
          //var s = "SVET-";                      // preubas add codigo
          //var codigo3 = s + dep1 +"-" + ano;
    
         

          $.ajax({

            type: "POST",
            url: "combustible/php/add_Registro_km_inicial.php",
            data: {id:id,lugar:lugar, motivo:motivo,n:n}, //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading').fadeIn("slow");
                  },
                  success:function(data){
                    //alert(data);
                    
                    
                     setTimeout(function(){
                                                    $('#loading').fadeOut("slow");
                                               }, 500);
                                     $('#message').fadeIn().html(data);
                                     $("#message").addClass('alert alert-success');
                                     setTimeout(function(){
                                                    $('#message').fadeOut("slow");
                                                    $('#loading').fadeOut("slow");
                                                    $('#modal-remoto-lgg').modal('hide');
                                                      show_notificacion_success("Registrado");
                                                  //get_horarios_usuario();
                                           }, 300);
                                           
                    
                    
                    
                   

                        //  
                
                    
            
                      
                      
                      
                      
      } // fin de funcion data
      
      
   }).done( function(data) {










                          }).fail( function( XMLHttpRequest, textSttus, errorThrown){

                            alert("some error");

                          });
}
 });

}


//SOLICITURD add_solicitud_manual

