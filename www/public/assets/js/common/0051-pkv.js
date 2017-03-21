$(document).ready(function() {

    $('#c24-header-menu-button').on('click touchstart', function (e) {

        $('#main_content').toggleClass('menu-opened');
        $('.menu_container').toggleClass('menu-opened');
        e.preventDefault();

    });

    $('.c24-navi-header-close').on('click touchstart', function () {

        $('#main_content').toggleClass('menu-opened');
        $('.menu_container').toggleClass('menu-opened');

    });

    $('.deactive_block').on('click touchstart', function (e) {

        $('#main_content').toggleClass('menu-opened');
        $('.menu_container').toggleClass('menu-opened');
        e.preventDefault();

    });

    $.rs.mobilesite.init_device_orientation();

    $(window).resize(function () {
        $.rs.mobilesite.init_device_orientation();
    });

    // set the status of the dental_no_maximum_refund_status checkox based on the dental option
    $.rs.mobilesite.set_c24api_dental_no_maximum_refund_status();

    /**
     * If is an android device, we have specific validation rules
     * for the three input fields which compose the user birthdate
     */
    if (is_android_mobile_device() && $('#c24api_birthdate_container_android').length > 0) {
        $.android_birthdate.input1.control_input_fields_behavior();
    }

    $("#resultform").submit(function(e) {

        /**
         * If is an android device, we have 3 different input fields
         * for the birthday (day, month and year).
         *
         * Because is only a frontend thing for a better usability, in
         * order to receive the correct results, on submit we update
         * the default c24api_birthdate field value with the resulted
         * value composed from these 3 input fields
         *
         * Because for child we have a default birthdate for now, we need to exclude the update !
         */
        if (is_android_mobile_device() && !$.android_birthdate.input1.is_child()) {
            $.android_birthdate.input1.update_default_birthdate_field_value();
        }

        $.rs.mobilesite.adjust_input1_browser_history();

    });

    /**
     * Open a tooltip after click icon-element
     */
    $('.c24-info-icon-tooltip , .c24-result-tariff-name-list').on('click touchstart', function () {

        var elem;

        if (!$(this).hasClass('no-tooltip')) {

            if ($(this).hasClass('c24-info-icon-tooltip')) {
                elem = $(this).parent();
            } else {
                elem = $(this);
            }

            var x = elem.find('.c24-info-icon-tooltip').position();

            var corner_css_left = x.left - 8;
            var tooltip_css_min_width = x.left + 8;

            if (tooltip_css_min_width < 200) {
                tooltip_css_min_width = 200;
            }

            var tooltip_css_left = 10;

            if (x.left - 300 > tooltip_css_left) {
                tooltip_css_left = x.left - 300;
                corner_css_left = corner_css_left - tooltip_css_left + 10;
                tooltip_css_min_width = tooltip_css_min_width - tooltip_css_left;
            }
            
            /* We need to hide all visible tooltips on compare page before we make the new one visible */

            if ($('.compare').length) {
                $('.c24-content-row-block-infobox-tool').hide();
            }

            /* Tooltip fix for tooltip corner tarif-register page */

            if ($('.tarif-register').length) {
                var tooltip_css_left = 0;
            }

            /* Set min-width and left position for the tooltip body and corner */
            var infobox_tooltip = elem.find('.c24-content-row-block-infobox-tool');

            infobox_tooltip.css('left', tooltip_css_left);
            infobox_tooltip.css('min-width', tooltip_css_min_width);
            infobox_tooltip.show();
            elem.find('.c24-corner-open').css('left', corner_css_left);

        }

    });

    // Handle tooltip for interfere, if click on interferer-info
    $('.c24_tariff-overview').find('.c24-interferer-text-wrapper').on('click touchstart', function () {

        if ($('.c24-content-row-block-infobox').is(':visible')) {
            $('.c24-content-row-block-infobox-tool').hide();
        }

        //remove all potential favorite-tooltips on page
        window.c24.vv.pkv.favorite.removeAllFavoritesTooltips();

        var header_wrapper              = $(this).parents('.c24-result-top-row');
        var tooltip_height              = header_wrapper.find('.c24-content-row-block-infobox').height();
        var tariff_information_height   = header_wrapper.find('.c24-wrapper-tariff-informations').outerHeight();
        var diff                        = tooltip_height - tariff_information_height;
        var interfer_info_left          = header_wrapper.find('.c24-interferer-info').offset().left;
        var arrow_width                 = 30;
        var info_width                  = header_wrapper.find('.c24-interferer-info').width();
        var arrow_position              = interfer_info_left - (arrow_width/2) - (info_width/2);

        if ($('.c24-tariff-overview-toogle').hasClass('arrow_up')) {
            $('.c24-tariff-overview-toogle').css('margin-bottom', tooltip_height );
        } else {

            if (tooltip_height > tariff_information_height) {
                $('.c24-tariff-overview-toogle').css('margin-bottom', diff );
            }
        }

        $('.arrow_top').css('left', arrow_position);
        $(this).parents('.c24-interferer-wrapper').find('.c24-content-row-block-infobox').show();
    });

    $('.c24-interferer-wrapper').find('.c24-info-close-row').on('click touchstart', function () {
            $('.c24-tariff-overview-toogle').css('margin-bottom', 0 );
    });

    /**
     * Close tooltip, if you click tooltip and hide other open tooltip
     */

    $('.c24-result-tariff-name-list').on( 'click touchstart', function() {
        if ($('.c24-content-row-block-infobox-tool').is(':visible')) {
            $('.c24-content-row-block-infobox').hide();
            }
        });

    $('.c24-tooltip-close').on('click', function () {
        $(this).parent().hide();
    });

    /**
     *  PVPKV-1473 Workaround for removing the placeholder class, because there are no more placeholder for datefields
     */
    if ($('#c24api_birthdate').val() == ''){
        $('#c24api_birthdate').removeClass('notempty');
    } else {
        $('#c24api_birthdate').addClass('notempty');
    }

    /**
     * If we have an employee, we do not show the Fußnote
     * accordeon on the 'Filter' tab
     */
    if ($('#c24api_profession').val() == 'employee') {

        var $filter_tab  = $('#tabs .ui-block-b');
        var $footer_note = $('#c24-content div.tarifffootnote');

        if ($filter_tab.hasClass('ui-state-active')) {
            $footer_note.hide();
        }

        $filter_tab.click(function() {
            $footer_note.hide();
        });
    }

});