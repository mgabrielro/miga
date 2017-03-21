(function(namespace_to_construct){
    "use strict";

    //-------------------"MEMBER VARIABLES"-------------------

    var coupon_input_element;

    //-------------------"PRIVATE METHODS"--------------------

    /**
     * Cross selling code validation; Checks whether the given code is valid or not.
     *
     * @private
     * @param {string} code The code to validate.
     * @param {int} productId The product_id the code belongs to.
     * @param {function(is_valid:boolean):void} callback The callback that is triggered after the validation.
     */
    function _check_coupon_code(code, product_id, callback)
    {
        if(code) {
            c24.register.ajax.check_coupon_code(product_id, code).done(function (data) {
                if (typeof callback === "function") {
                    var is_valid = data.data.status;
                    callback(is_valid);
                }
            }).fail(function (data) {
                if (typeof callback === "function") {
                    callback(false);
                }
            })
        } else {
            if (typeof callback === "function") {
                callback(true);
            }
        }
    }

    /**
     *
     * @private
     */
    function _handle_events()
    {
        coupon_input_element.on('change', function() {

            var code_value = $(this).val();
            var product_id = 11;

            _check_coupon_code(code_value, product_id, function (is_valid)
            {
                (new c24.validator).update_element(coupon_input_element, !(is_valid === true || code_value == ""), 'Coupon Code ist falsch oder ungültig.');
            });
        });
    }

    //-------------------"PRIVATE METHODS"--------------------
    (function(ns){

        //-------------------PSEUDO-CONSTRUCTOR OF THE NAMESPACE--------------------

        /*
         * This is not a constructor in any way, regarding javascript language constructors. It is just a self executing function which is called after all relevant other
         * parts for this namespace are loaded. (The public and the private method definitions)
         * Namespaces are NO Classes, but structured scopes!
         */

        jQuery(document).ready(function(){
            ns.init();
        });

    })(namespace(namespace_to_construct, $.noop, {

        //-------------------PUBLIC METHODS--------------------
        init: function(){
            coupon_input_element = $("#coupon_code");
        },

        check_coupon_code: _check_coupon_code,
        register_events: _handle_events

    }));
})("c24.register.coupon");
