/*
 *  Document   : almacen_forms_validation.js
 *  Author     : stuart.carazo
 *  Description: Custom JS code used in Form Validation Page
 */

var AlmacenFormValidation = function() {

    // Init Egreso Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationEgresoNuevo = function(){
        jQuery('.js-validation-egreso_nuevo').validate({
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
                'prod_id': {
                    required: true,
                    number: true
                },
                'egr_cant': {
                    required: true,
                    remote: {
                        url: 'almacen/egreso_validar.php',
                        data: {
                            prod_id: function(){ return $('#prod_id').val();},
                            req_fecha: function(){ return $('#req_fecha').val();}
                        }
                    }
                },
                'egr_fecha': {
                    required: true
                }
            },
            messages: {
                'prod_id': {
                    required: 'Por favor seleccione un producto.',
                    number: 'Debe seleccionar un producto'
                },
                'egr_cant': {
                    required: 'Por favor ingrese una cantidad.',
                    remote: 'La cantidad egresada no es valida.'
                },
                'egr_fecha': {
                    required: 'Por favor ingrese una fecha.'
                }
            }
        });
    };

    // Init Egreso Modificar Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationEgresoModificar = function(){
        jQuery('.js-validation-egreso_modificar').validate({
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
            rules: {
                'egr_cant': {
                    required: true
                },
                'egr_fecha': {
                    required: true
                }
            },
            messages: {
                'egr_cant': {
                    required: 'Por favor ingrese una cantidad.'
                },
                'egr_fecha': {
                    required: 'Por favor ingrese una fecha.'
                }
            }
        });
    };

    // Init Producto Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationProducto = function(){
        jQuery('.js-validation-producto').validate({
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
            rules: {
                'codigo': {
                    remote: {
                        url: 'almacen/producto_validar.php',
                        data: {
                            prod_id: function(){ return $('#prod_id').val();},
                            renglon_id: function(){ return $('#renglon_id').val();},
                            codigo_presentacion: function(){return $('#codigo_presentacion').val();}
                        }
                    }
                },
                'codigo_presentacion': {
                    remote: {
                        url: 'almacen/producto_validar.php',
                        data: {
                            prod_id: function(){ return $('#prod_id').val();},
                            renglon_id: function(){ return $('#renglon_id').val();},
                            codigo: function(){return $('#codigo').val();}
                        }
                    }
                }
            },
            messages: {
                'codigo': {
                    remote: 'Ingrese código de insumo válido, no se puede duplicar combinación de código de insumo y código de presentación. Renglón prespuestario 285 y 298 unicamente admite código de insumo cero (0).'
                },
                'codigo_presentacion': {
                    remote: 'Ingrese código de presentación válido, no se puede duplicar combinación de código de insumo y código de presentación. Renglón prespuestario 285 y 298 unicamente admite código de presentación cero (0).'
                },
                'prod_min': {
                    required: 'Por favor ingrese una cantidad.'
                },
                'prod_max': {
                    required: 'Por favor ingrese una cantidad.'
                }
            }
        });
    };

    // Init Renglon Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationRenglon = function(){
        jQuery('.js-validation-renglon').validate({
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
            rules: {
                'renglon_id': {
                    remote: {
                        url: 'almacen/renglon_validar.php'
                    }
                }
            },
            messages: {
                'renglon_id': {
                    remote: "Ya se asigno este número de renglón."
                }
            }
        });
    };

    // Init Facturas Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationFactura = function(){
        jQuery('.js-validation-factura').validate({
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
            rules: {
                'fac_control': {
                    remote: {
                        url: 'almacen/factura_control_validar.php',
                        data: {fac_id: function(){ return $('#fac_id').val();}}
                    }
                },
                'fac_1h': {
                    remote: {
                        url: 'almacen/factura_1h_validar.php',
                        data: {fac_id: function(){ return $('#fac_id').val();}}
                    }
                }
            },
            messages: {
                'fac_control': {
                    remote: "Ya se le asigno No. control a otra factura."
                },
                'fac_1h': {
                    remote: "Ya se le asigno No. 1-H a otra factura."
                }
            }
        });
    };

    // Init Facturas Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationIngreso = function(){
        jQuery('.js-validation-ingreso').validate({
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

            },
            messages: {
                'ing_cant': {
                    min: "Por favor ingresa una cantidad valida."
                },
                'ing_costo': {
                    min: "Por favor ingresa un costo valido."
                }
            }
        });
    };

    // Init Ingreso Modificar Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationIngresoModificar = function(){
        jQuery('.js-validation-ingreso-modificar').validate({
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
            rules: {
                'ing_costo': {
                    min: 0
                }
            },
            messages: {
                'ing_costo': {
                    min: "Por favor ingresa un costo valido."
                }
            }
        });
    };

    // Init Requisicion Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationRequisicion = function(){
        jQuery('.js-validation-requisicion').validate({
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
            rules: {
                'req_num': {
                    remote: {
                        url: 'almacen/requisicion_validar.php',
                        data: {req_id: function(){ return $('#req_id').val();}}
                    }
                }
            },
            messages: {
                'req_num': {
                    remote: "Ya se le asigno No. a otra requisición."
                }
            }
        });
    };

    return {
        init: function () {
            // Init Egreso Forms Validation
            initValidationEgresoNuevo();
            // Init Egreso Forms Validation
            initValidationEgresoModificar();
            // Init Producto Forms Validation
            initValidationProducto();
            // Init Renglon Forms Validation
            initValidationRenglon();
            // Init Facturas Forms Validation
            initValidationFactura();
            // Init Ingreso Forms Validation
            initValidationIngreso();
            // Init Ingreso Modificar Forms Validation
            initValidationIngresoModificar();
            // Init Requisicion Forms Validation
            initValidationRequisicion();

            // Init Validation on Select2 change
            jQuery('.js-select2').on('change', function(){
                jQuery(this).valid();
            });
        }
    };
}();

// Initialize when page loads
jQuery(function(){ AlmacenFormValidation.init(); });
