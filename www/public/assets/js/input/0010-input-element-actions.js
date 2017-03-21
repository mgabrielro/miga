$(function() {

    function mark_input_active() {
        var input_wrapper = $(this).parents('.js-c24-er-element');
        var input_selector = '.c24-input-containter, .c24-input-multi';

        input_wrapper.removeClass('error');
        $('.c24-er-element').removeClass('active');
        input_wrapper.addClass('active');

        $(input_selector).removeClass('hover');
        $(input_selector).removeClass('c24-active-input-element');
        input_wrapper.find(input_selector).addClass('c24-active-input-element');

        if (c24.check24.input.tooltip.load.instances.length < 1) {
            $input_tooltip_js = new c24.check24.input.tooltip.load();
        }

        var oversize_adjust = true;
        // adjust only if the input field isn't a part of c24 login box
        if ($(this).closest('form').attr('id') == 'c24login-form') {
            oversize_adjust = false;
        }

        $input_tooltip_js.adjust(input_wrapper, oversize_adjust);
    }

    $('.js-c24-er-element').delegate('.c24-form-ele-wrapper, .c24-checkbox, .c24-er-info', 'click', mark_input_active);
    $('.js-c24-er-element').delegate('input, select', 'focus', mark_input_active);

    $(document).click(function(e){
        var $active_input = $('.js-c24-er-element.active');
        var clicked_outside_of_input = !$active_input.is(e.target) && $active_input.has(e.target).length === 0;

        if(!clicked_outside_of_input)
            return;

        $('.c24-er-element').removeClass('active');
        $('.js-c24-er-element .iMod24Newtip').hide();
    });

    $('.c24-fe-radio').click(function() {

        var value = $(this).data('value');
        var hiddenInputId = '#' + $(this).data('name') + '_input';
        $( hiddenInputId ).val(value).trigger('change');

    });

});