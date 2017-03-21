"use strict;";

(function(namespaceToConstruct){

    //-------------------"PRIVATE METHODS"--------------------


    (function(ns){

        //-------------------PSEUDO-CONSTRUCTOR OF THE NAMESPACE--------------------

        /*
         * This is not a constructor in any way, regarding javascript language constructors. It is just a self executing function which is called after all relevant other
         * parts for this namespace are loaded. (The public and the private method definitions)
         * Namespaces are NO Classes, but structured scopes!
         */

        $(document).ready(function(){
            ns.init();
        });

    })(namespace(namespaceToConstruct, $.noop, {

        //-------------------PUBLIC METHODS--------------------
        init: function(){

            /* Send method hook of jQuery-AJAX. */
            $(document).ajaxSend(function (event, jqXHR, settings) {

                var username = settings.username || '';
                var password = settings.password || '';

                /* Check, if "username" has been set for AJAX-calls: */
                if (username) {
                    /* Setting header-information to fix authentication problems in safari */

                    /* Setting header-information to fix base authorization problems in ajax call */
                    jqXHR.setRequestHeader("Authorization", "Basic " + btoa(username + ":" + password));

                }

            });

        },
        login: function(username, password){
            return $.ajax({
                url : $.rs.controller.getScriptUrl('json_c24login_login', null),
                dataType: 'jsonp',
                data: {
                    'email': username,
                    'password': password
                }
            });
        }
    }));
})("c24.login.ajax");