jQuery(document).ready(function($) {
    'use strict';

    var mediaUploader;

    // Initialize color pickers after a small delay to ensure DOM is ready
    setTimeout(function() {
        if ($('.csbf-color-picker').length > 0) {
            $('.csbf-color-picker').each(function() {
                var $this = $(this);
                if (!$this.hasClass('wp-color-picker')) {
                    $this.wpColorPicker({
                        change: function(event, ui) {
                            // Update preview when color changes
                            setTimeout(function() {
                                updatePreview();
                            }, 100);
                        },
                        clear: function() {
                            // Update preview when color is cleared
                            setTimeout(function() {
                                updatePreview();
                            }, 100);
                        }
                    });
                }
            });
        }
        
        // Initial preview update after color pickers are initialized
        updatePreview();
    }, 500);

    $('#csbf_upload_logo_button').on('click', function(e) {
        e.preventDefault();
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose a Logo',
            button: { text: 'Choose Logo' },
            multiple: false
        });
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#csbf_logo_url').val(attachment.url);
            $('.csbf-logo-preview img').attr('src', attachment.url).show();
            $('#csbf_remove_logo_button').show();
            updatePreview();
        });
        mediaUploader.open();
    });

    $('#csbf_remove_logo_button').on('click', function(e) {
        e.preventDefault();
        $('#csbf_logo_url').val('');
        $('.csbf-logo-preview img').attr('src', '').hide();
        $(this).hide();
        updatePreview();
    });

    // Visually distinct gradients
    var presets = {
        1: ['#ff9a9e', '#fad0c4', '#fad0c4', '#ffdde1'], // Pink Sunrise
        2: ['#a1c4fd', '#c2e9fb', '#667eea', '#764ba2'], // Blue Ocean
        3: ['#43cea2', '#185a9d', '#43cea2', '#185a9d'], // Green Forest
        4: ['#f7971e', '#ffd200', '#f7971e', '#ffd200'], // Orange Sunset
        5: ['#c471f5', '#fa71cd', '#c471f5', '#fa71cd']  // Purple Grape
    };

    function updatePreview() {
        try {
            var color1 = $('#gradient_color_1').val() || '#ee7752';
            var color2 = $('#gradient_color_2').val() || '#e73c7e';
            var color3 = $('#gradient_color_3').val() || '#23a6d5';
            var color4 = $('#gradient_color_4').val() || '#23d5ab';
            var logoUrl = $('#csbf_logo_url').val();
            
            // Use proper selectors for form fields
            var title = $('#title').val() || 'Coming Soon';
            var text = $('#text').val() || 'This site is under construction. Please check back later.';
            
            var gradientCSS = 'linear-gradient(-45deg, ' + color1 + ', ' + color2 + ', ' + color3 + ', ' + color4 + ')';
            
            var $preview = $('#csbf-live-preview');
            if ($preview.length) {
                $preview.css({
                    'background': gradientCSS,
                    'background-size': '400% 400%',
                    'animation': 'gradient 15s ease infinite'
                });
            }
            
            if (logoUrl) {
                $('.logo-container-preview').html('<img src="' + logoUrl + '" style="max-height: 100px; max-width: 80%; width: auto; height: auto;">');
            } else {
                $('.logo-container-preview').html('');
            }
            
            var $title = $('.preview-title');
            if ($title.length) {
                $title.text(title);
            }
            
            var $text = $('.preview-text');
            if ($text.length) {
                $text.html(text.replace(/\n/g, '<br>'));
            }
        } catch (error) {
            console.error('Error updating preview:', error);
        }
    }

    // Preset button click handler
    $(document).on('click', '.csbf-preset-button', function(e) {
        e.preventDefault();
        var $button = $(this);
        var presetId = $button.data('preset');
        var colors = presets[presetId];
        
        if (colors && colors.length === 4) {
            // Set the color picker values
            for (var i = 1; i <= 4; i++) {
                var $colorField = $('#gradient_color_' + i);
                if ($colorField.length) {
                    $colorField.val(colors[i - 1]);
                    // Update the color picker UI if it exists
                    if ($colorField.hasClass('wp-color-picker')) {
                        $colorField.wpColorPicker('color', colors[i - 1]);
                    }
                }
            }
            
            // Update button states
            $('.csbf-preset-button').removeClass('active');
            $button.addClass('active');
            
            // Update preview
            updatePreview();
        }
    });

    // Update preview on any input/textarea change
    $(document).on('input change', '#title, #text, #csbf_logo_url', function() {
        updatePreview();
    });

    // Update preview when color picker values change (fallback)
    $(document).on('input change', '.csbf-color-picker', function() {
        setTimeout(function() {
            updatePreview();
        }, 100);
    });
}); 