<?php

add_action('wp_enqueue_scripts', 'FSF_enqueue_scripts_and_styles', 100);
function FSF_enqueue_scripts_and_styles()
{
    global $post;

    // Check if post content has 'Funnel-services-form' shortcode
    $has_shortcode = isset($post->post_content) && has_shortcode($post->post_content, 'Funnel-services-form');

    if (isset($post) && $has_shortcode) {
        // Get posts of type 'form-servico'
        $posts = get_posts(array(
            'post_type' => 'form-servico',
            'numberposts' => -1 // Get all posts
        ));

        // Crear un array para almacenar los datos de los posts y sus campos ACF
        $post_data = array();

        foreach ($posts as $post) {
            // Get ACF fields for each post
            $acf_fields = get_fields($post->ID);
            // Add post data and ACF fields to array
            $post_data[] = array(
                'ID' => $post->ID,
                'title' => $post->post_title,
                'acf' => $acf_fields, // Incluir todos los campos ACF
            );
        }


        // Obtener la URL de los términos y condiciones desde las opciones de WordPress
         $terms_url = get_option('fsf_terms_url', '');

         // Get terms and conditions URL from WordPress options
         $thanks_url = get_option('fsf_thanks_url', '');

        // Datos a pasar a JavaScript
        $debug_enabled = get_option('fsf_debug_enabled', '0');
        $logo_url = get_option('fsf_logo_url', '');
        $logo_max_width = get_option('fsf_logo_max_width', 200);
        $logo_max_height = get_option('fsf_logo_max_height', 80);
        
        // Get custom form texts
        $form_texts = function_exists('fsf_get_current_form_texts') ? fsf_get_current_form_texts() : array();
        
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
            'form_texts' => $form_texts,
        );
      // 
    wp_enqueue_script( 'FSF-frontend', FSF_PLUGIN_URL . '/dist/app.js', array('jquery'), '1.3.7', true );
    // wp_enqueue_script('FSF-frontend', 'http://localhost:9000/app.js', array('jquery'), '1.0.0', true);
    wp_enqueue_style('FSF-frontend-style', FSF_PLUGIN_URL .'dist/styles.css', array(), '1.3.7');
        wp_localize_script('FSF-frontend', 'FSF_data', $js_data_passed);
    }
}

add_action('admin_enqueue_scripts', 'FSF_enqueue_admin_scripts_and_styles');
function FSF_enqueue_admin_scripts_and_styles()
{
    wp_enqueue_style('FSF-settings-style', FSF_PLUGIN_URL . '/assets/css/style.css', array(), '1.0.1');
}

/**
 * Encolar CSS de compatibilidad personalizada para temas conflictivos
 * Los usuarios pueden agregar sus propias reglas CSS en custom-theme-override.css
 */
add_action('wp_enqueue_scripts', 'FSF_enqueue_theme_compat', 999);
function FSF_enqueue_theme_compat()
{
    // SIEMPRE cargar el archivo de sobrescritura personalizada
    // Este archivo permite a los usuarios agregar sus propias reglas CSS
    // para solucionar conflictos específicos con su tema
    wp_enqueue_style(
        'fsf-custom-theme-override',
        FSF_PLUGIN_URL . 'includes/compat/custom-theme-override.css',
        array(),
        '1.0.0'
    );
}