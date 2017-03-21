(function(window, document, $, undefined) {

    "use strict";

     var ns = namespace("c24.vv.pkv.widget.form.input2.state");

    /**
     * Abstract input2 form state.
     *
     * @abstract
     */
    ns.abstract_state = Class.create({

        form: null,

        /**
         * Sets the given form.
         *
         * @param {jQuery} form A form to set
         */
        set_form: function(form) {
            this.form = form;
        },

        /**
         * Initialize the hospitalization_accommodation.
         *
         * @param {jQuery} element The form element.
         */
        init_hospitalization_accommodation: function (element) {
        },

        /**
         * Initialize the dental.
         *
         * @param {!jQuery} element The form element.
         */
        init_dental: function (element) {
        },

        /**
         * Initialize the provision_costsharing_limit.
         *
         * @param {jQuery} element The form element.
         */
        init_provision_costsharing_limit: function (element) {
        },

        /**
         * Show the tipbox and set tiptext
         *
         * @param {jQuery} element The form element.
         * @param {boolean} visible Show the tipp-text or not.
         * @param {string} text Set a specific text.
         */
        init_help_text: function(element, visible, text) {

            var help_box = $('.c24-checktipp-wrapper', element);

            if(visible == true) {
                help_box.show();
                $('.c24-checktipp-text', element).text(text);
            } else {
                help_box.hide();
            }

        },

        /**
         * Initialize the label_text_provision_costsharing.
         *
         * @param {jQuery} element The form element.
         */
        init_label_text_provision_costsharing: function(element){
        }

    });

})(window, document, jQuery);