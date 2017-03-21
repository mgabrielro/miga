/**
 * This file is used for jQuery hooks.
 */

/* Send method hook of jQuery-AJAX. */
$(document).ajaxSend(function (event, jqXHR, settings) {

    var username = settings.username || '';
    var password = settings.password || '';

    /* Check, if "username" has been set for AJAX-calls: */
    if (username) {

        /* Setting header-information to fix base authorization problems in ajax call */
        jqXHR.setRequestHeader("Authorization", "Basic " + btoa(username + ":" + password));

    }

});