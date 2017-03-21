(function(){
    "use strict";

    var ns = namespace("c24.check24.input.error");

    ns.load = function (ajax_url) {

        this.url = ajax_url;

        ns.load.instances.push(this);
        this.instanceNum = ns.load.instances.length - 1;

        this.ajax_result = null;

    };

    ns.load.instances = [];

    ns.load.prototype = {

        // add error classes to given element
        addError: function (element, msg) {
            var form_element = element.closest('div[class^="c24-er-element"]');
            var is_duplicate = form_element.find('.c24-error:contains(' + msg + ')').length != 0;
            var selector = '.c24-input-multi, .c24-input-containter';

            element.parents(selector).addClass('c24-error-input-element');
            element.parents('.c24-register-row').find('.c24-fe-radio.boxed').addClass('c24-error-input-element'); // used for radio button groups

            form_element.find('.c24-input-containter').removeClass('c24-active-input-element');

            if(is_duplicate) {
                return;
            }

            var error_message_element = form_element.find('.c24-error').not(":visible").first();
            error_message_element.html(msg);
            error_message_element.show();

        },

        // remove error classes
        removeError: function (element, msg) {

            var selector = '.c24-input-multi, .c24-input-containter';

            element.parents(selector).removeClass('c24-error-input-element');
            element.parents('.c24-register-row').find('.c24-error-input-element').removeClass('c24-error-input-element'); // used for radio button groups

            var form_element = element.closest('div.c24-er-element');
            var error_div = form_element.find('.c24-error:contains(' + msg + ')');

            error_div.html('');
            error_div.hide();
        }
    }
})();