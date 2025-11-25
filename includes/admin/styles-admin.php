<?php
/**
 * Panel de administración para estilos
 * 
 * @package Funnel_Services_Form
 */

if (!defined('ABSPATH')) exit;

// Cargar dependencias
require_once __DIR__ . '/color-templates.php';
require_once __DIR__ . '/frontend-styles.php';

/**
 * Registrar menú de admin
 */
add_action('admin_menu', 'fsf_add_styles_menu');

function fsf_add_styles_menu() {
    add_submenu_page(
        'fsf-informacion-de-usuario',
        __('Personalização de Estilos e Logo', 'funnel-services-form'),
        __('Estilos e Logo', 'funnel-services-form'),
        'manage_options',
        'fsf-styles-settings',
        'fsf_display_styles_settings_page'
    );
}

/**
 * Enqueue scripts del admin
 */
add_action('admin_enqueue_scripts', 'fsf_enqueue_admin_scripts');

function fsf_enqueue_admin_scripts($hook_suffix) {
    if (strpos($hook_suffix, 'fsf-styles-settings') === false && 
        (!isset($_GET['page']) || $_GET['page'] !== 'fsf-styles-settings')) {
        return;
    }
    
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_media();
    
    // Registrar y cargar script externo
    wp_enqueue_script(
        'fsf-styles-admin',
        plugins_url('js/styles-admin.js', __FILE__),
        array('jquery', 'wp-color-picker', 'media-upload'),
        FSF_PLUGIN_VERSION,
        true
    );
    
    // Pasar datos al script
    wp_localize_script('fsf-styles-admin', 'fsfAdminData', array(
        'defaultColors' => fsf_get_default_colors(),
        'i18n' => array(
            'confirmReset' => __('¿Restaurar colores por defecto?', 'funnel-services-form'),
            'selectLogo' => __('Selecionar Logo', 'funnel-services-form'),
            'useImage' => __('Usar esta imagem', 'funnel-services-form'),
        )
    ));
}

/**
 * Página de configuración
 */
function fsf_display_styles_settings_page() {
    $color_templates = fsf_get_color_templates();
    $defaults = fsf_get_default_colors();
    
    // Procesar guardado
    if (isset($_POST['fsf_styles_nonce']) && wp_verify_nonce($_POST['fsf_styles_nonce'], 'fsf_styles_settings')) {
        fsf_save_style_settings($defaults);
        $saved_message = true;
    } else {
        $saved_message = false;
    }
    
    $logo_url = get_option('fsf_logo_url', '');
    $colors = fsf_get_current_colors();
    $active_template = get_option('fsf_active_template', 'custom');
    $show_success = $saved_message;
    
    // Incluir template HTML
    include __DIR__ . '/views/styles-settings-page.php';
}

/**
 * Guardar configuración
 */
function fsf_save_style_settings($defaults) {
    // Logo
    if (isset($_POST['logo_url'])) {
        update_option('fsf_logo_url', esc_url_raw($_POST['logo_url']));
    }
    if (isset($_POST['logo_max_width'])) {
        update_option('fsf_logo_max_width', intval($_POST['logo_max_width']));
    }
    if (isset($_POST['logo_max_height'])) {
        update_option('fsf_logo_max_height', intval($_POST['logo_max_height']));
    }
    if (isset($_POST['active_template'])) {
        update_option('fsf_active_template', sanitize_text_field($_POST['active_template']));
    }
    
    // Colores
    $color_options = [];
    $color_fields = ['bg_primary', 'bg_secondary', 'text_primary', 'text_secondary', 'title_color', 
                     'label_color', 'input_bg', 'input_text', 'input_border', 'button_bg', 
                     'button_text', 'button_hover_bg', 'theme_color_light'];
    
    foreach ($color_fields as $field) {
        $color_options[$field] = !empty($_POST[$field]) ? sanitize_text_field($_POST[$field]) : $defaults[$field];
    }
    
    $color_options['glass_bg_opacity'] = !empty($_POST['glass_bg_opacity']) ? floatval($_POST['glass_bg_opacity']) : $defaults['glass_bg_opacity'];
    $color_options['glass_blur'] = !empty($_POST['glass_blur']) ? intval($_POST['glass_blur']) : $defaults['glass_blur'];
    
    update_option('fsf_custom_colors', $color_options);
}
