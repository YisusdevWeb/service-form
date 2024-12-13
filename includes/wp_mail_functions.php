<?php

function fsf_send_email_to_admin($data, $subject) {
    $to = get_option('fsf_email_recipient', get_option('admin_email'));
    $email_from = get_option('fsf_email_from', 'web@dappin.pt');
    $subject = get_option('fsf_email_subject', $subject) . ' - ' . $data['email'];

    $created_quotation_date = date_i18n(get_option('date_format') . ' ' . get_option('time_format') . ' T');

    ob_start();
    include dirname(__FILE__) . '/templates/emails/quotation-notification-admin.php';
    $message = ob_get_contents();
    ob_end_clean();

    if (empty($message)) {
        error_log('El cuerpo del mensaje está vacío.');
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
    $subject = 'Tu Cotización - ' . get_option('fsf_email_subject', $subject);

    $created_quotation_date = date_i18n(get_option('date_format') . ' ' . get_option('time_format') . ' T');

    ob_start();
    include dirname(__FILE__) . '/templates/emails/quotation-notification-user.php';
    $message = ob_get_contents();
    ob_end_clean();

    if (empty($message)) {
        error_log('El cuerpo del mensaje para el usuario está vacío.');
        return;
    }

    $headers = array();
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'From: dappin <' . $email_from . '>';

    wp_mail($to, $subject, $message, $headers);
}


   // $headers[] = 'From: dappin <	web@dappin.pt>';
