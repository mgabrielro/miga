if (typeof c24 === 'undefined') {
    c24 = {};
}

if (typeof c24.et === 'undefined') {
    c24.et = {};
}

/**
 * Local storage wrapper
 *
 * @author    Pascale Schnell <pascale.schnell@check24.de>
 * @copyright CHECK24
 * @version   1.0
 */
 c24.et.local_storage = {

    primary_key : 'c24_et_local_storage',

    helper : {

        strpos : function (haystack, needle, offset) {
            var i = (haystack + '').indexOf(needle, (offset || 0));
            return i === -1 ? false : i;
        },
        is_array : function(val) {
            return Object.prototype.toString.call(val) ===  '[object Array]';
        },
        is_object : function(val) {
            return Object.prototype.toString.call(val) ===  '[object Object]';
        },
        get_auto_serialize : function(key) {

            if (typeof this.get_auto_serialize.stack === 'undefined') {

                var auto_serialize = localStorage.getItem('auto_serialize');

                try {
                    auto_serialize = JSON.parse(auto_serialize);
                } catch (e) {
                    auto_serialize = {};
                }

                if (!this.is_object(auto_serialize)) {
                    auto_serialize = {};
                }

                this.get_auto_serialize.stack = auto_serialize;

            }

            if (typeof key === 'undefined') {
                return this.get_auto_serialize.stack;
            }

            if (typeof this.get_auto_serialize.stack[key] === 'undefined') {
                return null;
            }

            return this.get_auto_serialize.stack[key];

        },
        set_auto_serialize : function(auto_serialize) {
            localStorage.setItem('auto_serialize', JSON.stringify(auto_serialize));
        }
    },
    is_available : function() {

        if (this.is_available.status == undefined) {

            try {
                localStorage.setItem("testItem", "testItem");
                this.is_available.status = window['localStorage'] !== null;
            } catch(e) {
                this.is_available.status = false;
            }

        }

        return  this.is_available.status;

    },
    clear : function() {

        if (!this.is_available()) {
            return;
        }

        localStorage.setItem(this.primary_key + '_expire_data', null);
        localStorage.setItem(this.primary_key, null);

    },
    remove : function(xpath) {

        if (!this.is_available()) {
            return;
        }

        this.set(xpath, null, 0);

    },


    set : function(xpath, item, expire) {

        if (!this.is_available()) {
            return null;
        }

        if (typeof expire === 'undefined') {
            expire = false;
        }

        var data = this.load(),
            tmp = {'d' : data},
            xpath_exp = xpath.split('/'),
            i,
            l = xpath_exp.length;

        for (i = 0; i < l; i ++) {

            if (i === 0) {
                this.set_expire(xpath_exp[i], expire);
            }

            if (!this.helper.is_object(tmp.d[xpath_exp[i]])) {
                tmp.d[xpath_exp[i]] = {};
            }

            if (i === (l - 1)) {
                tmp.d[xpath_exp[i]] = item;
            }

            tmp.d = tmp.d[xpath_exp[i]];

        }

        this.save(data);

    },
    get : function(xpath, extend_expiration) {

        if (!this.is_available()) {
            return null;
        }

        if (extend_expiration !== true) {
            extend_expiration = false;
        }

        try {
            var expire = JSON.parse(localStorage.getItem(this.primary_key + '_expire_data'));
        } catch (e) {
            return null;
        }

        var data = this.load();

        if (typeof xpath === 'undefined') {
            return data;
        }

        var xpath_exp = xpath.split('/'),
            i,
            l = xpath_exp.length;

        for (i = 0; i < l; i ++) {

            if (i === 0) {

                if (expire === null) {
                    expire = {};
                    expire[xpath_exp[i]] = false;
                }

                if (typeof expire[xpath_exp[i]] === 'undefined') {
                    return null;
                }

                if (expire[xpath_exp[i]].timestamp !== false) {

                    if (expire[xpath_exp[i]].timestamp < (new Date().getTime() / 1000)) {
                            return null;
                    }

                    if (extend_expiration) {
                        this.set_expire(xpath_exp[i], expire[xpath_exp[i]].seconds);
                    }

                }

            }

            if (data === null || typeof data[xpath_exp[i]] === 'undefined') {
                return null;
            }

            data = data[xpath_exp[i]];

        }

        return data;

    },
    set_expire : function(xpath, expire) {

        var data,
            timestamp = false;

        try {
            data = JSON.parse(localStorage.getItem(this.primary_key + '_expire_data'));
        } catch (e) {
            data = {};
        }

        if (!this.helper.is_object(data)) {
            data = {};
        }

        if (expire !== false) {
            timestamp = (new Date().getTime() / 1000) + expire;
        }

        data[xpath] = {
            'timestamp' : timestamp,
            'seconds' : expire
        };

        localStorage.setItem(this.primary_key + '_expire_data', JSON.stringify(data));

    },
    load : function() {

        try {
            data = JSON.parse(localStorage.getItem(this.primary_key));
        } catch (e) {
            data = {};
        }

        if (data === null) {
            data = {};
        }

        return data;

    },
    save : function(data) {
        localStorage.setItem(this.primary_key, JSON.stringify(data));
    }

};
