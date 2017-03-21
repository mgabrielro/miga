(function(window, document, $) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.form.state");

    /**
     * Abstract input1 form state.
     *
     * @abstract
     */
    ns.adult_freelancer = Class.create(ns.adult_default, {

        /**
         * Initialize the provision_costsharing_limit element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_provision_costsharing_limit: function (element) {
            element.val('1000');
        },

        /**
         * Initialize the pdhospital_payout_amount_value element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_pdhospital_payout_amount_value: function(element) {
            element.val('50');
        },

        /**
         * Initialize the hospitalization_accommodation element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_hospitalization_accommodation: function(element) {
            element.val('multi');
        },

        /**
         * Initialize the profesion element.
         *
         * @param {jQuery} element The form element.
         */
        init_profession: function (element) {
            $('#c24api_profession_container').show();
            element.val('freelancer');
        }

    });

})(window, document, jQuery);