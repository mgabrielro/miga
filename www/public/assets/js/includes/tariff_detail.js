$(document).ready(function() {

    c24.vv.pkv.tariff_detail.init();

    var tariff_logos         = $(".c24-tariff-history .tariff_logos a");
    var tariff_history_count = tariff_logos.length;
    var next_click_count     = 0;
    var enable_prev_click    = false;
    var enable_next_click    = false;
    var prev_element = $(".c24-tariff-history .left_arrow");
    var next_element = $(".c24-tariff-history .right_arrow");

    if (tariff_history_count > 2) {
        enable_prev_click = false;
        enable_next_click = true;
    }

    if (!enable_prev_click) {
        prev_element.addClass('disabled');
    }

    if (!enable_next_click) {
        next_element.addClass('disabled');
    }

    $.each(tariff_logos, function(index, value){
        var margin_left = (index * 50) + '%';
        $(value).css('left', margin_left);
    });

    tariff_logos.fadeIn();

    prev_element.click(function(){

        if (enable_prev_click && next_click_count > 0) {

            if (next_click_count > 0) {
                next_click_count--;
            }

            next_element.removeClass('disabled');

            $.each(tariff_logos, function(index, value){
                var left = (parseInt(value.style.left) + 50) + '%';
                $(value).css('left', left);
            });

            if (next_click_count == 0) {
                prev_element.addClass('disabled');
            }

        }


    });

    next_element.click(function(){

        if (next_click_count < (tariff_history_count - 2) && enable_next_click) {

            enable_prev_click = true;
            prev_element.removeClass('disabled');

            next_click_count++;

            $.each(tariff_logos, function(index, value){
                var left = (parseInt(value.style.left) - 50) + '%';
                $(value).css('left', left);
            });

            if (next_click_count == (tariff_history_count - 2)) {
                next_element.addClass('disabled');
            }
        }


    });
    
    $('#tariff-compare-link').click(function(){
        var tariff_version_id = $(this).data('tariff-version-id');
        if (tariff_version_id <= 0) {
            return;
        }

        var url = window.localStorage.getItem('result-url');
        window.localStorage.setItem('compare-keep-tariff', tariff_version_id);

        if (url) {
            window.location = url;
        } else {
            history.go(-1);
        }

        return false;
    });

});

/* ]]> */
