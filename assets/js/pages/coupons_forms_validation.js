/*
 *  Document   : base_forms_validation.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Form Validation Page
 */

var CouponsFormValidation = function() {
    // Init Facturas Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationCouponsApplications = function(){
        jQuery('.js-validation-cupones-pedido').validate({
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
                'pedido_num': {
                    remote: {
                        url: 'combustible/cupon_pedido_validar.php',
                        data: {
                            cupon_pedido_id: function(){ return $('#cupon_pedido_id').val();}
                        }
                    }
                }
            },
            messages: {
                'pedido_num': {
                    remote: "El numero de pedido ya esta en uso."
                }
            }
        });
    };

    var initValidationCoupons = function(){
        jQuery('.js-validation-cupones-ing').validate({
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
                'cupon_inicio': {
                    remote: {
                        url: 'combustible/cupon_ing_validar.php',
                        data: {
                            cupon_pedido_id: function(){ return $('#cupon_pedido_id').val();}
                        }
                    }
                },
                'cupon_final': {
                    remote: {
                        url: 'combustible/cupon_ing_validar.php',
                        data: {
                            cupon_pedido_id: function(){ return $('#cupon_pedido_id').val();}
                        }
                    }
                }
            },
            messages: {
                'cupon_inicio': {
                    remote: "El numero de cupón ya existe en el pedido."
                },
                'cupon_final': {
                    remote: "El numero de cupón ya existe en el pedido."
                }
            }
        });
    };

    var initValidationCouponsUpdate = function(){
        jQuery('.js-validation-cupones-ing-update').validate({
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

            }
        });
    };

    //validación form vehículos
    var initValidationVehicle = function(){
        jQuery('.js-validation-cupones-vehiculo').validate({
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
                'placa': {
                    remote: {
                        url: 'combustible/vehiculo_validar.php',
                        data: {vehiculo_id: function(){ return $('#vehiculo_id').val();}}
                    }
                }
            },
            messages: {
                'placa': {
                    remote: "Ya existe vehículo con número de placa."
                }
            }
        });
    };

    //validación form vehículos
    var initValidationVehicleReport = function(){
        jQuery('.js-validation-vehiculo-reporte').validate({
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
                $("#modal-remoto").modal('hide');
            },
            rules: {
                'fecha_inicio': {
                    remote: {
                        url: 'combustible/vehiculo_reporte_validar.php',
                        data: {
                            fecha_fin: function(){ return $('#fecha_fin').val();},
                            vehiculo_id: function(){ return $('#vehiculo_id').val();}
                        }
                    }
                }
            },
            messages: {
                'fecha_inicio': {
                    remote: "No hay movimientos en rango de fecha seleccionado."
                }
            }
        });
    };

    //validación form conductor
    var initValidationDriver = function(){
        jQuery('.js-validation-cupones-conductor').validate({
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

            }
        });
    };

    var initValidationCouponsDispatch = function(){
        jQuery('.js-validation-cupones-egr').validate({
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

            }
        });
    };



    return {
        init: function () {
            initValidationCouponsApplications();
            initValidationCoupons();
            initValidationCouponsUpdate();
            initValidationVehicle();
            initValidationVehicleReport();
            initValidationDriver();
            initValidationCouponsDispatch();

            // Init Validation on Select2 change
            jQuery('.js-select2').on('change', function(){
                jQuery(this).valid();
            });
        }
    };
}();

// Initialize when page loads
jQuery(function(){ CouponsFormValidation.init(); });
