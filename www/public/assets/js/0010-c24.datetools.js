(function(namespace_to_construct){
    "use strict;";

    /**
     * constructor
     */
    function datetools() {

    }

    /**
     * Format date in german
     *
     * @param datestring
     * @returns {*}
     */

    datetools.prototype.date_to_de_format = function(datestring) {

        var date_formated = datestring;

        if (datestring.indexOf('-') > 0) {

            var _default_date_en = datestring.split("-");
            var _default_date_de = _default_date_en[2] + '.' + _default_date_en[1] + '.' + _default_date_en[0];
            date_formated = _default_date_de;

        }

        return date_formated;

    };

    /**
     * Format date in english
     *
     * @param datestring
     * @returns {*}
     */
    datetools.prototype.date_to_en_format = function(datestring) {

        var date_formated = datestring;

        if (datestring.indexOf('.') > 0) {

            var _default_date_de = datestring.split(".");
            var _default_date_en = _default_date_de[2] + '-' + _default_date_de[1] + '-' + _default_date_de[0];

            date_formated = _default_date_en;

        }

        return date_formated;

    };


    (namespace(namespace_to_construct, $.noop, {
        datetools: datetools
    }));

})("c24");