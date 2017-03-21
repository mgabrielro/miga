;(function($) {

    $.fn.autoSave = function(options, method) {

        var callbackCounter = {};

        var runCallback = function(type, name, params) {

            if (typeof name === 'undefined') {
                var name = this.attr('name');
            }

            if (typeof callbackCounter[type] === 'undefined') {
                callbackCounter[type] = 0;
            }

            callbackCounter[type] ++;

            if (typeof options[type] === 'undefined') {
                return;
            }

            if (typeof options[type][name] === 'undefined') {

                if (name === 'main') {
                    options[type][name] = options[type];
                } else {
                    return;
                }

            }

            switch (options[type][name]) {

                case 'change' :
                case 'click'  :
                case 'keyup'  :
                    this[options[type][name]]();
                    break;

                default :

                    if (typeof params === 'undefined') {
                        params = this;
                    }

                    options[type][name](params);

            }


        };

        var prefix = options.prefix;

        if (method === 'save') {

            var name = this.attr('name'),
                type = this.attr('type'),
                val  = this.val();

            if (type === 'checkbox') {
                val = this.prop('checked') === true ? true : this.prop('checked') === 'checked';
            } else if (type === 'radio') {

                val = $('input[name="' + name + '"]:checked').val()

                if (typeof val === 'undefined') {
                    val = null;
                }

            }

            c24.et.local_storage.set(prefix + '/' + name, val);

            return;

        }

        this.each(function(k, v) {

            var ele = $(v);

            ele.find('input, select').each(function(k, v) {

                var inputEle = $(v),
                    type     = inputEle.prop("tagName") === 'SELECT' ? 'select' : inputEle.attr('type'), // tagName should use prop
                    name     = inputEle.attr('name'),
                    val = inputEle.val();

                if (typeof options.excludeFields === 'object' && options.excludeFields.indexOf(name) != -1) {
                    return;
                }

                inputEle.runCallback = runCallback;

                switch (type) {

                    case 'checkbox' :

                        if (c24.et.local_storage.get(prefix + '/' + name) !== null) {
                            inputEle.prop('checked', c24.et.local_storage.get(prefix + '/' + name));
                            inputEle.runCallback('onFill');
                        }

                        break;

                    case 'radio' :

                        if ((val = c24.et.local_storage.get(prefix + '/' + name)) !== null) {
                            $('input[name="' + name + '"][value="' + val + '"]').attr('checked', 'checked');
                            inputEle.runCallback('onFill');
                        }

                        break;

                    case 'text' :
                    case 'email' :
                    case 'url' :
                    case 'tel' :

                        if (val !== null) {

                            if ((val = c24.et.local_storage.get(prefix + '/' + name)) !== null) {
                                inputEle.val(c24.et.local_storage.get(prefix + '/' + name));
                                inputEle.runCallback('onFill');
                            }

                        }

                        break;

                    case 'select' :

                        if ((val = c24.et.local_storage.get(prefix + '/' + name)) !== null) {
                            inputEle.val(val);
                            inputEle.runCallback('onFill');
                        }

                        break;

                    case 'hidden' :

                        if (typeof options.hiddenFields === 'object' && options.hiddenFields.indexOf(name) != -1) {

                            if (val !== null) {

                                if ((val = c24.et.local_storage.get(prefix + '/' + name)) !== null) {
                                    inputEle.val(c24.et.local_storage.get(prefix + '/' + name));
                                    inputEle.runCallback('onFill');
                                }

                            }

                        }

                        break;

                    default :
                        return;
                }

                $(document).on('change', '#' + inputEle.attr('id'), function() {

                    var ele  = $(this),
                        name = ele.attr('name'),
                        type = inputEle.attr('type'),
                        val  = ele.val();

                    if (type === 'checkbox') {
                        val = ele.prop('checked') === true ? true : ele.prop('checked') === 'checked';
                    } else if (type === 'radio') {

                        val = $('input[name="' + name + '"]:checked').val()

                        if (typeof val === 'undefined') {
                            val = null;
                        }

                    }

                    c24.et.local_storage.set(prefix + '/' + name, val, 2000); // 1000

                });

            });

        });

        runCallback('onReady', 'main', callbackCounter);
        jQuery.noop.call(this);

        return this;

    };

})( jQuery );