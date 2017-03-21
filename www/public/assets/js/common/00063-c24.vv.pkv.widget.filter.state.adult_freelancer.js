(function(window, document, $) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.filter.state");

    /**
     * Adult freelancer form state.
     *
     * @abstract
     */
    ns.adult_freelancer = Class.create(ns.adult_default, {

        /**
         * Initialize the provision_costsharing_limit element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_provision_costsharing_limit: function(element) {

            this.init_help_text(element, false);

            element.on(
                'change',
                [this, element, '#c24api_provision_costsharing_limit_container'],
                this.on_provision_costsharing_change
            );

        },

        /**
         * Set the TipText, if you've selected 0, 350 or 650.
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

            var visible = true;
            var text = 'Bei niedriger Selbstbeteiligung erheben Versicherer meist überproportional hohe Beitragsaufschläge – sparen Sie durch die Wahl einer höheren Selbstbeteiligung.';

            $(container).find('.tip-helptext-active').removeClass('tip-helptext-active');

            switch(element.val())
            {
                case "0":

                    $(container).find('#c24-switch-c24api_provision_costsharing_limit-0').addClass('tip-helptext-active');
                    break;

                case "350":

                    $(container).find('#c24-switch-c24api_provision_costsharing_limit-350').addClass('tip-helptext-active');
                    break;

                case "650":
                    text = 'Wählen Sie eine mittlere Selbstbeteiligung, wenn Sie ggf. einen höheren Betrag für eine Behandlung auf einmal nicht tragen können. Monatlich noch mehr sparen Sie mit einer höheren Selbstbeteiligung.';
                    $(container).find('#c24-switch-c24api_provision_costsharing_limit-650').addClass('tip-helptext-active');
                    break;

                default:
                    visible = false;
                    text = null;

            }

            parent.init_help_text(container, visible, text);

        }

    });

})(window, document, jQuery);