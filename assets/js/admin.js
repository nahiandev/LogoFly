jQuery(document).ready(function($) {
    // Media uploader
    $('.logofly-upload').click(function(e) {
        e.preventDefault();
        
        var frame = wp.media({
            title: 'Select Logo',
            button: { text: 'Use This Image' },
            multiple: false
        });

        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            $('.logofly-logo-url').val(attachment.url);
            $('.logofly-preview').html('<img src="' + attachment.url + '" style="max-height: 80px;">');
        });

        frame.open();
    });
});