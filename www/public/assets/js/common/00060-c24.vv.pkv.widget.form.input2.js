(function(window, document, $) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.form");

    /**
     * Input2 stateable form.
     *
     * @class
     */
    ns.input2 = Class.create({

        state:   null,

        form: null,

        insured_person_type: null,

        profession_type: null,

        /**
         * @constructor
         * @param {jQuery} form
         * @param {jQuery} insured_person_type
         * @param {jQuery} profession_type
         */
        initialize: function(form, insured_person_type, profession_type) {

            this.form = $(form);
            this.insured_person_type = $(insured_person_type);
            this.profession_type = $(profession_type);

        },

        /**
         * @private
         */
        init: function() {

            this.insured_person_type.change([this], this.on_change);
            this.profession_type.change([this], this.on_change);

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

            var profession = $('#c24api_profession');
            var insured_person = $('#c24api_insured_person_input');
            var state_name='';

            if(profession.val() == ''){
                 state_name = insured_person.val() + '_default'
            }else{
                 state_name = insured_person.val() + '_' + profession.val();
            }

            return state_name;

        },

        /**
         * Initialize the state by the given state value.
         *
         * @param {string} state The state to change.
         * @param {jQuery} form The given form.
         */
        init_by_state: function (state, form) {

            console.log('DEBUG: Init state ' + state);

            var state_obj = new c24.vv.pkv.widget.form.input2.state[state]();

            if (typeof state_obj === 'undefined') {
                throw 'Could not find state object for state "' + state + '".';
            }

            console.log('DEBUG: State changed to: ' + state);
            this.state = state_obj;
            this.state.set_form(form);

            // Call init functions for each form field...
            this.init_dental();
            this.init_provision_costsharing_limit();
            this.init_hospitalization_accommodation();
            this.init_label_text_provision_costsharing();

        },

        /**
         * Sets the given dental and set the string selectorname.
         *
         */
        init_dental: function() {
            this.state.init_dental(
                $('#c24api_dental_container')
            );
        },

        /**
         * Sets the given provision_costsharing_limit and set the string selectorname.
         *
         */
        init_provision_costsharing_limit: function () {
            this.state.init_provision_costsharing_limit(
                $('#c24api_provision_costsharing_limit_container')
            );
        },

        /**
         * Sets the given hospitalization_accommodation and set the string selectorname.
         *
         */
        init_hospitalization_accommodation: function() {
            this.state.init_hospitalization_accommodation(
                $('#c24api_hospitalization_accommodation_container')
            );
        },

        /**
         * Sets the given label_text_provision_costsharing and set the string selectorname.
         *
         */
        init_label_text_provision_costsharing: function() {
            this.state.init_label_text_provision_costsharing(
                $('#c24-switch-c24api_provision_costsharing_limit-1000 .radio_list_description')
            );
        }

    });

})(window, document, jQuery);