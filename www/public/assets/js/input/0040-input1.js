(function(){

    var ns = namespace("c24.check24.input1");

    "use strict";

    var INPUT1_VALIDATIONS = {
        c24api_birthdate: {
            birthdate: "Bitte geben Sie das Geburtsdatum der zu versichernden Person an."
        },
        c24api_insure_sum: {
            numericality: {error_message: "Die Versicherungssumme muss zwischen 5.000 € und 5.000.000 € liegen.", min: 5000, max: 5000000}
        },
        c24api_insure_period: {
            insurance_period: $("#c24api_birthdate").length ? $.get_age_from_date($("#c24api_birthdate").val()) : 0
        },
        c24api_occupation_name: {
            presence: "Bitte wählen Sie einen Beruf aus der Liste."
        }
    };



    ns.load = function (ajax_url) {

        this.url = ajax_url;

        ns.load.instances.push(this);
        this.instanceNum = ns.load.instances.length - 1;

        this.init();

        this.ajax_result = null;

    };

    ns.load.instances = [];

    ns.load.prototype = {

        init: function () {

            var _this = this;

            try {

                $.extend($.ui.autocomplete.prototype, {
                    _renderItem: function (ul, item) {

                        var replace_statement = "<b>$&</b>";

                        var term = this.element.val();
                        var term_alternative = _this.replace_umlaut(term);
                        var term_alternative2 = _this.remove_umlaut(term);

                        var html = item.label.replace(new RegExp(_this.term_escape(term), 'gi'), replace_statement);
                        if (term_alternative != term) {
                            html = html.replace(new RegExp(_this.term_escape(term_alternative), 'gi'), replace_statement);
                        }
                        if (term_alternative2 != term) {
                            html = html.replace(new RegExp(_this.term_escape(term_alternative2), 'gi'), replace_statement);
                        }

                        var res = $("<li></li>")
                            .data("item.autocomplete", item)
                            .append($("<a></a>").html(html))
                            .appendTo(ul);

                        return res;
                    }
                });


                $('.js_autocomplete').keyup(function() {
                    if ($(this).val() == '' || $(this).val().trim() != $('#c24api_occupation_name').val()) {
                        $('#c24api_occupation_id').val('');
                        $('#c24api_occupation_name').val('');
                    }
                });

                $('.js_autocomplete').autocomplete({
                    appendTo: "#occupation-result",
                    autoFocus: true,
                    minLength: 2,
                    delay: 300, // Daniele choosed 300 as a good balance between user feedback and avoiding to many requests
                    source: function (request, response) {

                        $.ajax({
                            url: c24.routing.getUrl('ajax_json_occupation', {':snippet': encodeURIComponent(request.term), ':limit': 7}),
                            dataType: 'JSON',
                            async: true,
                            type: 'GET',

                            success: function (data, textStatus, xhr) {

                                data = data.content.data;

                                var results = [];

                                if (data && data.length > 0) {

                                    jQuery.each(JSON.parse(data), function (index, content) {
                                        // Append to results to show in list
                                        results.push({
                                            'id': content[0],
                                            'label': content[1],
                                            'value': content[1]
                                        });
                                    });
                                }
                                // Callback
                                response(results);
                            }

                        });

                    },
                    select: function (event, ui) {
                        // Fill these fields too
                        $('#c24api_occupation_id').val(ui.item.id);
                        $('#c24api_occupation_name').val(ui.item.value);

                        // Clear error
                        $(this).parents('.mod24FormRow').find('.c24-form-error-message').not('#occupation_error').remove();
                    },
                    change: function() {
                        // Clear id and name if value is empty
                        if(!$(this).val()) {
                            $('#c24api_occupation_id').val('');
                            $('#c24api_occupation_name').val('');
                        }
                    }
                });

            } catch (e) {
            }


            if (window.deviceoutput == "desktop") {

                $('#resultform input').on('change keyup blur', function () {
                    if (!INPUT1_VALIDATIONS[$(this).attr('name')]) {
                        return;
                    }

                    return (new c24.validator).validateField($(this), INPUT1_VALIDATIONS[$(this).attr('name')]);
                });
            }

            $(".js-c24-form-submit").click(function () {
                _this.recalc_new();

                return false;

            });

            $('#c24api_insure_period').number( true, 0, '', '' );

            var _insure_sum = $('#c24api_insure_sum');

            _insure_sum.val(_this.numberWithCommas(_insure_sum.val()));

            _insure_sum.keyup(function() {

                var insure_sum = _this.cleanupNumber($(this).val());

                var insure_sum_formatted = _this.numberWithCommas(insure_sum);
                $(this).val(insure_sum_formatted);

            });

            $('input[name=c24api_protectiontype]').change(function () {
                _this.check_protectiontype();
            });

            $("#input-container").find("[type='date'], input[type='text']").keypress(function(event) {
                if (event.keyCode == 13) { // enter button
                    $('#c24_form_submit').click();
                }
            });

            c24.fieldsanitizer.register($('#c24api_occupation_name'), /[^A-Z.,äöüÄÜÖ\s]/ig);
        },

        'numberWithCommas' : function(n) {
            var parts = n.toString().split(',');
            return parts[0].replace(/\B(?=(\d\d\d)+(?!\d))/g, '.') + (parts[1] ? ',' + parts[1] : '');
        },

        /**
         * Clean a string and removes all non number character
         */
        'cleanupNumber' : function(n) {
            return n.replace(/[^0-9]/g, '');
        },

        // Checks the protection type and then set the correct parameter for the calculation request.
        'check_protectiontype' : function(){

            if ($("#c24api_protectiontype_input").val() == 'constant') {
                $("#c24api_paymentperiod").val('month')
                $("#c24api_constant_contribution").val('no');
            } else {
                $("#c24api_paymentperiod").val('year');
                $("#c24api_constant_contribution").val('yes');
            }

        },

        'replace_umlaut' : function(value) {

            var replaced = value.replace('ä', 'ae').replace('Ä', 'Ae');
            replaced = replaced.replace('ö', 'oe').replace('Ö', 'Oe');
            replaced = replaced.replace('ü', 'ue').replace('Ü', 'Ue');

            return replaced;

        },

        'remove_umlaut' : function(value) {

            var replaced = value.replace('ä', 'a').replace('Ä', 'A');
            replaced = replaced.replace('ö', 'o').replace('Ö', 'O');
            replaced = replaced.replace('ü', 'u').replace('Ü', 'U');

            return replaced;

        },

        'term_escape': function(term) {
            return term.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
        },

        'normalizeBirthdateField': function($input_element) {
            // Remove leading 0 for birthday format like: 01.011.2014
            // and set date 11  with new correct date format
            // (add leading 0 for birthdays like 1.1.2014)

            var parms = $input_element.val().split(/[\.\-\/]/);
            var yyyy = parseInt(parms[2], 10);
            var mm = parseInt(parms[1], 10);
            var dd = parseInt(parms[0], 10);

            if (dd < 10) {
                dd = '0' + dd;
            }

            if (mm < 10) {
                mm = '0' + mm;
            }

            $input_element.val(dd + '.' + mm + '.' + yyyy);
        },

        "validate_inputs": function() {

            var _this = this;
            var validator = new c24.validator;
            var datetools = new c24.datetools;

            validator.validate_numericality($("#c24api_insure_sum"), {error_message: 'Die Versicherungssumme muss zwischen 5.000 € und 5.000.000 € liegen.', min: 5000, max: 5000000});
            var $birthday_input = $("#c24api_birthdate");
            var date_field_type = $birthday_input.attr('type');

            if (date_field_type == 'date') {

                $birthday_input.prop('type', 'text');
                $birthday_input.val(datetools.date_to_de_format($birthday_input.val()));

            }

            var valid_birthdate = validator.validate_birthdate($birthday_input);

            if(valid_birthdate){
                this.normalizeBirthdateField($birthday_input);
            }

            var age =  $.get_age_from_date($birthday_input.val());

            validator.validate_insurance_period($("#c24api_insure_period"), age);
            validator.validate_presence($("#c24api_occupation_name"), 'Bitte wählen Sie einen Beruf aus der Liste.');

            if (validator.has_errors()) {

                var error_headline = $('#c24-error-headline');
                error_headline.show();
                $('html, body').animate({ scrollTop: (error_headline.offset().top - 10)}, 'slow');

                if (date_field_type == 'date') {

                    $birthday_input.val(datetools.date_to_en_format($birthday_input.val()));
                    $birthday_input.prop('type', 'date');

                }

            } else {
                $('#c24-error-headline').hide();
            }

            return validator.has_errors();

        },

        "recalc_new": function(){
            var _this = this;

            _this.check_protectiontype();
            var has_errors = _this.validate_inputs();

            if (has_errors) {
                return false;
            }

            this.show_spinner();
            var form_data = $("#resultform").serialize();
            var calculation_url = '/pkv/vergleichsergebnis/?' + form_data;
            _this.adjust_browser_history();

            // ajax call is needed, on direct redirection with document.location the spinner is freezed on mobile devices
            if (window.deviceoutput != "desktop") {

                _this.ajax_result = $.ajax({
                    // TODO: insert url from other position
                    url: '/pkv/vergleichsergebnis/?' + form_data,
                    async: true,
                    type: 'GET',
                    data: form_data,
                    success: function (data, textStatus, xhr) {

                        document.location = calculation_url;

                    }
                });

            } else {

                document.location = calculation_url;

            }

        },

        adjust_browser_history: function () {
            var data = 'c24api_protectiontype=' + $("#c24api_protectiontype_input").val() +
                '&c24api_insure_sum=' + $("#c24api_insure_sum").val() +
                '&c24api_insure_period=' + $("#c24api_insure_period").val() +
                '&c24api_smoker=' + $("#c24api_smoker_input").val() +
                '&c24api_occupation_name=' + encodeURIComponent($("#c24api_occupation_name").val()) +
                '&c24api_occupation_id=' + $("#c24api_occupation_id").val() +
                '&c24api_birthdate=' + $("#c24api_birthdate").val();

            history.pushState({}, "input1", c24.routing.getUrl('input1') + '?' + data);
        },

        show_spinner: function () {

            var left = ( $(document).width() / 2 ) - ( $(".result_loader").width() / 2);

            if ($.browser.msie && parseFloat($.browser.version) < 8) {
                $(".result_loader").css("left", left + " px");
                $(".result_loader").css("top", "50px");
            }

            $("#input_header").hide();
            $("#result_page, .pkv_loader").show();
        },

        init_storages: function (ignore_insure_sum, form_id) {

            var ignore_elements = [];

            if (ignore_insure_sum) {
                ignore_elements.push('c24api_insure_sum');
            }

            var storage_resultform = new c24.check24.storage.pv.pkv.load('local', form_id, ignore_elements);

            var cookie_element_names = {
                'c24api_birthdate': 'c24_common_vertical_birthday',
                'c24api_occupation_name': 'c24_common_vertical_occupation',
                'c24api_smoker': 'c24_common_vertical_smoker'
            };

            var check24_cookies = new c24.check24.globalcookie.pv.pkv.load('resultform', cookie_element_names);

        }

    }

})();