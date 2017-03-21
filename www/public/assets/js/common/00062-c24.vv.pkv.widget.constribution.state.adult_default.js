(function(window, document, $, undefined) {

    "use strict";

     var ns = namespace("c24.vv.pkv.widget.contribution.state");

    /**
     * Adult default form state.
     *
     * @abstract
     */
    ns.adult_default = Class.create(ns.abstract_state, {



        /**
         * Set new option for contribution_rate and selected value
         * Start the methode generate_option_contribution_rate
         *
         * @param {jQuery} element The form element.
         */
        init_contribution_carrier: function(element) {

            var new_option = {
                '50' : '50%',
                '70' : '70%'
            };

            var option_default_selected = 50;

            this.generate_option_contribution_rate(this.selector.contribution_rate_element, new_option, option_default_selected);
        }

    });

})(window, document, jQuery);