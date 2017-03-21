$(document).ready(function() {

    /**
     * C24Login Panel
     */

    var c24_register_errormsg = $('#c24-register-errormsg');
    var c24_customer_account_view = $('#c24_customer_account_view');
    var c24_customer_account_view_default = $('#c24-header-bar-account-default');
    var c24_customer_account_view_logged_in = $('#c24-customer-account-logged-in');
    var c24_customer_account_view_login = $('#c24-header-bar-account-login');
    var c24_customer_account_view_register = $('#c24-header-bar-account-register');
    var c24_customer_account_view_pwrecover = $('#c24-customer-account-pwrecover');
    var c24_customer_account_view_emailsent = $('#c24-customer-account-emailsent');

    // function to change/switch the different pannel views
    var change_customer_view = function (c24_customer_account_view) {

        c24_customer_account_view_default.hide();
        c24_customer_account_view_logged_in.hide();
        c24_customer_account_view_login.hide();
        c24_customer_account_view_register.hide();
        c24_customer_account_view_pwrecover.hide();
        c24_customer_account_view_emailsent.hide();

        switch (c24_customer_account_view) {

            case 'user_logged_in':
                c24_customer_account_view_logged_in.show();
                break;

            case 'login':
                c24_customer_account_view_login.show();
                break;

            case 'register':
                c24_customer_account_view_register.show();
                break;

            case 'recover':
                c24_customer_account_view_pwrecover.show();
                break;

            case 'recoverconfirm':
                c24_customer_account_view_emailsent.show();
                window.scrollTo(0, 0);
                break;

            default :
                $("#c24-blocking-layer").hide();
                c24_customer_account_view_default.show();

        }


    };

    // initial call
    change_customer_view(c24_customer_account_view.val());

    /**
     * Function to process error messages of each field returned by the api
     *
     * @param {Object} errors               Errors
     * @param {string} request_type         Request type
     * @param {boolean} rewrite_allowed     Rewrite allowed flag
     * @return {Void}
     */
    var processErrors = function (errors, request_type, rewrite_allowed) {

        if (typeof rewrite_allowed === 'undefined') {
            rewrite_allowed = true;
        }

        /* Rewrite - one message for invalid pair email/password */
        if (typeof errors.c24_customer_login_email != 'undefined'
            && typeof errors.c24_customer_login_password != 'undefined'
            && request_type == 'login_user' && rewrite_allowed) {
            var intern_errors = {
                'c24_customer_login_email': 'E-Mail-Adresse / Passwort überprüfen',
                'c24_customer_login_password': 'E-Mail-Adresse / Passwort überprüfen'
            };
            return processErrors(intern_errors);
        }

        /* Show messages */
        for (var item in errors) {

            var elem = $('#' + item);

            var error_text = errors[item].replace(/<([^>]+?)([^>]*?)>(.*?)<\/\1>/ig, '');

            if (elem.length > 0) {

                elem.addClass('c24-form-errorbox c24-form-error-color');
                elem.parent().parent().parent().addClass('c24-content-row-error');
                elem.parent().find(".c24-content-row-block-errorbox").html(error_text);

                elem.parent().find(".c24-content-row-block-errorbox").show();

            } else {
                console.log('Element "' + item + ' (' + error_text + ')" not found!');
            }

        }

    };


    // api call for user login
    $("#c24-customer-account-login-button").click(function () {

        $.ajax({

            type: 'post',
            dataType: 'json',
            data: $("#c24-form").serialize(),
            url: '/app/api/c24login/login_user/',
            suppressErrors: true,
            crossDomain: true,
            success: function (data) {
                window.location.reload();
            },
            error: function (xhr, status, error) {
                var errors = xhr.responseJSON.data;
                var rewrite_allowed = true;

                if ($('#c24_customer_login_email').val() == '' && $('#c24_customer_login_password').val() == '') {
                    rewrite_allowed = false;
                }
                processErrors(errors, 'login_user', rewrite_allowed);
            }

        });

    });


    // api call for user register
    $("#c24-customer-account-register-button").click(function () {

        $.ajax({

            type: 'post',
            dataType: 'json',
            data: {
                c24_account_register_email: $('#c24_account_register_email').val(),
                c24_account_register_password1: $('#c24_account_register_password1').val(),
                c24_account_register_password2: $('#c24_account_register_password2').val()
            },
            url: '/app/api/c24login/register_user/',
            suppressErrors: true,
            crossDomain: true,
            success: function (data) {
                window.location.href = window.location.href + '?user_registered=true';
            },
            error: function (xhr, status, error) {
                var errors = xhr.responseJSON.data;
                processErrors(errors, 'register_user');
            }

        });

    });

    $('#c24-header-bar-account-login .social-buttons').click(function(){

        var url = this.getAttribute('data-href');
        var viewportHeight;
        var viewportWidth;
        var popup = null;

        if (document.compatMode === 'BackCompat') {
            viewportHeight = document.body.clientHeight;
            viewportWidth = document.body.clientWidth;
        } else {
            viewportHeight = document.documentElement.clientHeight;
            viewportWidth = document.documentElement.clientWidth;
        }

        if(popup == null || popup.close) {
            popup = window.open(url, 'Anmelden', 'width=520, height=520, scrollbars=yes, status=no, titlebar=no, top=' + ( (window.screenY + (viewportHeight / 2)) - 280 ) + ', left=' + ( (window.screenX + (viewportWidth / 2)) - 260 ) );
        } else {
            popup.focus();
        }

    });

    if ($('#deviceoutput_app').val() == 'no') {

        $('#c24-customer-account-default-login-link').click(function () {
            change_customer_view('login');
        });

    }

    $('#c24-customer-account-login-register-link').click(function () {
        change_customer_view('register');
    });

    $('#c24-customer-account-login-pwrecover-link').click(function () {
        change_customer_view('recover');
    });

    $('#c24-customer-account-login-header-close').click(function () {
        change_customer_view('default');
    });

    $('#c24-customer-account-emailsent-close').click(function () {
        change_customer_view('default');
    });

    $('#c24-customer-account-pwrecover-close').click(function () {
        change_customer_view('default');
    });

    $('#c24-customer-account-register-header-close').click(function () {
        change_customer_view('default');
    });

    $('#c24-customer-account-register-login-link').click(function () {
        change_customer_view('login');
    });

    $('#c24-customer-account-pwrecover-login-link').click(function () {
        change_customer_view('login');
    });

    $('#c24-customer-account-emailsent-login-link').click(function () {
        change_customer_view('login');
    });

    // api call to logout the user
    $('#c24-customer-account-login-logout-link').click(function () {

        $.ajax({

            type: 'post',
            dataType: 'json',
            data: $("#c24-form").serialize(),
            url: '/app/api/c24login/logout_user/',
            suppressErrors: true,
            crossDomain: true,
            success: function (data) {
                // the previous api call fires only a sso logout
                // after it, forward to logout locally
                window.location.href = '/user/logout';
            },
            error: function (xhr, status, error) {

            }

        });

    });


    // api call to recover password
    $("#c24-customer-account-pwrecover-button").click(function () {

        $.ajax({
            url: '/app/api/c24login/recover_user/',
            type: 'post',
            dataType: 'json',
            data: {
                c24_account_pwrecover_email: $('#c24_account_pwrecover_email').val(),
                c24_account_pwrecover_ref: window.location.href
            },
            suppressErrors: true,
            crossDomain: true,
            success: function (data) {
                change_customer_view('recoverconfirm');
            },
            error: function (xhr, status, error) {
                var errors = xhr.responseJSON.data;
                processErrors(errors, 'recover_user');
            }

        });


    });


    $('#c24-account-pwrecover-birthdate').keyup(function () {

        $(this).removeClass('c24-form-errorbox c24-form-error-color');
        $(this).parent().parent().parent().removeClass('c24-content-row-error');
        $(this).parent().find(".c24-content-row-block-errorbox").hide();

    });


    // password strength
    var register_password = $("#c24_account_register_password1");
    var pwd_check = $("#pwd_check");

    if (register_password.val() != "") {

        pwd_check.show();
        pwd_check.addClass('c24-pwd-check');

    } else {
        pwd_check.hide();
    }

    register_password.keyup(function () {

        var email = $('#c24_account_register_email');

        if ($(this).val() != "") {
            pwd_check.show();
            pwd_check.addClass('c24-pwd-check');
            register_password.passwordStrength({
                indicatorText: $('#rs-pws-indicator-text'),
                indicatorBar: $('#rs-pws-indicator-bar'),
                email: email
            });
        } else {
            pwd_check.hide();
        }

        var pw_secure_length = false;
        var pw_secure_mix = false;
        var pw_secure_similar = true;

        // check the password length
        if ($(this).val().length < 15 && $(this).val().length > 6) {

            $('#c24-pw-length').removeClass('fa-close c24-icon-red');
            $('#c24-pw-length').addClass('fa-check c24-icon-green');
            pw_secure_length = true;

        } else {

            $('#c24-pw-length').removeClass('fa-check c24-icon-green');
            $('#c24-pw-length').addClass('fa-close c24-icon-red');
            pw_secure_length = false;

        }

        var regex_nochars = /[^a-zA-Z0-9]/; // regex for special chars
        var regex_chars = /[a-zA-Z]/; // regex for chars only
        var regex_digits = /[0-9]/; // regex for digits only

        if ($(this).val().match(regex_nochars)
            && $(this).val().match(regex_chars)
            && $(this).val().match(regex_digits)) {

            $('#c24-pw-mix').removeClass('fa-close c24-icon-red');
            $('#c24-pw-mix').addClass('fa-check c24-icon-green');
            pw_secure_mix = true;

        } else {

            $('#c24-pw-mix').removeClass('fa-check c24-icon-green');
            $('#c24-pw-mix').addClass('fa-close c24-icon-red');
            pw_secure_mix = false;

        }

        match = [];
        var regexsplit = /([0-9a-zA-Z]+)/g; // split the email at special chars for similarity check
        var match = email.val().toLowerCase().match(regexsplit);

        // check similarity of email and password
        if (match) {

            for (i = 0; i < match.length; i++) {
                if (match[i].toLowerCase().indexOf($(this).val().toLowerCase()) != -1)
                    pw_secure_similar = false;
            }

        }

        // switch the state of password helptext icons based on the previous password security checks
        if (pw_secure_similar) {

            $('#c24-pw-similar').removeClass('fa-close c24-icon-red');
            $('#c24-pw-similar').addClass('fa-check c24-icon-green');

        } else {

            $('#c24-pw-similar').removeClass('fa-check c24-icon-green');
            $('#c24-pw-similar').addClass('fa-close c24-icon-red');

        }

        if (pw_secure_similar && pw_secure_mix && pw_secure_length) {

            $('#c24-pw-not-easy').removeClass('fa-close c24-icon-red');
            $('#c24-pw-not-easy').addClass('fa-check c24-icon-green');

        } else {

            $('#c24-pw-not-easy').removeClass('fa-check c24-icon-green');
            $('#c24-pw-not-easy').addClass('fa-close c24-icon-red');
        }


    });

    c24.vv.shared.util.run_set_timeout(c24.vv.shared.util.check_login_of_prefill_and_fade_out);
    
});