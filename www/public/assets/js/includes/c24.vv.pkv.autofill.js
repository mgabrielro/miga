/**
 * Autofill for forms
 *
 * Stores entered data in specific forms and fills them out if nothing is preselected.
 * A dropdown item is considered selected if any of the options have a "selected" attribute.
 * A radio or checkbox are considered selected if any of the items have a "checked" attribute.
 *
 * After updating the value with $.val() a $.change() (and $.click() for dropdowns/radios) will be called to run any
 * presentational business logic.
 *
 * Currently works only on #resultform.
 *
 * @author Armin Beširović <armin.besirovic@check24.de>
 * @namespace c24.vv.pkv
 */
(function ($, document, window, undefined) {

    "use strict";

    var ns = namespace('c24.vv.pkv');

    ns.autofill = {

        /**
         * Key for localStorage
         */
        storage_key: 'c24.vv.pkv.autofill',

        /**
         * IDs of fields to keep track of
         */
        fields: [
            "insure_input",
            "gender",
            "title",
            "firstname",
            "lastname",
            "phoneprefix",
            "phone",
            "email",
            "insure_gender",
            "insure_title",
            "insure_firstname",
            "insure_lastname"
        ],

        /**
         * Start the show
         */
        init: function () {
            this.update_form();
            this.bind_events();
        },

        /**
         * Bind events, duh.
         */
        bind_events: function() {
            
            var _this = this;
            
            this.fields.forEach(function(field){

                $("#" + field).on("blur", function(){
                    _this.update_stored_field_values();
                });

            });
            
        },

        /**
         * Update values stored in localStorage
         */
        update_stored_field_values: function() {
            var _this = this;
            this.fields.forEach(function(field){
                _this.save(field, $("#" + field).val());
            });
        },

        /**
         * Update form elements with stored values if elements have no other value
         */
        update_form: function() {

            var data = this.load();
            var $field = null;

            for (var f in data) {
                $field = $("#" + f);

                if (! $field.length || $field.val()) {
                    continue;
                }

                $field.val(data[f]);
                $field.change();

            }

            this.handle_field_exceptions(data);
        },

        /**
         * Some fields are not actual form fields but have <div> elements behaving as them
         *
         * Usually this is boring radio buttons being replaced with prettier alternatives.
         *
         * @param {Object} data Stored field values
         */
        handle_field_exceptions: function(data) {

            // VP != VN radio buttons
            if (data.insure_input) {
                $("[data-name=insure]").filter("[data-value=" + data.insure_input + "]").click();
            }

        },


        /**
         * Get the object with stored field values
         *
         * @returns {Object}
         */
        load: function() {

            var serialized = window.localStorage.getItem(this.storage_key);
            var data = {};

            try {
                data = JSON.parse(serialized)
            } catch (e) {
                window.localStorage.removeItem(this.storage_key);
                data = {};
            }

            return data ? data : {};

        },

        /**
         * Store field value to our localStorage key
         *
         * @param {String} key
         * @param {String} value
         */
        save: function(key, value) {

            if (! value) {
                return;
            }

            var data = this.load();
            data[key] = value;
            window.localStorage.setItem(this.storage_key, JSON.stringify(data));

        }

    };

    /**
     * Are. You. REEAAADYYY?
     */
    $(document).ready(function() {
        ns.autofill.init();
    });

})($, document, window, undefined);