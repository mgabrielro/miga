/* <![CDATA[ */

$(document).ready(function() {

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

    // Clear old registerForm data
    c24.et.local_storage.remove('registerForm')

    $('#c24-register').autoSave({
        'prefix' : 'registerForm'
    });

    $.rs.mobilesite.init_headlines();

});

/* ]]> */