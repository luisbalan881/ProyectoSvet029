


  function cancelar_solicitud(comision){
    if(confirm('¿Realmente quiere cancelar este solicitud?'))

      $.ajax({

        type: "POST",
        url: "transporte/php/cancelar_solicitud.php",
        data:{comision:comision},
         //f de fecha y u de estado.

        beforeSend:function(){
                      //$('#response').html('<span class="text-info">Loading response...</span>');

                      //$('#loading').fadeIn("slow");
              },
              success:function(data){
                //alert(data);
                get_solicitudes_list();
                load_solicitud_id(comision);
                show_notificacion_warning("Comisión cancelada");
                $('#modal-remoto').modal('hide');
              }


      }).done( function() {

      }).fail( function( jqXHR, textSttus, errorThrown){

        alert(errorThrown);

      });

  }




    function finalizar_solicitud(comision){
      if(confirm('¿Realmente quiere finalizar este solicitud?'))
        $.ajax({

          type: "POST",
          url: "transporte/php/finalizar_solicitud.php",
          data:{comision:comision},
           //f de fecha y u de estado.

          beforeSend:function(){
                        //$('#response').html('<span class="text-info">Loading response...</span>');

                        //$('#loading').fadeIn("slow");
                },
                success:function(data){
                  //alert(data);
                  get_solicitudes_list();

                      load_solicitud_id(comision);
                  show_notificacion_success_modal("Solicitud finalizada",1);
                  //$('#modal-remoto-lg').modal('hide');
                }


        }).done( function() {

        }).fail( function( jqXHR, textSttus, errorThrown){

          alert(errorThrown);

        });


    }




      function add_car(comision, user){
        //$('#titulo').text('Modificar Resolución');


        $("#vehiculo option:selected").each(function (){
          carro=$(this).val();

          $("#conductor_id option:selected").each(function (){
            conductor=$(this).val();

            $("#tipo_de_transporte option:selected").each(function (){
              tipo_d_t=$(this).val();


              if(carro!=0)
              {
                if(conductor!=0)
                {
                  if(tipo_d_t!=0)
                  {
                    $.ajax({

                      type: "POST",
                      url: "transporte/php/asignar_vehiculo.php",
                      data:{carro:carro,comision:comision, user:user, conductor:conductor,tipo_d_t:tipo_d_t},
                       //f de fecha y u de estado.

                      beforeSend:function(){
                                    //$('#response').html('<span class="text-info">Loading response...</span>');

                                    //$('#loading').fadeIn("slow");

                            },
                            success:function(data){
                              //alert(data);
                              get_solicitudes_list();

                              show_notificacion_success_modal("Vehículo y conductor asignados",1);
                                    /*Push.create(data, {
                                  icon: "../../herramientas/assets/img/escudo_logo.png"});*/
                                  load_solicitud_id(comision);

                                //$('#modal-remoto-lg').modal('hide');


                            }


                    }).done( function() {

                    }).fail( function( jqXHR, textSttus, errorThrown){

                      alert(errorThrown);

                    });
                  }
                  else{
                    show_notificacion("Seleccione para que va utilizar el vehículo",1);
                  }

                }
                else {
                  show_notificacion("Seleccione un Conductor",1);
                }


                }
                else {
                  show_notificacion("Seleccione un Vehículo",2);
                }

            });
          });

        });

      }



      function delete_car(comision,user){

        $("#vehiculo option:selected").each(function (){
          carro=$(this).val();

          if(carro!=0)
          {
          $.ajax({

            type: "POST",
            url: "transporte/php/cambiar_vehiculo.php",
            data:{carro:carro,comision:comision,user:user},
             //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          //$('#loading').fadeIn("slow");
                  },
                  success:function(data){
                    get_solicitudes_list();
                    //alert(data);

                    show_notificacion_warning("Se ha desasignado el vehículo");
                    $('#modal-remoto').modal('hide');
                  }


          }).done( function() {

          }).fail( function( jqXHR, textSttus, errorThrown){

            alert(errorThrown);

          });


        }
        else {
          Push.create("Seleccione un Vehículo", {
          icon: "assets/img/escudo_logo.png"});
        }

      });

      }

      function ver_textos()
      {


      }

      function establecer_ocupado_carro(solicitud,car,fecha)
      {
        $.ajax({

          type: "POST",
          url: "transporte/php/establecer_ocupados_carros.php",
          data:{solicitud:solicitud,car:car,fecha:fecha},
           //f de fecha y solicitud de estado.

          beforeSend:function(){
                        //$('#response').html('<span class="text-info">Loading response...</span>');

                        //$('#loading').fadeIn("slow");
                },
                success:function(data){
                  //alert(data);
                  get_solicitudes_list();
                  //show_notificacion_success("Vehículos entregados");
                  setTimeout(function(){
                      if(data=='error')
                      {
                        show_notificacion("El vehículo se encuentra en comisión",1);
                      }
                      else if(data=='OK'){
                        show_notificacion_success_modal("Vehículo entragado",1);
                      }

                      load_solicitud_id(solicitud);
                    },900);
                  //$('#modal-remoto-lg').modal('hide');
                }


        }).done( function() {

        }).fail( function( jqXHR, textSttus, errorThrown){

          alert(errorThrown);

        });
      }

      function devolver_ocupado_carro(solicitud,car,fecha)
      {
        $.ajax({

          type: "POST",
          url: "transporte/php/devolver_carro.php",
          data:{solicitud:solicitud,car:car,fecha:fecha},
           //f de fecha y solicitud de estado.

          beforeSend:function(){
                        //$('#response').html('<span class="text-info">Loading response...</span>');

                        //$('#loading').fadeIn("slow");
                },
                success:function(data){
                  //alert(data);
                  get_solicitudes_list();
                  //show_notificacion_success("Vehículos entregados");
                  show_notificacion_success_modal("Vehículo regresado",1);
                    load_solicitud_id(solicitud);

                  //$('#modal-remoto-lg').modal('hide');
                }


        }).done( function() {

        }).fail( function( jqXHR, textSttus, errorThrown){

          alert(errorThrown);

        });
      }

      function update_solicitud(solicitud){

        var fecha=$('#soli_fecha').val();
        var salida=$('#soli_salida').val();
        var duracion=$('#soli_tiempo').val();
        var desc=$("#soli_desc").val();
        var dur_en=$("#horas_dias option:selected");
        var especificacion = "";
        dur_en.each(function ()
      {
         especificacion=$(this).val();
      });
        var cantidad=$('#soli_cantidad').val();


        $.ajax({

          type: "POST",
          url: "transporte/php/update_datos_solicitud.php",
          data:{solicitud:solicitud,fecha:fecha,salida:salida,duracion:duracion,especificacion:especificacion,cantidad:cantidad,desc:desc},
           //f de fecha y solicitud de estado.

          beforeSend:function(){
                        //$('#response').html('<span class="text-info">Loading response...</span>');

                        //$('#loading').fadeIn("slow");
                },
                success:function(data){
                  //alert(data);
                  get_solicitudes_list();
                  //show_notificacion_success("Vehículos entregados");
                  show_notificacion_success_modal("Cambios Guardados",1);
                    load_solicitud_id(solicitud);

                  //$('#modal-remoto-lg').modal('hide');
                }


        }).done( function() {

        }).fail( function( jqXHR, textSttus, errorThrown){

          alert(errorThrown);

        });
      }


      var count = 1;
 $('#add').click(function(){
  count = count + 1;
  var html_code = "<tr id='row"+count+"'>";
   html_code += "<td style='border:1px solid transparent'><div class='input-group has-personalizado'><span class='input-group-addon' ><span class='fa fa-map-marker'></span></span><input type='text' class='form-control item_destino' id='txtd"+count+"' name='item_destino[]' required></input></div></div></td>";
   html_code += "<td style='border:1px solid transparent'><div class='input-group has-personalizado'><span class='input-group-addon' ><span class='fa fa-edit'></span></span><input type='text' class='form-control item_motivo' id='txtm"+count+"' name='item_motivo[]' required></input></div></div></td>";

   html_code += "<td class='text-center' style='border:1px solid transparent'><span style='margin-top:8px;' type='button' name='remove' data-row='row"+count+"' class='btn-minus remove'></span></td>";
   html_code += "</tr>";
   $('#crud_table').append(html_code);
 });

 $(document).on('click', '.remove', function(){
  var delete_row = $(this).data("row");
  $('#' + delete_row).remove();
 });


 function load_solicitud_id(id)
 {
   $('#cerrar_esto').fadeIn(1000);
   $.post("transporte/php/editar_solicitud.php",
   { id:id},
    function(data){
   $("#tabla").html(data);

   });
 }

 function agregar_otro_vehiculo(id)
 {
   $('#cerrar_esto').hide();
   $.post("transporte/php/agregar_otro_vehiculo.php",
   { id:id},
    function(data){
   $("#tabla").html(data);

   });
 }

 function editar_datos_solicitud(id)
 {
   $('#cerrar_esto').hide();
   $.post("transporte/php/editar_datos_solicitud.php",
   { id:id},
    function(data){
   $("#tabla").html(data);

   });
 }

 function editar_motivos_solicitud(id)
 {
   $('#cerrar_esto').hide();
   $.post("transporte/php/editar_datos_destinos.php",
   { id:id},
    function(data){
   $("#tabla").html(data);

   });
 }

 function editar_vehiculos_solicitud(id)
 {
   $('#cerrar_esto').hide();
   $.post("transporte/php/editar_datos_vehiculos.php",
   { id:id},
    function(data){
   $("#tabla").html(data);

   });
 }


// eliminar destino motivo
function eliminar_destino_motivo(solicitud,correlativo){
if(confirm('¿Realmente quiere cancelar este destino?'))
    $.ajax({

      type: "POST",
      url: "transporte/php/update_datos_motivos_solicitud.php",
      data:{solicitud:solicitud,correlativo:correlativo},
       //f de fecha y u de estado.

      beforeSend:function(){
                    //$('#response').html('<span class="text-info">Loading response...</span>');

                    //$('#loading').fadeIn("slow");
            },
            success:function(data){
              //alert(data);
              get_solicitudes_list();

                  load_solicitud_id(solicitud);
              show_notificacion_success_modal("Destino cancelado",1);
              //$('#modal-remoto-lg').modal('hide');
            }


    }).done( function() {

    }).fail( function( jqXHR, textSttus, errorThrown){

      alert(errorThrown);

    });


}

function cancelar_vehiculo_solicitud(solicitud,vehiculo)
{
	if(confirm('¿Realmente quiere cancelar este vehículo?'))
    $.ajax({

      type: "POST",
      url: "transporte/php/editar_vehiculos_asignados.php",
      data:{solicitud:solicitud,vehiculo:vehiculo},
       //f de fecha y u de estado.

      beforeSend:function(){
                    //$('#response').html('<span class="text-info">Loading response...</span>');

                    //$('#loading').fadeIn("slow");
            },
            success:function(data){
              alert(data);
              //get_solicitudes_list();

                  load_solicitud_id(solicitud);
              show_notificacion_success_modal("Vehículo cancelado",1);
              //$('#modal-remoto-lg').modal('hide');
            }


    }).done( function() {

    }).fail( function( jqXHR, textSttus, errorThrown){

      alert(errorThrown);

    });
}