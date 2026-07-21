// Related reading shortcode for tinymce editor
(function() {
    tinymce.PluginManager.add('related_reading', function(editor) {
        editor.addButton('related_reading_button', {
            //text: 'Related Reading',
            tooltip: 'Insert Related Reading',
            icon: 'codesample',
            onclick: function() {
                editor.insertContent('[related_reading]');
            }
        });
    });
})();