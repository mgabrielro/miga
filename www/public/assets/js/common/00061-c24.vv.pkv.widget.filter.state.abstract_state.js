(function(window, document, $, undefined) {

    "use strict";

     var ns = namespace("c24.vv.pkv.widget.filter.state");

    /**
     * Abstract Filter form state.
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
         * @param {jQuery} element The form element.
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
                $(element).find('.c24-content-row-block-infobox').show();
                $(element).find('.c24-content-row-info-content').addClass('c24-info-icon-open');

            } else {

                help_box.hide();
                $(element).find('.c24-content-row-block-infobox').hide();
                $(element).find('.c24-content-row-info-content').removeClass('c24-info-icon-open');

            }

        }

    });

})(window, document, jQuery);