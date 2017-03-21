(function($) {
    "use strict";


    /**
     * Capitalizes first letter.
     *
     * @returns {string}
     */
    String.prototype.ucFirst = function() {
        return this.charAt(0).toUpperCase() + this.slice(1);
    };

    /**
     * Returns a value for a given url parameter
     * @param key
     * @param [default_value]
     */
    $.getUrlVar = function(key, default_value) {
        var result = new RegExp(key + '=([^&]*)', 'i').exec(window.location.search);
        return decodeURIComponent((result == null || result && result[1] == '' ? default_value : result[1]));
    };

    /**
     * Parses the session id from the current locations pathname
     * @returns {string}
     */
    $.getSessionId = function() {
        var result = new RegExp('/([^\/]+)').exec(window.location.pathname);

        if (result[1].length == 32) {
            return result[1];
        } else {
            return '';
        }

    };


    /**
     * Check if the called event was triggered by a user (useful for click events)
     * @returns {boolean}
     */
    $.isUserEvent = function(evt) {
        return !!(evt.clientX && evt.clientY);
    };




    /**
     * Check if given date is in correct format
     *
     * @param str
     * @returns {boolean}
     */
    $.check_date =  function (str){
        var parms = str.split(/[\.\-\/]/);
        var yyyy = parseInt(parms[2],10);
        var mm   = parseInt(parms[1],10);
        var dd   = parseInt(parms[0],10);
        var date = new Date(yyyy,mm-1,dd,0,0,0,0);

        if(yyyy < 1900 || yyyy > 10000){
            return false;
        }else{
            return mm === (date.getMonth()+1) && dd === date.getDate() && yyyy === date.getFullYear();
        }

    };

    /**
     * Returns the age from a given date.
     *
     * @param date
     * @returns {number}
     */
    $.get_age_from_date = function (date) {

        var parms = date.split(/[\.\-\/]/);
        var yyyy = parseInt(parms[2],10);
        var mm   = parseInt(parms[1],10);
        var dd   = parseInt(parms[0],10);

        var today = new Date();
        var birthDate = new Date(yyyy,mm-1,dd,0,0,0,0);;
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;

    }

    $.parseDate = function(input, format) {

        if (input) {
            format = format || 'yyyy-mm-dd'; // default format
            var parts = input.match(/(\d+)/g),
                i = 0, fmt = {};
            // extract date-part indexes from the format
            format.replace(/(yyyy|dd|mm)/g, function(part) { fmt[part] = i++; });

            return new Date(parts[fmt['yyyy']], parts[fmt['mm']]-1, parts[fmt['dd']]);
        }

    }

    $.date_obj_to_eu_format = function(date) {
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();

        if (day < 10) {
            day = '0' + day;
        }

        if (month < 10) {
            month = '0' + month;
        }

        return day + "." + month + "." + year;
    };

    $.date_obj_to_en_format = function(date) {
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();

        if (day < 10) {
            day = '0' + day;
        }

        if (month < 10) {
            month = '0' + month;
        }

        return year + "-" + month + "-" + day;
    };

    $.month_diff = function(d1, d2) {

        var months;
        months = (d2.getFullYear() - d1.getFullYear()) * 12;
        months -= d1.getMonth() + 1;
        months += d2.getMonth();
        return months <= 0 ? 0 : months;

    }

    /**
     * Open a custom Dialog
     *
     * @param subject   The Title of the Dialog.
     * @param msg       The Content of the Dialog.
     * @param width     The width of the Dialog.
     * @param callback  Callback function that will be run after the "OK"
     *                  button is pressed.
     */
    $.dialogAlert = function (subject, msg, width, callback) {

        if (!width) {
            width = 300;
        }

        // Remove old Alerts from DOM tree
        $("#dialog-alert").remove();

        // Add our holder of the dialog to DOM
        $("body").append('<div id="dialog-alert" style="text-align: center;line-height: 26px;">' + msg + '</div>');

        // We use the jQuery Dialog
        $( "#dialog-alert" ).dialog({
            title: subject,
            resizable: false,
            width:width,
            modal: true,
            dialogClass: "alert",
            buttons: {
                Ok: function() {
                    $("#dialog-alert").dialog("close");
                    $("#dialog-alert").remove();

                    callback;
                }
            }
        });

    }

    /**
     * Open a custom Dialog
     *
     * @param subject   The Title of the Dialog.
     * @param msg       The Content of the Dialog.
     * @param width     The width of the Dialog.
     * @param callback  Callback function that will be run after the "OK"
     *                  button is pressed.
     * @param callback  Callback function that will be executed after the dialog
     *                  has been closed
     */
    $.dialogConfirm = function (subject, msg, width, ok_title, cancel_title, ok_callback, cancel_callback, close_callback) {

        if (!width) {
            width = 300;
        }

        // Remove old Alerts from DOM tree
        $("#dialog-alert").remove();

        // Add our holder of the dialog to DOM
        $("body").append('<div id="dialog-alert" style="text-align: center;line-height: 26px;">' + msg + '</div>');

        // We use the jQuery Dialog
        $( "#dialog-alert" ).dialog({
            title: subject,
            resizable: false,
            width: width,
            modal: true,
            dialogClass: "alert",
            buttons:
                [
                    {
                        text: ok_title,
                        click: function() {
                            $("#dialog-alert").dialog("close");
                            $("#dialog-alert").remove();

                            ok_callback();
                        }
                    },
                    {
                        text: cancel_title,
                        click: function() {
                            $("#dialog-alert").dialog("close");
                            $("#dialog-alert").remove();

                            cancel_callback();
                        }
                    }
                ],
            close: function () {
                close_callback();
            }
        });

    };

    /**
     * Get array with date values dependent on selected value in filter
     *
     * @param date_filter_value    Value of the filter
     * @param today                Current date
     * @returns {{date_from: *, date_to: *}}
     */
    $.get_date_filter_dates = function (date_filter_value, today) {

        if (today === undefined) {
            today = new Date();
        }

        var date_from;
        var date_to;

        switch (date_filter_value) {
            case 'today':
                date_from = $.date_obj_to_eu_format(today);
                date_to = $.date_obj_to_eu_format(today);
                break;
            case 'yesterday':
                var yesterday = new Date(today.getFullYear(), today.getMonth(), today.getDate() - 1);
                date_from = $.date_obj_to_eu_format(yesterday);
                date_to = $.date_obj_to_eu_format(yesterday);
                break;
            case 'last_week':
                var beforeOneWeek = new Date(today.getTime() - 60 * 60 * 24 * 7 * 1000)
                    , day = beforeOneWeek.getDay()
                    , diffToMonday = beforeOneWeek.getDate() - day + (day === 0 ? -6 : 1)
                    , lastMonday = new Date(new Date(today.getTime() - 60 * 60 * 24 * 7 * 1000).setDate(diffToMonday))
                    , lastSunday = new Date(new Date(today.getTime() - 60 * 60 * 24 * 7 * 1000).setDate(diffToMonday + 6));
                date_from = $.date_obj_to_eu_format(lastMonday);
                date_to = $.date_obj_to_eu_format(lastSunday);
                break;
            case 'last_month':
                var lastMonth = new Date(today.getFullYear(), today.getMonth()-1, 1);
                date_from = $.date_obj_to_eu_format(lastMonth);
                date_to = $.date_obj_to_eu_format(new Date(today.getFullYear(), today.getMonth(), 0));
                break;
            default:
                date_from = '';
                date_to = '';
                break;
        }

        return {
            date_from: date_from,
            date_to: date_to
        };

    };

    /**
     * Eventemitter
     *
     * @type {{_JQInit: _JQInit, emit: emit, once: once, on: on, off: off}}
     */
    $.eventEmitter = {
        _JQInit: function() {
            this._JQ = jQuery(this);
        },
        emit: function(evt, data) {
            !this._JQ && this._JQInit();
            this._JQ.trigger(evt, data);
        },
        once: function(evt, handler) {
            !this._JQ && this._JQInit();
            this._JQ.one(evt, handler);
        },
        on: function(evt, handler) {
            !this._JQ && this._JQInit();
            this._JQ.bind(evt, handler);
        },
        off: function(evt, handler) {
            !this._JQ && this._JQInit();
            this._JQ.unbind(evt, handler);
        }
    };

})(jQuery);
