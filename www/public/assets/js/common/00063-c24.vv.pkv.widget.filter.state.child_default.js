(function(window, document, $) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.filter.state");

    /**
     * State for all childs except servant and servant candidate on filter
     *
     */
    ns.child_default = Class.create(ns.adult_default, {

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
         * Set the TipText, if you've selected 1000, 1300, 1600 and "Alle Werte anzeigen" -1.
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
            var text = 'Ihr Arbeitgeber zahlt 50% des Beitrags, die Selbstbeteiligung tragen Sie alleine – bei hoher Selbstbeteiligung zahlen Sie netto daher zu viel; auch bei etwas niedrigerem monatlichen Beitrag.';

            $(container).find('.tip-helptext-active').removeClass('tip-helptext-active');


            switch(element.val())
            {

               case "1000":
                    $(container).find('#c24-switch-c24api_provision_costsharing_limit-1000').addClass('tip-helptext-active');
                    break;

                case "1300":
                    $(container).find('#c24-switch-c24api_provision_costsharing_limit-1300').addClass('tip-helptext-active');
                    break;

                case "1600":
                    $(container).find('#c24-switch-c24api_provision_costsharing_limit-1600').addClass('tip-helptext-active');
                    break;

                case "-1":
                    $(container).find('#c24-switch-c24api_provision_costsharing_limit-1').addClass('tip-helptext-active');
                    break;

                default:
                    visible = false;
                    text = null;

            }

            parent.init_help_text(container, visible, text);

        }

    });

})(window, document, jQuery);