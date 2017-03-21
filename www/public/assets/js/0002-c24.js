(function(namespaceToConstruct){
    "use strict";

    //-------------------"PRIVATE METHODS"--------------------
    (function(ns){

        //-------------------PSEUDO-CONSTRUCTOR OF THE NAMESPACE--------------------

        /*
         * This is not a constructor in any way, regarding javascript language constructors. It is just a self executing function which is called after all relevant other
         * parts for this namespace are loaded. (The public and the private method definitions)
         * Namespaces are NO Classes, but structured scopes!
         */

        ns.init();

    })(namespace(namespaceToConstruct, $.noop, {

        //-------------------PUBLIC METHODS--------------------
        init: function(){

        }
    }));
})("c24");