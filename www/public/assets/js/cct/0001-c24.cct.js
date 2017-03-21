(function(namespace_to_construct){
    "use strict";

    var cct_container1 = null,
        cct_container2 = null;
    var cct1_data, cct2_data;

    /**
     * initialize cross selling teasers
     * @private
     */
    function _initialize_cross_selling(){

        if(typeof cct_container1 != 'null' && cct_container1.length) {
            cct_container1.cctSelect(cct1_data || {});
        }

        if(typeof cct_container2 != 'null' && cct_container2.length) {
            cct_container2.cctSelect(cct2_data || {});
        }
    }

    (function(ns){

        //-------------------PSEUDO-CONSTRUCTOR OF THE NAMESPACE--------------------
        $(document).ready(function(){
            ns.init();
        });

    })(namespace(namespace_to_construct, $.noop, {

        //-------------------PUBLIC METHODS--------------------
        init: function(){

            cct_container1 = $('#c24-crossselling-container-cct1');
            cct_container2 = $('#c24-crossselling-container-cct2');

            _initialize_cross_selling();

        },

        set_data: function(data_1, data_2){

            cct1_data = data_1;
            cct2_data = data_2;

        }


    }));

})("c24.cct");