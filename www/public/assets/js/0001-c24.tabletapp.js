(function(namespace_to_construct){
    "use strict";


    (function(ns){

        //-------------------PSEUDO-CONSTRUCTOR OF THE NAMESPACE--------------------

        /*
         * This is not a constructor in any way, regarding javascript language constructors. It is just a self executing function which is called after all relevant other
         * parts for this namespace are loaded. (The public and the private method definitions)
         * Namespaces are NO Classes, but structured scopes!
         */

        $(document).ready(function(){
            // only load this plugin if tabletapp is active
            if (window.deviceoutput == "tabletapp"){
                ns.init();
            }
        });

    })(namespace(namespace_to_construct, $.noop, {

        //-------------------PUBLIC METHODS--------------------
        init: function(){
            // removing some unnecessary c24.tooltips
            // and adding a spinner to the page
            $('#result_content .row-content .row-column.c24-tooltip').removeClass('c24-tooltip').on('click', function(event){c24.check24.input1.load.prototype.show_spinner()});

            // viewport modification
            $('meta[name=viewport]').attr("content", "width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no");

            this.set_browser();

            // the spinner has to be hidden if the page is loaded from the browser cache -> e.g. iOS
            $(window).bind("pageshow", function (event) {
                if (event.originalEvent.persisted) {
                    $('.pkv_loader').hide();
                }
            });

        },

        set_browser: function () {

            if (window.jQBrowser.android) {
                $("html").addClass("android");
            } else if (window.jQBrowser.ipad || window.jQBrowser.iphone || window.jQBrowser.ipod) {
                $("html").addClass("ios");
            }

        }

    }));
})("c24.tabletapp");
