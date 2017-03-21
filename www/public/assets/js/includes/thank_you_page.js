/**
 * Check on Thank you page if a lead was finished with family Matching and has a consultant.
 * If we have a consultant where will toogle working and not working divs and fill the name of consultant to the divs
 *
 * @author ignaz schlennert <Ignaz.Schlennert@check24.de>
 * @date 20.09.2016
 *
 * @namespace c24.vv.pkv
 */
(function ($, document, window, undefined) {

    "use strict";

    var ns = namespace('c24.vv.pkv');

    /**
     * Class of consultant thank you page
     *
     * @type {string}
     */
    var working_div = '.working_hours';

    /**
     * Class of normal thank you page divs
     *
     * @type {string}
     */
    var not_working_div = '.no_working_hours';

    /**
     * Delay time for AJAX call
     *
     * @type {number} integer
     */
    var delay_time = 4000;

    ns.thank_you = {

        init: function () {
            ns.thank_you.toggle_consultant_box();
        },

        /**
         * toogle the consultant boxes with the normal boxes
         */
        toggle_consultant_box: function () {

            //Check if we are on Thank you page
            if ($('#c24-register-converted').length > 0) {

                $('.blocker').show();
                //We send a ajax call for check is correct Time and is family matching finish, there is no other way without timeout :-(
                setTimeout(ns.thank_you.get_consultant_data, delay_time);

            }

        },


        /**
         * Get the consultant_data with a ajax request to backend -> to api
         */
        get_consultant_data: function () {

            var $blocker = $('.blocker');
            var offer_id_text = $('#offer_id').text();
            var split_offer_id = offer_id_text.split(/\s+/);

            if (split_offer_id.length > 1) {

                //We check in Backend if the date is on holiday, weekend and if is in worktime
                $.ajax({
                    dataType: 'json',
                    url: '/ajax/json/consultantdata/' + split_offer_id[1] + '/',
                    timeout: 5000,
                    success: function (data) {

                        var content = data.content;

                        if (content.success) {

                            $('.any_questions').hide();
                            $(working_div).show();
                            $(working_div + ' .user').html(content.consultant.show_name);

                            var hotline = content.consultant_phone_prefix + ' ' + content.consultant.phoneprefix + ' ' + content.consultant.phonenumber;
                            var $phone = $('#optimize_tariff_choice .phone_thank');
                            $phone.attr('href', 'tel:' + hotline);
                            $phone.html(hotline);

                            //Add piwik Event for clicking on phone number
                            ns.tracking.piwik.addTrackEventOnClick($phone, 'Dankesseite', 'Anruf', 'Anruf mobile')

                        } else {
                            $(not_working_div).show();
                        }

                        $('.thank_you_content').show();

                    },
                    complete: function () {
                        $blocker.hide();
                        c24.vv.pkv.widget.cct.init();
                    },
                    error: function () {
                        $(not_working_div).show();
                    }
                });

            } else {
                $(not_working_div).show();
            }
        }
    };

    $(document).ready(function() {
        ns.thank_you.init();
    });


})($, document, window, undefined);