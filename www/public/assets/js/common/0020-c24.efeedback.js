(function(namespace_to_construct){
    "use strict";

    var default_count = 5;
    var filter_stars = 0;


    var efeedback_load_text   = 'weitere Kundenbewertungen anzeigen';
    var efeedback_load_star   = 'weitere :star-Sterne-Kundenbewertungen anzeigen';
    var efeedback_head_text   = 'Was unsere Kunden sagen';
    var efeedback_head_star   = 'Anzeige von :star-Sterne-Kundenbewertungen';
    var efeedback_none_text   = '<i class="fa fa-info"></i> Keine weiteren Kundenbewertungen vorhanden.';
    var efeedback_none_star   = '<i class="fa fa-info"></i> Keine weiteren :star-Sterne-Kundenbewertungen vorhanden.';

    //-------------------"PRIVATE METHODS"--------------------

    function _set_wording() {

        $('table.star-table tr .progress').removeClass('active');

        if(filter_stars > 0) {
            $('table.star-table tr[data-star="'+filter_stars+'"] .progress').addClass('active');
            $('#filter_reset').css('display', 'inline');
            $('#feedback_title').html(efeedback_head_star.replace(/:star/, filter_stars));
            $('#more_customerfeedbacks').html(efeedback_load_star.replace(/:star/, filter_stars));
            $('#no_more_items').html(efeedback_none_star.replace(/:star/, filter_stars));
        } else {
            $('#filter_reset').hide();
            $('#feedback_title').html(efeedback_head_text);
            $('#more_customerfeedbacks').html(efeedback_load_text);
            $('#no_more_items').html(efeedback_none_text);
        }
    }

    function _efeedback_filter(stars, reset) {
        filter_stars = stars;
        _efeedback_pager(default_count, reset);
    }

    function _efeedback_pager(items_per_request, at_first_set_empty)
    {
        _set_wording();

        if (at_first_set_empty) {
            $('.c24-user-comments').remove();
            $('#no_more_customerfeedback, #close_customerfeedbacks').hide();
            $('#more_customerfeedbacks').show();
        }

        $.ajax({
            url: efeedback_url + '/?offset=' + (at_first_set_empty ? 0 : $('.c24-user-comments').length) + '&limit=' + items_per_request + '&stars=' + filter_stars,
            dataType: 'json',
            success: function(data) {

                var comments = data.content;

                if(comments.length == 0) {
                    $('#no_more_customerfeedback').show();
                    $('#close_customerfeedbacks').css('display', 'block');
                    $('#more_customerfeedbacks').hide();
                }

                $.each(comments, function(){
                    var comment = this;

                    var positive_feedback = '';
                    var negative_feedback = '';
                    var date = comment['created_at'].replace('-', '').substr(0, 10);

                    if (comment['comment_positiv'] != '') {
                        positive_feedback = '<div class="c24-user-comment">' +
                            '<div class="positive"><i class="fa fa-check"></i></div> ' +
                            '<div class="comment"> ' + comment['comment_positiv'] + '' +
                            '</div></div>';
                    }

                    if (comment['comment_negativ'] != '') {
                        negative_feedback = '<div class="c24-user-comment"><div class="negative"><i class="fa fa-times"></i></div> <div class="comment"> ' + comment['comment_negativ'] + '</div></div>';
                    }

                    $('#c24-efeedback-comments').append('<div class="c24-user-comments">'
                        + '<div class="c24-user-comment-date">' + date + ' - ' + comment['customer_name'] + '</div>'
                        + positive_feedback
                        + negative_feedback
                        + '<div class="c24-user-comment-score"><div class="starempty14"><div class="starfull14 star'+(comment['rating']/2 + '').replace(/\./g, '')+'"></div></div></div>');
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status + ' ' + thrownError);
            }

        });
    }

    (function(ns){

        jQuery(document).ready(function(){
            ns.init();
        });

    })(namespace(namespace_to_construct, function(){}, {

        //-------------------PUBLIC METHODS--------------------
        init: function(){

            $(document).ready(function()
            {
                if(typeof efeedback_total == 'undefined' || typeof efeedback_url == 'undefined') {
                    return;
                }

                if(efeedback_total <= default_count) {
                    $('#no_more_customerfeedback').show();
                    $('#more_customerfeedbacks').hide();
                }

                $('#close_customerfeedbacks').on('click', function() {
                    _efeedback_filter(0, true);
                    $('.tariff_accordion').collapsible( "option", "collapsed", true );
                    return false;
                });

                $('#more_customerfeedbacks').on('click', function() {
                    _efeedback_pager(default_count, false);
                    return false;
                });

                $('table.star-table tr').on('click', function() {
                    _efeedback_filter($(this).data('star'), true);
                    return false;
                });

                $('.reset_button').on('click', function() {
                    _efeedback_filter(0, true);
                    return false;
                });
            });

        }
    }));
})("c24.efeedback");