/* <![CDATA[ */
$(document).ready(function() {

    $.rs.mobilesite.init_select();
    $.rs.mobilesite.init_radio();
    $.rs.mobilesite.init_headlines();
    $.rs.mobilesite.init_select_overlay();
    $.rs.mobilesite.init_agreed_tel_contact_error();

    $('#firstname, #lastname').attr('autocapitalize', 'on');

    var CHILD = 'child';
    var ADULT = 'adult';

    var $login_type = $('#c24login_type');
    var $page_form = $('#c24-form');

    // Save current form url as backup
    var page_form_action_default = $page_form.attr('action');

    var $insure_input = $('#insure_input');
    var $is_child = $('#insured_person_type').val() == CHILD;

    /**
     * Update page_form with new action or reset it
     */
    var update_page_form_action = function() {

        if ($login_type.val() == 'none') {
            $page_form.attr('action', page_form_action_default);
        } else {
            $page_form.attr('action', login_urls[$login_type.val()]);
        }

    };

    /**
     * Shows a given view
     * @param view
     */
    var change_view = function(view) {

        var $insure_person = $("div#insure_person");
        var $insure_other  = $('div.c24-insure_other_hide_row');

        var $login_form = $(".c24-login_row");
        var $insure_own_form = $("div.c24-insure_own_row");
        var $user_recover_form = $('.c24-user_recover_row');
        var $user_register_form = $('.c24-user_register_row');
        var $user_register_hide = $('.c24-user_register_hide_row');

        var $sso_prefilled_birthdate = $('#sso_prefilled_birthdate');
        var $best_sso_info_icon = $('#best-sso-info');

        switch(view) {

            case 'insure_adult':

                if ($insure_input.val() == 'own') {

                    $insure_own_form.show();
                    $insure_person.hide().removeClass('distance_form_header');

                    // Update the Best-SSO prefilled birthdate with the inserted one on Input1
                    $sso_prefilled_birthdate.html($('#birthdate').val());
                    $sso_prefilled_birthdate.show();

                    // Adjust tooltip position
                    $best_sso_info_icon.addClass('info-margin');

                } else {

                    $insure_other.hide();
                    $insure_person.show().addClass('distance_form_header');

                    // Another person is insured, not the logged in one
                    $sso_prefilled_birthdate.hide();

                    // Adjust tooltip position
                    $best_sso_info_icon.removeClass('info-margin');

                }

                break;

            case 'insure_child':

                $insure_person.show();
                $insure_own_form.show();
                $('#insure_container').hide();

                // Child ist always 'other' person set it like this for the correct save in BO-Tool)
                $insure_input.val('other');

                // Another person is insured, not the logged in one
                $sso_prefilled_birthdate.hide();

                // Adjust tooltip position
                $best_sso_info_icon.removeClass('info-margin');

                break;

        }

        // If the user is logged in

        if ($('#c24login_type').val() == 'user') {

            // don't show the E-mail field
            $("#c24-customer-account-logged-out-email").hide();


            $sso_prefilled_birthdate.html($('#birthdate').val());

        }

    };

    // Trigger this when the user change the insure person.
    $insure_input.change(function() {
        ($is_child) ? change_view('insure_child') : change_view('insure_adult');
    });

    $insure_input.change();

    $("#request_offer").click(function(){

        /**
         * TODO: that should not be like this, change inside the validaton process better
         */
        var DEFAULT_CHILD_DATE = '01.01.1985';
        if($is_child) {
            $('#birthdate').val(DEFAULT_CHILD_DATE);
        }

        $page_form.submit();
        
    });

});

$formCustomer = $("#formCustomerNew");
$use_sso_data = $("#use_sso_data");
$switched_from_bestsso_to_form = $('#switched_from_bestsso_to_form');

// Hide the best-sso block and show the form
function hide_best_sso_and_show_form() {
    $formCustomer.removeClass('sso-prefilled');
    $use_sso_data.val($formCustomer.hasClass('sso-prefilled') ? 1 : 0);
}

// User views the best-sso block, but he clicks to edit his data
$(".toggle_sso_prefilled").click(function() {

    /**
     * Set a flag to inform the page on new load,
     * that it must show the form and not the best-sso block
     * because the user already clicked to change his data
     */
    $switched_from_bestsso_to_form.val('yes');

    hide_best_sso_and_show_form();

});

/**
 * If the flag is set to 'yes', we need to show the form
 * and not the best-sso block, because the user
 * already clicked to change his data
 */
if($switched_from_bestsso_to_form.val() == 'yes') {
    hide_best_sso_and_show_form();
}

// There are errors on form and we have the best-sso in place ?
if($("#c24-register-error-headline-sso-login").is(":visible") && $use_sso_data.val() == 1) {

    $agreed_tel_contact = $("#agreed_tel_contact_container");
    $agreed_tel_contact_has_error = $agreed_tel_contact.find("div.c24-content-row-block-errorbox").length == 1;

    // If there is ONLY 1 error visible, and this one is on the agreed_tel_contact checkbox
    if ($('.c24-content-row-block-errorbox:visible').length == 1 && $agreed_tel_contact_has_error) {

        // We show the error and the best-sso block
        $use_sso_data.val(1);

    } else {

        // We show the form and hide the best-sso block
        $formCustomer.removeClass('sso-prefilled');
        $use_sso_data.val(0);

    }

}

/**
 * Increasing user usability
 * If we are on the c24login form, on the password field
 * and the user clicks enter, we submit
 */
$("#c24_customer_login_password").keyup(function(e) {

    if (e.which == 13) {
        $("#c24-customer-account-login-button").click();
    }

});

/* ]]> */
