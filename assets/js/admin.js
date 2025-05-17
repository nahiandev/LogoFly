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
            $('.logofly-preview').html(
                '<img src="' + attachment.url + '" style="max-width:100%;height:auto;">'
            );
        });

        frame.open();
    });

    // Size controls with aspect ratio locking
    var aspectRatio = null;
    $('input[name="logofly_options[logo_width]"], input[name="logofly_options[logo_height]"]').on('input', function() {
        var $width = $('input[name="logofly_options[logo_width]"]');
        var $height = $('input[name="logofly_options[logo_height]"]');
        var $lock = $('input[name="logofly_options[lock_aspect]"]');
        
        if ($lock.is(':checked')) {
            if (!aspectRatio && $width.val() && $height.val()) {
                aspectRatio = $width.val() / $height.val();
            }
            
            if ($(this).attr('name') === 'logofly_options[logo_width]' && aspectRatio) {
                $height.val(Math.round($width.val() / aspectRatio));
            } else if (aspectRatio) {
                $width.val(Math.round($height.val() * aspectRatio));
            }
        }
        
        updatePreview();
    });
    
    $('.logofly-preview img').on('load', function() {
        if (!$('input[name="logofly_options[logo_width]"]').val()) {
            aspectRatio = this.naturalWidth / this.naturalHeight;
            $('input[name="logofly_options[logo_width]"]').val(this.naturalWidth);
            $('input[name="logofly_options[logo_height]"]').val(this.naturalHeight);
            updatePreview();
        }
    });
    
    function updatePreview() {
        var width = $('input[name="logofly_options[logo_width]"]').val();
        var height = $('input[name="logofly_options[logo_height]"]').val();
        $('.logofly-preview img').css({
            'width': width + 'px',
            'height': height + 'px'
        });
    }
});