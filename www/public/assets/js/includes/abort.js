/* <![CDATA[ */

$(document).ready(function() {

    $('.c24-text-empty-icon').click(function() {
        var element = $(this).prev('input');
        element.val('');
        element.focus();
    });

    $('.c24-form-text').keypress(function(e) {
        $(this).parents('.c24-input-area').find('.c24-input-headline').css('visibility', 'visible');
    });

    $.rs.mobilesite.init_checkbox();

});

/* ]]> */