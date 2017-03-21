(function ($){

    if (!$.rs) {
        $.rs = {};
    }

    $.rs.controller = {

        version: '1.0',
        vars: {},
        scriptUrls: {},
        status: {
            AJAX_USER_AUTH_ERROR: 111
        },

        setVar: function(key, value) {
            this.vars[key] = value;
        },

        getVar: function(key) {
            return this.vars[key];
        },

        addScriptUrl: function(key, url) {
            this.scriptUrls[key] = url;
        },

        getScriptUrl: function(key, prms) {

            var url = this.scriptUrls[key];

            if (prms != undefined) {

                for (key in prms) {

                    if (url.indexOf('?') == '-1') {
                        url += '?';
                    } else {
                        url += '&';
                    }

                    url += key + '=' + prms[key];

                }

            }

            return url;

        }

    };

})(jQuery);