(function ($){

    if (!$.android_birthdate) {
        $.android_birthdate = {};
    }

    $.android_birthdate.input1 = {

        /* get the default birthdate field from inoput 1 */
        get_default_birthdate_field: function() {
            return $('#c24api_birthdate');
        },

        /**
         * Is the insured person a child?
         *
         * @returns {boolean}
         */
        is_child: function() {
            return $('#c24api_insured_person_input').val() === 'child';
        },

        /* update the default birthdate field with the value composed from the android birthdate fields */
        update_default_birthdate_field_value: function() {

            var $default_birthdate = this.get_default_birthdate_field();

            var day_value   = $('#c24api_birthdate_day').val();
            var month_value = $('#c24api_birthdate_month').val();
            var year_value  = $('#c24api_birthdate_year').val();

            /* in case of a submit to input 2 */
            if(day_value === undefined || month_value === undefined || year_value === undefined) {

                day_value = get_url_param('c24api_birthdate_day');
                month_value = get_url_param('c24api_birthdate_month');
                year_value = get_url_param('c24api_birthdate_year');
            }

            var date_android = year_value + '-' + month_value + '-' + day_value;

            /* strict validation by given pattern */
            if(moment(date_android, "YYYY-MM-DD", true).isValid()) {
                $default_birthdate.val(date_android);
            }

        },

        /* Toggle between the default birthdate container and android birthdate container */
        toggle_default_android_birthdate_fields: function() {

            if (is_android_mobile_device()) {
                $('#c24api_birthdate_container_android').show();
                $('#c24api_birthdate_container').hide();
            } else {
                $('#c24api_birthdate_container_android').hide();
                $('#c24api_birthdate_container').show();
            }

        },

        /**
         * Get the android date birthdate fields identifiers
         *
         * @returns {{day: string, month: string, year: string}}  Birthdate fields
         */
        get_birthdate_fields: function() {

            return {
                day: 'c24api_birthdate_day',
                month: 'c24api_birthdate_month',
                year: 'c24api_birthdate_year'
            };

        },

        /**
         * If there is an error we have to show it to our container too
         *
         * If we have data on the default birthdate field, we fill the corespondent
         * android fields with the related values
         */
        fill_default_values: function() {

            var birthdate_fields = this.get_birthdate_fields();
            $.each(birthdate_fields, function(index, identifier) {

                var url_val = get_url_param(identifier);
                if(url_val) {
                    $('#' + identifier).val(url_val);
                }

            });

            var $default_birthdate = this.get_default_birthdate_field();
            var default_birthdate_container_id =  '#c24api_birthdate_container';
            var android_birthdate_container_id =  '#c24api_birthdate_container_android';

            /**
             * If the default birthdate has an error message,
             * we display it to the android birthdate fields
             */
            if ($(default_birthdate_container_id).hasClass('c24-content-row-error')) {

                var default_birthdate_error_msg = $(default_birthdate_container_id + ' div.c24-content-row-block-errorbox').html();

                $(android_birthdate_container_id).addClass('c24-content-row-error');
                $('.android_fields .ui-input-text').addClass('has-error');
                $(android_birthdate_container_id +' div.c24-content-row-block-errorbox').text(default_birthdate_error_msg);

            }

            if ($default_birthdate.val()) {

                var default_date_parts = $default_birthdate.val().split("-");
                $('#c24api_birthdate_day').val(default_date_parts[2]);
                $('#c24api_birthdate_month').val(default_date_parts[1]);
                $('#c24api_birthdate_year').val(default_date_parts[0]);

            }

        },

        /**
         * It controls the behavior of the android birthdate fields,
         * in order to ensure as much as possible correct inputs
         */
        control_input_fields_behavior: function() {

            var _this = this;

            // fill values and show errors if neccessary
            this.fill_default_values();

            this.allow_only_numbers();

            var birthdate_fields = this.get_birthdate_fields();

            $.each(birthdate_fields, function(index, identifier) {

                var field = $('#' + identifier);
                var field_val = field.val();
                var field_length = field_val.length;

                //select the entire value
                field.click(function() {

                    //be sure that the numeric keyboard comes not over the input fields
                    var base_element = $('#c24api_birthdate_container_android label');
                    $.mobile.silentScroll(base_element.offset().top);
                    $(this).select();

                });

                switch(index) {

                    case 'day':

                        /* days who need leading zero */
                        var day_arr = [ 4,5,6,7,8,9 ];

                        _this.control_field_behavior(identifier, day_arr, 2, 31, birthdate_fields.month);

                        break;

                    case 'month':

                        field.click(function() {
                            _this.add_leading_zeros(birthdate_fields.day);
                        });

                        /* months who need leading zero */
                        var month_arr = [ 2,3,4,5,6,7,8,9 ];

                        _this.control_field_behavior(identifier, month_arr, 2, 12, birthdate_fields.year);

                        break;

                    case 'year':

                        var today = new Date();
                        var actual_year = today.getFullYear();
                        var actual_short_year = actual_year.toString().substr(2,4);

                        field.click(function() {
                            _this.add_leading_zeros(birthdate_fields.month);
                        });

                        field.keyup(function() {

                            if($(this).val().length === 2 && $(this).val() != '19') {
                                if($(this).val() != '20') {
                                    if($(this).val() > actual_short_year) {
                                        $(this).val('19' + $(this).val());
                                    } else {
                                        $(this).val('20' + $(this).val());
                                    }
                                }
                            } else if($(this).val().length === 4 && parseInt($(this).val()) > actual_year){
                                $(this).val('').select();
                            } else if($(this).val().length > 4){
                                $(this).val($(this).val().substr(0,4));
                            }

                            _this.remove_error_message_if_needed();

                        });

                        break;
                }

            });

        },

        /**
         * It ensures us that the user can use only numbers inside the android birthdate input fields
         * This version is also Chrome compatible
         */
        allow_only_numbers: function() {

            $('.date_android').keyup(function(e) {

                var regex = /^[0-9]$/;
                var str = $(this).val();
                var subStr = str.substr(str.length - 1);

                if(!regex.test(subStr)) {

                    if(str.length >0){
                        $(this).val(str.substr(0, (str.length - 1)));
                    }else{
                        $(this).val('');
                    }

                }

            });

        },

        /**
         * It controls a specific field behavior based on the user input
         *
         * @param field_identifier       {string}  The actual selected input field id
         * @param conditional_arr        {Array}   An array which ensure specific behavior on specific input values
         * @param max_length             {int}     The maximum length of the selected field value
         * @param max_val                {int}     The maximum value accepted for this field
         * @param next_field_identifier  {string}  The next field id to be selected if everything ok
         *
         */
        control_field_behavior: function(field_identifier, conditional_arr, max_length, max_val, next_field_identifier) {

            var $field = $('#' + field_identifier);
            var $next_field = $('#' + next_field_identifier);

            $field.keyup(function() {

                //add leading zeros if necessary
                if ($field.val().length == 1 && $.inArray(parseInt($field.val()), conditional_arr) != -1) {
                    $field.val('0' + $field.val());
                }

                if ($field.val().length == max_length) {
                    if ($field.val() > max_val) {
                        $field.select();
                    } else {
                        $next_field.select();
                    }
                } else if ($field.val().length > max_length) {
                    $field.val($field.val().substr(0, 2));
                }

                $.android_birthdate.input1.remove_error_message_if_needed();

            });

        },

        /**
         * Add leading zeros to the received input value
         *
         * @param field_identifier {string}  The selected input field id
         */
        add_leading_zeros: function(field_identifier) {

            $field = $('#' + field_identifier);

            if($field.val().length == 1 && parseInt($field.val()) < 10) {
                $field.val('0' + $field.val());
            }
        },

        /**
         * If the android birthdate container has an error message,
         * and the composed birthdate is valid, we eliminate the
         * error message
         */
        remove_error_message_if_needed: function() {

            var android_birthdate_container_id =  '#c24api_birthdate_container_android';

            if ($(android_birthdate_container_id).hasClass('c24-content-row-error')) {

                var day_value   = $('#c24api_birthdate_day').val();
                var month_value = $('#c24api_birthdate_month').val();
                var year_value  = $('#c24api_birthdate_year').val();

                var date_android = year_value + '-' + month_value + '-' + day_value;

                /* strict validation by given pattern */
                if(moment(date_android, "YYYY-MM-DD", true).isValid()) {
                    $(android_birthdate_container_id).removeClass('c24-content-row-error');
                    $('.android_fields .ui-input-text').removeClass('has-error');
                    $(android_birthdate_container_id +' div.c24-content-row-block-errorbox').text();
                }

            }

        }


    };

})(jQuery);
