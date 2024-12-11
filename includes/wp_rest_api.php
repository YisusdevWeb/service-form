<?php

add_action('rest_api_init', function() {
    register_rest_route('funnel-services-form/v1', '/user', array(
        'methods' => 'POST',
        'callback' => 'fsf_create_user_post',
    ));

    register_rest_route('funnel-services-form/v1', '/user/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'fsf_update_user_post',
    ));
});

function fsf_create_user_post(WP_REST_Request $request) {
    $data = $request->get_json_params();

    $post_id = wp_insert_post(array(
        'post_type' => 'user-info',
        'post_title' => 'Información de ' . sanitize_text_field($data['nombre']),
        'post_status' => 'publish',
        'meta_input' => array(
            'nombre' => sanitize_text_field($data['nombre']),
            'email' => sanitize_email($data['email']),
            'whatsapp' => sanitize_text_field($data['whatsapp']),
        ),
    ));

    if (is_wp_error($post_id)) {
        return new WP_Error('error', 'Failed to create post', array('status' => 500));
    }

    return array('post_id' => $post_id);
}

function fsf_update_user_post(WP_REST_Request $request) {
    $post_id = $request['id'];
    $data = $request->get_json_params();

    $post_data = array(
        'ID' => $post_id,
        'meta_input' => array(
            'nombre' => sanitize_text_field($data['nombre']),
            'email' => sanitize_email($data['email']),
            'whatsapp' => sanitize_text_field($data['whatsapp']),
            'services' => maybe_serialize($data['selections']), // Actualizar los servicios seleccionados
        ),
    );

    $updated_post_id = wp_update_post($post_data);

    if (is_wp_error($updated_post_id)) {
        return new WP_Error('error', 'Failed to update post', array('status' => 500));
    }

    return array('post_id' => $updated_post_id);
}
