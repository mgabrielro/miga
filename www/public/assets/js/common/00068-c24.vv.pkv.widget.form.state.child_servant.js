(function(window, document, $, undefined) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.form.state");

    /**
     * Abstract input1 form state.
     *
     * @abstract
     */
    ns.child_servant = Class.create(ns.child_default, {

        /**
         * Initialize the contribution rate.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_contribution_rate: function(element) {},

        /**
         * Initialize the profesion element.
         *
         * @param {jQuery} element The form element.
         */
        init_profession: function(element) {
            $('#c24api_profession_container').hide();
            element.val('servant');
        },

        /**
         * Initialize the provision_costsharing_limit element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_provision_costsharing_limit: function (element) {
            element.val('650');
        }

    });

})(window, document, jQuery);