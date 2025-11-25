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
        __('Textos do Formulário', 'funnel-services-form'),
        __('Textos do Formulário', 'funnel-services-form'),
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
            'confirmReset' => __('¿Restaurar textos por defecto?', 'funnel-services-form'),
        )
    ));
}

/**
 * Obtener textos por defecto del formulario
 */
function fsf_get_default_form_texts() {
    return array(
        // Títulos
        'form_title' => 'PEDIDO DE PROPOSTA',
        'form_subtitle' => 'Preenche os campos abaixo para pedires a tua proposta!',
        
        // Campo Nombre
        'name_label' => 'Nome e Apelido *',
        'name_placeholder' => 'O teu Primeiro e último nome',
        'name_error_required' => 'Nome é obrigatório',
        'name_error_min' => 'Deve ter pelo menos 3 caracteres',
        
        // Campo Email
        'email_label' => 'E-mail *',
        'email_placeholder' => 'O teu melhor e-mail',
        'email_error_required' => 'Email é obrigatório',
        'email_error_invalid' => 'Insere um email válido',
        
        // Campo WhatsApp
        'whatsapp_label' => 'O teu WhatsApp *',
        'whatsapp_placeholder' => 'O teu WhatsApp',
        'whatsapp_error_required' => 'Teu WhatsApp é obrigatório',
        'whatsapp_error_invalid' => 'Insere teu WhatsApp válido',
        
        // Privacidad
        'privacy_text' => 'Li e aceito',
        'privacy_link_text' => 'a Política de Privacidade',
        'privacy_error' => 'É necessário aceitar as políticas de privacidade',
        
        // Botón
        'submit_button' => 'SOLICITAR PROPOSTA',
        
        // Mensajes
        'error_message' => 'Houve um erro ao criar a entrada.',
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
