/**
 * This is the main JS for the favorite page.
 *
 * Created by gabriel.mandu on 19.12.2016
 */
(function (window, document, $, undefined){

    "use strict";

    var ns = window.namespace("c24.vv.pkv");

    /**
     * Related DOM elements to the favorite tariff
     */
    var domElements = {

        //for wireframe
        $wireframeHeartCounter: null,
        $wireframeHeart: null,

        //for Favorite-Page
        $favoriteBackLink: null,
        $favoritePageCounter: null,
        $softDeleteWrapper: null,

        //for Favorite-Page AND Result-Page
        $targetRow: null

    };

    /**
     * @namespace c24.vv.pkv.favorite
     */
    ns.favorite = {

        /**
         * Different DOM elements classes
         */
        classes: {

            //wireframe
            wireframeCounter: '.c24m-mylists-count',
            wireframeHeart: '.c24m-mylists-icon',

            //for Favorite-Page
            favoritePage: '.favorite-page',
            off: 'off',
            trashIcon: '.trash-icon',
            favoriteGroupCountObject: '.favorite-group-count-object',
            softDeleteWrapperClass: '.favorite-softdelete-wrapper',
            activeFavorites: '.favorite-softdelete-wrapper.off',
            favoriteReactivateLink: '.favorite-reactivate-link',

            //for Result-Page, Tariff-Detail-Page and Result-Page
            myFavorite: '.my-favorite',
            isFavorite: '.is-favorite',
            favoriteTooltip: '.favorite-tooltip',
            genericTooltip: '.c24-content-row-block-infobox',
            genericTooltipClose: '.c24-info-close-row',

            //for Favorite-Page AND Result-Page
            rowClass: '.c24-result-row'

        },

        /**
         * Potential AJAX requests actions
         *
         * Important:
         *  - the methods add_favorite AND delete_favorite are named like this,
         *    in order to not interfere with the desktop project methods.
         *    After we unify both projects (desktop and mobile), we can cleanup the API
         */
        actions: {
            add: 'add_favorite',
            delete: 'delete_favorite',
            activate: 'activate',
            deactivate: 'deactivate',
            count: 'count'
        },

        /**
         * AJAX method type
         */
        ajaxMethod: 'GET',

        /**
         * AJAX base url fro requests
         */
        ajaxBaseUrl: '/ajax/json/',

        /**
         * Complete AJAX url for request
         */
        ajaxUrl: null,

        /**
         * AJAX request action
         */
        ajaxAction: null,

        /**
         * AJAX request data
         */
        ajaxData: {},

        /**
         * It holds the input1 url
         */
        input1_url: '/pkv/benutzereingaben/',

        /**
         * Holds the clicked heart DOM element
         */
        clickedHeart: {},

        /**
         * Row tariffversion id
         */
        targetTariffVersionId: 0,

        /**
         * Row favorite id
         */
        targetFavoriteId: 0,

        /**
         * Total favorites counter (for all groups)
         * which is shown on the Favorite page headline
         */
        favoritePageTotalCounter: 0,

        /**
         * Favorites group of tariffs identifier,
         * used on the Favorite page
         */
        favoritePageGroupIdentifier: '',

        /**
         * Favorites group of tariffs counter
         * which is shown on the Favorite page
         */
        favoritePageGroupCounter: 0,

        /**
         * It informs us about the total (unfiltered) number of favorite tariffs
         */
        wireframeCounter: 0,

        /**
         * It holds the session Storage name for the favorite backlink url
         */
        favoriteBacklinkUrlStorageName: 'favoriteBackLinkUrl',

        /**
         * Favorites main counter available on every page,
         * BUT NOT ON Favorite Page - where we use the speicifc counter - favoritePageTotalCounter
         *
         * This counter helps us:
         *      - inform the user about the number of total favorites filtered by calculationparameter_id
         *      - limit the number of total favorites / calculationparameter_id to 9 (see maxAllowedFavorites variable value)
         */
        mainCounter: 0,

        /**
         * The number of max allowed tariffs to be added as favorite
         */
        maxAllowedFavorites: 9,

        /**
         * Text to be displayed if the user wnats to add more than
         * 'maxAllowedFavorites' tariffs as favorite
         */
        maxAllowedFavoritesMsg: 'Sie können max. 9 Tarife merken. Bitte entfernen Sie erst einen der gemerkten Tarife, bevor Sie einen weiteren Tarif merken.',

        /**
         * It holds the potential calculationparameter id
         * needed in case of get_count AJAX request
         */
        calculationparameterId: '',

        /**
         * It holds the potential active tooltip DOM element
         */
        curentTooltip: {},

        /**
         * jQuery sliding speed in ms
         */
        slideSpeed: 600,

        /**
         * Init function of compare Page
         */
        init: function(){

            // Ensure that the DOM is ready

            $(function(){

                var self = ns.favorite;

                domElements.$wireframeHeart        = $(self.classes.wireframeHeart);
                domElements.$wireframeHeartCounter = $(self.classes.wireframeCounter);

                privateMethods.getFavoritesCount();

                if(privateMethods.isFavoritePage()) {

                    domElements.$favoritePageCounter = $("#favorite-total-counter");
                    domElements.$favoriteBackLink    = $("#favorite-backlink");

                    //disable the click on wireframe heart, in order to not replace the link on 'zurück' button on favorite page
                    domElements.$wireframeHeart.click(function(e) {
                        e.preventDefault();
                    });

                    privateMethods.initFavoritePageHeadlineCounter();
                    privateMethods.updateFavoritePageBacklinkHref();

                    domElements.$favoriteBackLink.on("click", eventHandlers.handleBackLink);

                    $(document).on("touchend click", ns.favorite.classes.rowClass, eventHandlers.handleClickedResultRow);
                    $(document).on("touchend click", ns.favorite.classes.trashIcon, eventHandlers.deactivateFavorite);
                    $(document).on("touchend click", ns.favorite.classes.favoriteReactivateLink, eventHandlers.activateFavorite);


                } else {

                    /**
                     * Save the actual url in session storage in order to update
                     * later the backlink href sttribute on favorite page
                     */
                    sessionStorage.setItem(self.favoriteBacklinkUrlStorageName, window.location.href);

                    privateMethods.setSessionStorageFavoriteBacklinkUrl();
                    $(document).on("touchend click", ns.favorite.classes.myFavorite, eventHandlers.handleHeartClick);

                }

            });

        },

        /**
         * Remove all favorites tooltips from DOM
         */
        removeAllFavoritesTooltips: function() {
            $(ns.favorite.classes.favoriteTooltip).remove();
        }

    }; // END public functions


    /**
     * Private methods
     */
    var privateMethods = {

        /****************************
         *                          *
         *  Favorite Page functions *
         *                          *
         ****************************/

        /**
         * It tells us if we are on favorite page or not
         *
         * @return boolean
         */
        isFavoritePage: function() {
            return $(ns.favorite.classes.favoritePage).length == 1;
        },

        /**
         * Sets the actual url in session storage, in order to have it available
         * on favorite page for the backlink href attribute
         */
        setSessionStorageFavoriteBacklinkUrl: function() {
            sessionStorage.setItem(ns.favorite.favoriteBacklinkUrlStorageName, window.location.href);
        },

        /**
         * Update the backlink url on favorite page with the previous saved value in session storage
         * and reset the session storage value to Input!
         */
        updateFavoritePageBacklinkHref: function() {

            var sessionStorageLink = sessionStorage.getItem(ns.favorite.favoriteBacklinkUrlStorageName);

            if (!sessionStorageLink) {
                sessionStorage.setItem(ns.favorite.favoriteBacklinkUrlStorageName, ns.favorite.input1_url);
                sessionStorageLink = sessionStorage.getItem(ns.favorite.favoriteBacklinkUrlStorageName);
            }


            //If in the saved url from session storage, is not already defined the deviceoutput
            if ( ! sessionStorageLink.includes('deviceoutput') ) {

                var actualUrl = window.location.href;

                // If in the actual url, is not already defined the deviceoutput
                if ( actualUrl.includes('deviceoutput') ) {

                    var $actualDeviceoutputValue = get_url_param('deviceoutput');
                    var desired_text             = 'deviceoutput=' + $actualDeviceoutputValue;
                    var newSessionStorageLink    = '';

                    // we add the deviceoutput in order to solve the double header problem later
                    if (sessionStorageLink.includes('/?')) {

                        if(sessionStorageLink.includes('&')) {
                            newSessionStorageLink = sessionStorageLink + '&' + desired_text;
                        } else {
                            newSessionStorageLink = sessionStorageLink + desired_text;
                        }

                    } else {
                        newSessionStorageLink = sessionStorageLink + '/?' + desired_text;
                    }

                    //update the session storage link
                    sessionStorage.setItem(ns.favorite.favoriteBacklinkUrlStorageName, newSessionStorageLink);

                }

            }

            if (domElements.$favoriteBackLink.length) {
                domElements.$favoriteBackLink.attr('href', sessionStorage.getItem(ns.favorite.favoriteBacklinkUrlStorageName));
            }
        },

        /**
         * When the Favorite page is loaded, init the total counter
         */
        initFavoritePageHeadlineCounter: function() {
            ns.favorite.favoritePageTotalCounter = parseInt(domElements.$favoritePageCounter.html());
        },

        /**
         * When the user decides to activate/deactivate a favorite tariff,
         * we need to update the total counter. The total counter is always
         * actualized when the user activates or deactivates a favorite tariff
         */
        updateFavoritePageTotalCounter: function() {
            domElements.$favoritePageCounter.html(ns.favorite.favoritePageTotalCounter);
        },

        /**
         * Updates the favorite group count text every time,
         * when the user activate/deactivate a favorite tariff
         */
        updateFavoritePageGroupCountText: function() {

            var $groupRecordsDiv      = $("div").find("[data-group-name='" + ns.favorite.favoritePageGroupIdentifier + "']");
            var $groupRecordsCountObj = $groupRecordsDiv.find(ns.favorite.classes.favoriteGroupCountObject);
            var activeRecords         = $groupRecordsDiv.find(ns.favorite.classes.activeFavorites).length;

            if(activeRecords == 1) {
                var countText = '1 gemerkter Tarif';
            } else {
                var countText = activeRecords + ' gemerkte Tarife';
            }

            $groupRecordsCountObj.html(countText);

        },

        /**
         * Set the actual favorite tariff row
         *
         * @param {jQuery} $row     Actual favorite tariff row
         */
        setFavoritePageTargetRow: function($row) {
            domElements.$targetRow = $row;
        },

        /**
         * Set the related soft delete wrapper DOM element
         * of the actual favorite tariff row
         *
         * @param {jQuery} $wrapper     Related soft delete wrapper
         */
        setSoftDeleteWrapper: function($wrapper) {
            domElements.$softDeleteWrapper = $wrapper;
        },

        /**
         * Get the tariff favorite id of the related result row
         *
         * @return integer
         */
        setGroupIdentifier: function(groupIdentifier) {
            ns.favorite.favoritePageGroupIdentifier = groupIdentifier;
        },

        /**
         * Dectivate the click event for the tariff row
         */
        deactivateFavoritePageTargetRowClickEvent: function() {
            domElements.$targetRow.off('click');
        },

        /**
         * Hide the tariff row
         */
        slideToggleTargetRow: function() {
            domElements.$targetRow.slideToggle(ns.favorite.slideSpeed);
        },

        /**
         * Display the soft delete wrapper
         */
        slideToggleSoftDeleteWrapper: function() {

            domElements.$softDeleteWrapper.slideToggle(ns.favorite.slideSpeed);

            if(domElements.$softDeleteWrapper.hasClass(ns.favorite.classes.off)) {
                domElements.$softDeleteWrapper.removeClass(ns.favorite.classes.off);
            } else {
                domElements.$softDeleteWrapper.addClass(ns.favorite.classes.off);
            }

        },

        /**
         * Get the tariffversion id of the related result row
         *
         * @return integer
         */
        getTargetTariffVersionId: function() {

            // this if covers the favorite page usability case
            if(domElements.$targetRow) {
                ns.favorite.targetTariffVersionId = domElements.$targetRow.data('tariff-version-id');
            }

            return ns.favorite.targetTariffVersionId;

        },

        /**
         * Get the tariff favorite id of the related result row
         *
         * @return integer
         */
        getTargetFavoriteId: function() {

            if(domElements.$targetRow) {
                ns.favorite.targetFavoriteId = domElements.$targetRow.data('favorite-id');
            }

            return ns.favorite.targetFavoriteId;

        },

        /************************************
         *                                  *
         *  Other pages favorite functions  *
         *                                  *
         ************************************/

        /**
         * Update the wireframe heart counter in header, on every page,
         * and after every action (add, delete ...)
         */
        updateWireframeHeartCounter: function() {
            domElements.$wireframeHeartCounter.html(ns.favorite.wireframeCounter);
        },

        /**
         * Method called on load of every neede page, in order to be able
         * to update:
         *  - the wireframe counter (seee AJAX response.counter)
         *  - the main counter (the total number of favorites filtered by actual/last calculationparameter_id - see AJAX response.filtered_counter)
         */
        getFavoritesCount: function() {

            ns.favorite.ajaxAction = ns.favorite.actions.count;
            privateMethods.doRequest();

        },

        /**
         * Get the calculationparameter id from the first
         * potential tariff on the page
         *
         * @returns {string}
         */
        getCalculationParameterId: function() {
            
            // find the first potential tariff on page
            var $firstFavorite = $(ns.favorite.classes.myFavorite).first();

            if($firstFavorite) {
                ns.favorite.calculationparameterId = $firstFavorite.data('favorite-calculation-parameter-id');
            }

            return typeof ns.favorite.calculationparameterId !== 'undefined' ? ns.favorite.calculationparameterId : 'false';

        },

        /**
         * Create a tooltip DOM element, prefilled with a specific message
         *
         * @param {string} message    The tooltip message
         * @returns {object}          The tooltip DOM element
         */
        createTooltipElement: function(message) {

            var genericTooltipClass  = ns.favorite.classes.genericTooltip.replace('.', '');
            var favoriteTooltipClass = ns.favorite.classes.favoriteTooltip.replace('.', '');

            var $tooltipElement = $('<div class="' + genericTooltipClass + ' ' + favoriteTooltipClass + '">' +
                '<div class="c24-content-row-info-text">' +
                    '<div class="c24-content-row-info-text-content">' +
                        '<div class="favorite-info"></div> ' +
                        message +
                    '</div>' +
                    '<div class="c24-info-close-row">' +
                        '<i class="fa fa-angle-up"></i>' +
                    '</div>' +
                '</div>' +
                '</div>');

            return $tooltipElement;

        },

        /**********************
         *                    *
         *   AJAX functions   *
         *                    *
         **********************/

        /**
         * Sets the AJAX method type for requests
         *
         * @param {string} method_type     AJAX request method
         */
        setAjaxMethodType: function(method_type) {
            ns.favorite.ajaxMethod = method_type;
        },

        /**
         * Sets the AJAX data
         *
         * @param {object} data    Needed AJAX data
         */
        setAjaxData: function(data) {
            ns.favorite.ajaxData = data;
        },

        /**
         * Sets the AJAX action for requests
         *
         * @param {string} action     AJAX request action
         */
        setAjaxAction: function(action) {
            ns.favorite.ajaxAction = action;
        },

        /**
         * Set the AJAX url for requests by action
         *
         * @return {null|string}   AJAX request url
         */
        setAjaxUrlByAction: function() {

            var self = ns.favorite;

            if(!self.ajaxAction) {

                self.ajaxUrl = null;
                return ns.favorite.ajaxUrl;

            }

            switch (self.ajaxAction) {

                case self.actions.activate:
                case self.actions.deactivate:
                    self.ajaxUrl = self.ajaxBaseUrl + 'handle_favorite/' + self.ajaxAction + '/' +  privateMethods.getTargetFavoriteId();
                    break;

                case self.actions.delete:
                    self.ajaxUrl = self.ajaxBaseUrl + 'handle_favorite/' + self.ajaxAction + '/' + privateMethods.getTargetTariffVersionId();
                    break;

                case self.actions.add:
                    self.ajaxUrl = self.ajaxBaseUrl + 'handle_favorite/' + self.ajaxAction;
                    break;

                case self.actions.count:
                    self.ajaxUrl = self.ajaxBaseUrl + 'count_favorite/' + privateMethods.getCalculationParameterId();
                    break;

            }

            return self.ajaxUrl;

        },

        /**
         * On ajax request before send
         */
        onAjaxBeforeSend: function() {

            if (ns.favorite.ajaxAction == ns.favorite.actions.deactivate) {
                privateMethods.deactivateFavoritePageTargetRowClickEvent();
            }

        },

        /**
         * Method call on success response from AJAX request
         *
         * @param {object} response     AJAX response data
         *
         */
        onAjaxSuccessResponse: function(response) {

            // Favorite page related actions

            if (ns.favorite.ajaxAction == ns.favorite.actions.activate) {

                privateMethods.slideToggleSoftDeleteWrapper();
                privateMethods.slideToggleTargetRow();

                ns.favorite.favoritePageTotalCounter += 1;
                ns.favorite.favoritePageGroupCounter += 1;

            } else if(ns.favorite.ajaxAction == ns.favorite.actions.deactivate) {

                privateMethods.slideToggleTargetRow();
                privateMethods.slideToggleSoftDeleteWrapper();

                ns.favorite.favoritePageTotalCounter -= 1;
                ns.favorite.favoritePageGroupCounter -= 1;

            } else if(ns.favorite.ajaxAction == ns.favorite.actions.add) {

                ns.favorite.wireframeCounter += 1;
                ns.favorite.mainCounter += 1;

            } else if(ns.favorite.ajaxAction == ns.favorite.actions.delete) {

                if (ns.favorite.wireframeCounter > 0) {
                    ns.favorite.wireframeCounter -= 1;
                }

                if (ns.favorite.mainCounter > 0) {
                    ns.favorite.mainCounter -= 1;
                }

            } else if(ns.favorite.ajaxAction == ns.favorite.actions.count) {

                if(response.counter) {
                    ns.favorite.wireframeCounter = parseInt(response.counter);
                }

                ns.favorite.wireframeCounter = (response.counter) ? parseInt(response.counter) : 0;
                ns.favorite.mainCounter      = (response.counter) ? parseInt(response.filtered_counter) : 0;

            }

            if(privateMethods.isFavoritePage()) {

                privateMethods.updateFavoritePageTotalCounter();
                privateMethods.updateFavoritePageGroupCountText();

            }

            privateMethods.updateWireframeHeartCounter();

        },

        /**
         * Method call on error response from AJAX request
         *
         * @param {object} response     AJAX response data
         *
         */
        onAjaxErrorResponse: function(response) {
        },

        /**
         * Method call on complete AJAX request
         */
        onAjaxComplete: function() {
            privateMethods.resetAjaxDetails();
        },

        /**
         * Reset all AJAX details
         */
        resetAjaxDetails: function() {

            privateMethods.setAjaxMethodType('GET');
            privateMethods.setAjaxData({});
            privateMethods.setAjaxAction('');

        },

        /**
         * Make an AJAX request
         */
        doRequest: function() {

            privateMethods.setAjaxUrlByAction();

            if (ns.favorite.ajaxUrl) {

                // Send the AJAX request to Mobile-Backend (see Ajax Controller)

                $.ajax({
                    method: ns.favorite.ajaxMethod,
                    dataType: 'json',
                    url: ns.favorite.ajaxUrl,
                    data: ns.favorite.ajaxData,
                    cache: false,
                    timeout: 1000,
                    beforeSend: function( xhr ) {
                        privateMethods.onAjaxBeforeSend();
                    },
                    success: function (data) {

                        if(data.content.success == true) {
                            privateMethods.onAjaxSuccessResponse(data.content);
                        } else {
                            privateMethods.onAjaxErrorResponse(data.content);
                        }

                    },
                    complete: function () {
                        privateMethods.onAjaxComplete();
                    }
                });

            }

        }


    }; // END privateMethods

    /**
     * Event handlers (private)
     */
    var eventHandlers = {

        /**
         * Handle the favorite backlink click
         * If the user comes from a mobile page, we redirect him back,
         * else we redirect him on Input1
         *
         * @param event   Click event
         */
        handleBackLink: function(event) {

            event.preventDefault();
            window.location.href = $(this).attr('href');

        },

        /**
         * Handle the heart symbol click (add/delete favorite)
         *
         * Occurrence:
         *      - Result page
         *      - Detail page
         *      - Register page
         *
         * @param event   Click event
         */
        handleHeartClick: function(event) {

            // Do nothing when in compare mode - clicking anywhere on the row marks it for comparison
            var cmpns = namespace("c24.vv.pkv.widget.result.compare");

            if (cmpns.is_comparison_active && cmpns.is_comparison_active()) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();

            // cleanup
            privateMethods.resetAjaxDetails();

            if (event.handled !== true) {

                var self = ns.favorite;

                self.removeAllFavoritesTooltips();

                self.clickedHeart = $(this);

                var is_favorite  = self.classes.isFavorite.replace('.', '');

                //is the tariff already a favorite one?

                if (self.clickedHeart.hasClass(is_favorite)) {

                    self.clickedHeart.removeClass(is_favorite);

                    self.targetTariffVersionId = parseInt(self.clickedHeart.data('favorite-tariffversion-id'));

                    privateMethods.setAjaxAction(ns.favorite.actions.delete);
                    privateMethods.doRequest();

                } else {

                    //if the user has already added 'maxAllowedFavorites' number of tariffs as favorites
                    if(ns.favorite.mainCounter >= self.maxAllowedFavorites) {

                        //create a new tooltip element
                        self.curentTooltip = privateMethods.createTooltipElement(self.maxAllowedFavoritesMsg);

                        //append it to the DOM
                        self.clickedHeart.append(self.curentTooltip);

                        //hide all potential opened GENERIC tooltips before we open the favorite tooltip
                        $(self.classes.genericTooltip).hide();

                        self.curentTooltip.show();

                        eventHandlers.handleFavoriteTooltipClick();

                    } else {

                        self.clickedHeart.addClass(is_favorite);

                        var data = {
                            favorite_action             : self.actions.add,
                            tariffversion_id            : parseInt(self.clickedHeart.data('favorite-tariffversion-id')),
                            tariffversion_variation_key : self.clickedHeart.data('favorite-tariffversion-variaton-key'),
                            is_promo_tariff             : self.clickedHeart.data('favorite-is-promo-tariff'),
                            promotion_type              : self.clickedHeart.data('favorite-promotion-type'),
                            is_gold_grade_tariff        : self.clickedHeart.data('favorite-is-gold-grade'),
                            tariff_contribution_rate    : self.clickedHeart.data('favorite-contribution'),
                            calculationparameter_id     : self.clickedHeart.data('favorite-calculation-parameter-id')
                        };

                        privateMethods.setAjaxData(data);
                        privateMethods.setAjaxMethodType('POST');
                        privateMethods.setAjaxAction(ns.favorite.actions.add);
                        privateMethods.doRequest();

                    }

                }

                event.handled = true;

            } else {
                return false;
            }

        },

        /**
         * Handle the click on an opened favorite tooltip
         *
         */
        handleFavoriteTooltipClick: function() {

            var closeTooltipButton = ns.favorite.curentTooltip.find(ns.favorite.classes.genericTooltipClose);

            closeTooltipButton.on('click touchstart', function(e){

                e.preventDefault();
                $(this).closest(ns.favorite.classes.genericTooltip).remove();

            });

        },

        /**
         * On click of a result row we must save the clicked tariff name in Local Storage
         * because it might be needed later, on details page, when the user clicks the link
         * to compare this tariff with another one on rsult page
         */
        handleClickedResultRow: function(event) {
            $.rs.mobilesite.set_clicked_tariff_name($(this));
        },

        /**
         * RE-activate the previously soft-deleted favorite tariff
         *
         * Occurrence: Favorite page
         *
         * @param {Object} event   Click event
         */
        activateFavorite: function(event) {

            event.preventDefault();

            privateMethods.resetAjaxDetails();

            var $softDeleteWrapper = $(this).parents(ns.favorite.classes.softDeleteWrapperClass);
            privateMethods.setSoftDeleteWrapper($softDeleteWrapper);

            var $targetRow = $softDeleteWrapper.next(ns.favorite.classes.rowClass);
            privateMethods.setFavoritePageTargetRow($targetRow);

            privateMethods.setGroupIdentifier($softDeleteWrapper.data('group-identifier'));
            privateMethods.setAjaxAction(ns.favorite.actions.activate);

            privateMethods.doRequest();

        },

        /**
         * Soft delete a favorite tariff
         *
         * Occurrence: Favorite page
         *
         * @param {Object} event   Click event
         */
        deactivateFavorite: function(event) {

            event.preventDefault();
            event.stopPropagation();

            privateMethods.resetAjaxDetails();

            var $targetRow = $(this).parents(ns.favorite.classes.rowClass);
            privateMethods.setFavoritePageTargetRow($targetRow);

            var $softDeleteWrapper = $targetRow.prev(ns.favorite.classes.softDeleteWrapperClass);
            privateMethods.setSoftDeleteWrapper($softDeleteWrapper);

            privateMethods.setGroupIdentifier($softDeleteWrapper.data('group-identifier'));
            privateMethods.setAjaxAction(ns.favorite.actions.deactivate);

            privateMethods.doRequest();

        }

    }; // END eventHandlers

    ns.favorite.init();

})(window, window.document, window.jQuery, undefined);
