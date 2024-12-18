<?php
require_once 'wp_mail_functions.php';

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

    // Verificar honeypot
    if (!empty($data['website'])) {
        return new WP_Error('honeypot_failed', 'A verificação do honeypot falhou.', array('status' => 400));
    }

    $post_id = wp_insert_post(array(
        'post_type' => 'user-info',
        'post_title' => 'Informação de ' . sanitize_text_field($data['nombre']),
        'post_status' => 'publish',
        'meta_input' => array(
            'nombre' => sanitize_text_field($data['nombre']),
            'email' => sanitize_email($data['email']),
            'Telefone' => sanitize_text_field($data['whatsapp']),
        ),
    ));

    if (is_wp_error($post_id)) {
        return new WP_Error('error', 'Falha ao criar o post.', array('status' => 500));
    }

    // Não enviar e-mail na criação do usuário
    // fsf_send_email($data, 'Nova Entrada Criada');
    
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
            'services' => maybe_serialize($data['selections']), // Atualizar os serviços selecionados
        ),
    );

    $updated_post_id = wp_update_post($post_data);

    if (is_wp_error($updated_post_id)) {
        return new WP_Error('error', 'Falha ao atualizar o post.', array('status' => 500));
    }

    // Personalize o assunto do e-mail aqui
    $subject = get_option('fsf_email_subject', 'Cotação Nova');

    // Enviar e-mail para o administrador
    fsf_send_email_to_admin($data, $subject);

    // Enviar e-mail para o usuário
    fsf_send_email_to_user($data, $subject);

    return array('post_id' => $updated_post_id);
}
