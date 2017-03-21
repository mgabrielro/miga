/**
 * Handles Piwik on js side
 * Feel free to add more piwik functionality
 *
 * @author ignaz schlennert <Ignaz.Schlennert@check24.de>
 * @date 26.09.2016
 *
 * @namespace c24.vv.pvk.tracking
 */
(function ($, document, window, undefinded){
    
    "use strict";
    
    var ns = namespace('c24.vv.pkv.tracking');
    
    ns.piwik =  {

        /**
         * Fire a Piwik trackEvent
         *
         * @param {string} category Category of Event in piwik
         * @param {string} action Action of Event in piwik
         * @param {string} name Name of Event in piwik
         */
        trackEvent: function (category, action, name) {
            _paq.push(['trackEvent', category, action, name]);
        },

        /**
         * Add a Track Event on Click of a Element
         *
         * @param {jQuery} $element jQuery Element for binding Click Event
         * @param {string} category Category of Event in piwik
         * @param {string} action Action of Event in piwik
         * @param {string} name Name of Event in piwik
         */
        addTrackEventOnClick: function ($element, category, action, name) {

            if (_paq !== undefinded && typeof(_paq) == "object") {

                $element.on('click', function () {
                    ns.piwik.trackEvent(category, action, name);
                });

            }

        }

    }
    
})($, document, window, undefined);