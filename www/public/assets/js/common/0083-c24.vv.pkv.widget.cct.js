/**
 * @name Init the crossselling for thank page
 * @namespace c24.vv.pkv.widget.cct
 *
 * @author Sebastian Bretschneider <sebastian.bretschneider@check24.de>
 */
(function($, ns) {

    'use strict';

    /**********************
     * PRIVATE ATTRIBUTES *
     **********************/ 

    var cct_container1 = null,
        cct_container2 = null;

    ns.cct = {

        /**
         * Init
         */
        init: function() {

            cct_container1 = $('#c24-crossselling-container-cct1');
            cct_container2 = $('#c24-crossselling-container-cct2');
            initialize_cross_selling();
        }

    };

    /**
     * Initialize Cross selling
     */
    function initialize_cross_selling() {

        if(typeof cct_container1 != 'null' && cct_container1.length) {
            cct_container1.cctSelect(window.cct1_data || {});
        }

        if(typeof cct_container2 != 'null' && cct_container2.length) {
            cct_container2.cctSelect(window.cct2_data || {});
        }
        
    }

})($, window.namespace('c24.vv.pkv.widget'));