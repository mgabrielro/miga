/**
 * This namespace tariffname_shortener use with jQuery plugin dotdotdot()
 * If the text in the div-content is bigger than the limit of height then use the jQuery plugin dotdotdot()
 *
 * Namespace for c24.vv.pkv.widgets.tariffname_shortener
 *
 * @author Sebastian Bretschneider <sebastian.bretschneider@check24.de>
 */
(function ($, document){

    "use strict";

    var ns = namespace("c24.vv.pkv.widgets");

    ns.tariffname_shortener = {

        /**
         * Limit height that the dotdotdot function should to cut the content in compare page
         */
        limit_height_compare : 32,

        /**
         * Limit height that the dotdotdot function should to cut the content in other page
         */
        limit_height_default : 22,

        /**
         * Init
         */
        init: function() {

            /**
             * Start jQuery plugin dotdotdot() by compare_page, if the element with the class name compare-header is visible
             * otherwise start jQuery plugin dotdotdot() for other page, because there has same height
             */
            if ($('#c24-content .compare-header').is(':visible')) {
                this.start_dotdotdot('.c24-result-tariff-name-list-content', this.limit_height_compare);
            } else {
                this.start_dotdotdot('.c24-result-tariff-name-list-content', this.limit_height_default);
            }

        },

        /**
         * Start the jQuery plugin dotdotdot() with paramter selector and height of the content
         *
         * @param {string} selector The name of div-element selector that should use dotdotdot
         * @param {integer} height The limit of height that should cut the content and use dotdotdot
         */
        start_dotdotdot : function(selector, height) {

            $(selector).dotdotdot({
                /*	The text to add as ellipsis. */
                ellipsis	: '.......',

                /*	How to cut off the text/html: 'word'/'letter'/'children' */
                wrap		: 'word',

                /*	Wrap-option fallback to 'letter' for long words */
                fallbackToLetter: true,

                /*	jQuery-selector for the element to keep and put after the ellipsis. */
                after		: null,

                /*	Whether to update the ellipsis: true/'window' */
                watch		: false,

                /*	Optionally set a max-height, can be a number or function.
                 If null, the height will be measured. */
                height		: height, // max number of lines 3 * 20

                /*	Deviation for the height-option. */
                tolerance	: 0,

                /*	Callback function that is fired after the ellipsis is added,
                 receives two parameters: isTruncated(boolean), orgContent(string). */
                callback	: function( isTruncated, orgContent ) {

                    if (isTruncated) {

                        var str = $(this).text();
                        var res = str.slice(0, -7);
                        $(this).text(res);
                        var $current_element = $(this).parent().find('.tooltip-wrapper');
                        $(this).append($current_element);
                        $current_element.css('display', 'inline-block');

                    }

                },

                lastCharacter	: {

                    /*	Remove these characters from the end of the truncated text. */
                    remove		: [ ' ', ',', ';', '.', '!', '?' ],

                    /*	Don't add an ellipsis if this array contains
                     the last character of the truncated text. */
                    noEllipsis	: []
                }

            });

        }

    };

    /**
     * Call tariffname_shortener with the methode init() after document is ready
     */
    $(document).ready(function() {
         ns.tariffname_shortener.init();
    });

})($, document);