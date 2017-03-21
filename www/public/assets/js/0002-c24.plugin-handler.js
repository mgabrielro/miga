(function(namespace_to_construct) {
    "use strict";

    (function(ns) {
        $(document).ready(function() {
            ns.init();
        });
    })(namespace(namespace_to_construct, $.noop, {

        init: function() {
            $('[data-fancybox], .fancybox').fancybox(
                {
                    'beforeShow': function() {
                        c24.check24.result.layout.reset();
                    },
                    'afterShow': function() {
                        $(".result_compare_link, .result_sort_bar, .c24-result-row.fixed-row").removeClass('fancybox-margin');
                    }
                }
            );
        }
    }));
})("c24.plugin-handler");