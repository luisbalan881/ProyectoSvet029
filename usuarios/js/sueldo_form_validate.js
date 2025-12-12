function update_sueldo_user(u_id){

      jQuery('.js-validation-sueldos').validate({
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
              id=u_id;
              salario_base=$('#salario_base').val();
              complemento_personal=$('#complemento_personal').val();
              bono_antiguedad=$('#bono_antiguedad').val();
              bono_profesional=$('#bono_profesional').val();
              bono_vicepresidencial=$('#bono_vicepresidencial').val();
              bono_66_2000=$('#bono_66_2000').val();
              gastos_de_representacion=$('#gastos_de_representacion').val();
              viaticos=$('#viaticos').val();
              igss=$('#igss').val();
              montepio=$('#montepio').val();
              decreto_81_70=$('#decreto_81_70').val();

              $.ajax({
                type: "POST",
                url: "../herramientas/usuarios/php/update_sueldos.php",
                data: {id:id,
                salario_base:salario_base,
                complemento_personal:complemento_personal,
                bono_antiguedad:bono_antiguedad,
                bono_profesional:bono_profesional,
                bono_vicepresidencial:bono_vicepresidencial,
                bono_66_2000:bono_66_2000,
                gastos_de_representacion:gastos_de_representacion,
                viaticos:viaticos,
                igss:igss,
                montepio:montepio,
                decreto_81_70:decreto_81_70
              }, //f de fecha y u de estado.

                beforeSend:function(){
                              //$('#response').html('<span class="text-info">Loading response...</span>');

                              $('#loading').fadeIn("slow");
                      },
                      success:function(data){
                        //alert(data);
                        show_notificacion_success("Sueldos establecidos");
                        $("#su_form")[0].reset();
                        setTimeout(function(){
                                        $('#loading').fadeOut("slow");
                                   }, 5000);
                         $('#message').fadeIn().html(data);
                         $("#message").addClass('alert alert-success');
                         setTimeout(function(){
                                        $('#message').fadeOut("slow");
                                        $('#loading').fadeOut("slow");
                                        $('#modal-remoto').modal('hide');
                                          //cargar();
                                   }, 900);

                      }


              }).done( function() {










              }).fail( function( jqXHR, textSttus, errorThrown){

                alert(errorThrown);

              });
          }

      });

}

$(document).ready(function() {
//this calculates values automatically

if ( $("#igss").length>0 ) {
  sum();
  $("#salario_base, #complemento_personal, #bono_antiguedad, #bono_profesional,#bono_vicepresidencial,#bono_66_2000,#gastos_de_representacion,#viaticos,#igss,#montepio,#decreto_81_70").on("keydown keyup", function() {
  sum();
  });
}
else{
  sum2();
  $("#salario_base, #complemento_personal, #bono_antiguedad, #bono_profesional,#bono_vicepresidencial,#bono_66_2000,#gastos_de_representacion,#viaticos").on("keydown keyup", function() {
  sum2();
  });
}

});

function sum() {
  var a = document.getElementById('salario_base').value;
  var b = document.getElementById('complemento_personal').value;
  var c = document.getElementById('bono_antiguedad').value;
  var d = document.getElementById('bono_profesional').value;
  var e = document.getElementById('bono_vicepresidencial').value;
  var f = document.getElementById('bono_66_2000').value;
  var g = document.getElementById('gastos_de_representacion').value;
  var h = document.getElementById('viaticos').value;

  var i = document.getElementById('igss').value;
  var j = document.getElementById('montepio').value;
  var k = document.getElementById('decreto_81_70').value;

  var gastos1 = parseFloat(i) + parseFloat(j) + parseFloat(k);

  var result = parseFloat(a) + parseFloat(b) + parseFloat(c) + parseFloat(d) + parseFloat(e) + parseFloat(f) + parseFloat(g) + parseFloat(h);


  var liquido = result -gastos1;
  var l = liquido.toFixed(2);
  var r = result.toFixed(2);

  if (!isNaN(result) ) {
    document.getElementById('totaly').value = r;
  }
  if(!isNaN(liquido))
  {
    document.getElementById('liquido').value = l;
  }
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
