/*
 *  Document   : cheque_forms_validation.js
 *  Author     : stuart.carazo
 *  Description: Custom JS code used in Form Validation Page
 */

var ChequeFormValidation = function() {
    // Init Bancos Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationBanco = function(){
        jQuery('.js-validation-banco').validate({
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

    // Init Creditos Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationCredito = function(){
        jQuery('.js-validation-credito').validate({
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

    // Init Debitos Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationDebito = function(){
        jQuery('.js-validation-debito').validate({
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

    // Init Vouchers Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationVoucher = function(){
        jQuery('.js-validation-voucher').validate({
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
                'vchr_num': {
                    remote: {
                        url: 'cheques/voucher_num_validar.php',
                        data: {vchr_id: function(){ return $('#vchr_id').val();}}
                    }
                }

            },
            messages: {
                'vchr_num': {
                    remote: "Ya se le asigno No. a otro voucher."
                }
            }
        });
    };


    return {
        init: function () {
            // Init Cheques Forms Validation
            initValidationBanco();
            initValidationCredito();
            initValidationDebito();
            initValidationVoucher();

            // Init Validation on Select2 change
            jQuery('.js-select2').on('change', function(){
                jQuery(this).valid();
            });
        }
    };
}();

// Initialize when page loads
jQuery(function(){ ChequeFormValidation.init(); });
