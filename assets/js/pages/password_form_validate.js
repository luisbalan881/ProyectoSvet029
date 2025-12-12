function insertData(userid) {
  jQuery('.js-validation-usuario').validate({
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
          var p = regformhash(form,form.password,form.confirmpwd);
          var pw=p;//$("#password").val();
          var id=userid;

          $.ajax({

            type: "POST",
            url: "administrador/scripts_php/change_password.php",
            data: {pw:pw, id:id}, //f de fecha y u de estado.

            beforeSend:function(){
                          //$('#response').html('<span class="text-info">Loading response...</span>');

                          $('#loading').fadeIn("slow");
                  },
                  success:function(data){
                    //alert(data);
                    $("#loginForm")[0].reset();
                    setTimeout(function(){
                                    $('#loading').fadeOut("slow");
                               }, 5000);
                               if(data="Contraseña no cumple los requisitos"){
                                 //show_notificacion_warning(data);
                               }
                               else {
                                 show_notificacion_success("Contraseña establecida");
                               }

                     //$("#message").addClass('alert alert-success');
                     setTimeout(function(){
                                    //$('#message').fadeOut("slow");
                                    $('#loading').fadeOut("slow");
                                    $('#modal-remoto').modal('hide');

                               }, 500);
                  }


          }).done( function() {










          }).fail( function( jqXHR, textSttus, errorThrown){

            alert(errorThrown);

          });


      },
      rules: {
          'user_mail': {
              required: false,
              email: false
          },
          'password': {
              required: true,
              minlength: 6
          },
          'confirmpwd': {
              required: true,
              equalTo: '#password'
          }
      },
      messages: {
          'user_mail': 'Por favor ingrese un email valido',
          'password': {
              required: 'Por favor ingrese un password',
              minlength: 'El password debe tener al menos 5 caracteres de largo'
          },
          'confirmpwd': {
              required: 'Por favor ingrese un password.',
              minlength: 'El password debe tener al menos 5 caracteres de largo',
              equalTo: 'Por favor ingrese el mismo password.'
          }
      }


  });

}
