$(function(){

  $("input:checkbox").change(function() {
    id= $(this).data('id');
    var combo='#vehiculo_id'+id;
    if ($(this).is(':checked') ) {
      $('#'+id).val('');
      //alert($('#conductor_id'+id +' option:selected').text());

      document.getElementById(id).disabled=false;

      show_message(id,'Especifique el monto de combustible');
    } else {
      remove_message(id);
      $('#'+id).val('');
      document.getElementById(id).disabled=true;

    }
  });

  $('input:text').focus(function() {
    var currentId = $(this).attr('id');
    $("#"+currentId).keyup(function(){
      if($("#"+currentId).val() == '')
      {
        show_message(currentId,'Especifique el monto de combustible');
      }
      else
      {
        if(evaluar_monto($('#'+currentId).val()))
        {
          remove_message(currentId);
        }
        else {
          {
            show_message(currentId,'Ingrese un monto divisible dentro de 50');
          }
        }
      }
    });
  });

  var table = $('#tb_solicitar_cupones').DataTable( {
    dom: 'Bfrtip',
    "paging":   false,
    "ordering": false,
    "info":     false,
    "search": true,
    "searching": true,
    buttons: [

    ],
    "columns": [
    null,
    null,
    null,
    null,
    null,
    null,
    null,
    null,
    null,
    null
  ]
  });

  $('#save_solicitud_cupones').click(function(){

    total = $("input[type=checkbox]:checked").length;

    var nFilas = $("#tb_solicitar_cupones tr.danger").length;
    //var nColumnas = $("#tb_solicitar_cupones tr:last td").length;
    //var msg = "Filas: "+nFilas+" - Columnas: "+nColumnas;
    //alert(msg);
    var des = $('#des').val();
     var interno = $('#interno').val();
    var dias2 = $('#dias2').val();
    var rendimiento = $('#rendimiento').val();
     var p_galon = $('#p_galon').val(); 
      var res_calculo = $('#res_calculo').val(); 
     
     
    
     //var des = $('#des').val();
   // $.post('combustible/php/crear_solicitud_cupones.php',{dias2: dias2},function(data){
     //   $('fdias').html(data);
       //           });
  //});

    if(total == 0)
    {
      show_notificacion("Debe seleccionar al menos un vehículo",1);
    }
    else {
      if(nFilas == 0){


        $.ajax({



            type: "POST",

            url: "combustible/php/crear_solicitud_cupones.php",
            dataType: 'json',
            data: {des:des,interno:interno,dias2:dias2,rendimiento:rendimiento,p_galon:p_galon,res_calculo:res_calculo}, //f de fecha y u de estado.
           //  data: {}, //f de fecha y u de estado.
            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading').fadeIn("slow");
                  },
                  success:function(data){
                    var year=data.year;
                    var mes= data.mes;
                    var solicitud= data.solicitud_id;
                  //  var password=$('#loginpassword'+id).val(); 


                    $.each($('input[type=checkbox]:checked'), function(){
                      var id = ($(this).data('id'));
                      var conductor_id = $('#conductor_id'+id).val();
                     // var dias2=$('#logindias'+id).val();     
                      var monto=$('#'+id).val();
                      $.ajax({



                          type: "POST",

                          url: "combustible/php/crear_solicitud_cupones_vehiculo.php",

                          data: {year:year,mes:mes,solicitud:solicitud,vehiculo_id:id,monto:monto,conductor_id:conductor_id}, //f de fecha y u de estado.
                          beforeSend:function(){
                                        //$('#response').html('<span class="text-info">Loading response...</span>');

                                        $('#loading_soli_cu').fadeIn("slow");
                                },
                                success:function(data){
                                  //alert(data);
                                }


                        }).done( function() {


                          setTimeout(function(){
                                          $('#loading_soli_cu').fadeOut("slow");
                                     }, 500);







                        }).fail( function( jqXHR, textSttus, errorThrown){

                          alert(errorThrown);

                        })

                    });
                  }


          }).done( function() {
            get_solicitudes_cupones_list();
            setTimeout(function(){
                            $('#loading_soli_cu').fadeOut("slow");
                            $('#modal-remoto-lgg').modal('hide');

                       }, 500);
                       setTimeout(function(){

                                      show_notificacion_success("Cupones Solicitados");
                                 }, 900);







          }).fail( function( jqXHR, textSttus, errorThrown){

            alert(errorThrown);

          });



      }
      else {
        var monto;
        if (nFilas == 1)
        {
          monto = 'monto';
        }
        else {
          monto = 'montos'
        }
        show_notificacion("Tiene "+ nFilas+" "+ monto +" que especificar correctamente",1);
      }
    }













  }); //fin click boton
});//fin función

function sendToServer(data) {
alert(JSON.stringify(data));
}


function evaluar_monto(monto){
  if(monto == 50 || monto == 100  || monto == 150 || monto == 200 || monto == 250 || monto == 300 || monto == 350 || monto == 400|| monto == 450|| monto == 500|| monto == 550|| monto == 600|| monto == 650|| monto == 700|| monto == 750|| monto == 800|| monto == 900 || monto == 950|| monto == 1000|| monto == 1200|| monto == 1300|| monto == 1600|| monto == 3000){
    return true;
  }
  else{
    return false;
  }

}

function remove_message(id){
  $('#tr'+id).removeClass('danger');
  $('#message'+id).fadeOut(200);
}

function show_message(id, message){
  $('#message'+id).show();
  $('#message'+id).text(message);
  $('#tr'+id).addClass('danger');
}

function justNumbers(e)
        {
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
        return true;

        return /\d/.test(String.fromCharCode(keynum));
        }




function checkAll(e) {
         var checkboxes = document.getElementsByName('check');

         if (e.checked) {
           for (var i = 0; i < checkboxes.length; i++) {
             checkboxes[i].checked = true;

           }
         } else {
           for (var i = 0; i < checkboxes.length; i++) {
             checkboxes[i].checked = false;

           }
         }
        }







