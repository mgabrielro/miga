(function(window, document, $) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.form.input2.state");
    
    /**
     * State for all childs except servant and servant candidate on input2
     *
     */
    ns.child_default = Class.create(ns.adult_employee, {
        /**
         * Initialize the provision_costsharing_limit element.
         *
         * @override
         * @param {jQuery} element The form element.
         */
        init_provision_costsharing_limit: function(element) {

            var $provision_costsharing_limit_input = $('#c24api_provision_costsharing_limit_input');

            this.init_help_text(element, false);

            element.on(
                'change',
                [this, $provision_costsharing_limit_input, element],
                this.on_provision_costsharing_change
            );

        },

        /**
         * Set the TipText, if you've selected 1000.
         *
         * @param {jQuery} event The Event-Object.
         */
        on_provision_costsharing_change: function(event) {

            if(!(event.data[0] != undefined && event.data[1] != undefined && event.data[2] != undefined && typeof event.data[0] !='undefined' && typeof event.data[1] !='undefined' && typeof event.data[2] !='undefined')) {
                return;
            }

                var parent = event.data[0];
                var element = event.data[1];
                var container = event.data[2];

                var visible = false;
                var text = null;

                $(container).find('.tip-helptext-active').removeClass('tip-helptext-active');

                switch (element.val()) {
                    case "1000":

                        text = 'Ihr Arbeitgeber zahlt 50% des Beitrags, die Selbstbeteiligung tragen Sie alleine – bei hoher Selbstbeteiligung zahlen Sie netto daher zu viel; auch bei etwas niedrigerem monatlichen Beitrag.';
                        visible = true;
                        $(container).find('.c24-content-row-block-infobox').show();
                        $(container).find('#c24-switch-c24api_provision_costsharing_limit-1000').addClass('tip-helptext-active');
                        $(container).find('.c24-content-row-info-content').addClass('c24-info-icon-open');

                        break;

                    default:

                        $(container).find('.c24-content-row-block-infobox').hide();
                        $(container).find('.c24-content-row-info-content').removeClass('c24-info-icon-open');

                }

                parent.init_help_text(container, visible, text);

            }


    });

})(window, document, jQuery);
