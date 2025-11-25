<?php
/**
 * Template Name: Formulário de Serviços (Full Screen)
 * Template Post Type: page
 * 
 * Template de página fullscreen para el formulario de servicios.
 * 100% independiente del tema - funciona con cualquier tema de WordPress.
 * Compatible con: Elementor, Divi, Beaver Builder, Gutenberg, temas clásicos, etc.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Valores por defecto - DEBEN coincidir con wp_admin_styles.php
$defaults = array(
    'bg_primary'       => '#090a15',
    'bg_secondary'     => '#01579b',
    'text_primary'     => '#ffffff',
    'text_secondary'   => '#e5e7eb',
    'title_color'      => '#ffffff',
    'label_color'      => '#ffffff',
    'input_bg'         => 'rgba(255, 255, 255, 0.02)',
    'input_text'       => '#ffffff',
    'input_border'     => '#ffffff',
    'button_bg'        => '#122d42',
    'button_text'      => '#ffffff',
    'button_hover_bg'  => '#3974ad',
    'theme_color_light'=> '#7ba8cc',
    'glass_bg_opacity' => 0.15,
    'glass_blur'       => 10,
);

// Obtener colores guardados y mezclar con defaults
$saved_colors = get_option( 'fsf_custom_colors', array() );
$colors = array_merge( $defaults, (array) $saved_colors );

// Asegurar que los valores no estén vacíos
foreach ( $defaults as $key => $default_value ) {
    if ( empty( $colors[ $key ] ) || $colors[ $key ] === '' || $colors[ $key ] === null ) {
        $colors[ $key ] = $default_value;
    }
}

// Variables para usar en el template
$bg_primary      = esc_attr( $colors['bg_primary'] );
$bg_secondary    = esc_attr( $colors['bg_secondary'] );
$text_primary    = esc_attr( $colors['text_primary'] );
$glass_opacity   = floatval( $colors['glass_bg_opacity'] );
$glass_blur      = intval( $colors['glass_blur'] );

// Validar valores
if ( $glass_opacity <= 0 || $glass_opacity > 1 ) {
    $glass_opacity = 0.15;
}
if ( $glass_blur < 0 || $glass_blur > 50 ) {
    $glass_blur = 10;
}

// Prevenir cache de page builders
if ( defined( 'ELEMENTOR_VERSION' ) ) {
    add_filter( 'elementor/frontend/builder_content_data', '__return_empty_array', 1 );
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="fsf-fullscreen-html">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="theme-color" content="<?php echo $bg_primary; ?>">
    <title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>
    
    <?php wp_head(); ?>
    
    <style id="fsf-fullscreen-critical-css">
        /* =============================================
           VARIABLES CSS - Heredadas del admin
           ============================================= */
        :root {
            --fsf-bg-primary: <?php echo $bg_primary; ?>;
            --fsf-bg-secondary: <?php echo $bg_secondary; ?>;
            --fsf-text-primary: <?php echo $text_primary; ?>;
            --fsf-glass-opacity: <?php echo $glass_opacity; ?>;
            --fsf-glass-blur: <?php echo $glass_blur; ?>px;
        }
        
        /* =============================================
           RESET COMPLETO - Independiente del tema
           ============================================= */
        
        html.fsf-fullscreen-html,
        html.fsf-fullscreen-html body.fsf-fullscreen-page {
            margin: 0 !important;
            padding: 0 !important;
            min-height: 100vh !important;
            overflow-x: hidden !important;
        }
        
        body.fsf-fullscreen-page {
            background: linear-gradient(135deg, <?php echo $bg_primary; ?> 0%, <?php echo $bg_secondary; ?> 100%) !important;
            background-attachment: fixed !important;
            display: flex !important;
            justify-content: center !important;
            align-items: flex-start !important;
            min-height: 100vh !important;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            color: <?php echo $text_primary; ?> !important;
        }
        
        /* =============================================
           OCULTAR TODOS LOS ELEMENTOS DE CUALQUIER TEMA
           ============================================= */
        
        body.fsf-fullscreen-page #wpadminbar,
        body.fsf-fullscreen-page header,
        body.fsf-fullscreen-page footer,
        body.fsf-fullscreen-page nav,
        body.fsf-fullscreen-page aside,
        body.fsf-fullscreen-page .site-header,
        body.fsf-fullscreen-page .site-footer,
        body.fsf-fullscreen-page .site-navigation,
        body.fsf-fullscreen-page .main-navigation,
        body.fsf-fullscreen-page .primary-menu,
        body.fsf-fullscreen-page .secondary-menu,
        body.fsf-fullscreen-page .widget-area,
        body.fsf-fullscreen-page .sidebar,
        body.fsf-fullscreen-page #sidebar,
        body.fsf-fullscreen-page .breadcrumbs,
        body.fsf-fullscreen-page .breadcrumb,
        body.fsf-fullscreen-page .elementor-location-header,
        body.fsf-fullscreen-page .elementor-location-footer,
        body.fsf-fullscreen-page [data-elementor-type="header"],
        body.fsf-fullscreen-page [data-elementor-type="footer"],
        body.fsf-fullscreen-page #main-header,
        body.fsf-fullscreen-page #main-footer,
        body.fsf-fullscreen-page #top-header,
        body.fsf-fullscreen-page .ast-header-html-inner,
        body.fsf-fullscreen-page .ast-footer-overlay,
        body.fsf-fullscreen-page .site-info,
        body.fsf-fullscreen-page #site-header,
        body.fsf-fullscreen-page #footer,
        body.fsf-fullscreen-page #footer-widgets,
        body.fsf-fullscreen-page .kadence-header,
        body.fsf-fullscreen-page .kadence-footer,
        body.fsf-fullscreen-page .wp-site-blocks > header,
        body.fsf-fullscreen-page .wp-site-blocks > footer,
        body.fsf-fullscreen-page .fusion-header-wrapper,
        body.fsf-fullscreen-page .fusion-footer-widget-area,
        body.fsf-fullscreen-page .fl-page-header,
        body.fsf-fullscreen-page .fl-page-footer {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            max-height: 0 !important;
            overflow: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }
        
        /* =============================================
           PATRÓN DECORATIVO
           ============================================= */
        
        body.fsf-fullscreen-page::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.03) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        
        /* =============================================
           CONTENEDOR PRINCIPAL
           ============================================= */
        
        .fsf-fullscreen-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            box-sizing: border-box;
        }
        
        .fsf-fullscreen-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        
        /* El formulario dentro del template - NO tocar el fondo del form */
        .fsf-fullscreen-container .funil-services-form-root {
            min-height: auto !important;
            padding: 0 !important;
        }
        
        /* =============================================
           RESPONSIVE
           ============================================= */
        
        @media (max-width: 768px) {
            .fsf-fullscreen-wrapper {
                padding: 15px;
                align-items: flex-start;
                padding-top: 30px;
            }
            
            .fsf-fullscreen-container {
                max-width: 100%;
            }
        }
        
        @media (max-width: 480px) {
            .fsf-fullscreen-wrapper {
                padding: 10px;
            }
        }
        
        /* =============================================
           ANIMACIÓN DE ENTRADA
           ============================================= */
        
        @keyframes fsfFadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fsf-fullscreen-container {
            animation: fsfFadeInUp 0.6s ease-out forwards;
        }
        
        @media (prefers-reduced-motion: reduce) {
            .fsf-fullscreen-container {
                animation: none;
            }
        }
        
        /* Print styles */
        @media print {
            body.fsf-fullscreen-page {
                background: white !important;
            }
            
            body.fsf-fullscreen-page::before {
                display: none;
            }
        }
    </style>
</head>
<body <?php body_class( 'fsf-fullscreen-page' ); ?>>
    
    <div class="fsf-fullscreen-wrapper">
        <div class="fsf-fullscreen-container">
            <?php
            // Mostrar el contenido de la página (donde estará el shortcode)
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
            ?>
        </div>
    </div>

    <?php wp_footer(); ?>
    
    <script>
    (function() {
        'use strict';
        
        var elementsToHide = [
            'header', 'footer', 'nav', 'aside',
            '.site-header', '.site-footer',
            '.elementor-location-header', '.elementor-location-footer',
            '#main-header', '#main-footer',
            '#wpadminbar'
        ];
        
        function hideElements() {
            elementsToHide.forEach(function(selector) {
                var elements = document.querySelectorAll(selector);
                elements.forEach(function(el) {
                    if (el && !el.closest('.fsf-fullscreen-container')) {
                        el.style.cssText = 'display: none !important; visibility: hidden !important;';
                    }
                });
            });
        }
        
        hideElements();
        document.addEventListener('DOMContentLoaded', hideElements);
        window.addEventListener('load', hideElements);
        
        if (typeof MutationObserver !== 'undefined') {
            var observer = new MutationObserver(hideElements);
            observer.observe(document.body, { childList: true, subtree: true });
            setTimeout(function() { observer.disconnect(); }, 5000);
        }
    })();
    </script>
</body>
</html>
