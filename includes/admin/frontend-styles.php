<?php
/**
 * Inyección de CSS dinámico en el frontend
 * 
 * @package Funnel_Services_Form
 */

if (!defined('ABSPATH')) exit;

/**
 * Inyectar CSS personalizado en wp_head
 */
add_action('wp_head', 'fsf_inject_custom_styles', 100);

function fsf_inject_custom_styles() {
    $colors = fsf_get_current_colors();
    
    // Validar valores de glass
    $glass_opacity = floatval($colors['glass_bg_opacity']);
    if ($glass_opacity <= 0 || $glass_opacity > 1) $glass_opacity = 0.15;
    
    $glass_blur = intval($colors['glass_blur']);
    if ($glass_blur < 0 || $glass_blur > 50) $glass_blur = 10;
    
    ?>
    <style id="fsf-custom-styles">
        /* Variables CSS dinámicas */
        :root {
            --bg-color: <?php echo esc_attr($colors['bg_primary']); ?>;
            --bg-gradient: linear-gradient(135deg, <?php echo esc_attr($colors['bg_primary']); ?> 0%, <?php echo esc_attr($colors['bg_secondary']); ?> 100%);
            --heading-color: <?php echo esc_attr($colors['title_color']); ?>;
            --font-color: <?php echo esc_attr($colors['text_primary']); ?>;
            --font-color-secondary: <?php echo esc_attr($colors['text_secondary']); ?>;
            --label-color: <?php echo esc_attr($colors['label_color']); ?>;
            --theme-color: <?php echo esc_attr($colors['button_bg']); ?>;
            --theme-color-darken: <?php echo esc_attr($colors['button_hover_bg']); ?>;
            --theme-color-light: <?php echo esc_attr($colors['theme_color_light']); ?>;
            --glass-bg: rgba(255, 255, 255, <?php echo esc_attr($glass_opacity); ?>);
            --glass-blur: <?php echo esc_attr($glass_blur); ?>px;
            --input-bg: <?php echo esc_attr($colors['input_bg']); ?>;
            --input-text: <?php echo esc_attr($colors['input_text']); ?>;
            --input-border: <?php echo esc_attr($colors['input_border']); ?>;
            --button-text: <?php echo esc_attr($colors['button_text']); ?>;
            --logo-max-width: <?php echo esc_attr(get_option('fsf_logo_max_width', 200)); ?>px;
            --logo-max-height: <?php echo esc_attr(get_option('fsf_logo_max_height', 80)); ?>px;
        }
        
        /* Aislamiento de Elementor */
        .funil-services-form-root.funil-services-form-root {
            --e-global-color-primary: var(--font-color);
            --e-global-color-secondary: var(--font-color-secondary);
            --e-global-color-text: var(--font-color);
            --e-global-color-accent: var(--theme-color-light);
        }
        
        /* Override tipografía Elementor */
        .funil-services-form-root.funil-services-form-root p,
        .funil-services-form-root.funil-services-form-root span,
        .funil-services-form-root.funil-services-form-root label,
        .funil-services-form-root.funil-services-form-root div,
        .funil-services-form-root.funil-services-form-root .MuiTypography-root {
            color: var(--font-color) !important;
        }
        
        .funil-services-form-root.funil-services-form-root h1,
        .funil-services-form-root.funil-services-form-root h2,
        .funil-services-form-root.funil-services-form-root h3,
        .funil-services-form-root.funil-services-form-root h4,
        .funil-services-form-root.funil-services-form-root h5,
        .funil-services-form-root.funil-services-form-root h6 {
            color: var(--heading-color) !important;
        }
        
        /* Checkbox - reset Elementor */
        .funil-services-form-root.funil-services-form-root .MuiFormControlLabel-root p {
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* Links */
        .funil-services-form-root.funil-services-form-root a {
            color: var(--theme-color-light) !important;
        }
        .funil-services-form-root.funil-services-form-root a:hover {
            color: var(--theme-color-darken) !important;
        }
        
        /* Fullscreen container */
        .fsf-fullscreen-container .funil-services-form-root.funil-services-form-root {
            min-height: auto !important;
            padding: 20px !important;
        }
    </style>
    <?php
}
