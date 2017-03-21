(function(namespaceToConstruct){
    "use strict;";

    var layoutFixed = false;

    function elementBottom($element) {
        return $element.position().top + $element.outerHeight(true);
    }

    function switchToScrollLayout(){
        $('#special-action-ribbon-section').trigger('detach.ScrollToFixed');
        $('.result_compare_link').trigger('detach.ScrollToFixed');
        $('.result_sort_bar').trigger('detach.ScrollToFixed');
        $('.fixed-row').trigger('detach.ScrollToFixed');
        $('#result_sidebar').trigger('detach.ScrollToFixed');
    }

    function switchToFixedLayout () {

        var special_action_ribbon_container = $('#special-action-ribbon-section');
        var result_compare_link = $('.result_compare_link');
        var result_sort_bar = $('.result_sort_bar');
        var c24_dialog_bar_bg = $('#c24-dialog-bar-bg');
        var result_sidebar = $('#result_sidebar');

        special_action_ribbon_container.scrollToFixed({
            marginTop: 0,
            zIndex: 3000
        });

        /* compare link and filter sidebar */
        result_compare_link.scrollToFixed({
            marginTop: special_action_ribbon_container.outerHeight(),
            zIndex: 3000
        });

        /* sorting bar */
        result_sort_bar.scrollToFixed({
            marginTop: c24_dialog_bar_bg.outerHeight() + special_action_ribbon_container.outerHeight() + 47,
            zIndex: 3000
        });

        /* Promo row */
        $('.fixed-row').scrollToFixed({
            marginTop: c24_dialog_bar_bg.outerHeight() + special_action_ribbon_container.outerHeight() + result_compare_link.outerHeight() + result_sort_bar.outerHeight() - 11,
            zIndex: 3000
        });

        result_sidebar.scrollToFixed({
            marginTop: c24_dialog_bar_bg.outerHeight(),
            zIndex: 3001
        });

        result_sidebar.next().hide();

    };

    function init_layout_breakpoints(){

        var $widgetContactInfo = $('#result_contact');
        var $widgetBenefits = $("#result_benefits");
        var $sidebar = $('#result_sidebar');
        var $tooltipps = $('.iMod24Newtip');

        var footerHeight = $('#c24-page-container-footer').outerHeight(true);
        var headerHeight = $('#c24-header').outerHeight(true);

        $(window).on('scroll resize', function () {
            $tooltipps.hide();

            var scrollTop = $(window).scrollTop();
            if (scrollTop > headerHeight) {
                $widgetContactInfo.show();
                $widgetBenefits.hide();
            } else {
                $widgetContactInfo.hide();
                $widgetBenefits.show();
            }

            // Depending on which widget is display this changes
            var sidebarHeight = $sidebar.outerHeight(true);
            var fixedLayoutMinHeight = sidebarHeight + footerHeight;

            if (fixedLayoutMinHeight > $(window).height()) {
                if(layoutFixed) {
                    layoutFixed = false;
                    switchToScrollLayout();
                }
            } else {
                if (!layoutFixed) {
                    layoutFixed = true;
                    switchToFixedLayout();
                }
            }
        });
    }

    (function(ns){})(namespace(namespaceToConstruct, $.noop, {
        init: function(){
            init_layout_breakpoints();
        },
        reset: function() {
            if(layoutFixed) {
                switchToScrollLayout();
                switchToFixedLayout();
            }
        }
    }));
})("c24.check24.result.layout");
