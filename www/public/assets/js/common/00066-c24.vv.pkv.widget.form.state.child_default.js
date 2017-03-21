(function(window, document, $, undefined) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.form.state");

    /**
     * Abstract input1 form state.
     *
     * @abstract
     */
    ns.child_default = Class.create(ns.adult_default, {

        /**
         * Initialize the children_age element.
         *
         * @param {jQuery} element The form element.
         */
        init_children_age: function (element) {
            $('#c24api_children_age_container').show();

        },

        /**
         * Initialize the parent1_insured element.
         *
         * @param {jQuery} element The form element.
         */
        init_parent1_insured: function (element) {
            $('#form_header_insurend').show();
            $('#c24api_parent1_insured_container').show();
        },

        /**
         * Initialize the parent2_insured element.
         *
         * @param {jQuery} element The form element.
         */
        init_parent2_insured: function (element) {
            $('#c24api_parent2_insured_container').show();
        },
        /**
         * Initialize the birthdate element.
         *
         * @param {jQuery} element The form element.
         */
        init_birthdate: function (element) {

            if (is_android_mobile_device()) {
                $('#c24api_birthdate_container_android').hide();
            }

            $('#c24api_birthdate_container').hide();
            $('#c24api_birthdate').val('1986-01-01');
        },
        /**
         * Initialize the init_parent_servant_or_servant_candidate element.
         *
         * @param {jQuery} element The form element.
         */
        init_parent_servant_or_servant_candidate: function (element) {

            $('#c24api_parent_servant_or_servant_candidate_container').show();

            var is_adult_servant =  $(element).val();

            if(is_adult_servant == "yes") {

                var contribution = new c24.vv.pkv.widget.contribution(
                    '#c24api_insured_person_input',
                    '#c24api_contribution_carrier',
                    '#c24api_contribution_rate'
                );
                contribution.init();

                $('#c24api_contribution_carrier_container').show();
                c24.vv.shared.util.set_class_defaultvalue_by_selectfield('#c24api_contribution_rate');
                c24.vv.shared.util.set_class_defaultvalue_by_selectfield('#c24api_contribution_carrier');

            } else {

                $('#c24api_contribution_rate_container').hide();
                $('#c24api_contribution_carrier_container').hide();

            }

            if(this.init_event_listener.parent_servant_or_servant_candidate == false) {

                $(element).on("change", function() {

                    var is_adult_servant =  $(element).val();

                    if (is_adult_servant=="yes") {

                        $('#c24api_contribution_carrier_container').show();
                    } else {
                        $('#c24api_contribution_rate_container').hide();
                        $('#c24api_contribution_carrier_container').hide();
                    }

                });

                this.init_event_listener.parent_servant_or_servant_candidate = true;

            }

        },

        /**
         * Initialize the profesion element.
         *
         * @param {jQuery} element The form element.
         */
        init_profession: function (element) {

            $('#c24api_profession_container').hide();
            element.val('');

        },

        /**
         * Initialize the provision_costsharing_limit element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_provision_costsharing_limit: function (element) {
            element.val('350');
        }

    });

})(window, document, jQuery);
