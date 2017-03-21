(function(namespace_to_construct){
    "use strict";

    var device_type, mobile_url;

    var template = '<div class="mobile_switch_bg">' +
        '<div class="mobile_switch_box">' +
            '<div class="mobile_switch_content clearfix">' +
                '<h1><i class="fa fa-mobile"></i></h1>' +
                '<p>Sie werden auf die Mobile Webseite weitergeleitet. Möchten Sie fortfahren?</p>' +
                '<p><a id="msn" class="sayno c24-button inactive">Nein, Danke</a><a id="msy" class="c24-button">Ja</a></p>' +
            '</div>' +
        '</div></div>';

    /**
     *
     * @private
     */
    function _open_popup()
    {

        var body_min_width = $('body').css('min-width');

        $('body').css('min-width', '100%');
        $('body').prepend(template);
        $("#c24-page-and-ads").hide();

        $('#msn').on('click', function() {

            Cookies.set('c24stm', 'no');
            $('.mobile_switch_bg').remove();
            $('body').css('min-width', body_min_width + 'px');
            $("#c24-page-and-ads").show();

        });

        $('#msy').on('click', function() {

            Cookies.set('c24stm', 'yes');
            location.href = '//' + mobile_url;

        });

    }

    (function(ns){
        ns.init();
    })(namespace(namespace_to_construct, $.noop, {

        init: function(){
            this.show();
        },
        show: function() {
            $(document).ready(function(){
                // phone is the WURFL device_type
                if(device_type == 'phone' && !Cookies.get('c24stm')) {
                    _open_popup();
                } else if(Cookies.get('c24stm') === 'yes') {
                    location.href = '//' + mobile_url;
                }
            });
        },
        set_device_type: function(deviceType) {
            device_type = deviceType;
        },
        set_mobile_url: function(mobileUrl) {
            mobile_url = mobileUrl;
        }
    }));
})("c24.redirect");