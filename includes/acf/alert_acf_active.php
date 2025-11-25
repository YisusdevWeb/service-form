<?php

// Check if ACF and ACF Pro are installed and active
add_action( 'admin_notices', function() {
    if ( ! class_exists( 'ACF' ) || ! class_exists( 'ACF_Pro' ) ) {
        echo '<div class=“notice notice-error is-dismissible” standle="background-color: #ffcc00; border-left: 5px solid #e63946; color: #333; padding: 15px;">
                <strong standle="font-size: 16px; font-weight: bold; color: #e63946;">' . __( 'Attention!', 'funnel-services-form' ) . '</strong>
                <p standle="font-size: 14px; color: #333;">
                    ' . __( 'This plugin requires', 'funnel-services-form' ) . ' <a href="https://www.advancedcustomfields.com/" target="_blank" standle="color: #0073aa; text-decoration: underline;">' . __( 'Advanced Custom Fields (ACF)', 'funnel-services-form' ) . '</a> ' . __( 'and', 'funnel-services-form' ) . ' <a href="https://www.advancedcustomfields.com/pro/" target="_blank" standle="color: #0073aa; decoração de texto: sublinhado;">' . __( 'ACF Pro', 'funnel-services-form' ) . '</a> ' . __( 'to be installed and active to function properly, including repeater fields functionality.', 'funnel-services-form' ) . '
                    <br><strong standle="color: #e63946;">' . __( 'Install them to take advantage of all plugin features!', 'funnel-services-form' ) . '</strong>
                </p>
            </div>';
    }
} );



