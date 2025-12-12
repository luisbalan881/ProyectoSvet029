function add_solicitudN(userid, dep) {
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
            url: "viaticos/php/add_solicitud_nombramiento.php",
            data: {fecha:fecha,fecha2:fecha2, objetivo:objetivo1, especificacion:especificacion, dep:dep1, id:id,lugar:lugar, year:year}, //f de fecha y u de estado.

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
                                                    $('#modal-remoto-lgg').modal('hide');
                                                      show_notificacion_success("Nombramiento Generado");
                                                  //get_horarios_usuario();
                                           }, 300);
										   
					
					
					//
					
					
					
                    //
                    
                    
      } // fin de funcion data
	  
  }).done( function(data) {










                          }).fail( function( jqXHR, textSttus, errorThrown){

                            alert(errorThrown);

                          });


}
 });
location.reload(9000);
}


//SOLICITURD add_solicitud_manual




function add_solicitudNom(userid, dep) {
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
        
       // soli_tiempo


        //var p = regformhash(form,form.password,form.confirmpwd);

        var fecha=$('#soli_fecha').val();
        var fecha2=$('#soli_fecha2').val();
        var objetivo1=$('#objetivo').val();
        //var duracion1=$('#soli_tiempo2').val();
        var dur_en=$("#horas_dias option:selected");
        var lugar=$("#soli_lugar").val(); // luares
		
		// actualizacion para agregar hora
		  var hora1=$("#hora1").val(); // hora_inicio
		  var hora2=$("#hora2").val(); // hora_fin
		  
		  // hora
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
            url: "viaticos/php/add_solicitud_nombramiento.php",
            data: {hora1:hora1, hora2:hora2, fecha:fecha,fecha2:fecha2, objetivo:objetivo1, especificacion:especificacion, dep:dep1, id:id,lugar:lugar, year:year}, //f de fecha y u de estado.

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
                                                      show_notificacion_success("Nombramiento Generado");
													  setTimeout( function() { window.location.href = "?ref=_89"; }, 1000);
                                                  //get_horarios_usuario();
												  
											
                                           }, 300);
										  
                  
                    
      } // fin de funcion data
	  
  }).done( function(data) {

                          }).fail( function( jqXHR, textSttus, errorThrown){

                            alert(errorThrown);
								  HTMLtoPDF1(codigo);

                          });


}
 });
location.reload(9000);
}


