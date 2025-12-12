function crear_empleado(creador){

      jQuery('.js-validation-empleado').validate({
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
          },
          success: function(e) {
              var elem = jQuery(e);

              elem.closest('.form-group').removeClass('has-error');
              elem.closest('.help-block').remove();
          },
          submitHandler: function(form){
              //regformhash(form,form.password,form.confirmpwd);
              //id=u_id;

              user_nm1=$('#user_nm1').val();
              user_nm2=$('#user_nm2').val();
              user_ap1=$('#user_ap1').val();
              user_ap2=$('#user_ap2').val();
              fecha_nac=$('#fecha_nac').val();
              user_lugar_nac=$('#user_lugar_nac').val();
              user_genre=$('#user_genre').val();
              user_civil=$('#user_civil').val();
              user_cui=$('#user_cui').val();
              user_movil=$('#user_movil').val();
              user_prof=$('#user_prof').val();
              user_direccion=$('#user_direccion').val();
              dep_id=$('#dep_id').val();
              user_puesto=$('#user_puesto').val();
              user_cargo=$('#user_cargo').val();
              nacionalidad=$('#nacionalidad').val();

              user_id=creador;

              user_acuerdo=$('#user_acuerdo').val();
              fecha_acuerdo=$('#fecha_acuerdo').val();
              renglon=$('#renglon').val();
              user_igss=$('#user_igss').val();
              user_nit=$('#user_nit').val();
              user_partida=$('#user_partida').val();
              //fecha_posesion=$('#fecha_posesion').val();
              fecha_inicio=$('#fecha_inicio').val();

              contrato_num=$('#contrato_num').val();
              contrato_fecha=$('#contrato_fecha').val();
              fianza=$('#fianza').val();
              contrato_ini=$('#contrato_ini').val();
              contrato_fin=$('#contrato_fin').val();







              $.ajax({
                type: "POST",
                url: "usuarios/php/crear_empleado.php",
                data: {user_nm1:user_nm1,
                user_nm2:user_nm2,
                user_ap1:user_ap1,
                user_ap2:user_ap2,
                fecha_nac:fecha_nac,
                user_lugar_nac:user_lugar_nac,
                user_genre:user_genre,
                user_civil:user_civil,
                user_cui:user_cui,
                user_movil:user_movil,
                user_prof:user_prof,
                user_direccion:user_direccion,
                dep_id:dep_id,
                user_puesto:user_puesto,
                user_cargo:user_cargo,
                nacionalidad:nacionalidad,
                user_id:user_id,
                user_acuerdo:user_acuerdo,
                fecha_acuerdo:fecha_acuerdo,
                renglon:renglon,
                user_igss:user_igss,
                user_nit:user_nit,
                user_partida:user_partida,

                fecha_inicio:fecha_inicio,
                contrato_num:contrato_num,
                contrato_fecha:contrato_fecha,
                fianza:fianza,
                contrato_ini:contrato_ini,
                contrato_fin:contrato_fin
              }, //f de fecha y u de estado.

                beforeSend:function(){
                              //$('#response').html('<span class="text-info">Loading response...</span>');

                              $('#loading_ne').fadeIn("slow");
                      },
                      success:function(data){
                        //alert(data);

                        $("#en_form")[0].reset();
                        setTimeout(function(){
                                        $('#loading_ne').fadeOut("slow");
                                        show_notificacion_success("Empleado creado");
                                   }, 5000);
                         $('#message').fadeIn().html(data);
                         $("#message").addClass('alert alert-success');
                         setTimeout(function(){
                                        $('#message').fadeOut("slow");
                                        $('#loading_ne').fadeOut("slow");
                                        $('#modal-remoto-lgg').modal('hide');
                                          cargar();
                                   }, 900);

                      }


              }).done( function() {










              }).fail( function( jqXHR, textSttus, errorThrown){

                alert(errorThrown);

              });
          }

      });

}
