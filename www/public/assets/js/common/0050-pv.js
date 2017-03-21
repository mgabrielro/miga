
$(function(){
    "use strict";

    var ns = namespace("c24.check24.mobile.pv");

    ns.load = function(ajax_url) {
        this.url = ajax_url;

        ns.load.instances.push(this);
        this.instanceNum = ns.load.instances.length - 1;

        this.init();

    };

    ns.load.instances = [];

    ns.load.prototype = {

        init: function()
        {
            /* load all the necessary plugins */
            this.initialize_plugins();
        },

        initialize_plugins: function () {

            var _this = this;

            $(document).ready(function(){

                 $("#c24-page").css('visibility', 'visible');

                 $('.ui-navbar').scrollToFixed();

            });

            // We make this, because the elements are hidden so we can't calculate the height. We display it,
            // get the Height and then hide it again.

            $("#filter-container").show();

            /* Filter Buttons */
            _this.ui_filterButtons_initialize();

            $("#filter-container").hide();


            /* C24 dynamic links
            *
            *  every elements that contains a class = c24-link
            *  set the target in a data-link attribute inside the same element
            *  unless the target (clicked) element is in the data-link-exclude list
            *
            *  data-link-exclude should be a list of css classes which, when clicked
            *  will not trigger this event. this is here to prevent bubbling artificially.
            */
            $(document).on('click', '.c24-link', function(ev){

                var link = $(this).data("link");
                var disabled = $(this).data("link-disable");

                if (link == '' || disabled == true) {
                    return;
                }

                var exclude = $(this).data("link-exclude");
                var target = $(ev.target);

                if (typeof exclude == "string") {
                    exclude = exclude.split(" ");
                } else {
                    exclude = false;
                }

                if (exclude) {
                    for (var i in exclude) {
                        if (target.hasClass(exclude[i])) {
                            return;
                        }
                    }
                }

                window.location = link;

            });

            $("body").append('<div id="debug" style="position:fixed; bottom: 0; background-color:#fdf; font-size: 0.7rem; z-index:5000;"></div>');

            // Whe the user focus the Autocomplete input field, then show the Autocomplete overlay.
            $( "#c24api_occupation_name").focus( function ( e, data ) {
                _this.ui_autocomplete_show();
            });

            // When the user click on the overlay, clear the inout field and hide the overlay.
            $("#c24-blocking-layer").click(function(){
                _this.ui_autocomplete_reset();
                _this.ui_autocomplete_hide();
            });


            $( "#autocomplete" ).on( "filterablebeforefilter", function ( e, data ) {

                var $ul = $( this ),
                    $input = $( data.input ),
                    value = $input.val(),
                    html = "";
                $ul.html( "" );


                if ( value && value.length > 1 ) {

                    $ul.html( "<li><div class='ui-loader'><span class='ui-icon ui-icon-loading'></span></div></li>" );
                    $ul.listview( "refresh" );


                    $.ajax({
                        //url: _this.url,
                        url: '//' + window.location.host + '/ajax/json/occupation/' + value + '/7',
                        dataType: 'JSON',
                        async: true,
                        type: 'GET',
                        /*data: {
                            'c24_occupation_name_snippet': value,
                            'json': 'yes',
                            'action': 'occupation_name',
                            'c24_limit': 7
                        },*/
                        success: function (data, textStatus, xhr) {
                            var results = [];

                            if (data !== null) {
                                $ul.html('');

                                $.each( JSON.parse( data.content.data ), function ( i, val ) {

                                    var occupation_text = val[1];
                                    var occupation_id = val[0]

                                    var li_entry = $('<li data-icon="carat-r" class="ui-btn ui-btn-icon-right ui-icon-carat-r ui-li-has-arrow ui-li ui-btn-up-c " data-transition="fade" data-autocomplete=""' + JSON.stringify(occupation_text).replace(/"/g, "&#34;") + '">' + occupation_text + '</li>')
                                        .click(function() {

                                            $('#c24api_occupation_id').val(occupation_id);
                                            $('#c24api_occupation_name, #c24api_occupation_name_holder').val(occupation_text).blur();

                                            $ul.html('');
                                            $ul.listview("refresh");
                                            _this.ui_autocomplete_hide();

                                        });
                                    $ul.append(li_entry);

                                });

                                $ul.listview("refresh");
                                $ul.trigger("updatelayout");
                            }

                        }

                    });

                }

            });

        },

        /**
         * Show the new Autocomplete overlay
         */
        ui_autocomplete_show: function() {

            var autocomplete_layer = $("#autocomplete_overlay");
            var autocomplete_input = autocomplete_layer.find('#c24api_occupation_name_holder');
            var _this = this;

            // Show the overlay
            $("#c24-blocking-layer").show();
            autocomplete_layer.show();

            // Get the element and calculate the offset from top
            var offset = $("#c24api_occupation_name_container").offset().top - autocomplete_input.outerHeight() - 70;


            $("#autocomplete_overlay").css('padding-top', offset + 'px');

            // Change the focus from the "old" Autocomplete field to the new Autocomplete field.
            autocomplete_input.focus(function(){

                // After the overlay is shown, scroll to the new Autocomplete field.
                $('html, body').animate({ scrollTop: ($(this).offset().top - 30)}, 'slow');

            });

            autocomplete_input.focus();

            // Set the index and position to show the list "over" the Overlay.
            $(".ui-page-theme-c24 ul#autocomplete").css({'z-index': '120', 'position': 'relative'});

        },

        /**
         * Hide the Autocomplete overlay
         */
        ui_autocomplete_hide: function() {

            $("#c24-blocking-layer").hide();
            $("#autocomplete_overlay").hide();

        },

        /**
         * Reset the Autocomplete Input field.
         */
        ui_autocomplete_reset: function() {
            $("#c24api_occupation_name_holder").val('');
        },

        ui_filterButtons_initialize: function (){

            var selector = '#js-c24-result-filter-buttons-container';
            var protectiontype = $("#c24api_protectiontype").val();
            var limit = 0;
            var sticky_filter_button_initialized = false;
            var filter_container = '#filter-container';

            $('.c24-form-element-group', filter_container).on('change', function() {

                if (!sticky_filter_button_initialized) {

                    if ($(selector).length > 0) {

                        if (protectiontype == 'constant') {
                            limit = $(selector).position().top + $(selector).height() + 25;
                        } else {
                            limit = $(selector).position().top - $(selector).height() + 250;
                        }

                        $(selector).scrollToFixed({
                            bottom: 0,
                            limit: limit,
                            zIndex: 60,
                            preFixed: function()  { $(selector).addClass('filterButtons-detached')},
                            postFixed: function() { $(selector).removeClass('filterButtons-detached')}
                        });

                    }

                    sticky_filter_button_initialized = true;

                }

            });

        }

    };

    // Add change event for date inputs
    // These will add a notempty to prevent showing the
    // little css hack to display placeholder for date inputs.
    // @see common/0060-form-elements.css#1297 - input[type=date]::before{
    $('input[type=date]').change(function() {

        if ($(this).val()) {
            $(this).addClass('notempty');
        } else {
            $(this).removeClass('notempty');
        }

    });

    if ($('input[type=date]').val()) {
        $(this).addClass('notempty');
    }

    var dateevent = 'vmousedown';

    // Stupid ass ios only reacts on focus events
    if (!/iPad|iPhone|iPod/g.test(navigator.userAgent)) {
        dateevent = 'focus';
    }

    //Set a Defaultyear for date inputs for mobil
    $('input[type=date]').on( dateevent , function() {

        var date = new Date();
        var defaultyear = date.getFullYear()-30;

        if ($('#c24api_birthdate').val() == ''){

            $('#c24api_birthdate').prop('value' , defaultyear + '-01-01');
            $('#c24api_birthdate').addClass('notempty');

        }

    });

    // jQuery Mobile HACK
    // when using the browser "back-button" with the normal http protocol, some elements (e.g. radio buttons)
    // aren't accessible because of the backward-forward cache
    // a page reload fixes this currently.
    //
    // can be removed eventually when updating the jquery mobile version to a newer version
    if (typeof document.location.protocol !== 'undefined' && document.location.protocol == 'http:') {
        $(window).bind("pageshow", function (event) {
            if (typeof event.originalEvent !== 'undefined') {
                if (event.originalEvent.persisted) {
                    document.location.reload();
                }
            }
        });
    }


    $(document).ready(function($){

        var deviceAgent = navigator.userAgent;
        var is_android  = (deviceAgent.match( /Mozilla\/5.0/i )  && deviceAgent.match( /Android\s/i ));
        var is_ios      = (deviceAgent.match( /iPad/i ) || deviceAgent.match( /iPhone/i ) || deviceAgent.match( /iPod/i ));
        var is_chrome   = (deviceAgent.match( /Mozilla\/5.0/i )  && deviceAgent.match( /AppleWebKit/i ) && deviceAgent.match( /Chrome/i ));
        var is_safari   = (deviceAgent.match( /Mozilla\/5.0/i )  && deviceAgent.match( /AppleWebKit/i ) && deviceAgent.match( /Safari/i ));

        // switch css class for different browsers#
        if (is_android) {
            $("html").addClass("android");
        } else if (is_ios) {
            $("html").addClass("ios");
        } else {
            $("html").addClass("fallback_browser");  // e.g. firefox on android
        }

        if (is_chrome) {
            $("html").addClass("chrome");
        } else if (is_safari) {
            $("html").addClass("safari");
        }


    });

});
