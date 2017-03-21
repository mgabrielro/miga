/**
 * Created by sebastian.bretschnei on 17.02.2016.
 */

/**
 * Created by sebastian.bretschneider on 25.11.2015.
 */
$( document ).ready(function() {

    var  opts = {
        lines: 15 // The number of lines to draw
        , length: 0 // The length of each line
        , width: 16 // The line thickness
        , radius: 35// The radius of the inner circle
        , scale: 0.50 // Scales overall size of the spinner
        , corners: 1 // Corner roundness (0..1)
        , color: '#000' // #rgb or #rrggbb or array of colors
        , opacity: 0.25 // Opacity of the lines
        , rotate: 0 // The rotation offset
        , direction: 1 // 1: clockwise, -1: counterclockwise
        , speed: 1.0 // Rounds per second
        , trail: 52 // Afterglow percentage
        , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
        , zIndex: 2e9 // The z-index (defaults to 2000000000)
        , className: 'c24-spinner-mobil' // The CSS class to assign to the spinner
        , top: '0%' // Top position relative to parent
        , left: '50%' // Left position relative to parent
        , shadow: false // Whether to render a shadow
        , hwaccel: false // Whether to use hardware acceleration
        , position: 'absolute' // Element positioning
    };

    //show spinner after click button
    $('.loading_spinner').on('click', function () {

        var docuy = $(document).scrollTop();
        var screenheight =$(window).height();
        var positionyforspinner =-75 + docuy + (screenheight/2);
        var spinner = new Spinner(opts).spin(this);

        $(".c24-spinner-mobil").css('top', positionyforspinner+'px');

    });

});

$(document).on( "click", ".loading_spinner", function() {
    $('html').addClass('ui-loading');
});