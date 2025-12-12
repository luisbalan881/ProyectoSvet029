/*
 *  Document   : usuarios_forms_validation.js
 *  Author     : stuart.carazo
 *  Description: Custom JS code used in Form Validation Page
 */

var UsuariosFormValidation = function() {
    // Init Usuarios Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationUsuario = function(){
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
                $("#boton_a_u").removeClass('vibrar').addClass('vibrar');
            },
            success: function(e) {
                var elem = jQuery(e);

                elem.closest('.form-group').removeClass('has-error');
                $("#boton_a_u").removeClass('vibrar');
                elem.closest('.help-block').remove();
            },
            submitHandler: function(form){
                regformhash(form,form.password,form.confirmpwd);
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
    };

    var initValidationIggs = function(){
        jQuery('.js-validation-iggs').validate({
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
                regformhash(form,form.password,form.confirmpwd);
                cargar();
            },
            rules: {
                'from': {
                    remote: {
                        url: 'usuarios/validar_fecha_suspencion.php',
                        data: {
                          from: function(){ return $('#from').val();},
                          codigo: function(){ return $('#codigo').val();}

                      }
                    }
                },

                'resolucion': {
                    remote: {
                        url: 'usuarios/validar_resolucion_suspencion.php',
                        data: {
                          from: function(){ return $('#resolucion').val();},

                      }
                    }
                }




            },
            messages: {
                'from': {
                    remote: "La fecha no existe en los horarios."
                },
                'resolucion':{
                  remote: "La resolución ya existe."
                }
            }

        });
    };

    return {
        init: function () {
            // Init Usuarios Forms Validation
            initValidationUsuario();
            initValidationIggs();

            // Init Validation on Select2 change
            jQuery('.js-select2').on('change', function(){
                jQuery(this).valid();
            });
        }
    };
}();

// Initialize when page loads
jQuery(function(){ UsuariosFormValidation.init(); });
