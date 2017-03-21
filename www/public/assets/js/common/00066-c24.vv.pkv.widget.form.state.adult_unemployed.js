(function(window, document, $) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.form.state");

    /**
     * Abstract input1 form state.
     *
     * @abstract
     */
    ns.adult_unemployed = Class.create(ns.adult_default, {

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
            element.val('unemployed');
        }

    });

})(window, document, jQuery);