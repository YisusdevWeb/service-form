<?php

add_action('wp_enqueue_scripts', 'FSF_enqueue_scripts_and_styles', 100);
function FSF_enqueue_scripts_and_styles() {
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
    
    // Datos a pasar a JavaScript
    $js_data_passed = array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'servicios' => $post_data,
        'api_base_url' => array(
            'form_servico' => rest_url('funnel-services-form/v1/servico'),
            'user_info' => rest_url('funnel-services-form/v1/user')
        )
    );
    
    wp_enqueue_script('FSF-frontend', 'http://localhost:9000/app.js', array('jquery'), '1.0.0', true);
    wp_localize_script('FSF-frontend', 'FSF_data', $js_data_passed);
}

add_action('admin_enqueue_scripts', 'FSF_enqueue_admin_scripts_and_styles');
function FSF_enqueue_admin_scripts_and_styles() {
    wp_enqueue_style('FSF-settings-style', FSF_PLUGIN_URL . '/assets/css/style.css', array(), '1.0.1');
}
