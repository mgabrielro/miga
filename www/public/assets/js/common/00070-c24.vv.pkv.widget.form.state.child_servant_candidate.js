(function(window, document, $, undefined) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.form.state");

    /**
     * Abstract input1 form state.
     *
     * @abstract
     */
    ns.child_servant_candidate = Class.create(ns.child_default, {

        /**
         * Initialize the profesion element.
         *
         * @param {jQuery} element The form element.
         */
        init_profession: function(element) {
            $('#c24api_profession_container').hide();
            element.val('servant_candidate');
        }

    });

})(window, document, jQuery);