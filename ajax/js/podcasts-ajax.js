jQuery(document).ready(function ($) {

    $('#load-more-podcasts').on('click', function () {

        const button = $(this);
        const offset = parseInt(button.attr('data-offset'));

        button.prop('disabled', true);
        button.text('Loading...');

        $.ajax({
            url: podcast_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'load_more_podcasts',
                offset: offset
            },
            success: function (response) {

                if (response.success) {

                    $('#podcast-list').append(response.data.html);

                    const loadedCount = parseInt(response.data.count);
                    const totalPosts = parseInt(response.data.total);

                    const newOffset = offset + loadedCount;

                    button.attr('data-offset', newOffset);

                    if (newOffset >= totalPosts) {
                        button.remove();
                    } else {
                        button.prop('disabled', false);
                        button.text('Load More Episodes');
                    }

                } else {
                    button.remove();
                }

            },

            error: function () {

                button.prop('disabled', false);
                button.text('Load More Episodes');

            }
            
            
        });

    });

});