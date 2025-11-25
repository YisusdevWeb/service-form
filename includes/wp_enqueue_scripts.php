<?php

add_action('wp_enqueue_scripts', 'FSF_enqueue_scripts_and_styles', 100);
function FSF_enqueue_scripts_and_styles()
{
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