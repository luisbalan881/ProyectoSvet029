/*
 *  Document   : proveedor_forms_validation.js
 *  Author     : stuart.carazo
 *  Description: Custom JS code used in Form Validation Page
 */

var ProveedorFormValidation = function() {
    // Init Proveedor Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationProveedor = function(){
        jQuery('.js-validation-proveedor').validate({
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
                'prov_nit': {
                    remote: {
                        url: 'proveedores/proveedor_validar.php',
                        data: {prov_id: function(){ return $('#prov_id').val();}}
                    }
                }

            },
            messages: {
                'prov_nit': {
                    remote: "Ya existe otro proveedor con este NIT."
                }
            }
        });
    };

    return {
        init: function () {
            // Init Proveedor Forms Validation
            initValidationProveedor();
;

            // Init Validation on Select2 change
            jQuery('.js-select2').on('change', function(){
                jQuery(this).valid();
            });
        }
    };
}();

// Initialize when page loads
jQuery(function(){ ProveedorFormValidation.init(); });
