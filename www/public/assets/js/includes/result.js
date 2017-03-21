$(document).ready(function(){

    var result_row = '.c24-result-row';

    $.rs.mobilesite.init_radio();

    $.rs.mobilesite.set_c24api_dental_no_maximum_refund_status();

    // The result-url is used when clicking the "Compare this tariff with another" link and in detail compare as back link
    window.localStorage.setItem('result-url', $("[data-role=page]").data('url'));

    $(result_row).click(function(){
        $.rs.mobilesite.set_clicked_tariff_name($(this));
    });

    /**
     * Last tariff clicked on in the result listing, if we have one we'll scroll to it min. once
     * @type {string|undefined}
     */
    var last_tariff = localStorage.getItem("c24_mobile_last_tariff");

    if (last_tariff) {

        var e = $('a[name="' + last_tariff + '"]');
        var pad = 84;
        var cmp = namespace("c24.vv.pkv.widget.result.compare");

        // The "Select 2 Tariffs for comparison" hint pushes the content down, the following adjusts for this
        if ($(cmp.hint).is(":visible")) {
            pad = 44;
        }

        if (e.length && document.location.pathname.indexOf("pkv/vergleichsergebnis") != -1) {

            $('html, body').animate({
                scrollTop: e.offset().top - pad
            }, 200);

            localStorage.removeItem("c24_mobile_last_tariff");

        }

    }

    if($("#resultform .c24-content-row-error").length > 0) {
        $("#filter_tab").click();
    }

    // Set Filter button inactive

    $('#resultform_filter_submit_btn').on('click touchend', function(e) {

        var element = $(this);

        element.css('background-color','#cdcdcd');
        element.addClass('disabled');

        var is_safari = detect_mobileBrowser() == 'safari';

        if (is_safari) {

            setTimeout(function(){
                $('#resultform').submit();
            }, 200);

        } else {
            $('#resultform').submit();
        }

    });

    // Trigger the Filter tab
    $("#open_filter_trigger").click(function(){
        $("#filter_tab").click();
    });

    $(".change-filter-info , .c24-filter-header-info").click(function(){

        c24.vv.pkv.widget.result.compare.exchange_active_tab($("#filter_tab"));
        $("#result-container").hide();
        $("#filter-container").show();
        $(".change-filter-info").addClass('not_show');

    });

    $("#result_tab").click(function(){

        c24.vv.pkv.widget.result.compare.exchange_active_tab($(this));
        $("#filter-container").hide();
        $("#result-container").show();
        $(".change-filter-info").removeClass('not_show');

    });

    $("#filter_tab").click(function(){

        c24.vv.pkv.tracking.piwik.trackEvent('Filter Result', 'open' , 'Filter');
        c24.vv.pkv.widget.result.compare.exchange_active_tab($(this));
        $("#filter-container").show();
        $("#result-container").hide();
        $(".change-filter-info").addClass('not_show');

    });

    var protection_type = $('input[name=c24api_protectiontype]').val();

    if (protection_type == 'constant') {

        $(".filter_constant").show();
        $(".filter_falling").hide();
        $("#insure_sum_falling_tooltip").hide();
        $("#insure_sum_constant_tooltip").show();
        $(".change-filter-info").addClass('not_show');


    } else {

        $(".filter_constant").hide();
        $(".filter_falling").show();
        $("#insure_sum_falling_tooltip").show();
        $("#insure_sum_constant_tooltip").hide();

    }


    $( "#tabs" ).tabs({
        beforeActivate: function( event, ui ) {
            if ($("#resultform").data('changed')) {
                $("#popupFilterConfirmation" ).popup( "open" );
                return false;
            }
        }
    });

    $("#confirm_filter_btn").click(function(){
        $("#popupFilterConfirmation" ).popup( "close" );
    });

    $("#discard_filter_btn").click(function(){
        $("#resultform").data('changed', false);
        $('#result_tab').click();
        $("#resultform")[0].reset();
        $("#popupFilterConfirmation" ).popup( "close" );

        // After we reset the form we need to format again the insure
        // sum to get the thousand separator.

        $('#c24api_insure_sum').val(numberWithCommas(sum));

    });

    // formats number on page load
    var sum = $('#c24api_insure_sum').val();

    $( "#popupFilterConfirmation" ).popup({
        afterclose: function( event, ui ) {
            if ($("#resultform").data('changed')) {
                $("#resultform").submit();
            }
        }
    });

    $('#c24api_insure_sum').val(numberWithCommas(sum));

    $('#c24api_insure_sum').focusout(function() {

        var insure_sum = cleanupNumber($(this).val());

        var insure_sum_formatted = numberWithCommas(insure_sum);
        $(this).val(insure_sum_formatted);

    });

    $("#resultform input , #resultform select").change(function() {
        $("#resultform").data('changed', true);
    });

});