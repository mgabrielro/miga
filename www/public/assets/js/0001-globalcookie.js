(function(){

    "use strict";

    var ns = namespace("c24.check24.globalcookie.pv.pkv");

    /**
     *
     * @param parent_id             Parent ID
     * @param elements_to_cookie    key => value array where:
     *                              key   - name of element
     *                              value - name of parameter in coolie
     * @param save_days             How long save data in COOKIEs (in days)
     */
    ns.load = function(parent_id, elements_to_cookie, save_days) {

        var _this = this;

        _this.save_days = 0; /* 0 means - "forever" */

        if (save_days !== undefined) {
            _this.save_days = save_days;
        }

        _this.parent_id = parent_id;
        _this.elements_to_cookie = elements_to_cookie;

        _this.init();

    };

    ns.load.instances = [];

    ns.load.prototype = {

        "init": function(){

            var _this = this;

            $.each($('input, select, textarea', '#' + _this.parent_id), function (index, value) {

                var element_to_cookie = true;

                var element_cookie_name = _this.elements_to_cookie[$(this).attr('name')];

                if (element_cookie_name == undefined) {
                    element_to_cookie = false;
                }

                if (!element_to_cookie) {
                    return true;
                }

                /* Set COOKIE values as elements' values */
                var cookie_value = _this.get_cookie(element_cookie_name);

                if (cookie_value != undefined && cookie_value != '') {

                    if ($(this).is("input") && $(this).attr('type') == 'checkbox') {
                        if (cookie_value == 'checked') {
                            $(this).prop('checked', true);
                        }
                    } else if ($(this).is("input") && $(this).attr('type') == 'radio') {

                        var radio_values = [];
                        $.each($("input[name=" + $(this).attr('name') + "][type!='hidden']", '#' + _this.parent_id), function (index, value) {
                            radio_values.push($(this).attr('value'));
                        });

                        $("input[name=" + $(this).attr('name') + "][value=" + cookie_value + "][type!='hidden']", '#' + _this.parent_id).prop('checked', true);

                        for (var j = 0; j < radio_values.length; ++j) {
                            if (radio_values[j] != cookie_value) {
                                $("input[name=" + $(this).attr('name') + "][value=" + radio_values[j] + "][type!='hidden']", '#' + _this.parent_id).prop('checked', false);
                            }
                        }

                    } else {
                        $(this).val(cookie_value);
                    }


                }

                /* Add event handlers for data in COOKIE saving */
                if ($(this).is("input") && $(this).attr('type') == 'checkbox') {

                    if ($(this).is(':checked')) {
                        _this.set_cookie(element_cookie_name, 'checked', _this.save_days);
                    }

                    $(this).change(function () {
                        if ($(this).is(':checked')) {
                            _this.set_cookie(element_cookie_name, 'checked', _this.save_days);
                        } else {
                            _this.set_cookie(element_cookie_name, '', _this.save_days);
                        }
                    });

                } else if ($(this).is("input") && $(this).attr('type') == 'radio') {

                    if ($(this).is(':checked')) {
                        _this.set_cookie(element_cookie_name, $(this).val(), _this.save_days);
                    }

                    $(this).change(function () {
                        _this.set_cookie(element_cookie_name, $(this).val(), _this.save_days);
                    });

                } else {

                    if ($(this).val() != null && $(this).val() != '') {
                        _this.set_cookie(element_cookie_name, $(this).val(), _this.save_days);
                    }

                    $(this).blur(function () {
                        _this.set_cookie(element_cookie_name, $(this).val(), _this.save_days);
                    });

                }

            });

        },

        "set_cookie": function (cname, cvalue, exdays) {
            var cookie_str = cname + "=" + cvalue + ";";

            if (exdays !== undefined && exdays != 0) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                var expires = "expires=" + d.toUTCString();

                cookie_str += " " + expires;
            }

            document.cookie = cookie_str;
        },

        "get_cookie": function (cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');

            for (var i = 0; i < ca.length; i++) {

                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1);

                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }

            }

            return "";
        }

    };

})();
