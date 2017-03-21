$(document).ready(function() {
    $('#c24-text-email-headline').remove();
    $('#c24-password-password-headline').remove();
    $('.c24-text-empty-icon').hide();
    $('.c24-input-headline').css({'visibility': 'visible', 'fontSize' : '12px', 'paddingBottom': '2px'});
    $('.c24-input-headline').show();
    $.rs.mobilesite.init_text_input_remover();

    $('.c24-input-help-help, .c24-input-help-close').click(function() {

        $('.c24-input-help-close').hide();
        $('.c24-input-help-help').show();

        var content_id = $(this).attr('rel');
        var content = $('#' + content_id);
        var content_hidden = content.is(':hidden');

        $('.c24-input-help-content').hide();

        if (content_hidden) {

            var row_height = $(this).parent().parent().height();
            var icon_height = $(this).parent().height();

            $(this).hide();
            var close = $(this).parent().find('.c24-input-help-close');

            close.css('padding-bottom', (row_height - icon_height + 4) + 'px');
            close.show();

            content.show();

        } else {

            $(this).hide();
            $(this).parent().find('.c24-input-help-help').show();

            content.hide();

        }

    });

});
