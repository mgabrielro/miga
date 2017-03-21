/**
 * @name Sorting feature for result view
 * @namespace c24.vv.pkv.widget.result.sort
 *
 * @author Armin Beširović <armin.besirovic@check24.de>
 */
(function (window, document, $) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.result.sort");

    /**
     * Form element ID that stores the sort field passed via query (?c24api_sortfield=...)
     * @type {*|jQuery|HTMLElement}
     */
    ns.sort_field    = $("#c24api_sortfield");

    /**
     * Form element ID that stores the sort order (SQL ORDER BY direction) passed via query (?c24api_sortorder=...)
     * @type {*|jQuery|HTMLElement}
     */
    ns.sort_dir      = $("#c24api_sortorder");

    /**
     * jQuery/CSS selector for the sorting options container
     * @type {string}
     */
    ns.menu_selector        = "#sort-menu";

    /**
     * jQuery/CSS selector for the toggle link that toggles the options menu
     * @type {string}
     */
    ns.menu_selector_toggle_selector = "#sort-menu-toggle";

    /**
     * jQuery/CSS selector for the element where all the search result rows are found
     * @type {*|jQuery|HTMLElement}
     */
    ns.result_container = $("#result");

    /**
     * jQuery/CSS selector for a single search result element
     * @type {string}
     */
    ns.result_row_selector = "div.c24-result-row";

    /**
     * Flag indicating that we are sorting currently, used to prevent bubbling
     * @type {boolean}
     */
    ns.loading = false;

    /**
     * Mapping between c24api_sortfield values to labels, used during init to set the toggle label
     * @type {{provider: string, tariffgrade: string, price: string}}
     */
    ns.field_label_map = {
        "provider"    : "Anbieter",
        "tariffgrade" : "Beste Note zuerst",
        "price"       : "Niedrigster Preis zuerst",
        "promotion"   : "Empfehlung + Preis"
    };

    /**
     * Comparison method used by jQuery.sort() when sorting by different fields
     * @type {{provider: String, tariffgrade: *, price: *}}
     */
    ns.normalize_method_map = {
        "provider"    : String,
        "tariffgrade" : parseFloat,
        "price"       : parseInt,
        "promotion"   : parseInt
    };

    /**
     * Updates the toggle label to the value of the selected option
     * @returns {*}
     */
    ns.update_toggle_label = function() {
        $(ns.menu_selector_toggle_selector + "-label").html(ns.field_label_map[ns.sort_field.val()]);
        return ns;
    };

    /**
     * Updates the radio button icon for the currently selected option (i.e. currently sorted by option)
     * @returns {*}
     */
    ns.update_selected_option = function(){

        // highlight the currently active search
        $(ns.menu_selector + " .sort-menu-row").each(function(idx, el){
            if (el.dataset.sortField == ns.sort_field.val()
                && el.dataset.sortDir == ns.sort_dir.val()
            ) {
                $(el).children(".c24-switch-panel-icon").addClass('icon-active');
            }
        });

        return ns;

    };

    /**
     * Binds the click event for the sort menu toggle, i.e. adds an event handler that does the toggling
     * @returns {*}
     */
    ns.bind_toggle_event = function() {

        $(ns.menu_selector_toggle_selector).click(function(){

            // hide the potential opened result per email block
            $(c24.vv.pkv.widget.result.result_per_email.result_per_email_container).hide();
            $(c24.vv.pkv.widget.result.result_per_email.result_per_email_toggle + " .arrow").removeClass('up').addClass('down');

            $(ns.menu_selector_toggle_selector + " .arrow").toggleClass('down').toggleClass('up');
            $(ns.menu_selector).slideToggle();

        });

        return ns;

    };

    /**
     * Meat of the sorter. This method will perform the actual sorting and then close the menu when done.
     * @returns {*}
     */
    ns.bind_click_event = function(){

        $(ns.menu_selector + ' .sort-menu-row').click(function(){

            if (ns.loading) {
                return;
            }

            /**
             * Currently used field for sorting
             * @type {*|jQuery}
             */
            var field = $(this).data('sort-field');

            /**
             * Currently user direction/order for sorting
             * @type {*|jQuery}
             */
            var dir = $(this).data('sort-dir');

            $(this).children('.c24-switch-panel-icon').addClass('icon-spinner');

            ns.loading = true;

            var children = ns.result_container.children(ns.result_row_selector);

            // Price is always used as a second-level sort if it is not the actual selected field
            children.sort(function(a, b){

                /**
                 * Value normalization method, used to cast compared values to the same type
                 * @type {function(value)}
                 */
                var method = ns.normalize_method_map[field];

                /**
                 * Left comparison value
                 * @type {string|*}
                 */
                var lval = (new String(a.getAttribute("data-" + field))).toLowerCase();

                /**
                 * Right comparison value
                 * @type {string|*}
                 */
                var rval = (new String(b.getAttribute("data-" + field))).toLowerCase();

                /**
                 * We always do a second-level sorting by price ascending (i.e. ORDER BY field dir, price ASC)
                 * @type {function(value)}
                 */
                var priceMethod = ns.normalize_method_map["price"];

                /**
                 * Left comparison value
                 * @type {string|*}
                 */
                var priceLval = a.getAttribute("data-price");

                /**
                 * Right comparison value
                 * @type {string|*}
                 */
                var priceRval = b.getAttribute("data-price");

                /**
                 * Boolean indicating whether left value preceeds right value (A > B)
                 * @type {boolean}
                 */
                var result = false;

                if (lval == rval && field != "price") {
                    result = (
                        (priceMethod(priceLval) < priceMethod(priceRval)) ? -1 :
                            (priceMethod(priceLval) > priceMethod(priceRval)) ? 1 : 0
                    );
                } else {
                    result = (
                            (method(lval) > method(rval)) ? -1 :
                                (method(lval) < method(rval)) ? 1 : 0
                        ) * (dir == "asc" ? -1 : 1);
                }

                return result;

            });

            children.detach().prependTo(ns.result_container);

            ns.update_promoted(field);
            ns.sort_field.val(field);
            ns.sort_dir.val(dir);

            var position = 1;

            children.each(function(index) {

                if (!$(this).is(":visible")) {
                    return;
                }

                $(this).find('.c24-result-tariff-position').html(position + '.');
                position++;

            });

            // turn off the current active option
            $(ns.menu_selector).children(".sort-menu-row").children(".c24-switch-panel-icon").removeClass('icon-active');

            // replace the spinner with a pretty blue "active" class
            $(this).children('.c24-switch-panel-icon').removeClass('icon-spinner').addClass('icon-active');

            // update the toggle label with the new sort field label and close
            $(ns.menu_selector_toggle_selector + "-label").html($(this).children(".sort-menu-row-label").html());
            $(ns.menu_selector_toggle_selector).click();

            if (typeof c24.vv.shared.util.scroll_top === 'function') {
                c24.vv.shared.util.scroll_top();
            } else{
                window.scrollTo(0, 0);
            }

            ns.loading = false;

        });

        return ns;

    };

    /**
     * Relocated the promoted tariffs to the top and sorts them based on the data-promo attribute
     * The attribute itself is derived from promotion_position.
     *
     * When sorting by price, we show the promo results on top and they have twin rows below (which are not styled as
     * promo rows).
     *
     * When sorting by other fields, we show the promo results where they would normally be sorted and we hide their
     * unstyled twin rows.
     */
    ns.update_promoted = function(sort_field) {

        var promo = ns.result_container.children("[data-promo]");

        if (sort_field == 'promotion' || sort_field == undefined) {

           if ($('.favorite-page').length != 1) {

               // Promo tariffs go on top and are sorted via the API
               promo.detach().sort(function(a,b){
                   var lval = parseInt(a.getAttribute("data-promo"));
                   var rval = parseInt(b.getAttribute("data-promo"));
                   return (lval == rval) ? 0 : (lval < rval ? -1 : 1);
               }).prependTo(ns.result_container);

           }

            // Make sure all results are visible in this mode (including the twin results of the promoted)
            promo.each(function(i, e){

                var tariff_version = $(e).data('tariff-version-id');
                var tariff_promo = $(e).data('promo');
                var twin = $('div[data-tariff-version-id=' + tariff_version + '][data-promo=' + tariff_promo + ']'); //.not('[data-promo]');

                if (twin) {
                    // Show the promo results for promotion sort type
                    twin.show();
                }

            })

        } else {

            promo.each(function(i, e){

                var tariff_version = $(e).data('tariff-version-id');
                var tariff_promo = $(e).data('promo');
                var twin = $('div[data-tariff-version-id=' + tariff_version + '][data-promo=' + tariff_promo + ']');

                if (twin) {
                    // Hide the promo results when we mix promo with regular rows
                    twin.hide();
                }

            });

        }

    };

    /**
     * Inits the sorter and accepts an optional options object which maps to the properties defined in the class
     * @param options
     */
    ns.init = function(options) {

        for (i in options) {
            if (ns[i]) {
                ns[i] = options[i];
            }
        }

        ns.update_toggle_label()
            .update_selected_option()
            .bind_toggle_event()
            .bind_click_event()
            .update_promoted();

    };

    ns.init();

})(window, document, jQuery);
