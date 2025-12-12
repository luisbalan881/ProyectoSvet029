function modificar_empleado(creador, empleado){

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
              emp=empleado;
              user_nm1=$('#user_nm11').val();
              user_nm2=$('#user_nm22').val();
              user_ap1=$('#user_ap11').val();
              user_ap2=$('#user_ap22').val();
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
              fecha_posesion=$('#fecha_posesion').val();
              fecha_inicio=$('#fecha_inicio').val();
              //user_status=$('#user_status').val();







              $.ajax({
                type: "POST",
                url: "usuarios/php/modificar_empleado.php",
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
                fecha_posesion:fecha_posesion,
                fecha_inicio:fecha_inicio,
                //user_status:user_status,
                emp:emp
              }, //f de fecha y u de estado.

                beforeSend:function(){
                              //$('#response').html('<span class="text-info">Loading response...</span>');

                              $('#loading_me').fadeIn("slow");
                      },
                      success:function(data){
                        //alert(data);

                        $("#em_form")[0].reset();
                        setTimeout(function(){
                                        $('#loading_me').fadeOut("slow");
                                        show_notificacion_success("Empleado modificado");
                                        cargar();
                                   }, 3000);
                         $('#message').fadeIn().html(data);
                         $("#message").addClass('alert alert-success');
                         setTimeout(function(){
                                        $('#message').fadeOut("slow");
                                        $('#loading_me').fadeOut("slow");
                                        $('#modal-remoto-lgg').modal('hide');

                                   }, 2000);

                      }


              }).done( function() {










              }).fail( function( jqXHR, textSttus, errorThrown){

                alert(errorThrown);

              });
          }

      });

}


function desactivar_user(user,emp){


          //regformhash(form,form.password,form.confirmpwd);
          //id=u_id;
          emp=emp;
          user:user;
          //alert(emp+ ' ' + user)





          $.ajax({
            type: "POST",
            url: "usuarios/php/desactivar_empleado.php",
            data: {
            emp:emp,
            user:user
          }, //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading_de').fadeIn("slow");
                  },
                  success:function(data){
                    //alert(data);
                    //$("#em_form")[0].reset();
                    setTimeout(function(){
                                    $('#loading_de').fadeOut("slow");
                                    cargar();
                               }, 3000);
                     $('#message').fadeIn().html(data);
                     $("#message").addClass('alert alert-success');
                     setTimeout(function(){
                                    $('#message').fadeOut("slow");
                                    $('#loading_de').fadeOut("slow");
                                    $('#modal-remoto-lgg').modal('hide');

                               }, 2000);

                  }


          }).done( function() {










          }).fail( function( jqXHR, textSttus, errorThrown){

            alert(errorThrown);

          });


}

function reactivar_user(user,emp){


          //regformhash(form,form.password,form.confirmpwd);
          //id=u_id;
          emp=emp;
          user:user;
          //alert(emp+ ' ' + user)





          $.ajax({
            type: "POST",
            url: "../herramientas/usuarios/php/reactivar_empleado.php",
            data: {
            emp:emp,
            user:user
          }, //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading_re_e').fadeIn("slow");
                  },
                  success:function(data){
                    //alert(data);
                    //$("#em_form")[0].reset();
                    setTimeout(function(){
                                    $('#loading_re_e').fadeOut("slow");
                                    cargar();
                               }, 3000);
                     $('#message').fadeIn().html(data);
                     $("#message").addClass('alert alert-success');
                     setTimeout(function(){
                                    $('#message').fadeOut("slow");
                                    $('#loading_re_e').fadeOut("slow");
                                    $('#modal-remoto-lgg').modal('hide');

                               }, 2000);

                  }


          }).done( function() {










          }).fail( function( jqXHR, textSttus, errorThrown){

            alert(errorThrown);

          });


}


function modificar_011(emp,correlativo){

      jQuery('.js-validation-empleado-011-m').validate({
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


              user_acuerdo=$('#user_acuerdo22').val();
              fecha_acuerdo=$('#fecha_acuerdo22').val();
              user_partida=$('#user_partida22').val();
              fecha_inicio=$('#fecha_inicio22').val();
              user_puesto=$('#user_puesto22').val();
              user_cargo=$('#user_cargo22').val();

              salario_base=$('#salario_base').val();
              complemento_personal=$('#complemento_personal').val();
              bono_antiguedad=$('#bono_antiguedad').val();
              bono_profesional=$('#bono_profesional').val();
              bono_vicepresidencial=$('#bono_vicepresidencial').val();
              bono_66_2000=$('#bono_66_2000').val();
              gastos_de_representacion=$('#gastos_de_representacion').val();
              viaticos=$('#viaticos').val();







              $.ajax({
                type: "POST",
                url: "usuarios/php/editar_partida_011.php",
                data: {
                  emp:emp,
                  correlativo:correlativo,

                user_acuerdo:user_acuerdo,
                fecha_acuerdo:fecha_acuerdo,
                user_partida:user_partida,
                fecha_inicio:fecha_inicio,
                user_puesto:user_puesto,
                user_cargo:user_cargo,
                salario_base:salario_base,
                complemento_personal:complemento_personal,
                bono_antiguedad:bono_antiguedad,
                bono_profesional:bono_profesional,
                bono_vicepresidencial:bono_vicepresidencial,
                bono_66_2000:bono_66_2000,
                gastos_de_representacion:gastos_de_representacion,
                viaticos:viaticos


              }, //f de fecha y u de estado.

                beforeSend:function(){
                              //$('#response').html('<span class="text-info">Loading response...</span>');

                              $('#loading_me_011').fadeIn("slow");
                      },
                      success:function(data){
                        //alert(data);

                        $('#loading_me_011').fadeOut("slow");

                      }


              }).done( function() {










              }).fail( function( jqXHR, textSttus, errorThrown){

                alert(errorThrown);

              });
          }

      });

}

function nuevo_011(emp){

      jQuery('.js-validation-empleado-011-n').validate({
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


              user_acuerdo=$('#user_acuerdo222').val();
              fecha_acuerdo=$('#fecha_acuerdo222').val();
              user_partida=$('#user_partida222').val();
              fecha_inicio=$('#fecha_inicio222').val();
              user_puesto=$('#user_puesto222').val();
              user_cargo=$('#user_cargo222').val();

              salario_base=$('#salario_base1').val();
              complemento_personal=$('#complemento_personal1').val();
              bono_antiguedad=$('#bono_antiguedad1').val();
              bono_profesional=$('#bono_profesional1').val();
              bono_vicepresidencial=$('#bono_vicepresidencial1').val();
              bono_66_2000=$('#bono_66_20001').val();
              gastos_de_representacion=$('#gastos_de_representacion1').val();
              viaticos=$('#viaticos1').val();







              $.ajax({
                type: "POST",
                url: "usuarios/php/nueva_partida_011.php",
                data: {
                  emp:emp,


                user_acuerdo:user_acuerdo,
                fecha_acuerdo:fecha_acuerdo,
                user_partida:user_partida,
                fecha_inicio:fecha_inicio,
                user_puesto:user_puesto,
                user_cargo:user_cargo,
                salario_base:salario_base,
                complemento_personal:complemento_personal,
                bono_antiguedad:bono_antiguedad,
                bono_profesional:bono_profesional,
                bono_vicepresidencial:bono_vicepresidencial,
                bono_66_2000:bono_66_2000,
                gastos_de_representacion:gastos_de_representacion,
                viaticos:viaticos


              }, //f de fecha y u de estado.

                beforeSend:function(){
                              //$('#response').html('<span class="text-info">Loading response...</span>');

                              $('#loading_ne_011').fadeIn("slow");
                      },
                      success:function(data){
                        //alert(data);

                        $('#loading_ne_011').fadeOut("slow");
                        cargar_panel_ascensos(emp);

                      }


              }).done( function() {










              }).fail( function( jqXHR, textSttus, errorThrown){

                alert(errorThrown);

              });
          }

      });

}


function modificar_029(emp,correlativo){

      jQuery('.js-validation-empleado-029-m').validate({
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


              user_acuerdo=$('#user_acuerdo22').val();
              fecha_acuerdo=$('#fecha_acuerdo22').val();
              user_partida=$('#user_partida22').val();
              fecha_inicio=$('#fecha_inicio22').val();
              user_puesto=$('#user_puesto22').val();
              user_cargo=$('#user_cargo22').val();

              salario_base=$('#salario_base').val();

              contrato_num=$('#contrato_num').val();
              contrato_fecha=$('#contrato_fecha').val();
              fianza=$('#fianza').val();
              contrato_ini=$('#contrato_ini').val();
              contrato_fin=$('#contrato_fin').val();







              $.ajax({
                type: "POST",
                url: "usuarios/php/editar_partida_029.php",
                data: {
                  emp:emp,
                  correlativo:correlativo,

                user_acuerdo:user_acuerdo,
                fecha_acuerdo:fecha_acuerdo,
                user_partida:user_partida,
                fecha_inicio:fecha_inicio,
                user_puesto:user_puesto,
                user_cargo:user_cargo,
                salario_base:salario_base,
                contrato_num:contrato_num,
                contrato_fecha:contrato_fecha,
                fianza:fianza,
                contrato_ini:contrato_ini,
                contrato_fin:contrato_fin


              }, //f de fecha y u de estado.

                beforeSend:function(){
                              //$('#response').html('<span class="text-info">Loading response...</span>');

                              $('#loading_me_029').fadeIn("slow");
                      },
                      success:function(data){
                        alert(data);

                        $('#loading_me_029').fadeOut("slow");

                      }


              }).done( function() {










              }).fail( function( jqXHR, textSttus, errorThrown){

                alert(errorThrown);

              });
          }

      });

}

function nuevo_029(emp){

      jQuery('.js-validation-empleado-029-n').validate({
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


              user_acuerdo=$('#user_acuerdo222').val();
              fecha_acuerdo=$('#fecha_acuerdo222').val();
              user_partida=$('#user_partida222').val();
              fecha_inicio=$('#fecha_inicio222').val();
              user_puesto=$('#user_puesto222').val();
              user_cargo=$('#user_cargo222').val();

              salario_base=$('#salario_base11').val();

              contrato_num=$('#contrato_num1').val();
              contrato_fecha=$('#contrato_fecha1').val();
              fianza=$('#fianza1').val();
              contrato_ini=$('#contrato_ini1').val();
              contrato_fin=$('#contrato_fin1').val();







              $.ajax({
                type: "POST",
                url: "usuarios/php/nueva_partida_029.php",
                data: {
                  emp:emp,


                user_acuerdo:user_acuerdo,
                fecha_acuerdo:fecha_acuerdo,
                user_partida:user_partida,
                fecha_inicio:fecha_inicio,
                user_puesto:user_puesto,
                user_cargo:user_cargo,
                salario_base:salario_base,
                contrato_num:contrato_num,
                contrato_fecha:contrato_fecha,
                fianza:fianza,
                contrato_ini:contrato_ini,
                contrato_fin:contrato_fin


              }, //f de fecha y u de estado.

                beforeSend:function(){
                              //$('#response').html('<span class="text-info">Loading response...</span>');

                              $('#loading_ne_029').fadeIn("slow");
                      },
                      success:function(data){
                        //alert(data);

                        $('#loading_ne_029').fadeOut("slow");
                        cargar_panel_ascensos(emp);

                      }


              }).done( function() {










              }).fail( function( jqXHR, textSttus, errorThrown){

                alert(errorThrown);

              });
          }

      });

}


function destitucion_user(emp,correlativo){

      jQuery('.js-validation-empleado-destitucion-m').validate({
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
              resolucion_no=$('#resolucion_num').val();
              resolucion_fecha=$('#resolucion_fecha').val();
              tipo_cancelacion_c=$('#tipo_cancelacion_c').val();
              fecha_fin=$('#fecha_fin').val();
              if(confirm('¿Realmente quiere finalizar este documento?'))
              $.ajax({
                type: "POST",
                url: "usuarios/php/finalizar_contrato_user.php",
                data: {
                  emp:emp,
                  correlativo:correlativo,

                  resolucion_no:resolucion_no,
                  resolucion_fecha:resolucion_fecha,
                  tipo_cancelacion_c:tipo_cancelacion_c,
                  fecha_fin:fecha_fin



              }, //f de fecha y u de estado.

                beforeSend:function(){
                              //$('#response').html('<span class="text-info">Loading response...</span>');

                              $('#loading_me_cont').fadeIn("slow");
                      },
                      success:function(data){
                        //alert(data);

                        $('#loading_me_cont').fadeOut("slow");
                        cargar_panel_ascensos(emp);

                      }


              }).done( function() {










              }).fail( function( jqXHR, textSttus, errorThrown){

                alert(errorThrown);

              });
          }

      });

}



function sum2() {
  var a = document.getElementById('salario_base').value;
  var b = document.getElementById('complemento_personal').value;
  var c = document.getElementById('bono_antiguedad').value;
  var d = document.getElementById('bono_profesional').value;
  var e = document.getElementById('bono_vicepresidencial').value;
  var f = document.getElementById('bono_66_2000').value;
  var g = document.getElementById('gastos_de_representacion').value;
  var h = document.getElementById('viaticos').value;




  var result = parseFloat(a) + parseFloat(b) + parseFloat(c) + parseFloat(d) + parseFloat(e) + parseFloat(f) + parseFloat(g) + parseFloat(h);
  var r = result.toFixed(2);

  if (!isNaN(result)) {
      document.getElementById('liquido').value = r;

  }
}
