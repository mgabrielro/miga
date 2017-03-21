(function(namespace_to_construct){
    "use strict";

    /**
     * the timeout id
     */
    var timeout;

    //-------------------"PRIVATE METHODS"--------------------
    /**
     * check trigger events
     *
     * @param event
     * @param trigger
     */
    function check_trigger_event(event, trigger){
        /**
         * the tooltip element
         */
        var tooltip;

        if (trigger.data('trigger') == event) {
            if (event == 'mouseover') {
                tooltip = mouse_over(trigger);
            } else {
                tooltip = mouse_click(trigger);
            }

            timeout = setTimeout(function() {
                tooltip.fadeIn();
            }, 250);
        }
    }

    /**
     * handle mouseover event
     *
     * @param trigger
     * @returns Array
     */
    function mouse_over(trigger){
        trigger.find('.c24-tooltip-close').hide();

        return create_tooltip(trigger);
    }

    /**
     * handle on click event
     *
     * @param trigger
     * @returns Array
     */
    function mouse_click(trigger){
        trigger.find('.c24-tooltip-close').show();

        return create_tooltip(trigger);
    }

    /**
     * handle mouseout event
     *
     * @param trigger
     */
    function mouse_out(trigger){
        if (trigger.data('trigger') == 'mouseover') {
            trigger.find('.c24-tooltip-content').fadeOut();

            clearTimeout(timeout);
        }

    }

    /**
     * retrieves the direction of the tooltip
     *
     * data-direction attribute is used as the default direction
     * data-direction-overwrite can overwrite this per device-output
     *
     * example:
     * data-direction="right" data-direction-overwrite='{"tabletapp" : "left"}
     */
    function get_direction(trigger) {
        var direction = "up";
        var overwrites = trigger.data('direction-overwrite');
        var default_direction = trigger.data('direction');
        var overwritten_direction = $.isPlainObject(overwrites) ? overwrites[window.deviceoutput] : undefined;

        if(typeof overwritten_direction != 'undefined') {
            return overwritten_direction;
        }

        if (typeof default_direction != 'undefined') {
            return default_direction;
        }

        return direction;
    }

    /**
     * create tooltip
     *
     * @param trigger
     * @returns Array
     */
    function create_tooltip(trigger){
        var trigger_height = trigger.outerHeight();
        var trigger_with = trigger.outerWidth();
        var content = trigger.find('.c24-tooltip-content');
        var content_width = content.outerWidth();
        var content_height = content.outerHeight();
        var arrow = content.find('.c24-tooltip-arrow');
        var direction = get_direction(trigger);

       // clean arrow properties from eventual previous calls and set the current direction
        arrow.removeClass('down up left').addClass(direction);

        // change direction if the tooltip is being hidden by scrolling down
        if (direction == "up" && ((trigger.offset().top - $(window).scrollTop()) < (content_height))) {
            direction = 'down';
        } else if (direction == "left" && ((trigger.offset().top - $(window).scrollTop()) < (content_height/2))) {
            direction ="leftdown";
        }

        var arrow_width = arrow.width();
        var arrow_height = arrow.height();
        var arrow_middle_h = (content_width / 2 ) - (arrow_width /2);
        var arrow_middle_v = (content_height / 2 ) - (arrow_height /2);
        var arrow_top = 0;
        var content_top = 0;

        switch (direction) {
            case 'up':
                arrow_top = (content_height - 3);
                content_top = -(arrow_height + content_height);
                arrow.css('left', arrow_middle_h + 'px');
                arrow.css('top', arrow_top + 'px');
                content.css('top', content_top + 'px');
                content.css('left', (trigger_with/2) - (content_width / 2) + 'px');
                break;

            case 'down':
                arrow_top = -arrow_height;
                content_top = (trigger_height + arrow_height);
                arrow.css('top', arrow_top + 'px');
                arrow.css('left', arrow_middle_h + 'px');
                content.css('top', content_top + 'px')
                content.css('left', (trigger_with/2) - (content_width / 2) + 'px');
                break;

            case 'left':
                arrow_top = arrow_middle_v;
                content_top = -((content_height / 2) - (trigger_height/2));
                content.css('left', '-' +  (arrow_width +  content_width) + 'px');
                content.css('top', content_top + 'px');
                arrow.css('top', arrow_top + 'px');
                arrow.css('right', '-' + (arrow_width - 1) + 'px');
                break;

            case 'right':
                arrow_top = arrow_middle_v;
                content_top = -((content_height / 2) - (trigger_height/2))
                content.css('left', (trigger_with + arrow_width) + 'px');
                content.css('top', content_top + 'px');
                arrow.css('top', arrow_top + 'px');
                arrow.css('left', '-' + arrow_width + 'px');
                break;

            case 'leftdown':
                arrow_top = 15;
                content_top = -20;
                content.css('left', '-' +  (arrow_width +  content_width) + 'px');
                content.css('top', content_top + 'px');
                arrow.css('top', arrow_top + 'px');
                arrow.css('right', '-' + (arrow_width - 1) + 'px');
                break;

            case 'down_right_arrow':
                arrow_top = -arrow_height;
                content_top = (trigger_height + arrow_height);

                var content_left = (trigger_with + 20) - (content_width);
                var arrow_left = content_width - 43;

                arrow.css('top', arrow_top + 'px');
                arrow.css('left', arrow_left + 'px');
                content.css('top', content_top + 'px')
                content.css('left', content_left + 'px');
                break;

        }

        // check the arrow direction and adjust it if necessary
        if (direction == 'up' || direction == 'down' ||  direction == 'down_right_arrow') {

            if (arrow_top < content_top) {
                arrow.removeClass('up').addClass('down');
            } else if (arrow_top > content_top) {
                arrow.removeClass('down').addClass('up');
            }

        }

        return content;
    }

    (function(ns){

        //-------------------PSEUDO-CONSTRUCTOR OF THE NAMESPACE--------------------

        /*
         * This is not a constructor in any way, regarding javascript language constructors. It is just a self executing function which is called after all relevant other
         * parts for this namespace are loaded. (The public and the private method definitions)
         * Namespaces are NO Classes, but structured scopes!
         */

        $(document).ready(function(){
            ns.init();
        });

    })(namespace(namespace_to_construct, $.noop, {

        //-------------------PUBLIC METHODS--------------------
        init: function(){
            $(document).on('mouseover', '.c24-tooltip', function(){
                var isTouchDevice = 'ontouchstart' in document.documentElement;

                if(isTouchDevice) {
                    return;
                }

                if ($(this).find('.c24-tooltip-content').is(':visible')) {
                    return;
                }

                check_trigger_event('mouseover', $(this));

                $(this).on('mouseout', function(){
                    mouse_out($(this));
                });

            });

            $(document).on('click touchend', '.c24-tooltip', function(){
                check_trigger_event('click', $(this));
            });

            $(document).on('click touchend', '.c24-tooltip-close', function(e){
                $(this).parent().fadeOut();

                return false;
            });

            $(document).on('click touchend', function(e) {
                var $active_tooltip = $('.c24-tooltip-content:visible');
                var clicked_outside_active_tooltip = !$active_tooltip.is(e.target) && $active_tooltip.has(e.target).length === 0;

                if ($active_tooltip.is(':animated') || !clicked_outside_active_tooltip) {
                    return;
                }
                $active_tooltip.fadeOut();
            });
        }
    }));
})("c24.tooltips");
