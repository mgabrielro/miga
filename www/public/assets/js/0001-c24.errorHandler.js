/*
 * This is a construct to "mimic" private methods, which are otherwise not present in javascript. It is just an example how someone could use
 * namespaces to structure his/her code more cleanly.
 */
(function(namespace_to_construct){
    "use strict";

    var _modalOpen = false;


    (function(ns){

        $(document).ready(function(){
            ns.init();
        });

    })(namespace(namespace_to_construct, function(){}, {

        //-------------------PUBLIC METHODS--------------------
        init: function(){
            $( document ).ajaxError(function( event, jqxhr, settings, thrownError ) {
                return;

                var errorModal = $('#errorModal');

                if(errorModal){
                    errorModal.find(".js-c24-form-submit").on("click", function(){
                        errorModal.hide().promise().then(function(){
                            var _modalOpen = false;
                        });
                    });
                    errorModal.show().promise().then(function(){
                        _modalOpen = true;
                    });
                }
            });
        }
    }));
})("c24.errorHandler");