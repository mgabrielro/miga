(function(namespace_to_construct){
    "use strict";

    (function(ns){
        $(document).ready(function(){
            ns.init();
        });

    })(namespace(namespace_to_construct, function(){}, {
        init: function(){
            $(document).on('click', '[data-tab]', function(){
                var $clicked_trigger = $(this);
                var active_content = '.tab_' + $(this).data('tab');
                var $tab_content    = $(this).parents('[data-tab-parent]').find(active_content);

                $('[data-tab]').not($clicked_trigger).parents('.column_tab').removeClass('active');
                $clicked_trigger.parent().toggleClass('active');

                $('.tab_content').not(active_content).hide();
                $tab_content.slideToggle();
            });

            $(document).on('click', '[data-tab-close]', function(){
                $('[data-tab]').parents('.column_tab').removeClass('active');
                $(this).parents('.tab_content').slideUp();
            });

            $(document).click(function(e){
                var $active_tab = $('.tab_content:visible');
                var clicked_outside_of_active_tab = !$active_tab.is(e.target) && $active_tab.has(e.target).length === 0;

                if($active_tab.is(':animated') || !clicked_outside_of_active_tab)
                    return;

                $('[data-tab]').parents('.column_tab').removeClass('active');
                $active_tab.slideUp();
            });
        }
    }));
})("c24.tabs");