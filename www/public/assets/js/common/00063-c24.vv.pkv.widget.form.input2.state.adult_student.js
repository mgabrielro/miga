(function(window, document, $) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.form.input2.state");

    var $provision_costsharing_limit_input = $('#c24api_provision_costsharing_limit_input');

    /**
     * Abstract input2 form state.
     *
     * @abstract
     */
    ns.adult_student = Class.create(ns.adult_default, {

        /**
         * Initialize the provision_costsharing_limit element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_provision_costsharing_limit: function(element) {

            this.init_help_text(element, false);

            $provision_costsharing_limit_input.on(
                'change',
                [this, $provision_costsharing_limit_input, '#c24api_provision_costsharing_limit_container'],
                this.on_provision_costsharing_change
            );

        },

        /**
         * Set the TipText, if you've selected 350.
         *
         * @param {jQuery} event The Event-Object.
         */
        on_provision_costsharing_change: function(event) {

            if(!(event.data[0] != undefined && event.data[1] != undefined && event.data[2] != undefined && typeof event.data[0] !='undefined' && typeof event.data[1] !='undefined' && typeof event.data[2] !='undefined')) {
                return;
            }

            var parent  = event.data[0];
            var element = event.data[1];
            var container = event.data[2];

            var visible = false;
            var text = null;

            $(container).find('.tip-helptext-active').removeClass('tip-helptext-active');

            switch(element.val())
            {
                case "350":
                    text = 'Bei niedriger Selbstbeteiligung erheben Versicherer meist überproportional hohe Beitragsaufschläge – sparen Sie durch die Wahl einer höheren Selbstbeteiligung.';
                    visible = true;
                    $(container).find('.c24-content-row-block-infobox').show();
                    $(container).find('#c24-switch-c24api_provision_costsharing_limit-350').addClass('tip-helptext-active');
                    $(container).find('.c24-content-row-info-content').addClass('c24-info-icon-open');
                    break;

                default:
                    visible = false;
                    text = null;
                    $(container).find('.c24-content-row-block-infobox').hide();
                    $(container).find('.c24-content-row-info-content').removeClass('c24-info-icon-open');
            }

            parent.init_help_text(container, visible, text);

        },

        /**
         * Override the text in #c24-switch-c24api_provision_costsharing_limit-1000.
         * This text exist in filter.php. Here will the text override.
         *
         * @override
         * @param {jQuery} event The Event-Object.
         */
        init_label_text_provision_costsharing: function(element){
            $(element).html('Niedrigster</br> Beitrag');
        }

    });

})(window, document, jQuery);