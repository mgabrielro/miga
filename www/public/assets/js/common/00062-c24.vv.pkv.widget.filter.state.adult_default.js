(function(window, document, $, undefined) {

    "use strict";

     var ns = namespace("c24.vv.pkv.widget.filter.state");

    /**
     * Adult default form state.
     *
     * @abstract
     */
    ns.adult_default = Class.create(ns.abstract_state, {

        /**
         * Initialize the hospitalization_accommodation element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_hospitalization_accommodation: function(element) {

            var container = '#c24api_hospitalization_accommodation_container';

            this.init_help_text(element, false);

            element.change([this, element, container], this.on_hospitalization_accommodation_change);

        },

        /**
         * Set the TipText, if you've selected single.
         *
         * @param {jQuery} event The Event-Object.
         */
        on_hospitalization_accommodation_change: function(event) {

            if(!(event.data[0] != undefined && event.data[1] != undefined && event.data[2] != undefined && typeof event.data[0] !='undefined' && typeof event.data[1] !='undefined' && typeof event.data[2] !='undefined')) {
                return;
            }

            var parent  = event.data[0];
            var $element = event.data[1];
            var container = event.data[2];

            var visible = false;
            var text = null;

            if($element.val() == 'single'){

                visible = true;
                text = 'Für ein Einbettzimmer zahlen Sie oft einen sehr hohen Zuschlag. In der Regel ist es günstiger, einen Tarif mit Zweibettzimmer zu wählen und bei Bedarf den Zuschlag für das Einbettzimmer selbst zu zahlen.';

            }

            parent.init_help_text(container, visible, text);

        },

        /**
         * Initialize the dental element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_dental: function(element) {

            var container = '#c24api_dental_container';

            this.init_help_text(element, false);

            $(container).change([this, element, container], this.on_dental_change);

        },

        /**
         * Set the TipText, if you've selected premium.
         *
         * @param {jQuery} event The Event-Object.
         */
        on_dental_change: function(event) {

            if(!(event.data[0] != undefined && event.data[1] != undefined && event.data[2] != undefined && typeof event.data[0] !='undefined' && typeof event.data[1] !='undefined' && typeof event.data[2] !='undefined')) {
                return;
            }

            var parent  = event.data[0];
            var $element = event.data[1];
            var container = event.data[2];

            var visible = false;
            var text = null;

            $(container).find('.tip-helptext-active').removeClass('tip-helptext-active');

            if($element.val() == 'premium'){

                visible = true;
                text = 'In der Regel zahlen Sie Monat für Monat einen hohen Aufschlag für Premium-Tarife. Oft sparen Sie, wenn Sie einen Komfort-Tarif wählen und dafür bei einer Behandlung einen etwas höheren eigenen Anteil tragen.';
                $(container).find('#c24-switch-c24api_dental-premium').addClass('tip-helptext-active');

            }

            parent.init_help_text(container, visible, text);

        }

    });

})(window, document, jQuery);