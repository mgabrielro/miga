/**
 * @name Module Scroll Arrow
 * @namespace c24.vv.pkv.widget.result
 *
 * @author Sebastian Bretschneider <sebastian.bretschneider@check24.de>
 */
(function (window, document, $) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.result");

    /**
     * Arrow selector
     *
     * @type {string}
     * @private
     */
    var _arrow_selector = '.scrollTopArrow';

    /**
     * Document
     *
     * @type {*|jQuery}
     */
    var documentscroll = $(document);

    /**
     * DOM to the class 'scrollTopArrow'
     *
     * @type {*|jQuery}
     */
    var $scrollTopArrowfind = $('#filter-container').parent().find('.scrollTopArrow');

    /**
     * FF doesn't recognize mousewheel as of FF3.x
     *
     * @type {string}
     */
    var mousewheelevt = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel";


    /**
     * Scroll this element to top, if you click this element
     * Click handler
     *
     * @private
     */
    ns.on_click_handler = function () {

        $(_arrow_selector).on('click', function (e) {

            c24.vv.shared.util.scroll_top();

            $('#filter-container').parent().find('.scrollTopArrow').stop(true, true).fadeOut();

            e.preventDefault();

        });

    };

    /**
     * Calls functions necessary for initialisation.
     */
    ns.init = function () {

        this.scroll_arrow_top();
        this.arrow_html_element();
        this.on_click_handler();

    };

    /**
     * Verified the distance of scroll-document to top and show the class 'scrollTopArrow' or not
     */
    ns.scroll_arrow_top = function () {

        /**
         * get number of distance from scroll to top
         *
         * @type {number}
         */
        var lastScrollTop = 0;

        $(document).scroll(function (event) {

            if ($('[aria-controls=result-container][aria-selected]').hasClass('ui-state-active')) {

                var st = $(this).scrollTop();

                // The arrow should appear only when we scroll upwards; the idea is to help scroll to the top when
                // deep down in the results. This is why we have this check (it will be true when scrolling upwards as
                // the last scroll position will be greater when scrolling upwards).
                if (st < lastScrollTop) {

                    if (documentscroll.scrollTop() > 500) {
                        var arrow = $('#filter-container').parent().find('.scrollTopArrow');
                        arrow.toggleClass('above-compare-menu', $('#compare-menu').is(':visible'));
                        arrow.stop(true, true).fadeIn();

                        $(".scrollTopArrow").click(function () {
                            $(this).data('clicked', true);
                        });

                        if ($('.scrollTopArrow').data('clicked')) {
                            event.preventDefault();
                        }

                    } else {
                        $('#filter-container').parent().find('.scrollTopArrow').stop(true, true).fadeOut();
                    }

                } else {
                    $('#filter-container').parent().find('.scrollTopArrow').stop(true, true).fadeOut();
                }

                lastScrollTop = st;

            }

        });

    };

    /**
     * Build a element for scrollTopArrow
     */
    ns.arrow_html_element = function () {
        $('#filter-container').parent().append('<a href="#"><span class="scrollTopArrow"></span></a>');
    };

    ns.init();

})(window, document, jQuery);