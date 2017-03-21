(function(window, document, $, undefined) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.form.state");

    /**
     * Abstract input1 form state.
     *
     * @abstract
     */
    ns.adult_servant = Class.create(ns.adult_default, {


        /**
         * Initialize the contribution_rate element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_contribution_rate: function (element) {
            $('#c24api_contribution_rate_container').show();

            var contribution = new c24.vv.pkv.widget.contribution(
                '#c24api_insured_person_input',
                '#c24api_contribution_carrier',
                '#c24api_contribution_rate'
            );
            contribution.init();

        },

        /**
         * Initialize the contribution_carrier element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_contribution_carrier: function (element) {
            $('#c24api_contribution_carrier_container').show();
        },

        /**
         * Initialize the profesion element.
         *
         * @param {jQuery} element The form element.
         */
        init_profession: function (element) {
            $('#c24api_profession_container').show();
            element.val('servant');
        }

    });

})(window, document, jQuery);
