<?php

// Verificar si ACF y ACF Pro están instalados y activos
add_action( 'admin_notices', function() {
    if ( ! class_exists( 'ACF' ) || ! class_exists( 'ACF_Pro' ) ) {
        echo '<div class=“notice notice-error is-dismissible” style="background-color: #ffcc00; border-left: 5px solid #e63946; color: #333; padding: 15px;">
                <strong style="font-size: 16px; font-weight: bold; color: #e63946;">' . __( '¡Atención!', 'funnel-services-form' ) . '</strong>
                <p style="font-size: 14px; color: #333;">
                    ' . __( 'Este plugin requer que', 'funnel-services-form' ) . ' <a href="https://www.advancedcustomfields.com/" target="_blank" style="color: #0073aa; text-decoration: underline;">' . __( 'Campos personalizados avançados (ACF)', 'funnel-services-form' ) . '</a> ' . __( 'y', 'funnel-services-form' ) . ' <a href="https://www.advancedcustomfields.com/pro/" target="_blank" style="color: #0073aa; decoração de texto: sublinhado;">' . __( 'ACF Pro', 'funnel-services-form' ) . '</a> ' . __( 'estão instalados e activos para funcionar corretamente, incluindo a funcionalidade de campos repetidores.', 'funnel-services-form' ) . '
                    <br><strong style="color: #e63946;">' . __( '¡Instálalos para aprovechar todas las funcionalidades del plugin!', 'funnel-services-form' ) . '</strong>
                </p>
            </div>';
    }
} );


