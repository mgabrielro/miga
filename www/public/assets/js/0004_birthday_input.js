(function(namespace_to_construct){
    "use strict";

    (function(ns){

        $(document).ready(function(){
            ns.init();
        });

    })(namespace(namespace_to_construct, function(){}, {

        init: function() {

            var $birthdate_input = $('#c24api_birthdate:visible, #c24-forgotpw-form-birthday-input:visible');
            var validator = new c24.validator;
            var datetools = new c24.datetools;
            var _this = this;

            // show the datepicker only in the desktop version
            // !!! HINT !!! datepicker will change always the attribute "type" of the input field from anything to "text"
            if (window.deviceoutput == "desktop") {

                $birthdate_input.on('keyup', function (event) {
                    var unprocessed_value = $(this).val();
                    var sanitized_value = unprocessed_value.replace(/[^0-9\.]/g, '');
                    var formated_value = _this.auto_format_date(event, sanitized_value);

                    if(unprocessed_value == formated_value) {
                        return true;
                    }

                    var has_error = _this.is_date_valid(formated_value)
                        || unprocessed_value != sanitized_value;

                    validator.update_element($(this), has_error, "Bitte geben Sie Ihr Geburtsdatum im Format 'TT.MM.JJJJ' an.");

                    $(this).val(formated_value);
                });

                _this.datepicker($birthdate_input);

            } else {

                if (!$birthdate_input.val()) {
                    $birthdate_input.removeClass('notempty');
                } else {
                    $birthdate_input.addClass('notempty');
                    $birthdate_input.val(datetools.date_to_en_format($birthdate_input.val()));
                }

                // Add change event for date inputs
                $birthdate_input.on("touchstart", function() {

                    var _this = $(this);
                    var _birthdate_val = _this.val();

                    if (!_birthdate_val) {

                        _this.val(datetools.date_to_en_format(_this.data('default-date')));
                        _this.addClass('notempty');

                    }

                });

            }
        },

        auto_format_date: function (event, value) {
            // Adds dots
            if (this.is_digit_key_code(event.which)) {
                value = value.replace(/^([0-9]{2})\.?/, '$1.');
                value = value.replace(/^([0-9]{2})\.?([0-9]{2})\.?/, '$1.$2.');
            }

            // Expands shorthands for days and months ( 1.1.1970 => 01.01.1970)
            if (event.which == 190) {
                var parts = value.split('.');
                for (var i = 0; i < parts.length; i++) {

                    if (parts[i] && parts[i].length == 1) {
                        parts[i] = '0' + parts[i];
                    } else if (!parts[i] && i != parts.length - 1) {
                        parts.splice(i, 1);
                    }

                }

                value = parts.join('.').replace(/\.\./g, '.');
            }

            return value;
        },

        is_digit_key_code: function (keyCode) {
            return (48 <= keyCode && keyCode <= 57 || 96 <= keyCode && keyCode <= 105);
        },

        is_date_valid: function(date) {
            var parts = date.split('.');
            var dd = parts[0];
            var mm = parts[1];
            var yy = parts[2];

            var leapyear = (yy != undefined && yy.length == 4 ? this.is_leap_year(yy) : undefined);

            return (
                (mm != undefined && dd == 0 || dd > 31 || (mm == 2 && dd > 29))
                || (yy != undefined && mm == 0 || mm > 12)
                || (leapyear != undefined && leapyear == 0 && dd > 28)
            );
        },

        is_leap_year: function(year) {
            return ((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0);
        },

        datepicker: function($birthday_input) {
            var today = new Date();
            var selectable_years = 100;
            var validator = new c24.validator;


            $birthday_input.pickadate({
                format: 'dd.mm.yyyy',
                firstDay: true,
                formatSubmit: false,
                labelMonthNext: 'Nächster Monat',
                labelMonthPrev: 'Vorheriger Monat',
                labelMonthSelect: 'Monat wählen',
                labelYearSelect: 'Jahr wählen',
                monthsFull: ['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'],
                monthsShort: ['Jan','Feb','Mär','Apr','Mai','Jun','Jul','Aug','Sep','Okt','Nov','Dez'],
                weekdaysFull: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
                weekdaysShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
                selectMonths: true,
                selectYears: selectable_years,
                today: false,
                clear: false,
                close: false,
                save: false,
                outerClickSave: true,
                onFocusPicker: false,
                onClickPicker: false,
                editable: true,
                min: new Date(today.getFullYear() - 100, today.getMonth(), today.getDate(),'00','00'),
                max: new Date(today.getFullYear(), today.getMonth(), today.getDate(),'00','00'),
                onOpen: function() {
                    var input_container = $birthday_input.parents('.c24-input-containter');
                    var input_tooltip = input_container.parent().find('.iMod24Newtip');

                    $birthday_input.addClass('c24-datepicker-active');

                    input_container.removeClass('c24-error-input-element');
                    input_container.addClass('c24-active-input-element');

                    if (input_tooltip.is(':hidden')) {
                        $('.iMod24Newtip').hide();
                        input_tooltip.fadeIn();
                    }

                    var year = '1970';
                    var month = '00';
                    var day = '01';

                    if ($birthday_input.val()) {

                        var matches = $birthday_input.val().split(".");

                        if (matches.length >= 3) {
                            year = matches[2];
                            month = matches[1] - 1;
                            day = matches[0];
                        }

                    }

                    this.set('select', [year, month, day]); //00 Month is correct :-)

                },
                onClose: function() {
                    $birthday_input.removeClass('c24-datepicker-active');
                    validator.update_element($birthday_input, false, "Bitte geben Sie Ihr Geburtsdatum im Format 'TT.MM.JJJJ' an.");
                }
            });
        }
    }));
})("c24.birthday_input");