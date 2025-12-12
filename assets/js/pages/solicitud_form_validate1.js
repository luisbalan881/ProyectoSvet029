function add_solicitud1(userid, dep) {
  jQuery('.js-validation-solicitud').validate({
    ignore: [],
    errorClass: 'help-block animated fadeInDown',
    errorElement: 'div',
    errorPlacement: function (error, e) {
      jQuery(e).parents('.form-group > div').append(error);
    },
    highlight: function (e) {
      var elem = jQuery(e);

      elem
        .closest('.form-group')
        .removeClass('has-error')
        .addClass('has-error');
      elem.closest('.help-block').remove();
      $('#boton_s_t').removeClass('vibrar').addClass('vibrar');
    },
    success: function (e) {
      var elem = jQuery(e);

      elem.closest('.form-group').removeClass('has-error');
      $('#boton_s_t').removeClass('vibrar');
      elem.closest('.help-block').remove();
    },
    submitHandler: function (form) {
      //alert('OK');
      var codigo;
      var id = userid;
      var dep1 = dep;

      // soli_tiempo

      //var p = regformhash(form,form.password,form.confirmpwd);

      var fecha = $('#soli_fecha').val();
      var fecha2 = $('#soli_fecha2').val();
      var objetivo1 = $('#objetivo').val();
      //var duracion1=$('#soli_tiempo2').val();
      var dur_en = $('#horas_dias option:selected');
      var lugar = $('#soli_lugar').val(); // luares
      var especificacion = ''; // tiempo

      dur_en.each(function () {
        especificacion = $(this).val();
      });

      var codigo1 = $('#codigo').val();
      var year = new Date().getFullYear();
      //var s = "SVET-";                      // preubas add codigo
      //var codigo3 = s + dep1 +"-" + ano;

      $.ajax({
        type: 'POST',
        url: 'viaticos/php/add_solicitud1.php',
        data: {
          fecha: fecha,
          fecha2: fecha2,
          objetivo: objetivo1,
          especificacion: especificacion,
          dep: dep1,
          id: id,
          lugar: lugar,
          year: year,
        }, //f de fecha y u de estado.

        beforeSend: function () {
          //$('#response').html('<span class="text-info">Loading response...</span>');

          $('#loading').fadeIn('slow');
        },
        success: function (data) {
          //alert(data);
          codigo = data;

          //
          var selected = $('#d_solicitantes option:selected'); // inicio de funcion selected
          var message = '';
          selected.each(function () {
            var inst = $(this).val();
            message = $(this).val();

            var inst = $(this).val();
            //vp_solicitud_transporte_departamento

            // HTMLtoPDF
            $.ajax({
              type: 'POST',
              url: 'viaticos/php/add_solicitud_detalle1.php',
              data: { codigo: codigo, inst: inst }, //f de fecha y u de estado.

              beforeSend: function () {
                //$('#response').html('<span class="text-info">Loading response...</span>');

                $('#loading1').fadeIn('slow');
              },
              success: function (data) {
                //alert(data);

                setTimeout(function () {
                  $('#loading1').fadeOut('slow');
                }, 500);
                $('#message').fadeIn().html(data);
                $('#message').addClass('alert alert-success');
                setTimeout(function () {
                  $('#message').fadeOut('slow');
                  $('#loading1').fadeOut('slow');
                  $('#modal-remoto-lgg').modal('hide');
                  show_notificacion_success(
                    'Solicitud y Nombramiento Generada'
                  );
                  setTimeout(function () {
                    window.location.href = '?ref=_89';
                  }, 1000);
                  //get_horarios_usuario();
                }, 300);

                //  HTMLtoPDF1(codigo);
                // HTMLtoPDFV(codigo);

                // datos_hoja_cupones5(codigo);
              },
            })
              .done(function (data) {})
              .fail(function (jqXHR, textSttus, errorThrown) {
                alert(errorThrown);
              });
          }); // fin de funcion selected

          var selected2 = $('#d_solicitantes2 option:selected'); // inicio de funcion selected22
          var message2 = '';
          selected2.each(function () {
            var inst2 = $(this).val();
            message2 = $(this).val();

            var inst2 = $(this).val();
            //vp_solicitud_transporte_departamento

            //
            $.ajax({
              type: 'POST',
              url: 'viaticos/php/add_solicitud_detalle2.php',
              data: { codigo: codigo, inst2: inst2 }, //f de fecha y u de estado.

              beforeSend: function () {
                //$('#response').html('<span class="text-info">Loading response...</span>');

                $('#loading1').fadeIn('slow');
              },
              success: function (data) {
                //alert(data);

                setTimeout(function () {
                  $('#loading1').fadeOut('slow');
                }, 500);
                $('#message').fadeIn().html(data);
                $('#message').addClass('alert alert-success');
                setTimeout(function () {
                  $('#message').fadeOut('slow');
                  $('#loading1').fadeOut('slow');
                  $('#modal-remoto-lgg').modal('hide');
                  show_notificacion_success('Satisfactoriamente');
                  //get_horarios_usuario();
                }, 300);

                //  HTMLtoPDFV4(codigo);
                //  datos_hoja_cupones5(codigo);
              },
            })
              .done(function (data) {})
              .fail(function (jqXHR, textSttus, errorThrown) {
                alert(errorThrown);
              });
          }); // fin de funcion selected2
        }, // fin de funcion data
      });
    },
  });
}

//SOLICITURD add_solicitud_manual
