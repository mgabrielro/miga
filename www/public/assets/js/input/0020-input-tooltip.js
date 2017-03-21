$(document).ready(function() {
    "use strict";

    var ns = namespace("c24.check24.input.tooltip");

    ns.load = function (ajax_url) {

        this.url = ajax_url;

        ns.load.instances.push(this);
        this.instanceNum = ns.load.instances.length - 1;
        this.ajax_result = null;

    };

    ns.load.instances = [];

    ns.load.prototype = {

        // adjust tooltip position, if necessary
        adjust: function(element, oversize_adjust) {

            var _this = this;

            var element = $(element);
            var this_tooltip = element.find(".iMod24Newtip");

            // if current element is not hidden, do nothing!
            if (this_tooltip.is(":hidden") == false) {
                return true;
            }

            $(".iMod24Newtip").hide();

            var main_obj = element.parents('form');
            var main_top = main_obj.offset().top;
            var main_height = main_obj.height();

            var this_top = element.offset().top;

            var this_tooltip_height = this_tooltip.height();
            var this_corner = element.find(".iBox24Corner");
            var this_tooltip_css_top = parseInt(this_tooltip.css("top"));

            // if the current tooltip is too big and laying over the main_obj, adjust it
            if ((main_height + main_top) < (this_top + this_tooltip_height + this_tooltip_css_top)
                && oversize_adjust) {

                // determine the oversize height and adjust objects
                var oversize_height = (this_top + this_tooltip_height) - (main_height + main_top);
                var this_this_corner_css = parseInt(this_corner.css("top"));

                this_tooltip.css("top", this_tooltip_css_top - oversize_height + "px");
                this_corner.css("top", this_this_corner_css + oversize_height + "px");

            }

            _this.condition_check(this_tooltip);
            _this.fadeIn(this_tooltip);

        },

        fadeIn: function(tooltip) {
            tooltip.fadeIn();
        },

        // check if we have conditioned hint texts
        condition_check: function(element) {
            var _this = this;
            element.find('div[data-condition-element]').each( function(_){
                var condition_element = $(this).data("condition-element");
                var required_condition_value = $(this).data("condition-value");
                var condition_value = _this.condition_value(condition_element);

                if (required_condition_value == condition_value) {
                    $(this).show();
                } else {
                    $(this).hide();
                }

            });

        },

        condition_value: function(condition_element) {
            var input_element = $("input[type='radio'][name='" + condition_element + "']:checked");

            if(input_element.length == 0)
            {
                input_element = $('#' + condition_element);
            }
            return input_element.val();
        }
    }
});