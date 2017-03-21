(function(namespace_to_construct){
    "use strict";

    function validator() {
        this.error_count = 0;
        this.input_error = new c24.check24.input.error.load();
    }

    /**
     * Runs multiple validations
     *
     * @param validations
     */
    validator.prototype.validate = function(validations) {
        var _this = this;

        $.each(validations, function(input_id, validators) {
           var $input_element = $('#' + input_id);
           var has_error = false;

            $.each(validators, function(name, error_message) {

                if(typeof _this["validate_"+name] != 'function') {
                    return;
                }

                has_error =  _this["validate_"+name]($input_element, error_message);

                if(has_error){ // Only show the first error message
                    _this.input_error.removeError($input_element, error_message);
                    return;
                }
            });
        });
    };

    /**
     * Run single validation
     * @param input_element
     * @param validators
     */
    validator.prototype.validateField = function($input_element, validators) {
        var _this = this;

        var has_error = false;

        $.each(validators, function(name, error_message) {

            if(typeof _this["validate_"+name] != 'function') {
                return;
            }

            has_error =  _this["validate_"+name]($input_element, error_message);

            if(has_error){ // Only show the first error message
                _this.input_error.removeError($input_element, error_message);
                return;
            }

            has_error = false;
        });
    };

    validator.prototype.validate_email = function($input_element, error_message) {

        var email_regex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i;
        var has_error = !email_regex.test($input_element.val());

        return this.update_element($input_element, has_error, error_message);

    };

    validator.prototype.validate_confirmation = function($input_element, error_message)
    {
        var refObject = $('[name="'+$($input_element).data('ref')+'"]');
        var has_error = (refObject.val() != $input_element.val());

        // update reference object too on bidi-reference
        if(refObject.data('ref').length) {
            this.update_element(refObject, has_error, error_message);
        }
        return this.update_element($input_element, has_error, error_message);
    };


    validator.prototype.validate_numericality = function($input_element, validate) {
        var input_value = $input_element.val().replace(/\./g, '');
        var value = parseInt(input_value);
        var has_error = isNaN(value);

        if(typeof(validate.min) != "undefined") {
            has_error = has_error || value < validate.min;
        }

        if(typeof(validate.max) != "undefined"){
            has_error = has_error || value > validate.max;
        }

        return this.update_element($input_element, has_error, validate.error_message);
    };

    validator.prototype.validate_presence = function($input_element, error_message) {
        var has_error = !$input_element.val();
        return this.update_element($input_element, has_error, error_message);

    };

    validator.prototype.validate_insurance_period = function($input_element, age) {
        var valid_period = this.validate_numericality($input_element, {error_message: 'Die Laufzeit muss zwischen 5 und 50 Jahren liegen.',  min: 5,  max: 50});
        if(!valid_period)
            return false;

        var max_age_exceeded = (age + parseInt($input_element.val())) > 75;
        return this.update_element(
            $input_element,
            max_age_exceeded,
            'Das maximale Endalter bei Vertragsende beträgt 75 Jahre. Bitte verringern Sie die Vertragslaufzeit.'
        );
    };

    validator.prototype.validate_birthdate = function($input_element) {

        var birthdate = $.check_date($input_element.val());
        var age = $.get_age_from_date($input_element.val());
        var has_error = false;
        var error_message = '';

        if (!birthdate) {
            has_error = true;
            if ($input_element.val() == '') {
                error_message = 'Bitte geben Sie das Geburtsdatum der zu versichernden Person an.';
            } else {
                error_message = "Bitte geben Sie Ihr Geburtsdatum im Format 'TT.MM.JJJJ' an.";
            }
        } else if (age < 18) {
            has_error = true;
            error_message = 'Leider können unter 18 Jahre alte Personen keine Risikolebensversicherung abschließen.';
        }

        return this.update_element($input_element, has_error, error_message);
    };

    validator.prototype.update_element = function($input_element, has_error, error_message) {
        if(has_error){
            this.add_error($input_element, error_message);
        } else {
            this.input_error.removeError($input_element, error_message);
        }
        return !has_error;
    };

    validator.prototype.has_errors = function() {
        return this.error_count > 0;
    };

    validator.prototype.add_error = function($input_element, error_message) {
        this.input_error.addError($input_element, error_message);
        this.error_count++;

    };
  (namespace(namespace_to_construct, $.noop, {
        validator: validator
    }));
})("c24");