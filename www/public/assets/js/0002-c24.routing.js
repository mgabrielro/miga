(function(namespace_to_construct){
    "use strict";


    /**
     * replace route parameters over object iteration
     *
     * @param {string} route
     * @param {object} parameter
     * @returns {string}
     * @private
     */
    function _replace_route_parameters(route, parameter)
    {
        parameter = parameter || {};

        for(var key in parameter)
        {
            if(parameter.hasOwnProperty(key)) {
                route = route.replace(key, parameter[key]);
            }
        }

        return route;
    }

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

    })(namespace(namespace_to_construct, $.noop, {

        //-------------------PUBLIC METHODS--------------------
        init: function(){

        },

        getUrl: function(route_name, parameters){

            var route_match = null;

            switch(route_name){

                case 'input1':
                    route_match = '/pkv/benutzereingaben/';
                    break;
                case 'result':
                    route_match = '/pkv/vergleichsergebnis/';
                    break;
                case 'user_login':
                    route_match = '/user/login';
                    break;
                case 'user_logout':
                    route_match = '/user/logout';
                    break;
                case 'json_get_cities':
                    route_match = '/ajax/json/city/:zip/';
                    break;
                case 'json_get_streets':
                    route_match = '/ajax/json/street/:zip/:city/';
                    break;
                case 'ajax_json_occupation':
                    route_match = '/ajax/json/occupation/:snippet/:limit';
                    break;
                case 'check_coupon_code':
                    route_match = '/app/api/cscode_check/:product_id/:code';
                    break;
                default:
                    console.log('Unfinished Method "c24.routing.getUrl("'+route_name+'")"!');
            }

            return _replace_route_parameters(route_match, parameters);
        }
    }));
})("c24.routing");