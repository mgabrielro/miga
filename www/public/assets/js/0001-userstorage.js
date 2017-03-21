(function(){

    "use strict";

    var ns = namespace("c24.check24.storage.pv.pkv");

    /**
     * Check if storage is available and works
     *
     * @parameter localstorage
     * @return boolean 
     */
    ns.storage_available = function(storage) {
        var test_key = '_test_item';
        if(!storage) {
            return false;
        }

        try {
            storage.setItem(test_key, test_key);
            storage.removeItem(test_key);

            return true;
        } catch (exception) {
            return false;
        }
    };

    /**
     * Load function
     *
     * @param storage_type          Storage type. 'local' or 'session'
     * @param parent_id             Parent ID
     * @param blacklist_elements    Array of elements
     * @return void
     */
    ns.load = function(storage_type, parent_id, blacklist_elements) {

        var _this = this;

        _this.storage = localStorage;

        if (storage_type == 'session') {
            _this.storage = sessionStorage;
        }

        _this.parent_id = parent_id;

        if(!ns.storage_available(_this.storage)) {
            return;
        }

        _this.elements_ignore = [];

        if (typeof blacklist_elements !== typeof undefined && blacklist_elements != '') {

            for (var i = 0; i < blacklist_elements.length; ++i) {
                _this.elements_ignore[blacklist_elements[i]] = '';
            }
        }

        _this.init();

    };

    /**
     *
     * @type {Array}
     */
    ns.load.instances = [];

    /**
     *
     * @type {{init: "init", get_storage_value: "get_storage_value"}}
     */
    ns.load.prototype = {

        /**
         * Init function: load storage values, add handlers for elements
         */
        "init": function(){

            var _this = this;

            $.each($("input[type!='hidden'][type!='button'], select, textarea", '#' + _this.parent_id), function (index, value) {

                var element_to_storage = true;

                if (typeof $(this).attr('name') == 'undefined' || $(this).attr('name') in _this.elements_ignore) {
                    element_to_storage = false;
                }

                if (!element_to_storage) {
                    return true;
                }

                /* Check if element has the ID. Ignore the radio inputs. They don't have IDs */
                if ($(this).attr('type') != 'radio' && typeof $(this).attr('id') === typeof undefined && $(this).attr('id') === false) {
                    return true;
                }

                /* Set values from storage */
                var localValue = _this.get_storage_value($(this));

                if (localValue !== null) {

                    if ($(this).is("input") && $(this).attr('type') == 'checkbox') {
                        if (localValue == 'checked') {
                            $(this).prop('checked', true);
                        } else if (localValue == '') {
                            $(this).prop('checked', false);
                        }
                    } else if ($(this).is("input") && $(this).attr('type') == 'radio') {

                        var radio_values = [];
                        $.each($("input[name=" + $(this).attr('name') + "][type!='hidden']", '#' + _this.parent_id), function (index, value) {
                            radio_values.push($(this).attr('value'));
                        });

                        $("input[name=" + $(this).attr('name') + "][value=" + localValue + "][type!='hidden']", '#' + _this.parent_id).prop('checked', true);

                        if (typeof $("input[name=" + $(this).attr('name') + "][value=" + localValue + "][type='hidden']", '#' + _this.parent_id) !== 'undefined') {
                            $("input[name=" + $(this).attr('name') + "][type='hidden']", '#' + _this.parent_id).val(localValue);
                        }

                        for (var j = 0; j < radio_values.length; ++j) {
                            if (radio_values[j] != localValue && radio_values[j] !== '') {
                                $("input[name=" + $(this).attr('name') + "][value=" + radio_values[j] + "][type!='hidden']", '#' + _this.parent_id).prop('checked', false);
                            }
                        }

                    } else {
                        $(this).val(localValue);
                    }

                }

                /* Add event handlers with data in storage saving */
                if ($(this).is("input") && $(this).attr('type') == 'checkbox') {

                    if ($(this).is(':checked')) {
                        _this.storage.setItem($(this).attr('id'), 'checked');
                    } else {
                        _this.storage.setItem($(this).attr('id'), '');
                    }

                    $(this).change(function () {
                        if ($(this).is(':checked')) {
                            _this.storage.setItem($(this).attr('id'), 'checked');
                        } else {
                            _this.storage.setItem($(this).attr('id'), '');
                        }
                    });

                } else if ($(this).is("input") && $(this).attr('type') == 'radio') {

                    if ($(this).is(':checked')) {
                        _this.storage.setItem($(this).attr('name'), $(this).val());
                    }

                    $(this).change(function () {
                        _this.storage.setItem($(this).attr('name'), $(this).val());
                    });

                } else {

                    if ($(this).val() != null && $(this).val() != '') {
                        _this.storage.setItem($(this).attr('id'), $(this).val());
                    }

                    $(this).blur(function () {
                        _this.storage.setItem($(this).attr('id'), $(this).val());
                    });

                }

            });

        },

        /**
         * Get storage value by given element
         *
         * @param element   Form element
         * @returns string
         */
        "get_storage_value": function(element) {

            var _this = this;

            var storage_id = '';

            if (element.is("input") && element.attr('type') == 'radio') {
                storage_id = element.attr('name');
            } else {
                storage_id = element.attr('id');
            }

            var localValue = _this.storage.getItem(storage_id);

            return localValue;

        }

    };

})();
