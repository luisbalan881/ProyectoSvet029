function add_solicitudNE(userid, dep, correlativo) {
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
        var dep1=dep;
		var c=correlativo;
        
       // soli_tiempo


        //var p = regformhash(form,form.password,form.confirmpwd);

        var fecha=$('#soli_fecha').val();
        var fecha2=$('#soli_fecha2').val();
        var objetivo1=$('#objetivo').val();
        //var duracion1=$('#soli_tiempo2').val();
        var dur_en=$("#horas_dias option:selected");
        var lugar=$("#soli_lugar").val(); // luares
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
            url: "viaticos/php/add_solicitud_nombramiento_editable.php",
            data: {codigo:c, fecha:fecha,fecha2:fecha2,objetivo:objetivo1,lugar:lugar}, //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading1').fadeIn("slow");
                  },
                  success:function(data){
                    //alert(data);
                    codigo= data;
					
					
                                    setTimeout(function(){
                                                    $('#loading1').fadeOut("slow");
                                               }, 300);
											    $('#message').fadeIn().html(data);
                                     $("#message").addClass('alert alert-success');
									 
									  setTimeout(function(){
                                                    $('#message').fadeOut("slow");
                                                    $('#loading1').fadeOut("slow");
                                                    $('#modal-remoto-lgg1').modal('hide');
                                                      show_notificacion_success("Nombramiento modificado");
                                                  //get_horarios_usuario();
                                           }, 300);
										     if(data.success == true){ // if true (1)
      setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 10000); 
   }
										   
					
					
					//
					
					
					
                    //
                    
                    
      } // fin de funcion data
	  
  }).done( function(data) {










                          }).fail( function( jqXHR, textSttus, errorThrown){

                            alert(errorThrown);

                          });


}
 });
//location.reload(9000);
}

function ponleFocus(){
    document.getElementById("soli_lugar").focus();
}

ponleFocus();





//SOLICITURD add_solicitud_manual

