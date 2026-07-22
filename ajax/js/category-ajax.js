jQuery(document).ready(function ($) {

    $('#load-more-posts').on('click', function () {

        var button = $(this);

        var offset = parseInt(button.attr('data-offset'));
        var totalPosts = parseInt(button.attr('data-total'));
        var termId = button.attr('data-term-id');
        var taxonomy = button.attr('data-taxonomy');

        button.text('LOADING...');
        button.prop('disabled', true);

        $.ajax({

            url: ajax_object.ajax_url,

            type: 'POST',

            data: {
                action: 'load_more_topic_posts',
                offset: offset,
                term_id: termId,
                taxonomy: taxonomy
            },

            success: function (response) {

                if ($.trim(response) !== '') {

                    $('#category-posts').append(response);

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