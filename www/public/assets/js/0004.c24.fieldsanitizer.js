(function(namespaceToConstruct){
    "use strict;";

    (function(ns){})(namespace(namespaceToConstruct, $.noop, {
        /**
         * This removes all non-whitelisted characters from the fields after typing
         *
         * @param $input
         * @param whitelist_regex
         */
        register: function($input, whitelist_regex){
            $input.on('keyup', function () {
                var original_value = $(this).val();
                var sanitized_value = original_value.replace(whitelist_regex, '');

                if(original_value != sanitized_value) {
                    $(this).val(sanitized_value);
                }
            });
        }
    }));
})("c24.fieldsanitizer");
