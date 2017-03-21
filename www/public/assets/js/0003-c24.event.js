(function(namespaceToConstruct){
    "use strict";

    //-------------------"PRIVATE METHODS"--------------------

    function EventManager(){

    }

    EventManager.inherit(EventEmitter);

    (function(ns){

        ns.init();

    })(namespace(namespaceToConstruct, $.noop, {

        //-------------------PUBLIC METHODS--------------------
        init: function(){

        },
        eventManager: new EventManager()
    }));
})("c24.event");