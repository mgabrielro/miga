(function($) {

    // IE legacy fix!

    if (!Array.indexOf) {
        Array.prototype.indexOf = function(obj) {
            for(var i = 0; i < this.length; i++) {
                if(this[i] === obj){
                    return i;
                }
            }
            return -1;
        };
    }

    // Plugin code

    $.fn.passwordStrength = function(o) {

        var $this = $(this);

        $this
            .bind('change', {elm: $this, options: o}, function(e) {
                check(e.data.elm, e.data.options);
            })
            .bind('keyup', {elm: $this, options: o}, function(e) {
                check(e.data.elm, e.data.options);
            });

        o.email
            .bind('change', {elm: $this, options: o}, function(e) {
                check(e.data.elm, e.data.options);
            })
            .bind('keyup', {elm: $this, options: o}, function(e) {
                check(e.data.elm, e.data.options);
            });

        var check = function(elm, o) {

            /* element value = password */

            var val = elm.val();

            /* a minimum of 6 characters if required to pass form-validation */

            if (val.length < 6) {
                renderState(0);
                return;
            }

            /* Check email: Email should not used as password */

            if (o.email.val().length > 0 && val.length >= 6) {

                var email = o.email.val();

                if (email.toLowerCase() == val.toLowerCase()) {
                    renderState(1);
                    return;
                }

                if (val.toLowerCase().indexOf(email.toLowerCase()) != -1) {
                    renderState(1);
                    return;
                }

                var atindex = email.indexOf('@');

                var localpart = email.substring(0, atindex);
                var domain = email.substring((atindex + 1), email.length);

                val = val.replace(new RegExp(localpart, "g"), '');
                val = val.replace(new RegExp(domain, "g"), '');
            }

            // define invalid sequences ('' = separator)

            var sequence1 = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '',
                'q', 'w', 'e', 'r', 't', 'z', 'u', 'i', 'o', 'p', 'ü', '',
                'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'ö', 'ä', '',
                'y', 'x', 'c', 'v', 'b', 'n', 'm', '',
                'Q', 'W', 'E', 'R', 'T', 'Z', 'U', 'I', 'O', 'P', 'Ü', '',
                'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Ö', 'Ä', '',
                'Y', 'X', 'C', 'V', 'B', 'N', 'M'];
            var sequence2 = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
                'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '',
                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
                'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
            var dictonary = [
                'ficken',
                'passwort',
                'schatz',
                'sommer',
                'frankfurt',
                'daniel',
                'nadine',
                'password',
                'passwort1',
                'password1',
                'iloveyou',
                'check24',
                'check2412',
                'CHECK24',
                'Check24',
                'admin',
                'letmein',
                'monkey',
                'shadow',
                'sunshine',
                'princess',
                'trustno1',
                'testplan12',
                'testplan',
                'testplan1'
            ];

            /* test TÜV criteria */

            var val_length      = val.length;
            var seq_length      = Math.max(sequence_length(val, sequence1), sequence_length(val, sequence2), sequence_length(val, sequence1.reverse()), sequence_length(val, sequence2.reverse()));
            var has_lower       = (val.match(/[a-z]+/) == null ? false : true);
            var has_upper       = (val.match(/[A-Z]+/) == null ? false : true);
            var has_numeric     = (val.match(/[0-9]+/) == null ? false : true);
            var has_special     = (val.match(/[\_\^\°\!\"\§\$\%\&\/\(\)\=\?\\\{\[\]\}\*\+\~\#\,\.\;\:\|\<\>]+/) == null ? false : true);
            var num_distinct    = distinct_letters(val);
            var three_same      = (val != val.replace(/([a-z0-9])\1{3,}/ig, "$1$1$1"));
            var has_trivial     = find_trivial(val);
            var in_dictionary   = is_in_dictonary(val, dictonary);
            var has_dict_match  = match_dictonary(val, dictonary);

            /* assemble criteria */

            var sufficient  =               (val_length >= 6 && seq_length < 3 && num_distinct >= 3 && !in_dictionary);
            var strong      = sufficient && (val_length >= 8 && num_distinct >= 3 && (has_upper || has_lower) && (has_numeric || has_special) && !three_same && !has_trivial && !has_dict_match);
            var very_strong = strong &&     (val_length >= 8 && ( (has_upper && has_lower && has_numeric) || (has_numeric && (has_upper || has_lower) && has_special)) );

            if (very_strong == true) {
                renderState(4);
            } else if (strong == true) {
                renderState(3);
            } else if (sufficient == true) {
                renderState(2);
            } else {
                renderState(1);
            }
        };

        var levelMapping = [
            {text: 'zu kurz', color: 'red', multiplier: 0},
            {text: 'zu schwach', color: 'red', multiplier: 1},
            {text: 'ausreichend', color: 'orange', multiplier: 2},
            {text: 'stark', color: '#0077b3', multiplier: 3},
            {text: 'sehr stark', color: 'green', multiplier: 4}
        ];

        var renderState = function(level) {

            var settings = levelMapping[level];

            o.indicatorText.html(settings.text);
            o.indicatorBar.find('div').css({'width': (parseInt(o.indicatorBar.width()) / 4) * settings.multiplier + 'px', 'background-color': settings.color});
        };

        var find_trivial = function(val) {

            return (val.indexOf('1q2w3') == 0 || val.indexOf('q2w3') == 0 || val.indexOf('qaws') == 0 || val.indexOf('awse') == 0 || val.indexOf('aysx') == 0 || val.indexOf('ysxd') == 0);
        }

        /**
         * number of distinct characters in given string
         */
        var distinct_letters = function(val) {

            var letters = [ ];

            for (i = 0; i < val.length; i++) {
                if (letters.indexOf(val.charAt(i)) == -1) {
                    letters.push(val.charAt(i));
                }
            }

            return letters.length;
        }

        /**
         * check for charactes in sequence and return count
         */
        var sequence_length = function(val, sequence) {

            var firstMatchPos       = -2; // -2: not currently matching a sequence
            var lastMatchPos        = -2;
            var maxMatchLength      = 0;
            var matchLength         = 0;
            var i = 0;

            while (i < val.length) {

                var matchPos = sequence.indexOf(val.charAt(i));

                // if not matching yet, check if current character equals (last +1) or is the same character

                if (firstMatchPos == -2 || matchPos == lastMatchPos +1 || matchPos == lastMatchPos) {

                    // begin matching sequence

                    lastMatchPos = matchPos;

                    if (firstMatchPos == -2) {
                        firstMatchPos = matchPos;
                    }

                    i++;

                } else {

                    // end matching sequence

                    if (firstMatchPos > -2) {
                        matchLength = (lastMatchPos +1) -firstMatchPos;
                        if (matchLength >= 2 && maxMatchLength < matchLength) {
                            maxMatchLength = matchLength;
                            //console.log(val.substring(i -matchLength, i));
                        }
                    }

                    firstMatchPos = -2
                }
            }

            // close open sequence

            if (firstMatchPos > -2) {
                matchLength = (lastMatchPos +1) -firstMatchPos;
                if (matchLength >= 2 && maxMatchLength < matchLength) {
                    maxMatchLength = matchLength;
                    //console.log(val.substring(i -matchLength, i));
                }
            }
            return maxMatchLength;
        }

        var is_in_dictonary = function(val, dictionary) {
            return (dictionary.indexOf(val) == -1) ? false : true;
        }

        var match_dictonary = function(val, dictionary) {
            for(var i = 0; i < dictionary.length; i++) {
                if (val.match(new RegExp(dictionary[i], 'i'))) {
                    return true;
                }
            }
            return false;
        }

        check($this, o);

    }

})(jQuery);