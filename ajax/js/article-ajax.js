jQuery(document).ready(function ($) {

    $('#load-more-articles').on('click', function () {

        var button = $(this);

        var offset = parseInt(button.attr('data-offset'));
        var totalPosts = parseInt(button.attr('data-total'));

        button.text('LOADING...');
        button.prop('disabled', true);

        $.ajax({

            url: ajax_articles.ajax_url,

            type: 'POST',

            data: {
                action: 'load_more_article_posts',
                offset: offset,
            },

            success: function (response) {

                if ($.trim(response) !== '') {

                    $('#article-posts').append(response);

                    offset = offset + 8;

                    button.attr('data-offset', offset);

                    if (offset >= totalPosts) {

                        button.remove();

                    } else {

                        button.text('LOAD MORE');
                        button.prop('disabled', false);

                    }

                } else {

                    button.remove();

                }

            },

            error: function () {

                button.text('LOAD MORE');
                button.prop('disabled', false);

            }

        });

    });

});