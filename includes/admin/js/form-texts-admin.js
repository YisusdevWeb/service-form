/**
 * Admin Scripts para la página de Textos del Formulario
 * 
 * @package Funnel_Services_Form
 * @since 1.4.2
 */

(function($) {
    'use strict';

    var defaults = window.fsfFormTextsData ? window.fsfFormTextsData.defaults : {};
    var i18n = window.fsfFormTextsData ? window.fsfFormTextsData.i18n : {};

    $(document).ready(function() {
        initResetTexts();
        initDismissNotice();
    });

    /**
     * Restaurar textos por defecto
     */
    function initResetTexts() {
        $('#fsf_reset_texts').on('click', function(e) {
            e.preventDefault();
            
            var confirmMsg = i18n.confirmReset || '¿Restaurar textos por defecto?';
            if (!confirm(confirmMsg)) {
                return;
            }

            // Restaurar cada campo a su valor por defecto
            $.each(defaults, function(key, value) {
                var $field = $('#' + key);
                if ($field.length) {
                    $field.val(value);
                    // Efecto visual de cambio
                    $field.css('background-color', '#fef3c7');
                    setTimeout(function() {
                        $field.css('background-color', '');
                    }, 500);
                }
            });
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
