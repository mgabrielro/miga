(function(window, document, $, undefined) {

    "use strict";

     var ns = namespace("c24.vv.pkv.widget.form.input2.state");

    /**
     * Abstract input2 form state.
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

            var $element = $('#c24api_hospitalization_accommodation_input');
            var $container = $('#c24api_hospitalization_accommodation_container');

            this.init_help_text(element, false);

            element.change([this, $element, $container], this.on_hospitalization_accommodation_change);

        },

        /**
         * Set the TipText, if you've selected single.
         *
         * @param {jQuery} event The Event-Object.
         */
        on_hospitalization_accommodation_change: function(event) {

            var parent  = event.data[0];
            var $element = event.data[1];
            var $container = event.data[2];

            if(!(event.data[0] != undefined && event.data[1] != undefined && event.data[2] != undefined && typeof event.data[0] !='undefined' && typeof event.data[1] !='undefined' && typeof event.data[2] !='undefined')) {
                return;
            }

            if($element.val() == 'single'){
                parent.init_help_text($container, true, 'Für ein Einbettzimmer zahlen Sie oft einen sehr hohen Zuschlag. In der Regel ist es günstiger, einen Tarif mit Zweibettzimmer zu wählen und bei Bedarf den Zuschlag für das Einbettzimmer selbst zu zahlen.');
                $container.find('.c24-content-row-block-infobox').show();
                $container.find('.c24-content-row-info-content').addClass('c24-info-icon-open');

            } else {
                parent.init_help_text($container, false, null);
                $container.find('.c24-content-row-block-infobox').hide();
                $container.find('.c24-content-row-info-content').removeClass('c24-info-icon-open');
            }

        },

        /**
         * Initialize the dental element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_dental: function(element) {

            var $element = $('#c24api_dental_input');
            var $container = $('#c24api_dental_container');

            this.init_help_text(element, false);

            element.change([this, $element, $container], this.on_dental_change);

        },

        /**
         * Set the TipText, if you've selected premium.
         *
         * @param {jQuery} event The Event-Object.
         */
        on_dental_change: function(event) {

            var parent  = event.data[0];
            var $element = event.data[1];
            var $container = event.data[2];

            if(!(event.data[0] != undefined && event.data[1] != undefined && event.data[2] != undefined && typeof event.data[0] !='undefined' && typeof event.data[1] !='undefined' && typeof event.data[2] !='undefined')) {
                return;
            }

            $container.find('.tip-helptext-active').removeClass('tip-helptext-active');

            if($element.val() == 'premium'){

                parent.init_help_text($container, true, 'In der Regel zahlen Sie Monat für Monat einen hohen Aufschlag für Premium-Tarife. Oft sparen Sie, wenn Sie einen Komfort-Tarif wählen und dafür bei einer Behandlung einen etwas höheren eigenen Anteil tragen.');
                $container.find('.c24-content-row-block-infobox').show();
                $container.find('#c24-switch-c24api_dental-premium').addClass('tip-helptext-active');
                $container.find('.c24-content-row-info-content').addClass('c24-info-icon-open');

            } else {

                parent.init_help_text($container, false, null);
                $container.find('.c24-content-row-block-infobox').hide();
                $container.find('.c24-content-row-info-content').removeClass('c24-info-icon-open');

            }

        },

        /**
         * Override the text in #c24-switch-c24api_provision_costsharing_limit-1000.
         * This text exist in filter.php. Here will the text override.
         *
         * @override
         * @param {jQuery} event The Event-Object.
         */
        init_label_text_provision_costsharing: function(element){
            $(element).html('Netto oft zu viel</br> gezahlt');
        }

    });

})(window, document, jQuery);