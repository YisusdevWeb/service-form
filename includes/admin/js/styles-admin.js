/**
 * Admin Scripts para la página de Estilos
 * 
 * @package Funnel_Services_Form
 * @since 1.4.2
 */

(function($) {
    'use strict';

    // Variables globales pasadas desde PHP via wp_localize_script
    var defaultColors = window.fsfAdminData ? window.fsfAdminData.defaultColors : {};
    var i18n = window.fsfAdminData ? window.fsfAdminData.i18n : {};

    /**
     * Inicializar cuando el DOM esté listo
     */
    $(document).ready(function() {
        initColorPickers();
        initTemplateSelector();
        initResetDefaults();
        initMediaUploader();
        initRemoveLogo();
        initGlassPreview();
        initTemplateStyles();
        initDismissNotice();
    });

    /**
     * Inicializar WordPress Color Pickers
     */
    function initColorPickers() {
        $('.fsf-color-picker').wpColorPicker();
    }

    /**
     * Selector de plantillas de colores
     */
    function initTemplateSelector() {
        $('.fsf-template-card').on('click', function() {
            var $card = $(this);
            var colors = $card.data('colors');
            var templateId = $card.data('template');

            // Actualizar estado visual
            $('.fsf-template-card').removeClass('active');
            $card.addClass('active');
            $('#active_template').val(templateId);

            // Aplicar colores a los campos
            if (colors) {
                $.each(colors, function(key, value) {
                    var $field = $('#' + key);
                    if ($field.length) {
                        if ($field.hasClass('fsf-color-picker')) {
                            $field.wpColorPicker('color', value);
                        } else {
                            $field.val(value);
                        }
                    }
                });

                // Actualizar preview de glassmorphism si hay valores
                if (colors.glass_bg_opacity !== undefined) {
                    $('#glass_bg_opacity').val(colors.glass_bg_opacity);
                    $('#glass_bg_opacity_range').val(colors.glass_bg_opacity);
                }
                if (colors.glass_blur !== undefined) {
                    $('#glass_blur').val(colors.glass_blur);
                    $('#glass_blur_range').val(colors.glass_blur);
                }
                updateGlassStyles();
            }
        });
    }

    /**
     * Botón de restaurar valores por defecto
     */
    function initResetDefaults() {
        $('#fsf_reset_defaults').on('click', function(e) {
            e.preventDefault();
            
            var confirmMsg = i18n.confirmReset || '¿Restaurar colores por defecto?';
            if (!confirm(confirmMsg)) {
                return;
            }

            $.each(defaultColors, function(key, value) {
                var $field = $('#' + key);
                if ($field.length) {
                    if ($field.hasClass('fsf-color-picker')) {
                        $field.wpColorPicker('color', value);
                    } else {
                        $field.val(value);
                    }
                }
            });

            // Actualizar rangos de glassmorphism
            if (defaultColors.glass_bg_opacity !== undefined) {
                $('#glass_bg_opacity_range').val(defaultColors.glass_bg_opacity);
            }
            if (defaultColors.glass_blur !== undefined) {
                $('#glass_blur_range').val(defaultColors.glass_blur);
            }
            updateGlassStyles();
        });
    }

    /**
     * Media Uploader para el logo
     */
    function initMediaUploader() {
        var mediaUploader;

        $('#fsf_upload_logo_button').on('click', function(e) {
            e.preventDefault();

            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            mediaUploader = wp.media({
                title: i18n.selectLogo || 'Selecionar Logo',
                button: { 
                    text: i18n.useImage || 'Usar esta imagem' 
                },
                multiple: false,
                library: { type: 'image' }
            });

            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#fsf_logo_url').val(attachment.url);
                $('#fsf-logo-preview').attr('src', attachment.url).removeClass('hidden');
                $('#fsf-no-logo').addClass('hidden');
            });

            mediaUploader.open();
        });
    }

    /**
     * Remover logo
     */
    function initRemoveLogo() {
        $(document).on('click', '#fsf_remove_logo_button', function(e) {
            e.preventDefault();
            $('#fsf_logo_url').val('');
            $('#fsf-logo-preview').addClass('hidden');
            $('#fsf-no-logo').removeClass('hidden');
        });
    }

    /**
     * Preview de Glassmorphism con sliders
     */
    function initGlassPreview() {
        // Aplicar estilos iniciales
        var $glassPreview = $('#fsf-glass-preview');
        if ($glassPreview.length) {
            var initialOpacity = $glassPreview.data('opacity') || 0.1;
            var initialBlur = $glassPreview.data('blur') || 10;
            updateGlassStyles(initialOpacity, initialBlur);
        }

        // Sincronizar sliders con inputs numéricos
        $('#glass_bg_opacity_range').on('input', function() {
            $('#glass_bg_opacity').val($(this).val());
            updateGlassStyles();
        });

        $('#glass_bg_opacity').on('input', function() {
            $('#glass_bg_opacity_range').val($(this).val());
            updateGlassStyles();
        });

        $('#glass_blur_range').on('input', function() {
            $('#glass_blur').val($(this).val());
            updateGlassStyles();
        });

        $('#glass_blur').on('input', function() {
            $('#glass_blur_range').val($(this).val());
            updateGlassStyles();
        });
    }

    /**
     * Actualizar estilos del preview de glassmorphism
     */
    function updateGlassStyles(opacity, blur) {
        opacity = opacity !== undefined ? opacity : $('#glass_bg_opacity').val();
        blur = blur !== undefined ? blur : $('#glass_blur').val();

        $('#fsf-glass-bg').css({
            'background': 'rgba(255, 255, 255, ' + opacity + ')',
            'backdrop-filter': 'blur(' + blur + 'px)',
            '-webkit-backdrop-filter': 'blur(' + blur + 'px)'
        });
    }

    /**
     * Aplicar estilos dinámicos a las tarjetas de plantillas
     */
    function initTemplateStyles() {
        $('.fsf-template-card').each(function() {
            var $card = $(this);
            var bgPrimary = $card.data('bg-primary');
            var bgSecondary = $card.data('bg-secondary');
            var textPrimary = $card.data('text-primary');

            if (bgPrimary && bgSecondary) {
                $card.css('background', 'linear-gradient(135deg, ' + bgPrimary + ' 0%, ' + bgSecondary + ' 100%)');
            }
            if (textPrimary) {
                $card.find('.fsf-template-name').css('color', textPrimary);
            }
        });
    }

    /**
     * Cerrar mensaje de éxito
     */
    function initDismissNotice() {
        $('.fsf-dismiss-notice').on('click', function() {
            $(this).closest('.fsf-success-message').fadeOut(200, function() {
                $(this).remove();
            });
        });
    }

})(jQuery);
