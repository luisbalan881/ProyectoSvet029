/*
 *  Document   : archivo_forms_validation.js
 *  Author     : stuart.carazo
 *  Description: Custom JS code used in Form Validation Page
 */

var ArchivosFormValidation = function() {
    // Init Documentos Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationDocumento = function(){
        jQuery('.js-validation-documento').validate({
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
                form.submit();
                $("button").attr('disabled','disabled');
            },
            rules: {
                'arch_correlativo': {
                    remote: {
                        url: 'archivo/correlativo_validar.php',
                        data: {arch_id: function(){ return $('#arch_id').val();}}
                    }
                }

            },
            messages: {
                'arch_correlativo': {
                    remote: "Ya se le asigno No. de correlativo a otro archivo."
                },
                'arch_original': {
                    accept: 'Por favor ingrese un tipo de archivo valido (xls,xlsx,doc,docx,ppt,pptx,pdf,jpeg,png).'
                },
                'arch_firmado': {
                    accept: 'Por favor ingrese un tipo de archivo valido (pdf).'
                },
                'arch_recibido': {
                    accept: 'Por favor ingrese un tipo de archivo valido (pdf).'
                }
            }
        });
    };

    // Init Documentos Modificar Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationDocumentoModificar = function(){
        jQuery('.js-validation-documento-modificar').validate({
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
                form.submit();
                $("button").attr('disabled','disabled');
            },
            rules: {
                'arch_correlativo': {
                    remote: {
                        url: 'archivo/correlativo_validar.php',
                        data: {arch_id: function(){ return $('#arch_id').val();}}
                    }
                }

            },
            messages: {
                'arch_correlativo': {
                    remote: "Ya se le asigno No. de correlativo a otro archivo."
                },
                'arch_original': {
                    accept: 'Por favor ingrese un tipo de archivo valido (xls,xlsx,doc,docx,ppt,pptx,pdf,jpeg,png).'
                },
                'arch_firmado': {
                    accept: 'Por favor ingrese un tipo de archivo valido (pdf).'
                },
                'arch_recibido': {
                    accept: 'Por favor ingrese un tipo de archivo valido (pdf).'
                }
            }
        });
    };

    // Init Documentos Recibidos Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationDocumentoRecibido = function(){
        jQuery('.js-validation-documento-recibido').validate({
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
                form.submit();
                $("button").attr('disabled','disabled');
            },
            rules: {
                'arch_correlativo': {
                    remote: {
                        url: 'archivo/correlativo_recibido_validar.php',
                        data: {arch_id: function(){ return $('#arch_id').val();}}
                    }
                }

            },
            messages: {
                'arch_correlativo': {
                    remote: "Ya se le asigno No. de correlativo a otro archivo."
                },
                'arch_recibido': {
                    accept: 'Por favor ingrese un tipo de archivo valido (pdf).'
                }
            }
        });
    };

    // Init Documentos Recibidos Modificar Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationDocumentoRecibidoModificar = function(){
        jQuery('.js-validation-documento-recibido-modificar').validate({
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
                form.submit();
                $("button").attr('disabled','disabled');
            },
            rules: {
                'arch_correlativo': {
                    remote: {
                        url: 'archivo/correlativo_recibido_validar.php',
                        data: {arch_id: function(){ return $('#arch_id').val();}}
                    }
                }

            },
            messages: {
                'arch_correlativo': {
                    remote: "Ya se le asigno No. de correlativo a otro archivo."
                },
                'arch_recibido': {
                    accept: 'Por favor ingrese un tipo de archivo valido (pdf).'
                }
            }
        });
    };





    return {
        init: function () {
            // Init Documento Forms Validation
            initValidationDocumento();

            // Init Documento Modificar Forms Validation
            initValidationDocumentoModificar();

            // Init Documento Forms Validation
            initValidationDocumentoRecibido();

            // Init Documento Modificar Forms Validation
            initValidationDocumentoRecibidoModificar();


            // Init Validation on Select2 change
            jQuery('.js-select2').on('change', function(){
                jQuery(this).valid();
            });
        }
    };
}();

// Initialize when page loads
jQuery(function(){ ArchivosFormValidation.init(); });
