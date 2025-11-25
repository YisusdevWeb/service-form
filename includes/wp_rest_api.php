<?php
require_once 'wp_mail_functions.php';

add_action('rest_api_init', function() {
    register_rest_route('funnel-services-form/v1', '/user', array(
        'methods' => 'POST',
        'callback' => 'fsf_create_user_post',
        'permission_callback' => function (WP_REST_Request $request) {
            $nonce = '';
            if (isset($_SERVER['HTTP_X_WP_NONCE'])) {
                $nonce = $_SERVER['HTTP_X_WP_NONCE'];
            } elseif ($request->get_header('x_wp_nonce')) {
                $nonce = $request->get_header('x_wp_nonce');
            }
            // Allow public submissions when no nonce is provided (forms from unauthenticated users)
            if (empty($nonce)) {
                return true;
            }
            return wp_verify_nonce($nonce, 'wp_rest');
        },
    ));

    register_rest_route('funnel-services-form/v1', '/user/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'fsf_update_user_post',
        'permission_callback' => function (WP_REST_Request $request) {
            $nonce = '';
            if (isset($_SERVER['HTTP_X_WP_NONCE'])) {
                $nonce = $_SERVER['HTTP_X_WP_NONCE'];
            } elseif ($request->get_header('x_wp_nonce')) {
                $nonce = $request->get_header('x_wp_nonce');
            }
            // Allow public submissions when no nonce is provided
            if (empty($nonce)) {
                return true;
            }
            return wp_verify_nonce($nonce, 'wp_rest');
        },
    ));
});

function fsf_create_user_post(WP_REST_Request $request) {
    $data = $request->get_json_params();

    // Verify honeypot
    if (!empty($data['website'])) {
        return new WP_Error('honeypot_failed', 'Honeypot verification failed.', array('status' => 400));
    }

    $post_id = wp_insert_post(array(
        'post_type' => 'user-info',
        'post_title' => 'User info - ' . sanitize_text_field($data['nombre']),
        'post_status' => 'publish',
        'meta_input' => array(
            'nombre' => sanitize_text_field($data['nombre']),
            'email' => sanitize_email($data['email']),
            'Telefone' => sanitize_text_field($data['whatsapp']),
        ),
    ));

    if (is_wp_error($post_id)) {
        return new WP_Error('error', 'Failed to create post.', array('status' => 500));
    }
    // Send email to admin as lead when first form is created
    if (!empty($data) && is_email($data['email'])) {
        $subject = get_option('fsf_email_subject', 'New Lead Received');
        fsf_send_email_to_admin($data, $subject);
        // Send email to registered user
        fsf_send_email_to_user($data, $subject);
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
            'Telefone' => sanitize_text_field($data['whatsapp']),
            'services' => maybe_serialize($data['selections']), // Update selected services
        ),
    );

    $updated_post_id = wp_update_post($post_data);

    if (is_wp_error($updated_post_id)) {
        return new WP_Error('error', 'Failed to update post.', array('status' => 500));
    }

    // Customize email subject here
    $subject = get_option('fsf_email_subject', 'New Quote');

    // Send email to admin
    fsf_send_email_to_admin($data, $subject);

    // Send email to user
    fsf_send_email_to_user($data, $subject);

    return array('post_id' => $updated_post_id);
}
