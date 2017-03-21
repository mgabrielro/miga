(function(window, document, $) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget");

    /**
     * contribution stateable form.
     *
     * @class
     */
    ns.contribution = Class.create({

        /**
         * Name of state that to use for statepatterm
         */
        state: null,

        /**
         * jQuery element insured person type
         */
        insured_person_type: null,

        /**
         * jQuery element contribution_carrier
         */
        contribution_carrier: null,

        /**
         * jQuery element contribution_rate
         */
        contribution_rate: null,

        /**
         * @constructor
         * @param {jQuery} insured_person_type
         * @param {jQuery} contribution_carrier
         * @param {jQuery} contribution_rate
         */
        initialize: function(insured_person_type, contribution_carrier, contribution_rate) {

            this.insured_person_type = $(insured_person_type);
            this.contribution_carrier = $(contribution_carrier);
            this.contribution_rate = $(contribution_rate);

        },

        /**
         * @private
         */
        init: function() {

            var _this = this;
            this.contribution_carrier.change([this, _this], this.on_change);

            var default_state = this.get_state();
            this.init_by_state(default_state);

        },

        /**
         * Detects the default state to use after the form was reloaded.
         * Uses existing form values if set, to show the right elements in form.
         *
         * @returns {string}
         */
        get_state: function() {

            var name_of_state = '';

            var same_option = ['bb', 'be', 'bw', 'by', 'hh', 'mv', 'ni', 'nw', 'rp', 'sh', 'sl', 'sn', 'st', 'th'];

            var c24api_contribution_carrier = this.contribution_carrier.val();
            var insured_person = this.insured_person_type.val();          

            if (c24api_contribution_carrier == '' || c24api_contribution_carrier == 'association') {
                name_of_state = 'association';
            } else if (same_option.indexOf(c24api_contribution_carrier) > -1) {
                name_of_state = 'default';
            } else {
                name_of_state = c24api_contribution_carrier;
            }

            var state = insured_person + '_' + name_of_state;

            return state;

        },

        /**
         * On change listener.
         *
         * @private
         * @param {jQuery} element
         */
        on_change: function(event) {

            var state = event.data[1].get_state();
            event.data[0].init_by_state(state);

        },

        /**
         * Initialize the state by the given state value.
         *
         * @param {string} state The state to change.
         */
        init_by_state: function (state) {

            var state_obj = new c24.vv.pkv.widget.contribution.state[state]();

            if (typeof state_obj === 'undefined') {
                throw 'Could not find state object for state "' + state + '".';
            }

            this.state = state_obj;

            // Call init functions for each form field...
            this.init_contribution_carrier();
            this.init_contribution_rate();

        },

        /**
         * Sets the given contribution_rate and set the string selectorname.
         *
         */
        init_contribution_rate: function () {
            this.state.init_contribution_rate(
               this.contribution_rate
            );
        },

        /**
         * Sets the given contribution_carrier and set the string selectorname.
         *
         */
        init_contribution_carrier: function () {
            this.state.init_contribution_carrier(
               this.contribution_carrier
            );
        }

    });

})(window, document, jQuery);