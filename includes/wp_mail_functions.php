<?php

function fsf_send_email_to_admin($data, $subject) {
    $to = get_option('fsf_email_recipient', get_option('admin_email'));
    $email_from = get_option('fsf_email_from', 'web@dappin.pt');
    $subject = 'Nova cotação'  . ' - ' . $data['email'];

    $created_quotation_date = date_i18n(get_option('date_format') . ' ' . get_option('time_format') . ' T');

    ob_start();
    include dirname(__FILE__) . '/templates/emails/quotation-notification-admin.php';
    $message = ob_get_contents();
    ob_end_clean();

    if (empty($message)) {
        error_log('O corpo da mensagem está vazio.');
        return;
    }

    $headers = array();
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'From: dappin <' . $email_from . '>';

    wp_mail($to, $subject, $message, $headers);
}

function fsf_send_email_to_user($data, $subject) {
    $to = $data['email'];
    $email_from = get_option('fsf_email_from', 'web@dappin.pt');
    $email_subject = get_option('fsf_email_subject', $subject);
    $subject = 'Sua Cotação - ' . $email_subject;
       /* $subject = 'Sua Cotação - ' . get_option('fsf_email_subject', $subject);*/


    $created_quotation_date = date_i18n(get_option('date_format') . ' ' . get_option('time_format') . ' T');

    // Obtener la plantilla del cuerpo del correo desde las opciones
    $email_body_template = get_option('fsf_email_body', '');

    // Reemplazar los placeholders con los datos reales
    $email_body = str_replace(
        ['{nome}', '{email}', '{whatsapp}', '{data_criacao}'],
        [
            esc_html($data['nombre']),
            esc_html($data['email']),
            esc_html($data['whatsapp']),
            esc_html($created_quotation_date),
        ],
        $email_body_template
    );

    ob_start();
    include dirname(__FILE__) . '/templates/emails/quotation-notification-user.php';
    $message = ob_get_clean();

    if (empty($message)) {
        error_log('O corpo da mensagem para o usuário está vazio.');
        return;
    }

    $headers = array();
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'From: dappin <' . $email_from . '>';

    wp_mail($to, $subject, $message, $headers);
}


// $headers[] = 'From: dappin <	web@dappin.pt>';
