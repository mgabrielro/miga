/**
 * This file is used for jQuery hooks.
 *
 * Created by siegfried.diel on 02.06.2015.
 */

// Send method hook of jQuery-AJAX.
$(document).ajaxSend(function (event, jqXHR, settings) {

    var username = settings.username || 'public';
    var password = settings.password || '';

    // Check, if "username" has been set for AJAX-calls:
    if (username) {

        // Setting header-information to fix authentication problems in safari
        jqXHR.setRequestHeader("Authorization", "Basic " + btoa(username + ":" + password));

    }

});