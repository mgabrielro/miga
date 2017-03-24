$( document ).ready(function() {

    var ENTER                 = 13;
        $notification_msg     = $('#notification-msg'),
        $search_term          = $('#search_term'),
        $start_search         = $('#start_search'),
        $posts_table          = $('#posts_table'),
        $reset_posts          = $('#reset_posts');

        //user usability - clicks on enter
    $start_search.keypress(function(e) {
        if(e.which == ENTER) {
            $start_search.click();
        }
    });

    $start_search.on('click', function(e){

        e.preventDefault();

        if ($search_term.val() == '') {

            $notification_msg
                .addClass('alert-danger')
                .html('Do you search for something or you just wanna click some buttons here ?')
                .show();

        } else {

            console.log('clicked start search for term: ' + $search_term.val());

            $.ajax({
                type: 'POST',
                dataType: 'json',
                //async: true,
                url: '/ajax/search',
                data: {'term': $search_term.val()},
                beforeSend: function(){

                },
                success: function (data) {

                    var count = data.length;

                    if(count == 0) {
                        $posts_table.find('.post_header').remove();
                        $reset_posts.show();
                    } else {
                        $reset_posts.hide();
                    }

                    $notification_msg
                        .addClass('alert-success')
                        .html("We've found " + data.length + ' record(s) for this search term!')
                        .show();

                    $posts_table.find('.post_row').remove();

                    $.each( data, function(index, post){

                        var html  = '<tr class="post_row">';
                            html  += '<td><span id="post' + post.id + '">' + post.title + ' </span></td>';
                            html += '<td><a class="btn btn-success" href="blog/detail/' +  post.id + '">View</a> <a class="btn btn-primary" href="blog/edit/' +  post.id + '">Edit</a> <a class="btn btn-danger" href="blog/delete' +  post.id + '">Delete</a></td>';
                            html  += '</tr>';

                        $posts_table.append(html);

                    });

                    $search_term.val('');

                },
                complete: function (data) {

                },
                error: function (data) {

                    $notification_msg
                        .addClass('alert-danger')
                        .html('Oups. We have an error!' + data.responseText)
                        .show();
                }
            });

        }

    });

});