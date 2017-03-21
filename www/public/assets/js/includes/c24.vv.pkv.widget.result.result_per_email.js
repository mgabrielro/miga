/**
 * @name Send result page link per email feature
 * @namespace c24.vv.pkv.widget.result.result_per_email
 *
 * @author Gabriel Mandu <gabriel.mandu@check24.de>
 */
(function (window, document, $) {

    "use strict";

    var ns = namespace("c24.vv.pkv.widget.result.result_per_email");

    /**
     * AJAX base url for sending the result link per email
     *
     * @type {string}
     */
    ns.ajax_base_url = '/ajax/json/send_results_per_email/';

    /**
     * jQuery selector for the calculationparameter id
     *
     * @type {string}
     */
    ns.calculationparameter_id = '#c24api_calculationparameter_id';

    /**
     * jQuery selector for the result per email toggle
     *
     * @type {string}
     */
    ns.result_per_email_toggle = "#result-per-email-toggle";

    /**
     * jQuery selector for the result per email container
     *
     * @type {string}
     */
    ns.result_per_email_container = "#result-per-email-container";

    /**
     * jQuery selector for the result per email form
     *
     * @type {string}
     */
    ns.result_per_email_form = "#result-per-email-form";

    /**
     * jQuery selector for the result per email label
     *
     * @type {string}
     */
    ns.result_per_email_label = '#result-per-email-label';

    /**
     * jQuery selector for the result per email input field
     *
     * @type {string}
     */
    ns.email_result_input = '#result-per-email-input';

    /**
     * jQuery selector for the result per email submit field
     *
     * @type {string}
     */
    ns.email_result_submit = '#result-per-email-submit';

    /**
     * jQuery selector for the result per email input field error message
     *
     * @type {string}
     */
    ns.result_per_email_input_error = '#result-per-email-input-error';

    /**
     * jQuery selector for the result per email submit field
     *
     * @type {string}
     */
    ns.send_complete_message = '#result-per-email-send-complete-message';

    /**
     * jQuery selector for the result per email send complete container
     *
     * @type {string}
     */
    ns.result_per_email_send_complete = '#result-per-email-send-complete';

    /**
     * Classes names
     *
     * @type {string}
     */
    ns.classes = {
        down  : "down",
        up    : "up",
        show  : "show",
        error : "error"
    };

    /**
     * Different messages to be used
     *
     * @param Object
     */
    ns.messages = {
        please_give_your_email_address: 'Bitte geben Sie Ihre E-Mail-Adresse an.',
        please_give_valid_email_address: 'Bitte geben Sie eine gültige E-Mail-Adresse an.'
    };

    /**
     * Binds the click event for the send result per email toggle
     *
     * @returns {Object}
     */
    ns.bind_toggle_event = function() {

        $(ns.result_per_email_toggle).click(function(){
            ns.hide_sort_feature();
            ns.toggle_container();
        });

        return ns;

    };

    /**
     * Hide error message on input field focus
     */
    ns.bind_focusin_email_input = function(){

        $(ns.email_result_input).focus(function() {
            ns.hide_mail_error();
        });

        return ns;

    };

    /**
     * When we open the feature send result page link per email,
     * we have to be sure that the sort feature is not shown, because
     * these features appear both in the same area
     *
     * @returns {Object}
     */
    ns.hide_sort_feature = function() {

        $(c24.vv.pkv.widget.result.sort.menu_selector).hide();
        $(c24.vv.pkv.widget.result.sort.menu_selector_toggle_selector + " .arrow").removeClass(ns.classes.up).addClass(ns.classes.down);

    };

    /**
     * Display or hide the result per email container
     */
    ns.toggle_container = function() {

        $(ns.result_per_email_toggle + " .arrow").toggleClass(ns.classes.down).toggleClass(ns.classes.up);
        $(ns.result_per_email_form).show();
        $(ns.result_per_email_send_complete).html('').hide();
        $(ns.result_per_email_container).slideToggle();

    };

    /**
     * Display or hide the input email attached label
     *
     * @returns {Object}
     */
    ns.toggle_email_input_label = function() {

        $(ns.email_result_input).keyup(function(){

            ns.hide_mail_error();

            var input_has_value = $(ns.email_result_input).val().trim();

            if(input_has_value) {
                $(ns.result_per_email_label).css('visibility', 'visible');
            } else {
                $(ns.result_per_email_label).css('visibility', 'hidden')
            }

        });

        return ns;

    };

    /**
     * Binds the click event for the send result per email toggle
     *
     * @returns {Object}
     */
    ns.bind_submit_event = function() {

        $(ns.email_result_submit).click(function(){

            var is_mail_empty = ns.is_mail_empty();
            var is_mail_vaild = ns.is_mail_valid();

            if(!is_mail_empty && is_mail_vaild) {
                ns.send_results_per_email();
            } else {

                if (is_mail_empty === true) {
                    ns.show_mail_error(ns.messages.please_give_your_email_address);
                } else {
                    ns.show_mail_error(ns.messages.please_give_valid_email_address);
                }

            }

        });

        return ns;

    };

    /**
     * Validates the e-mail address input field for empty
     *
     * @returns {boolean}  Is the email input value empty?
     */
    ns.is_mail_empty = function () {

        if (!$(ns.email_result_input).val().trim()) {
            $(ns.email_result_input).addClass(ns.classes.error);
            return true;
        }

        return false;

    };

    /**
     * Validates the email address against a simple Regex
     *
     * @returns {boolean}  Is the email input value valid?
     */
    ns.is_mail_valid = function () {

        var email_val = $(ns.email_result_input).val().trim();
        var regex     = new RegExp(/.+\@.+\..+/);

        return regex.test(email_val);

    };

    /**
     * Send the results link per email with an ajax request on mobile backend and then send an API request to desktop
     *
     * @see \Common\Controller\AjaxController::getSendResultsPerEmailAction()
     */
    ns.send_results_per_email = function() {

        var mail_to                        = $(ns.email_result_input).val().trim();
        var $calculationparameter_id_field = $(ns.calculationparameter_id);
        var calculationparameter_id        = '';

        if ($(ns.calculationparameter_id).length > 0) {
            calculationparameter_id = $(ns.calculationparameter_id).val().trim();
        }

        var url = ns.ajax_base_url + mail_to + '/' + calculationparameter_id;

        // Send the AJAX request to Mobile-Backend (see Ajax Controller)

        $.ajax({
            dataType: 'json',
            url: url,
            timeout: 1000,
            success: function (data) {

                if(data.content.success == true) {
                    ns.hide_mail_error();
                    ns.show_success_message();
                } else {
                    ns.show_mail_error(data.content.error_message);
                }

            }
        });

    };

    /**
     * Displays the error message
     *
     * @errorText {string} The error message to be displayed.
     */
    ns.show_mail_error = function (errorText) {

        $(ns.result_per_email_input_error).html(errorText);
        $(ns.result_per_email_input_error).css('visibility', 'visible');

    };

    /**
     * Hide the error message
     */
    ns.hide_mail_error = function () {
        $(ns.result_per_email_input_error).css('visibility', 'hidden');
    };

    /**
     * Show the success message
     */
    ns.show_success_message = function () {

        var email   = $(ns.email_result_input).val().trim();
        var message = '<div class="email_success">Das Ergebnis wurde an ' + email + '</a> verschickt.</div>';

        $(ns.result_per_email_send_complete).html(message).show();
        $(ns.result_per_email_container).delay(2500).fadeOut('slow');
        $(ns.result_per_email_toggle + " .arrow").removeClass(ns.classes.up).addClass(ns.classes.down);

        window.scrollTo(0, 0);

    };

    /**
     * Inits the send result per email feature
     */
    ns.init = function() {

        ns.bind_toggle_event()
            .toggle_email_input_label()
            .bind_submit_event()
            .bind_focusin_email_input();
    };

    ns.init();

})(window, document, jQuery);
