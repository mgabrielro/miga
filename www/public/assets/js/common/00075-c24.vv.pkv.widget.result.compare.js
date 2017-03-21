/**
 * @name Tariff comparison feature for result view
 * @namespace c24.vv.pkv.widget.result.sort
 *
 * @author Armin Beširović <armin.besirovic@check24.de>
 */
(function (window, document, $) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.result.compare");

    /**
     * Base of the compare link (i.e. the thing before the tariff IDs)
     * @type {string}
     */
    ns.compare_link_base = '/pkv/tarifvergleich';

    /**
     * jQuery Selector for Result container, has the rows tariffs.
     * Please note that this should contain only the result rows - not the sorter/filter menus/toolbars!
     * @type {string}
     */
    ns.result_container = '#result';

    /**
     * jQuery Selector 'result_tab'
     *
     * @type {string}
     */
    ns.result_tab ='#result_tab';

    /**
     * jQuery Selector 'filter_tab'
     *
     * @type {string}
     */
    ns.filter_tab ='#filter_tab';

    /**
     * jQuery Selector for the option user taps to enable/disable compare mode
     * @type {string}
     */
    ns.toggle = '#compare_tab';

    /**
     * jQuery Selector 'toggle_comparison_action'
     *
     * @type {string}
     */
    ns.toggle_comparison_action = '.toggle_comparison_action';

    /**
     * jQuery Selector for the visible checkboxes the user can tap on
     * @type {string}
     */
    ns.checkbox_selector = '.compare-checkbox';

    /**
     * jQuery Selector for result rows which contain the checkbox
     * @type {string}
     */
    ns.result_row_selector = '.c24-result-row > div';

    /**
     * jQuery Selector for the hint to the user how to select the tariffs to compare
     * @type {string}
     */
    ns.hint = '#compare-hint';

    /**
     * jQuery Selector for the sticky menu/toolbar the user can tap on to enter comparison/exit compare mode
     * @type {string}
     */
    ns.menu = '#compare-menu';

    /**
     * jQuery Selector for the button to exit compare mode
     * @type {string}
     */
    ns.menu_close = '#compare-menu-close';

    /**
     * jQuery Selector for the button to proceed to comparison page
     * @type {string}
     */
    ns.menu_link = '#compare-menu-label';

    /**
     * Selected tariff IDs (array of integers)
     * @type {Array}
     */
    ns.selected = [];

    /**
     * Stores the base URL originally printed out
     * @type {string}
     */
    ns.base_url = '/pkv/tarifvergleich';

    /**
     * Updates the compare button link after a tariff was selected
     */
    ns.update_compare_link = function() {
        var compare_link = ns.compare_link_base + '/' + ns.selected.join('/') + ns.build_additional_uri();
        $(ns.menu_link).attr('href', compare_link);
    };

    /**
     * Build promotion uri link.
     *
     * @returns {string}
     */
    ns.build_additional_uri = function() {

        var additional_uri_part = '',
            promotion_type,
            is_gold_grade;

        $.each(ns.selected, function(key, tariffversion_id) {

            var param_value;
            var $element = $('[data-tariff-version-id=' + tariffversion_id + ']');
            promotion_type = $element.data('promotiontype');

            if (promotion_type) {
                param_value = 'promotion_type_' + tariffversion_id + '=' + promotion_type;
                additional_uri_part += (additional_uri_part == '' ? '?' + param_value : '&' + param_value);
            }

            is_gold_grade = $element.data('is-gold-grade');
            param_value = 'is_gold_grade_' + tariffversion_id + '=' + is_gold_grade;
            additional_uri_part += (additional_uri_part == '' ? '?' + param_value : '&' + param_value);

        });

        return additional_uri_part;

    };

    /**
     * Check if we are currently in compare mode
     *
     * @returns {boolean}
     */
    ns.is_comparison_active = function() {
        return $(ns.toggle).parent().hasClass('ui-state-active');
    };

    /**
     * Show or hide the comparison mode with the associated logic/animations
     * @param {boolean} close When true, will exit comparison mode (if active)
     * @param {jQuery} $element The jQuery-element
     */
    ns.toggle_comparison = function(close, $element) {

        if (typeof $element != 'undefined') {

            var is_compare_btn      = $element.hasClass('compare-tariff-btn');
            var is_compare_close    = $element.hasClass('compare-close');
            var is_hidden           = $(ns.checkbox_selector).hasClass('hidden');

        }

        if (close && is_hidden) {
            return;
        }
        
        //exchange the tab and the active tab-element is "result_tab"
        if (is_compare_close) {

            ns.exchange_active_tab($('#result_tab'));
            $("#result-container").show();
            $(".c24-info-icon-tooltip").show();

        }

        //exchange the tab and the active tab-element is "compare_tab"
        if (is_compare_btn) {

            ns.exchange_active_tab($('#compare_tab'));
            $("#result-container").show();
            $("#filter-container").hide();
            $(".change-filter-info").removeClass('not_show');
            $('.c24-result-tariff-name-list').addClass('no-tooltip');
            $('.c24-info-icon-tooltip').addClass('no-tooltip');
        }

        if ($(ns.result_container).hasClass('compare-active')) {

            $(ns.hint).slideUp(100, function(){
                $(ns.result_container).removeClass('compare-active');
                $(ns.checkbox_selector).addClass('hidden');
                $('.c24-result-tariff-name-list').removeClass('no-tooltip');
                $('.c24-info-icon-tooltip').removeClass('no-tooltip');
            });
            ns.exchange_active_tab($('#result_tab'));

        } else {

            $(ns.hint).slideDown(100, function(){
                $(ns.result_container).addClass('compare-active');
                $(ns.checkbox_selector).removeClass('hidden');
            });

        }

        $(ns.menu).slideToggle(100);

        // Cleanup the URL state so we don't have #compare#compare#compare...
        if (window.location.href.indexOf('#compare') >= 0) {
            window.history.replaceState(null, null, window.location.href.replace(/#compare/g, ''));
        }

        if (is_hidden) {
            window.history.pushState({}, "", window.location.href + '#compare');
        } else {
            $(ns.checkbox_selector).removeClass('selected disabled error');
            ns.selected = [];
        }

        $('.c24-link').data('link-disable', is_hidden);

    };

    /**
     * Bind toggle events for relevant links
     * @returns {*}
     */
    ns.bind_toggle_event = function() {

        $(ns.toggle).click(function(){ ns.toggle_comparison(false, $(this)); });
        $(ns.toggle_comparison_action).on('click', function(){ ns.toggle_comparison(true, $(this)); });

        return ns;

    };

    /**
     * Returns a sibling element (checkbox from the same tariff).
     * This is used because the promo tariffs are shown twice in the results.
     * @param {jQuery} e
     * @returns {boolean}
     */
    ns.get_sibling_if_any = function(e) {
        
        var tariff_version_id = e.data('tariff-version-id');
        var result_row = e.parent()[0];
        var matches = e.parent().parent().children('[data-tariff-version-id="' + tariff_version_id + '"]');
        var sibling = false;

        matches.each(function(i, el){
            if (el != result_row) {
                sibling = $(el).children(ns.checkbox_selector);
                return;
            }
        });

        return sibling;

    };

    /**
     * Bind click events for the checkboxes
     * @returns {*}
     */
    ns.bind_click_event = function() {

        // Clicking on the result row should select a tariff (accounts for chubby fingers ;-).
        $(ns.result_row_selector).click(function(){
            var is_hidden = $(ns.checkbox_selector).hasClass('hidden');
            if (is_hidden) {
                return;
            }

            $(this).siblings(ns.checkbox_selector)[0].click();
        });

        // Clicking on the checkbox should select the tariff
        $(ns.checkbox_selector).click(function(e){

            e.preventDefault();
            var e = $(this);
            var tariff_version_id = e.data('tariff-version-id');
            var sibling = ns.get_sibling_if_any(e);

            if (e.hasClass('disabled')) {
                return;
            } else if (e.hasClass('selected')) {
                ns.selected.splice($.inArray(tariff_version_id, ns.selected), 1);
                $(ns.menu_link).removeClass('active').html('Bitte 2 Tarife auswählen');
                e.removeClass('selected');
                if (sibling) {
                    sibling.removeClass('selected');
                }

                if (ns.selected.length > 0) {
                    $(ns.checkbox_selector + '.disabled').removeClass('disabled');
                }
            } else {
                ns.selected.push(tariff_version_id);
                ns.update_compare_link();
                e.addClass('selected');
                if (sibling) {
                    sibling.addClass('selected');
                }

                if (ns.selected.length > 1) {
                    $(ns.checkbox_selector + ':not(.selected)').addClass('disabled');
                    ns.enable_menu_link();
                }

                $(ns.menu_link).attr('data-tariff-versions', ns.selected.join(','));
            }

        });

        // Clicking on the "Compare now" button redirects you to the appropriate location
        $(ns.menu_link).click(function(){

            if ($(this).hasClass('active') && $(this).attr('href')) {
                window.location = $(this).attr('href');
            }
            return false;

        });

        return ns;
    };

    /**
     * Enables the button to compare the tariffs when two have been selected
     */
    ns.enable_menu_link = function() {

        var calc_param_id = $('#result').data('calculationparameter_id');

        $(ns.menu_link).addClass('active')
            .attr('href', ns.base_url + '/' + calc_param_id + '/' + ns.selected.join('/') + ns.build_additional_uri())
            .html('Tarife jetzt vergleichen');

    };

    /**
     * Start up the comparison from local storage
     *
     * This is the case when somebody was on the detail comparison and clicked the [X] on one of the tariffs, the tariff
     * that should still be selected is saved in local storage.
     *
     * @returns {Object}
     */
    ns.init_from_storage = function(){

        var keep = window.localStorage.getItem('compare-keep-tariff');
        var el = $(ns.checkbox_selector + "[data-tariff-version-id=" + keep + "]");

        if (el[0]) {
            ns.toggle_comparison(false , $('#compare_tab'));
            $(el[0]).click();
        }

        window.localStorage.removeItem('compare-keep-tariff');

        return ns;

    };

    /**
     * Hooks to the browser back event to disable the comparison mode when somebody clicks the back button
     *
     * @returns {Object}
     */
    ns.bind_browser_back_event = function(){

        window.onhashchange = function() {
            if (! $(ns.checkbox_selector).hasClass('hidden')) {
                ns.toggle_comparison();
            }
        };

        return ns;

    };

    /* Exchange a new active tab
     * 
     * @param {jQuery} $element The jQuery-element
     */
    ns.exchange_active_tab =  function ($element) {

        var $navbar_link = $('#tabs .ui-navbar a');

        $navbar_link.parent().removeClass('ui-state-active').removeClass('ui-tabs-active');
        $navbar_link.removeClass('ui-btn-active');
        $element.parent().addClass('ui-state-active');
        $element.parent().addClass('ui-tabs-active');
        $element.addClass('ui-state-active');

    };

    /**
     * Inits the thing and binds required events
     *
     * @param options
     */
    ns.init = function(options) {

        for (i in options) {
            if (ns[i]) {
                ns[i] = options[i];
            }
        }

        ns.bind_toggle_event()
            .bind_click_event()
            .bind_browser_back_event()
            .init_from_storage();

    };

    ns.init();

})(window, document, jQuery);
