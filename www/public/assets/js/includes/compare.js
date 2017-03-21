$(document).ready(function(){

    // Toggle tariff feature groups
    $('tbody.group th').click(function(ev){
        $(this).toggleClass('collapsed');
        $(this).parents('tbody').next('tbody').toggle();
    });

    // Toggle tooltip
    $('.tariff_feature_info_icon').click(function(){
        $(this).siblings('.c24-content-row-block-infobox').first().toggle();
        $(this).toggleClass('active');
    });

    $('.c24-info-close-row').click(function(){
        $(this).parents('th').children('.tariff_feature_info_icon').toggleClass('active');
    });

    // Toggle sticky
    const FIXED_HEADER_HEIGHT       = 155;
    const FIXED_HEADER_SPACER_DIFF  = 40;
    const FIXED_HEADER_SPACER       = $("table.compare-header").outerHeight()-FIXED_HEADER_SPACER_DIFF;
    const COMPARE_TABLE_TOP_OFFSET  = $("table.compare-body").offset().top;

    var compare_header = $("table.compare-header");
    var compare_body = $("table.compare-body");

    $(window).scroll(function(){

        if ((COMPARE_TABLE_TOP_OFFSET - $(window).scrollTop()) <  FIXED_HEADER_HEIGHT) {
            compare_header.addClass('scroll-to-fixed-fixed');
            compare_body.css('margin-top', FIXED_HEADER_SPACER);
        } else if (compare_header.hasClass('scroll-to-fixed-fixed')) {
            compare_header.removeClass('scroll-to-fixed-fixed');
            compare_body.css('margin-top', "0px");
        }

    });

    // Remove a tariff from comparison
    $('.remove_tariff').click(function(){

        var url = window.localStorage.getItem('result-url');
        window.localStorage.setItem('compare-keep-tariff', $(this).data('keep'));

        if (url) {
            window.location = url;
        } else {
            history.go(-1);
        }

        return false;

    });

});
