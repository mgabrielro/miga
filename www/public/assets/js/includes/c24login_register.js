/* <![CDATA[ */

$(document).ready(function() {

    $('#password').passwordStrength({
        indicatorText: $('#c24-password-indicator-text'),
        indicatorBar: $('#c24-password-indicator-bar'),
        email: $('#email')
    });

    $('.c24-faq-headline').click(function() {

        var content = $(this).next('.c24-faq-content');

        if (content.is(':hidden')) {

            $(this).removeClass('c24-faq-closed');
            $(this).addClass('c24-faq-opened');

            content.show();

        } else {

            $(this).removeClass('.24-faq-opened');
            $(this).addClass('c24-faq-closed');

            content.hide();

        }

    });

    var registerFormData = c24.et.local_storage.get('registerForm');
    var email = $('#email');

    if (registerFormData !== null && typeof registerFormData.email === "string" && email.length > 0) {

        email.val(registerFormData.email);
        email.trigger('change');

    }

    $.rs.mobilesite.init_headlines();

});

/* ]]> */