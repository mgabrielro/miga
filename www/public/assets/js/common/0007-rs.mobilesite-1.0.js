;(function ($){

    if (!$.rs) {
        $.rs = {};
    }
    
    var mobileLastTariff = 'c24_mobile_last_tariff';

    /**
     * Object of dynamic url properties and the values (input fields
     *
     * @type {{c24api_insured_person: string, c24api_profession: string, c24api_contribution_carrier: string, c24api_contribution_rate: string, c24api_birthdate: string, c24api_children_age: string, c24api_parent_servant_or_servant_candidate: string, c24api_parent1_insured: string, c24api_parent2_insured: string}}
     */
    var browserhistory = {
        'c24api_insured_person' :                         'c24api_insured_person_input',
        'c24api_profession' :                             'c24api_profession',
        'c24api_contribution_carrier' :                   'c24api_contribution_carrier',
        'c24api_contribution_rate' :                      'c24api_contribution_rate',
        'c24api_birthdate' :                              'c24api_birthdate',
        'c24api_birthdate_day' :                          'c24api_birthdate_day',
        'c24api_birthdate_month' :                        'c24api_birthdate_month',
        'c24api_birthdate_year' :                         'c24api_birthdate_year',
        'c24api_children_age' :                           'c24api_children_age',
        'c24api_parent_servant_or_servant_candidate' :    'c24api_parent_servant_or_servant_candidate_input',
        'c24api_parent1_insured' :                        'c24api_parent1_insured',
        'c24api_parent2_insured' :                        'c24api_parent2_insured',
        'c24api_hospitalization_accommodation':           'c24api_hospitalization_accommodation_input',
        'c24api_dental':                                  'c24api_dental_input',
        'deviceoutput':                                   'deviceoutput',
        'c24api_provision_costsharing_limit':             'c24api_provision_costsharing_limit_input'
    };

    $.rs.mobilesite = {

        init_headlines : function() {


            $('.c24-form-text').keypress(function(event) {
                    $.rs.mobilesite.eventlistener_keypress(this, event);
            });

            $('input[type=text]').attr('autocorrect', 'off');

            $('.c24-form-text').blur(function() {

                $.rs.mobilesite.eventlistener_blur(this, event);

            });

            $('.c24-form-select').change(function(event) {

                if ($(this).val() == '' || $(this).val() == '-1' || $(this).val() == '-') {
                    $('#' + $(this).data('headline')).removeClass('c24-input-title-visible');
                } else {
                    $('#' + $(this).data('headline')).addClass('c24-input-title-visible');
                }

            });

        },

        init_select_overlay : function() {

            $(document).on('change', 'select', function() {
                var optionText = $(this).find('option[value="' + $(this).val() + '"]').text();
                var placeholder_viewer =  $('#' + $(this).attr('name') + '-select-button span');
                var label = $(this).closest('.c24-content-row-block').find('.js-c24-block-label-top');

                if ($(this).val() == '' && $(this).data('placeholder')) {
                    placeholder_viewer.html($(this).data('placeholder'));
                    placeholder_viewer.addClass('empty');
                } else {
                    placeholder_viewer.html(optionText);
                    placeholder_viewer.removeClass('empty');
                }

                // skip the rest in case there is no dynamic label
                if (!label.length){
                    return;
                }

                if ($(this).val() == "" || $(this).val() == "-") {
                    label.css({visibility: 'hidden'});

                } else {
                    label.css({visibility: 'visible'});
                }
            });

        },

        init_agreed_tel_contact_error : function() {

            $('#agreed_tel_contact_container').click(function(){
               var if_checked_agreed_tel_contact= $('#agreed_tel_contact_container').find('label').hasClass("ui-checkbox-off");
               var content_row_block_errorbox= $('#agreed_tel_contact_container').children('.c24-content-row-block-errorbox');

                if (if_checked_agreed_tel_contact == true) {
                    content_row_block_errorbox.hide();
                }

            });

        },

        init_input_states : function() {

            $('.ui-input-text, .c24-select .ui-btn').click(function(){
                $(this).addClass('c24-active-input-element');
                $(this).removeClass('c24-content-row-error');
            });

            $("input, select").blur(function(){
                $(this).closest('.c24-active-input-element').removeClass('c24-active-input-element');
            });

        },

        // function for the
        init_info_layers : function() {

            $(document).on('click', '.js-c24-info-icon', function() {

                var oInfoTextContainer = $(this).closest('.c24-content-row-info, .c24-twocolumn-info, .c24-twocolumn-select-info').find('.c24-content-row-block-infobox');
                var oIconContainer = $(this).parent();
                var oInfoTextIcon = $(this).find('.c24-info-icon');

                if (oIconContainer.hasClass('c24-info-icon-open')) {
                    oIconContainer.removeClass('c24-info-icon-open');
                    oIconContainer.find('.tip-helptext-active').removeClass('tip-helptext-active');
                    oInfoTextContainer.hide();
                } else {
                    oIconContainer.addClass('c24-info-icon-open');
                    oInfoTextContainer.show();
                }

            });

            $(".c24-info-close-row").click(function(e){
                e.stopPropagation();

                var oInfoTextContainer = $(this).closest('.c24-content-row-block-infobox');
                var contentRow = oInfoTextContainer.parent();
                var oIconContainer = contentRow.find('.c24-content-row-info-icon');
                var activeElement = contentRow.find('.c24-active-input-element');

                oInfoTextContainer.toggle();
                oIconContainer.parent().removeClass('c24-info-icon-open');
                activeElement.removeClass('c24-active-input-element');
                contentRow.find('.tip-helptext-active').removeClass('tip-helptext-active');

            });

        },

        init_radio : function() {

            $('.c24-switch').click(function() {
                var adultEle = $(this).closest('.c24-switch-container');
                adultEle.find('.c24-switch').removeClass('switch-active');
                var switchIcon = adultEle.find('.c24-switch-panel-icon');
                switchIcon.removeClass('icon-active');
                $(this).addClass('switch-active');
                var switchIconActive = $(this).find('.c24-switch-panel-icon');
                switchIconActive.addClass('icon-active');
                var value = $(this).data('value');
                var hiddenInputId = '#' + $(this).data('name') + '_input';
                $( hiddenInputId ).val(value).trigger('change');
            });

        },

        /**
         * Add a class 'select-default-color' in element span with the class name c24-form-select, if the selectfield is default.
         */
        init_select : function() {

            $('select.c24-form-select').each(function(i, e) {
                c24.vv.shared.util.set_class_defaultvalue_by_selectfield(e);
            });

            $('select.c24-form-select').change(function() {
                c24.vv.shared.util.set_class_defaultvalue_by_selectfield(this);
            });
            
        },
      
        /**
         * Code to remove error messages on input1 when user
         * get´s focus on the element again.
         */
        init_remove_error_messages_on_focus: function () {

            //TODO: Add additional field types when we have more mandatory fields in input1.

            $(".c24-form-select").focus(function() {

                var $this = $(this);
                var form_row = $this.closest('.c24-select-container');

                if (form_row.hasClass('c24-content-row-error')) {
                    form_row.removeClass('c24-content-row-error');
                }

                // Find span with label text
                var span = $this.prev('span');

                if (span.hasClass('c24-form-errorbox') || span.hasClass('c24-form-error-color')) {
                    span.removeClass('c24-form-errorbox');
                    span.removeClass('c24-form-error-color');
                }

                // Finally remove elements on the element itself
                if ($this.hasClass('c24-form-errorbox') || $this.hasClass('c24-form-error-color')) {
                    $this.removeClass('c24-form-errorbox');
                    $this.removeClass('c24-form-error-color');
                }

            });
        },

        init_error_remove_message: function () {

            $(".c24-form-select").change(function () {

                var error_div = $(this).parents(".c24-content-row-error");

                if ($(this).hasClass("c24-form-errorbox") || error_div.length > 0) {

                    if ($(this).val() != "" && $(this).val() != "-1" && $(this).val() != '-') {


                        error_div.removeClass('c24-content-row-error');
                        $(this).removeClass('c24-form-errorbox c24-form-error-color');
                        $(this).prev('span').removeClass('c24-form-errorbox c24-form-error-color');

                        $(this).removeClass("c24-form-errorbox");
                        $(this).removeClass("c24-form-error-color");

                        var errorbox = $("#" + $(this).data("overlay")).parents(".c24-form-errorbox");

                        errorbox.removeClass("c24-form-error-color");
                        errorbox.removeClass("c24-form-errorbox");

                        $("#" + $(this).data("content-layer")).hide()


                        if ($(".c24-content-row-error").length == 0) {
                            $(".c24-form-error").hide();
                        }

                    }

                }

            });

            $(".c24-form-text").on('blur keyup', function () {

                var error_div = $(this).parents(".c24-content-row-error");

                if ($(this).hasClass("c24-form-errorbox") || error_div.length > 0) {

                    if ($(this).val() != "") {

                        error_div.removeClass('c24-content-row-error');
                        $(this).removeClass('c24-form-errorbox c24-form-error-color');
                        $(this).prev('span').removeClass('c24-form-errorbox c24-form-error-color');

                        $(this).removeClass("c24-form-errorbox");
                        $(this).removeClass("c24-form-error-color");
                        $(this).parents('.c24-content-row').removeClass('c24-content-row-error');
                        $("#" + $(this).data("content-layer")).hide()

                        if ($(".c24-content-row-error").length == 0) {
                            $(".c24-form-error").hide();
                        }

                    }

                }

            })

        },

        init_checkbox: function () {

            $('.c24-form-checkbox').each(function(index, element) {

                var checkbox = $(element);
                var area     = checkbox.parent();
                var c24_checkbox = $('<div>').addClass('c24-form-checkbox-element').addClass('c24-form-checkbox-element-default');

                checkbox.hide();
                area.prepend(c24_checkbox);
                c24_checkbox_state(checkbox, c24_checkbox);

            });

            $('.c24-form-checkbox-element').on('click', function() {
                $(this).parent().find('.c24-form-checkbox').click();
            });

            $("input[type='checkbox']").change(function() {

                var c24_checkbox = $(this).parent().find('.c24-form-checkbox-element');
                var checkbox = $(this);

                c24_checkbox_state(checkbox, c24_checkbox);

            });

            function c24_checkbox_state(checkbox, c24_checkbox) {

                if (checkbox.is(':checked')) {

                    c24_checkbox
                        .addClass('c24-form-checkbox-element-checked')
                        .removeClass('c24-form-checkbox-element-default');

                } else {

                    c24_checkbox
                        .addClass('c24-form-checkbox-element-default')
                        .removeClass('c24-form-checkbox-element-checked');

                }

            }

        },

        init_datepicker: function() {

            $('input[type=date]').each(function(){
               $(this).attr('type', 'text');
            });

            $('.c24-form-date[type=text]').each(function(index, element) {

                var begin = false,
                    end = false,
                    headerText = false,
                    defaultValue = false;

                headerText = $(element).attr('placeholder');

                if ($(element).attr('min')) {
                    begin = $(element).attr('min');
                    var arr = begin.split('.');
                    if (arr.length == 3) {
                        begin = new Date(arr[2], arr[1] - 1, arr[0]);
                    } else {
                        begin = new Date(begin);
                    }

                }

                if ($(element).attr('max')) {
                    end = $(element).attr('max');
                    var arr = end.split('.');
                    if (arr.length == 3) {
                        end = new Date(arr[2], arr[1] - 1, arr[0]);
                    } else {
                        end = new Date(end);
                    }

                }

                if ($(element).val()) {

                    defaultValue = $(element).val();
                    var arr = defaultValue.split('.');
                    if (arr.length == 3) {
                        defaultValue = new Date(arr[2], arr[1] - 1, arr[0]);
                    } else {
                        defaultValue = new Date(defaultValue);
                    }

                } else {

                    var d = new Date();
                    defaultValue = new Date(d.getFullYear() - 35, d.getMonth(), d.getDate());

                }

                if ($(element).attr('id') == 'movein_date') {
                    defaultValue = new Date();
                }

                if ($.mobiscroll.defaults.theme == 'wp') {
                    $.mobiscroll.themes.wp.height = 30;
                    $.mobiscroll.themes.wp.rows = 7;
                    $('body').append($('<style type="text/css">.wp .dw-sel .dw-day, .wp .dw-sel .dw-mon, .wp .dw-day, .wp .dw-mon { margin-left:30px; }</style>'));
                }

                $(element).mobiscroll({
                    'preset'         : 'date',
                    'lang'           : 'de',
                    'animate'        : 'pop',
                    'closeOnOverlay' : false,
                    'display'        : 'bottom',
                    'dateOrder'      : 'ddMMyy',
                    'defaultValue'   : defaultValue // Must be set here (can't be set later
                });

                $(element).mobiscroll('option', 'minDate', begin);
                $(element).mobiscroll('option', 'headerText', headerText);
                $(element).mobiscroll('option', 'maxDate', end);
                $(element).mobiscroll('option', 'defaultValue', defaultValue);

            });

            $('.c24-form-date-label').click(function() {
                $(this).hide();
            });

            $('input[type="date"]').focus(function(){
                $(this).siblings('.c24-form-date-label').hide();
            });

            $('input[type="date"]').blur(function(){
                if ($(this).val() == '') {
                    $(this).siblings('.c24-form-date-label').show();
                }

            });

        },

        init_text_input_remover: function() {

            // hide/show delete icons
            $('input').on('blur keyup', function(){

                if($(this).val().length > 0) {
                    $(this).next('.c24-text-empty-icon').show();
                }
                else {
                    $(this).next('.c24-text-empty-icon').hide();
                }

            });

            $('.c24-text-empty-icon').click(function() {

                var element = $(this).prev('input');
                $(this).hide();
                element.val('');
                element.focus();

                if(navigator.userAgent.toLowerCase().indexOf('android') != -1) {

                    if(element.attr('id') == 'birthdate') {

                        element.attr('readonly', 'readonly'); // Force keyboard to hide on input field.
                        element.attr('disabled', 'true'); // Force keyboard to hide on textarea field.
                        setTimeout(function() {
                            element.blur();  //actually close the keyboard
                            // Remove readonly attribute after keyboard is hidden.
                            element.removeAttr('readonly');
                            element.removeAttr('disabled');
                        }, 100);

                    }
                    else if(element.attr('type') == 'date') {

                        element.attr('readonly', 'readonly'); // Force keyboard to hide on input field.
                        element.attr('disabled', 'true'); // Force keyboard to hide on textarea field.
                        setTimeout(function() {
                            element.blur();  //actually close the keyboard
                            // Remove readonly attribute after keyboard is hidden.
                            element.removeAttr('readonly');
                            element.removeAttr('disabled');
                        }, 100);

                    }

                }

                element.keyup();

            });

        },

        init_device_orientation: function() {

            var matchMedia = window.msMatchMedia || window.MozMatchMedia || window.WebkitMatchMedia || window.matchMedia;

            if (typeof(matchMedia) !== 'undefined') {

                var LONG_TITLE  = 'Private Krankenversicherung';
                var SHORT_TITLE = 'Private Krankenvers.';
                var isPortrait  = window.matchMedia("(orientation: portrait)");

                if (isPortrait.matches) {
                    $('#c24-header-product-headline').text(SHORT_TITLE);
                } else {
                    $('#c24-header-product-headline').text(LONG_TITLE);
                }

            }

        },

        /**
         * disable the dental_no_maximum_refund_status_checkbox,
         * and don't allow the direct change anymore
         *
         * @param {object} checkbox the jQuery checkox element
         * @param {object} label the jQuery label element
         */
        disable_dental_no_maximum_refund_status_checkbox: function(checkbox, label) {

            label.removeClass('ui-checkbox-off').addClass('ui-checkbox-on').addClass('check-disabled');

            checkbox.prop("checked", true);
            checkbox.attr('disabled', true).attr("data-cacheval", "false");

        },

        /**
         * enable the dental_no_maximum_refund_status_checkbox,
         * and don't allow the direct change anymore
         *
         * @param {object} checkbox the jQuery checkox element
         * @param {object} label the jQuery label element
         */
        enable_dental_no_maximum_refund_status_checkbox: function(checkbox, label) {

            label.removeClass('ui-checkbox-on').removeClass('check-disabled').addClass('ui-checkbox-off');

            checkbox.prop("checked", false);
            checkbox.attr('disabled', false).attr("data-cacheval", "true");

        },

        /**
         * set the status of the dental_no_maximum_refund_status checkox
         * based on the dental option
         */
        set_c24api_dental_no_maximum_refund_status: function() {

            var _this = this;

            var PREMIUM = 'premium';

            var $dental = $('#c24api_dental_input');

            var ID = 'c24api_dental_no_maximum_refund';
            var $related_checkbox = $("#" + ID);
            var $related_checkbox_label = $("label[for='" + ID + "']");

            if($dental.val() == PREMIUM) {
                _this.disable_dental_no_maximum_refund_status_checkbox($related_checkbox, $related_checkbox_label);
            } else {
                _this.enable_dental_no_maximum_refund_status_checkbox($related_checkbox, $related_checkbox_label)
            }

            // if the user selects the dental premium option
            $dental.change(function() {
                if($dental.val() == PREMIUM) {
                    _this.disable_dental_no_maximum_refund_status_checkbox($related_checkbox, $related_checkbox_label);
                } else {
                   _this.enable_dental_no_maximum_refund_status_checkbox($related_checkbox, $related_checkbox_label)
                }

            });

        },

        /**
         * set the needed parameters in browser history in order
         * to prefill the Input1 form, if the user uses the back button
         */
        adjust_input1_browser_history: function() {

            var _this = this;
            var data = 'c24api_product_id=21'+
                '&c24api_paymentperiod=month';

            $.each(browserhistory, function(key, element){

                var input = $('#' + element);
                var value;

                if (input.length > 0) {
                    value = input.val();
                } else {
                    value = _this.get_url_parameter(key);
                }

                if (key == 'deviceoutput' && !value) {
                    value = 'mobile';
                }

                data += '&' + key + '=' + encodeURIComponent(value);
            });

            //In case of the validation error input 2 param shouldn't be added to url

            if (window.location.href.indexOf('c24_change_options') !== -1 && $('#error_flag').length == 0) {
                data += '&c24_controller=form&c24_calculate=x&c24api_calculationparameter_id=&c24api_rs_lang=&c24_change_options=' + encodeURIComponent('Suche verfeinern');
            }

            history.replaceState({}, "input1", '/pkv/benutzereingaben/?' + data);

        },

        /**
         * check if the passed parameter (sParam) exists in the GET query string
         *
         * @param {string} sParam the paramenter name to be checked
         * @returns {string|null}
         */
        get_url_parameter: function(sParam) {

            var sPageURL = window.location.search.substring(1);
            var sURLVariables = sPageURL.split('&');

            for (var i = 0; i < sURLVariables.length; i++) {

                var sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] == sParam) {
                    return sParameterName[1];
                }

            }

        },

        /**
         * Action on eventlistener: Keypress, reference so that it can be referred to. e.g. detaching event.
         * shows the label, when user types value and hides label, when there is no value in the source.
         * @param {HTMLElement} The Source Element, on which the event has occured
         * @param {jQuery.Event} The Event Element that has been triggered on the element
         */
        eventlistener_keypress: function(element, event) {

            if ($(element).val() == '') {
                $('#' + $(element).data('headline')).removeClass('c24-input-title-visible');
            } else {
                $('#' + $(element).data('headline')).addClass('c24-input-title-visible');
            }

        },

        /**
         * Action on eventlistener_blur, reference so that it can be referred to. e.g. detaching event.
         * hides the label, when the input is not focused.
         * @param {HTMLElement} The Source Element, on which the event has occured
         * @param {jQuery.Event} The Event Element that has been triggered on the element
         */
        eventlistener_blur: function(element, event) {

            if ($(element).val() == '') {
                $('#' + $(element).data('headline')).removeClass('c24-input-title-visible');
            }

        },

        /**
         * Save the last clicked tariff name in Local Storage, on click of result row
         *
         * @param $result_row       The clicked result row
         */
        set_clicked_tariff_name: function ($result_row) {

            var $link = $result_row.children(".scroll-anchor").first();

            if ($link.length == 1 && $link.attr("name")) {
                localStorage.setItem(mobileLastTariff, $link.attr("name"));
            }

        }

    };

})(jQuery);
