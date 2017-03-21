(function(window, document, $, undefined) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.contribution.state");
 
    /**
     * Abstract contribution form state.
     *
     * @abstract
     */
    ns.abstract_state = Class.create({

        selector: {
            contribution_rate_element: $('#c24api_contribution_rate')
        },
     
        /**
         * Initialize the contribution_rate.
         *
         * @param {jQuery} element The form element.
         */
        init_contribution_rate: function (element) {           
        },

        /**
         * Initialize the contribution_carrier.
         *
         * @param {jQuery} element The form element.
         */
        init_contribution_carrier: function (element) {
        },

        /**
         * Build options in a selectfield and set the attribute 'selected' with default-value 'option_selected'
         *
         * @param {jQuery} select_element The name of contribution_rate select-field
         * @param {object} new_option List of option
         * @param {int} option_default_selected Default-value for select
         */
        generate_option_contribution_rate: function(select_element, new_option, option_default_selected) {

            $('option', select_element).remove();

            $.each(new_option, function(text, key) {
                var option = new Option(key, text);
                select_element.append($(option));
            });

            select_element.find('option[value="' + option_default_selected + '"]').attr('selected', 'selected');
         
            this.check_count_option(select_element);
            this.show_constribution_rate_value(select_element);

        },

        /**
         * Show the value in the span-element
         *
         * @param {jQuery} select_element The name of contribution_rate select-field
         */
        show_constribution_rate_value: function (select_element){

            var select_option_val = select_element.find('option:selected').html();
            $('#c24api_contribution_rate-button span.c24-form-select').html(select_option_val);

        },

        /**
         * Check the count of option in a selectfield contribution
         * If the count of option more than one then show this otherwise hide
         *
         * @param {jQuery} select_element The name of selectfield contribution-rate
         */
        check_count_option: function(select_element){

            if (select_element.find('option').length == 1) {
                $('#c24api_contribution_rate_container').hide();
            } else {
                $('#c24api_contribution_rate_container').show();
            }

        }

    });

})(window, document, jQuery);