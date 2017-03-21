(function(window, document, $) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.form");

    /**
     * Input1 stateable form.
     *
     * @class
     */
    ns.input1 = Class.create({

        state:   null,

        form: null,

        insured_person_type: null,

        profession_type: null,

        prev_person: null,

        prev_profession: null,

        child_servant_candidate_switcher: null,

        /**
         * @constructor
         * @param {jQuery} form
         * @param {jQuery} insured_person_type
         * @param {jQuery} profession_type
         */
        initialize: function(form, insured_person_type, profession_type, child_servant_candidate_switcher) {

            this.form = $(form);
            this.insured_person_type = $(insured_person_type);
            this.profession_type = $(profession_type);
            this.child_servant_candidate_switcher = $(child_servant_candidate_switcher);
            this.prev_person = this.insured_person_type.val();
            this.prev_profession = $('#c24api_profession').val();

        },

        /**
         * @private
         */
        init: function() {

            this.insured_person_type.change([this], this.on_change);
            this.profession_type.change([this], this.on_change);
            this.child_servant_candidate_switcher.change([this], this.on_change);

            var default_state = this.get_default_state();
            this.init_by_state(default_state, this.form);

        },

        /**
         * Detects the default state to use after the form was reloaded.
         * Uses existing form values if set, to show the right elements in form.
         *
         * @returns {string}
         */
        get_default_state: function() {

            var default_state = 'adult_default';

            if (this.insured_person_type.val() != '') {

                default_state = this.insured_person_type.val() + '_';

                // If insured person is child we need to check if one of the parent
                // is servant instead of relying on the profession.

                if (this.insured_person_type.val() == 'child') {

                    if (this.child_servant_candidate_switcher.val() == 'yes') {
                        default_state += 'servant';
                    } else {
                        default_state += 'default';
                    }

                } else {

                    if (this.profession_type.val() != '') {
                        default_state += this.profession_type.val()
                    } else {
                        default_state += 'default';
                    }

                }

            }

            return default_state;

        },

        /**
         * On change listener.
         *
         * @private
         * @param {jQuery} element
         */
        on_change: function(event) {

            var profession = $('#c24api_profession').val();
            var insured_person = $('#c24api_insured_person_input');
            var form = $('#resultform');
            var child_servant_candidate_switcher = $('#c24api_parent_servant_or_servant_candidate_input');

            /**
             * Workaround for 'child_servant'. We save always previous selected insured person.
             * After that we check here the previous selected person and new one in order to set the correct
             * profession when it was changed person from 'child_servant' direct to the 'adult'.
             */
            if ((profession == 'servant' || profession == 'servant_candidate') && this.prev_person == 'child' && $('#c24api_insured_person_input').val() == 'adult' && child_servant_candidate_switcher.val() == 'yes') {

                profession = 'default';
                child_servant_candidate_switcher.val('no');
                $('#c24-switch-c24api_parent_servant_or_servant_candidate-no').addClass('switch-active');
                $('#c24-switch-c24api_parent_servant_or_servant_candidate-no .c24-switch-panel-icon').addClass('icon-active');
                $('#c24-switch-c24api_parent_servant_or_servant_candidate-yes').removeClass('switch-active');
                $('#c24-switch-c24api_parent_servant_or_servant_candidate-yes .c24-switch-panel-icon').removeClass('icon-active');

            } else if (profession == '' && this.prev_profession != '' && typeof this.prev_profession !== 'undefined' && child_servant_candidate_switcher.val() == 'no') {

                profession = this.prev_profession;

            } else if (profession == '') {

                profession = 'default';

            }

            if (insured_person.val() == 'child') {

                if (child_servant_candidate_switcher.val() == 'yes') {
                    profession = 'servant';
                } else {
                    profession = 'default';


                    $('#c24-switch-c24api_parent_servant_or_servant_candidate-no').addClass('switch-active');
                    $('#c24-switch-c24api_parent_servant_or_servant_candidate-no .c24-switch-panel-icon').addClass('icon-active');
                    $('#c24-switch-c24api_parent_servant_or_servant_candidate-yes').removeClass('switch-active');
                    $('#c24-switch-c24api_parent_servant_or_servant_candidate-yes .c24-switch-panel-icon').removeClass('icon-active');
                }

            } else {
                $.android_birthdate.input1.toggle_default_android_birthdate_fields();
            }

            this.prev_person = insured_person.val();
            this.prev_profession = $('#c24api_profession').val();

            var state = insured_person.val() + '_' + profession;
            event.data[0].init_by_state(state, form);

        },

        /**
         * Initialize the state by the given state value.
         *
         * @param {string} state The state to change.
         * @param {jQuery} form The given form.
         */
        init_by_state: function (state, form) {

            console.log('DEBUG: Init state ' + state);

            var state_obj = new c24.vv.pkv.widget.form.state[state]();

            if (typeof state_obj === 'undefined') {
                throw 'Could not find state object for state "' + state + '".';
            }

            console.log('DEBUG: State changed to: ' + state);
            this.state = state_obj;
            this.state.set_form(form);

            // Call init functions for each form field...
            this.init_paymentperiod();
            this.init_insure_date();
            this.init_pdhospital_payout_start();
            this.init_pdhospital_payout_amount_value();
            this.init_children_age();
            this.init_parent1_insured();
            this.init_parent2_insured();
            this.init_insured_person();
            this.init_profession();
            this.init_birthdate();
            this.init_contribution_carrier();
            this.init_contribution_rate();
            this.init_parent_servant_or_servant_candidate();
            this.init_provision_costsharing_limit();
            this.init_hospitalization_accommodation();
            this.init_dental();

        },

        /**
        * Sets the given paymentperiod and set the string selectorname.
        *
        */
        init_paymentperiod: function () {
            this.state.init_paymentperiod(
                $('#c24api_paymentperiod')
            );
        },

        /**
         * Sets the given insure_date and set the string selectorname.
         *
         */
        init_insure_date: function () {
            this.state.init_insure_date(
                $('#c24api_insure_date')
            );
        },

        /**
         * Sets the given pdhospital_payout_start and set the string selectorname.
         *
         */
        init_pdhospital_payout_start: function () {
            this.state.init_pdhospital_payout_start(
                $('#c24api_pdhospital_payout_start')
            );
        },

        /**
         * Sets the given pdhospital_payout_start and set the string selectorname.
         *
         */
        init_pdhospital_payout_amount_value: function () {
            this.state.init_pdhospital_payout_amount_value(
                $('#c24api_pdhospital_payout_amount_value')
            );
        },

        /**
         * Sets the given children_age and set the string selectorname.
         *
         */
        init_children_age: function () {
            this.state.init_children_age(
                $('#c24api_children_age')
            );
        },

        /**
         * Sets the given parent1_insured and set the string selectorname.
         *
         */
        init_parent1_insured: function () {
            this.state.init_parent1_insured(
                $('#c24api_parent1_insured')
            );
        },

        /**
         * Sets the given parent2_insured and set the string selectorname.
         *
         */
        init_parent2_insured: function () {
            this.state.init_parent2_insured(
                $('#c24api_parent2_insured')
            );
        },

        /**
         * Sets the given insured_person and set the string selectorname.
         *
         */
        init_insured_person: function () {
            this.state.init_insured_person(
                $('#c24api_insured_person')
            );
        },

        /**
         * Sets the given profession and set the string selectorname.
         *
         */
        init_profession: function () {
            this.state.init_profession(
                $('#c24api_profession')
            );
        },

        /**
         * Sets the given birthdate and set the string selectorname.
         *
         */
        init_birthdate: function () {
            this.state.init_birthdate(
                $('#c24api_birthdate')
            );
        },

        /**
         * Sets the given contribution_rate and set the string selectorname.
         *
         */
        init_contribution_rate: function () {
            this.state.init_contribution_rate(
                $('#c24api_contribution_rate')
            );
        },

        /**
         * Sets the given contribution_carrier and set the string selectorname.
         *
         */
        init_contribution_carrier: function () {
            this.state.init_contribution_carrier(
                $('#c24api_contribution_carrier')
            );
        },

        /**
         * Sets the given parent_servant_or_servant_candidate and set the string selectorname.
         *
         */
        init_parent_servant_or_servant_candidate: function () {
            this.state.init_parent_servant_or_servant_candidate(
                $('#c24api_parent_servant_or_servant_candidate_input')
            );
        },

        /**
         * Sets the given provision_costsharing_limit and set the string selectorname.
         *
         */
        init_provision_costsharing_limit: function () {
            this.state.init_provision_costsharing_limit(
                $('#c24api_provision_costsharing_limit_input')
            );
        },

        init_hospitalization_accommodation: function () {
            this.state.init_hospitalization_accommodation(
                $('#c24api_hospitalization_accommodation_input')
            );
        },

        init_dental: function() {
            this.state.init_dental(
                $('#c24api_dental')
            );
        }

    });

})(window, document, jQuery);