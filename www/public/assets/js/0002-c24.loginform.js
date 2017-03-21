(function(){
    "use strict";

    var ns = namespace("c24.check24.login.pv.pkv");

    var SIGNIN_VALIDATIONS = {
        loginpassword: {
            presence: "Sie müssen ein Passwort angeben."
        },
        password: {
            presence: "Das Passwort muss eine Länge von 6-15 Zeichen haben",
            confirmation: "Die beiden Passwörter stimmen nicht überein."
        },
        repassword: {
            confirmation: "Die beiden Passwörter stimmen nicht überein."
        },
        loginemail: {
            presence: "Sie müssen eine E-Mail-Adresse angeben.",
            email: "Ungültige E-Mail-Adresse"
        }
    };



    ns.load = function(ajax_url, unit_test) {

        var _this = this;

        /* /app/api/c24login */
        _this.url = ajax_url;
        _this.unit_test = unit_test;
        _this.c24session;
        _this.c24login_user_id;
        _this.animation_length = 400;

        _this.active_form = '';
        _this.isOpen = false;
        _this.input_error = new c24.check24.input.error.load();

        ns.load.instances.push(_this);
        _this.instanceNum = ns.load.instances.length - 1;

        _this.init();

    }

    ns.load.instances = [];


    ns.load.prototype = {

        "init": function(){

            var _this = this;

            $('#c24-login-form-register').click($.proxy(_this.form_register, _this));
            $('#c24-login-form-forgotpw-link').click($.proxy(_this.form_recover_password, _this));

            $('#c24-login-form-head .c24-user-form-head-text .c24-user-form-head-text-row1').click($.proxy(_this.form_login, _this));
            $('#c24-login-form-head-action-login').click($.proxy(_this.form_login, _this));
            $('#c24-forgotpw-form-backtologin').click($.proxy(_this.form_login, _this));
            $('#c24-user-register-form-login').click($.proxy(_this.form_login, _this));
            $('#c24-emailsend-form-backtologin').click($.proxy(_this.form_login, _this));


            $('#c24-login-form-head-action-link').click($.proxy(_this.form_reset, _this));
            $('#c24-forgotpw-form-head-action-link').on("click",$.proxy(_this.form_reset, _this));
            $('#c24-user-register-form-head-action-link').on("click",$.proxy(_this.form_reset, _this));
            $('#c24-emailsend-form-head-action-link').on("click",$.proxy(_this.form_reset, _this));

            $('#c24-login-form-link').click($.proxy(_this.action_login, _this));
            $('#c24-forgotpw-form-link').click($.proxy(_this.action_recover_password, _this));
            $('#c24-user-register-form-link').click($.proxy(_this.action_register, _this));
            $('#c24-login-form-head-action-logout').click($.proxy(_this.action_logout, _this));


            _this.initialize_plugins();
            _this.form_reset();

            Number.prototype.isClientError = function(){
                return Math.floor((this/100)) === 4;
            };

            Number.prototype.isServerError = function(){
                return Math.floor((this/100)) === 5;
            };
        },


        "initialize_plugins": function(){

            var _this = this;

            $("#c24-user-register-form-password-input").keyup(function () {

                if ($(this).val() != "") {

                    $("#pwd_check").closest('.c24-register-row').show();
                    $("#pwd_check").show();
                    $('#c24-user-register-form-password-input').passwordStrength({
                        indicatorText: $('#rs-pws-indicator-text'),
                        indicatorBar: $('#rs-pws-indicator-bar'),
                        email: $('#c24-user-register-form-email-input')
                    });

                } else {
                    $("#pwd_check").closest('.c24-register-row').hide();
                    $("#pwd_check").hide
                }
            });


            $('#c24login-form input, #c24-user-register-form input').on('change', function()
            {
                if(!SIGNIN_VALIDATIONS[$(this).attr('name')]) {
                    return;
                }

                return (new c24.validator).validateField($(this), SIGNIN_VALIDATIONS[$(this).attr('name')]);
            });


        },


        /*********************************************/
        /* Property - setters                        */
        /*********************************************/
        "set_c24session": function(sessionid){
            var _this = this;
            _this.c24session = sessionid;
        },
        "set_c24login_user_id": function(userid){
            var _this = this;
            _this.c24login_user_id = userid;
        },


        /*********************************************/
        /* Views / Form manipulation                 */
        /*********************************************/
        "page_refresh_href": function() {

            var _this = this;

            var href = window.location.href;

            if (href.indexOf('?') == -1) {

                // we need to pass some important parameters on href change after previous formular posts (e.g. error messages)
                // only if we don't have get parameters in the current url
                var params = 'c24api_calculationparameter_id=' + $('#c24api_calculationparameter_id').val();
                params += '&c24api_tariffversion_id=' + $('#c24api_tariffversion_id').val();
                params += '&c24api_tariffversion_variation_key=' + $('#c24api_tariffversion_variation_key').val();
                params += '&datacontainer_id=' + $('#datacontainer_id').val();
                params += '&step=' + $('#step').val();
                params += '&pid=' + $('#pid').val();
                params += '&c24session=';
                params += '&c24api_product_id=' + $('#c24api_product_id').val();
                params += '&partner_id=' + $('#partner_id').val();
                params += '&backlink=' + $('#backlink').val();
                params += '&olduri=' + $('#olduri').val();
                params += '&preload_lead_id=' + $('#preload_lead_id').val();
                params += '&preload_lead_access_key=' + $('#preload_lead_access_key').val();
                params += '&final_lead_id=' + $('#final_lead_id').val();
                params += '&final_lead_access_key=' + $('#final_lead_access_key').val();
                params += '&admin_password=' + $('#admin_password').val();

                params = "";
                href = href + '?' + params;

                window.location.href = href;
                return false;

            } else {
                window.location.reload();
            }
        },



        "handle_errors": function(json_data) {

            var _this = this;

            _this.remove_error_headline();

            var has_errors = 0;

            jQuery.each(json_data, function(element_key, msg){
                has_errors++;
                var element = $('#' + element_key + '-input');
                _this.input_error.addError(element, msg);
            });

            if (has_errors > 0 ){
                _this.add_error_headline();
            }

        },




        "add_error_message": function(element_id, message) {

            var _this = this;
            var dom_element = $('#' + element_id);

            if (!dom_element.hasClass('has-error')) {

                dom_element
                    .addClass('has-error')
                    .append(
                    '<div class="error-message">' + message + '</div>'
                );

            }

        },



        "add_row_error": function(element_id) {

            var _this = this;
            var dom_element = $('#' + element_id);

            if (!dom_element.hasClass('c24-login-form-error')) {
                dom_element.addClass('c24-login-form-error');
            }

        },



        "add_error_headline": function() {

            var _this = this;

            if ($('#c24-register-error-headline').length === 0) {
                $('#c24-user-form').before('<h2 id="c24-register-error-headline"><b>Bitte beachten Sie die <u>Fehlermeldungen</u> in den unten rot markierten Bereichen.</b></h2>');
            }

        },



        "remove_error_headline": function() {
            $('#c24-register-error-headline').remove();
        },

        "show_fatal_error_message": function(){
            this.remove_error_headline();
            $('#c24-user-form').before('<h2 id="c24-register-error-headline"><b>Ein interner Fehler ist aufgetreten. Unsere Technik wurde verständigt. Bitte versuchen Sie es später noch einmal!</b></h2>');
        },

        "handle_remove_errors": function(row) {

            var _this = this;

            $('#c24-user-form .has-error').removeClass('has-error'); /* remove the error colorizing class */
            $('#c24-user-form .error-message').remove(); /* remove the respective error message */
            $('#c24-user-form .c24-login-form-error').removeClass('c24-login-form-error');

            _this.remove_error_headline();
        },



        "render_button_close": function(){

            var _this = this;

            $('#c24-login-form-head-action-login').hide();
            $('#c24-login-form-head-action-link').show();
        },



        "render_button_login": function(){

            var _this = this;

            $('#c24-login-form-head-action-link').hide();
            $('#c24-login-form-head-action-login').show();
        },



        "disable_button_submit": function(jquery_element){

            var _this = this;

            /* @ToDo: disable doubleclick on button */

            /* button: replace icon with spinner */
            jquery_element.find('.fa').removeClass("fa-angle-double-right").addClass("fa-spinner fa-pulse");

        },


        "enable_button_submit": function(jquery_element){
            var _this = this;

            /* @ToDo: enable click on button */

            /* button: replace spinner with double right*/
            jquery_element.find('.fa').removeClass("fa-spinner fa-pulse").addClass("fa-angle-double-right");

        },


        "form_reset": function(){

            var _this = this;
            if (_this.isOpen){

                _this.handle_remove_errors();
                $('#c24-' + _this.active_form + '-form').find('.iMod24Newtip').hide();

                if(_this.active_form == 'login') {
                    $('#c24-' + _this.active_form + '-form-body').slideUp(400, function() {
                        _this.render_button_login();
                    });
                } else {

                    $('#c24-' + _this.active_form + '-form-body').slideUp(400);

                    $('#c24-' + _this.active_form + '-form').find('.iMod24Newtip').hide();

                    $('#c24-' + _this.active_form + '-form').stop(true);

                    $('#c24-' + _this.active_form + '-form').slideUp(_this.animation_length).promise().done(function() {

                        _this.render_button_login();
                        $('#c24-login-form-body').hide();
                        $('#c24-login-form').fadeIn();

                    });

                }

            }

            _this.active_form = '';
            _this.isOpen = false;

        },



        "form_open": function(new_form){
            var animation_length = 400;
            var _this = this;
            var $new_form = $('#c24-' + new_form + '-form');
            var $old_form = $('#c24-' + _this.active_form + '-form');

            $old_form.find('.iMod24Newtip').hide();

            if (!_this.isOpen) {

                /* handle it separatly from the case in which it is open. (animation smoothness)*/
                _this.handle_remove_errors();

                $('#c24-' + new_form + '-form-body').stop(true).slideDown(_this.animation_length).promise().done(function() {

                    _this.isOpen = true;
                    _this.render_button_close();
                    _this.active_form = new_form;

                    /* focus first input field */
                    /* click before focus is needed to activate help_infos */
                    $new_form.find("input:not([type=hidden]):first").click().focus();

                });

            } else {

                $old_form.stop(true, true).slideUp(_this.animation_length).promise().done(function() {

                    _this.active_form = new_form;

                    $('#c24-' + new_form + '-form-body').show();
                    _this.handle_remove_errors();
                    $new_form.slideDown(_this.animation_length).promise().done(function() {

                        /* focus first input field */
                        /* click before focus is needed to activate help_infos */
                        $new_form.find("input:not([type=hidden]):first").click().focus();

                    });

                });

            }

        },



        "form_login": function() {

            var _this = this;

            _this.form_open('login');

        },



        /* enable the recover password form view */
        "form_recover_password": function() {

            var _this = this;

            _this.form_open('forgotpw');

        },



        "form_register": function() {

            var _this = this;

            _this.form_open('user-register');

            if ($("#c24-user-register-form-password-input").val() != "") {
                $("#pwd_check").closest('.c24-register-row').show();
                $("#pwd_check").show();
            } else {
                $("#pwd_check").closest('.c24-register-row').hide();
                $("#pwd_check").hide();
            }

        },



        "action_login": function(){

            var _this = this;

            var $email = $('#c24-login-form-email-input');
            var $pw = $('#c24-login-form-password-input');
            var $button = $('#c24-login-form-link');

            if ($email.val() !== '' && $pw.val() !== '') {

                _this.disable_button_submit($button);

                $.ajax({
                    url: _this.url + '/login_user',
                    method: 'POST',
                    username: 'public',
                    data: {
                        c24_customer_login_email: $email.val(),
                        c24_customer_login_password: $pw.val()
                    }
                }).done(function(data) {
                    _this.page_refresh_href();
                }).fail(function(jqXHR, textStatus, errorThrown) {

                    if(jqXHR.status.isServerError()){
                        _this.show_fatal_error_message();
                    }else if(jqXHR.status.isClientError()){
                        var json_errors = jqXHR.responseJSON.data;
                        var errors_msg = {};

                        /* do some error object mapping to the respective html id in order to simplify the error display logic*/
                        if (typeof json_errors.c24_customer_login_email != 'undefined'){
                            errors_msg["c24-login-form-email"] = json_errors["c24_customer_login_email"];
                        }
                        if (typeof json_errors.c24_customer_login_password != 'undefined'){
                            errors_msg["c24-login-form-password"] = json_errors["c24_customer_login_password"];
                        }

                        _this.handle_errors(errors_msg);
                        _this.enable_button_submit($button);
                    }

                });

            } else {

                /* Error Handling: user didn't fill out the form */

                var errors_msg = new Object();

                /* do some error object mapping to the respective html id in order to simplify the error display logic*/
                if ($email.val() === '') {
                    errors_msg["c24-login-form-email"] = 'Sie müssen eine E-Mail-Adresse angeben.';
                }
                if ($pw.val() === '') {
                    errors_msg["c24-login-form-password"] = 'Sie müssen ein Passwort angeben.';
                }

                _this.handle_errors(errors_msg);

            }

        },



        "action_recover_password": function(){

            var _this = this;

            var $button = $('#c24-forgotpw-form-link');
            _this.disable_button_submit($button);

            var ref_url = encodeURIComponent(window.location.href.replace(/&ref=[^&;]*/,''));

            $.ajax({
                url: _this.url + '/recover_user',
                method: 'POST',
                username: 'public',
                data: {
                    c24_account_pwrecover_email: $('#c24-forgotpw-form-email-input').val(),
                    c24_account_pwrecover_ref: ref_url
                }
            }).done(function(data) {

                _this.form_open('emailsend');

            }).fail(function(jqXHR, textStatus, errorThrown) {

                var json_errors = jqXHR.responseJSON.data;
                var errors_msg = new Object();

                /* do some error object mapping to the respective html id in order to simplify the error display logic*/
                if (typeof json_errors.c24_account_pwrecover_email != 'undefined'){
                    errors_msg["c24-forgotpw-form-email"] = json_errors["c24_account_pwrecover_email"];
                }

                _this.handle_errors(errors_msg);
                _this.enable_button_submit($button);
            });

        },



        "action_register": function(){

            var _this = this;

            var $pw = $('#c24-user-register-form-password-input');
            var $re_pw = $('#c24-user-register-form-repassword-input');
            var $button = $('#c24-user-register-form-link');


            if ($pw.val() !== $re_pw.val()) {

                var errors_msg = {
                    'c24-user-register-form-password': 'Die beiden Passwörter stimmen nicht überein.',
                    'c24-user-register-form-repassword': 'Die beiden Passwörter stimmen nicht überein.'
                };
                _this.handle_errors(errors_msg);

            } else {


                _this.disable_button_submit($button);

                $.ajax({
                    url: _this.url + '/register_user',
                    method: 'POST',
                    username: 'public',
                    data: {
                        c24_account_register_email: $('#c24-user-register-form-email-input').val(),
                        c24_account_register_password:  $pw.val(),
                        c24_account_register_password2: $re_pw.val(),
                        birthdate: $('#birthdate').val()
                    }
                }).done(function (data) {

                    var href = window.location.href;

                    if (href.indexOf('?') == -1) {
                        href = href + '?';
                    } else {
                        href = href + '&';
                    }

                    href = href + 'user_registered=true' ;

                    window.location.href = href;

                }).fail(function(jqXHR, textStatus, errorThrown) {

                    var json_errors = jqXHR.responseJSON.data;
                    var errors_msg = new Object();

                    /* do some error object mapping to the respective html id in order to simplify the error display logic*/
                    if (typeof json_errors.c24_account_register_email != 'undefined'){
                        errors_msg["c24-user-register-form-email"] = json_errors["c24_account_register_email"];
                    }
                    if (typeof json_errors.c24_account_register_password != 'undefined'){
                        errors_msg["c24-user-register-form-password"] = json_errors["c24_account_register_password"];
                    }

                    _this.handle_errors(errors_msg);

                    _this.enable_button_submit($button);

                });

            }

        },



        "action_logout": function(){

            var _this = this;

            $.ajax({

                type: 'post',
                username: 'public',
                dataType: 'json',
                data: {
                    c24session_hidden: _this.c24session,
                    c24login_user_id_hidden: _this.c24login_user_id
                },
                url: _this.url + '/logout_user/',
                suppressErrors: true,
                crossDomain: true,
                success: function (data) {
                    // the previous api call fires only a sso logout
                    // after it, forward to logout locally
                    window.location.href = '/user/logout';
                },
                error: function(xhr, status, error) {

                }

            });

        }
    };

})();
