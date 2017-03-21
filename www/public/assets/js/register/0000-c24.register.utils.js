(function(namespace_to_construct){
    "use strict";

    //-------------------"PRIVATE METHODS"--------------------
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
            this.open_tariff_change_popup();
            this.close_tariff_change_popup();
            this.change_birthdate();
        },

        check_age: function (age_input, valid_age) {
            var date = new Date();
            var parms = age_input.split(/[\.\-\/]/);
            var yyyy = parseInt(parms[2],10);
            var age = date.getFullYear() - yyyy;

            if (age < valid_age) {
                $("#insure_headline").html("Ihre Angaben (volljähriger Versicherungsnehmer)");
                $('label[for="other"]').text('Kind');
            } else {
                $("#insure_headline").html("Ihre Angaben (Versicherungsnehmer)");
            }
        },

        change_birthdate: function() {
            $('#c24_change_birthdate').click(function(){
                location.href=$(this).data('url');
            });
        },

        /**
         * open the tariff change popup for the first and second tariff
         */
        open_tariff_change_popup: function() {
            $('.js-c24-change-birthdate').click(function(){
                $(".birthdate_change_bg").show();
            });
        },

        /**
         * close the tariff change popup for the first and second tariff
         */
        close_tariff_change_popup: function() {
            $(".birthdate_change_close_button").click(function(){
                $(".birthdate_change_bg").hide();
            });
        },

        update_insure_fields: function() {

            if ($('input[name="insure"]:checked').val() == 'other') {

                $('.insure_person_block').show();
                $('div[data-key="birthdate"]').hide();
                $('#insure_person_title_single').hide();

            } else {

                $('.insure_person_block').hide();
                $('div[data-key="birthdate"]').show();
                $('#insure_person_title_single').show();

            }

        }
    }));
})("c24.register.utils");