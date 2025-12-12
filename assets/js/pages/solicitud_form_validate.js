function add_solicitud(userid) {
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


        //var p = regformhash(form,form.password,form.confirmpwd);

        var fecha=$('#soli_fecha').val();
        
        var fecha2=$('#serverDate').val();
        //serverDate
        //var d = new Date();
        //
        
         var btnEnviar = document.getElementById('boton_s_t');
        if(fecha==fecha2)
        {
            alert("fecha invalida");
               btnEnviar.disabled = true;
         }
         else  btnEnviar.disabled = false;
       // var n = d.getFullYear();
        //alert(fecha);
        //alert(fecha2);
       // alert(n);
        var salida=$('#soli_salida1').val();
        var duracion=$('#soli_tiempo').val();
        var dur_en=$("#horas_dias option:selected");
        var desc=$("#soli_desc").val();
        var especificacion = "";
        dur_en.each(function ()
      {
         especificacion=$(this).val();
      });
      var cantidad=$('#soli_cantidad').val();






          $.ajax({

            type: "POST",
            url: "transporte/php/add_solicitud.php",
            data: {fecha:fecha, salida:salida, duracion:duracion, especificacion:especificacion, cantidad:cantidad, id:id,desc:desc}, //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading').fadeIn("slow");
                  },
                  success:function(data){
                    //alert(data);
                    codigo=data;


                    var selected =$("#d_solicitantes option:selected");
                      var message = "";
                    selected.each(function () {
                      var inst = $(this).val();
                        message = $(this).val();
                          //alert(message);



                          var inst = $(this).val();
                          //vp_solicitud_transporte_departamento
                          $.ajax({

                            type: "POST",
                            url: "transporte/php/add_solicitud_departamento.php",
                            data: {codigo:codigo, inst:inst}, //f de fecha y u de estado.

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
                                                    $('#modal-remoto-lgg1').modal('hide');
                                                      //get_horarios_usuario();
                                               }, 800);

                                  }


                          }).done( function(data) {










                          }).fail( function( jqXHR, textSttus, errorThrown){

                            alert(errorThrown);

                          });





                    });




                    //destino y motivos
                    var miArray1=new Array();
                    var miArray2=new Array();
                    var xx;
                    var yy;

                    $("#crud_table tbody tr td div .item_destino").each(function(){
                         xx = ($(this).attr('id'));
                         miArray1.push($('#'+xx).val());
                    });

                    $("#crud_table tbody tr td div .item_motivo").each(function(){
                         yy = ($(this).attr('id'));
                         miArray2.push($('#'+yy).val());
                    });

                    var x = 1;
                    for(var x in miArray1)
                    {
                      var correlativo=x;
                      $.ajax({

                        type: "POST",
                        url: "transporte/php/add_solicitud_destino_motivo.php",
                        data: {codigo:codigo, correlativo:correlativo,destino:miArray1[x],motivo:miArray2[x]}, //f de fecha y u de estado.

                        beforeSend:function(){
                                      //$('#response').html('<span class="text-info">Loading response...</span>');

                                      $('#loading1').fadeIn("slow");
                              },
                              success:function(data){
                                //alert(data);

                                setTimeout(function(){
                                                $('#loading1').fadeOut("slow");
                                           }, 500);

                                 setTimeout(function(){
                                                $('#message').fadeOut("slow");
                                                $('#loading1').fadeOut("slow");
                                                $('#modal-remoto-lgg').modal('hide');
                                                show_notificacion_success("Solicitud Generada");
                                                  //get_horarios_usuario();
                                           }, 800);



                              }


                      }).done( function(data) {










                      }).fail( function( jqXHR, textSttus, errorThrown){

                        alert(errorThrown);

                      });
                      //alert(miArray1[x] + ' ' + miArray2[x]);

                      x++;
                    }

                    HTMLtoPDF(codigo);






                  }



          }).done( function() {










          }).fail( function( jqXHR, textSttus, errorThrown){

            alert(errorThrown);

          });




          //SOLICITUD Departamentos
















      }/*,

    rules: {
      'soli_fecha': {
          remote: {
              url: 'transporte/validar_fecha.php',
              data: {
                from: function(){ return $('#soli_fecha').val();},

            }
          }
        }
    },
    messages: {

          'soli_fecha': {
              remote: "La fecha no existe en los horarios."
          }

    }*/




  });

}


//SOLICITURD add_solicitud_manual


function add_solicitud_manual() {
  //alert($("#responsable").val());
  jQuery('.js-validation-solicitud1').validate({
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
        var id=$("#responsable").val();


        //var p = regformhash(form,form.password,form.confirmpwd);

        var fecha=$('#soli_fecha').val();
        var salida=$('#soli_salida1').val();
        var duracion=$('#soli_tiempo').val();
        var dur_en=$("#horas_dias option:selected");
        var desc=$("#soli_desc").val();
        var especificacion = "";
        dur_en.each(function ()
      {
         especificacion=$(this).val();
      });
      var cantidad=$('#soli_cantidad').val();






          $.ajax({

            type: "POST",
            url: "transporte/php/add_solicitud.php",
            data: {fecha:fecha, salida:salida, duracion:duracion, especificacion:especificacion, cantidad:cantidad, id:id,desc:desc}, //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading').fadeIn("slow");
                  },
                  success:function(data){
                    //alert(data);
                    codigo=data;


                    var selected =$("#d_solicitantes option:selected");
                      var message = "";
                    selected.each(function () {
                      var inst = $(this).val();
                        message = $(this).val();
                          //alert(message);



                          var inst = $(this).val();
                          //vp_solicitud_transporte_departamento
                          $.ajax({

                            type: "POST",
                            url: "transporte/php/add_solicitud_departamento.php",
                            data: {codigo:codigo, inst:inst}, //f de fecha y u de estado.

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
                                                    $('#modal-remoto-lgg1').modal('hide');
                                                      //get_horarios_usuario();
                                               }, 800);

                                  }


                          }).done( function(data) {










                          }).fail( function( jqXHR, textSttus, errorThrown){

                            //alert(errorThrown);

                          });





                    });




                    //destino y motivos
                    var miArray1=new Array();
                    var miArray2=new Array();
                    var xx;
                    var yy;
                    $("#crud_table tbody tr td div .item_destino").each(function(){
                         xx = ($(this).attr('id'));
                         miArray1.push($('#'+xx).val());
                    });

                    $("#crud_table tbody tr td div .item_motivo").each(function(){
                         yy = ($(this).attr('id'));
                         miArray2.push($('#'+yy).val());
                    });

                    var x = 1;
                    for(var x in miArray1)
                    {

                      var correlativo=x;
                      $.ajax({

                        type: "POST",
                        url: "transporte/php/add_solicitud_destino_motivo.php",
                        data: {codigo:codigo,  correlativo:correlativo,destino:miArray1[x],motivo:miArray2[x]}, //f de fecha y u de estado.

                        beforeSend:function(){
                                      //$('#response').html('<span class="text-info">Loading response...</span>');

                                      $('#loading1').fadeIn("slow");
                              },
                              success:function(data){
                                //alert(data);

                                setTimeout(function(){
                                                $('#loading1').fadeOut("slow");
                                           }, 500);

                                 setTimeout(function(){
                                                $('#message').fadeOut("slow");
                                                $('#loading1').fadeOut("slow");
                                                $('#modal-remoto-lgg').modal('hide');
                                                show_notificacion_success("Solicitud Generada");
                                                  //get_horarios_usuario();
                                           }, 300);

                              }


                      }).done( function(data) {










                      }).fail( function( jqXHR, textSttus, errorThrown){

                        alert(errorThrown);

                      });
                      //alert(miArray1[x] + ' ' + miArray2[x]);
                    }








                  }


          }).done( function() {










          }).fail( function( jqXHR, textSttus, errorThrown){

            alert(errorThrown);

          });




          //SOLICITUD Departamentos
















      }/*,

    rules: {
      'soli_fecha': {
          remote: {
              url: 'transporte/validar_fecha.php',
              data: {
                from: function(){ return $('#soli_fecha').val();},

            }
          }
        }
    },
    messages: {

          'soli_fecha': {
              remote: "La fecha no existe en los horarios."
          }

    }*/


  });

}
