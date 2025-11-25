<?php
/**
 * Panel de administración para textos del formulario
 * 
 * @package Funnel_Services_Form
 * @since 1.4.2
 */

if (!defined('ABSPATH')) exit;

/**
 * Registrar menú de admin para textos
 */
add_action('admin_menu', 'fsf_add_form_texts_menu');

function fsf_add_form_texts_menu() {
    add_submenu_page(
        'fsf-informacion-de-usuario',
        __('Form Texts', 'funnel-services-form'),
        __('Form Texts', 'funnel-services-form'),
        'manage_options',
        'fsf-form-texts',
        'fsf_display_form_texts_page'
    );
}

/**
 * Enqueue scripts del admin para textos
 */
add_action('admin_enqueue_scripts', 'fsf_enqueue_form_texts_scripts');

function fsf_enqueue_form_texts_scripts($hook_suffix) {
    if (strpos($hook_suffix, 'fsf-form-texts') === false && 
        (!isset($_GET['page']) || $_GET['page'] !== 'fsf-form-texts')) {
        return;
    }
    
    wp_enqueue_script(
        'fsf-form-texts-admin',
        plugins_url('js/form-texts-admin.js', __FILE__),
        array('jquery'),
        FSF_PLUGIN_VERSION,
        true
    );
    
    wp_localize_script('fsf-form-texts-admin', 'fsfFormTextsData', array(
        'defaults' => fsf_get_default_form_texts(),
        'i18n' => array(
            'confirmReset' => __('Restore default texts?', 'funnel-services-form'),
        )
    ));
}

/**
 * Obtener textos por defecto del formulario
 */
function fsf_get_default_form_texts() {
    return array(
        // Titles
        'form_title' => 'REQUEST A QUOTE',
        'form_subtitle' => 'Fill in the fields below to request your quote!',
        
        // Name field
        'name_label' => 'Full Name *',
        'name_placeholder' => 'Your first and last name',
        'name_error_required' => 'Name is required',
        'name_error_min' => 'Must be at least 3 characters',
        
        // Email field
        'email_label' => 'Email *',
        'email_placeholder' => 'Your best email',
        'email_error_required' => 'Email is required',
        'email_error_invalid' => 'Enter a valid email',
        
        // WhatsApp field
        'whatsapp_label' => 'Your WhatsApp *',
        'whatsapp_placeholder' => 'Your WhatsApp number',
        'whatsapp_error_required' => 'WhatsApp is required',
        'whatsapp_error_invalid' => 'Enter a valid WhatsApp number',
        
        // Privacy
        'privacy_text' => 'I have read and accept',
        'privacy_link_text' => 'the Privacy Policy',
        'privacy_error' => 'You must accept the privacy policy',
        
        // Button
        'submit_button' => 'REQUEST QUOTE',
        
        // Messages
        'error_message' => 'There was an error creating the entry.',
    );
}

/**
 * Obtener textos actuales del formulario
 */
function fsf_get_current_form_texts() {
    $defaults = fsf_get_default_form_texts();
    $saved = get_option('fsf_form_texts', array());
    return wp_parse_args($saved, $defaults);
}

/**
 * Página de configuración de textos
 */
function fsf_display_form_texts_page() {
    $defaults = fsf_get_default_form_texts();
    
    // Procesar guardado
    if (isset($_POST['fsf_form_texts_nonce']) && wp_verify_nonce($_POST['fsf_form_texts_nonce'], 'fsf_form_texts_settings')) {
        fsf_save_form_texts($defaults);
        $show_success = true;
    } else {
        $show_success = false;
    }
    
    $texts = fsf_get_current_form_texts();
    
    // Incluir template HTML
    include __DIR__ . '/views/form-texts-page.php';
}

/**
 * Guardar textos del formulario
 */
function fsf_save_form_texts($defaults) {
    $texts = array();
    
    foreach ($defaults as $key => $default_value) {
        if (isset($_POST[$key])) {
            $texts[$key] = sanitize_text_field($_POST[$key]);
        } else {
            $texts[$key] = $default_value;
        }
    }
    
    update_option('fsf_form_texts', $texts);
}
