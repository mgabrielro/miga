/*
 * This is a construct to "mimic" private methods, which are otherwise not present in javascript. It is just an example how someone could use
 * namespaces to structure his/her code more cleanly.
 */
(function(namespace_to_construct){
    "use strict";

    //-------------------"PRIVATE METHODS"--------------------
    function ultra_private_function(){
        console.log('Im only living inside the scope of a SEAF! (Self-Executing Anonymous Function)');
        console.log('I do not polute anything!');
    }

    (function(ns){

        //-------------------PSEUDO-CONSTRUCTOR OF THE NAMESPACE--------------------

        /*
         * This is not a constructor in any way, regarding javascript language constructors. It is just a self executing function which is called after all relevant other
         * parts for this namespace are loaded. (The public and the private method definitions)
         * Namespaces are NOT Classes, but more in the sense of structured scopes!
         */
        $(document).ready(function(){
            ns.init();
        });

    })(namespace(namespace_to_construct, function(){}, {

        //-------------------PUBLIC METHODS--------------------
        init: function(){
            ultra_private_function();
        }
    }));
})("c24.check24.exampleNamespace");