(function(){
    "use strict";

    /**
     * javascript functions for c24 tariff comparison
     */
    namespace("c24.common.comparison", function()
    {
        var comparison = {

            /**
             * set true if comparison page loaded
             */
            active: false,

            /**
             * the current selected key of tariff in the last column
             */
            pagination_default: '',

            /**
             * the current selected key of tariff in the last column
             */
            pagination_selected: '',

            /**
             * default pagination index
             */
            pagination_index: 0,

            /**
             * all tariff keys to paginate in the last column
             */
            pagination_keys: [],

            /**
             * default selector
             */
            selector: '#comparison',

            /**
             * initialize the functionality
             */
            init: function(selector) {
                /* set active status */
                this.active = $(selector).length;

                /* stop if no comparison available */
                if(!this.active) {
                    return null;
                }

                this.selector = selector;

                // at first, set third tariff as default and selected
                this.pagination_selected = this.pagination_default = $('#tariff_3').val();

                // set default as first
                this.pagination_keys.push(this.pagination_default);


                // add pagination keys
                this.pagination_keys = this.pagination_keys.concat(comparison_pager_keys || []);

                this.openTariffChangePopup();
                this.closeTariffChangePopup();
                this.onToggleSection();
                this.onChangeTariff();
                this.onScroll();
                this.pagination();
            },

            onScroll: function()
            {

                $(window).on('scroll resize', function () {
                    $('.iMod24Newtip, .c24-tooltip-content').hide();
                });

                $(this.selector).find('header:first').scrollToFixed({marginTop: 1, zIndex: 1001});
                $(this.selector).find('section > header').scrollToFixed({
                    marginTop: $(this.selector).find('header:first').height()
                });

            },


            /**
             * open the tariff change popup for the first and second tariff
             */
            openTariffChangePopup: function() {
                $(this.selector).find("#tariff_change_1, #tariff_change_2").click(function(){
                    $(".tariff_change_bg").show();
                    $("#tariff_column").val($(this).attr('data-column-id'));
                });
            },

            /**
             * close the tariff change popup for the first and second tariff
             */
            closeTariffChangePopup: function() {
                $(this.selector).find(".tariff_change_close_button").click(function(){
                    $(".tariff_change_bg").hide();
                });
            },

            /**
             * event for toggle sections
             */
            onToggleSection: function() {
                $(this.selector).find('header').click(function() {
                    $(this).closest('section').toggleClass("open").toggleClass("close");
                });
            },

            /**
             * event for on click a tariff in the popup
             */
            onChangeTariff: function()
            {
                var self = this;

                $(this.selector).find(".tariff_click").click(function()
                {
                    var link    = comparison_base_link || '';

                    $('#tariff_' + $("#tariff_column").val()).val($(this).data('id'));

                    link += '&c24_tariffversion_key_1=' + $('#tariff_1').val();
                    link += '&c24_tariffversion_key_2=' + $('#tariff_2').val();
                    link += '&c24_tariffversion_key_3=' + $('#tariff_3').val();

                    $(self.selector).find(".tariff_change_close_button").click();

                    window.location = link.replace(/amp;/gi, '');
                });
            },

            /**
             * paginate if element is not deactivated
             *
             * @param element the button element
             * @param dir the direction prev|next default is next
             */
            paginate: function(element, dir)
            {
                if($(element).hasClass('disabled'))
                    return;

                var direction = dir || 'next';

                $(this.selector).find('article .'+this.pagination_keys[this.pagination_index]).toggleClass('hide');

                if(direction == 'prev') {
                    this.pagination_index--;
                } else {
                    this.pagination_index++;
                }

                $(this.selector).find('article .'+this.pagination_keys[this.pagination_index]).toggleClass('hide');

                $('#tariff_3').val(this.pagination_keys[this.pagination_index]);

                // rebuild current tariff selection in the popup
                $('.tariff_change_box .tariff').removeClass('tariff_checked').addClass('tariff_click');
                $('.tariff_change_box .tariff[data-id=\'' + $('#tariff_1').val() + '\']').addClass('tariff_checked');
                $('.tariff_change_box .tariff[data-id=\'' + $('#tariff_2').val() + '\']').addClass('tariff_checked');
                $('.tariff_change_box .tariff[data-id=\'' + this.pagination_keys[this.pagination_index] + '\']').addClass('tariff_checked');

                // first page button style
                if(this.pagination_index == 0) {
                    $(this.selector).find('.prevResult').addClass('disabled');
                } else {
                    $(this.selector).find('.prevResult').removeClass('disabled');
                }

                // last page button style
                if(this.pagination_index == this.pagination_keys.length-1) {
                    $(this.selector).find('.nextResult').addClass('disabled');
                } else {
                    $(this.selector).find('.nextResult').removeClass('disabled');
                }

            },

            /**
             * add click events to paginate the last column of tariff comparison
             */
            pagination: function()
            {
                // nothing to paginate when less the one tariff to paginate
                if(this.pagination_selected.length <= 1) {
                    return false;
                }

                var self = this;

                $(".prevResult").click(function(){
                    self.paginate(this, 'prev');
                });

                $(".nextResult").click(function(){
                    self.paginate(this, 'next');
                });
            }
        };

        /**
         * initialize on document ready
         */
        $(document).ready(function() {
            comparison.init('#comparison');
        });
    });
})();