(function(window, document, $, undefined) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.form.state");

    /**
     * Abstract input1 form state.
     *
     * @abstract
     */
    ns.adult_servant_candidate = Class.create(ns.adult_servant, {
        /**
         * Initialize the profesion element.
         *
         * @param {jQuery} element The form element.
         */
        init_profession: function (element) {
            $('#c24api_profession_container').show();
            element.val('servant_candidate');
        }
    });

})(window, document, jQuery);