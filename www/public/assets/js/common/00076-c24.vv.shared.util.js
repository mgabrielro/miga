/**
 * Use this namespace c24.vv.shared.util, if methode are helper and can use for other application
 *
 * @author Sebastian Bretschneider <sebastian.bretschneider@check24.de>
 */
(function (window, document, $) {

    "use strict";

    var ns = namespace("c24.vv.shared");

    ns.util = {

        /**
         * Scroll the page to top with animate function and default is 0 pixel and move slow
         *
         * @param {integer} distance_to_top The distance from top in pixel
         */
        scroll_top: function (distance_to_top) {

            if(typeof distance_to_top == 'undefined') {
                distance_to_top = 0;
            }

            $('html, body').animate({
                scrollTop: distance_to_top
            }, 'slow');

        },

        /**
         * Add a class 'select-default-color' in element span with the class name c24-form-select, if the selectfield is default.
         * 
         * @param {string} element The name of element from selectfield
         */
        set_class_defaultvalue_by_selectfield: function (element){

                if ($(element).parent().find('span.c24-form-select').text().trim() == 'Bitte wählen' || $(element).val() == null) {
                    $(element).parent().find('span.c24-form-select').addClass('select-default-color');
                } else {
                    $(element).parent().find('span.c24-form-select').removeClass('select-default-color');
                }
            
        },

        /**
         * Runs a setTimeout and calls a callback function after delay
         *
         * @param {function} callback The callback function for timeout
         * @param {int} milliseconds Number of milliseconds for timeout
         * @returns {boolean}
         */
        run_set_timeout: function(callback, milliseconds) {

            if (callback == '' || typeof callback == 'undefined' || typeof callback != 'function') {
                return false;
            }

            if (typeof (milliseconds) != 'number' || milliseconds == undefined || typeof milliseconds == 'undefined') {
                milliseconds = 200;
            }

            setTimeout(function(){
                callback();
            }, milliseconds);

            return true

        },

        /**
         * Check if there is a prefill of the login fields and fade out the login
         */
        check_login_of_prefill_and_fade_out: function() {

            if ($('#c24_customer_login_email').val() != '' && $('#c24login_user_id_hidden').val() == '' && $('#deviceoutput_app').val() == 'no') {
                $('#c24-customer-account-default-login-link').click();
            }

        }        

    }

})(window, document, jQuery);