(function(window, document, $, undefined) {

    "use strict";

     var ns = namespace("c24.vv.pkv.widget.form.state");

    /**
     * Abstract input1 form state.
     *
     * @abstract
     */
    ns.adult_default = Class.create(ns.abstract_state, {

        /**
         * Initialize the children_age element.
         *
         * @param {jQuery} element The form element.
         */
        init_children_age: function (element) {
            $('#c24api_children_age_container').hide();
        },

        /**
         * Initialize the parent1_insured element.
         *
         * @param {jQuery} element The form element.
         */
        init_parent1_insured: function (element) {
            $('#form_header_insurend').hide();
            $('#c24api_parent1_insured_container').hide();
        },

        /**
         * Initialize the parent2_insured element.
         *
         * @param {jQuery} element The form element.
         */
        init_parent2_insured: function (element) {
            $('#c24api_parent2_insured_container').hide();
        },
        
        /**
         * Initialize the birthdate element.
         *
         * @param {jQuery} element The form element.
         */
        init_birthdate: function (element) {

            $('#c24api_birthdate_day_container .c24-content-row-info-icon').hide();
            $('#c24api_birthdate_month_container .c24-content-row-info-icon').hide();

            $.android_birthdate.input1.toggle_default_android_birthdate_fields();

        },

        /**
         * Initialize the contribution_rate element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_contribution_rate: function (element) {
            $('#c24api_contribution_rate_container').hide();
        },

        /**
         * Initialize the contribution_carrier element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_contribution_carrier: function (element) {
            $('#c24api_contribution_carrier_container').hide();
        },

        /**
         * Initialize the init_parent_servant_or_servant_candidate element.
         *
         * @param {jQuery} element The form element.
         */
        init_parent_servant_or_servant_candidate: function (element) {
            $('#c24api_parent_servant_or_servant_candidate_container').hide();
            element.val('no');
        },

        /**
         * Initialize the profesion element.
         *
         * @param {jQuery} element The form element.
         */
        init_profession: function (element) {
            $('#c24api_profession_container').show();
            //Set an german name for the given profession in the display DOM (not select) element.
            $('#c24api_profession-button span.c24-form-select').text('Bitte wählen');
            element.val('');
        },

        /**
         * Initialize the pdhospital_payout_amount_value element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_pdhospital_payout_amount_value: function(element) {
            element.val('100');
        },

        /**
         * Initialize the pdhospital_payout_start element.
         *
         * @param {jQuery} element The form element.
         */
        init_pdhospital_payout_start: function (element) {
            element.val('43');
        },

        /**
         * Initialize the provision_costsharing_limit element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_provision_costsharing_limit: function (element) {
            element.val('650');
        },

        /**
         * Initialize the hospitalization_accommodation element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_hospitalization_accommodation: function(element) {
            element.val('double');
        },

        /**
         * Initialize the dental element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_dental: function(element) {
            element.val('comfort');
        }

    });

})(window, document, jQuery);