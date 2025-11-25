<?php
/**
 * Sistema de internacionalización para el frontend del plugin
 *
 * Este archivo maneja la carga de cadenas de traducción para el frontend
 * basado en el idioma actual de WordPress
 */

/**
 * Cargar cadenas de traducción para el frontend
 */
function fsf_load_frontend_translations() {
    // Obtener textos por defecto (ahora en inglés)
    $default_texts = array(
        // Textos del formulario (ya gestionados por fsf_get_current_form_texts)
        // Textos del frontend React
        'loading' => __('Loading...', 'funnel-services-form'),
        'service_selection' => __('Select a service', 'funnel-services-form'),
        'email_sent_success' => __('Email sent successfully!', 'funnel-services-form'),
        'redirecting' => __('Redirecting...', 'funnel-services-form'),
        'notice' => __('Notice', 'funnel-services-form'),
        'close' => __('Close', 'funnel-services-form'),
        'service_no_phase' => __('The service "%s" has no phase options available.', 'funnel-services-form'),
    );
    
    // Combinar con textos personalizados del formulario
    $form_texts = function_exists('fsf_get_current_form_texts') ? fsf_get_current_form_texts() : array();
    
    // Combinar todos los textos
    $all_texts = array_merge($default_texts, $form_texts);
    
    return $all_texts;
}

/**
 * Extender la función de enqueue para incluir los textos traducidos
 */
function fsf_enqueue_scripts_and_styles_with_translations() {
    // Código existente de fsf_enqueue_scripts_and_styles
    global $post;

    // Verificar si el contenido del post tiene el shortcode 'Funnel-services-form'
    $has_shortcode = isset($post->post_content) && has_shortcode($post->post_content, 'Funnel-services-form');

    if (isset($post) && $has_shortcode) {
        // Obtener los posts del tipo 'form-servico'
        $posts = get_posts(array(
            'post_type' => 'form-servico',
            'numberposts' => -1 // Obtener todos los posts
        ));

        // Crear un array para almacenar los datos de los posts y sus campos ACF
        $post_data = array();

        foreach ($posts as $post) {
            // Obtener los campos ACF de cada post
            $acf_fields = get_fields($post->ID);
            // Agregar los datos del post y sus campos ACF al array
            $post_data[] = array(
                'ID' => $post->ID,
                'title' => $post->post_title,
                'acf' => $acf_fields, // Incluir todos los campos ACF
            );
        }

        // Obtener la URL de los términos y condiciones desde las opciones de WordPress
         $terms_url = get_option('fsf_terms_url', '');

         // Obtener la URL de los términos y condiciones desde las opciones de WordPress
         $thanks_url = get_option('fsf_thanks_url', '');

        // Datos a pasar a JavaScript
        $debug_enabled = get_option('fsf_debug_enabled', '0');
        $logo_url = get_option('fsf_logo_url', '');
        $logo_max_width = get_option('fsf_logo_max_width', 200);
        $logo_max_height = get_option('fsf_logo_max_height', 80);

        // Obtener textos traducidos para el frontend
        $frontend_texts = fsf_load_frontend_translations();

        $js_data_passed = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'servicios' => $post_data,
            'api_base_url' => array(
                'form_servico' => rest_url('funnel-services-form/v1/servico'),
                'user_info' => rest_url('funnel-services-form/v1/user')
            ),
            'terms_url' => $terms_url,
            'thanks_url' => $thanks_url,
            'nonce' => wp_create_nonce('wp_rest'),
            'debug_enabled' => $debug_enabled,
            'logo_url' => $logo_url,
            'logo_max_width' => $logo_max_width,
            'logo_max_height' => $logo_max_height,
            'form_texts' => $frontend_texts, // Ahora incluye todos los textos
        );

        wp_enqueue_script('FSF-frontend', FSF_PLUGIN_URL . '/dist/app.js', array('jquery'), '1.4.2', true);
        wp_enqueue_style('FSF-frontend-style', FSF_PLUGIN_URL .'dist/styles.css', array(), '1.4.2');
        wp_localize_script('FSF-frontend', 'FSF_data', $js_data_passed);
    }
}

// Reemplazar la función original con la versión mejorada
remove_action('wp_enqueue_scripts', 'FSF_enqueue_scripts_and_styles');
add_action('wp_enqueue_scripts', 'fsf_enqueue_scripts_and_styles_with_translations', 100);