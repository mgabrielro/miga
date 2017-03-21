(function(window, document, $, undefined) {

    "use strict";

     var ns = namespace("c24.vv.pkv.widget.form.state");

    /**
     * Abstract input1 form state.
     *
     * @abstract
     */
    ns.abstract_state = Class.create({

        form: null,

        init_event_listener: {
            parent_servant_or_servant_candidate: false
        },

        /**
         * Sets the given form.
         *
         * @param {jQuery} form A form to set
         */
        set_form: function(form) {
            this.form = form;
        },

        /**
         * Initialize the paymentperiod element.
         *
         * @param {jQuery} element The form element.
         */
        init_paymentperiod: function (element) {
        },

        /**
         * Initialize the insure_date element.
         *
         * @param {jQuery} element The form element.
         */
        init_insure_date: function (element) {
        },

        /**
         * Initialize the pdhospital_payout_start element.
         *
         * @param {jQuery} element The form element.
         */
        init_pdhospital_payout_start: function (element) {
        },

        /**
         * Initialize the pdhospital_payout_start element.
         *
         * @param {jQuery} element The form element.
         */
        init_pdhospital_payout_amount_value: function(element) {
        },

        /**
         * Initialize the children_age element.
         *
         * @param {jQuery} element The form element.
         */
        init_children_age: function (element) {
        },

        init_hospitalization_accommodation: function(element) {
        },

        init_dental: function(element) {
        },

        /**
         * Initialize the parent1_insured element.
         *
         * @param {jQuery} element The form element.
         */
        init_parent1_insured: function (element) {
        },

        /**
         * Initialize the parent2_insured element.
         *
         * @param {jQuery} element The form element.
         */
        init_parent2_insured: function (element) {
        },

        /**
         * Initialize the insured_person element.
         *
         * @param {jQuery} element The form element.
         */
        init_insured_person: function (element) {
        },

        /**
         * Initialize the profession element.
         *
         * @param {jQuery} element The form element.
         */
        init_profession: function (element) {
        },

        /**
         * Initialize the birthdate element.
         *
         * @param {jQuery} element The form element.
         */
        init_birthdate: function (element) {
        },

        /**
         * Initialize the contribution_rate element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_contribution_rate: function (element) {
        },

        /**
         * Initialize the contribution_carrier element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_contribution_carrier: function (element) {
        },

        /**
         * Initialize the init_parent_servant_or_servant_candidate element.
         *
         * @param {jQuery} element The form element.
         */
        init_parent_servant_or_servant_candidate: function (element) {
        },

        /**
         * Initialize the provision_costsharing_limit element.
         *
         * @param {jQuery} element The form element.
         */
        init_provision_costsharing_limit: function (element) {
        }

    });

})(window, document, jQuery);