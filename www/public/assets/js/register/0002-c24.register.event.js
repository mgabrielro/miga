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
        $(document).ready(function(){
            ns.init();
        });

    })(namespace(namespaceToConstruct, $.noop, {

        //-------------------PUBLIC METHODS--------------------
        init: function(){
            c24.event.eventManager.addListener(this.pre_city_call, function(){
                $("#city_label").html("");
                $(".loading-panel").show();
                $("#city_text").hide();
            });

        },

        pre_city_call: 'pre_city_call',
        post_city_call: 'post_city_call'
    }));
})("c24.register.event");